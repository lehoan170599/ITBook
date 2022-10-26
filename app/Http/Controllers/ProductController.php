<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Slide;
use Illuminate\Support\Facades\Redirect;
session_start();


class ProductController extends Controller
{
    public function add_product(){
    	$cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
    	return view('admin.add_product')->with('cate_product',$cate_product);
    }

    public function all_product(){
    	$all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')->orderby('tbl_product.product_id','desc')->get();
    	$manager_product = view('admin.all_product')->with('all_product',$all_product);
    	return view('admin_layout')->with('admin.all_product',$manager_product);
    }

    public function save_product(Request $Request){
    	$data = array();
    	$data['product_name'] = $Request->product_name;
    	$data['product_desc'] = $Request->product_desc;
    	$data['product_content'] = $Request->product_content;
    	$data['product_price'] = $Request->product_price;
        $data['product_cost'] = $Request->product_cost;
    	$data['product_qty'] = $Request->product_qty;
    	$data['category_id'] = $Request->cate_product;
        $data['product_status'] = $Request->product_status;

    	
    	$get_image = $Request->file('product_image');
    	if($get_image){
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.',$get_name_image));
    		$new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    		$get_image->move('public/uploads/product',$new_image);
    		$data['product_image'] = $new_image;
    		DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công');
    		return Redirect::to('all-product');
    	}
    	$data['product_image'] = '';
    	DB::table('tbl_product')->insert($data);
        Session::put('message','Thêm sản phẩm thành công');
    	return Redirect::to('all-product');
    } 

    public function active_product($product_id){
    	DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Đã hiển thị sản phẩm thành công');
    	return Redirect::to('all-product');
    }

    public function unactive_product($product_id){
    	DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Đã ẩn sản phẩm thành công');
    	return Redirect::to('all-product');
    }
    public function edit_product($product_id){
    	$cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();  
    	$edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
    	$manager_product = view('admin.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product);
    	return view('admin_layout')->with('admin.edit_product',$manager_product);

    }
    public function update_product(Request $Request,$product_id){
    	$data = array();
    	$data['product_name'] = $Request->product_name;
    	$data['product_desc'] = $Request->product_desc;
    	$data['product_content'] = $Request->product_content;
    	$data['product_price'] = $Request->product_price;
        $data['product_cost'] = $Request->product_cost;
    	$data['product_qty'] = $Request->product_qty;
    	$data['category_id'] = $Request->cate_product;
    	$get_image = $Request->file('product_image');
    	if($get_image){
    		$get_name_image = $get_image->getClientOriginalName();
    		$name_image = current(explode('.',$get_name_image));
    		$new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
    		$get_image->move('public/uploads/product',$new_image);
    		$data['product_image'] = $new_image;
    		DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
    		return Redirect::to('all-product');
    	}
    	DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
    	return Redirect::to('all-product');
    }
    public function delete_product($product_id){
    	DB::table('tbl_product')->where('product_id',$product_id)->delete();
         Session::put('message','Xóa sản phẩm thành công');
    	return Redirect::to('all-product');
    }
    // End Admin Page-----------------------

    public function product_detail($product_id){
        //slide
        $slide = Slide::orderBy('slide_id','DESC')->where('slide_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $product_detail = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')->where('tbl_product.product_id',$product_id)->get();
        foreach($product_detail as $key => $value){
            $category_id = $value->category_id;
        }

        $product_related = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();
        return view('pages.product.show_product_detail')->with('category',$cate_product)->with('product_detail',$product_detail)->with('relate',$product_related)->with('slide',$slide);
    }
}
