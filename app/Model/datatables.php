<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

####### Include
use Auth;
use DB;
use Agent;

class datatables extends Model
{
    static public function datatables_category($post = [],$type = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('fti_category')
        ->where('type',$type)
        ->whereNull('deleted_at');

        return $get;
    }

    static public function datatables_product($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('fti_product')
        ->whereNull('deleted_at');

        return $get;
    }
    static public function datatables_hotel($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('fti_hotels')
        ->whereNull('deleted_at');

        return $get;
    }

    static public function datatables_product_img_slide($post = [],$id)
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }

        $get = DB::table('fti_slide_img')
        ->where('type','product')
        ->where('ref_id',$id)
        ->whereNull('deleted_at');

        return $get;
    }

    static public function datatables_attraction($post = [])
    {
        foreach (@$post as $key => $value){
            ${$key} = $value;
        }

        $get = DB::table('fti_attractions')
        ->whereNull('deleted_at');

        return $get;
    }
}
