<?php

namespace App\Model\Log;

use Illuminate\Database\Eloquent\Model;

####### Include
use Auth;
use DB;
use Agent;

class log_frontend_login extends Model
{
    protected $table = 'log_frontend_login';
    protected $primaryKey = 'frontend_login_id';

    static public function log($detail = '', $status = 'L')
    {
        DB::table('log_frontend_login')
        ->insert([
            'frontend_login_status'      => $status, //F = รหัสผ่านผิดพลาด, S = เข้าระบบสำเร็จ, L = Log
            'frontend_login_username'    => @Auth::guard('ecom_customer')->user()->customer_email,
            'frontend_login_detail'      => $detail,
            'frontend_login_visitor'     => \Request::ip(),
            'frontend_login_macaddress'  => '',
            'frontend_login_browser'     => Agent::browser(),
            'frontend_login_device'      => Agent::device(),
            'frontend_login_created_at'  => date('Y-m-d H:i:s'),
            'frontend_login_updated_at_ref_customer_id' => @Auth::guard('ecom_customer')->user()->id
        ]);
        $id  = DB::getPdo()->lastInsertId();
        return $id;
    }
}
