<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;
use Carbon\Carbon;

class Dash_SaleController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_sale';
        parent::__construct($this->url);
        $this->path_file .= '.dash_sale';
        $this->menu = 'หน้าการขาย';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
    
    function noti_send(Request $request) {
        $select = $request->get('select');

        DB::table('account_admin')
        ->where('id',@Auth::user()->id)
        ->update([
            'noti' => $select
        ]);


        return $select;
    }

    public function create($id,$id2)
    {
        $data = [
            'url'  => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
            '_id'   => $id,
            'logId' => $id2,
            'customer' => \App\Model\dashboard::first_customer($id),
            'call'  => \App\Model\dashboard::call_history_customer($id)
        ];
        if(Auth::user()->role == 'admin' ||  Auth::user()->role == 'agent') {
            return view($this->path_file.'.create', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    function add_cart(Request $request)
    {
        $id = $request->get('id');
        $refId = $request->get('refId');
        $type = $request->get('type');
        $value = $request->get('value');

        $check = DB::table('dash_product_order')->where([['ref_so_id',$refId],['product_id',$id]])->count();

        if($type == 'cart') {
            if($check < 1) {
                $price = \App\Model\dashboard::first_product($id);
                DB::table('dash_product_order')->insert([
                    'ref_so_id'         => $refId,
                    'product_id'        => $id,
                    'product_qty'       => 1,
                    'product_price'     => $price->product_unit_price,
                    'product_sum_price' => $price->product_unit_price,
                ]);
            }
        }else if($type == 'del') {
            if($check > 0) {
                DB::table('dash_product_order')->where([['ref_so_id', $refId],['product_id',$id]])->delete();
            }
        }else if($type == 'qty') {
            $old = DB::table('dash_product_order')->where('id',$id)->first();
            DB::table('dash_product_order')
            ->where('id',$id)
            ->update([
                'product_qty'   => $value,
                'product_sum_price' => $old->product_price * $value,
            ]);
        }

        $product = DB::table('dash_product_order as po')
        ->join('dash_product as p','p.product_id','=','po.product_id')
        ->where('po.ref_so_id',$refId)
        ->get();

        $price = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$refId)
        ->sum('product_sum_price');

        $discount = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$refId)
        ->sum('product_discount');

        $tax = General::number_format_(0.07 * ($price- $discount));

        $sum = General::number_format_($price + $tax - $discount);

        $result = '';

        foreach($product as $k => $p) {
            $result .= 
                    '<tr>
                        <td>'.($k+1).'</td>
                        <td>'.$p->product_name.'</td>
                        <td>
                            <input type="hidden" name="order_id" value="'.$p->ref_so_id.'">
                            <div class="row sp-quantity">
                                <div class="col-2 qty" data-id="'.$p->id.'" data-dependent="minus"><i class="ti-minus"></i></div>
                                <div class="col-6 px-1">
                                    <input class="quntity-input" id="num" disabled type="text" style="width:100%" value="'.$p->product_qty.'" />
                                </div>
                                <div class="col-2 px-0 qty" data-id="'.$p->id.'" data-dependent="plus"><i class="ti-plus"></i></div>
                            </div>
                        </td>
                        <td>'.General::number_format_($p->product_unit_price).'</td>
                        <td>
                            <div class="row sp-discount">
                                <div class="col-8">
                                    <input class="form-control discount-input" type="number" min="0" value="'.$p->product_discount.'">
                                </div>
                                <div class="col-4 px-0">
                                    <button type="button" class="btn-grd-info discount" data-id="'.$refId.'" data-dependent="'.$p->id.'">+</button>
                                </div>
                            </div>
                        </td>
                        <td>'.General::number_format_((($p->product_unit_price * $p->product_qty) - $p->product_discount)).'</td>
                        <td>
                        <button type="button" class="btn-grd-danger del-cart" data-id="'.$p->product_id.'" data-dependent="'.$p->ref_so_id.'"> - </button></td>
                    </tr>';
        }

        return response()->json(['result' => $result, 'price' => General::number_format_($price - $discount - $tax),'price_r' => ($price - $discount - $tax), 'tax' => $tax, 'sum' =>  General::number_format_($price - $discount) ,'sum_r' => $price - $discount]);
    }

    function dis_count(Request $request)
    {
        $id = $request->get('id');
        $dataId = $request->get('dataId');
        $value = $request->get('value');

        $old = DB::table('dash_product_order')->where('id',$id)->first();
        DB::table('dash_product_order')
        ->where('id',$id)
        ->update([
            'product_discount'   => $value,
        ]);

        $product = DB::table('dash_product_order as po')
        ->join('dash_product as p','p.product_id','=','po.product_id')
        ->where('po.ref_so_id',$dataId)
        ->get();

        $price = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$dataId)
        ->sum('product_sum_price');

        $discount = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$dataId)
        ->sum('product_discount');

        $tax = General::number_format_(0.07 * ($price- $discount));

        $sum = General::number_format_($price + $tax - $discount);

        $result = '';

        foreach($product as $k => $p) {
            $result .= 
                    '<tr>
                        <td>'.($k+1).'</td>
                        <td>'.$p->product_name.'</td>
                        <td>
                            <input type="hidden" name="order_id" value="'.$p->ref_so_id.'">
                            <div class="row sp-quantity">
                                <div class="col-2 qty" data-id="'.$p->id.'" data-dependent="minus"><i class="ti-minus"></i></div>
                                <div class="col-6 px-1">
                                    <input class="quntity-input" id="num" disabled type="text" style="width:100%" value="'.$p->product_qty.'" />
                                </div>
                                <div class="col-2 px-0 qty" data-id="'.$p->id.'" data-dependent="plus"><i class="ti-plus"></i></div>
                            </div>
                        </td>
                        <td>'.General::number_format_($p->product_unit_price).'</td>
                        <td>
                            <div class="row sp-discount">
                                <div class="col-8">
                                    <input class="form-control discount-input" type="number" min="0" value="'.$p->product_discount.'">
                                </div>
                                <div class="col-4 px-0">
                                    <button type="button" class=" btn-grd-info discount" data-id="'.$dataId.'" data-dependent="'.$p->id.'">+</button>
                                </div>
                            </div>
                        </td>
                        <td>'.General::number_format_((($p->product_unit_price * $p->product_qty) - $p->product_discount)).'</td>
                        <td>
                        <button type="button" class=" btn-grd-danger del-cart" data-id="'.$p->product_id.'" data-dependent="'.$p->ref_so_id.'"> - </button></td>
                    </tr>';
        }

        return response()->json(['result' => $result, 'price' => General::number_format_($price - $discount - $tax),'price_r' => ($price - $discount - $tax), 'tax' => $tax, 'sum' =>  General::number_format_($price - $discount) ,'sum_r' => $price - $discount]);
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
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }

        if($cr_status == 2) {
            $this->validate(
                $request, 
                [
                    'cr_status'             => 'required',
                    'cr_date'               => 'required',
                    'cr_day'                => 'required',
                    'cr_minute'             => 'required',
                    'cr_hour'               => 'required',
                ],
                [  
                    'cr_status.required'            => 'สถานะจำเป็นต้องระบุข้อมูลค่ะ',
                    'cr_date.required'              => 'วันนัดโทรกลับจำเป็นต้องระบุข้อมูลค่ะ',
                    'cr_day.required'               => 'วันจำเป็นต้องระบุข้อมูลค่ะ',
                    'cr_minute.required'            => 'นาทีจำเป็นต้องระบุข้อมูลค่ะ',
                    'cr_hour.required'              => 'ชั่วโมงจำเป็นต้องระบุข้อมูลค่ะ',
                ]
            );
        }else {
            $this->validate(
                $request, 
                [
                    'cr_status'             => 'required',
                ],
                [  
                    'cr_status.required'            => 'สถานะจำเป็นต้องระบุข้อมูลค่ะ',
                ]
            );
        }


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('dash_call_result');
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
            DB::table('dash_call_result')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            if($cr_status == 2) {
                $time = Carbon::parse($cr_date);
                if($cr_day != 0) {
                    $time->add(-$cr_day,'day');
                }
                if($cr_hour != 0) {
                    $time->add(-$cr_hour,'hour');
                }
                if($cr_minute != 0) {
                    $time->add(-$cr_minute,'minute');
                }
                DB::table('dash_call_result')->where('id',$id)->update([
                    'cr_noti_date' => $time
                ]);
                \App\Model\Notification\notification::log('callback',$id,'','');
            }

            $old = DB::table('dash_customer')->where('customer_id',$cr_customer_id)->first();
            DB::table('dash_customer')->where('customer_id',$cr_customer_id)->update([
                'customer_order' => $old->customer_order + 1
            ]);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลผลลัพธ์การโทร/ID: '.$id);

            DB::commit();
            if($cr_status == 4) {
                DB::table('dash_sale_order')->insert([
                    'ref_result_id'     => $id,
                    'ref_customer_id'   => $cr_customer_id,
                    'so_price'          => 0,
                    'so_created_at_ref_user_id' => @Auth::user()->id,
                    'so_date'           => date('Y-m-d h:i:s'),
                ]);
                $id2 = DB::getPdo()->lastInsertId();
                $num = strlen($id2);
                $str = '';
                for($i = 0;$i<5-$num;$i++) {
                    $str .= '0';
                }
                $year = date('ym');
                $num_id = 'EVS'.$year.$str.$id2;
                DB::table('dash_sale_order')
                ->where('id',$id2)
                ->update([
                    'so_num_id'         => $num_id,
                ]);

                return redirect()->to('backend/'.$this->url.'/'.$id2.'/sell')->with('success', true)->with('message', ' บันทึกข้อมูลการโทรเรียบร้อยแล้วค่ะ');
            }else {
                return redirect()->to('backend/dash_customer')->with('success', true)->with('message', ' บันทึกข้อมูลการโทรเรียบร้อยแล้วค่ะ');
            }

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/เพิ่มข้อมูลผลลัพธ์การโทร/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
        }
    }

    public function sell($id)
    {
        $check = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->count();
        $cart_data = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->first();
        $cart = DB::table('dash_product_order as po')
        ->join('dash_product as p','p.product_id','=','po.product_id')
        ->where('po.ref_so_id',$id)
        ->get();
        $price = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_sum_price');
        $discount = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_discount');
        $tax = 0.07 * ($price - $discount);
        if($check > 0) {
            $data = [
                'id'   => $id,
                'url'  => $this->url,
                'menu' => $this->menu,
                '_title' => $this->menu,
                'product' => \App\Model\dashboard::front_product(),
                'cart'  => $cart,
                'sale'  => $cart_data,
                'customer' => \App\Model\dashboard::first_customer($cart_data->ref_customer_id),
                'price' => $price - $discount,
                'tax'   => $tax,
            ];
            return view($this->path_file.'.sell', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function invoice($id)
    {
        $check = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->count();
        $cart_data = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->first();
        $cart = DB::table('dash_product_order as po')
        ->join('dash_product as p','p.product_id','=','po.product_id')
        ->where('po.ref_so_id',$id)
        ->get();
        $price = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_sum_price');
        $discount = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_discount');
        $tax = 0.07 * ($price - $discount);
        if($check > 0) {
            $data = [
                'id'   => $id,
                'url'  => $this->url,
                'menu' => $this->menu,
                '_title' => $this->menu,
                'product' => \App\Model\dashboard::front_product(),
                'cart'  => $cart,
                'sale'  => $cart_data,
                'customer' => \App\Model\dashboard::first_customer($cart_data->ref_customer_id),
                'price' => $price - $discount,
                'tax'   => $tax,
            ];
            return view($this->path_file.'.info', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

    public function sticker($id)
    {
        $check = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->count();
        $cart_data = DB::table('dash_call_result as cr')
        ->join('dash_sale_order as so','cr.id','=','so.ref_result_id')
        ->where([['so.id',$id],['cr.cr_status',4]])->first();
        $cart = DB::table('dash_product_order as po')
        ->join('dash_product as p','p.product_id','=','po.product_id')
        ->where('po.ref_so_id',$id)
        ->get();
        $price = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_sum_price');
        $discount = DB::table('dash_product_order as po')
        ->where('po.ref_so_id',$id)
        ->sum('product_discount');
        $tax = 0.07 * ($price - $discount);
        if($check > 0) {
            $data = [
                'id'   => $id,
                'url'  => $this->url,
                'menu' => $this->menu,
                '_title' => $this->menu,
                'product' => \App\Model\dashboard::front_product(),
                'cart'  => $cart,
                'sale'  => $cart_data,
                'customer' => \App\Model\dashboard::first_customer($cart_data->ref_customer_id),
                'price' => $price - $discount,
                'tax'   => $tax,
            ];
            return view($this->path_file.'.sticker', $data);
        }else {
            return abort(403, 'Unauthorized action.');
        }
    }

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
            'rec'       => \App\Model\dashboard::first_customer($id)
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
                'customer_phone'          => 'required',
                'so_date'                 => 'required',
                'so_shipping_type'        => 'required',
                'i_name'                  => 'required',
                'customer_i_province'     => 'required',
                'customer_i_district'     => 'required',
                'customer_i_subdistrict'  => 'required',
                'customer_i_postcode'     => 'required',
                's_name'                  => 'required',
                'customer_s_province'     => 'required',
                'customer_s_district'     => 'required',
                'customer_s_subdistrict'  => 'required',
                'customer_s_postcode'     => 'required',
                'so_price'                => 'required',
                'so_tax'                  => 'required',
                'so_tax_per'              => 'required',
                'so_sum_price'            => 'required',
                'so_pay_type'             => 'required',
            ],
            [  
                'customer_phone.required'         => 'เบอร์โทรศัพท์จำเป็นต้องระบุข้อมูลค่ะ',
                'so_date.required'                => 'วันที่ขายจำเป็นต้องระบุข้อมูลค่ะ',
                'so_shipping_type.required'       => 'ขนส่งจำเป็นต้องระบุข้อมูลค่ะ',
                'i_name.required'                 => 'ชื่อใบกำกับภาษีจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_i_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
                's_name.required'                 => 'ชื่อผู้รับสินค้าจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_province.required'    => 'จังหวัดจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_district.required'    => 'อำเภอจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_subdistrict.required' => 'ตำบลจำเป็นต้องระบุข้อมูลค่ะ',
                'customer_s_postcode.required'    => 'รหัสไปรษณีย์จำเป็นต้องระบุข้อมูลค่ะ',
                'so_price.required'               => 'ราคาจำเป็นต้องระบุข้อมูลค่ะ',
                'so_tax.required'                 => 'ภาษีจำเป็นต้องระบุข้อมูลค่ะ',
                'so_tax_per.required'             => 'ภาษีจำเป็นต้องระบุข้อมูลค่ะ',
                'so_sum_price.required'           => 'ราคารวมจำเป็นต้องระบุข้อมูลค่ะ',
                'so_pay_type.required'            => 'ช่องทางชำระเงินจำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $customer_i_name = explode(' ',$i_name)[0];
            $customer_i_lastname = isset(explode(' ',$i_name)[1])?explode(' ',$i_name)[1]:'';
            $customer_s_name = explode(' ',$s_name)[0];
            $customer_s_lastname = isset(explode(' ',$s_name)[1])?explode(' ',$s_name)[1]:'';
            
            DB::table('dash_sale_order')->where('id',$id)->update([
                'so_date'                   => @$so_date,
                'so_shipping_type'          => @$so_shipping_type,
                'so_price'                  => @$so_price,
                'so_tax'                    => @$so_tax,
                'so_tax_per'                => @$so_tax_per,
                'so_sum_price'              => @$so_sum_price,
                'so_pay_type'               => @$so_pay_type,
                'so_pay_date'               => @$so_pay_date,
                'so_remark'                 => @$so_remark,
                'so_tracking'               => @$so_tracking,
                'so_inv_date'               => @$so_inv_date,
                'so_inv_num'                => @$so_inv_num,
            ]);

            $cart = DB::table('dash_product_order as po')
            ->join('dash_product as p','p.product_id','=','po.product_id')
            ->where('po.ref_so_id',$id)
            ->get();
            if($cart->count() > 0) {
                if(Auth::user()->role == 'agent') {
                    DB::table('dash_sale_order')->where('id',$id)->update([
                        'so_status'                   => 'รอตรวจสอบ',
                    ]);
                    foreach($cart as $c) {
                        $time = Carbon::parse($so_date);
                        if($c->product_noti_few != 0) {
                            $time->add($c->product_noti_few,'day');
                        }
                        if($c->product_type == 2) {
                            \App\Model\Notification\notification::log('callagain','',$c->product_id,$id,$time);
                        }
                    }
                }
            }
            if(Auth::user()->role == 'supervisor') {
                if($button_name == 'cc') {
                    $type_v = 'ยกเลิกออเดอร์';
                }else if($button_name == 'check') {
                    $type_v = 'อนุมัติคำสั่งซื้อ';
                }
                DB::table('dash_sale_order')->where('id',$id)->update([
                    'so_status'                   => $type_v,
                ]);
            }
            if(Auth::user()->role == 'fulillment' || Auth::user()->role == 'admin') {
                DB::table('dash_sale_order')->where('id',$id)->update([
                    'so_status'                   => @$so_status,
                ]);

                if($so_status == 'ออกอินวอยซ์') {
                    $num = strlen($id);
                    $str = '';
                    for($i = 0;$i<5-$num;$i++) {
                        $str .= '0';
                    }
                    $year = date('ym');
                    DB::table('dash_sale_order')->where('id',$id)->update([
                        'so_inv_num' => 'EVI'.$year.$str.$id,
                        'so_inv_date' => date('Y-m-d h:i:s'),
                    ]);
                    foreach($cart as $c) {
						$check = DB::table('dash_product')
            				->where('product_id',$c->product_id)->first();
                		$num = $check->product_stock - $c->product_qty;
            			
                		DB::table('dash_product')
                		->where('product_id',$c->product_id)
                		->update([
                    		'product_stock' => $num,
                		]);
                		## Log
                		\App\Model\Log\log_product_stock::log('out',$c->product_qty,$c->product_id,$id);
                    }
					
                }
            }

            DB::table('dash_customer')->where('customer_id',$ref_customer_id)->update([
                'customer_i_name'                   => $customer_i_name,
                'customer_i_lastname'               => $customer_i_lastname,
                'customer_i_address'                => $customer_i_address,
                'customer_i_province'               => $customer_i_province,
                'customer_i_district'               => $customer_i_district,
                'customer_i_subdistrict'            => $customer_i_subdistrict,
                'customer_i_postcode'               => $customer_i_postcode,
                'customer_s_name'                   => $customer_s_name,
                'customer_s_lastname'               => $customer_s_lastname,
                'customer_s_address'                => $customer_s_address,
                'customer_s_province'               => $customer_s_province,
                'customer_s_district'               => $customer_s_district,
                'customer_s_subdistrict'            => $customer_s_subdistrict,
                'customer_s_postcode'               => $customer_s_postcode,
            ]);
            
            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/แก้ไข้ข้อมูล Customer/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/dash_sale')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/จัดการข้อมูล Order/ID:/Error:'.substr($e->getMessage(),0,180) );
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
        $tbl = \App\Model\dashboard::datatables_sale_order(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('manage', function($col){
            
            $html = '<a href="'.url('backend/dash_sale/'.$col->id.'/sell').'" class="text-danger"><button class="btn btn-sm btn-grd-info">
                    <i class="ti-shopping-cart-full"></i>Manage</button></a>';
            if($col->so_status == 'ออกอินวอยซ์' || $col->so_status == 'กำลังจัดส่ง' || $col->so_status == 'ลูกค้ารับสินค้า' || $col->so_status == 'ลูกค้าปฏิเสธการรับสินค้า' || $col->so_status == 'refun' || $col->so_status == 'ยกเลิกออเดอร์') {
                $html .= '<a href="'.url('backend/dash_sale/'.$col->id.'/invoice').'" class="text-danger"><button class="btn btn-sm btn-grd-info">
                <i class="ti-shopping-cart-full"></i>Invoice</button></a>';
            }else {
                $html .= '';
            }
            $html .= '<a href="'.url('backend/dash_sale/'.$col->id.'/sticker').'" class="text-danger"><button class="btn btn-sm btn-grd-warning">
                    <i class="ti-truck"></i>Sticker Shipping</button></a>';
            return $html;
        });

        // $DBT->editColumn('c.customer_name', function($col){
            
        //     $html = \App\Model\dashboard::name_customer($col->ref_customer_id);
        //     return $html;
        // });so_sum_price

        $DBT->editColumn('so_created_at_ref_user_id', function($col){
            $html = \App\Model\dashboard::name_account($col->so_created_at_ref_user_id);
            return $html;
        });

        $DBT->editColumn('so_status',function($col){
            if($col->so_status == '') {
                $html = '';
            }else {
                $html = '<span class="label label-primary">'.$col->so_status.'</span>';
            }

            return $html;
        });

        $DBT->editColumn('so_sum_price', function($col){
            
            $html = General::number_format_($col->so_sum_price);
            return $html;
        });

        return $DBT->make(true);
    }

}
