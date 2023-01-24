<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

####### Include
use Auth;
use DB;
use Agent;

class master extends Model
{
    static public function datatables_faq_tag($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_faq_tag')
        ->whereNull('faq_tag_deleted_at');

        return $get;
    }

    static public function first_ftg($id)
    {
        $first = DB::table('cag_faq_tag')
        ->whereNull('faq_tag_deleted_at')
        ->where('faq_tag_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_ftg($lang = '')
    {
        $first = DB::table('cag_faq_tag')
        ->whereNull('faq_tag_deleted_at')
        ->where('faq_tag_active','1')
        ->orderBy('faq_tag_sort','asc');

        if($lang == 'th') {
            $first = $first->select('faq_tag_id','faq_tag_name_th as faq_tag_name');
        }else if($lang == 'en') {
            $first = $first->select('faq_tag_id','faq_tag_name as faq_tag_name');
        }
        
        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function datatables_faq_topic($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_faq_topic')
        ->whereNull('faq_topic_deleted_at');

        return $get;
    }

    static public function first_ftc($id)
    {
        $first = DB::table('cag_faq_topic')
        ->whereNull('faq_topic_deleted_at')
        ->where('faq_topic_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_ftc($ref_id='' , $lang = '')
    {
        $first = DB::table('cag_faq_topic')
        ->whereNull('faq_topic_deleted_at')
        ->where('faq_topic_active','1')
        ->orderBy('faq_topic_sort','asc');

        if($ref_id){
            $first = $first->where('ref_faq_tag_id',$ref_id);
        }
        
        if($lang == 'th') {
            $first = $first->select('faq_topic_id','faq_topic_name_th as faq_topic_name');
        }else if($lang == 'en') {
            $first = $first->select('faq_topic_id','faq_topic_name as faq_topic_name');
        }
        
        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }


    static public function faq_tag_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_faq_tag')
        ->whereNull('faq_tag_deleted_at')
        ->where('faq_tag_active','1')
        ->orderBy('faq_tag_sort','asc')
        ->get();
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->faq_tag_id.'" '.($selected == $v->faq_tag_id ? 'selected' : '').'>'.$v->faq_tag_name.'/ '.$v->faq_tag_name_th.'</option>';
            }
        }

        return $html;
    }

    static public function datatables_faq_qa($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_faq_qa')
        ->whereNull('faq_qa_deleted_at');

        return $get;
    }

    static public function first_fq($id)
    {
        $first = DB::table('cag_faq_qa')
        ->whereNull('faq_qa_deleted_at')
        ->where('faq_qa_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_fq($ref_id='' , $lang = '')
    {
        $first = DB::table('cag_faq_qa')
        ->whereNull('faq_qa_deleted_at')
        ->where('faq_qa_active','1')
        ->orderBy('faq_qa_sort','asc');

        if($ref_id){
            $first = $first->where('ref_faq_topic_id',$ref_id);
        }

        if($lang == 'th') {
            $first = $first->select('faq_qa_id','ref_faq_topic_id','faq_qa_question_th as faq_qa_question','faq_qa_answer_th as faq_qa_answer');
        }else if($lang == 'en') {
            $first = $first->select('faq_qa_id','ref_faq_topic_id','faq_qa_question as faq_qa_question','faq_qa_answer as faq_qa_answer');
        }
        
        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function faq_topic_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_faq_topic')
        ->whereNull('faq_topic_deleted_at')
        ->where('faq_topic_active','1')
        ->orderBy('faq_topic_sort','asc')
        ->get();
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->faq_topic_id.'" '.($selected == $v->faq_topic_id ? 'selected' : '').'>'.$v->faq_topic_name.'/ '.$v->faq_topic_name_th.'</option>';
            }
        }

        return $html;
    }

    static public function datatables_attribute($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_attribute')
        ->whereNull('attribute_deleted_at');

        return $get;
    }

    static public function first_attribute($id)
    {
        $first = DB::table('cag_attribute')
        ->whereNull('attribute_deleted_at')
        ->where('attribute_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function attribute_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_attribute')
        ->whereNull('attribute_deleted_at')
        ->where('attribute_active','1')
        ->orderBy('attribute_sort','asc')
        ->get();
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->attribute_topic.'" '.($selected == $v->attribute_topic ? 'selected' : '').'>'.$v->attribute_topic.'</option>';
            }
        }

        return $html;
    }

    static public function datatables_color($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_color')
        ->whereNull('color_deleted_at');

        return $get;
    }

