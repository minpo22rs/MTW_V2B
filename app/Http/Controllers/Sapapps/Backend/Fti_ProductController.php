<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Fti_ProductController extends Controller
{
    public function __construct()
    {
        $this->url = 'fti_product';
        parent::__construct($this->url);
        $this->path_file .= '.fti_product';
        $this->menu = 'ข้อมูลสินค้า'; //\App\Model\Menu::get_menu_name($this->url)['menu'];
        $this->menu_right = ''; //\App\Model\Menu::get_menu_name($this->url)['menu_right'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'url' => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
        ];
        return view($this->path_file . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'url' => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
        ];

        if (Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file . '.create', $data);
        } else {
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
            ${$key} = $value;
        }
        // dd($request);

        $this->validate(
            $request,
            [
                'product_name' => 'required',
                'category' => 'required',
                'short_descrip' => 'required',
                'full_descrip' => 'required',
                'unit_price' => 'required',
                'sale_price' => 'required',
                'product_img_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ],
            [
                'product_name.required' => 'ชื่อสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'category.required' => 'หมวดหมู่สินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'short_descrip.required' => 'รายละเอียดโดยย่อจำเป็นต้องระบุข้อมูลค่ะ',
                'full_descrip.required' => 'รายละเอียดเต็มจำเป็นต้องระบุข้อมูลค่ะ',
                'unit_price.required' => 'ราคาต่อหน่วยจำเป็นต้องระบุข้อมูลค่ะ',
                'sale_price.required' => 'ราคาขายจำเป็นต้องระบุข้อมูลค่ะ',
                'product_img_name.required' => 'Image จำเป็นต้องระบุข้อมูลค่ะ',
                'product_img_name.image' => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพเท่านั้นค่ะ',
                'product_img_name.mimes' => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพนามสกุล :values เท่านั้นค่ะ',
                'product_img_name.max' => 'Image รบกวนใช้ไฟล์ขนาดไม่เกิน :max kilobytes ค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('fti_product');
            $count_columns = count($columns);
            if ($columns) {
                foreach ($columns as $key => $name) {

                    $data[$name] = @${$name};

                    ### At, Ref
                    if (stristr($name, 'updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    if (stristr($name, 'merchandize')) {
                        $data[$name] = @Auth::user()->id;
                    }

                }
            }

            // dd($data);
            DB::table('fti_product')
                ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if (@$product_img_name) {
                $file = $request->file('product_img_name');
                if ($file) {

                    ### Parameters
                    $img_id = $id;
                    $name_upload = $file->getClientOriginalName();
                    $type = $file->getMimeType();
                    $fileSize = filesize($file->getRealPath());
                    if ($fileSize < 1024) {
                        $size = $fileSize . ' bytes';

                    } elseif ($fileSize < 1048576) {
                        $size = round($fileSize / 1024, 2) . ' KB';

                    } else {
                        $size = round($fileSize / 1048576, 2) . ' MB';

                    }
                    // $size        = General::formatSizeUnits($file->getSize());

                    $width = getimagesize($file->getRealPath())[0];
                    $height = getimagesize($file->getRealPath())[1];

                    ### Path Real
                    $FileGen = $img_id . '.' . $file->getClientOriginalExtension();
                    $Path_File = storage_path('app/public/image/products/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);

                    $data_img = [
                        'product_img_name' => $FileGen,
                        'product_img_name_upload' => $name_upload,
                        'product_img_type' => $type,
                        // 'product_img_size'        => $size,
                        'product_img_width' => $width,
                        'product_img_height' => $height,
                    ];

                    DB::table('fti_product')->where('id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url . '/เพิ่มข้อมูลสินค้า/ID: ' . $id);

            DB::commit();
            return redirect()->to('backend/' . $this->url)->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url . '/เพิ่มข้อมูลสินค้า/ID:/Error:' . $e->getMessage());
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message', 'ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:' . $log_code);
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
            'url' => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
            'id' => $id,
            'rec' => \App\Model\dashboard::first_product($id),
        ];
        return view($this->path_file . '.stock', $data);
    }

    public function stock_input(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            ${$key} = $value;
        }

        $this->validate(
            $request,
            [
                'type' => 'required',
                'product_stock' => 'required',
            ],
            [
                'type.required' => 'กรุณาระบุประเภท stock ค่ะ',
                'product_stock.required' => 'จำนวนสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $check = DB::table('dash_product')
                ->where('product_id', $id)->first();
            if ($type == 'in') {
                $num = $check->product_stock + $product_stock;
            } else if ($type == 'out') {
                $num = $check->product_stock - $product_stock;
            }
            if ($num >= 0) {
                DB::table('dash_product')
                    ->where('product_id', $id)
                    ->update([
                        'product_stock' => $num,
                    ]);
                ## Log
                \App\Model\Log\log_product_stock::log($type, $product_stock, $id);
                \App\Model\Log\log_backend_login::log($this->url . '/แก้ไข้ Stock Product/ID: ' . $id);

                DB::commit();
                return redirect()->to('backend/' . $this->url . '/' . $id . '/stock')->with('success', true)->with('message', ' Complete!');
            } else if ($num < 0) {
                ## Log
                $log_code = \App\Model\Log\log_backend_login::log($this->url . '/แก้ไข้ Stock Product/ID:/Error:จำนวนสต๊อกไม่ถูกต้อง');

                DB::commit();
                return redirect()->to('backend/' . $this->url . '/' . $id . '/stock')->with('fail', true)->with('message', 'กรุณาเช็คจำนวนสต๊อก');
            }

        } catch (\Exception $e) {

            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url . '/แก้ไข้ข้อมูล Product/ID:/Error:' . substr($e->getMessage(), 0, 180));
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message', 'ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:' . $log_code);
        }
    }

    public function edit($id)
    {
        $data = [
            'url' => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
            'id' => $id,
            'rec' => \App\Model\dashboard::first_product($id),
        ];

        if (Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file . '.edit', $data);
        } else {
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
            ${$key} = $value;
        }

        $this->validate(
            $request,
            [
                'product_name' => 'required',
                'category' => 'required',
                'short_descrip' => 'required',
                'full_descrip' => 'required',
                'unit_price' => 'required',
                'sale_price' => 'required',
            ],
            [
                'product_name.required' => 'ชื่อสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'category.required' => 'หมวดหมู่สินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'short_descrip.required' => 'รายละเอียดโดยย่อจำเป็นต้องระบุข้อมูลค่ะ',
                'full_descrip.required' => 'รายละเอียดเต็มจำเป็นต้องระบุข้อมูลค่ะ',
                'unit_price.required' => 'ราคาต่อหน่วยจำเป็นต้องระบุข้อมูลค่ะ',
                'sale_price.required' => 'ราคาขายจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {

            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('fti_product');
            $count_columns = count($columns);
            if ($columns) {
                foreach ($columns as $key => $name) {

                    $data[$name] = @${$name};

                    ### At, Ref
                    if (stristr($name, 'updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Set Null
                    if (stristr($name, 'created_at')) {
                        unset($data[$name]);
                    }

                    ### unset
                    if (stristr($name, '_img_')) {
                        unset($data[$name]);
                    }
                }
            }

            unset($data['id']);

            //dd($data);
            DB::table('fti_product')
                ->where('id', $id)
                ->update($data);

            if (@$product_img_name) {
                $file = $request->file('product_img_name');
                if ($file) {

                    ### Parameters
                    $img_id = $id;
                    $name_upload = $file->getClientOriginalName();
                    $type = $file->getMimeType();
                    $fileSize = filesize($file->getRealPath());
                    if ($fileSize < 1024) {
                        $size = $fileSize . ' bytes';

                    } elseif ($fileSize < 1048576) {
                        $size = round($fileSize / 1024, 2) . ' KB';

                    } else {
                        $size = round($fileSize / 1048576, 2) . ' MB';

                    }
                    // $size        = General::formatSizeUnits($file->getSize());
                    $width = getimagesize($file->getRealPath())[0];
                    $height = getimagesize($file->getRealPath())[1];

                    ### Path Real
                    $FileGen = $img_id . '.' . $file->getClientOriginalExtension();

                    $Path_File = storage_path('app/public/image/products/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);

                    $data_img = [
                        'product_img_name' => $FileGen,
                        'product_img_name_upload' => $name_upload,
                        'product_img_type' => $type,
                        'product_img_size' => $size,
                        'product_img_width' => $width,
                        'product_img_height' => $height,
                    ];
                    DB::table('fti_product')->where('id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url . '/แก้ไข้ข้อมูลสินค้า/ID: ' . $id);

            DB::commit();
            return redirect()->to('backend/' . $this->url . '/' . $id . '/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url . '/แก้ไข้ข้อมูลสินค้า/ID:/Error:' . substr($e->getMessage(), 0, 180));
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message', 'ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:' . $log_code);

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
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('fti_product');
            $count_columns = count($columns);
            if ($columns) {
                foreach ($columns as $key => $name) {
                    ### At, Ref
                    if (stristr($name, 'deleted_at')) {
                        $data[$name] = date('Y-m-d H:i:s');
                    }
                    if (stristr($name, 'deleted_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }
                }
            }
            //dd($data);
            DB::table('fti_product')
                ->where('id', $id)
                ->update($data);
            ## Log
            \App\Model\Log\log_backend_login::log('ลบข้อมูลสินค้า/ID:' . $id);
            return back()->with('success', true)->with('message', ' Delete Complete!');
        } else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\datatables::datatables_product(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function ($col) {
            $html = $col->id;
            return $html;
        });

        $DBT->editColumn('unit_price', function ($col) {

            $html = '฿ ' . $col->unit_price;
            return $html;
        });

        $DBT->editColumn('sale_price', function ($col) {

            $html = '฿ ' . $col->sale_price;
            return $html;
        });

        // $DBT->editColumn('product_type', function($col){
        //     $html = \App\Model\dashboard::type_name($col->product_type);
        //     return $html;
        // });

        $DBT->editColumn('category', function ($col) {
            $html = \App\Model\dashboard::cate_name($col->category);
            return $html;
        });

        $DBT->editColumn('product_img_name', function ($col) {
            $html = '<img src="' . asset('storage/app/public/image/products/' . $col->product_img_name) . '" title="' . $col->product_img_name . '" width="20%">';
            return $html;
        });

        $DBT->editColumn('updated_at_ref_admin_id', function ($col) {
            $html = '<span class="badge rounded-pill badge-glow bg-imfo">' . \App\Model\dashboard::name_account($col->updated_at_ref_admin_id) . '</span>';
            return $html;
        });

        $DBT->editColumn('manage', function ($col) {

            $html = '
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="' . url('backend/' . $this->url . '/' . $col->id . '/edit') . '" class="btn btn-gradient-warning" style="color:white;">แก้ไข</a>
                <a href="' . url('backend/' . $this->url . '/' . $col->id . '/imageslide') . '" class="btn btn-gradient-dark" style="color:white;">รูปภาพ</a>
                <button type="button" class="btn btn-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleted' . $col->id . '" style="color:white;">ลบ</button>
            </div>
            <div class="modal fade modal-danger text-start" id="deleted' . $col->id . '" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel120">ลบสินค้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">ยืนยันที่จะลบ " ' . $col->product_name . '" หรือไม่?
                        </div>
                        <div class="modal-footer">
                            <form action="' . url('backend/' . $this->url . '/' . $col->id . '/delete') . '" method="get">
                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Accept</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
            return $html;
        });

        return $DBT->make(true);
    }

    public function imageslide($id)
    {

        $product = \App\Model\dashboard::first_product($id);
        $data = [
            'url' => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
            'product' => $product->product_name,
            'id' => $id,
        ];
        return view($this->path_file . '.imageslide', $data);
    }

    public function image_store(Request $request, $ref_id)
    {
        // dd($request,$ref_id);
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key} = $value;
        }

        if (!@$ref_id) {
            return back()->withInput()->with('fail', true)->with('message', 'ไม่สามารถทำรายการได้ในขณะนี้ เนื่องจากไม่มี Ref ID อ้างอิงค่ะ');
        }

        $this->validate(
            $request,
            [
                'slide_img_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120', // 5120kb = 5mb
            ],
            [
                'slide_img_name.required' => 'Image จำเป็นต้องระบุข้อมูลค่ะ',
                'slide_img_name.image' => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพเท่านั้นค่ะ',
                'slide_img_name.mimes' => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพนามสกุล :values เท่านั้นค่ะ',
                'slide_img_name.max' => 'Image รบกวนใช้ไฟล์ขนาดไม่เกิน :max kilobytes ค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('fti_slide_img');
            $count_columns = count($columns);
            if ($columns) {
                foreach ($columns as $key => $name) {

                    $data[$name] = @${$name};

                    ### At, Ref
                    if (stristr($name, 'updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Ref
                    if (stristr($name, 'ref_id')) {
                        $data[$name] = $ref_id;
                    }

                    ### unset
                    if (stristr($name, '_img_')) {
                        unset($data[$name]);
                    }

                }
            }

            //dd($data);
            DB::table('fti_slide_img')
                ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if (@$slide_img_name) {
                $file = $request->file('slide_img_name');
                if ($file) {

                    ### Parameters
                    $img_id = $id;
                    $name_upload = $file->getClientOriginalName();
                    $type = $file->getMimeType();
                    // $size = General::formatSizeUnits($file->getSize());
                    $fileSize = filesize($file->getRealPath());
                    if ($fileSize < 1024) {
                        $size = $fileSize . ' bytes';

                    } elseif ($fileSize < 1048576) {
                        $size = round($fileSize / 1024, 2) . ' KB';

                    } else {
                        $size = round($fileSize / 1048576, 2) . ' MB';

                    }
                    $width = getimagesize($file->getRealPath())[0];
                    $height = getimagesize($file->getRealPath())[1];

                    ### Path Real
                    $FileGen = $img_id . '.' . $file->getClientOriginalExtension();
                    $Path_File = storage_path('app/public/image/slide/product/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);

                    $data_img = [
                        'slide_img_name' => $FileGen,
                        'slide_img_name_upload' => $name_upload,
                        'slide_img_type' => $type,
                        'slide_img_size' => $size,
                        'slide_img_width' => $width,
                        'slide_img_height' => $height,
                    ];
                    DB::table('fti_slide_img')->where('id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url . '/เพิ่มรูปสไลด์สินค้า/ID: ' . $id);

            DB::commit();
            return redirect()->to('backend/' . $this->url . '/' . $ref_id . '/imageslide/')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url . '/เพิ่มรูปสไลด์สินค้า/ID:/Error:' . substr($e->getMessage(), 0, 180));
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message', 'ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:' . $log_code);

        }
    }

    public function image_delete($ref_id, $id)
    {
        // dd($id);
        $img = DB::table('fti_slide_img')->where('id', $id)->first();
        Storage::delete('image/slide/product/' . $img->slide_img_name);
        DB::table('fti_slide_img')
            ->where('id', $id)
            ->delete();

        ## Log
        \App\Model\Log\log_backend_login::log('ลบรูปภาพสินค้า/ID:' . $id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables_image(Request $request)
    {
        $tbl = \App\Model\datatables::datatables_product_img_slide(@$request->all(), $request->get('id'));
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function ($col) {
            $html = $col->id;
            return $html;
        });

        $DBT->editColumn('slide_img_name', function ($col) {
            $html = '<img src="' . asset('storage/app/public/image/slide/product/' . $col->slide_img_name) . '" title="' . $col->slide_img_name . '" width="20%">';
            return $html;
        });

        $DBT->editColumn('updated_at_ref_admin_id', function ($col) {
            $html = '<span class="badge rounded-pill badge-glow bg-imfo">' . \App\Model\dashboard::name_account($col->updated_at_ref_admin_id) . '</span>';
            return $html;
        });

        $DBT->editColumn('manage', function ($col) {

            $html = '
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleted' . $col->id . '" style="color:white;">ลบ</button>
            </div>
            <div class="modal fade modal-danger text-start" id="deleted' . $col->id . '" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel120">ลบสินค้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">ยืนยันที่จะลบ " ' . $col->id . '" หรือไม่?
                        </div>
                        <div class="modal-footer">
                            <form action="' . url('backend/' . $this->url . '/' . $col->ref_id . '/imageslide/' . $col->id . '/delete') . '" method="get">
                                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Accept</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
            return $html;
        });

        return $DBT->make(true);
    }

}
