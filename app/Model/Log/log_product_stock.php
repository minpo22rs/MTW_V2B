<?php

namespace App\Model\Log;

use Illuminate\Database\Eloquent\Model;

####### Include
use Auth;
use DB;

class log_product_stock extends Model
{
    protected $table = 'log_product_stock';
    protected $primaryKey = 'id';

    static public function log($type,$stock,$ref_product_id,$ref_sale_order_id = null)
    {
        $name = \App\Model\dashboard::name_account(@Auth::user()->id);
        $product = \App\Model\dashboard::product_name($ref_product_id);
        DB::table('log_product_stock')
        ->insert([
            'type'                      => $type,
            'ref_input_id'              => $name,
            'stock'                     => $stock,
            'ref_product_id'            => $product,
            'ref_sale_order_id'         => $ref_sale_order_id
        ]);
        $id  = DB::getPdo()->lastInsertId();
        return $id;
    }
}
