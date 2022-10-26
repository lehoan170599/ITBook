<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Slide;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
{
    public function add_category_product(){
    	return view('admin.add_category_product');
    }
    public function all_category_product(){
    	$all_category_product = DB::table('tbl_category_product')->get();
    	$manager_category_product = view('admin.all_category_product')->with('all_category_product',$all_category_product);
    	return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
    }
    public function save_category_product(Request $Request){
    	$data = array();
    	$data['category_name'] = $Request->category_product_name;
    	$data['category_desc'] = $Request->category_product_desc;
    	$data['category_status'] = $Request->category_product_status;
    	DB::table('tbl_category_product')->insert($data);
    	Session::put('message','Thêm danh mục sản phẩm thành công');
    	return Redirect::to('add-category-product');
	}
	public function unactive_category_product($category_product_id){
		DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
		Session::put('message','Hiển thị danh mục sản phẩm thành công');
		return Redirect::to('all-category-product');
	}
	public function active_category_product($category_product_id){
		DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
		Session::put('message','Ẩn danh mục sản phẩm thành công');
		return Redirect::to('all-category-product');
	}
	public function edit_category_product($category_product_id){
		$edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
    	$manager_category_product = view('admin.edit_category_product')->with('edit_category_product',$edit_category_product);
    	return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);
	}
	public function update_category_product(Request $Request,$category_product_id){
		$data = array();
		$data['category_name'] = $Request->category_product_name;
		$data['category_desc'] = $Request->category_product_desc;
		DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
		Session::put('message','Cập nhật danh mục thành công');
		return Redirect::to('all-category-product');
	}
	public function delete_category_product($category_product_id){
		DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
		return Redirect::to('all-category-product');
	}
//-End function Admin Page ----------

	public function show_category_home($category_id){
		//Slide
        $slide = Slide::orderby('slide_id','DESC')->where('slide_status','1')->take(4)->get();
		$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
		$category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.category_id',$category_id)->get();
		$category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->limit(1)->get();
		return view('pages.category.show_category')->with('category',$cate_product)->with('category_by_id',$category_by_id)->with('category_name',$category_name)->with('slide',$slide);
	}
}