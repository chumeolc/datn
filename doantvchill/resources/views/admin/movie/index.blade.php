@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12" style="overflow-y: auto;" >
            <a href="{{route('movie.create')}}" class="btn btn-primary">Thêm phim</a>
                <table class="table table-striped table-hover table-sm" id="tablephim" > 
                    <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên phim</th>
                        <th scope="col">Tập phim</th>
                        <th scope="col">Từ khoá phim</th>
                        <th scope="col">Tên diễn viên</th>
                        <th scope="col">Thời lượng phim</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Phim hot</th>
                        <th scope="col">Định dạng</th>
                        <th scope="col">Phụ đề</th>
                        {{-- <th scope="col">Description</th> --}}
                        <th scope="col">Đường dẫn</th>
                        <th scope="col">Trạng thái</th>
                      
                        <th scope="col">Thuộc phim</th>
                        <th scope="col">Số tập</th>

                        <th scope="col">Danh mục</th>
                        <th scope="col">Thể loại</th>
                        <th scope="col">Quốc gia</th>
                        
                        <th scope="col">Season</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Ngày cập nhật</th>
                        <th scope="col">Năm phim</th>
                        <th scope="col">Top view</th>
                        <th scope="col">Quản lý</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $key => $cate)
                    <tr>
                        <th scope="row">{{$key}}</th>
                         {{-- Tên phim --}}
                        <td>{{$cate->title}}</td>
                         {{-- Thêm tập phim --}}
                        <td>
                            <a href="{{route('add-episode',[$cate->id])}}" class="btn btn-danger btn-sm">Thêm tập phim</a>
                            @foreach($cate->episode as $key =>$epis)
                                <span class="badge rounded-pill bg-success"><a href="" style="color: aliceblue">{{$epis->episode}}</a></span>
                            @endforeach

                        </td>
                        {{-- Từ khoá phim --}}
                        <td>
                            @if(strlen($cate->tags)>150)
                                @php
                                    $tags = substr($cate->tags, 0, 100);
                                    echo $tags.'...';
                                @endphp
                            @else
                             {{$cate->tags}}
                            @endif
                            {{-- {{$cate->tags}} --}}
                        </td>
                        {{-- Tên diễn viên --}}
                        <td>
                            {{$cate->dienvien}}
                        </td>
                         {{-- Thời lượng phim --}}
                        <td>{{$cate->thoiluong}}</td>
                         {{-- Hình ảnh phim --}}
                        <td>
                            <img width="150px" src="{{asset('uploads/movie/'.$cate->image)}}">
                            <input type="file" id="file-{{$cate->id}}" data-movie_id="{{$cate->id}}" 
                            name="image_choose" class="form-control-file file_image" style="width:100%" accept="image/*">
                            <span id="error_gallery"></span>
                        </td>
                         {{-- Phim hot --}}
                        <td>
                            {{-- @if($cate->phim_hot==0)
                                Không
                            @else
                                Có
                            @endif --}}
                            <select class="phimhot_choose" id="{{$cate->id}}">
                                @if($cate->phim_hot==0)
                                    <option value="1">Hot</option>
                                    <option selected value="0">Không</option>
                                @else 
                                    <option selected value="1">Hot</option>
                                    <option value="0">Không</option>
                                @endif
                            </select>
                           
                        </td>
                         {{-- Định dạng --}}
                        <td>
                            {{-- @if($cate->resolution==0)
                                HD
                            @elseif($cate->resolution==1)
                                SD 
                            @elseif($cate->resolution==2)
                                HDCam
                            @elseif($cate->resolution==3)
                                Cam
                            @else
                                Trailer
                            @endif --}}
                            @php
                                $options = array('0'=>"HD",'1'=>'SD','2'=>'HDCam','3'=>'Cam','4'=>'Trailer')
                            @endphp
                             <select id="{{$cate->id}}" class ="resolution_choose">
                            @foreach($options as $key => $resolution)
                                <option {{$cate->resolution==$key ? 'selected' : ''}} value="{{$key}}">{{$resolution}}</option>
                            @endforeach
                        </select>
                        </td>
                         {{-- Phụ đề --}}
                        <td>
                            {{-- @if($cate->phude==0)
                                Vietsub
                            @else
                                Thuyết minh
                            @endif --}}
                            <select id="{{$cate->id}}" class ="phude_choose">
                                @if($cate->phude==0){
                                    <option value="1">Thuyết minh</option>
                                    <option selected value="0">Vietsub</option>
                                @else
                                    <option selected value="1">Thuyết minh</option>
                                    <option value="0">Vietsub</option>
                                }
                                @endif
                            </select>
                        </td>
                        {{-- <td>{{$cate->description}}</td> --}}
                         {{-- Đường dẫn --}}
                        <td>{{$cate->slug}}</td>
                         {{-- Trạng thái --}}
                        <td>
                            {{-- @if($cate->status)
                                Hiển thị
                            @else
                                Không hiển thị
                            @endif --}}
                            <select id="{{$cate->id}}" class ="trangthai_choose">
                                @if($cate->status==0){
                                    <option value="1">Hiển thị</option>
                                    <option selected value="0">Ẩn</option>
                                @else
                                    <option selected value="1">Hiển thị</option>
                                    <option value="0">Ẩn</option>
                                }
                                @endif
                            </select>
                        </td>
                       {{-- Thuộc phim --}}
                        <td>
                            {{-- @if($cate->thuocphim=='phimle')
                                Phim lẻ
                            @else
                                Phim bộ
                            @endif --}}
                            <select id="{{$cate->id}}" class ="thuocphim_choose">
                                @if($cate->thuocphim=='phimle'){
                                    <option value="phimle">Phim lẻ</option>
                                    <option selected value="phimbo">Phim bộ</option>
                                @else
                                    <option selected value="phimle">Phim lẻ</option>
                                    <option value="phimbo">Phim bộ</option>
                                }
                                @endif
                            </select>
                        </td>
                         {{-- Số tập --}}
                        <td>{{$cate->episode_count}}/{{$cate->sotap}} tập</td>
                         {{-- Danh mục --}}
                            <td>
                                {{-- {{$cate->category->title}} --}}
                                {!! Form::select('category_id', $category , isset($cate) ? $cate->category->id: '' , ['class'=>'category_choose', 'id'=>$cate->id]) !!}
                            
                            </td>
                         {{-- Thể loại --}}
                        <td>
                            @foreach($cate -> movie_genre as $gen)
                           
                            <span class="badge bg-dark">{{$gen->title}}</span>
  
                            @endforeach
                        </td>
                         {{-- Quốc gia --}}
                        <td>
                            {{-- {{$cate->country->title}} --}}
                            {!! Form::select('country_id', $country , isset($cate) ? $cate->country->id: '' , ['class'=>'country_choose', 'id'=>$cate->id]) !!}
                        </td>
                         {{-- Mùa phim --}}
                        <td>
                            {!! Form::selectYear('season', 0, 20, isset($cate->season) ? $cate->season : '' ,['class'=>'select-season','id'=>$cate->id]) !!}
                        </td>
                        {{-- <td>
                            <form method="POST">
                                @csrf
                                {!! Form::selectRange('season', 1, 20, '' ,['class'=>'select-season','id'=>$cate->id]) !!}
                            </form>

                        </td> --}}
                         {{-- Ngày tạo --}}
                        <td>{{$cate->ngaytao}}</td>
                         {{-- Ngày cập nhật --}}
                        <td>{{$cate->ngaycapnhat}}</td>
                        {{-- Năm --}}
                        <td>
                            {!! Form::selectYear('year',1995, 2023, isset($cate->year) ? $cate->year : '',['class'=>'select-year','id'=>$cate->id, 'placeholder'=>'Năm phim']) !!}
                        </td>
                        {{-- <td>
                            <form method="POST">
                          
                                @csrf
                                {!! Form::selectYear('year',1995, 2023, '' ,['class'=>'select-year','id'=>$cate->id]) !!}
                            
                            </form>
                        </td> --}}
                         {{-- Top view --}}
                        <td>
                            {!! Form::select('topview',['0' =>'Ngày','1'=>'Tuần','2'=>'Tháng', NULL =>'Không có'], isset($cate->topview) ? $cate->topview: '' , ['class'=>'select-topview','id'=>$cate->id]) !!}
                        </td>
                        {{-- <td>
                           <form method="POST">
                                @csrf
                                <select class="topview" name="topview" >

                                    @if($cate->topview==1)
                                    <option value="0" id="{{$cate->id}}">Ngày</option>
                                    <option value="1" selected id="{{$cate->id}}">Tuần</option>
                                    <option value="2" id="{{$cate->id}}">Tháng</option>
                                    @elseif($cate->topview ==2)
                                    <option value="0" id="{{$cate->id}}">Ngày</option>
                                    <option value="1" id="{{$cate->id}}">Tuần</option>
                                    <option value="2" selected id="{{$cate->id}}">Tháng</option>
                                    @else
                                    <option value="0" selected id="{{$cate->id}}">Ngày</option>
                                    <option value="1" id="{{$cate->id}}">Tuần</option>
                                    <option value="2" id="{{$cate->id}}">Tháng</option>  
                                    @endif
                                </select>
                           </form>
                        </td> --}}
                         {{-- Nút xoá và sửa --}}
                        <td>
                            {!! Form::open([
                                'method'=>'DELETE',
                                'route' =>['movie.destroy', $cate->id],
                                'onsubmit' => 'return confirm("Bạn có muốn xoá không?")'
                            ]) !!}
                            {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('movie.edit',$cate->id)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
