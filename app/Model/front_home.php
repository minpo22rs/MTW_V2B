<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

####### Include
use Auth;
use DB;
use Agent;
use General;

class front_home extends Model
{
    static public function datatables_banner_slide($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_banner_slide')
        ->whereNull('banner_slide_deleted_at');

        return $get;
    }

    static public function first($id)
    {
        $first = DB::table('cag_banner_slide')
        ->whereNull('banner_slide_deleted_at')
        ->where('banner_slide_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front()
    {
        $first = DB::table('cag_banner_slide')
        ->whereNull('banner_slide_deleted_at')
        ->where('banner_slide_active','1')
        ->orderBy('banner_slide_sort','asc');

        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function datatables_how_it_work($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_how_it_work')
        ->whereNull('how_it_work_deleted_at');

        return $get;
    }

    static public function first_hiw($id , $type = '' , $lang = '')
    {
        $first = DB::table('cag_how_it_work')
        ->whereNull('how_it_work_deleted_at');

        if($id){
            $first = $first->where('how_it_work_id',$id);
        }

        if($type) {
            $first = $first->where('how_it_work_mode',$type);
        }

        if($lang == 'th') {
            $first = $first->select('how_it_work_id','how_it_work_topic_th as how_it_work_topic','how_it_work_detail_th as how_it_work_detail','how_it_work_img_name');
        }else if($lang == 'en') {
            $first = $first->select('how_it_work_id','how_it_work_topic as how_it_work_topic','how_it_work_detail as how_it_work_detail','how_it_work_img_name');
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_hiw($type = '',$lang = '')
    {
        $first = DB::table('cag_how_it_work')
        ->whereNull('how_it_work_deleted_at')
        ->where('how_it_work_active','1')
        ->orderBy('how_it_work_sort','asc');

        if($type) {
            $first = $first->where('how_it_work_mode',$type);
        }

        if($lang == 'th') {
            $first = $first->select('how_it_work_id','how_it_work_topic_th as how_it_work_topic','how_it_work_detail_th as how_it_work_detail','how_it_work_img_name');
        }else if($lang == 'en') {
            $first = $first->select('how_it_work_id','how_it_work_topic as how_it_work_topic','how_it_work_detail as how_it_work_detail','how_it_work_img_name');
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function how_it_work_mode_option_html($selected = '')
    {
        $html  = '';
        $html .= '<option value="head" '.($selected == "head" ? 'selected' : '').'>Header</option>';
        $html .= '<option value="list" '.($selected == "list" ? 'selected' : '').'>List</option>';

        return $html;
    }

    static public function datatables_content_tag($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_content_tag')
        ->whereNull('content_tag_deleted_at');

        return $get;
    }

    static public function first_ct($id)
    {
        $first = DB::table('cag_content_tag')
        ->whereNull('content_tag_deleted_at')
        ->where('content_tag_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_ct($lang = '')
    {
        $first = DB::table('cag_content_tag')
        ->whereNull('content_tag_deleted_at')
        ->where('content_tag_active','1')
        ->orderBy('content_tag_sort','asc');

        if($lang == 'th') {
            $first = $first->select('content_tag_id','content_tag_topic_th as content_tag_topic');
        }else if($lang == 'en') {
            $first = $first->select('content_tag_id','content_tag_topic as content_tag_topic');
        }
        
        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function content_tag_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_content_tag')
        ->whereNull('content_tag_deleted_at')
        ->where('content_tag_active','1')
        ->orderBy('content_tag_sort','asc')
        ->get();
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->content_tag_id.'" '.($selected == $v->content_tag_id ? 'selected' : '').'>'.$v->content_tag_topic.'</option>';
            }
        }

        return $html;
    }

    static public function datatables_content($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_content')
        ->whereNull('content_deleted_at');

        return $get;
    }

    static public function first_c($id , $lang = '')
    {
        $first = DB::table('cag_content')
        ->whereNull('content_deleted_at')
        ->where('content_id',$id);

        if($lang == 'th') {
            $first = $first->select('content_id','ref_content_tag_id','content_route','content_tag_name_th as content_tag_name','content_topic_th as content_topic','content_full_description_th as content_full_description'
            ,'content_short_description_th as content_short_description','content_img_name','content_updated_at','content_meta_title','content_meta_keyword','content_meta_description');
        }else if($lang == 'en') {
            $first = $first->select('content_id','ref_content_tag_id','content_route','content_tag_name as content_tag_name','content_topic as content_topic','content_full_description as content_full_description'
            ,'content_short_description as content_short_description','content_img_name','content_updated_at','content_meta_title','content_meta_keyword','content_meta_description');
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_c($ref_id = '',$paginate = '' ,$lang = '' , $owned = '')
    {
        $first = DB::table('cag_content')
        ->whereNull('content_deleted_at')
        ->where('content_active','1')
        ->orderBy('content_sort','desc');
        
        if($ref_id){
            $first = $first->where('ref_content_tag_id',$ref_id);
        }

        if($owned){
            $first = $first->where('content_id','!=',$owned);
        }

        if($lang == 'th') {
            $first = $first->select('content_id','ref_content_tag_id','content_route','content_tag_name_th as content_tag_name','content_topic_th as content_topic','content_short_description_th as content_short_description','content_img_name','content_updated_at');
        }else if($lang == 'en') {
            $first = $first->select('content_id','ref_content_tag_id','content_route','content_tag_name as content_tag_name','content_topic as content_topic','content_short_description as content_short_description','content_img_name','content_updated_at');
        }

        if($paginate != ''){
            $first = $first->paginate($paginate);
        }else {
            $first = $first->get();
        }

        if(!$first) {
            return [];
        }

        if(@$first) {
            foreach($first as $k => $v) {
                $route = General::str_slug($v->content_route, '-');
                $subject = General::str_slug($v->content_topic, '-');
                $first[$k]->url = ($route ? $route.'-'.$v->content_id : $subject.'-'.$v->content_id);
            }
        }
        
        return $first;
    }

    static public function datatables_social($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_social')
        ->whereNull('social_deleted_at');

        return $get;
    }

    static public function first_s($id)
    {
        $first = DB::table('cag_social')
        ->whereNull('social_deleted_at')
        ->where('social_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_s()
    {
        $first = DB::table('cag_social')
        ->whereNull('social_deleted_at')
        ->where('social_active','1')
        ->orderBy('social_sort','asc')
        ->get();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_article($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_article')
        ->whereNull('article_deleted_at');

        return $get;
    }

    static public function first_article($id)
    {
        $first = DB::table('cag_article')
        ->whereNull('article_deleted_at')
        ->where('article_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function first_section_article($section)
    {
        $first = DB::table('cag_article')
        ->whereNull('article_deleted_at')
        ->where('article_active','1')
        ->where('article_section',$section)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_article($type='' , $lang = '')
    {
        $first = DB::table('cag_article')
        ->whereNull('article_deleted_at')
        ->where('article_active','1')
        ->orderBy('article_section','asc');

        if($type){
            $first = $first->where('article_type',$type);
        }

        if($lang == 'th') {
            $first = $first->select('article_id','article_section','article_topic_th as article_topic','article_content_th as article_content','article_img_name');
        }else if($lang == 'en') {
            $first = $first->select('article_id','article_section','article_topic_en as article_topic','article_content_en as article_content','article_img_name');
        }
        
        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function article_type_option_html($selected = '')
    {
        $html  = '';
        $html .= '<option value="first" '.($selected == "first" ? 'selected' : '').'>get started</option>';
        $html .= '<option value="normal" '.($selected == "normal" ? 'selected' : '').'>ปกติ</option>';
        $html .= '<option value="replenish" '.($selected == "replenish" ? 'selected' : '').'>replenished</option>';

        return $html;
    }

    static public function province_option_html($selected = '', $text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_area_provinces')->get();
        
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name_in_thai.' / '.$v->name_in_english.'</option>';
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
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name_in_thai.' / '.$v->name_in_english.'</option>';
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
                $html .= '<option value="'.$v->id.'" '.($selected == $v->id ? 'selected' : '').'>'.$v->name_in_thai.' / '.$v->name_in_english.'</option>';
            }
        }

        return $html;
    }

    static public function front_address_customer($ref_id = '' , $lang = '')
    {
        $first = DB::table('cag_customer_address')
        ->whereNull('customer_address_deleted_at')
        ->where('customer_address_active','1');
        
        if(@$ref_id) {
            $first = $first->where('ref_customer_id',$ref_id);
        }

        if($lang == 'th') {
            $first = $first->select('customer_address_id','customer_address_active','customer_address_default','customer_address_address','customer_address_province_th as customer_address_province',
            'customer_address_district_th as customer_address_district','customer_address_sub_district_th as customer_address_sub_district','customer_address_postcode');
        }else if($lang == 'en') {
            $first = $first->select('customer_address_id','customer_address_active','customer_address_default','customer_address_address','customer_address_province_en as customer_address_province',
            'customer_address_district_en as customer_address_district','customer_address_sub_district_en as customer_address_sub_district','customer_address_postcode');
        }

        $first = $first->get();
        
        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function first_address_customer($ref_id = '')
    {
        $first = DB::table('cag_customer_address')
        ->whereNull('customer_address_deleted_at')
        ->where('customer_address_active','1');

        if(@$ref_id)
        {
            $first = $first->where('ref_customer_id',$ref_id);
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function check_default($ref_id = '')
    {
        $first = DB::table('cag_customer_address')
        ->whereNull('customer_address_deleted_at')
        ->where('customer_address_active','1');

        $first = $first->where('customer_address_default','pin');

        if(@$ref_id)
        {
            $first = $first->where('ref_customer_id',$ref_id);
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function front_review($ref_id = '' , $user_id = '' , $sort = '' , $paginate = '')
    {
        $first = DB::table('cag_product_review')
        ->whereNull('review_deleted_at')
        ->where('review_active','1');

        if($sort) {
            $first = $first->orderBy($sort,'desc');
        } else {
            $first = $first->orderBy('review_id','desc');
        }

        if(@$ref_id) {
            $first = $first->where('ref_product_id',$ref_id);
        }

        if(@$user_id) {
            $first = $first->where('ref_customer_id',$user_id);
        }

        if(@$paginate) {
            $first = $first->paginate($paginate);
        }else {
            $first = $first->get();
        }

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function front_image($ref_id = '' , $paginate = '')
    {
        $first = DB::table('cag_product_review_image')
        ->whereNull('image_deleted_at')
        ->where('image_active','1')
        ->orderBy('image_id','asc');

        if(@$ref_id) {
            $first = $first->where('ref_review_id',$ref_id);
        }

        if(@$paginate) {
            $first = $first->paginate($paginate);
        }else {
            $first = $first->get();
        }

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function count_star($id)
    {
        $first = DB::table('cag_product_review as review')
        ->whereNull('review_deleted_at')
        ->where('ref_product_id',$id)
        ->where('review_active','1')
        ->select(
            //Count Star
            DB::Raw('(Select count(review_id) From cag_product_review as review_in Where review_in.ref_product_id = review.ref_product_id And review_in.review_star = "5" ) as count_star_5'),
            DB::Raw('(Select count(review_id) From cag_product_review as review_in Where review_in.ref_product_id = review.ref_product_id And review_in.review_star = "4" ) as count_star_4'),
            DB::Raw('(Select count(review_id) From cag_product_review as review_in Where review_in.ref_product_id = review.ref_product_id And review_in.review_star = "3" ) as count_star_3'),
            DB::Raw('(Select count(review_id) From cag_product_review as review_in Where review_in.ref_product_id = review.ref_product_id And review_in.review_star = "2" ) as count_star_2'),
            DB::Raw('(Select count(review_id) From cag_product_review as review_in Where review_in.ref_product_id = review.ref_product_id And review_in.review_star = "1" ) as count_star_1'),
            //Count Review
            DB::Raw('(Select count(review_id) From cag_product_review as review_in Where review_in.ref_product_id = review.ref_product_id And review_content is not null ) as count_review'),
            //Avg Star
            DB::Raw('(Select ROUND(AVG(review_star),1) From cag_product_review as review_in Where review_in.ref_product_id = review.ref_product_id) as avg_star')
        );

        $first = $first->first();
        
        return @$first;
    }

    static public function star_html($score, $type = '')
    {
        $html = '';
        for($x=0;$x<5;$x++) {
            if(floor(@$score) > $x) {
                $html .= '<li><i class="fas fa-star"></i></li> ';
            } else {
                if($type == 'product_rating') {
                    $html .= '<li><i class="fas fa-star" style="color:gray;"></i></li> ';
                } else {
                    $html .= '<li><i class="fas fa-star" style="color:gray;"></i></li>';
                }
            }
        }
        
        return $html;
    }

    static public function star_html_bk($score, $type = '')
    {
        $html = '';
        for($x=0;$x<5;$x++) {
            if(floor(@$score) > $x) {
                $html .= '<a href="!#"><i class="fa fa-star f-18 text-c-blue"></i></a> ';
            } else {
                if($type == 'product_rating') {
                    $html .= '<a href="!#"><i class="fa fa-star f-18 text-default"></i></a> ';
                } else {
                    $html .= '<a href="!#"><i class="fa fa-star f-18 text-default"></i></a>';
                }
            }
        }
        
        return $html;
    }

    static public function star_per_review($score_s = '',$score_r = '')
    {
        $per = ($score_s/$score_r)*100;
        $html = '';
        $html .= '<div class="progress-bar" role="progressbar" style="width: '.$per.'%;" aria-valuenow="'.$per.'" aria-valuemin="0" aria-valuemax="100"></div>';

        return $html;
    }

    static public function front_card_customer($ref_id = '')
    {
        $first = DB::table('cag_customer_card as cc')
        ->join('cag_credit_card as ct','cc.ref_payment_id','=','ct.credit_card_number')
        ->where('cc.card_active','1');

        if($ref_id) {
            $first = $first->where('cc.ref_customer_id',$ref_id);
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function check_card_default($ref_id = '')
    {
        $first = DB::table('cag_customer_card')
        ->whereNull('card_deleted_at')
        ->where('card_active','1');

        if(@$ref_id)
        {
            $first = $first->where('ref_customer_id',$ref_id);
        }

        $first = $first->where('card_default','pin');
        
        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function first_card_customer($ref_id = '')
    {
        $first = DB::table('cag_customer_card')
        ->where('ref_customer_id',Auth::guard('ecom_customer')->user()->id)
        ->where('card_active','1');

        if($ref_id) {
            $first = $first->where('card_id',$ref_id);
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function first_card($ref_id = '')
    {
        $first = DB::table('cag_customer_card as cc')
        ->join('cag_credit_card as ct','cc.ref_payment_id','=','ct.credit_card_number')
        ->where('cc.card_active','1');

        if($ref_id) {
            $first = $first->where('cc.card_id',$ref_id);
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function datatables_security($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_security')
        ->whereNull('sec_deleted_at');

        return $get;
    }

    static public function first_security($ref_id = '')
    {
        $first = DB::table('cag_security')
        ->where('sec_active','1');

        if($ref_id) {
            $first = $first->where('sec_id',$ref_id);
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function front_security($type = '',$lang = '')
    {
        $first = DB::table('cag_security')
        ->where('sec_active','1');

        if($type) {
            $first = $first->where('sec_type',$type);
        }

        if($lang == 'th') {
            $first = $first->select('sec_id','sec_active','sec_type','sec_header_th as sec_header','sec_content_th as sec_content');
        }else if($lang == 'en') {
            $first = $first->select('sec_id','sec_active','sec_type','sec_header as sec_header','sec_content as sec_content');
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        
        return $first;
    }

    static public function sec_type_option_html($selected = '')
    {
        $html  = '';
        $html .= '<option value="terms" '.($selected == "terms" ? 'selected' : '').'>Terms</option>';
        $html .= '<option value="privacy" '.($selected == "privacy" ? 'selected' : '').'>Privacy</option>';

        return $html;
    }

}