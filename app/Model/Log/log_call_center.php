<?php

namespace App\Model\Log;

use Illuminate\Database\Eloquent\Model;

####### Include
use Auth;
use DB;
use Agent;

class log_call_center extends Model
{
    protected $table = 'log_call_center';
    protected $primaryKey = 'call_center_id';

    static public function log($userId = '')
    {
        DB::table('log_call_center')
        ->insert([
            'call_center_username'                  => @Auth::user()->id,
            'call_center_customer'                  => $userId,
            'call_center_visitor'                   => \Request::ip(),
            'call_center_macaddress'                => '',
            'call_center_browser'                   => Agent::browser(),
            'call_center_device'                    => Agent::device(),
            'call_center_created_at'                => date('Y-m-d H:i:s'),
            'call_center_updated_at_ref_admin_id'   => @Auth::guard('ecom_customer')->user()->id
        ]);
        $id  = DB::getPdo()->lastInsertId();
        return $id;
    }
}
