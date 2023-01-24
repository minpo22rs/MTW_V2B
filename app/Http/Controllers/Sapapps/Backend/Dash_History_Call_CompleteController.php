<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;
use Carbon\Carbon;

class Dash_History_Call_CompleteController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_history_call_complete';
        parent::__construct($this->url);
        $this->path_file .= '.dash_history_call_complete';
        $this->menu = 'ติดต่อได้';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_history_call(@$request->all(),'complete');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('cr_created_at_ref_user_id', function($col){
            $html = \App\Model\dashboard::name_account($col->cr_created_at_ref_user_id);
            return $html;
        });

        return $DBT->make(true);
    }
}