@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm Slide
                        </header>
                            @php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            @endphp
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/insert-slide')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên slide</label>
                                    <input type="text" name="slide_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh slide</label>
                                    <input type="file" name="slide_image" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mô tả</label>
                                    <input type="text" name="slide_desc" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                    <select name="slide_status" class="form-control input-sm m-bot15">
                                        <option value="1">Hiển thị slide</option>
                                        <option value="0">Ẩn slide</option>
                                    </select>
                                </div>
                                <button type="submit" name="add_slide" class="btn btn-info">Thêm slide</button>
                            </form>
                            </div>
                        </div>
                    </section>
            </div>
@endsection