<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;
use Carbon\Carbon;

class Dash_History_SuccessController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_history_success';
        parent::__construct($this->url);
        $this->path_file .= '.dash_history_success';
        $this->menu = 'ประวัตืการซื้อที่สำเร็จ';//\App\Model\Menu::get_menu_name($this->url)['menu'];
        $this->menu_right = '';//\App\Model\Menu::get_menu_name($this->url)['menu_right'];       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'url'  => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu
        ];
        return view($this->path_file.'.index', $data);
    }

    public function info($id)
    {
        $check = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->count();
        $cart_data = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->first();
        $cart = DB::table('dash_product_order as po')
        ->join('dash_product as p','p.product_id','=','po.product_id')
        ->where('po.ref_so_id',$id)
        ->get();
        $price = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_sum_price');
        $discount = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_discount');
        $tax = 0.07 * $price;
        if($check > 0) {
            $data = [
                'id'   => $id,
                'url'  => $this->url,
                'menu' => $this->menu,
                '_title' => $this->menu,
                'product' => \App\Model\dashboard::front_product(),
                'cart'  => $cart,
                'sale'  => $cart_data,
                'customer' => \App\Model\dashboard::first_customer($cart_data->ref_customer_id),
                'price' => $price - $discount,
                'tax'   => $tax,
            ];
            return view($this->path_file.'.sell', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_history(@$request->all(),'success');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('manage', function($col){
            
            $html = '<a href="'.url('backend/dash_history_success/'.$col->id.'/info').'" class="text-danger"><button class="btn btn-sm btn-grd-info">
                    <i class="ti-shopping-cart-full"></i>รายละเอียด</button></a>';
            return $html;
        });

        $DBT->editColumn('name', function($col){
            
            $html = \App\Model\dashboard::name_customer($col->ref_customer_id);
            return $html;
        });

        $DBT->editColumn('so_created_at_ref_user_id', function($col){
            $html = \App\Model\dashboard::name_account($col->so_created_at_ref_user_id);
            return $html;
        });

        $DBT->editColumn('status',function($col){
            if($col->so_status == '') {
                $html = '';
            }else {
                $html = '<span class="label label-primary">'.$col->so_status.'</span>';
            }

            return $html;
        });

        return $DBT->make(true);
    }
}