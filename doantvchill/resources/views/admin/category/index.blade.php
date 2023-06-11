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
        {!! Form::open(['route'=>'category.store', 'method' =>'POST']) !!}
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thêm danh mục phim</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
            <div class="card">
                <div class="card-header">Quản lý danh mục</div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body" >
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        {!! Form::open(['route'=>'category.store', 'method' =>'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($category) ? $category->title: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($category) ? $category->slug: '', ['class'=>'form-control','id'=>'convert_slug','readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($category) ? $category->description: '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Active', []) !!}
                            {!! Form::select('status',['1' =>'Hiển thị','0'=>'Không'], isset($category) ? $category->status: '' , ['class'=>'form-control']) !!}
                        </div>
                        

                    {{-- @if(!isset($category))
                            {!! Form::submit('Thêm danh mục', ['style'=>'margin-top:10px','class'=>'btn btn-success', 'onclick'=>'send()']) !!}
                    @else 
                            {!! Form::submit('Cập nhật ', ['style'=>'margin-top:10px','class'=>'btn btn-success']) !!}
                    @endif --}}
                    
                   
                </div>
            </div>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          {!! Form::submit('Thêm danh mục', ['style'=>'margin-top:10px','class'=>'btn btn-success', 'onclick'=>'send()']) !!}
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    </div>
<table class="table table-striped table-hover table-sm" id="tablephim">
    <thead>
    <tr>
        <th scope="col">STT</th>
        <th scope="col">Tên danh mục</th>
        <th scope="col">Mô tả danh mục</th>
        <th scope="col">Đường dẫn</th>
        <th scope="col">Trạng thái</th>
        <th scope="col">Quản lý</th>
    </tr>
    </thead>
    <tbody class="order_position ui-sortable">
         
        @foreach($list as $key => $cate)
    
    <tr id="{{$cate->id}}" class="ui-sortable-handle ui-sortable-helper" style="">
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
                'route' =>['category.destroy', $cate->id],
                'onsubmit' => 'return confirm("Bạn có muốn xoá không?")'
            ]) !!}
            {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
            {!! Form::close() !!}
            <a href="{{route('category.edit',$cate->id)}}" class="btn btn-warning">Sửa</a>
        </td>
    </tr>
        @endforeach
    </tbody>
</table>
@endsection