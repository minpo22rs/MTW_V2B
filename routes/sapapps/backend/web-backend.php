<?php
use Illuminate\Support\Facades\Route;

### Main Ajax_Update
$folder = 'ajax';
Route::resource($folder, $folder.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);

/*============================================ NEW
### Home / Call Center
/*============================================
Note : Call Center
===============================================*/
$url = 'call_center';
$file = 'Log_Call_Center';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');

/*============================================ NEW
### Home / Product
/*============================================
Note : Product
===============================================*/
$url = 'system_log';
$file = 'Log_Backend';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');

/*============================================ NEW
### Home / Product Stock
/*============================================
Note : Product Stock
===============================================*/
$url = 'product_stock_log';
$file = 'Log_Product_Stock';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');

/*============================================ NEW
### Home / Supplier
/*============================================
Note : Supplier
===============================================*/
$url = 'dash_supplier';
$file = 'Dash_Supplier';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/fetch-address', [App\Http\Controllers\Sapapps\Backend\Dash_SupplierController::class, 'fetchaddress'])->name($url.'.fetchaddress');
Route::post($url.'/{id?}/fetch-address', [App\Http\Controllers\Sapapps\Backend\Dash_SupplierController::class, 'fetchaddress'])->name($url.'.fetchaddress');
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / Product Type
/*============================================
Note : Product Type
===============================================*/
$url = 'dash_product_type';
$file = 'Dash_Product_Type';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / Product Category
/*============================================
Note : Product Category
===============================================*/
$url = 'dash_product_category';
$file = 'Dash_Product_Category';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / Product Attribute
/*============================================
Note : Product Attribute
===============================================*/
$url = 'dash_product_attribute';
$file = 'Dash_Product_Attribute';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / Product
/*============================================
Note : Product
===============================================*/
$url = 'dash_product';
$file = 'Dash_Product';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/stock', array('uses' => $file.'Controller@stock'))->name($url.'.stock');
Route::post($url.'/{id?}/stock/input', array('uses' => $file.'Controller@stock_input'))->name($url.'.stock_input');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / Customer
/*============================================
Note : Customer
===============================================*/
$url = 'dash_customer';
$file = 'Dash_Customer';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
Route::post($url.'/log_call', array('uses' => $file.'Controller@log_call'))->name($url.'.log_call');
Route::post($url.'/spread_customer', array('uses' => $file.'Controller@spread_customer'))->name($url.'.spread_customer');

/*============================================ NEW
### Home / Sale
/*============================================
Note : Sale
===============================================*/
$url = 'dash_sale';
$file = 'Dash_Sale';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/{id?}/add-cart', array('uses' => $file.'Controller@add_cart'))->name($url.'.add_cart');
Route::post($url.'/{id?}/discount', array('uses' => $file.'Controller@dis_count'))->name($url.'.dis_count');
Route::get($url.'/{id?}/create/{id2?}', array('uses' => $file.'Controller@create'))->name($url.'.create');
Route::get($url.'/{id?}/sell', array('uses' => $file.'Controller@sell'))->name($url.'.sell');
Route::get($url.'/{id?}/invoice', array('uses' => $file.'Controller@invoice'))->name($url.'.invoice');
Route::get($url.'/{id?}/sticker', array('uses' => $file.'Controller@sticker'))->name($url.'.sticker');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / Admin
/*============================================
Note : Admin
===============================================*/
$url = 'dash_admin';
$file = 'Dash_Admin';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

Route::get($url.'/{id?}/admin', array('uses' => $file.'Controller@admin'))->name($url.'.admin');
Route::post($url.'/datatables_admin', array('uses' => $file.'Controller@datatables_admin'))->name($url.'.datatables_admin');
Route::get($url.'/{id?}/merchandize', array('uses' => $file.'Controller@merchandize'))->name($url.'.merchandize');
Route::post($url.'/datatables_merchandize', array('uses' => $file.'Controller@datatables_merchandize'))->name($url.'.datatables_merchandize');
Route::get($url.'/{id?}/supervisor', array('uses' => $file.'Controller@supervisor'))->name($url.'.supervisor');
Route::post($url.'/datatables_supervisor', array('uses' => $file.'Controller@datatables_supervisor'))->name($url.'.datatables_supervisor');
Route::get($url.'/{id?}/fulillment', array('uses' => $file.'Controller@fulillment'))->name($url.'.fulillment');
Route::post($url.'/datatables_fulillment', array('uses' => $file.'Controller@datatables_fulillment'))->name($url.'.datatables_fulillment');
Route::get($url.'/{id?}/agent', array('uses' => $file.'Controller@agent'))->name($url.'.agent');
Route::post($url.'/datatables_agent', array('uses' => $file.'Controller@datatables_agent'))->name($url.'.datatables_agent');

