<?php

namespace App\Http\Controllers;
use App\Models\Shipping;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\OrderDetail;
use App\Models\Statistical;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
	public function update_qty(Request $Request){
		$data = $Request->all();
		$order_detail = OrderDetail::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
		$order_detail->product_sale_qty = $data['order_qty'];
		$order_detail->save();

	}
	public function update_order_qty(Request $Request){
		//update order
		$data = $Request->all();
		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();
		//order date
		$order_date = $order->order_date;
		$statistic = Statistical::where('order_date',$order_date)->get();
		if($statistic){
			$statistic_count = $statistic->count();
		}else{
			$statistic_count = 0;
		}
		if($order->order_status==2){
			$total_order = 0; 
			$sales = 0;
			$profit = 0;
			$quantity = 0;
			foreach($data['order_product_id'] as $key => $product_id){

				$product = Product::find($product_id);
				$product_qty = $product->product_qty;
				$product_sold = $product->product_sold;
				$product_price = $product->product_price;
				$product_cost = $product->product_cost;
				$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

				foreach($data['qty'] as $key2 => $qty){
					
					if($key==$key2){
						$pro_remain = $product_qty - $qty;
						$product->product_qty = $pro_remain;
						$product->product_sold = $product_sold + $qty;
						$product->save();
						//update doanh thu
						$quantity+=$qty;
						$total_order+=1;
						$sales+=$product_price*$qty;
						$profit = $sales-($product_cost*$qty);
					}
				}
			}
			if($statistic_count>0){
				$statistic_update = Statistical::where('order_date',$order_date)->first();
				$statistic_update->sales = $statistic_update->sales + $sales;
				$statistic_update->profit = $statistic_update->profit + $profit;
				$statistic_update->quantity = $statistic_update->quantity + $quantity;
				$statistic_update->total_order = $statistic_update->total_order + $total_order;
				$statistic_update->save();
			}
			else{

				$statistic_new = new Statistacal();
				$statistic_new->order_date = $order_date;
				$statistic_new->sales = $sales;
				$statistic_new->profit = $profit;
				$statistic_new->quantity = $quantity;
				$statistic_new->total_order = $total_order;
				$statistic_new->save();
			}
		}
	}
	public function view_order($order_code){
		$order_detail = OrderDetail::with('product')->where('order_code',$order_code)->get();
		$order = Order::where('order_code',$order_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
		}
			$customer = Customer::where('customer_id',$customer_id)->first();
			$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		
		return view('admin.view_order')->with(compact('order_detail','customer','shipping','order_detail','order','order_status'));
	}
    public function manage_order(){
    	$order = Order::orderby('created_at','DESC')->get();
    	return view('admin.manage_order')->with(compact('order'));
    }

    public function print_order($checkout_code){
    	$pdf = \App::make('dompdf.wrapper');
    	$pdf->loadHTML($this->print_order_convert($checkout_code));
    	return $pdf->stream();
    }
    public function print_order_convert($checkout_code){
    	return $checkout_code;
    }
}
