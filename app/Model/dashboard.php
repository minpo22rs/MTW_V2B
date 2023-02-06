<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

####### Include
use Auth;
use DB;
use Agent;
use Illuminate\Support\Facades\Log;
class dashboard extends Model
{
    static public function datatables_supplier($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_supplier')
        ->whereNull('supplier_deleted_at');

        return $get;
    }

    static public function first_supplier($id)
    {
        $first = DB::table('dash_supplier')
        ->whereNull('supplier_deleted_at')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function name_customer($id)
    {
        if($id != '') {
            $first = DB::table('dash_customer')
            ->where('customer_id',$id)
            ->first();

            if(!$first) {
                return [];
            }

            $name = $first->customer_name.' '.$first->customer_lastname;
            return $name;
        }else {
            $name = '';
            return $name;
        }
    }

    static public function datatables_stock_log($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('log_product_stock');

        return $get;
    }

    static public function datatables_log_call($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('log_call_center');

        return $get;
    }

    static public function datatables_product_type($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_product_type')
        ->whereNull('type_deleted_at');

        return $get;
    }

    static public function first_product_type($id)
    {
        $first = DB::table('dash_product_type')
        ->whereNull('type_deleted_at')
        ->where('type_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_product_category($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_product_category')
        ->whereNull('cate_deleted_at');

        return $get;
    }

    static public function first_product_category($id)
    {
        $first = DB::table('dash_product_category')
        ->whereNull('cate_deleted_at')
        ->where('cate_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_product_attribute($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_product_attribute')
        ->whereNull('attribute_deleted_at');

        return $get;
    }

    static public function first_product_attribute($id)
    {
        $first = DB::table('dash_product_attribute')
        ->whereNull('attribute_deleted_at')
        ->where('attribute_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function type_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('dash_product_type')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->type_id.'" '.($selected == $v->type_id ? 'selected' : '').'>'.$v->type_name.'</option>';
            }
        }

        return $html;
    }

