<?php

namespace App\Http\Middleware;

use Closure;

####### Include
use Auth;
use Session;
use DB;

class Account_Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (@Auth::check()) {

            return $next($request); //Add Menu ใน DB ค่อยมาปิดที่นี่

            $ex_menu = explode('/',$request->getPathInfo());// /backend/group_main
            $menu = @$ex_menu[2]; //group_main

            $check_menu = DB::table('permission_groupadmin_list as pgl')
            ->leftJoin('permission_menu_match_groupadmin as pmmg', function($join)
            {
                $join->on('pmmg.ref_groupadmin_id','=','pgl.ref_groupadmin_id');
            })
            ->leftJoin('permission_menu as pm', function($join)
            {
                $join->on('pm.menu_id','=','pmmg.ref_menu_id');
            })
            ->leftJoin('permission_groupadmin as pg', function($join)
            {
                $join->on('pg.groupadmin_id','=','pgl.ref_groupadmin_id');
            })
            ->where('pgl.ref_admin_id', Auth::user()->id)
            ->whereNull('pgl.groupadmin_list_deleted_at')
            ->where('pgl.groupadmin_list_active','1')
            ->whereNull('pg.groupadmin_deleted_at')
            ->where('pg.groupadmin_active','1')
            ->where('pm.menu_url', $menu)
            ->first();

            if(@$check_menu) {
                //ถ้ามีสิทธิ์ให้ผ่านเข้าเมนูนี้ได้
                return $next($request); 
            } else if( in_array($request->getPathInfo(), array('/backend/ajax')) || 
                stristr($request->getPathInfo(), '/backend/sync') !== False || 
                stristr($request->getPathInfo(), '/backend/import_excel') !== False ) {
                return $next($request); 
            } else if( in_array($request->getPathInfo(), array('/laravel-filemanager','/laravel-filemanager/upload')) ) {
                //CkEditor
                return $next($request); 
            } else if( stristr($request->getPathInfo(), '/backend/profile') ) {
                //Profile ตัวเอง
                return $next($request); 
            } else {
                //ถ้าไม่มีสิทธิ์ให้พาไปยังเมนูแรกที่เซทไว้
                $groupadmin = DB::table('permission_groupadmin_list as pgl')
                ->leftJoin('permission_groupadmin as pg', function($join)
                {
                    $join->on('pg.groupadmin_id','=','pgl.ref_groupadmin_id');
                })
                ->where('pgl.ref_admin_id', Auth::user()->id)
                ->whereNull('pgl.groupadmin_list_deleted_at')
                ->where('pgl.groupadmin_list_active','1')
                ->whereNull('pg.groupadmin_deleted_at')
                ->where('pg.groupadmin_active','1')
                ->first();
                if(@$groupadmin) { //dashboards
                    if(@$groupadmin->groupadmin_url_after_login) { //dashboards
                        return redirect('backend/'.$groupadmin->groupadmin_url_after_login); 
                    } else {
                        return back()->with('fail', true)->with('message','กรุณาติดต่อผู้ดูแลระบบ ตั้งค่า URL GroupAdmin : After Login '); //ย้อนกลับ
                    }
                } else {
                    return redirect('backend/login')->with('fail', true)->with('message','คุณไม่มีสิทธิ์เข้าใช้งานระบบนี้ค่ะ'); 
                }
            }
        } else {
            Session::put('backUrl', $request->getPathInfo());
            //dd($request);
            //dd(Session::all());exit;
            return abort(404, 'Page not found');
        }

        
    }

}

?>
