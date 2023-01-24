<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Dash_Product_CategoryController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_product_category';
        parent::__construct($this->url);
        $this->path_file .= '.dash_product_category';
        $this->menu = 'Product Category';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
                'cate_name'           => 'required',
            ],
            [  
                'cate_name.required'          => 'ประเภทสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_product_category');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_created_at_ref_user_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                }
            }

            // dd($data);
            DB::table('dash_product_category')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลหมวดสินค้า/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลหมวดสินค้า/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
        }
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
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'id'        => $id,
            'rec'       => \App\Model\dashboard::first_product_category($id)
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize' || Auth::user()->role == 'fufillment') {
            return view($this->path_file.'.edit', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
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
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        
        $this->validate(
            $request, 
            [
                'cate_name'           => 'required',
            ],
            [  
                'cate_name.required'          => 'ประเภทสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_product_category');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_user_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Set Null
                    if(stristr($name,'_created_at')) {
                        unset($data[$name]);
                    }
                }
            }

            unset($data['cate_id']);

            //dd($data);
            DB::table('dash_product_category')
            ->where('cate_id',$id)
            ->update($data);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลหมวดสินค้า/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลหมวดสินค้า/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
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

    public function delete($id)
    {
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_product_category');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    ### At, Ref
                    if(stristr($name,'_deleted_at')) {
                        $data[$name] = date('Y-m-d H:i:s');
                    }
                    if(stristr($name,'_deleted_at_ref_user_id')) {
                        $data[$name] = @Auth::user()->id;
                    }
                }
            }
            //dd($data);
            DB::table('dash_product_category')
            ->where('cate_id',$id)
            ->update($data);
            ## Log
            \App\Model\Log\log_backend_login::log('destroy-product-category/ID:'.$id);
            return back()->with('success', true)->with('message', ' Delete Complete!');
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_product_category(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('cate_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->cate_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('cate_created_at_ref_user_id', function($col){
            $html = \App\Model\dashboard::name_account($col->cate_created_at_ref_user_id);
            return $html;
        });

        $DBT->editColumn('cate_updated_at_ref_user_id', function($col){
            $html = \App\Model\dashboard::name_account($col->cate_updated_at_ref_user_id);
            return $html;
        });

        return $DBT->make(true);
    }

}
