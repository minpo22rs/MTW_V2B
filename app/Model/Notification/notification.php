<?php

namespace App\Model\Notification;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Carbon\Carbon;

####### Include
use Auth;
use DB;
use Agent;
use General;

class notification extends Model
{
    protected $table = 'dash_notification';
    protected $primaryKey = 'noti_id';

    static public function log($noti_type = '',$noti_ref_log_id = null,$noti_ref_product_id = null,$noti_ref_sale_order_id = null,$time = null)
    {
        // dd(@Auth::user()->id);
        DB::table('dash_notification')
        ->insert([
            'noti_ref_user_id'                  => @Auth::user()->id,
            'noti_type'                         => @$noti_type,
            'noti_ref_log_id'                   => (@$noti_ref_log_id != '') ? $noti_ref_log_id : null,
            'noti_ref_product_id'               => (@$noti_ref_product_id != '') ? $noti_ref_product_id : null,
            'noti_ref_sale_order_id'            => (@$noti_ref_sale_order_id != '') ? $noti_ref_sale_order_id : null,
            'noti_few_product_date'             => (@$time != '') ? $time : null,
        ]);
        $id  = DB::getPdo()->lastInsertId();
        return $id;
    }

    static public function notification($type = '') 
    {
        $date = date('Y-m-d H:i:s');
        $callback = DB::table('dash_notification as dn')
        ->join('dash_call_result as dcr','dcr.id','=','dn.noti_ref_log_id')
        ->where([['noti_ref_user_id',Auth::user()->id],['noti_type','callback'],['dcr.cr_noti_date','<=',$date]])
        ->select('dn.*','dcr.cr_customer_id')
        ->get();
        
        $callagain = DB::table('dash_notification as dn')->where([['noti_ref_user_id',Auth::user()->id],['noti_few_product_date','<=',$date]])->get();

        $array1 = json_decode(json_encode($callback), FALSE);
        $array2 = json_decode(json_encode($callagain), FALSE);

        $first = array_merge($array1,$array2);


        $novel_updated_at = array_column($first, 'noti_updated_at');

        array_multisort($novel_updated_at, SORT_DESC, $first);
        // dd($first);

        $collect = collect($first)->count();

        if($type == '') {
            return $first;
        }else {
            return $collect;
        }
    }

    static public function noti_text($id) 
    {
        $log = DB::table('dash_call_result')->where('id',$id)->first();
        $customer = DB::table('dash_customer')->where('customer_id',$log->cr_customer_id)->first();
        $html = '';
        $html .= 
        '<p class="notification-msg">'.$customer->customer_name.' '.$customer->customer_lastname.' ('.$customer->customer_mem_id.')</p>
        <p class="notification-msg">นัดเวลาโทรกลับ '.$log->cr_date.'</p>
        <p class="notification-msg">แจ้งเตือนก่อนถึงเวลานัด ';

        if($log->cr_day != 0) {
            $html .= $log->cr_day.' วัน ';
        }
        if($log->cr_hour != 0) {
            $html .= $log->cr_hour.' ชั่วโมง ';
        }
        if($log->cr_minute != 0) {
            $html .= $log->cr_minute.' นาที ';
        }
        
        $html .= '</p>
        <span class="notification-time">'.\App\Helpers\General::gen_date_content($log->cr_noti_date,'en').'</span>';

        return $html;
    }

    static public function noti_text_few($id) 
    {
        $log = DB::table('dash_notification')->where('noti_id',$id)->first();
        $order = DB::table('dash_sale_order')->where('id',$log->noti_ref_sale_order_id)->first();
        $customer = DB::table('dash_customer')->where('customer_id',$order->ref_customer_id)->first();
        $html = '';
        $html .= 
        '<p class="notification-msg">'.$customer->customer_name.' '.$customer->customer_lastname.' ('.$customer->customer_mem_id.')</p>
        <p class="notification-msg">เลข Order '.$order->so_num_id.'</p>';
        
        $html .= '</p>
        <span class="notification-time">'.\App\Helpers\General::gen_date_content($log->noti_few_product_date,'en').'</span>';

        return $html;
    }
}