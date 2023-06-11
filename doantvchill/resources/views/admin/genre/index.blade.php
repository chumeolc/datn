@extends('layouts.app')

@section('content')

<!-- Button to Open the Modal -->
<div class="col-md-12" style="text-align: center">
    <button type="button" class="btn btn-primary mb-4 px-5" data-bs-toggle="modal" data-bs-target="#category">
        Thêm nhanh
    </button>
</div>
   
  
  <!-- The Modal -->
    <div class="modal" id="category">
    <div class="modal-dialog">
        {!! Form::open(['route'=>'genre.store', 'method' =>'POST']) !!}
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thêm thể loại phim</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
            <div class="card">
                <div class="card-header">Quản lý thể loại</div>

                <div class="card-body" style="font-size: large">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
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

                    {{-- @if(!isset($genre))
                            {!! Form::submit('Thêm thể loại', ['style'=>'margin-top:10px','class'=>'btn btn-success', 'onclick'=>'send()']) !!}
                    @else
                            {!! Form::submit('Cập nhật', ['style'=>'margin-top:10px','class'=>'btn btn-success']) !!}
                    @endif --}}
                    
                    {{-- {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          {!! Form::submit('Thêm thể loại', ['style'=>'margin-top:10px','class'=>'btn btn-success', 'onclick'=>'send()']) !!}
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    </div>

<table class="table table-striped table-hover table-sm"  id="tablephim">
    <thead>
    <tr>
        <th scope="col">STT</th>
        <th scope="col">Tên thể loại</th>
        <th scope="col">Mô tả thể loại</th>
        <th scope="col">Đường dẫn</th>
        <th scope="col">Trạng thái</th>
        <th scope="col">Quản lý</th>
    </tr>
    </thead>
    <tbody>
        @foreach($list as $key => $cate)
    <tr>
        <th scope="row">{{$key}}</th>
        <td>{{$cate->title}}</td>
        <td>{{$cate->description}}</td>
        <td>{{$cate->slug}}</td>
        <td>
            @if($cate->status)
                Hiển thị
            @else
                Không hiển thị
            @endif

        </td>
        <td>
            {!! Form::open([
                'method'=>'DELETE',
                'route' =>['genre.destroy', $cate->id],
                'onsubmit' => 'return confirm("Bạn có muốn xoá không?")'
            ]) !!}
            {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
            {!! Form::close() !!}
            <a href="{{route('genre.edit',$cate->id)}}" class="btn btn-warning">Sửa</a>
        </td>
    </tr>
        @endforeach
    </tbody>
</table>
@endsection