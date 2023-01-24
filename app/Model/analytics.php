<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Str;

####### Include
use Auth;
use DB;
use Agent;

class analytics extends Model
{
    static public function list_customer()
    {
        $customer = DB::table('dash_customer');
        
        if(Auth::user()->role == 'agent') {
            $customer = $customer->where('ref_sale_id',Auth::user()->id);
        }
        
        $customer = $customer->count();

        return $customer;
    }

    static public function list_call_customer_per_month()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $customer = DB::table('log_call_center');
        
        if(Auth::user()->role == 'agent') {
            $customer = $customer->where('call_center_username',Auth::user()->id);
        }

        $customer = $customer->where('call_center_created_at','>=',$date)->count();

        return $customer;
    }

    static public function list_call_customer_per_day()
    {
        $date = date('Y-m-d');
        $now = $date.' 00:00:00';
        $customer = DB::table('log_call_center');
        
        if(Auth::user()->role == 'agent') {
            $customer = $customer->where('call_center_username',Auth::user()->id);
        }

        $customer = $customer->where('call_center_created_at','>=',$now)->count();
        
        return $customer;
    }

    static public function list_call_customer_left()
    {
        $customer = DB::table('dash_customer');
        
        if(Auth::user()->role == 'agent') {
            $customer = $customer->where('ref_sale_id',Auth::user()->id);
        }
        
        $customer = $customer->count();

        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 

        $sum_call = DB::table('log_call_center');
        
        if(Auth::user()->role == 'agent') {
            $sum_call = $sum_call->where('call_center_username',Auth::user()->id);
        }

        $sum_call = $sum_call->where('call_center_created_at','>=',$date)->count();
        
        $result = $customer - $sum_call;

        return $result;
    }

    static public function target()
    {
        $target = DB::table('account_admin')->where('id',Auth::user()->id)->first();
        $result = $target->cost_target;

        return $result;
    }

    static public function sale_order_accumulate_per_month()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at_ref_user_id',Auth::user()->id],['so_created_at','>=',$date],['so_status','!=','ยกเลิกออเดอร์']])->sum('so_sum_price');
        
        return $so;
    }

    static public function sale_order_per_day()
    {
        $date = date('Y-m-d');
        $now = $date.' 00:00:00';
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$now],['so_status','!=','ยกเลิกออเดอร์']]);

        if(Auth::user()->role == 'agent') {
            $so = $so->where('so_created_at_ref_user_id',Auth::user()->id);
        }
        
        $so = $so->sum('so_sum_price');

        return $so;
    }

    static public function on_target()
    {
        $target = DB::table('account_admin')->where('id',Auth::user()->id)->first();
        $result = $target->cost_target;
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at_ref_user_id',Auth::user()->id],['so_created_at','>=',$date],['so_status','!=','ยกเลิกออเดอร์']])->sum('so_sum_price');
        $different = $result - $so;

        return $different;
    }

    static public function sum_circulation()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','!=','ยกเลิกออเดอร์']])->sum('so_sum_price');

        return $so;
    }

    static public function sum_order_invoice()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','ออกอินวอยซ์']])->sum('so_sum_price');

        return $so;
    }

    static public function sum_order_waiting_verify()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','รอตรวจสอบ']])->sum('so_sum_price');

        return $so;
    }

    static public function sum_order_shipping()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','กำลังจัดส่ง']])->sum('so_sum_price');

        return $so;
    }

    static public function sum_order_recive()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','ลูกค้ารับสินค้า']])->sum('so_sum_price');

        return $so;
    }

    static public function sum_order_not_recive()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','ลูกค้าปฏิเสธการรับสินค้า']])->sum('so_sum_price');

        return $so;
    }

    static public function count_all()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where('so_created_at','>=',$date)->count();

        return $so;
    }

    static public function count_order_recive()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','ลูกค้ารับสินค้า']])->count();

        return $so;
    }

    static public function count_order_not_recive()
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $so = DB::table('dash_sale_order')->where([['so_created_at','>=',$date],['so_status','ลูกค้าปฏิเสธการรับสินค้า']])->count();

        return $so;
    }

    static public function recent_order()
    {
        $so = DB::table('dash_sale_order as dso')
        ->join('dash_customer as dc','dc.customer_id','=','dso.ref_customer_id')
        ->orderBy('id','DESC')->limit(8)->get();

        return $so;
    }

    static public function product_per_month($type = '') 
    {
        $month = date('m');
        $pro = DB::table('dash_product_order as pro')
        ->join('dash_sale_order as so','so.id','=','pro.ref_so_id')
        ->join('dash_product as dp','dp.product_id','=','pro.product_id')
        ->where('so.so_date','LIKE','%-'.$month.'-%')
        ->whereNotIn('dp.product_type',['2','3'])
        ->select(DB::raw('SUM(pro.product_sum_price) as product_count'),'dp.product_name')
        ->groupby('dp.product_name')->orderBy('product_count','DESC')->get();

        if($pro->count() == 0) {
            return json_encode([]);
        }

        foreach($pro as $p) {
            $count[] = $p->product_count;
            $name[] = $p->product_name;
        }
        if($type != '') {
            $array = json_encode($count);
        }else {
            $array = json_encode($name);
        }

        return $array;
    }

    static public function product_per_day($type = '') 
    {
        $date = date('Y-m-d');
        $pro = DB::table('dash_product_order as pro')
        ->join('dash_sale_order as so','so.id','=','pro.ref_so_id')
        ->join('dash_product as dp','dp.product_id','=','pro.product_id')
        ->where('so.so_date',$date)
        ->whereNotIn('dp.product_type',['2','3'])
        ->select(DB::raw('SUM(pro.product_sum_price) as product_count'),'dp.product_name')
        ->groupby('dp.product_name')->orderBy('product_count','DESC')->get();
        if($pro->count() == 0) {
            return json_encode([]);
        }

        foreach($pro as $p) {
            $count[] = $p->product_count;
            $name[] = $p->product_name;
        }
        if($type != '') {
            $array = json_encode($count);
        }else {
            $array = json_encode($name);
        }

        return $array;
    }

    static public function product_top_10($type = '') 
    {
        $pro = DB::table('dash_product_order as pro')
        ->join('dash_sale_order as so','so.id','=','pro.ref_so_id')
        ->join('dash_product as dp','dp.product_id','=','pro.product_id')
        ->whereNotIn('dp.product_type',['2','3'])
        ->select(DB::raw('COUNT(pro.id) as product_count'),'dp.product_name')
        ->groupby('dp.product_name')->orderBy('product_count','DESC')->limit(10)->get();

        if($pro->count() == 0) {
            return json_encode([]);
        }
        foreach($pro as $p) {
            $count[] = $p->product_count;
            $name[] = $p->product_name;
        }
        if($type != '') {
            $array = json_encode($count);
        }else {
            $array = json_encode($name);
        }

        return $array;
    }

    static public function list_call_customer_per_month_id($id)
    {
        $month = date('m');
        $date = date('Y').'-'.$month.'-01 00:00:00'; 
        $customer = DB::table('log_call_center');
        $customer = $customer->where('call_center_username',$id);

        $customer = $customer->where('call_center_created_at','>=',$date)->count();

        return $customer;
    }
    
}
