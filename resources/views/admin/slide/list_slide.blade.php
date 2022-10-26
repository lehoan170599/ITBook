@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê Slide
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-4">
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">

        <thead>
        	@php
                $message = Session::get('message');
                if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
                }
            @endphp
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên Slide</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_slide as $key => $slide)  
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{($slide->slide_name)}}</td>
             <td><img src="{{URL::to('public/uploads/slide')}}/{{($slide->slide_image)}}" height="120" width="500"></td>
            <td>{{($slide->slide_desc)}}</td>
            <td><span class="text-ellipsis">
              <?php
              if($slide->slide_status == 1){
              ?>
                 <a href="{{URL::to('/unactive-slide/'.$slide->slide_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>;
              <?php
              }else{
              ?>
                <a href="{{URL::to('/active-slide/'.$slide->slide_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>;
              <?php
              }
              ?>

            </span></td>
            <td>
                <a onclick="return confirm('Bạn có muốn xóa Slide này không?')" href="{{URL::to('/delete-slide/'.$slide->slide_id)}}" class="active styling edit"ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i></a>
            </td>
          </tr>
          @endforeach()
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection