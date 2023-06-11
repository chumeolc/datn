<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Movie_Genre; 
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\Info;

use Carbon\Carbon;
use Storage;
use File;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Movie::with('category','movie_genre','country','genre')->withCount('episode')->orderBy('id', 'DESC')->get(); 
        //count so tap
        $category = Category::pluck('title', 'id');
        $country = Country::pluck('title', 'id');
        //json
        $path = public_path()."/json/";
            if (!is_dir($path)) { 
                mkdir($path, 0777, true); 
            }
       
        File::put($path.'movies.json',json_encode($list));
        return view('admin.movie.index',compact('list', 'category','country'));
    }
    //cập nhật năm phim
    public function update_year(Request $request){
         $data = $request->all();
         $movie = Movie::find($data['id_phim']);
         $movie->year = $data['year'];
         $movie->save();
    }
    //cập nhật mùa phim
    public function update_season(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }
    //cập nhật topview
    public function update_topview(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }
    //cập nhật filter_topview
    public function filter_topview(Request $request){
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('ngaycapnhat','DESC')->take(20)->get();
        $output ='';
        foreach($movie as $key => $mov){
            
            if($mov->resolution==0){
                $text = 'HD';
            }elseif($mov->resolution==1){
                $text = 'SD';
            }elseif($mov->resolution==2){
                $text = 'HDCam';
            }elseif($mov->resolution==3){
                $text = 'Cam';
            }else{
                $text= 'Trailer';   
            }
            $output.= ' <div class="item">
                                <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                                <div class="item-link">
                                    <img src="'.url('uploads/movie/'.$mov->image).'" 
                                    class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                    <span class="is_trailer">
                                        '.$text.'
                                    </span>
                                </div>
                                <p class="title">'.$mov->title.'</p>
                            </a>
                            <div class="viewsCount" style="color: #9d9d9d;">'.$mov->count_views.' lượt xem</div>
                            <div style="float: left;">
                                <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                <span style="width: 0%"></span>
                                </span>
                            </div>
                        </div>';
        }
        echo $output;
    }
    public function filter_default(Request $request){
        
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('ngaycapnhat','DESC')->take(20)->get();
        $output = '';
        foreach($movie as $key => $mov){
            if($mov->resolution==0){
                $text = 'HD';
            }elseif($mov->resolution==1){
                $text = 'SD';
            }elseif($mov->resolution==2){
                $text = 'HDCam';
            }elseif($mov->resolution==3){
                $text = 'Cam';
            }else{
                $text= 'Trailer';   
            }
        $output.=  '<div class="item">
                            <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                            <div class="item-link">
                                <img src="'.url('uploads/movie/'.$mov->image).'" 
                                class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                                <span class="is_trailer">
                                    '.$text.'
                                </span>
                            </div>
                            <p class="title">'.$mov->title.'</p>
                        </a>
                        <div class="viewsCount" style="color: #9d9d9d;">'.$mov->count_views.' lượt xem</div>
                        <div style="float:left">
                            <ul class="list-inline rating"  title="Average Rating" >
                            ';
                                        for($count=1; $count<=5; $count++){
                                            $output.=' <li title="star_rating" style="font-size:20px;color:#ffcc00;padding:0">&#9733;
                                            </li>';
                                         }
                                         $output.='<ul class="list-inline rating"  title="Average Rating" >
                           
                         </div>  
                    </div>';
        }
    echo $output;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $list_genre = Genre::all();
        $country = Country::pluck('title', 'id');

        return view('admin.movie.form',compact('genre','country','category','list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // $data = $request->validate(
        //     [
        //         'title' => 'required|unique:movies|max:255',
        //         'name_eng' => 'required|unique:movies|max:255',
        //         'description' => 'required|max:500',
        //         'image' => 'required',
        //         'tags' => 'required',
        //         'genre' => 'required',
        //     ],
        //     [
        //         'title.unique' => 'Tên phim đã có, bạn hãy điền tên khác.',
        //         'slug.unique' => 'Slug phim đã có, bạn hãy điền tên khác.',
        //         'name_eng.unique' => 'Tên tiếng anh phim đã có, bạn hãy điền tên khác.',
        //         'title.required' => 'Tên phim phải có.',
        //         'slug.required' => 'Slug phim phải có.',
        //         'name_eng.required' => 'Tên tiếng anh phim phải có.',
        //         'description.required' => 'Mô tả phim phải có.',
        //         'genre.required' => 'Thể loại phim phải có.',
        //         'image.required' => 'Hình ảnh phim phải có.',
        //         'tags.required' => 'Từ khoá phim phải có.',

                
        //     ]
        //     );
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->name_eng = $data['name_eng'];
        $movie->resolution = $data['resolution'];
        $movie->phude = $data['phude'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->trailer = $data['trailer'];
        $movie->sotap = $data['sotap'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->count_views = rand(100,99999);
        $movie->dienvien = $data['dienvien'];

      
       
        foreach($data['genre'] as $key => $gen){
            $movie->genre_id = $gen[0];
        }
        $get_image = $request->file('image');
        // $movie->genre_id = $data['genre_id'];
        // Thêm hình ảnh, và chuyển hình ảnh vào file movie
        if($get_image){

            $get_name_image = $get_image->getClientOriginalName(); //hinhanh.jpg
            $name_image = current(explode('.', $get_name_image)); //[0] => hinhanh , [1] => jpg
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension(); // hinhanh 3234. jpg
            $get_image->move('uploads/movie/', $new_image);
            $movie->image = $new_image;
        }
        $movie->save();
        //them nhieu the loai
        $movie->movie_genre()->attach($data['genre']);
        toastr()->success('Thành công', 'Thêm phim thành công.');
        return redirect()->route('movie.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::pluck('title', 'id');
        $genre = Genre::pluck('title', 'id');
        $list_genre = Genre::all();
        $country = Country::pluck('title', 'id');

        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admin.movie.form',compact('genre','country','category','movie','list_genre','movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        {
            $data = $request->all();
            // return response()->json($data['genre']);
            $movie = Movie::find($id);
            $movie->title = $data['title'];
            $movie->tags = $data['tags'];
            $movie->thoiluong = $data['thoiluong'];
            $movie->slug = $data['slug'];
            $movie->description = $data['description'];
            $movie->status = $data['status'];
            $movie->category_id = $data['category_id'];
            // $movie->genre_id = $data['genre_id'];
            $movie->country_id = $data['country_id'];
            $movie->phim_hot = $data['phim_hot'];
            $movie->name_eng = $data['name_eng'];
            $movie->resolution = $data['resolution'];
            $movie->phude = $data['phude'];
            $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->trailer = $data['trailer'];
            $movie->sotap = $data['sotap'];
            $movie->thuocphim = $data['thuocphim'];
            $movie->dienvien = $data['dienvien'];
            // $movie->count_views = rand(100,99999);
            // them hinh anh
            $get_image = $request->file('image');
            foreach($data['genre'] as $key => $gen){
                $movie->genre_id = $gen[0];
            }
            if($get_image){
                if(file_exists('uploads/movie/'.$movie->image)){
                    unlink('uploads/movie/'.$movie->image);
                }else{
                $get_name_image = $get_image->getClientOriginalName(); //hinhanh.jpg
                $name_image = current(explode('.', $get_name_image)); //[0] => hinhanh , [1] => jpg
                $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension(); // hinhanh 3234. jpg
                $get_image->move('uploads/movie/', $new_image);
                $movie->image = $new_image;
                }
            }
            $movie->save();
            $movie->movie_genre()->sync($data['genre']);
            toastr()->success('Thành công', 'Sửa phim thành công.');
            return redirect()->route('movie.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        // xoa anh
        if(file_exists('uploads/movie/'.$movie->image)){
            unlink('uploads/movie/'.$movie->image);
        }
        // $movie->movie_genre()->sync($data['genre']);
        //xoa the loai
        // $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        // $many_genre = [];
        // foreach($movie_genre as $key => $movi){
        //     $many_genre[] = $movi->movie_id;
            
        // }
        // return response()->json($many_genre);
        
        Movie_Genre::whereIn('movie_id',[$movie->id])->delete(); 
        //xoa tap phim
        Episode::whereIn('movie_id',[$movie->id])->delete(); 
        $movie->delete();
        toastr()->success('Thành công', 'Xoá phim thành công.');
        return redirect()->back();
    }
    public function category_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> category_id = $data['category_id'];
        $movie->save();
    }
    public function country_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> country_id = $data['country_id'];
        $movie->save();
    }
    public function trangthai_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> status = $data['trangthai_val'];
        $movie->save();
    }
    public function phude_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> phude = $data['phude_val'];
        $movie->save();
    }
    public function thuocphim_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> thuocphim = $data['thuocphim_val'];
        $movie->save();
    }
    public function phimhot_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> phim_hot = $data['phimhot_val'];
        $movie->save();
    }
    public function resolution_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> resolution = $data['resolution_val'];
        $movie->save();
    }
    public function update_image_movie_ajax(Request $request){
        $get_image = $request->file('file');
        $movie_id = $request->movie_id;
        if($get_image){
            // xoá ảnh cũ
            $movie = Movie::find($movie_id);
            unlink('uploads/movie/'.$movie->image);
            // thêm ảnh mới
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image -> move('uploads/movie/', $new_image);
            $movie->image = $new_image;
            $movie ->save();
        }
    }
}
