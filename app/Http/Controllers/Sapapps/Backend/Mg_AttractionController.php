<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Mg_AttractionController extends Controller
{
    public function __construct()
    {
        $this->url  = 'mg_attraction';
        parent::__construct($this->url);
        $this->path_file .= '.mg_attraction';
        $this->menu = 'สถานที่ท่องเที่ยว';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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

    public function create()
    {
        $data = [
            'url'  => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu
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
        // dd($request);
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }
        // dd($request);

        $this->validate(
            $request,
            [
                'att_name'           => 'required',
                'short_descrip'           => 'required',
                'full_descrip'           => 'required',
                'att_province'           => 'required',
                'att_district'           => 'required',
                'att_subdistrict'           => 'required',
                'cover_img_name'           => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'location'           => 'required',
            ],
            [
                'att_name.required'          => 'ชื่อสถานที่ท่องเที่ยวจำเป็นต้องระบุข้อมูลค่ะ',
                'short_descrip.required'          => 'คำอธิบายโดยย่อจำเป็นต้องระบุข้อมูลค่ะ',
                'full_descrip.required'          => 'คำอธิบายจำเป็นต้องระบุข้อมูลค่ะ',
                'att_province.required'          => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'att_district.required'          => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'att_subdistrict.required'          => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'cover_img_name.required'    => 'Image จำเป็นต้องระบุข้อมูลค่ะ',
                'cover_img_name.image'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพเท่านั้นค่ะ',
                'cover_img_name.mimes'       => 'Image รบกวนใช้ไฟล์ประเภทรูปภาพนามสกุล :values เท่านั้นค่ะ',
                'cover_img_name.max'         => 'Image รบกวนใช้ไฟล์ขนาดไม่เกิน :max kilobytes ค่ะ',
                'location.required'          => 'URL Google Map จำเป็นต้องระบุข้อมูลค่ะ',

            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('mg_attractions');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {

                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### unset
                    if(stristr($name,'img')) {
                        unset($data[$name]);
                    }

                }
            }
            // dd($data);
            DB::table('mg_attractions')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if(@$cover_img_name) {
                $file = $request->file('cover_img_name');
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
                    $Path_File  = storage_path('app/public/image/attractions/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);

                    $data_img = [
                        'cover_img_name'        => $FileGen,
                        'cover_img_name_upload' => $name_upload,
                        'cover_img_type'        => $type,
                        'cover_img_size'        => $size,
                        'cover_img_width'       => $width,
                        'cover_img_height'      => $height
                    ];
                    DB::table('mg_attractions')->where('id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลสถานที่ท่องเที่ยว/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url)->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลสถานที่ท่องเที่ยว/ID:/Error:'.$e->getMessage() );
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

    public function edit($id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'id'        => $id,
            'rec'       => \App\Model\dashboard::first_attraction($id)
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
        // dd($request);
        ### Request
        //General::print_r_($request->all());exit;
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }

        $this->validate(
            $request,
            [
                'att_name'           => 'required',
                'short_descrip'           => 'required',
                'full_descrip'           => 'required',
                'att_province'           => 'required',
                'att_district'           => 'required',
                'att_subdistrict'           => 'required',
                'location'           => 'required',
            ],
            [
                'att_name.required'          => 'ชื่อสถานที่ท่องเที่ยวจำเป็นต้องระบุข้อมูลค่ะ',
                'short_descrip.required'          => 'คำอธิบายโดยย่อจำเป็นต้องระบุข้อมูลค่ะ',
                'full_descrip.required'          => 'คำอธิบายจำเป็นต้องระบุข้อมูลค่ะ',
                'att_province.required'          => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'att_district.required'          => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'att_subdistrict.required'          => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'location.required'          => 'URL Google Map จำเป็นต้องระบุข้อมูลค่ะ',

            ]
        );


        DB::beginTransaction();

        try {

            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('mg_attractions');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {

                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    ### Set Null
                    if(stristr($name,'created_at')) {
                        unset($data[$name]);
                    }

                    ### unset
                    if(stristr($name,'_img_')) {
                        unset($data[$name]);
                    }
                }
            }

            unset($data['id']);

            //dd($data);
            DB::table('mg_attractions')
            ->where('id',$id)
            ->update($data);

            if(@$cover_img_name) {
                $file = $request->file('cover_img_name');
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
                    $Path_File  = storage_path('app/public/image/attractions/');

                    ### Resize - ก่อนย้ายจาก temp ไป Folder รูป
                    // $Path_File_Resize  = storage_path('app/public/image/image/tmp');
                    // $image = Image::make($file->getRealPath())
                    // ->resize(1600, null, function ($constraint) {
                    //     $constraint->aspectRatio(); //ปรับไม่ให้เสีย Scale
                    // })
                    // ->save($Path_File_Resize.'/'.$FileGen);

                    $file->move($Path_File, $FileGen);

                    $data_img = [
                        'cover_img_name'        => $FileGen,
                        'cover_img_name_upload' => $name_upload,
                        'cover_img_type'        => $type,
                        'cover_img_size'        => $size,
                        'cover_img_width'       => $width,
                        'cover_img_height'      => $height
                    ];
                    DB::table('mg_attractions')->where('id', $img_id)->update($data_img);

                }
            }

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลสถานที่ท่องเที่ยว/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url)->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลสถานที่ท่องเที่ยว/ID:/Error:'.$e->getMessage() );
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
        $columns = DB::getSchemaBuilder()->getColumnListing('mg_attractions');
        $count_columns = count($columns);
        if($columns) {
            foreach ($columns as $key => $name) {
                ### At, Ref
                if(stristr($name,'deleted_at')) {
                    $data[$name] = date('Y-m-d H:i:s');
                }
                if(stristr($name,'deleted_at_ref_admin_id')) {
                    $data[$name] = @Auth::user()->id;
                }
            }
        }
        // dd($data);
        DB::table('mg_attractions')
        ->where('id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log('ลบสถานที่ท่องเที่ยว/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\datatables::datatables_attraction(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = $col->id;
            return $html;
        });

        $DBT->editColumn('att_province', function($col){
            $html = \App\Model\dashboard::province_html($col->att_province);
            return $html;
        });

        $DBT->editColumn('att_district', function($col){
            $html = \App\Model\dashboard::district_html($col->att_district);
            return $html;
        });

        $DBT->editColumn('att_subdistrict', function($col){
            $html = \App\Model\dashboard::subdistrict_html($col->att_subdistrict);
            return $html;
        });

        $DBT->editColumn('cover_img_name', function($col){
            $html = '<img src="'.asset('storage/app/public/image/attractions/'.$col->cover_img_name).'" title="'.$col->cover_img_name.'" width="30%">';
            return $html;
        });

        $DBT->editColumn('author', function($col){
            $html = '<span class="badge rounded-pill badge-glow bg-imfo">'.\App\Model\dashboard::name_account($col->updated_at_ref_admin_id).'</span>';
            return $html;
        });

        $DBT->editColumn('manage', function($col){

            $html = '
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="'.url('backend/'.$this->url.'/'.$col->id.'/edit').'" class="btn btn-gradient-warning" style="color:white;">แก้ไข</a>
                <button type="button" class="btn btn-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleted'.$col->id.'" style="color:white;">ลบ</button>
            </div>
            <div class="modal fade modal-danger text-start" id="deleted'.$col->id.'" tabindex="-1" aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel120">ลบประเภทสินค้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">ยืนยันที่จะลบ " '.$col->att_name.'" หรือไม่?
                        </div>
                        <div class="modal-footer">
                            <form action="'.url('backend/'.$this->url.'/'.$col->id.'/delete').'" method="get">
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
