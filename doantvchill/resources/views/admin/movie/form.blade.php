@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <a href="{{route('movie.index')}}" class="btn btn-primary">Liệt kê phim</a>
                <div class="card-header">Quản lý phim</div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body"  style="font-size: large">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!isset($movie))
                        {!! Form::open(['route'=>'movie.store', 'method' =>'POST', 'enctype'=> 'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route'=>['movie.update', $movie->id], 'method' =>'PUT','enctype'=> 'multipart/form-data']) !!}
                    @endif

                        <div class="form-group">
                            {!! Form::label('title', 'Tên phim', []) !!}
                            {!! Form::text('title', isset($movie) ? $movie->title: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name_eng', 'Tên tiếng anh', []) !!}
                            {!! Form::text('name_eng', isset($movie) ? $movie->name_eng: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('thoiluong', 'Thời lượng', []) !!}
                            {!! Form::text('thoiluong', isset($movie) ? $movie->thoiluong: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('sotap', 'Số tập', []) !!}
                            {!! Form::text('sotap', isset($movie) ? $movie->sotap: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Đường dẫn', []) !!}
                            {!! Form::text('slug', isset($movie) ? $movie->slug: '', ['class'=>'form-control','id'=>'convert_slug','readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('trailer', 'Trailer', []) !!}
                            {!! Form::text('trailer', isset($movie) ? $movie->trailer: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả', []) !!}
                            {!! Form::textarea('description', isset($movie) ? $movie->description: '',
                             ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', 'Từ khoá phim', []) !!}
                            {!! Form::textarea('tags', isset($movie) ? $movie->tags: '',
                             ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('status', 'Trạng thái', []) !!}
                            {!! Form::select('status',['1' =>'Hiển thị','0'=>'Không'], isset($movie) ? $movie->status: '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('resolution', 'Định dạng', []) !!}
                            {!! Form::select('resolution',['0' =>'HD','1'=>'SD','2'=>'HDCam','3'=>'Cam','4'=>'Trailer'], isset($movie) ? $movie->resolution: '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('phude', 'Phụ đề', []) !!}
                            {!! Form::select('phude',['0' =>'Vietsub','1'=>'Thuyết minh'], isset($movie) ? $movie->phude: '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category_id', 'Danh mục', []) !!}
                            {!! Form::select('category_id', $category , isset($movie) ? $movie->category_id: '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('thuocphim', 'Thuộc phim', []) !!}
                            {!! Form::select('thuocphim', ['phimle' =>'Phim lẻ','phimbo'=>'Phim bộ'] , isset($movie) ? $movie->thuocphim: '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('country_id', 'Quốc gia', []) !!}
                            {!! Form::select('country_id', $country , isset($movie) ? $movie->country_id: '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Genre', 'Thể loại', []) !!}<br>
                            {{-- {!! Form::select('genre_id', $genre , isset($movie) ? $movie->genre_id: '' , ['class'=>'form-control']) !!} --}}
                            @foreach($list_genre as $key => $gen)
                                @if(isset($movie))
                                {!!Form::checkbox('genre[]',$gen->id, isset($movie_genre) && $movie_genre->contains($gen->id) ? true : false) !!}
                                @else
                                {!!Form::checkbox('genre[]',$gen->id, '') !!}
                                @endif
                                {!!Form::label('genre',$gen->title) !!}
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::label('dienvien', 'Tên diễn viên', []) !!}
                            {!! Form::text('dienvien', isset($movie) ? $movie->dienvien: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('phim_hot', 'Phim hot', []) !!}
                            {!! Form::select('phim_hot', ['1' =>'Có','0'=>'Không'], isset($movie) ? $movie->phim_hot: '' , ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('image', 'Hình ảnh', []) !!}
                            {!! Form::file('image',['class'=>'form-control-file']) !!} 
                            @if(isset($movie))
                            <img width="20%" src="{{asset('uploads/movie/'.$movie->image)}}">
                            @endif
                        </div>

                    @if(!isset($movie))
                            {!! Form::submit('Thêm dữ liệu', ['style'=>'margin-top:10px','class'=>'btn btn-success', 'onclick'=>'send()']) !!}
                    @else
                            {!! Form::submit('Cập nhật ', ['style'=>'margin-top:10px','class'=>'btn btn-success']) !!}
                    @endif
                    
                    {!! Form::close() !!}
                </div>
            </div>
              
            
        </div>
    </div>
</div>
@endsection