/*============================================ NEW
### Home / Status Call
/*============================================
Note : Status Call
===============================================*/
$url = 'dash_status_call';
$file = 'Dash_Status_Call';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / History
/*============================================
Note : History
===============================================*/
$url = 'dash_history';
$file = 'Dash_History';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');

/*============================================ NEW
### Home / History Success
/*============================================
Note : History Success
===============================================*/
$url = 'dash_history_success';
$file = 'Dash_History_Success';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');

/*============================================ NEW
### Home / History Call
/*============================================
Note : History Call
===============================================*/
$url = 'dash_history_call';
$file = 'Dash_History_Call';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');

/*============================================ NEW
### Home / History Call Complete
/*============================================
Note : History Call Complete
===============================================*/
$url = 'dash_history_call_complete';
$file = 'Dash_History_Call_Complete';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');

/*============================================ NEW
### Home / History Call Disconnect
/*============================================
Note : History Call Disconnect
===============================================*/
$url = 'dash_history_call_disconnect';
$file = 'Dash_History_Call_Disconnect';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');

/*============================================ NEW
### Home / History Call Cancel
/*============================================
Note : History Call Cancel
===============================================*/
$url = 'dash_history_call_cancel';
$file = 'Dash_History_Call_Cancel';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
Route::get($url.'/{id?}/info', array('uses' => $file.'Controller@info'))->name($url.'.info');

/*============================================ NEW
### Home / Report Invoice
/*============================================
Note : Report Invoice
===============================================*/
$url = 'dash_report_invoice';
$file = 'Dash_Report_Invoice';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

### Dashboard
/*============================================
Note :
===============================================*/
$url = 'dashboard';
$file = 'Dashboard';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/rank', array('uses' => $file.'Controller@rank'))->name($url.'.rank');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');

/*============================================ NEW
### Home / Sticker Shipping
/*============================================
Note : Sticker Shipping
===============================================*/
$url = 'dash_sticker_shipping';
$file = 'Dash_Sticker_Shipping';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/render', array('uses' => $file.'Controller@show'))->name($url.'.render');


/*===========================================================================================*/

/*===========================================================================================*/


/*============================================ NEW
### Home / Product
/*============================================
Note : Product
===============================================*/
$url = 'mtw_v2_product';
$file = 'Mtw_v2_Product';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/stock', array('uses' => $file.'Controller@stock'))->name($url.'.stock');
Route::post($url.'/{id?}/stock/input', array('uses' => $file.'Controller@stock_input'))->name($url.'.stock_input');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

### Image
Route::get($url.'/{id?}/imageslide', array('uses' => $file.'Controller@imageslide'))->name($url.'.imageslide');
Route::post($url.'/datatables_image', array('uses' => $file.'Controller@datatables_image'))->name($url.'.datatables_image');
Route::post($url.'/{id?}/imageslide', array('uses' => $file.'Controller@image_store'))->name($url.'.image_store');
Route::put($url.'/{id?}/imageslide/{id2?}', array('uses' => $file.'Controller@image_update'))->name($url.'.image_update');
Route::get($url.'/{id?}/imageslide/{id2?}/delete', array('uses' => $file.'Controller@image_delete'))->name($url.'.image_delete');

/*============================================ NEW
### Home / Product Category
/*============================================
Note : Product Category
===============================================*/
$url = 'mtw_v2_product_category';
$file = 'Mtw_v2_Product_Category';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');

/*============================================ NEW
### Home / Attraction
/*============================================
Note : Attraction
===============================================*/
$url = 'mtw_v2_attraction';
$file = 'Mtw_v2_Attraction';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');