    static public function attribute_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('dash_product_attribute')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->attribute_id.'" '.($selected == $v->attribute_id ? 'selected' : '').'>'.$v->attribute_name.'</option>';
            }
        }

        return $html;
    }

    static public function supplier_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('dash_supplier')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->supplier_name.'</option>';
            }
        }

        return $html;
    }

    static public function datatables_product($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_product')
        ->whereNull('product_deleted_at');

        return $get;
    }

    static public function front_product()
    {
        $first = DB::table('dash_product')
        ->whereNull('product_deleted_at')
        ->get();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function type_name($id)
    {
        if($id != '') {
            $first = DB::table('dash_product_type')
            ->where('type_id',$id)
            ->first();

            if(!$first) {
                return [];
            }

            $name = $first->type_name;
            return $name;
        }else {
            $name = '';
            return $name;
        }
    }

    static public function product_name($id)
    {
        if($id != '') {
            $first = DB::table('dash_product')
            ->where('product_id',$id)
            ->first();

            if(!$first) {
                return [];
            }

            $name = $first->product_name;
            return $name;
        }else {
            $name = '';
            return $name;
        }
    }

    static public function datatables_customer($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_customer')
        ->whereNull('customer_deleted_at')
        ->orderBy('customer_order','ASC');

        if(Auth::user()->role == 'agent' ) {
            $get = $get->where('ref_sale_id',Auth::user()->id);
        }

        return $get;
    }

    static public function first_customer($id)
    {
        $first = DB::table('dash_customer')
        ->whereNull('customer_deleted_at')
        ->where('customer_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_admin($post = [],$role = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('account_admin');

        if($role != '') {
            $get = $get->where('role',$role);
        }

        return $get;
    }

    static public function first_admin($id)
    {
        $first = DB::table('account_admin')
        ->whereNull('deleted_at')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_status_call($post = [])
    {
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_status_call')
        ->whereNull('sts_deleted_at');

        return $get;
    }

    static public function first_status_call($id)
    {
        $first = DB::table('dash_status_call')
        ->whereNull('sts_deleted_at')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function status_call_type_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $html .= '<option value="ติดต่อได้" '.($selected == 'ติดต่อได้' ? 'selected' : '').'>ติดต่อได้</option>';

        $html .= '<option value="ยังติดต่อไม่ได้" '.($selected == 'ยังติดต่อไม่ได้' ? 'selected' : '').'>ยังติดต่อไม่ได้</option>';

        $html .= '<option value="ยกเลิกการติดต่อ" '.($selected == 'ยกเลิกการติดต่อ' ? 'selected' : '').'>ยกเลิกการติดต่อ</option>';

        return $html;
    }

    static public function status_call_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('dash_status_call')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->sts_text.'</option>';
            }
        }

        return $html;
    }

    static public function datatables_sale_order($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_sale_order as so')
        ->join('dash_customer as c','c.customer_id','=','so.ref_customer_id')
        ->whereNull('so_deleted_at');

        if(Auth::user()->role == 'agent') {
            $get = $get->where('so.so_created_at_ref_user_id',Auth::user()->id);
        }

        if(Auth::user()->role == 'supervisor') {
            $get = $get->where('so.so_status','รอตรวจสอบ');
        }

        if(Auth::user()->role == 'fulillment') {
            $get = $get->whereIn('so.so_status',['อนุมัติคำสั่งซื้อ','หยิบสินค้า','ออกอินวอยซ์','กำลังจัดส่ง','ลูกค้าปฏิเสธการรับสินค้า','refun']);
        }

        return $get;
    }

    static public function datatables_history($post = [],$type = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_sale_order as so')
        ->join('dash_customer as c','c.customer_id','=','so.ref_customer_id')
        ->whereNull('so.so_deleted_at');

        if(Auth::user()->role == 'agent') {
            $get = $get->where('so.so_created_at_ref_user_id',Auth::user()->id);
        }

        if($type == 'success') {
            $get = $get->where('so.so_status','ลูกค้ารับสินค้า');
        }

        return $get;
    }

    static public function province_html($selected = '')
    {

        $get = DB::table('cag_area_provinces')->where('id',$selected)->first();

		//dd($get);
		$html = '';
		if($get != '') {
        	$html .= $get->name_in_thai;
		}

        return $html;
    }

    static public function district_html($selected = '')
    {
        $get = DB::table('cag_area_districts')->where('id',$selected);

        $get = $get->first();

		$html = '';
		if($get != '') {
        	$html .= $get->name_in_thai;
		}

        return $html;
    }

    static public function subdistrict_html($selected = '')
    {
        $get = DB::table('cag_area_subdistricts')->where('id',$selected);

        $get = $get->first();

		$html = '';
		if($get != '') {
        	$html .= $get->name_in_thai;
		}

        return $html;
    }

    static public function datatables_history_call($post = [],$type = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_call_result as cr')
        ->join('dash_status_call as sc','sc.id','=','cr.cr_status')
        ->join('dash_customer as c','c.customer_id','=','cr.cr_customer_id')
        ->whereNull('cr.cr_deleted_at');

        if(Auth::user()->role == 'agent') {
            $get = $get->where('cr.cr_created_at_ref_user_id',Auth::user()->id);
        }

        if($type == 'complete') {
            $get = $get->where('sc.sts_type','ติดต่อได้');
        }else if($type == 'disconnect') {
            $get = $get->where('sc.sts_type','ยังติดต่อไม่ได้');
        }else if($type == 'cancel') {
            $get = $get->where('sc.sts_type','ยกเลิกการติดต่อ');
        }

        return $get;
    }

    static public function call_history_customer($id)
    {
        $get = DB::table('dash_call_result as cr')
        ->join('dash_status_call as sc','sc.id','=','cr.cr_status')
        ->join('dash_customer as c','c.customer_id','=','cr.cr_customer_id')
        ->where('cr_customer_id',$id)
        ->whereNull('cr.cr_deleted_at')
        ->orderBy('cr.id','DESC')
        ->limit(10)->get();

        if(!$get) {
            return [];
        }
        return $get;
    }

    static public function last_result_call($id)
    {
        $get = DB::table('dash_call_result as cr')
        ->join('dash_status_call as sc','sc.id','=','cr.cr_status')
        ->join('dash_customer as c','c.customer_id','=','cr.cr_customer_id')
        ->where('cr_customer_id',$id)
        ->whereNull('cr.cr_deleted_at')
        ->orderBy('cr.id','DESC')
        ->first();

        if(!$get) {
            return [];
        }

        if($get->sts_type == 'ติดต่อได้') {
            $html = '<span class="label label-primary">'.$get->sts_text.'</span>';
        } else if($get->sts_type == 'ยังติดต่อไม่ได้') {
            $html = '<span class="label label-info">'.$get->sts_text.'</span>';
        } else if($get->sts_type == 'ยกเลิกการติดต่อ') {
            $html = '<span class="label label-danger">'.$get->sts_text.'</span>';
        }

        return $html;
    }

    static public function last_result_call_date($id)
    {
        $get = DB::table('dash_call_result as cr')
        ->join('dash_status_call as sc','sc.id','=','cr.cr_status')
        ->join('dash_customer as c','c.customer_id','=','cr.cr_customer_id')
        ->where('cr_customer_id',$id)
        ->whereNull('cr.cr_deleted_at')
        ->orderBy('cr.id','DESC')
        ->first();

        if(!$get) {
            return [];
        }

        $html = $get->cr_created_at;

        return $html;
    }

    static public function datatables_report_invoice($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('dash_product_order as po')
        ->join('dash_sale_order as so','po.ref_so_id','=','so.id')
        ->join('dash_customer as c','c.customer_id','=','so.ref_customer_id')
        ->join('dash_product as p','p.product_id','=','po.product_id')
        ->join('account_admin as ad','ad.id','=','so_created_at_ref_user_id');

        return $get;
    }

    static public function first_location()
    {
        $get = DB::table('dash_location')
        ->first();

        if(!$get) {
            return [];
        }

        return $get;
    }

    static public function count_location()
    {
        $get = DB::table('dash_location')
        ->count();

        if(!$get) {
            return [];
        }

        return $get;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    static public function name_account($id)
    {
        if($id != '') {
            $first = DB::table('account_admin')
            ->where('id',$id)
            ->first();

            if(!$first) {
                return [];
            }

            $name = $first->name;
            return $name;
        }else {
            $name = '';
            return $name;
        }
    }

    static public function province_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_area_provinces')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name_in_thai.'</option>';
            }
        }

        return $html;
    }

    static public function district_option_html($selected = '', $text_first = '',$province_id = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_area_districts');

        if(@$province_id) {
            $get = $get->where('province_id',$province_id);
        }

        $get = $get->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name_in_thai.'</option>';
            }
        }

        return $html;
    }

    static public function subdistrict_option_html($selected = '', $text_first = '', $district_id)
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_area_subdistricts');

        if(@$district_id) {
            $get = $get->where('district_id',$district_id);
        }

        $get = $get->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name_in_thai.'</option>';
            }
        }

        return $html;
    }

    static public function assigned_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('account_admin')->where('role','agent')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name.'</option>';
            }
        }

        return $html;
    }

    static public function merchandize_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('account_admin')->where('role','merchandize')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name.'</option>';
            }
        }

        return $html;
    }

    static public function img_account($id)
    {
        if($id != '') {
            $first = DB::table('account_admin')
            ->where('id',$id)
            ->first();

            if(!$first) {
                return [];
            }

            $name = $first->img_name;
            return $name;
        }else {
            $name = '';
            return $name;
        }
    }

    static public function name_province($id)
    {
        $first = DB::table('cag_area_provinces')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }

        $name = $first->name_in_thai;
        return $name;
    }

    static public function name_district($id)
    {
        $first = DB::table('cag_area_districts')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }

        $name = $first->name_in_thai;
        return $name;
    }

    static public function name_subdistrict($id)
    {
        $first = DB::table('cag_area_subdistricts')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }

        $name = $first->name_in_thai;
        return $name;
    }

    static public function datatables_log($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('log_backend_login');

        return $get;
    }

    static public function category_option_html($selected = '', $text_first = '',$type = '')
    {

        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('mtw_v2_category')->where('type',$type)->whereNull('deleted_at')->get();
        // Log::debug($get);

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->cate_name.'</option>';
            }
        }

        return $html;
    }

    static public function cate_name($id)
    {
        if($id != '') {
            $first = DB::table('mtw_v2_category')
            ->where('id',$id)
            ->first();

            if(!$first) {
                return [];
            }

            $name = $first->cate_name;
            return $name;
        }else {
            $name = '';
            return $name;
        }
    }

    static public function first_product($id)
    {
        $first = DB::table('mtw_v2_product')
        ->whereNull('deleted_at')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }
    static public function first_hotel($id)
    {
        $first = DB::table('mtw_v2_hotels')
        ->whereNull('deleted_at')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }
    static public function first_all($id,$table)
    {
        $first = DB::table($table)
        ->whereNull('deleted_at')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function first_attraction($id)
    {
        $first = DB::table('mtw_v2_attractions')
        ->whereNull('deleted_at')
        ->where('id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }


}
