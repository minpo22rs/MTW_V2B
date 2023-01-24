<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/clc', function() {
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

Route::get('testAPI',function(Request $request){
	$param = [
		'token' => $request->token,
		'referenceNo' => $request->referenceNo,
		'backgroundUrl' => $request->backgroundUrl ,
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

Route::get('/addon', function() {
	Artisan::call('storage:link');
	return "Success!!!";
});

Route::post('/test-api', [App\Http\Controllers\Sapapps\Frontend\PostController::class,'token_api']);

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => '/', 'namespace' => 'App\Http\Controllers\Sapapps\Backend'], function(){ 

	Route::get('/', array('uses' => 'LoginController@index'))->name('backend.login');
	Route::get('login/', array('uses' => 'LoginController@index'))->name('backend.login-index');
	Route::post('login/', array('uses' => 'LoginController@store'))->name('backend.store');
	Route::get('logout/', array('uses' => 'LoginController@logout'))->name('backend.logout');

});

Route::group(['prefix' => 'backend', 'namespace' => 'App\Http\Controllers\Sapapps\Backend', 'middleware' => 'account_admin'], function(){

	//Backend
	include('sapapps/backend/web-backend.php');
	include('sapapps/backend/fetch-address.php');

});

// Route::group(['namespace' => 'Traceon\Frontend'], function(){ 

// 	//Frontend
// 	include('traceon/frontend/web-frontend.php');

// });

// Route::group(['namespace' => 'App\Http\Controllers\Traceon\Frontend', 'middleware' => 'ecommerce_customer'], function(){ 

// 	//Member
// 	include('traceon/frontend/member.php');
// 	include('traceon/frontend/cart.php');
	
// });
