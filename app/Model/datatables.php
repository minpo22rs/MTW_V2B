<?php

namespace App\Model;

####### Include
use DB;
use Illuminate\Database\Eloquent\Model;

class datatables extends Model
{
    public static function datatables_category($post = [], $type = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_category')
            ->where('type', $type)
            ->whereNull('deleted_at');

        return $get;
    }
    public static function datatables_all($post = [], $table)
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table($table)
            ->whereNull('deleted_at');

        return $get;
    }
    public static function datatables_product($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_product')
            ->whereNull('deleted_at');

        return $get;
    }
    public static function datatables_hotel($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_hotels')
            ->whereNull('deleted_at');

        return $get;
    }

    public static function datatables_product_img_slide($post = [], $id)
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_slide_img')
            ->where('type', 'product')
            ->where('ref_id', $id)
            ->whereNull('deleted_at');

        return $get;
    }

    public static function datatables_hotel_img_slide($post = [], $id)
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_slide_img')
            ->where('type', 'hotel')
            ->where('ref_id', $id)
            ->whereNull('deleted_at');

        return $get;
    }
    public static function datatables_restaurant_img_slide($post = [], $id)
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_slide_img')
            ->where('type', 'restaurant')
            ->where('ref_id', $id)
            ->whereNull('deleted_at');

        return $get;
    }
    public static function datatables_car_img_slide($post = [], $id)
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_slide_img')
            ->where('type', 'car')
            ->where('ref_id', $id)
            ->whereNull('deleted_at');

        return $get;
    }

    public static function datatables_attraction($post = [])
    {
        foreach (@$post as $key => $value) {
            ${$key} = $value;
        }

        $get = DB::table('mtw_v2_attractions')
            ->whereNull('deleted_at');

        return $get;
    }
}
