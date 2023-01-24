<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Log_Product_StockController extends Controller
{
    public function __construct()
    {
        $this->url  = 'product_stock_log';
        parent::__construct($this->url);
        $this->path_file .= '.product_stock_log';
        $this->menu = 'Product Stock Log';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
        if(Auth::user()->role == 'admin') {
            return view($this->path_file.'.index', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_stock_log(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 
        
        $DBT->editColumn('type', function($col){
            if($col->type == 'in') {
                $html = '<span class="label label-success">เข้าคลัง</span>';
            } else if($col->type == 'out') {
                $html = '<span class="label label-danger">ออกคลัง</span>';
            }

            return $html;
        });

        return $DBT->make(true);
    }

}
