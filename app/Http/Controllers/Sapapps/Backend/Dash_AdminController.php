<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Dash_AdminController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_admin';
        parent::__construct($this->url);
        $this->path_file .= '.dash_admin';
        $this->menu = 'User Account';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
        // $n = 0;
        // $data2 = DB::select("SELECT @n := @n + 1 AS NO,'id' FROM dash_supplier, (SELECT @n := 0) m WHERE supplier_address = 'world' ORDER BY id DESC");
        // dd($data2);
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.index', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'url'  => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.create', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
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
        // dd($request);

        $this->validate(
            $request, 
            [
                'email'           => 'required',
                'username'         => 'required',
                'name'         => 'required',
                'password'             => 'required',
                'role'     => 'required',
            ],
            [  
                'email.required'          => 'อีเมล์จำเป็นต้องระบุข้อมูลค่ะ',
                'username.required'        => 'username จำเป็นต้องระบุข้อมูลค่ะ',
                'name.required'        => 'ชื่อจำเป็นต้องระบุข้อมูลค่ะ',
                'password.required'            => 'password จำเป็นต้องระบุข้อมูลค่ะ',
                'role.required'    => 'role จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            DB::table('account_admin')
            ->insert([
                'email'                => $email,
                'name'                 => $name,
                'username'             => $username,
                'password'             => bcrypt($password),
                'role'                 => $role,
                'active'               => '1',  
                'cost_target'          => $cost_target,
            ]);
            $id = DB::getPdo()->lastInsertId();

            ### Upload (Image)
            if(@$img_name) {
                $file = $request->file('img_name');
                if($file) {

                    ### Parameters
                    $img_id      = $id;
                    $name_upload = $file->getClientOriginalName();
                    $type        = $file->getMimeType();
                    $size        = General::formatSizeUnits($file->getSize());
                    $width       = getimagesize($file->getRealPath())[0];
                    $height      = getimagesize($file->getRealPath())[1];
                    
                    ### Path Real
                    $FileGen    = $img_id.'.'.$file->getClientOriginalExtension();
                    $Path_File  = storage_path('app/public/image/profile/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/banner_slide/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);
                    
                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'img_name'        => $FileGen,
                        'img_name_upload' => $name_upload,
                        'img_type'        => $type,
                        'img_size'        => $size,
                        'img_width'       => $width,
                        'img_height'      => $height
                    ];
                    DB::table('account_admin')->where('id', $img_id)->update($data_img);

                }
            }
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลพนักงาน/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url)->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลพนักงาน/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
        }
    }

    public function edit($id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'id'        => $id,
            'rec'       => \App\Model\dashboard::first_admin($id)
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent' || Auth::user()->role == 'supervisor') {
            return view($this->path_file.'.edit', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function update(Request $request, $id)
    {
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        $this->validate(
            $request, 
            [
                'role'           => 'required',
                'email'         => 'required',
                'name'         => 'required',
                'username'             => 'required',
            ],
            [  
                'role.required'          => 'role จำเป็นต้องระบุข้อมูลค่ะ',
                'email.required'      => 'email จำเป็นต้องระบุข้อมูลค่ะ',
                'name.required'         => 'ชื่อจำเป็นต้องระบุข้อมูลค่ะ',
                'username.required'            => 'username จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            DB::table('account_admin')
            ->where('id',$id)
            ->update([
                'email'                => $email,
                'name'                 => $name,
                'username'             => $username,
                'role'                 => $role,
                'active'               => '1',  
                'cost_target'          => $cost_target,
            ]);

            if($password != '') {
                DB::table('account_admin')
                ->where('id',$id)
                ->update([
                    'password'                => bcrypt($password),
                ]);
            }
            
            if(@$img_name) {
                
                $file = $request->file('img_name');
                if($file) {

                    ### Parameters
                    $img_id      = $id;
                    $name_upload = $file->getClientOriginalName();
                    $type        = $file->getMimeType();
                    $size        = General::formatSizeUnits($file->getSize());
                    $width       = getimagesize($file->getRealPath())[0];
                    $height      = getimagesize($file->getRealPath())[1];
                    
                    ### Path Real
                    $FileGen    = $img_id.'.'.$file->getClientOriginalExtension();
                    $Path_File  = storage_path('app/public/image/profile/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/banner_slide/tmp/');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'img_name'        => $FileGen,
                        'img_name_upload' => $name_upload,
                        'img_type'        => $type,
                        'img_size'        => $size,
                        'img_width'       => $width,
                        'img_height'      => $height
                    ];
                    DB::table('account_admin')->where('id', $img_id)->update($data_img);

                }
            }
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลพนักงาน/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/role/'.$role)->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลพนักงาน/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function admin($ref_id)
    {
        $data = [
            'url'  => $this->url,
            'menu' => 'Role Admin',
            '_title' => 'Role Admin'
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.admin', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables_admin(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_admin(@$request->all(),'admin');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        });
        
        $DBT->editColumn('role', function($col){
            $html = '<span class="label label-success">'.$col->role.'</span>';

            return $html;
        });

        return $DBT->make(true);
    }

    public function merchandize($ref_id)
    {
        $data = [
            'url'  => $this->url,
            'menu' => 'Role Merchandize',
            '_title' => 'Role Merchandize'
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.merchandize', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables_merchandize(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_admin(@$request->all(),'merchandize');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        });
        
        $DBT->editColumn('role', function($col){
            $html = '<span class="label label-success">'.$col->role.'</span>';

            return $html;
        });

        return $DBT->make(true);
    }

    public function supervisor($ref_id)
    {
        $data = [
            'url'  => $this->url,
            'menu' => 'Role Supervisor',
            '_title' => 'Role Supervisor'
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.supervisor', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables_supervisor(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_admin(@$request->all(),'supervisor');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        });
        
        $DBT->editColumn('role', function($col){
            $html = '<span class="label label-success">'.$col->role.'</span>';

            return $html;
        });

        return $DBT->make(true);
    }

    public function fulillment($ref_id)
    {
        $data = [
            'url'  => $this->url,
            'menu' => 'Role Fulillment',
            '_title' => 'Role Fulillment'
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.fulillment', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables_fulillment(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_admin(@$request->all(),'fulillment');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        });
        
        $DBT->editColumn('role', function($col){
            $html = '<span class="label label-success">'.$col->role.'</span>';

            return $html;
        });

        return $DBT->make(true);
    }

    public function agent($ref_id)
    {
        $data = [
            'url'  => $this->url,
            'menu' => 'Role Agent',
            '_title' => 'Role Agent'
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.agent', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables_agent(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_admin(@$request->all(),'agent');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        });

        $DBT->editColumn('cost_target', function($col){
            $html = '
            <div class="form-group has-feedback">  
                <input type="text" placeholder="0" class="form-control input-sm sort" style="width:80%;" value="'.$col->cost_target.'" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อกำหนดยอดเป้าหมาย">
                <span class="glyphicon glyphicon-sort form-control-feedback"></span>
            </div>';

            return $html;
        });  
        
        $DBT->editColumn('role', function($col){
            $html = '<span class="label label-success">'.$col->role.'</span>';

            return $html;
        });

        return $DBT->make(true);
    }

}
