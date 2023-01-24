<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use DB;
use Session;
use Config;
use General;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->url  = 'login';
        parent::__construct($this->url);
        $this->path_file .= '.login';
        $this->menu = '';//\App\Model\Menu::get_menu_name($this->url)['menu'];
        $this->menu_right = '';//\App\Model\Menu::get_menu_name($this->url)['menu_right'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        return view($this->path_file.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }

        //dd($request->all());

        $this->validate(
            $request,
            [
                'username'     => 'required',
                'password'     => 'required'
            ],
            [
                'username.required'    => '• Username จำเป็นต้องระบุข้อมูลค่ะ',
                'password.required'    => '• Password จำเป็นต้องระบุข้อมูลค่ะ'
            ]
        );

        //DB::beginTransaction();

        try {
            if(Auth::attempt(['username' => $username,'password'=> $password], 1)) {
                $status_login = 'Pass';
                if(Auth::user()->active != 1) {
                    $status_login = 'Not Active';
                }
            } else {
                $status_login = 'Wrong';
            }

            if($status_login != 'Pass') {

                if($status_login == 'Not Active') {
                    ## Log
                    \App\Model\Log\log_backend_login::log('login/account_admin/ID:/Not Active', 'F');

                    return back()->withInput($request->except(['password']))->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ เนื่องจาก Account นี้ยังไม่ได้รับการอนุมัติ รหัส: "Login Not Active" ค่ะ');
                } else if($status_login == 'Wrong') {
                    ## Log
                    \App\Model\Log\log_backend_login::log('login/account_admin/ID:/Wrong', 'F');

                    return back()->withInput($request->except(['password']))->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ เนื่องจาก Username/Password ผิดพลาดค่ะ');
                }


            } else {
                $lifetime = time() + 60 * 60 * 24 * 365;// one year
                Config::set('session.lifetime', $lifetime);
                ## Log
                \App\Model\Log\log_backend_login::log('login/account_admin/ID:'.Auth::user()->id.'/Pass', 'S');
            }

            //DB::commit();
            if(@Session::get('backUrl')) {
                $url = Session::get('backUrl');
                Session::forget('backUrl');
            } else {
                ### หา URL ที่อยู่ใน After Login
                $link = DB::table('permission_groupadmin_list as pgl')
                ->leftJoin('permission_groupadmin as pg', function($join)
                {
                    $join->on('pg.groupadmin_id','=','pgl.ref_groupadmin_id');
                })
                ->first();
                if(@$link) {
                    $url = 'backend/'.$link->groupadmin_url_after_login;
                } else {
                    $url = 'backend/group_main';
                }
            }

            return redirect()->intended($url)->with('success', true)->with('message', ' เข้าสู่ระบบสำเร็จแล้วค่ะ');

        } catch (\Exception $e) {
            //DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log('login/account_admin/ID:/Error:'.substr($e->getMessage(),0,180), 'F');
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput($request->except(['password']))->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
