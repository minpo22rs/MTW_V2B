<?php

namespace App\Http\Controllers\Traceon\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Shop_ProductController extends Controller
{
    public function __construct()
    {
        $this->url  = 'shop_product';
        parent::__construct($this->url);
        $this->path_file .= '.shop_product';
        $this->menu = 'Product';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
                'product_name'                  => 'required',
                'product_name_th'               => 'required',
                'ref_category_id'               => 'required',
                'product_detail'                => 'required',
                'product_detail_th'             => 'required',
                'product_ingredients'           => 'required',
                'product_ingredients_th'        => 'required',
                'product_discount_price'        => 'required',
                'product_attribute'             => 'required',
                'product_value'                 => 'required',
            ],
            [  
                'product_name.required'                 => 'Product จำเป็นต้องระบุข้อมูลค่ะ',
                'product_name_th.required'              => 'ชื่อสินค้า จำเป็นต้องระบุข้อมูลค่ะ',
                'ref_category_id.required'              => 'Category จำเป็นต้องระบุข้อมูลค่ะ',
                'product_detail.required'               => 'Detail จำเป็นต้องระบุข้อมูลค่ะ',
                'product_detail_th.required'            => 'รายละเอียด จำเป็นต้องระบุข้อมูลค่ะ',
                'product_ingredients.required'          => 'Ingredients จำเป็นต้องระบุข้อมูลค่ะ',
                'product_ingredients_th.required'       => 'ส่วนประกอบ จำเป็นต้องระบุข้อมูลค่ะ',
                'product_discount_price.required'       => 'Sale Price จำเป็นต้องระบุข้อมูลค่ะ',
                'product_attribute.required'            => 'Attribute จำเป็นต้องระบุข้อมูลค่ะ',
                'product_value.required'                => 'ปริมาณ/จำนวน จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    if(stristr($name,'product_size')) {
                        $data[$name] = $product_width + $product_long + $product_height;
                    }

                }
            }

            //dd($data);
            DB::table('cag_product')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if(@$ref_category_id) {
                $cate = \App\Model\front_shop::first_category($ref_category_id)->category_topic;
                DB::table('cag_product')
                ->where('product_id',$id)
                ->update([
                    'product_cate_name'     => $cate,
                ]);
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product/ID:/Error:'.substr($e->getMessage(),0,180) );
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
            'rec'       => \App\Model\front_shop::first_product($id)
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
                'product_name'                  => 'required',
                'product_name_th'               => 'required',
                'ref_category_id'               => 'required',
                'product_detail'                => 'required',
                'product_detail_th'             => 'required',
                'product_ingredients'           => 'required',
                'product_ingredients_th'        => 'required',
                'product_discount_price'        => 'required',
                'product_attribute'             => 'required',
                'product_value'                 => 'required',
            ],
            [  
                'product_name.required'                 => 'Product จำเป็นต้องระบุข้อมูลค่ะ',
                'product_name_th.required'              => 'ชื่อสินค้า จำเป็นต้องระบุข้อมูลค่ะ',
                'ref_category_id.required'              => 'Category จำเป็นต้องระบุข้อมูลค่ะ',
                'product_detail.required'               => 'Detail จำเป็นต้องระบุข้อมูลค่ะ',
                'product_detail_th.required'            => 'รายละเอียด จำเป็นต้องระบุข้อมูลค่ะ',
                'product_ingredients.required'          => 'Ingredients จำเป็นต้องระบุข้อมูลค่ะ',
                'product_ingredients_th.required'       => 'ส่วนประกอบ จำเป็นต้องระบุข้อมูลค่ะ',
                'product_discount_price.required'       => 'Sale Price จำเป็นต้องระบุข้อมูลค่ะ',
                'product_attribute.required'            => 'Attribute จำเป็นต้องระบุข้อมูลค่ะ',
                'product_value.required'                => 'ปริมาณ/จำนวน จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product');
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

                    if(stristr($name,'product_size')) {
                        $data[$name] = $product_width + $product_long + $product_height;
                    }
                }
            }

            unset($data['product_id']);

            //dd($data);
            DB::table('cag_product')
            ->where('product_id',$id)
            ->update($data);

            if(@$ref_category_id) {
                $cate = \App\Model\front_shop::first_category($ref_category_id)->category_topic;
                DB::table('cag_product')
                ->where('product_id',$id)
                ->update([
                    'product_cate_name'     => $cate,
                ]);
            }
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product/ID:/Error:'.substr($e->getMessage(),0,180) );
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
        $columns = DB::getSchemaBuilder()->getColumnListing('cag_product');
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
        DB::table('cag_product')
        ->where('product_id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log('product/destroy-cag_product/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\front_shop::datatables_product(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('product_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->product_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('product_active', function($col){
            if($col->product_active == '1') {
                $html = '<button class="btn btn-mat btn-success btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น Off">On</button>';
            } else {
                $html = '<button class="btn btn-mat btn-danger btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น On">Off</button>';
            }

            return $html;
        });  

        $DBT->editColumn('product_sort', function($col){
            $html = '
            <div class="form-group has-feedback">  
                <input type="text" placeholder="0" class="form-control input-sm sort" style="width:50px;" value="'.$col->product_sort.'" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อเรียงลำดับ 1 - 99">
                <span class="glyphicon glyphicon-sort form-control-feedback"></span>
            </div>';

            return $html;
        }); 

        $DBT->editColumn('product_type', function($col){
            if($col->product_type == 'bundle') {
                $html = '<button class="btn btn-mat btn-warning btn-mini" data-toggle="tooltip">'.$col->product_type.'</button>';
            }else {
                $html = '<button class="btn btn-mat btn-info btn-mini" data-toggle="tooltip">'.$col->product_type.'</button>';
            }

            return $html;
        }); 

        $DBT->editColumn('product_cate_name', function($col){
                
            $html = '<button class="btn btn-mat btn-danger btn-mini" data-toggle="tooltip">'.$col->product_cate_name.'</button>';

            return $html;
        }); 

        $DBT->editColumn('product_more', function($col){

            $html = '<br><a href="'.url('backend/'.$this->url.'/'.$col->product_id.'/property').'" class="text-danger"><button class="btn btn-sm btn-grd-primary">
                    <i class="icofont icofont-edit"></i> จัดการ Property</button></a>';
            $html .= '&nbsp;&nbsp;&nbsp;<a href="'.url('backend/'.$this->url.'/'.$col->product_id.'/color').'" class="text-danger"><button class="btn btn-sm btn-grd-warning">
                    <i class="icofont icofont-edit"></i> จัดการสี</button></a>';
            $html .= '&nbsp;&nbsp;&nbsp;<a href="'.url('backend/'.$this->url.'/'.$col->product_id.'/more').'" class="text-danger"><button class="btn btn-sm btn-grd-info">
                    <i class="icofont icofont-edit"></i> จัดการข้อมูลเพิ่มเติม</button></a>';
            $html .= '&nbsp;&nbsp;&nbsp;<a href="'.url('backend/'.$this->url.'/'.$col->product_id.'/image').'" class="text-danger"><button class="btn btn-sm btn-grd-danger">
                    <i class="icofont icofont-edit"></i> จัดการข้อมูลรูปภาพ</button></a>';
            return $html;
        }); 

        return $DBT->make(true);
    }

    ////////////////Property//////////////////////////////////

    public function property($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];

        $data['menu'] .= ' > '.$data['rec']->product_name ;

        return view($this->path_file.'.property', $data);
    }

    public function property_create($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];
        

        $data['menu'] .= ' > '.$data['rec']->product_name;

        return view($this->path_file.'.property_create', $data);
    }

    public function property_store(Request $request, $ref_id)
    {
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        if(!@$ref_id) {
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ เนื่องจากไม่มี Ref ID อ้างอิงค่ะ');
        }

        $this->validate(
            $request, 
            [   
                'property_content'      => 'required',
                'property_content_th'   => 'required',
            ],
            [   
                'property_content.required'         => 'Property จำเป็นต้องระบุข้อมูลค่ะ',        
                'property_content_th.required'      => 'คุณสมบัติ จำเป็นต้องระบุข้อมูลค่ะ',   
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_property');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Ref
                    if(stristr($name,'ref_product_id')) {
                        $data[$name] = $ref_id;
                    }

                }
            }

            //dd($data);
            DB::table('cag_product_property')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_property/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/property/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_property/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function property_edit($ref_id,$id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec_ref'   => \App\Model\front_shop::first_product($ref_id),
            'id'        => $id,
            'rec'       => \App\Model\front_shop::first_property($id)
        ];

        $data['menu'] .= ' > '.$data['rec_ref']->product_name;

        return view($this->path_file.'.property_edit', $data);
    }

    public function property_update(Request $request, $ref_id, $id)
    {
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        $this->validate(
            $request, 
            [   
                'property_content'      => 'required',
                'property_content_th'   => 'required',
            ],
            [   
                'property_content.required'         => 'Property จำเป็นต้องระบุข้อมูลค่ะ',        
                'property_content_th.required'      => 'คุณสมบัติ จำเป็นต้องระบุข้อมูลค่ะ',   
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_property');
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

            unset($data['ref_product_id'],$data['property_id']);

            //dd($data);
            DB::table('cag_product_property')
            ->where('property_id',$id)
            ->update($data);

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_property/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/property/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_property/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function property_delete($ref_id, $id)
    {
        $data = [];
        $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_property');
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
        DB::table('cag_product_property')
        ->where('property_id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log($this->url.'/destroy-cag_product_property/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables_property(Request $request)
    {
        $tbl = \App\Model\front_shop::datatables_property(@$request->all(),$request->get('ref_id'));
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('property_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->property_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('property_active', function($col){
            if($col->property_active == '1') {
                $html = '<button class="btn btn-mat btn-success btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น Off">On</button>';
            } else {
                $html = '<button class="btn btn-mat btn-danger btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น On">Off</button>';
            }

            return $html;
        });  

        $DBT->editColumn('property_sort', function($col){
            $html = '
            <div class="form-group has-feedback">  
                <input type="text" placeholder="0" class="form-control input-sm sort" style="width:50px;" value="'.$col->property_sort.'" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อเรียงลำดับ 1 - 99">
                <span class="glyphicon glyphicon-sort form-control-feedback"></span>
            </div>';

            return $html;
        });  

        return $DBT->make(true);
    }

    ////////////////Color//////////////////////////////////

    public function color($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];

        $data['menu'] .= ' > '.$data['rec']->product_name ;

        return view($this->path_file.'.color', $data);
    }

    public function color_create($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];
        

        $data['menu'] .= ' > '.$data['rec']->product_name;

        return view($this->path_file.'.color_create', $data);
    }

    public function color_store(Request $request, $ref_id)
    {
        //dd($request);
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        if(!@$ref_id) {
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ เนื่องจากไม่มี Ref ID อ้างอิงค่ะ');
        }

        $this->validate(
            $request, 
            [
                'ref_master_color_id'       => 'required',
            ],
            [  
                'ref_master_color_id.required'      => 'Color จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_color');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Ref
                    if(stristr($name,'ref_product_id')) {
                        $data[$name] = $ref_id;
                    }
                }
            }

            //dd($data);
            DB::table('cag_product_color')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if(@$ref_master_color_id != '') {
                $code = \App\Model\master::first_color($ref_master_color_id)->color_code; 
                $color = \App\Model\master::first_color($ref_master_color_id)->color_name; 
                DB::table('cag_product_color')->where('color_id', $id)->update([
                    'color_name'  =>  $color,
                    'color_code'  =>  $code,
                ]);
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_color/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/color/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_color/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function color_edit($ref_id,$id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec_ref'   => \App\Model\front_shop::first_product($ref_id),
            'id'        => $id,
            'rec'       => \App\Model\front_shop::first_color($id)
        ];

        $data['menu'] .= ' > '.$data['rec_ref']->product_name;

        return view($this->path_file.'.color_edit', $data);
    }

    public function color_update(Request $request, $ref_id, $id)
    {
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        $this->validate(
            $request, 
            [
                'ref_master_color_id'       => 'required',
            ],
            [  
                'ref_master_color_id.required'      => 'Color จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_color');
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

            unset($data['ref_product_id'],$data['color_id']);

            //dd($data);
            DB::table('cag_product_color')
            ->where('color_id',$id)
            ->update($data);

            if(@$ref_master_color_id != '') {
                $code = \App\Model\master::first_color($ref_master_color_id)->color_code; 
                $color = \App\Model\master::first_color($ref_master_color_id)->color_name; 
                DB::table('cag_product_color')->where('color_id', $id)->update([
                    'color_name'  =>  $color,
                    'color_code'  =>  $code,
                ]);
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_color/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/color/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_color/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function color_delete($ref_id, $id)
    {
        $data = [];
        $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_color');
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
        DB::table('cag_product_color')
        ->where('color_id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log($this->url.'/destroy-cag_product_color/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables_color(Request $request)
    {
        $tbl = \App\Model\front_shop::datatables_color(@$request->all(),$request->get('ref_id'));
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('color_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->color_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('color_active', function($col){
            if($col->color_active == '1') {
                $html = '<button class="btn btn-mat btn-success btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น Off">On</button>';
            } else {
                $html = '<button class="btn btn-mat btn-danger btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น On">Off</button>';
            }

            return $html;
        });  

        $DBT->editColumn('color_sort', function($col){
            $html = '
            <div class="form-group has-feedback">  
                <input type="text" placeholder="0" class="form-control input-sm sort" style="width:50px;" value="'.$col->color_sort.'" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อเรียงลำดับ 1 - 99">
                <span class="glyphicon glyphicon-sort form-control-feedback"></span>
            </div>';

            return $html;
        }); 
        
        $DBT->editColumn('color_code', function($col){
            $html = '
            <button type="button" class="btn" style="width:100px; background:'.$col->color_code.'"></button>';

            return $html;
        });  

        return $DBT->make(true);
    }

    ////////////////Image//////////////////////////////////

    public function image($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];

        $data['menu'] .= ' > '.$data['rec']->product_name ;

        return view($this->path_file.'.image', $data);
    }

    public function image_create($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];
        

        $data['menu'] .= ' > '.$data['rec']->product_name;

        return view($this->path_file.'.image_create', $data);
    }

    public function image_store(Request $request, $ref_id)
    {
        //dd($request);
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        if(!@$ref_id) {
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ เนื่องจากไม่มี Ref ID อ้างอิงค่ะ');
        }

        $this->validate(
            $request, 
            [
                'image_img_name'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5120kb = 5mb
            ],
            [  
                'image_img_name.required'    => 'Image จำเป็นต้องระบุข้อมูลค่ะ',
                'image_img_name.image'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพเท่านั้นค่ะ',
                'image_img_name.mimes'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพนามสกุล :values เท่านั้นค่ะ',
                'image_img_name.max'         => 'Image รบกวนใช้ไฟล์ขนาดไม่เกิน :max kilobytes ค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_image');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Ref
                    if(stristr($name,'ref_product_id')) {
                        $data[$name] = $ref_id;
                    }

                    ### unset 
                    if(stristr($name,'_img_')) {
                        unset($data[$name]);
                    }

                }
            }

            //dd($data);
            DB::table('cag_product_image')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if(@$ref_color_id != '') {
                $code = \App\Model\front_shop::first_color($ref_color_id)->color_code; 
                $color = \App\Model\front_shop::first_color($ref_color_id)->color_name; 
                DB::table('cag_product_image')->where('image_id', $id)->update([
                    'image_color_name'  =>  $color,
                    'image_color_code'  =>  $code,
                ]);
            }

            if(@$image_img_name) {
                $file = $request->file('image_img_name');
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
                    $Path_File  = storage_path('app/public/image/product/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);
                    
                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'image_img_name'        => $FileGen,
                        'image_img_name_upload' => $name_upload,
                        'image_img_type'        => $type,
                        'image_img_size'        => $size,
                        'image_img_width'       => $width,
                        'image_img_height'      => $height
                    ];
                    DB::table('cag_product_image')->where('image_id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_image/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/image/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_image/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function image_edit($ref_id,$id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec_ref'   => \App\Model\front_shop::first_product($ref_id),
            'id'        => $id,
            'rec'       => \App\Model\front_shop::first_image($id)
        ];

        $data['menu'] .= ' > '.$data['rec_ref']->product_name;

        return view($this->path_file.'.image_edit', $data);
    }

    public function image_update(Request $request, $ref_id, $id)
    {
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        $this->validate(
            $request, 
            [
                'image_img_name'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5120kb = 5mb
            ],
            [  
                'image_img_name.image'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพเท่านั้นค่ะ',
                'image_img_name.mimes'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพนามสกุล :values เท่านั้นค่ะ',
                'image_img_name.max'         => 'Image รบกวนใช้ไฟล์ขนาดไม่เกิน :max kilobytes ค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_image');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### unset 
                    if(stristr($name,'_img_')) {
                        unset($data[$name]);
                    }

                    ### Set Null
                    if(stristr($name,'_created_at')) {
                        unset($data[$name]);
                    }
                }
            }

            unset($data['ref_product_id'],$data['image_id']);

            //dd($data);
            DB::table('cag_product_image')
            ->where('image_id',$id)
            ->update($data);

            if(@$ref_color_id != '') {
                $code = \App\Model\front_shop::first_color($ref_color_id)->color_code; 
                $color = \App\Model\front_shop::first_color($ref_color_id)->color_name; 
                DB::table('cag_product_image')->where('image_id', $id)->update([
                    'image_color_name'  =>  $color,
                    'image_color_code'  =>  $code,
                ]);
            }

            if(@$image_img_name) {
                $file = $request->file('image_img_name');
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
                    $Path_File  = storage_path('app/public/image/product/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);
                    
                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'image_img_name'        => $FileGen,
                        'image_img_name_upload' => $name_upload,
                        'image_img_type'        => $type,
                        'image_img_size'        => $size,
                        'image_img_width'       => $width,
                        'image_img_height'      => $height
                    ];
                    DB::table('cag_product_image')->where('image_id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_image/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/image/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_image/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function image_delete($ref_id, $id)
    {
        $data = [];
        $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_image');
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
        DB::table('cag_product_image')
        ->where('image_id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log($this->url.'/destroy-cag_product_image/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables_image(Request $request)
    {
        $tbl = \App\Model\front_shop::datatables_image(@$request->all(),$request->get('ref_id'));
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('image_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->image_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('image_active', function($col){
            if($col->image_active == '1') {
                $html = '<button class="btn btn-mat btn-success btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น Off">On</button>';
            } else {
                $html = '<button class="btn btn-mat btn-danger btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น On">Off</button>';
            }

            return $html;
        });  

        $DBT->editColumn('image_sort', function($col){
            $html = '
            <div class="form-group has-feedback">  
                <input type="text" placeholder="0" class="form-control input-sm sort" style="width:50px;" value="'.$col->image_sort.'" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อเรียงลำดับ 1 - 99">
                <span class="glyphicon glyphicon-sort form-control-feedback"></span>
            </div>';

            return $html;
        }); 

        $DBT->editColumn('image_img_name', function($col){
            $html = '<img src="'.asset('storage/app/public/image/product/'.$col->image_img_name).'" title="'.$col->image_img_name.'" width="25%">';
            return $html;
        });  

        $DBT->editColumn('image_color_code', function($col){
            $html = '
            <button type="button" class="btn" style="width:100px; background:'.$col->image_color_code.'"></button>';

            return $html;
        }); 

        return $DBT->make(true);
    }

    ////////////////More//////////////////////////////////

    public function more($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];

        $data['menu'] .= ' > '.$data['rec']->product_name ;

        return view($this->path_file.'.more', $data);
    }

    public function more_create($ref_id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec'       => \App\Model\front_shop::first_product($ref_id)
        ];
        

        $data['menu'] .= ' > '.$data['rec']->product_name;

        return view($this->path_file.'.more_create', $data);
    }

    public function more_store(Request $request, $ref_id)
    {
        //dd($request);
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        if(!@$ref_id) {
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ เนื่องจากไม่มี Ref ID อ้างอิงค่ะ');
        }

        $this->validate(
            $request, 
            [
                'more_topic'        => 'required',
                'more_topic_th'     => 'required',
                'more_img_name'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5120kb = 5mb
            ],
            [  
                'more_img_name.required'    => 'Image จำเป็นต้องระบุข้อมูลค่ะ',
                'more_img_name.image'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพเท่านั้นค่ะ',
                'more_img_name.mimes'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพนามสกุล :values เท่านั้นค่ะ',
                'more_img_name.max'         => 'Image รบกวนใช้ไฟล์ขนาดไม่เกิน :max kilobytes ค่ะ',
                'more_topic.required'       => 'Topic จำเป็นต้องระบุข้อมูลค่ะ',
                'more_topic_th.required'    => 'หัวข้อ จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_more');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Ref
                    if(stristr($name,'ref_product_id')) {
                        $data[$name] = $ref_id;
                    }

                    ### unset 
                    if(stristr($name,'_img_')) {
                        unset($data[$name]);
                    }

                }
            }

            //dd($data);
            DB::table('cag_product_more')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if(@$more_img_name) {
                $file = $request->file('more_img_name');
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
                    $Path_File  = storage_path('app/public/image/more/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);
                    
                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'more_img_name'        => $FileGen,
                        'more_img_name_upload' => $name_upload,
                        'more_img_type'        => $type,
                        'more_img_size'        => $size,
                        'more_img_width'       => $width,
                        'more_img_height'      => $height
                    ];
                    DB::table('cag_product_more')->where('more_id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_more/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/more/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_more/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function more_edit($ref_id,$id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'ref_id'    => $ref_id,
            'rec_ref'   => \App\Model\front_shop::first_product($ref_id),
            'id'        => $id,
            'rec'       => \App\Model\front_shop::first_more($id)
        ];

        $data['menu'] .= ' > '.$data['rec_ref']->product_name;

        return view($this->path_file.'.more_edit', $data);
    }

    public function more_update(Request $request, $ref_id, $id)
    {
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        $this->validate(
            $request, 
            [
                'more_topic'        => 'required',
                'more_topic_th'     => 'required',
                'more_img_name'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5120kb = 5mb
            ],
            [  
                'more_img_name.image'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพเท่านั้นค่ะ',
                'more_img_name.mimes'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพนามสกุล :values เท่านั้นค่ะ',
                'more_img_name.max'         => 'Image รบกวนใช้ไฟล์ขนาดไม่เกิน :max kilobytes ค่ะ',
                'more_topic.required'       => 'Topic จำเป็นต้องระบุข้อมูลค่ะ',
                'more_topic_th.required'    => 'หัวข้อ จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_more');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### unset 
                    if(stristr($name,'_img_')) {
                        unset($data[$name]);
                    }

                    ### Set Null
                    if(stristr($name,'_created_at')) {
                        unset($data[$name]);
                    }
                }
            }

            unset($data['ref_product_id'],$data['more_id']);

            //dd($data);
            DB::table('cag_product_more')
            ->where('more_id',$id)
            ->update($data);

            if(@$more_img_name) {
                $file = $request->file('more_img_name');
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
                    $Path_File  = storage_path('app/public/image/more/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);
                    
                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'more_img_name'        => $FileGen,
                        'more_img_name_upload' => $name_upload,
                        'more_img_type'        => $type,
                        'more_img_size'        => $size,
                        'more_img_width'       => $width,
                        'more_img_height'      => $height
                    ];
                    DB::table('cag_product_more')->where('more_id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_more/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$ref_id.'/more/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/update-cag_product_more/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }

    public function more_delete($ref_id, $id)
    {
        $data = [];
        $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_more');
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
        DB::table('cag_product_more')
        ->where('more_id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log($this->url.'/destroy-cag_product_more/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables_more(Request $request)
    {
        $tbl = \App\Model\front_shop::datatables_more(@$request->all(),$request->get('ref_id'));
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('more_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->more_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('more_active', function($col){
            if($col->more_active == '1') {
                $html = '<button class="btn btn-mat btn-success btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น Off">On</button>';
            } else {
                $html = '<button class="btn btn-mat btn-danger btn-mini active" data-toggle="tooltip" data-original-title="คลิ๊กเปลี่ยนเป็น On">Off</button>';
            }

            return $html;
        });  

        $DBT->editColumn('more_sort', function($col){
            $html = '
            <div class="form-group has-feedback">  
                <input type="text" placeholder="0" class="form-control input-sm sort" style="width:50px;" value="'.$col->more_sort.'" data-toggle="tooltip" data-original-title="ใส่เลขเพื่อเรียงลำดับ 1 - 99">
                <span class="glyphicon glyphicon-sort form-control-feedback"></span>
            </div>';

            return $html;
        });  

        $DBT->editColumn('more_type', function($col){
            if($col->more_type == 'text') {
                $html = '<button class="btn btn-mat btn-primary btn-mini" data-toggle="tooltip">Text</button>';
            }else if($col->more_type == 'ul') {
                $html = '<button class="btn btn-mat btn-danger btn-mini" data-toggle="tooltip">Option</button>';
            }
            return $html;
        });

        $DBT->editColumn('more_img_name', function($col){
            $html = '<img src="'.asset('storage/app/public/image/more/'.$col->more_img_name).'" title="'.$col->more_img_name.'" width="50%">';
            return $html;
        });  

        $DBT->editColumn('more_topic', function($col){
            $html = $col->more_topic.'<hr>'.$col->more_topic_th;
            return $html;
        });

        $DBT->editColumn('more_content', function($col){
            $html = $col->more_content.'<hr>'.$col->more_content_th;
            return $html;
        });

        return $DBT->make(true);
    }

}