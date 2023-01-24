<?php

namespace App\Model\Log;

use Illuminate\Database\Eloquent\Model;

####### Include
use Auth;
use DB;
use Agent;

class log_backend_login extends Model
{
    protected $table = 'log_backend_login';
    protected $primaryKey = 'backend_login_id';

    static public function log($detail = '', $status = 'L')
    {
        DB::table('log_backend_login')
        ->insert([
            'backend_login_status'      => $status, //F = รหัสผ่านผิดพลาด, S = เข้าระบบสำเร็จ, L = Log
            'backend_login_username'    => @Auth::user()->username,
            'backend_login_detail'      => $detail,
            'backend_login_visitor'     => \Request::ip(),
            'backend_login_macaddress'  => '',
            'backend_login_browser'     => Agent::browser(),
            'backend_login_device'      => Agent::device(),
            'backend_login_created_at'  => date('Y-m-d H:i:s'),
            'backend_login_updated_at_ref_admin_id' => @Auth::user()->id
        ]);
        $id  = DB::getPdo()->lastInsertId();
        return $id;
    }
}
