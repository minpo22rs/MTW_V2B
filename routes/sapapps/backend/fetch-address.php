<?php 

Route::post('fetch-address', [App\Http\Controllers\Sapapps\Backend\Dash_SupplierController::class,'fetchaddress']);
Route::post('noti-send', [App\Http\Controllers\Sapapps\Backend\Dash_SaleController::class,'noti_send']);