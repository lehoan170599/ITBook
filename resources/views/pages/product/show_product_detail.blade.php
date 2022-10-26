@extends('layout')
@section('content')
@foreach($product_detail as $key => $value)
<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{URL::to('/public/uploads/product/'.$value->product_image)}}" alt="" />
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								

							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="{{URL::to('public/frontend/images/new.jpg')}}" class="newarrival" alt="" />
								<h2>{{$value->product_name}}</h2>
								<p>Mã ID: {{$value->product_id}}</p>
								<img src="{{URL::to('public/prontend/images/rating.png')}}" alt="" />
								<form action="{{URL::to('/save-cart')}}" method="POST">
									@csrf
									<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
								<span>
									<span>{{number_format($value->product_price,0,',','.').' đ'}}</span>
								
									<label>Số lượng:</label>
									<input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}"  value="1" />
									<input name="productid_hidden" type="hidden"  value="{{$value->product_id}}" />
								</span>
								 <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
								</span>
								</form>
								<p><b>Tình trạng:</b> Còn hàng</p>
								<p><b>Điều kiện:</b> Mới 100%</p>
								<p><b>Danh mục:</b> {{$value->category_name}}</p>
								<a href=""><img src="{{URL::to('/public/frontend/images/share.png')}}" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li  class="active"><a href="#details" data-toggle="tab">Thông tin chi tiết</a></li>
								<li><a href="#desc" data-toggle="tab">Mô tả sản phẩm</a></li>
								<li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="details" >
								<p>{!!$value->product_content!!}</p>
							</div>
							<div class="tab-pane fade" id="desc" >
								<p>{!!$value->product_desc!!}</p>
							</div>
							<div class="tab-pane fade" id="reviews" >
								<div class="col-sm-12">
									<p><b>Viết đánh giá của bạn</b></p>
									
									<form action="#">
										<span>
											<input type="text" placeholder="Tên của bạn"/>
											<input type="email" placeholder="Địa chỉ email"/>
										</span>
										<textarea name="" placeholder="Đánh giá của bạn về sản phẩm"></textarea>
										<b>Đánh giá: </b> <img src="{{URL::to('public/frontend/images/rating.png')}}" alt="" />
										<button type="button" class="btn btn-default pull-right">
											Gửi
										</button>
									</form>
								</div>
							</div>
						</div>
</div><!--/category-tab-->
@endforeach
<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Sản phẩm liên quan</h2>
						
						<div id="related-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
									@foreach($relate as $key => $lienquan)	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="{{URL::to('public/uploads/product/'.$lienquan->product_image)}}" alt="" />
													<h2>{{number_format($value->product_price).' '.'đ'}}</h2>
													<p>{{$lienquan->product_name}}</p>
													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
												</div>
											</div>
										</div>
									</div>
								@endforeach
								</div>
							</div>		
						</div>
					</div><!--/recommended_items-->
					
@endsection   