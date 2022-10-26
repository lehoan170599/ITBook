<!DOCTYPE html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Quản lý danh mục sản phẩm" />
<script type="application/x-javascript">  </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/frontend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/frontend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/frontend/css/font.css')}}" type="text/css"/>
<link href="{{('public/frontend/css/font-awesome.css')}}" rel="stylesheet"> 
{{-- <link rel="stylesheet" href="{{asset('public/frontend/css/morris.css')}}" type="text/css"/> --}}
<!-- calendar -->
<link rel="stylesheet" href="{{asset('public/frontend/css/monthly.css')}}">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('public/frontend/js/jquery2.0.3.min.js')}}"></script>
{{-- <script src="{{asset('public/frontend/js/raphael-min.js')}}"></script> --}}
<link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">


</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="dashboard" class="logo">
        IT-Book
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
       {{--  <li>
            <input type="text" class="form-control search" placeholder=" Tìm kiếm">
        </li> --}}
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{asset('public/uploads/product/2.jpg')}}">
                <span class="username">
                <?php
					$name = Session::get('admin_name');
					if($name){
					echo $name;
				}
				?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Thông tin</a></li>
                <li><a href="#"><i class="fa fa-cog"></i>Cài đặt</a></li>
                <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i>Đăng xuất</a></li>
            </ul>
        </li>
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý slide</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/add-slide')}}">Thêm slide</a></li>
                        <li><a href="{{URL::to('/manage-slide')}}">Liệt kê slide</a></li>
                    </ul>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý đơn hàng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a></li>
                    </ul>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục sản phẩm</a></li>
						<li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục sản phẩm</a></li>
                    </ul>

                 <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Quản lý sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
						<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                    </ul>

              </div>
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
        @yield('admin_content')
    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>Footer</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('public/frontend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/frontend/js/scripts.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.scrollTo.js')}}"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>


<!-- morris JavaScript -->	
<script type="text/javascript">
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script type="text/javascript">
      $('.update_qty_order').click(function(){
        var order_product_id = $(this).data('product_id');
        var order_qty = $('.order_qty_' +order_product_id).val();
        var order_code = $('.order_code').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
             url: '{{url('/update-qty')}}',
            method: 'POST',
            data:{_token:_token,order_product_id:order_product_id,order_qty:order_qty,order_code:order_code},
            success:function(data){

                alert('Cập nhật số lượng thành công');
                location.reload();
            }
        });
      });
</script>
<script type="text/javascript">
    $('.order_details').change(function(){
        var order_status = $(this).val();
        var order_id = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();
        
        //Lấy ra số lượng
        qty = [];
        $("input[name='product_sale_qty']").each(function(){
            qty.push($(this).val());   
        });
        
        //Lấy ra product_id
        order_product_id = [];
         $("input[name='order_product_id']").each(function(){
            order_product_id.push($(this).val());
        });
        j = 0;
        for(i=0;i<order_product_id.length;i++){
            //Số lượng khách đặt
            var order_qty = $('.order.qty_' + order_product_id[i]).val();
            //Số lượng tồn kho
            var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();
            if(parseInt(order_qty)>parseInt(order_qty_storage)){
                j = j + 1;
                if(j==1){
                    alert('Số lượng trong kho không đủ');
                }
                $('.color_qty' +order_product_id[i]).css('background','#DC143C')
            }
        }
        if(j==0){
            $.ajax({
            url: '{{url('/update-order-qty')}}',
            method: 'POST',
            data:{_token:_token,order_status:order_status,order_id:order_id,qty:qty,order_product_id:order_product_id},
            success:function(data){

                alert('Thay đổi tình trạng đơn hàng thành công');  
                location.reload();
            }
         }); 
        }

    });
</script>
<script type="text/javascript">
   $(function(){
    $("#datepicker").datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
        duration: "slow"
    });
    $("#datepicker2").datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
        duration: "slow"
    });
   });
</script>
<script type="text/javascript">
$(document).ready(function(){
       chart30daysorder();
         var chart = new Morris.Bar({

          element: 'chart',
          LineColors: ['#819C79', '#fc8710','#FF6541','#A4ADD3','#766B56'],
          parseTime: false,
          hideHover: 'auto',

          xkey: 'period',

          ykeys: ['order','sales','profit','quantity'],
          
          labels: ['đơn hàng','doanh số','lợi nhuận','số lượng']
            });

    function chart30daysorder(){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{url('/days-order')}}",
            method:"POST",
            dataType:"JSON",
            data:{_token:_token},

            success:function(data)
            {
                chart.setData(data);
            }
        });
    }

    $('.dashboard-filter').change(function(){
        var dashboard_value = $(this).val();
        var _token =  $('input[name="_token"]').val();
        
        $.ajax({
            url:"{{url('/dashboard-filter')}}",
            method:"POST",
            dataType:"JSON",
            data:{dashboard_value:dashboard_value,_token:_token},

            success:function(data)
            {
                chart.setData(data);
            }
        });
    });

    $('#btn-dashboard-filter').click(function(){
        var _token = $('input[name="_token"]').val();

        var from_date = $('#datepicker').val();
        var to_date = $('#datepicker2').val();
        
        $.ajax({
            url:"{{url('/filter-by-date')}}",
            method:"POST",
            dataType:"JSON",
            data:{from_date:from_date,to_date:to_date,_token:_token},

            success:function(data)
            {
                chart.setData(data);
            }
        });
    });
});

</script>
</body>
</html>
