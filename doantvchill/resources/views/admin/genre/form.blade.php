@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý thể loại</div>

                <div class="card-body" style="font-size: large">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!isset($genre))
                        {!! Form::open(['route'=>'genre.store', 'method' =>'POST']) !!}
                    @else
                        {!! Form::open(['route'=>['genre.update', $genre->id], 'method' =>'PUT']) !!}
                    @endif

                        <div class="form-group">
                            {!! Form::label('title', 'Tên thể loại', []) !!}
                            {!! Form::text('title', isset($genre) ? $genre->title: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Đường dẫn', []) !!}
                            {!! Form::text('slug', isset($genre) ? $genre->slug: '', ['class'=>'form-control','id'=>'convert_slug','readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả thể loại', []) !!}
                            {!! Form::textarea('description', isset($genre) ? $genre->description: '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Trạng thái', []) !!}
                            {!! Form::select('status',['1' =>'Hiển thị','0'=>'Không'], isset($genre) ? $genre->status: '' , ['class'=>'form-control']) !!}
                        </div>

                    @if(!isset($genre))
                            {!! Form::submit('Thêm thể loại', ['style'=>'margin-top:10px','class'=>'btn btn-success', 'onclick'=>'send()']) !!}
                    @else
                            {!! Form::submit('Cập nhật', ['style'=>'margin-top:10px','class'=>'btn btn-success']) !!}
                    @endif
                    
                    {!! Form::close() !!}
                </div>
            </div>
               
        </div>
    </div>
</div>
@endsection
