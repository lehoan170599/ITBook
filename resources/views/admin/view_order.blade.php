@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
     Thông tin khách hàng đăng nhập
    </div>
    
    <div class="table-responsive">
                            @php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            @endphp
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        
          <tr>
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td>{{$customer->customer_email}}</td>
          </tr>
     
        </tbody>
      </table>

    </div>
   
  </div>
</div>
<br>
<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
     Thông tin vận chuyển hàng
    </div>
    
    
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th>Tên người vận chuyển</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>
          
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
        
          <tr>
           
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
             <td>{{$shipping->shipping_phone}}</td>
             <td>{{$shipping->shipping_email}}</td>
             <td>{{$shipping->shipping_note}}</td>
             <td>@if($shipping->shipping_method==0) Chuyển khoản @else Tiền mặt @endif</td>
            
          
          </tr>
     
        </tbody>
      </table>

    </div>
   
  </div>
</div>
<br><br>

<div class="table-agile-info">
  
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê chi tiết đơn hàng
    </div>
   
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
    
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng kho còn</th>
            <th>Số lượng</th>
            <th>Giá bán</th>
            <th>Giá gốc</th>
            <th>Tổng tiền</th>
            
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
          $i = 0;
          $total = 0;
          @endphp
        @foreach($order_detail as $key => $detail)

          @php 
          $i++;
          $subtotal = $detail->product_price*$detail->product_sale_qty;
          $total+=$subtotal;  
          @endphp
          <tr class="color_qty_{{$detail->product_id}}">
            <td><i>{{$i}}</i></td>
            <td>{{$detail->product_name}}</td>
            <td>{{$detail->product->product_qty}}</td>
            <td><input type="number" {{$order_status==2 ? 'disabled' :''}} class="order_qty_{{$detail->product_id}}" min="1" value="{{$detail->product_sale_qty}}"  name="product_sale_qty">
              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$detail->product_id}}" value="{{$detail->product->product_qty}}">
              <input type="hidden" name="order_code" class="order_code" value="{{$detail->order_code}}">

              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$detail->product_id}}">
              
              @if($order_status!=2)

              <button class="btn btn-default update_qty_order" data-product_id="{{$detail->product_id}}" name="update_qty_order">Cập nhật</button>

              @endif
            </td>
            <td>{{number_format($detail->product_price,0,',','.')}} đ</td>
            <td>{{number_format($detail->product->product_cost,0,',','.')}} đ</td>
            <td>{{number_format($subtotal,0,',','.')}} đ</td>
          </tr>
        @endforeach
          <tr>
            <td colspan="2">Thanh toán: {{number_format($total,0,',','.')}} đ </td>
          </tr>
          <tr>
            <td colspan="2">
              @foreach($order as $key => $or)
                @if($or->order_status==1)
              <form>
                @csrf
              <select class="form-control order_details">

                <option id="{{$or->order_id}}" selected value="1">Chưa xử lý</option>
                <option id="{{$or->order_id}}" value="2">Đã xử lý - Đã giao hàng</option>
              </select>
              </form>

              @else

              <form>
                @csrf
              <select class="form-control order_details" >
                <option disabled id="{{$or->order_id}}" value="1">Chưa xử lý</option>
                <option id="{{$or->order_id}}" selected value="2">Đã xử lý - Đã giao hàng</option>

              </select>
            </form>
                @endif
              @endforeach
            </td>
          </tr>
        </tbody>
      </table>
      {{-- <a href="{{'print-order/'.$detail->order_code}}">In đơn hàng</a> --}}
    </div>
   
  </div>
</div>
@endsection