<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $info = Info::find(1);
        return view('admin.info.form', compact('info'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        //
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
        $data = $request->validate(
            [
                'title' => 'required|max:255',
                'description' => 'required|max:255',
                // 'image' => 'required|image|mines:jpg,png,jpeg,gif,svg|max:2048
                // |dismensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],
            [
                'title.required' => 'Tên phải có.',
                'description.required' => 'Mô tả phải có.',
                'image.required' => 'Hình ảnh  phải có.',

            ]
            );
            $info = Info::find($id);
            $info->title = $data['title'];
            $info->description = $data['description'];
            $get_image = $request->file('image');
    
            if($get_image){
    
                $get_name_image = $get_image->getClientOriginalName(); //hinhanh.jpg
                $name_image = current(explode('.', $get_name_image)); //[0] => hinhanh , [1] => jpg
                $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension(); // hinhanh 3234. jpg
                $get_image->move('uploads/logo/', $new_image);
                $info->logo = $new_image;
            }
            $info->save();
            toastr()->success('Cập nhật', 'Cập nhật thông tin website thành công.');
            return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