/*============================================ NEW
### Home / Hotel
/*============================================
Note : Hotel
===============================================*/
$url = 'mtw_v2_hotel';
$file = 'Mtw_v2_Hotel';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/stock', array('uses' => $file.'Controller@stock'))->name($url.'.stock');
Route::post($url.'/{id?}/stock/input', array('uses' => $file.'Controller@stock_input'))->name($url.'.stock_input');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
### Image
Route::get($url.'/{id?}/imageslide', array('uses' => $file.'Controller@imageslide'))->name($url.'.imageslide');
Route::post($url.'/datatables_image', array('uses' => $file.'Controller@datatables_image'))->name($url.'.datatables_image');
Route::post($url.'/{id?}/imageslide', array('uses' => $file.'Controller@image_store'))->name($url.'.image_store');
Route::put($url.'/{id?}/imageslide/{id2?}', array('uses' => $file.'Controller@image_update'))->name($url.'.image_update');
Route::get($url.'/{id?}/imageslide/{id2?}/delete', array('uses' => $file.'Controller@image_delete'))->name($url.'.image_delete');

/*============================================ NEW
### Home / Hotel Category
/*============================================
Note : Hotel Category
===============================================*/
$url = 'mtw_v2_hotel_category';
$file = 'Mtw_v2_hotel_Category';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');






/*============================================ NEW
### Home / restaurant
/*============================================
Note : restaurant
===============================================*/
$url = 'mtw_v2_restaurant';
$file = 'Mtw_v2_Restaurant';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/stock', array('uses' => $file.'Controller@stock'))->name($url.'.stock');
Route::post($url.'/{id?}/stock/input', array('uses' => $file.'Controller@stock_input'))->name($url.'.stock_input');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
### Image
Route::get($url.'/{id?}/imageslide', array('uses' => $file.'Controller@imageslide'))->name($url.'.imageslide');
Route::post($url.'/datatables_image', array('uses' => $file.'Controller@datatables_image'))->name($url.'.datatables_image');
Route::post($url.'/{id?}/imageslide', array('uses' => $file.'Controller@image_store'))->name($url.'.image_store');
Route::put($url.'/{id?}/imageslide/{id2?}', array('uses' => $file.'Controller@image_update'))->name($url.'.image_update');
Route::get($url.'/{id?}/imageslide/{id2?}/delete', array('uses' => $file.'Controller@image_delete'))->name($url.'.image_delete');

/*============================================ NEW
### Home / restaurant Category
/*============================================
Note : restaurant Category
===============================================*/
$url = 'mtw_v2_restaurant_category';
$file = 'Mtw_v2_restaurant_Category';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');







/*============================================ NEW
### Home / restaurant
/*============================================
Note : restaurant
===============================================*/
$url = 'mtw_v2_car';
$file = 'Mtw_v2_Car';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::get($url.'/{id?}/stock', array('uses' => $file.'Controller@stock'))->name($url.'.stock');
Route::post($url.'/{id?}/stock/input', array('uses' => $file.'Controller@stock_input'))->name($url.'.stock_input');
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
### Image
Route::get($url.'/{id?}/imageslide', array('uses' => $file.'Controller@imageslide'))->name($url.'.imageslide');
Route::post($url.'/datatables_image', array('uses' => $file.'Controller@datatables_image'))->name($url.'.datatables_image');
Route::post($url.'/{id?}/imageslide', array('uses' => $file.'Controller@image_store'))->name($url.'.image_store');
Route::put($url.'/{id?}/imageslide/{id2?}', array('uses' => $file.'Controller@image_update'))->name($url.'.image_update');
Route::get($url.'/{id?}/imageslide/{id2?}/delete', array('uses' => $file.'Controller@image_delete'))->name($url.'.image_delete');

/*============================================ NEW
### Home / car Category
/*============================================
Note : car Category
===============================================*/
$url = 'mtw_v2_car_category';
$file = 'Mtw_v2_Car_Category';
Route::resource($url, $file.'Controller')
->only([
    'index', 'show', 'create', 'store', 'update', 'destroy', 'edit'
])->except([

]);
Route::post($url.'/datatables', array('uses' => $file.'Controller@datatables'))->name($url.'.datatables');
Route::get($url.'/{id?}/delete', array('uses' => $file.'Controller@delete'))->name($url.'.delete');
