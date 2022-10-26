<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Slide;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();


class HomeController extends Controller
{
    public function index(){
        //Slide
        $slide = Slide::orderby('slide_id','DESC')->where('slide_status','1')->take(4)->get();

    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
    	$all_product = DB::table('tbl_product')->where('product_status','1')->orderby('product_id','desc')->limit(6)->get();
    	return view('pages.home')->with('category',$cate_product)->with('all_product',$all_product)->with('slide',$slide);
    }
    public function search(Request $Request){
    	$keywords = $Request->keywords_submit;
        //Slide
        $slide = Slide::orderby('slide_id','DESC')->where('slide_status','1')->take(4)->get();
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();

    	$search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();

    	return view('pages.product.search')->with('category',$cate_product)->with('search_product',$search_product)->with('slide',$slide);

    }
}
