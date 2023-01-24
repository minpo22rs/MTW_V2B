<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

####### Include
use DB;
use General;
use Auth;

class Menu extends Model
{
    protected $table = 'permission_menu';
    protected $primaryKey = 'menu_id';

    static public function get_menu_name($url = '') 
    {
        $data = [
            'menu' => '',
            'menu_right' => ''
        ]; 
        if($url) {
            $data['menu'] = DB::table('permission_menu')->where('menu_url',$url)->first();
            $data['menu_right'] = '<li class="active">'.$data['menu']->menu_name_en.'</li>';//ติดต่อเรา
            if(@$data['menu']->menu_ref_menu_id_lv3) {
                $m = DB::table('permission_menu')->where('menu_id',$data['menu']->menu_ref_menu_id_lv3)->first();
                $data['menu_right'] = '<li><a href="javascript:void(0);">'.$m->menu_name_en.'</a></li>'.$data['menu_right'];
            }
            if(@$data['menu']->menu_ref_menu_id_lv2) {
                $m = DB::table('permission_menu')->where('menu_id',$data['menu']->menu_ref_menu_id_lv2)->first();
                $data['menu_right'] = '<li><a href="javascript:void(0);">'.$m->menu_name_en.'</a></li>'.$data['menu_right'];
            }
            if(@$data['menu']->menu_ref_menu_id_lv1) {
                $m = DB::table('permission_menu')->where('menu_id',$data['menu']->menu_ref_menu_id_lv1)->first();
                $data['menu_right'] = '<li><a href="javascript:void(0);">'.$m->menu_name_en.'</a></li>'.$data['menu_right'];
            }
        }

        return $data;
    }

}
