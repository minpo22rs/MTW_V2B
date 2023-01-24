<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Dash_Sticker_ShippingController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_sticker_shipping';
        parent::__construct($this->url);
        $this->path_file .= '.dash_sticker_shipping';
        $this->menu = 'ที่อยู่บริษัท';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
            '_title' => $this->menu,
            'rec'   => \App\Model\dashboard::first_location(),
            'count' => \App\Model\dashboard::count_location(),
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
        // dd($request);

        $this->validate(
            $request, 
            [
                'l_company'           => 'required',
                'l_phone'         => 'required',
                'l_address'         => 'required',
                'l_province'     => 'required',
                'l_district'     => 'required',
                'l_subdistrict'  => 'required',
                'l_postcode'     => 'required',
            ],
            [  
                'l_company.required'          => 'ชื่อบริษัทจำเป็นต้องระบุข้อมูลค่ะ',
                'l_phone.required'        => 'เบอร์โทรศัพท์จำเป็นต้องระบุข้อมูลค่ะ',
                'l_address.required'        => 'ที่อยู่จำเป็นต้องระบุข้อมูลค่ะ',
                'l_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'l_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'l_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'l_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_location');
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
            DB::table('dash_location')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลที่อยู่บริษัท/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url)->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลที่อยู่บริษัท/ID:/Error:'.substr($e->getMessage(),0,180) );
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
        if($id == 'company') {
            $data = [
                'url'  => $this->url,
                'menu' => $this->menu,
                '_title' => $this->menu,
                'rec'   => \App\Model\dashboard::first_location(),
                'count' => \App\Model\dashboard::count_location(),
            ];
            return view($this->path_file.'.render', $data);
        }else {
            return abort('404');
        }
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
            ${$key}  = $value;
        }   

        $this->validate(
            $request, 
            [
                'l_company'           => 'required',
                'l_phone'         => 'required',
                'l_address'         => 'required',
                'l_province'     => 'required',
                'l_district'     => 'required',
                'l_subdistrict'  => 'required',
                'l_postcode'     => 'required',
            ],
            [  
                'l_company.required'          => 'ชื่อบริษัทจำเป็นต้องระบุข้อมูลค่ะ',
                'l_phone.required'        => 'เบอร์โทรศัพท์จำเป็นต้องระบุข้อมูลค่ะ',
                'l_address.required'        => 'ที่อยู่จำเป็นต้องระบุข้อมูลค่ะ',
                'l_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'l_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'l_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'l_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );

        DB::beginTransaction();

        try {
            
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_location');
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

            //dd($data);
            DB::table('dash_location')
            ->where('id',$id)
            ->update($data);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลที่อยู่บริษัท/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url)->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูลที่อยู่บริษัท/ID:/Error:'.substr($e->getMessage(),0,180) );
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
        //
    }

}
