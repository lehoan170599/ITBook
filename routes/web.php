<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Frontend
Route::get('/', 'HomeController@index');
Route::get('/trang-chu', 'HomeController@index');
Route::post('/tim-kiem', 'HomeController@search');

//Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}', 'CategoryProduct@show_category_home');
Route::get('/chi-tiet-san-pham/{product_id}', 'ProductController@product_detail');


//Backend
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::post('/admin-dashboard', 'AdminController@dashboard');
Route::post('/filter-by-date','AdminController@filter_by_date');
Route::post('/dashboard-filter','AdminController@dashboard_filter');
Route::post('/days-order','AdminController@days_order');
Route::get('/logout', 'AdminController@logout');


//Category Product
Route::get('/add-category-product', 'CategoryProduct@add_category_product');
Route::get('/all-category-product', 'CategoryProduct@all_category_product');
Route::get('/edit-category-product/{category_product_id}', 'CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'CategoryProduct@delete_category_product');

Route::get('/unactive-category-product/{category_product_id}', 'CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'CategoryProduct@active_category_product');
Route::post('/save-category-product', 'CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}', 'CategoryProduct@update_category_product');

//Product
Route::get('/add-product','ProductController@add_product');
Route::get('/edit-product/{product_id}','ProductController@edit_product');
Route::get('/delete-product/{product_id}','ProductController@delete_product');
Route::get('/all-product','ProductController@all_product');

Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');

Route::post('/save-product','ProductController@save_product');
Route::post('/update-product/{product_id}','ProductController@update_product');

//Cart
Route::post('/update-to-cart','CartController@update_to_cart');
Route::post('/save-cart','CartController@save_cart');
Route::get('/gio-hang','CartController@gio_hang');
Route::get('/delete-to-cart/{session_id}','CartController@delete_to_cart');
Route::get('/delete-all-cart','CartController@delete_all_cart');
Route::post('/add-to-cart','CartController@add_to_cart');

//Checkout
Route::get('/login-checkout','CheckoutController@login_checkout');
Route::get('/logout-checkout','CheckoutController@logout_checkout');
Route::post('/login-customer','CheckoutController@login_customer');
Route::post('/add-customer','CheckoutController@add_customer');
Route::get('/checkout','CheckoutController@checkout');
Route::post('/save-checkout-customer','CheckoutController@save_checkout_customer');

Route::get('/payment','CheckoutController@payment');
Route::post('/order-place','CheckoutController@order_place');
Route::post('/confirm-order','CheckoutController@confirm_order');

//Order
Route::get('/manage-order','OrderController@manage_order');
Route::get('/view-order/{order_code}','OrderController@view_order');
Route::get('/print-order/{checkout_code}','OrderController@print_order');
Route::post('/update-order-qty','OrderController@update_order_qty');
Route::post('/update-qty','OrderController@update_qty');

//Slide
Route::get('/manage-slide','SlideController@manage_slide');
Route::get('/add-slide','SlideController@add_slide');
Route::post('/insert-slide','SlideController@insert_slide');
Route::get('/unactive-slide/{slide_id}', 'SlideController@unactive_slide');
Route::get('/active-slide/{slide_id}', 'SlideController@active_slide');