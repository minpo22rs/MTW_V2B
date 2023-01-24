<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Dash_Report_InvoiceController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dash_report_invoice';
        parent::__construct($this->url);
        $this->path_file .= '.dash_report_invoice';
        $this->menu = 'รายงาน';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
        //
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
        //
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

    public function datatables(Request $request)
    {
        $tbl = \App\Model\dashboard::datatables_report_invoice(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        // $DBT->editColumn('id', function($col){
        //     $html = '
        //     <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
        //     return $html;
        // }); 

        $DBT->editColumn('product_sum_price', function($col){
            $html = General::number_format_($col->product_sum_price-$col->product_discount);
            return $html;
        });

        $DBT->editColumn('product_discount', function($col){
            $html = General::number_format_($col->product_discount);
            return $html;
        });

        $DBT->editColumn('product_unit_price', function($col){
            $html = General::number_format_($col->product_unit_price);
            return $html;
        });

        $DBT->editColumn('so_sum_price', function($col){
            $html = General::number_format_($col->so_sum_price);
            return $html;
        });

        $DBT->editColumn('customer_name', function($col){
            $html = $col->customer_name.' '.$col->customer_lastname;
            return $html;
        });
        
        $DBT->editColumn('paymenttype', function($col){
            if($col->so_pay_type == 'cod') {
                $html = 'เก็บเงินปลายทาง';
            } else if($col->so_pay_type == 'transfer') {
                $html = 'โอนเงิน';
            } else {
                $html = '';
            }

            return $html;
        });

        return $DBT->make(true);
    }

}
