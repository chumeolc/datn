@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý quốc gia</div>

                <div class="card-body"  style="font-size: large">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!isset($country))
                        {!! Form::open(['route'=>'country.store', 'method' =>'POST']) !!}
                    @else
                        {!! Form::open(['route'=>['country.update', $country->id], 'method' =>'PUT']) !!}
                    @endif

                        <div class="form-group">
                            {!! Form::label('title', 'Tên quốc gia', []) !!}
                            {!! Form::text('title', isset($country) ? $country->title: '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Đường dẫn', []) !!}
                            {!! Form::text('slug', isset($country) ? $country->slug: '', ['class'=>'form-control','id'=>'convert_slug','readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Mô tả quốc gia', []) !!}
                            {!! Form::textarea('description', isset($country) ? $country->description: '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu','id'=>'description']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Active', 'Trạng thái', []) !!}
                            {!! Form::select('status',['1' =>'Hiển thị','0'=>'Không'], isset($country) ? $country->status: '' , ['class'=>'form-control']) !!}
                        </div>

                    @if(!isset($country))
                            {!! Form::submit('Thêm quốc gia', ['style'=>'margin-top:10px','class'=>'btn btn-success', 'onclick'=>'send()']) !!}
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
