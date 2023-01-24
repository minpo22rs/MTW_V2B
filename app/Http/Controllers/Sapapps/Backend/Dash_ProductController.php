<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Dash_ProductController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_product';
        parent::__construct($this->url);
        $this->path_file .= '.dash_product';
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
                'product_name'           => 'required',
                'product_supplier'           => 'required',
                'product_type'           => 'required',
                'product_category'           => 'required',
                'product_ref_admin'           => 'required',
                'product_attribute'           => 'required',
                'product_unit_price'           => 'required',
                'product_open'           => 'required',
                'product_end'           => 'required',
                'product_active'           => 'required',
            ],
            [  
                'product_name.required'          => 'ชื่อสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_supplier.required'        => 'ชื่อซัพพลายเออร์จำเป็นต้องระบุข้อมูลค่ะ',
                'product_type.required'          => 'ประเภทสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_category.required'        => 'หมวดหมู่สินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_ref_admin.required'          => 'ผู้ดูแลสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_attribute.required'    => 'หน่วยนับสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_unit_price.required'    => 'ราคาต่อหน่วยจำเป็นต้องระบุข้อมูลค่ะ',
                'product_open.required' => 'วันเปิดการขายจำเป็นต้องระบุข้อมูลค่ะ',
                'product_end.required'    => 'วันปิดการขายจำเป็นต้องระบุข้อมูลค่ะ',
                'product_active.required'    => 'สถานะการขายจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_product');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_created_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                }
            }

            // dd($data);
            DB::table('dash_product')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();
            $num = strlen($id);
            $str = '';
            for($i = 0;$i<5-$num;$i++) {
                $str .= '0';
            }
            $year = date('ym');
            DB::table('dash_product')->where('product_id',$id)->update([
                'product_no' => 'EVP'.$year.$str.$id,
            ]);

            

            if(@$product_img_name) {
                $file = $request->file('product_img_name');
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
                    $Path_File  = storage_path('app/public/image/products/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);
                    
                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'product_img_name'        => $FileGen,
                        'product_img_name_upload' => $name_upload,
                        'product_img_type'        => $type,
                        'product_img_size'        => $size,
                        'product_img_width'       => $width,
                        'product_img_height'      => $height
                    ];
                    DB::table('dash_product')->where('product_id', $img_id)->update($data_img);

                }
            }
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูล Product/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูล Product/ID:/Error:'.substr($e->getMessage(),0,180) );
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
    
    public function stock($id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'id'        => $id,
            'rec'       => \App\Model\dashboard::first_product($id)
        ];
        return view($this->path_file.'.stock', $data);
    }
    
    public function stock_input(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }   

        $this->validate(
            $request, 
            [
                'type'                   => 'required',
                'product_stock'           => 'required',
            ],
            [  
                'type.required'                            => 'กรุณาระบุประเภท stock ค่ะ',
                'product_stock.required'          => 'จำนวนสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $check = DB::table('dash_product')
            ->where('product_id',$id)->first();
            if($type == 'in') {
                $num = $check->product_stock + $product_stock;
            }else if($type == 'out') {
                $num = $check->product_stock - $product_stock;
            }
            if($num >= 0) {
                DB::table('dash_product')
                ->where('product_id',$id)
                ->update([
                    'product_stock' => $num,
                ]);
                ## Log
                \App\Model\Log\log_product_stock::log($type,$product_stock,$id);
                \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ Stock Product/ID: '.$id);

                DB::commit();
                return redirect()->to('backend/'.$this->url.'/'.$id.'/stock')->with('success', true)->with('message', ' Complete!');
            }else if($num < 0) {
                ## Log
                $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ Stock Product/ID:/Error:จำนวนสต๊อกไม่ถูกต้อง');

                DB::commit();
                return redirect()->to('backend/'.$this->url.'/'.$id.'/stock')->with('fail', true)->with('message', 'กรุณาเช็คจำนวนสต๊อก');
            }
            
            
        } catch(\Exception $e) {
            
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Product/ID:/Error:'.substr($e->getMessage(),0,180) );
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
            'rec'       => \App\Model\dashboard::first_product($id)
        ];
        
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
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
                'product_name'           => 'required',
                'product_supplier'           => 'required',
                'product_type'           => 'required',
                'product_category'           => 'required',
                'product_ref_admin'           => 'required',
                'product_attribute'           => 'required',
                'product_unit_price'           => 'required',
                'product_open'           => 'required',
                'product_end'           => 'required',
                'product_active'           => 'required',
            ],
            [  
                'product_name.required'          => 'ชื่อสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_supplier.required'        => 'ชื่อซัพพลายเออร์จำเป็นต้องระบุข้อมูลค่ะ',
                'product_type.required'          => 'ประเภทสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_category.required'        => 'หมวดหมู่สินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_ref_admin.required'          => 'ผู้ดูแลสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_attribute.required'    => 'หน่วยนับสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'product_unit_price.required'    => 'ราคาต่อหน่วยจำเป็นต้องระบุข้อมูลค่ะ',
                'product_open.required' => 'วันเปิดการขายจำเป็นต้องระบุข้อมูลค่ะ',
                'product_end.required'    => 'วันปิดการขายจำเป็นต้องระบุข้อมูลค่ะ',
                'product_active.required'    => 'สถานะการขายจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_product');
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

                    ### unset 
                    if(stristr($name,'_img_')) {
                        unset($data[$name]);
                    }
                }
            }

            unset($data['product_id']);
            unset($data['product_no']);
            unset($data['product_stock']);

            //dd($data);
            DB::table('dash_product')
            ->where('product_id',$id)
            ->update($data);

            if(@$product_img_name) {
                $file = $request->file('product_img_name');
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
                    $Path_File  = storage_path('app/public/image/products/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);
                    
                    $file->move($Path_File, $FileGen);
                    
                    $data_img = [
                        'product_img_name'        => $FileGen,
                        'product_img_name_upload' => $name_upload,
                        'product_img_type'        => $type,
                        'product_img_size'        => $size,
                        'product_img_width'       => $width,
                        'product_img_height'      => $height
                    ];
                    DB::table('dash_product')->where('product_id', $img_id)->update($data_img);

                }
            }
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Product/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Product/ID:/Error:'.substr($e->getMessage(),0,180) );
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
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_product');
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
            DB::table('dash_product')
            ->where('product_id',$id)
            ->update($data);
            ## Log
            \App\Model\Log\log_backend_login::log('destroy-product/ID:'.$id);
            return back()->with('success', true)->with('message', ' Delete Complete!');
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_product(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('product_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->product_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        if(Auth::user()->role != 'agent') {
            $DBT->editColumn('manage', function($col){
                
                $html = '<br><a href="'.url('backend/'.$this->url.'/'.$col->product_id.'/stock').'" class="text-danger"><button class="btn btn-sm btn-grd-info">
                        <i class="ti-package"></i>สต็อกสินค้า</button></a>';
                return $html;
            });
        }

        $DBT->editColumn('product_unit_price', function($col){
            
            $html = '฿ '.$col->product_unit_price;
            return $html;
        });

        $DBT->editColumn('product_type', function($col){
            $html = \App\Model\dashboard::type_name($col->product_type);
            return $html;
        });

        $DBT->editColumn('product_category', function($col){
            $html = \App\Model\dashboard::cate_name($col->product_category);
            return $html;
        });

        return $DBT->make(true);
    }

}
