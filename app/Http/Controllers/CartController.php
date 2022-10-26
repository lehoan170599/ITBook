<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Cart;
use App\Models\Slide;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function gio_hang(){
        //Slide
        $slide = Slide::orderby('slide_id','DESC')->where('slide_status','1')->take(4)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('slide',$slide);
    }
    public function add_to_cart(Request $request){
        // Session::forget('cart');
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart',$cart);
        }
       
        Session::save();

    }   
    
    public function delete_to_cart($session_id){
        $cart  = Session::get('cart');
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Xóa sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Xóa sản phẩm thất bại');
        }
    }
    public function delete_all_cart(){
        $cart = Session::get('cart');
        if($cart==true){
            Session::forget('cart');
            return Redirect()->back()->with('message','Xóa hết giỏ hàng thành công');
        }
    }
    public function show_cart(){
        //Slide
        $slide = Slide::orderby('slide_id','DESC')->where('slide_status','1')->take(4)->get();
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
    	return view('pages.cart.show_cart')->with('category',$cate_product)->with('slide',$slide);
    }

    public function update_to_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Cập nhật số lượng thành công');
        }else{
            return redirect()->back()->with('message','Cập nhật số lượng thất bại');
        }
    }

    public function save_cart(Request $Request){
        $productId = $Request->productid_hidden;
        $quantity = $Request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first();  

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        return Redirect::to('/show-cart');
        // Cart::destroy();
    }
}
