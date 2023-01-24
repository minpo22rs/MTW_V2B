<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Dash_SupplierController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_supplier';
        parent::__construct($this->url);
        $this->path_file .= '.dash_supplier';
        $this->menu = 'Supplier';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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

    function fetchaddress(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        if($select == 'province_id'|| $select == 'province_s_id')
        {
            $data = DB::table('cag_area_districts')
            ->where('province_id', $value)
            ->get();

            $output = '<option value="">Select</option>';
            foreach($data as $row)
            {
            $output .= '<option value="'.$row->id.'">'.$row->name_in_thai.'</option>';
            }
            return $output;
        } else if($select == 'district_id'||$select == 'district_s_id')
        {
            $data = DB::table('cag_area_subdistricts')
            ->where('district_id', $value)
            ->get();

            $output = '<option value="">Select</option>';
            foreach($data as $row)
            {
            $output .= '<option value="'.$row->id.'">'.$row->name_in_thai.'</option>';
            }
            return $output;
        }

        $output = '<option value="">Select</option>';

        return $output;
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
                'supplier_id'           => 'required',
                'supplier_name'         => 'required',
                'taxpayer_id'           => 'required',
                'taxpayer_name'         => 'required',
                'assigned_to'           => 'required',
                'supplier_province'     => 'required',
                'supplier_district'     => 'required',
                'supplier_subdistrict'  => 'required',
                'supplier_postcode'     => 'required',
            ],
            [  
                'supplier_id.required'          => 'รหัสซัพพลายเออร์จำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_name.required'        => 'ชื่อซัพพลายเออร์จำเป็นต้องระบุข้อมูลค่ะ',
                'taxpayer_id.required'          => 'Taxpayer ID จำเป็นต้องระบุข้อมูลค่ะ',
                'taxpayer_name.required'        => 'Taxpayer Name จำเป็นต้องระบุข้อมูลค่ะ',
                'assigned_to.required'          => 'Assigned To จำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_supplier');
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
            DB::table('dash_supplier')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูล Supplier/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูล Supplier/ID:/Error:'.substr($e->getMessage(),0,180) );
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
    
    public function info($id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'id'        => $id,
            'rec'       => \App\Model\dashboard::first_supplier($id)
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'merchandize') {
            return view($this->path_file.'.info', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function edit($id)
    {
        $data = [
            'url'       => $this->url,
            'menu'      => $this->menu,
            '_title'    => $this->menu,
            'id'        => $id,
            'rec'       => \App\Model\dashboard::first_supplier($id)
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
                'supplier_id'           => 'required',
                'supplier_name'         => 'required',
                'taxpayer_id'           => 'required',
                'taxpayer_name'         => 'required',
                'assigned_to'           => 'required',
                'supplier_province'     => 'required',
                'supplier_district'     => 'required',
                'supplier_subdistrict'  => 'required',
                'supplier_postcode'     => 'required',
            ],
            [  
                'supplier_id.required'          => 'รหัสซัพพลายเออร์จำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_name.required'        => 'ชื่อซัพพลายเออร์จำเป็นต้องระบุข้อมูลค่ะ',
                'taxpayer_id.required'          => 'Taxpayer ID จำเป็นต้องระบุข้อมูลค่ะ',
                'taxpayer_name.required'        => 'Taxpayer Name จำเป็นต้องระบุข้อมูลค่ะ',
                'assigned_to.required'          => 'Assigned To จำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'supplier_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_supplier');
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

            unset($data['id']);

            //dd($data);
            DB::table('dash_supplier')
            ->where('id',$id)
            ->update($data);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Supplier/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Supplier/ID:/Error:'.substr($e->getMessage(),0,180) );
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
        $columns = DB::getSchemaBuilder()->getColumnListing('dash_supplier');
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
        DB::table('dash_supplier')
        ->where('id',$id)
        ->update($data);
        ## Log
        \App\Model\Log\log_backend_login::log('destroy-supplier/ID:'.$id);
        return back()->with('success', true)->with('message', ' Delete Complete!');
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_supplier(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('manage', function($col){
            
            $html = '<br><a href="'.url('backend/'.$this->url.'/'.$col->id.'/info').'" class="text-danger"><button class="btn btn-sm btn-grd-info">
                    <i class="icofont icofont-edit"></i>รายละเอียด</button></a>';
            return $html;
        });

        return $DBT->make(true);
    }

}
