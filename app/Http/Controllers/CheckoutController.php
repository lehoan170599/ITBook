<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Cart;
use App\Http\Requests;
use Session;
use Carbon\Carbon;
use App\Models\Slide;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    public function confirm_order(Request $request){
         $data = $request->all();
         $shipping = new Shipping();
         $shipping->shipping_name = $data['shipping_name'];
         $shipping->shipping_email = $data['shipping_email'];
         $shipping->shipping_phone = $data['shipping_phone'];
         $shipping->shipping_address = $data['shipping_address'];
         $shipping->shipping_note = $data['shipping_note'];
         $shipping->shipping_method = $data['shipping_method'];
         $shipping->save();
         $shipping_id = $shipping->shipping_id;

         $checkout_code = substr(md5(microtime()),rand(0,26),5);
         $order = new Order;
         $order->customer_id = Session::get('customer_id');
         $order->shipping_id = $shipping_id;
         $order->order_status = 1;
         $order->order_code = $checkout_code;

         date_default_timezone_set('Asia/Ho_Chi_Minh');
         $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
         $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
         $order->created_at = $today;
         $order->order_date = $order_date; 
         $order->save();

        if(Session::get('cart')==true){
            foreach(Session::get('cart') as $key => $cart){
                $order_detail = new OrderDetail;
                $order_detail->order_code = $checkout_code;
                $order_detail->product_id = $cart['product_id'];
                $order_detail->product_name = $cart['product_name'];
                $order_detail->product_price = $cart['product_price'];
                $order_detail->product_sale_qty = $cart['product_qty'];
                $order_detail->save();
            }
        }
        Session::forget('cart');
    }
    public function login_checkout(){
        //Slide
        $slide = Slide::orderby('slide_id','DESC')->where('slide_status','1')->take(4)->get();
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
    	return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('slide',$slide);
    }
    public function add_customer(Request $Request){
    	$data = array();
    	$data['customer_name'] = $Request->customer_name;
    	$data['customer_email'] = $Request->customer_email;
    	$data['customer_password'] = md5($Request->customer_password);
    	$data['customer_phone'] = $Request->customer_phone;

    	$customer_id = DB::table('tbl_customers')->insertGetId($data);

    	Session::put('customer_id',$customer_id);
    	Session::put('customer_name',$Request->customer_name);

    	return Redirect('/checkout');
    }
    public function checkout(){
        //Slide
        $slide = Slide::orderby('slide_id','DESC')->where('slide_status','1')->take(4)->get();
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
    	return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('slide',$slide);
    }
    public function save_checkout_customer(Request $Request){
    	$data = array();
    	$data['shipping_name'] = $Request->shipping_name;
    	$data['shipping_email'] = $Request->shipping_email;
    	$data['shipping_address'] = $Request->shipping_address;
    	$data['shipping_phone'] = $Request->shipping_phone;
    	$data['shipping_note'] = $Request->shipping_note;

    	$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

    	Session::put('shipping_id',$shipping_id);
    	return Redirect::to('/payment');
    }
    public function payment(){
    	$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
    	return view('pages.checkout.payment')->with('category',$cate_product);;
    }
    public function order_place(Request $Request){
    	//insert payment_method
	    	$data = array();
	    	$data['payment_method'] = $Request->payment_options;
	    	$data['payment_status'] = 'Đang chờ xử lý';
	    	$payment_id = DB::table('tbl_payment')->insertGetId($data);


    	//insert order
	    	$order_data = array();
	        $order_data['customer_id'] = Session::get('customer_id');
	        $order_data['shipping_id'] = Session::get('shipping_id');
	        $order_data['payment_id'] = $payment_id;
	        $order_data['order_total'] = Cart::total();
	        $order_data['order_status'] = 'Đang chờ xử lý';
	        $order_id = DB::table('tbl_order')->insertGetId($order_data);

    	//insert order_detail
    	$content = Cart::content();
    	foreach($content as $v_content){
    		$order_d_data['order_id'] = $order_id;
    		$order_d_data['product_id'] = $v_content->id;
    		$order_d_data['product_name'] = $v_content->name;
    		$order_d_data['product_price'] = $v_content->price;
    		$order_d_data['product_amount'] = $v_content->qty;
    		DB::table('tbl_order_detail')->insert($order_d_data);	
    	}
    	if($data['payment_method']==1){
    		echo 'Thanh toán bằng thẻ ATM';
    	}
    	elseif($data['payment_method']==2){
    		Cart::destroy();
    		$cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
    	return view('pages.checkout.handcash')->with('category',$cate_product);
    	}
    	else{
            echo 'Thẻ ghi nợ';

        }
    }
    public function logout_checkout(){
    	Session::flush();
    	return Redirect('/login-checkout');
    }
    public function login_customer(Request $Request){
    	$email = $Request->email_account;
    	$password = md5($Request->password_account);
    	$result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
    	if($result){
    		Session::put('customer_id',$result->customer_id);
    		return Redirect::to('/checkout');
    	}
    	else{
    		return Redirect::to('/login-checkout');
    	}
	}
	public function manage_order(){
		$all_order = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')->select('tbl_order.*','customer_name')->orderby('tbl_order.order_id','desc')->get();
    	$manager_order = view('admin.manage_order')->with('all_order',$all_order);
    	return view('admin_layout')->with('admin.manage_order',$manager_order);
	}
    public function view_order($orderId){
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_detail','tbl_order.order_id','=','tbl_order_detail.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_detail.*')
        ->first();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manager_order_by_id);

    }
}

