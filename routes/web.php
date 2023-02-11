<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes 22222
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//API Mobile
Route::post('API/use-vouchers', 'App\Http\Controllers\api\Mobile\ApiController@use_vouchers');
//index
Route::post('API/index-main', 'App\Http\Controllers\api\Mobile\ApiController@index');
Route::get('API/banner-main', 'App\Http\Controllers\api\Mobile\ApiController@main_banner_index');
Route::get('API/banner-button', 'App\Http\Controllers\api\Mobile\ApiController@button_banner_index');
Route::get('API/banner-sub', 'App\Http\Controllers\api\Mobile\ApiController@sub_banner_index');
Route::get('API/banner-footer', 'App\Http\Controllers\api\Mobile\ApiController@footer_banner_index');

Route::get('API/contestant-top1', 'App\Http\Controllers\api\Mobile\ApiController@top1_index');
Route::get('API/contestant-top3', 'App\Http\Controllers\api\Mobile\ApiController@top3_index');
Route::get('API/contestant-top9', 'App\Http\Controllers\api\Mobile\ApiController@top9_index');
Route::get('API/contestant-top15', 'App\Http\Controllers\api\Mobile\ApiController@top15_index');
Route::get('API/recommend-hotel', 'App\Http\Controllers\api\Mobile\ApiController@hotel_index');
Route::get('API/recommend-restaurant', 'App\Http\Controllers\api\Mobile\ApiController@restaurant_index');
Route::get('API/recommend-product', 'App\Http\Controllers\api\Mobile\ApiController@product_index');
Route::get('API/recommend-location', 'App\Http\Controllers\api\Mobile\ApiController@location_index');
//Hotel
Route::post('API/room-detail', 'App\Http\Controllers\api\Mobile\ApiController@room_detail');
Route::post('API/seacrh-hotel', 'App\Http\Controllers\api\Mobile\ApiController@search_hotel');
Route::post('API/search-rooms', 'App\Http\Controllers\api\Mobile\ApiController@search_rooms');
Route::post('API/check-rooms', 'App\Http\Controllers\api\Mobile\ApiController@check_rooms');
Route::post('API/show-vouchers-hotel', 'App\Http\Controllers\api\Mobile\ApiController@show_vouchers_hotel');
Route::post('API/useless-vouchers-hotel', 'App\Http\Controllers\api\Mobile\ApiController@useless_vouchers_hotel');
Route::post('API/order-hotel-detail', 'App\Http\Controllers\api\Mobile\ApiController@order_hotel_detail');
Route::post('API/room-images', 'App\Http\Controllers\api\Mobile\ApiController@room_images');
//vote
Route::post('API/regions-name', 'App\Http\Controllers\api\Mobile\ApiController@regions_name');
Route::post('API/contestant-regions-member', 'App\Http\Controllers\api\Mobile\ApiController@contestant_page_2');
Route::post('API/contestant-detail', 'App\Http\Controllers\api\Mobile\ApiController@contestant_detail');
Route::post('API/vote-contestant', 'App\Http\Controllers\api\Mobile\ApiController@vote_contestant');
Route::post('API/vote-contestant-free', 'App\Http\Controllers\api\Mobile\ApiController@vote_contestant_free');
Route::get('API/18519520618552215205', 'App\Http\Controllers\api\Mobile\ApiController@reset_free_vote');
//Restaurant
Route::post('API/restaurant-image', 'App\Http\Controllers\api\Mobile\ApiController@restaurant_image');
Route::post('API/vouchers-show-detail', 'App\Http\Controllers\api\Mobile\ApiController@vouchers_show_detail');
Route::post('API/vouchers-order-detail', 'App\Http\Controllers\api\Mobile\ApiController@vouchers_order_detail');
Route::post('API/seller-images', 'App\Http\Controllers\api\Mobile\ApiController@seller_images');
Route::post('API/product-by-cate', 'App\Http\Controllers\api\Mobile\ApiController@product_by_cate');
//product
Route::get('API/category-product', 'App\Http\Controllers\api\Mobile\ApiController@category_product_page');
Route::post('API/product-in-category-product-page', 'App\Http\Controllers\api\Mobile\ApiController@product_in_category_product_page');
Route::post('API/product-detail-product-page', 'App\Http\Controllers\api\Mobile\ApiController@product_detail_product_page');
Route::get('API/product-page', 'App\Http\Controllers\api\Mobile\ApiController@product_page');
//Attraction
Route::get('API/attraction-page', 'App\Http\Controllers\api\Mobile\ApiController@attraction_page');
Route::get('API/attraction-member', 'App\Http\Controllers\api\Mobile\ApiController@attraction_member');
Route::post('API/attraction-member-detail', 'App\Http\Controllers\api\Mobile\ApiController@attraction_member_detail');
Route::post('API/attraction-detail-product-page', 'App\Http\Controllers\api\Mobile\ApiController@attraction_detail_product_page');
//seller
Route::get('API/category-restaurant', 'App\Http\Controllers\api\Mobile\ApiController@category_restaurant_page');
Route::post('API/restaurant-detail', 'App\Http\Controllers\api\Mobile\ApiController@restaurant_detail');
Route::post('API/vouchers-detail', 'App\Http\Controllers\api\Mobile\ApiController@vouchers_detail');
Route::post('API/hotel-detail', 'App\Http\Controllers\api\Mobile\ApiController@hotel_detail');
//Auth
Route::post('API/login-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@login_user_mtwa');
Route::post('API/register-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@register_user_mtwa');
Route::post('API/account-detail', 'App\Http\Controllers\api\Mobile\ApiController@account');
Route::get('API/otp-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@otp_user_mtwa');
Route::post('API/reset-mobile-mtwa', 'App\Http\Controllers\api\Mobile\ApiController@reset_user_mtwa');
Route::post('API/otp-mobile-mtwa-reset', 'App\Http\Controllers\api\Mobile\ApiController@otp_user_mtwa_reset');
Route::post('API/account-change', 'App\Http\Controllers\api\Mobile\ApiController@account_change');
Route::post('API/otp-phone-mtwa-reset', 'App\Http\Controllers\api\Mobile\ApiController@otp_phone_mtwa_reset');
Route::post('API/add-address', 'App\Http\Controllers\api\Mobile\ApiController@add_address');
Route::post('API/address-detail', 'App\Http\Controllers\api\Mobile\ApiController@address_detail');
Route::get('API/sos', 'App\Http\Controllers\api\Mobile\ApiController@sos');
Route::post('API/appleIdsign', 'App\Http\Controllers\api\Mobile\ApiController@appleIdsign');
//Cart
Route::post('API/add-cart', 'App\Http\Controllers\api\Mobile\ApiController@add_cart');
Route::post('API/qty-cart', 'App\Http\Controllers\api\Mobile\ApiController@qty_cart');
Route::post('API/search-cart', 'App\Http\Controllers\api\Mobile\ApiController@search_cart');
Route::post('API/list-cart', 'App\Http\Controllers\api\Mobile\ApiController@list_cart');
Route::get('API/e-pay', 'App\Http\Controllers\api\Mobile\ApiController@e_pay');
Route::get('API/e-pay-again', 'App\Http\Controllers\api\Mobile\ApiController@e_pay_again');
Route::post('API/account-list-payment', 'App\Http\Controllers\api\Mobile\ApiController@list_payment');
Route::post('API/call-back', 'App\Http\Controllers\api\Mobile\ApiController@call_back');
Route::get('API/thank-you', 'App\Http\Controllers\api\Mobile\ApiController@thank_you');
Route::get('API/332311212520', 'App\Http\Controllers\api\Mobile\ApiController@cc_wallet');
Route::get('API/opapp', 'App\Http\Controllers\api\Mobile\ApiController@opapp');
Route::post('API/carts-restaurant', 'App\Http\Controllers\api\Mobile\ApiController@carts_restaurant');
Route::post('API/carts-restaurant-list', 'App\Http\Controllers\api\Mobile\ApiController@carts_restaurant_list');
Route::post('API/carts-restaurant-delete', 'App\Http\Controllers\api\Mobile\ApiController@carts_restaurant_delete');
//Wishlists
Route::post('API/add-wishlists', 'App\Http\Controllers\api\Mobile\ApiController@add_wishlists');
Route::post('API/check-wishlists', 'App\Http\Controllers\api\Mobile\ApiController@check_wishlists');
Route::post('API/list-wishlists', 'App\Http\Controllers\api\Mobile\ApiController@list_wishlists');
//Order
Route::post('API/show-order', 'App\Http\Controllers\api\Mobile\ApiController@show_order');
Route::post('API/show-vouchers', 'App\Http\Controllers\api\Mobile\ApiController@show_vouchers');
Route::post('API/show-vouchers-useless', 'App\Http\Controllers\api\Mobile\ApiController@show_vouchers_useless');
Route::post('API/hotel-order', 'App\Http\Controllers\api\Mobile\ApiController@hotel_order');
Route::get('API/kuy_aisus', 'App\Http\Controllers\api\Mobile\ApiController@kuy_aisus');
//Review
Route::post('API/form-review', 'App\Http\Controllers\api\Mobile\ApiController@form_review');
Route::post('API/reviewlist', 'App\Http\Controllers\api\Mobile\ApiController@reviewlist');
Route::post('API/own-review', 'App\Http\Controllers\api\Mobile\ApiController@ownreview');
Route::post('API/stardust', 'App\Http\Controllers\api\Mobile\ApiController@stardust');
//Search
Route::post('API/search-everything', 'App\Http\Controllers\api\Mobile\ApiController@search_everything');
//Address
Route::get('API/getProvinces', 'App\Http\Controllers\api\Mobile\ApiController@getProvinces');
Route::post('API/getDistrict', 'App\Http\Controllers\api\Mobile\ApiController@getDistrict');
Route::post('API/getSubDistrict', 'App\Http\Controllers\api\Mobile\ApiController@getSubDistrict');

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/clc', function () {
    // Artisan::call('make:middleware Localization');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    // Artisan::call('view:clear');
    // Artisan::call('view:clear');
    // session()->forget('key');
    return "Cleared!";
});

