<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Http\Requests;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
session_start();

class SlideController extends Controller
{
    public function manage_slide(){
    	$all_slide = Slide::orderby('slide_id','DESC')->get();
    	return view('admin.slide.list_slide')->with(compact('all_slide'));    
	}
	public function add_slide(){
		return view('admin.slide.add_slide');
	}
	public function insert_slide(Request $Request){
		$data = $Request->all();

    	$get_image = $Request->file('slide_image');
    	if($get_image){
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.',$get_name_image));
    		$new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();

    		$get_image->move('public/uploads/slide',$new_image);

    		$slide = new Slide();
    		$slide->slide_name = $data['slide_name'];
    		$slide->slide_image = $new_image;
    		$slide->slide_status = $data['slide_status'];
    		$slide->slide_desc = $data['slide_desc'];
    		$slide->save();
    		Session::put('message','Thêm slide thành công');
    		return Redirect::to('add-slide');
    	}else{
    		Session::put('message','Vui lòng thêm hình ảnh');
    		Redirect::to('add-slide');
    	}
	}
	public function active_slide($slide_id){
    	DB::table('tbl_slide')->where('slide_id',$slide_id)->update(['slide_status'=>1]);
    	Session::put('message','Đã hiển thị slide thành công');
    	return Redirect::to('manage-slide');
    }

    public function unactive_slide($slide_id){
    	DB::table('tbl_slide')->where('slide_id',$slide_id)->update(['slide_status'=>0]);
    	Session::put('message','Đã ẩn slide');
    	return Redirect::to('manage-slide');
    }
}
