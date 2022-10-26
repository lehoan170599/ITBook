<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use App\Models\Statistical;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
session_start();
class AdminController extends Controller
{
    public function index(){
    	return view('admin_login');
    }
    public function show_dashboard(){
    	return view('admin.dashboard');
    }
    public function dashboard(Request $Request){
        $admin_email = $Request->admin_email;
        $admin_password = md5($Request->admin_password);
        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboard');
        }else{
            Session::put('massage','Sai tài khoản hoặc mật khẩu');
            return Redirect::to('/admin');
        }
    }
    public function logout(){
            Session::put('admin_name',null);
            Session::put('admin_id',null);
            return Redirect::to('/admin');
    }
    public function filter_by_date(Request $Request){
        $data = $Request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = Statistical::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();

            foreach($get as $key => $val){
                $chart_data[] = array(

                    'period' => $val->order_date,
                    'order'=> $val->total_order,
                    'sales'=> $val->sales,
                    'profit'=> $val->profit,
                    'quantity'=> $val->quantity
                
                );
            }
            echo $data = json_encode($chart_data);
    }
    public function days_order(){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistical::whereBetween('order_date',[$sub30days,$now])->orderBy('order_date','ASC')->get();

        foreach($get as $key => $val){
            $chart_data[] = array(

                    'period' => $val->order_date,
                    'order'=> $val->total_order,
                    'sales'=> $val->sales,
                    'profit'=> $val->profit,
                    'quantity'=> $val->quantity
                );
            echo $data = json_encode($chart_data);
        }
    }

    public function dashboard_filter(Request $Request){
        $data = $Request->all();

        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        echo $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value']=='7ngay'){
            $get = Statistical::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();
        }
        elseif($data['dashboard_value']=='thangtruoc'){
            $get = Statistical::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();
        }
        elseif($data['dashboard_value']=='thangnay'){
            $get = Statistical::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','ASC')->get();
        }
        else{
            $get = Statistical::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }

        foreach($get as $key => $val){
            $chart_data[] = array(

                    'period' => $val->order_date,
                    'order'=> $val->total_order,
                    'sales'=> $val->sales,
                    'profit'=> $val->profit,
                    'quantity'=> $val->quantity
                
                );
            echo $data = json_encode($chart_data);
        }
    }
}
