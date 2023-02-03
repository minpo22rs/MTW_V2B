<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class Mg_Hotel_CategoryController extends Controller
{

    public function __construct()
    {
        $this->url = 'mg_hotel_category';
        parent::__construct($this->url);
        $this->path_file .= '.mg_hotel_category';
        $this->menu = 'ประเภทโรงแรม'; //\App\Model\Menu::get_menu_name($this->url)['menu'];
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
            ${$key} = $value;
        }
        // dd($request);

        $this->validate(
            $request,
            [
                'cate_name' => 'required',
            ],
            [
                'cate_name.required' => 'ประเภทสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('mg_category');
            $count_columns = count($columns);
            if ($columns) {
                foreach ($columns as $key => $name) {

                    $data[$name] = @${$name};

                    ### At, Ref
                    if (stristr($name, 'updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                }
            }
            // dd($data);
            DB::table('mg_category')
                ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if (@$cover_img_name) {
                $file = $request->file('cover_img_name');
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

                    $width = getimagesize($file->getRealPath())[0];
                    $height = getimagesize($file->getRealPath())[1];

                    ### Path Real
                    $FileGen = $img_id . '.' . $file->getClientOriginalExtension();
                    $Path_File = storage_path('app/public/image/category/hotel/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);

                    $data_img = [
                        'cover_img_name' => $FileGen,
                        'cover_img_name_upload' => $name_upload,
                        'cover_img_type' => $type,
                        'cover_img_size' => $size,
                        'cover_img_width' => $width,
                        'cover_img_height' => $height,
                    ];
                    DB::table('mg_category')->where('id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url . '/เพิ่มข้อมูลประเภทสินค้า/ID: ' . $id);

            DB::commit();
            return redirect()->to('backend/' . $this->url)->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url . '/เพิ่มข้อมูลประเภทสินค้า/ID:/Error:' . $e->getMessage());
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
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key} = $value;
        }

        $this->validate(
            $request,
            [
                'cate_name' => 'required',
            ],
            [
                'cate_name.required' => 'ประเภทสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {

            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('mg_category');
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
            DB::table('mg_category')
                ->where('id', $id)
                ->update($data);

            if (@$cover_img_name) {
                $file = $request->file('cover_img_name');
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
                    // $size = General::formatSizeUnits($file->getSize());
                    $width = getimagesize($file->getRealPath())[0];
                    $height = getimagesize($file->getRealPath())[1];

                    ### Path Real
                    $FileGen = $img_id . '.' . $file->getClientOriginalExtension();
                    $Path_File = storage_path('app/public/image/category/hotel/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);

                    $data_img = [
                        'cover_img_name' => $FileGen,
                        'cover_img_name_upload' => $name_upload,
                        'cover_img_type' => $type,
                        'cover_img_size' => $size,
                        'cover_img_width' => $width,
                        'cover_img_height' => $height,
                    ];
                    DB::table('mg_category')->where('id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url . '/แก้ไข้ข้อมูลประเภทสินค้า/ID: ' . $id);

            DB::commit();
            return redirect()->to('backend/' . $this->url)->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url . '/แก้ไข้ข้อมูลประเภทสินค้า/ID:/Error:' . $e->getMessage());
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
        $data = [];
        $columns = DB::getSchemaBuilder()->getColumnListing('mg_category');
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
        // dd($data);
        DB::table('mg_category')
            ->where('id', $id)
            ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log('ลบประเภทโรงแรม/ID:' . $id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }
    public function datatables(Request $request)
    {

        $tbl = \App\Model\datatables::datatables_category(@$request->all(), 'hotel');
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function ($col) {
            $html = $col->id;
            return $html;
        });

        $DBT->editColumn('type', function ($col) {
            $html = '<span class="badge rounded-pill badge-glow bg-primary">' . $col->type . '</span>';
            return $html;
        });

        $DBT->editColumn('cover_img_name', function ($col) {
            $html = '<img src="' . asset('storage/app/public/image/category/hotel/' . $col->cover_img_name) . '" title="' . $col->cover_img_name . '" width="20%">';
            return $html;
        });

        $DBT->editColumn('author', function ($col) {
            $html = '<span class="badge rounded-pill badge-glow bg-imfo">' . \App\Model\dashboard::name_account($col->updated_at_ref_admin_id) . '</span>';
            return $html;
        });

        $DBT->editColumn('manage', function ($col) {

            $html = '
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-gradient-warning" data-bs-toggle="modal" data-bs-target="#Edit' . $col->id . '" style="color:white;">แก้ไข</button>
                <button type="button" class="btn btn-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleted' . $col->id . '" style="color:white;">ลบ</button>
            </div>
            <div class="modal fade text-start modal-warning" id="Edit' . $col->id . '" tabindex="-1" aria-labelledby="myModalLabel17" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel17">แก้ไขประเภทโรงแรม : " ' . $col->cate_name . ' "</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form class="form form-horizontal" action="' . url('backend/' . $this->url . '/' . $col->id) . '" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="type" value="hotel">
                            <div class="row">
                                <div class="col-5">
                                    <div class="mb-1 row">
                                        <div class="col-sm-12">
                                            <label class="col-form-label" for="cate_name">ประเภทโรงแรม</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="text" id="cate_name" class="form-control" name="cate_name" value="' . $col->cate_name . '"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="mb-1 row form-group">
                                        <div class="col-sm-12">
                                            <label class="col-form-label" for="cover_img_name">รูปภาพประกอบ</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="file" id="cover_img_name" class="form-control" name="cover_img_name" value="' . $col->cover_img_name . '" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-1 row form-group">
                                        <div class="col-sm-12">
                                        &nbsp;
                                        </div>
                                        <div class="col-sm-12 py-1">
                                            <button type="submit" class="btn btn-warning me-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade modal-danger text-start" id="deleted' . $col->id . '" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel120">ลบประเภทโรงแรม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">ยืนยันที่จะลบ " ' . $col->cate_name . '" หรือไม่?
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
}
