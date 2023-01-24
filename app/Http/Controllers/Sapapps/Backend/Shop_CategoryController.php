<?php

namespace App\Http\Controllers\Traceon\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Shop_CategoryController extends Controller
{
    public function __construct()
    {
        $this->url  = 'shop_category';
        parent::__construct($this->url);
        $this->path_file .= '.shop_category';
        $this->menu = 'Category';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
        return view($this->path_file.'.create', $data);
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


        $this->validate(
            $request, 
            [
                'category_topic'     => 'required',
            ],
            [  
                'category_topic.required'    => 'Topic จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_category');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                }
            }

            //dd($data);
            DB::table('cag_category')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/store-cag_category/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/store-cag_category/ID:/Error:'.substr($e->getMessage(),0,180) );
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
            'rec'       => \App\Model\front_shop::first_category($id)
        ];
        return view($this->path_file.'.edit', $data);
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
                'category_topic'     => 'required',
            ],
            [  
                'category_topic.required'    => 'Topic จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_category');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Set Null
                    if(stristr($name,'_created_at')) {
                        unset($data[$name]);
                    }
                }
            }

            unset($data['category_id']);

            //dd($data);
            DB::table('cag_category')
            ->where('category_id',$id)
            ->update($data);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/update-cag_category/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/update-cag_category/ID:/Error:'.substr($e->getMessage(),0,180) );
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
        $data = [];
        $columns = DB::getSchemaBuilder()->getColumnListing('cag_category');
        $count_columns = count($columns);
        if($columns) {
            foreach ($columns as $key => $name) {
                ### At, Ref
                if(stristr($name,'_deleted_at')) {
                    $data[$name] = date('Y-m-d H:i:s');
                }
                if(stristr($name,'_deleted_at_ref_admin_id')) {
                    $data[$name] = @Auth::user()->id;
                }
            }
        }
        //dd($data);
        DB::table('cag_category')
        ->where('category_id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log('category/destroy-cag_category/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\front_shop::datatables_category(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('category_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->category_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('category_active', function($col){
            if($col->category_active == '1') {
                $html = '<button class="btn btn-mat btn-success btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น Off">On</button>';
            } else {
                $html = '<button class="btn btn-mat btn-danger btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น On">Off</button>';
            }

            return $html;
        });  

        $DBT->editColumn('category_sort', function($col){
            $html = '
            <div class="form-group has-feedback">  
                <input type="text" placeholder="0" class="form-control input-sm sort" style="width:50px;" value="'.$col->category_sort.'" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อเรียงลำดับ 1 - 99">
                <span class="glyphicon glyphicon-sort form-control-feedback"></span>
            </div>';

            return $html;
        }); 

        return $DBT->make(true);
    }

}