Route::get('testAPI', function (Request $request) {
    $param = [
        'token' => $request->token,
        'referenceNo' => $request->referenceNo,
        'backgroundUrl' => $request->backgroundUrl,
        'amount' => $request->amount,

    ];

    $client = new GuzzleHttp\Client();

    $res = $client->post('https://api.gbprimepay.com/gbp/gateway/qrcode/text', [
        'form_params' => $param,

    ]);

    // dd($res->getBody()->getContents());
    $response = json_decode($res->getBody()->getContents());
    dd($response);
});

Route::get('/addon', function () {
    Artisan::call('storage:link');
    return "Success!!!";
});

Route::post('/test-api', [App\Http\Controllers\Sapapps\Frontend\PostController::class, 'token_api']);

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => '/', 'namespace' => 'App\Http\Controllers\Sapapps\Backend'], function () {

    Route::get('/', array('uses' => 'LoginController@index'))->name('backend.login');
    Route::get('login/', array('uses' => 'LoginController@index'))->name('backend.login-index');
    Route::post('login/', array('uses' => 'LoginController@store'))->name('backend.store');
    Route::get('logout/', array('uses' => 'LoginController@logout'))->name('backend.logout');

});

Route::group(['prefix' => 'backend', 'namespace' => 'App\Http\Controllers\Sapapps\Backend', 'middleware' => 'account_admin'], function () {

    //Backend
    include ('sapapps/backend/web-backend.php');
    include ('sapapps/backend/fetch-address.php');

});

// Route::group(['namespace' => 'Traceon\Frontend'], function(){

//     //Frontend
//     include('traceon/frontend/web-frontend.php');

// });

// Route::group(['namespace' => 'App\Http\Controllers\Traceon\Frontend', 'middleware' => 'ecommerce_customer'], function(){

//     //Member
//     include('traceon/frontend/member.php');
//     include('traceon/frontend/cart.php');

// });
