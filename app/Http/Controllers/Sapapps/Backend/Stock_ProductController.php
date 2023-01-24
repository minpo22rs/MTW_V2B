<?php

namespace App\Http\Controllers\Traceon\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Helpers\General;
use Intervention\Image\Facades\Image as Image;

class Stock_ProductController extends Controller
{
    public function __construct()
    {
        $this->url  = 'stock_product';
        parent::__construct($this->url);
        $this->path_file .= '.stock_product';
        $this->menu = 'Stock Product';//\App\Model\Menu::get_menu_name($this->url)['menu'];
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
            '_title' => $this->menu,
        ];
        return view($this->path_file.'.create', $data);
    }

    public function edit($id)
    {
        $data = [
            'url'  => $this->url,
            'menu' => $this->menu,
            '_title' => $this->menu,
            'rec'   => \App\Model\front_shop::first_stock($id),
            'id'    => $id,
        ];
        return view($this->path_file.'.add', $data);
    }

    public function update(Request $request,$id)
    {
        foreach ($request->all() as $key => $value) {
            ${$key}  = $value;
        }    

        $this->validate(
            $request, 
            [   
                'stock_value'      => 'required',
            ],
            [   
                'stock_value.required'         => 'Stock จำเป็นต้องระบุข้อมูลค่ะ',    
            ]
        );

        DB::beginTransaction();

        try {

            $stock = DB::table('cag_product_stock')->where('stock_id',$id)->first();

            // dd($request,$stock,$id);

            DB::table('cag_product_stock')->where('stock_id',$id)->update([
                'stock_value'   => $stock->stock_value + $stock_value,
            ]);

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/update-update_stock/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Update Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/update-update_stock/ID:/Error:'.substr($e->getMessage(),0,180) );
            // throw $e;
            // echo $e->getMessage();
            // return abort(404);
            return back()->withInput()->with('fail', true)->with('message','ไม่สามารถทำรายการได้ในขณะนี้ กรุณาติดต่อผู้ดูแลระบบ รหัส:'.$log_code);
            
        }
    }
    
    function fetchoption(Request $request)
    {
        //dd('พ่อมึงอะ');
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        if($select == 'ref_product_id')
        {
            $data = DB::table('cag_product_color')
            ->whereNull('color_deleted_at')
            ->where($select, $value)
            ->get();

            $output = '<option value="">Select</option>';
            foreach($data as $row)
            {
            $output .= '<option value="'.$row->color_id.'">'.$row->color_name.'</option>';
            }
            return $output;
        }

        $output = '<option value="">Select</option>';

        return $output;
    }

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
                'ref_product_id'                  => 'required',
            ],
            [  
                'ref_product_id.required'                 => 'Product จำเป็นต้องระบุข้อมูลค่ะ',
            ]
        );


        DB::beginTransaction();

        try {
            $data = [];
            $columns = DB::getSchemaBuilder()->getColumnListing('cag_product_stock');
            $count_columns = count($columns);
            if($columns) {
                foreach ($columns as $key => $name) {
                    
                    $data[$name] = @${$name};

                    ### At, Ref
                    if(stristr($name,'_updated_at_ref_admin_id')) {
                        $data[$name] = @Auth::user()->id;
                    }

                    if(stristr($name,'stock_value')) {
                        $data[$name] = 0;
                    }

                }
            }

            //dd($data);
            DB::table('cag_product_stock')
            ->insert($data);
            $id = DB::getPdo()->lastInsertId();

            ## Log
            \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_stock/ID: '.$id);

            DB::commit();
            return redirect()->to('backend/'.$this->url.'/'.$id.'/edit')->with('success', true)->with('message', ' Create Complete!');

        } catch (\Exception $e) {
            DB::rollback();
            ## Log
            $log_code = \App\Model\Log\log_backend_login::log($this->url.'/store-cag_product_stock/ID:/Error:'.substr($e->getMessage(),0,180) );
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

    public function datatables(Request $request)
    {
        $tbl = \App\Model\front_shop::datatables_stock_product(@$request->all());
        $DBT = datatables()->of($tbl);
        $DBT->escapeColumns(['*']); //อนุญาติให้ Return Html ถ้าเอาส่วนนี้ออกจะ Return Text

        $DBT->editColumn('stock_id', function($col){
            $html = '
            <input type="checkbox" class="width-20 height-20" style="width:18px; height:18px;" name="check_id" val_id="'.$col->stock_id.'" data-toggle="tooltip" data-original-title="คลิ๊กเพื่อเลือกรายการ ที่ต้องการ แก้ไข/ลบ">';
            return $html;
        }); 

        $DBT->editColumn('stock_product', function($col){
                
            $html = '<button class="btn btn-mat btn-danger btn-mini" data-toggle="tooltip">'.\App\Model\front_shop::stock_html($col->ref_product_id,'product').'</button>';

            return $html;
        }); 

        $DBT->editColumn('stock_option', function($col){
            
            if($col->ref_color_id != '') {
                $html = '<button class="btn btn-mat btn-danger btn-mini" data-toggle="tooltip">'.\App\Model\front_shop::stock_html($col->ref_color_id,'option').'</button>';
            }else {
                $html = '';
            }
            return $html;
        }); ; 

        $DBT->editColumn('stock_add', function($col){
                
            $html = '<br><a href="'.url('backend/'.$this->url.'/'.$col->stock_id.'/edit').'" class="text-danger"><button class="btn btn-sm btn-grd-primary">
            <i class="icofont icofont-edit"></i> เพิ่ม stock สินค้า</button></a>';
            
            return $html;
        }); 

        return $DBT->make(true);
    }

}
