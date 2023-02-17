<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('test',function() {
    return "Minpo22";
});
//API Mobile
Route::post('use-vouchers', 'App\Http\Controllers\api\Mobile\ApiController@use_vouchers');
//index
Route::post('index-main', 'App\Http\Controllers\api\Mobile\ApiController@index');
Route::get('banner-main', 'App\Http\Controllers\api\Mobile\ApiController@main_banner_index');
Route::get('banner-button', 'App\Http\Controllers\api\Mobile\ApiController@button_banner_index');
Route::get('banner-sub', 'App\Http\Controllers\api\Mobile\ApiController@sub_banner_index');
Route::get('banner-footer', 'App\Http\Controllers\api\Mobile\ApiController@footer_banner_index');

Route::get('contestant-top1', 'App\Http\Controllers\api\Mobile\ApiController@top1_index');
Route::get('contestant-top3', 'App\Http\Controllers\api\Mobile\ApiController@top3_index');
Route::get('contestant-top9', 'App\Http\Controllers\api\Mobile\ApiController@top9_index');
Route::get('contestant-top15', 'App\Http\Controllers\api\Mobile\ApiController@top15_index');
Route::get('recommend-hotel', 'App\Http\Controllers\api\Mobile\ApiController@hotel_index');
Route::get('recommend-restaurant', 'App\Http\Controllers\api\Mobile\ApiController@restaurant_index');
Route::get('recommend-product', 'App\Http\Controllers\api\Mobile\ApiController@product_index');
Route::get('recommend-location', 'App\Http\Controllers\api\Mobile\ApiController@location_index');
//Hotel
Route::post('room-detail', 'App\Http\Controllers\api\Mobile\ApiController@room_detail');
Route::post('seacrh-hotel', 'App\Http\Controllers\api\Mobile\ApiController@search_hotel');
Route::post('search-rooms', 'App\Http\Controllers\api\Mobile\ApiController@search_rooms');
Route::post('check-rooms', 'App\Http\Controllers\api\Mobile\ApiController@check_rooms');
Route::post('show-vouchers-hotel', 'App\Http\Controllers\api\Mobile\ApiController@show_vouchers_hotel');
Route::post('useless-vouchers-hotel', 'App\Http\Controllers\api\Mobile\ApiController@useless_vouchers_hotel');
Route::post('order-hotel-detail', 'App\Http\Controllers\api\Mobile\ApiController@order_hotel_detail');
Route::post('room-images', 'App\Http\Controllers\api\Mobile\ApiController@room_images');
//vote
Route::post('regions-name', 'App\Http\Controllers\api\Mobile\ApiController@regions_name');
Route::post('contestant-regions-member', 'App\Http\Controllers\api\Mobile\ApiController@contestant_page_2');
Route::post('contestant-detail', 'App\Http\Controllers\api\Mobile\ApiController@contestant_detail');
Route::post('vote-contestant', 'App\Http\Controllers\api\Mobile\ApiController@vote_contestant');
Route::post('vote-contestant-free', 'App\Http\Controllers\api\Mobile\ApiController@vote_contestant_free');
Route::get('18519520618552215205', 'App\Http\Controllers\api\Mobile\ApiController@reset_free_vote');
//Restaurant
Route::post('restaurant-image', 'App\Http\Controllers\api\Mobile\ApiController@restaurant_image');
Route::post('vouchers-show-detail', 'App\Http\Controllers\api\Mobile\ApiController@vouchers_show_detail');
Route::post('vouchers-order-detail', 'App\Http\Controllers\api\Mobile\ApiController@vouchers_order_detail');
Route::post('seller-images', 'App\Http\Controllers\api\Mobile\ApiController@seller_images');
Route::post('product-by-cate', 'App\Http\Controllers\api\Mobile\ApiController@product_by_cate');
//product
Route::get('category-product', 'App\Http\Controllers\api\Mobile\ApiController@category_product_page');
Route::post('product-in-category-product-page', 'App\Http\Controllers\api\Mobile\ApiController@product_in_category_product_page');
Route::post('product-detail-product-page', 'App\Http\Controllers\api\Mobile\ApiController@product_detail_product_page');
Route::get('product-page', 'App\Http\Controllers\api\Mobile\ApiController@product_page');
//Attraction
Route::get('attraction-page', 'App\Http\Controllers\api\Mobile\ApiController@attraction_page');
Route::get('attraction-member', 'App\Http\Controllers\api\Mobile\ApiController@attraction_member');
Route::post('attraction-member-detail', 'App\Http\Controllers\api\Mobile\ApiController@attraction_member_detail');
Route::post('attraction-detail-product-page', 'App\Http\Controllers\api\Mobile\ApiController@attraction_detail_product_page');
//seller
Route::get('category-restaurant', 'App\Http\Controllers\api\Mobile\ApiController@category_restaurant_page');
Route::post('restaurant-detail', 'App\Http\Controllers\api\Mobile\ApiController@restaurant_detail');
Route::post('vouchers-detail', 'App\Http\Controllers\api\Mobile\ApiController@vouchers_detail');
Route::post('hotel-detail', 'App\Http\Controllers\api\Mobile\ApiController@hotel_detail');
//Auth
Route::post('login-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@login_user_mtwa');
Route::post('register-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@register_user_mtwa');
Route::post('account-detail', 'App\Http\Controllers\api\Mobile\ApiController@account');
Route::get('otp-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@otp_user_mtwa');
Route::post('reset-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@reset_user_mtwa');
Route::post('otp-mobile-mtwa-reset', 'App\Http\Controllers\api\Mobile\ApiController@otp_user_mtwa_reset');
Route::post('account-change', 'App\Http\Controllers\api\Mobile\ApiController@account_change');
Route::post('otp-phone-mtwa-reset', 'App\Http\Controllers\api\Mobile\ApiController@otp_phone_mtwa_reset');
Route::post('add-address', 'App\Http\Controllers\api\Mobile\ApiController@add_address');
Route::post('address-detail', 'App\Http\Controllers\api\Mobile\ApiController@address_detail');
Route::get('sos', 'App\Http\Controllers\api\Mobile\ApiController@sos');
Route::post('appleIdsign', 'App\Http\Controllers\api\Mobile\ApiController@appleIdsign');
//Cart
Route::post('add-cart', 'App\Http\Controllers\api\Mobile\ApiController@add_cart');
Route::post('qty-cart', 'App\Http\Controllers\api\Mobile\ApiController@qty_cart');
Route::post('search-cart', 'App\Http\Controllers\api\Mobile\ApiController@search_cart');
Route::post('list-cart', 'App\Http\Controllers\api\Mobile\ApiController@list_cart');
Route::get('e-pay', 'App\Http\Controllers\api\Mobile\ApiController@e_pay');
Route::get('e-pay-again', 'App\Http\Controllers\api\Mobile\ApiController@e_pay_again');
Route::post('account-list-payment', 'App\Http\Controllers\api\Mobile\ApiController@list_payment');
Route::post('call-back', 'App\Http\Controllers\api\Mobile\ApiController@call_back');
Route::get('thank-you', 'App\Http\Controllers\api\Mobile\ApiController@thank_you');
Route::get('332311212520', 'App\Http\Controllers\api\Mobile\ApiController@cc_wallet');
Route::get('opapp', 'App\Http\Controllers\api\Mobile\ApiController@opapp');
Route::post('carts-restaurant', 'App\Http\Controllers\api\Mobile\ApiController@carts_restaurant');
Route::post('carts-restaurant-list', 'App\Http\Controllers\api\Mobile\ApiController@carts_restaurant_list');
Route::post('carts-restaurant-delete', 'App\Http\Controllers\api\Mobile\ApiController@carts_restaurant_delete');
//Wishlists
Route::post('add-wishlists', 'App\Http\Controllers\api\Mobile\ApiController@add_wishlists');
Route::post('check-wishlists', 'App\Http\Controllers\api\Mobile\ApiController@check_wishlists');
Route::post('list-wishlists', 'App\Http\Controllers\api\Mobile\ApiController@list_wishlists');
//Order
Route::post('show-order', 'App\Http\Controllers\api\Mobile\ApiController@show_order');
Route::post('show-vouchers', 'App\Http\Controllers\api\Mobile\ApiController@show_vouchers');
Route::post('show-vouchers-useless', 'App\Http\Controllers\api\Mobile\ApiController@show_vouchers_useless');
Route::post('hotel-order', 'App\Http\Controllers\api\Mobile\ApiController@hotel_order');
Route::get('kuy_aisus', 'App\Http\Controllers\api\Mobile\ApiController@kuy_aisus');
//Review
Route::post('form-review', 'App\Http\Controllers\api\Mobile\ApiController@form_review');
Route::post('reviewlist', 'App\Http\Controllers\api\Mobile\ApiController@reviewlist');
Route::post('own-review', 'App\Http\Controllers\api\Mobile\ApiController@ownreview');
Route::post('stardust', 'App\Http\Controllers\api\Mobile\ApiController@stardust');
//Search
Route::post('search-everything', 'App\Http\Controllers\api\Mobile\ApiController@search_everything');
//Address
Route::get('getProvinces', 'App\Http\Controllers\api\Mobile\ApiController@getProvinces');
Route::post('getDistrict', 'App\Http\Controllers\api\Mobile\ApiController@getDistrict');
Route::post('getSubDistrict', 'App\Http\Controllers\api\Mobile\ApiController@getSubDistrict');
