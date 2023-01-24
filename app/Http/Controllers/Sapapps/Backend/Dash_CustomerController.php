<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Dash_CustomerController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_customer';
        parent::__construct($this->url);
        $this->path_file .= '.dash_customer';
        $this->menu = 'หน้ารายชื่อลูกค้า';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent' || Auth::user()->role == 'supervisor') {
            return view($this->path_file.'.index', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function log_call(Request $request)
    {
        $id = $request->get('id');
        $logId = \App\Model\Log\log_call_center::log($id);

        return $logId;
    }

    public function spread_customer(Request $request)
    { 
        DB::beginTransaction();
        try {
            $sale = DB::table('account_admin')->where('role','agent')->get();

            $customer = DB::table('dash_customer')->where('customer_order','0')->count();

            $limit = floor($customer / $sale->count());
            $mod = $customer % $sale->count();

            for($i = 0; $i < $sale->count(); $i++)
            {
                $skip_s = $limit * $i;
                $skip_e = ($limit * ($i +1)) -1;
                $start = DB::table('dash_customer')
                ->where('customer_order','0')
                ->skip($skip_s)
                ->take(1)
                ->first();
                $end = DB::table('dash_customer')
                ->where('customer_order','0')
                ->skip($skip_e)
                ->take(1)
                ->first();
                
                DB::table('dash_customer')
                ->where('customer_order','0')
                ->whereBetween('customer_id',[$start->customer_id,$end->customer_id])
                ->update([
                    'ref_sale_id' => $sale[$i]->id,
                ]);
            }
                
            if($mod != 0) {
                $diff = $customer - $mod;
                $start_m = DB::table('dash_customer')
                ->where('customer_order','0')
                ->skip($diff)
                ->take($mod)
                ->get();
                foreach($start_m as $k => $m) {
                    DB::table('dash_customer')
                    ->where('customer_order','0')
                    ->where('customer_id',$m->customer_id)
                    ->update([
                        'ref_sale_id' => $sale[$k]->id,
                    ]);

                }
            }

            DB::commit();
            return redirect()->to('backend/'.$this->url)->with('success', true)->with('message', ' Spread Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/กระจายรายชื่อ/ID:/Error:'.substr($e->getMessage(),0,180) );
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
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
        if(Auth::user()->role == 'admin') {
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
        if($select == 'province_s_id')
        {
            $data = DB::table('cag_area_districts')
            ->where('provice_id', $value)
            ->get();

            $output = '<option value="">Select</option>';
            foreach($data as $row)
            {
            $output .= '<option value="'.$row->id.'">'.$row->name_in_thai.'</option>';
            }
            return $output;
        } else if($select == 'district_s_id')
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
                'customer_name'           => 'required',
                'customer_lastname'         => 'required',
                'customer_phone'         => 'required',
                'ref_sale_id'             => 'required',
                'customer_i_province'     => 'required',
                'customer_i_district'     => 'required',
                'customer_i_subdistrict'  => 'required',
                'customer_i_postcode'     => 'required',
                'customer_s_province'     => 'required',
                'customer_s_district'     => 'required',
                'customer_s_subdistrict'  => 'required',
                'customer_s_postcode'     => 'required',
            ],
            [  
                'customer_name.required'          => 'ชื่อจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_lastname.required'        => 'นามสกุลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_phone.required'        => 'เบอร์โทรศัพท์จำเป็นต้องระบุข้อมูลค่ะ',
                'ref_sale_id.required'            => 'กรุณาเพิ่มพนักงานค่ะ',
                'customer_i_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_customer');
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
            DB::table('dash_customer')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();
            $num = strlen($id);
            $str = '';
            for($i = 0;$i<5-$num;$i++) {
                $str .= '0';
            }
            $year = date('ym');
            DB::table('dash_customer')->where('customer_id',$id)->update([
                'customer_mem_id' => 'EVC'.$year.$str.$id,
            ]);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูล Customer/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูล Customer/ID:/Error:'.substr($e->getMessage(),0,180) );
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
            'rec'       => \App\Model\dashboard::first_customer($id)
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent' || Auth::user()->role == 'supervisor') {
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
            'rec'       => \App\Model\dashboard::first_customer($id)
        ];
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'agent' || Auth::user()->role == 'supervisor') {
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
                'customer_name'           => 'required',
                'customer_lastname'         => 'required',
                'customer_phone'         => 'required',
                'ref_sale_id'             => 'required',
                'customer_i_name'           => 'required',
                'customer_i_lastname'         => 'required',
                'customer_i_province'     => 'required',
                'customer_i_district'     => 'required',
                'customer_i_subdistrict'  => 'required',
                'customer_i_postcode'     => 'required',
                'customer_s_name'           => 'required',
                'customer_s_lastname'         => 'required',
                'customer_s_province'     => 'required',
                'customer_s_district'     => 'required',
                'customer_s_subdistrict'  => 'required',
                'customer_s_postcode'     => 'required',
            ],
            [  
                'customer_name.required'          => 'ชื่อจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_lastname.required'      => 'นามสกุลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_phone.required'         => 'เบอร์โทรศัพท์จำเป็นต้องระบุข้อมูลค่ะ',
                'ref_sale_id.required'            => 'กรุณาเพิ่มพนักงานค่ะ',
                'customer_i_name.required'        => 'ชื่อใบกำกับภาษีจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_lastname.required'    => 'นามสกุลใบกำกับภาษีจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_name.required'        => 'ชื่อผู้รับสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_lastname.required'    => 'นามสกุลผู้รับสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_customer');
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
            unset($data['customer_mem_id']);
            unset($data['customer_id']);

            //dd($data);
            DB::table('dash_customer')
            ->where('customer_id',$id)
            ->update($data);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Customer/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Customer/ID:/Error:'.substr($e->getMessage(),0,180) );
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
        if(Auth::user()->role == 'admin') {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_customer');
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
            DB::table('dash_customer')
            ->where('customer_id',$id)
            ->update($data);
            ## Log
            \App\Model\Log\log_backend_login::log('destroy-customer/ID:'.$id);
            return back()->with('success', true)->with('message', ' Delete Complete!');
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_customer(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('customer_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->customer_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('last_result_call', function($col){
            $html = \App\Model\dashboard::last_result_call($col->customer_id);
            return $html;
        });

        $DBT->editColumn('last_result_call_date', function($col){
            $html = \App\Model\dashboard::last_result_call_date($col->customer_id);
            return $html;
        });

        $DBT->editColumn('manage', function($col){
            
            $html = '<a  onclick="navigatorFunc('.$col->customer_phone.','.$col->customer_id.')" class="text-danger"><button class="btn btn-sm btn-grd-info">
                    <i class="ti-shopping-cart-full"></i>สร้างรายการขาย</button></a>';
            return $html;
        });

        $DBT->editColumn('info', function($col){
            
            $html = '<a href="dash_customer/'.$col->customer_id.'/info" class="text-danger"><button class="btn btn-sm btn-grd-warning">
                    <i class="ti-shopping-cart-full"></i>รายละเอียด</button></a>';
            return $html;
        });

        $DBT->editColumn('ref_sale_id', function($col){
            $html = \App\Model\dashboard::name_account($col->ref_sale_id);
            return $html;
        });

        return $DBT->make(true);
    }

}