    static public function first_color($id)
    {
        $first = DB::table('cag_color')
        ->whereNull('color_deleted_at')
        ->where('color_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function color_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_color')
        ->whereNull('color_deleted_at')
        ->where('color_active','1')
        ->orderBy('color_sort','asc')
        ->get();
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->color_id.'" '.($selected == $v->color_id ? 'selected' : '').'>
                                <button type="button" class="btn" style="border-radius: 50%; background: '.$v->color_code.';"></button>'.$v->color_name.
                        '</option>';
            }
        }

        return $html;
    }

    static public function datatables_bank($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_bank')
        ->whereNull('bank_deleted_at');

        return $get;
    }

    static public function first_bank($id)
    {
        $first = DB::table('cag_bank')
        ->whereNull('bank_deleted_at')
        ->where('bank_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_bank($lang = '')
    {
        $first = DB::table('cag_bank')
        ->whereNull('bank_deleted_at')
        ->where('bank_active','1')
        ->orderBy('bank_sort','asc');

        if($lang == 'th') {
            $first = $first->select('bank_id','bank_name_th as bank_name','bank_img_name');
        }else if($lang == 'en') {
            $first = $first->select('bank_id','bank_name as bank_name','bank_img_name');
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function price_show($price = '',$sale = '',$type='')
    {
        $html  = '';

        if($type == 'back') {
            if($price && $sale != ''){
                $html .= '<del style="color:gray;">฿'.$price.'</del>&nbsp;฿'.$sale;
            }else if ($price == '') {
                $html .= '฿'.$sale;
            }
        }else{
            if($price && $sale != ''){
                $html .= '<div class="full-price">฿'.$price.'</div>
                        <div class="price ">฿'.$sale.'</div>';
            }else if ($price == '') {
                $html .= '<div class="price ">฿'.$sale.'</div>';
            }
        }
        

        return $html;
    }

    static public function datatables_payment($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_type_payment')
        ->whereNull('payment_deleted_at');

        return $get;
    }

    static public function first_payment($id,$lang = '')
    {
        $first = DB::table('cag_type_payment')
        ->whereNull('payment_deleted_at')
        ->where('payment_active','1')
        ->where('payment_id',$id);

        if($lang == 'th') {
            $first = $first->select('payment_id','payment_name_th as payment_name');
        }else if($lang == 'en') {
            $first = $first->select('payment_id','payment_name as payment_name');
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_payment($lang = '')
    {
        $first = DB::table('cag_type_payment')
        ->whereNull('payment_deleted_at')
        ->where('payment_active','1')
        ->orderBy('payment_sort','asc');

        if($lang == 'th') {
            $first = $first->select('payment_id','payment_name_th as payment_name');
        }else if($lang == 'en') {
            $first = $first->select('payment_id','payment_name as payment_name');
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        return $first;
    }
    
    static public function option_about_payment($name = '', $lang = '')
    {
        //
    }

    static public function datatables_credit_card($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_credit_card')
        ->whereNull('credit_card_deleted_at');

        return $get;
    }

    static public function first_credit_card($id)
    {
        $first = DB::table('cag_credit_card')
        ->whereNull('credit_card_deleted_at')
        ->where('credit_card_active','1')
        ->where('credit_card_id',$id);

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_shipper($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_shipper')
        ->whereNull('shipper_deleted_at');

        return $get;
    }

    static public function first_shipper($id)
    {
        $first = DB::table('cag_shipper')
        ->whereNull('shipper_deleted_at')
        ->where('shipper_active','1')
        ->where('shipper_id',$id);

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function use_shipper()
    {
        $first = DB::table('cag_shipper')
        ->whereNull('shipper_deleted_at')
        ->where('shipper_active','1');

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_replenishment($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_get_start_round')
        ->whereNull('get_deleted_at');

        return $get;
    }

    static public function first_replen_round($id)
    {
        $first = DB::table('cag_get_start_round')
        ->whereNull('get_deleted_at')
        ->where('get_active','1')
        ->where('get_id',$id);

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_replen_round($lang)
    {
        $first = DB::table('cag_get_start_round')
        ->whereNull('get_deleted_at')
        ->where('get_active','1')
        ->orderBy('get_sort','asc');

        if($lang == 'th'){
            $first = $first->select('get_id','get_name_th as get_name','get_round','get_2_id');
        }else if($lang == 'en'){
            $first = $first->select('get_id','get_name as get_name','get_round','get_2_id');
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        return $first;
    }

}