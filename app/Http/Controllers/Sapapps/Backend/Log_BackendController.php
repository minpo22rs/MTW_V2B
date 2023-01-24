<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Log_BackendController extends Controller
{
    public function __construct()
    {
        $this->url  = 'system_log';
        parent::__construct($this->url);
        $this->path_file .= '.system_log';
        $this->menu = 'System Log';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
        $tbl = \App\Model\dashboard::datatables_log(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('backend_login_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->backend_login_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 
        
        $DBT->editColumn('backend_login_status', function($col){
            if($col->backend_login_status == 'F') {
                $html = '<span class="label label-warning">รหัสผ่านผิดพลาด</span>';
            } else if($col->backend_login_status == 'S') {
                $html = '<span class="label label-primary">เข้าระบบสำเร็จ</span>';
            } else if($col->backend_login_status == 'L') {
                $html = '<span class="label label-info">Log</span>';
            }

            return $html;
        });

        return $DBT->make(true);
    }

}
