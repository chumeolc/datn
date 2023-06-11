@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý thông tin website</div>
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

                    {!! Form::open(['route'=>['info.update', $info->id], 'method' =>'PUT','enctype'=>'multipart/form-data']) !!}               

                        <div class="form-group">
                            {!! Form::label('title', 'Tiêu đề website', []) !!}
                            {!! Form::text('title', isset($info) ? $info->title: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả website', []) !!}
                            {!! Form::textarea('description', isset($info) ? $info->description: '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('image', 'Hình ảnh logo', []) !!}
                            {!! Form::file('image',['class'=>'form-control-file']) !!} 
                            @if(isset($info))
                            <img width="20%" src="{{asset('uploads/logo/'.$info->logo)}}">
                            @endif
                        </div>
                        
                            {!! Form::submit('Cập nhật thông tin web ', ['style'=>'margin-top:10px','class'=>'btn btn-success']) !!}
                    
                    {!! Form::close() !!}
                </div>
            </div>
               
        </div>
    </div>
    {{-- <table class="table" id="tablephim">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Slug</th>
            <th scope="col">Active/Inactive</th>
            <th scope="col">Manage</th>
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
                    'route' =>['info.destroy', $cate->id],
                    'onsubmit' => 'return confirm("Bạn có muốn xoá không?")'
                ]) !!}
                {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
                <a href="{{route('info.edit',$cate->id)}}" class="btn btn-warning">Sửa</a>
            </td>
        </tr>
            @endforeach
        </tbody>
    </table> --}}
</div>
@endsection