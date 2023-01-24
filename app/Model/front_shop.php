<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

####### Include
use Auth;
use DB;
use Agent;
use General;

class front_shop extends Model
{
    static public function datatables_category($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_category')
        ->whereNull('category_deleted_at');

        return $get;
    }

    static public function first_category($id)
    {
        $first = DB::table('cag_category')
        ->whereNull('category_deleted_at')
        ->where('category_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }
    
    static public function front_category()
    {
        $first = DB::table('cag_category')
        ->whereNull('category_deleted_at')
        ->where('category_active','1')
        ->orderBy('category_sort','asc')
        ->get();

        if(!$first) {
            return [];
        }

        return $first;
    }

    static public function category_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_category')
        ->whereNull('category_deleted_at')
        ->where('category_active','1')
        ->orderBy('category_sort','asc')
        ->get();
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->category_id.'" '.($selected == $v->category_id ? 'selected' : '').'>'.$v->category_topic.'</option>';
            }
        }

        return $html;
    }

    static public function product_type_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="bundle" '.($selected == 'bundle' ? 'selected' : '').'>Bundle</option>';
        $html .= '<option value="normal" '.($selected == 'normal' ? 'selected' : '').'>Normal</option>';
        $html .= '<option value="get started" '.($selected == 'get started' ? 'selected' : '').'>Get Started</option>';

        return $html;
    }

    static public function datatables_product($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_product')
        ->whereNull('product_deleted_at');

        return $get;
    }

    static public function first_product($id,$lang = '')
    {
        $first = DB::table('cag_product')
        ->whereNull('product_deleted_at')
        ->where('product_id',$id);

        if($lang == 'th') {
            $first = $first->select('product_id','product_stock','product_name_th as product_name','product_value','product_attribute','product_normal_price','product_discount_price','product_route'
            ,'product_detail_th as product_detail','product_ingredients_th as product_ingredients','product_cate_name','product_meta_title','product_meta_keyword','product_meta_description');
        }else if($lang == 'en') {
            $first = $first->select('product_id','product_stock','product_name as product_name','product_value','product_attribute','product_normal_price','product_discount_price','product_route'
            ,'product_detail as product_detail','product_ingredients as product_ingredients','product_cate_name','product_meta_title','product_meta_keyword','product_meta_description');
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_property($post = [],$ref_id = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_product_property')
        ->whereNull('property_deleted_at');
        
        if($ref_id) {
            $get = $get->where('ref_product_id',$ref_id);
        }

        return $get;
    }

    static public function first_property($id)
    {
        $first = DB::table('cag_product_property')
        ->whereNull('property_deleted_at')
        ->where('property_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_color($post = [],$ref_id = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_product_color')
        ->whereNull('color_deleted_at');
        
        if($ref_id) {
            $get = $get->where('ref_product_id',$ref_id);
        }

        return $get;
    }

    static public function first_color($id)
    {
        $first = DB::table('cag_product_color')
        ->whereNull('color_deleted_at')
        ->where('color_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function color_option_html($selected = '' ,$ref_id = '' ,$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_product_color')
        ->whereNull('color_deleted_at')
        ->where('color_active','1');

        if($ref_id) {
            $get = $get->where('ref_product_id',$ref_id);
        }

        $get = $get->orderBy('color_sort','asc')->get();

        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->color_id.'" '.($selected == $v->color_id ? 'selected' : '').'>
                                <button type="button" class="btn" style="border-radius: 50%; background: '.$v->color_code.';"></button>'.$v->color_name.
                        '</option>';
            }
        }

        return $html;
    }

    static public function datatables_image($post = [],$ref_id = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_product_image')
        ->whereNull('image_deleted_at');
        
        if($ref_id) {
            $get = $get->where('ref_product_id',$ref_id);
        }

        return $get;
    }

    static public function first_image($id)
    {
        $first = DB::table('cag_product_image')
        ->whereNull('image_deleted_at')
        ->where('image_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function datatables_more($post = [],$ref_id = '')
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_product_more')
        ->whereNull('more_deleted_at');
        
        if($ref_id) {
            $get = $get->where('ref_product_id',$ref_id);
        }

        return $get;
    }

    static public function first_more($id)
    {
        $first = DB::table('cag_product_more')
        ->whereNull('more_deleted_at')
        ->where('more_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_product($ref_id = '' , $paginate = '' , $lang = '') 
    {
        $first = DB::table('cag_product as p')
        ->whereNull('p.product_deleted_at')
        ->where('p.product_type','!=','bundle')
        ->where('p.product_active','1')
        ->orderBy('p.product_sort','desc');

        if($ref_id) {
            $first = $first->where('ref_category_id',$ref_id);
        }

        if($lang == 'th') {
            $first = $first->select('p.product_id','p.product_stock','p.product_name_th as product_name','p.product_value','p.product_attribute','p.product_normal_price','p.product_discount_price','p.product_route');
        }else if($lang == 'en') {
            $first = $first->select('p.product_id','p.product_stock','p.product_name as product_name','p.product_value','p.product_attribute','p.product_normal_price','p.product_discount_price','p.product_route');
        }

        if($paginate) {
            $first = $first->paginate($paginate);
        }else {
            $first = $first->get();
        }

        if(!$first) {
            return [];
        }

        if(@$first) {
            foreach($first as $k => $v) {
                $route = General::str_slug($v->product_route, '-');
                $subject = General::str_slug($v->product_name, '-');
                $first[$k]->url = ($route ? $route.'-'.$v->product_id : $subject.'-'.$v->product_id);
            }
        }
        
        return $first;
        
    }

    static public function first_product_image($id = '')
    {
        $first = DB::table('cag_product_image')
        ->whereNull('image_deleted_at')
        ->orderBy('image_sort','asc');

        if($id){
            $first = $first->where('ref_product_id',$id);
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_color($ref_id = '',$type = '')
    {
        $first = DB::table('cag_product_color')
        ->whereNull('color_deleted_at')
        ->where('color_active','1')
        ->orderBy('color_sort','asc');
 
        if($ref_id) {
            $first = $first->where('ref_product_id',$ref_id);
        }

        if($type == 'first') {
            $first = $first->first();
        }else {
            $first = $first->get();
        }

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_property($ref_id = '' , $lang = '')
    {
        $first = DB::table('cag_product_property')
        ->whereNull('property_deleted_at')
        ->where('property_active','1')
        ->orderBy('property_sort','asc');
 
        if($ref_id) {
            $first = $first->where('ref_product_id',$ref_id);
        }

        if($lang == 'th') {
            $first = $first->select('property_id','property_content_th as property_content');
        }else if($lang == 'en') {
            $first = $first->select('property_id','property_content as property_content');
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_more($ref_id = '' , $lang = '')
    {
        $first = DB::table('cag_product_more')
        ->whereNull('more_deleted_at')
        ->where('more_active','1')
        ->orderBy('more_sort','asc');
 
        if($ref_id) {
            $first = $first->where('ref_product_id',$ref_id);
        }

        if($lang == 'th') {
            $first = $first->select('more_id','more_sort','more_topic_th as more_topic','more_content_th as more_content','more_type','more_img_name');
        }else if($lang == 'en') {
            $first = $first->select('more_id','more_sort','more_topic as more_topic','more_content as more_content','more_type','more_img_name');
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function front_image($ref_id = '' , $ref_id2 = '')
    {
        $first = DB::table('cag_product_image')
        ->whereNull('image_deleted_at')
        ->where('image_active','1')
        ->orderBy('image_sort','asc');
 
        if($ref_id) {
            $first = $first->where('ref_product_id',$ref_id);
        }

        if($ref_id2) {
            $first = $first->where('ref_color_id',$ref_id2);
        }

        $first = $first->get();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function more_type_option_html($selected = '')
    {
        $html  = '';
        $html .= '<option value="text" '.($selected == "text" ? 'selected' : '').'>Text</option>';
        $html .= '<option value="ul" '.($selected == "ul" ? 'selected' : '').'>Option</option>';

        return $html;
    }

    static public function more_text($selected = '', $content = '')
    {
        $html = '';
        if($selected == 'text') {
            $html .= '<div class="txt-content">'.$content.'</div>';
        } else if($selected == 'ul') {
            $html .= '<ul class="content-list">'.$content.'</ul>';
        }

        return $html;
    }

    static public function stock_button($selected = '', $type = '' , $price = '')
    {
        $html = '';
        if($type == 'pd') {
            $check = DB::table('cag_product_stock')->where('ref_product_id',$selected)->sum('stock_value');
            if($check > '0') {
                $html .= '
                    <button type="button" class="btn buttonBK add-cart addcart" data-id="'.$selected.'">
                        <ul>
                            <li>ADD</li>
                            <li>฿'.$price.'</li>
                        </ul>
                    </button>';
            }else if($check == '0') {
                $html .= '
                <button type="button" class="btn buttonBK add-cart">
                    <ul>
                        <li>สินค้าหมด</li>
                        <li>฿'.$price.'</li>
                    </ul>
                </button>';
            }
        }else if($type == 'gg') {
            $check = DB::table('cag_product_stock')->where('ref_product_id',$selected)->sum('stock_value');
            if($check > '0') {
                $html .= '<div class="tag">NEW</div>';
            }else if($check == '0') {
                $html .= '<div class="tag">สินค้าหมด</div>';
            }
        }

        return $html;
    }

    static public function datatables_stock_product($post = [])
    {
        ### Request
        //General::print_r_($post);exit;
        foreach (@$post as $key => $value) {
            ${$key}  = $value;
        }   

        $get = DB::table('cag_product_stock')
        ->whereNull('stock_deleted_at');

        return $get;
    }

    static public function stock_html($ref_id = '',$type = '')
    {
        $html = '';

        if($ref_id) {
            if($type == 'option') {
                $first = DB::table('cag_product_color')->where('color_id',$ref_id)->first();
                $html .= $first->color_name;
            }else if($type == 'product') {
                $first = DB::table('cag_product')->where('product_id',$ref_id)->first();
                $html .= $first->product_name;
            }
        }

        return $html;
    }

    static public function first_stock($id = '')
    {
        $first = DB::table('cag_product_stock')
        ->whereNull('stock_deleted_at');

        if($id){
            $first = $first->where('stock_id',$id);
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

    static public function product_option_html($selected = '',$text_first = '')
    {
        $html  = '';
        $html .= '<option value="">'.$text_first.'</option>';

        $get = DB::table('cag_product')
        ->whereNull('product_deleted_at')
        ->where('product_active','1')
        ->orderBy('product_sort','asc')
        ->get();
        if(@$get) {
            foreach($get as $k => $v) {
                $html .= '<option value="'.$v->product_id.'" '.($selected == $v->product_id ? 'selected' : '').'>'.$v->product_name.'</option>';
            }
        }

        return $html;
    }
    
    static public function get_started_bundle($lang = '')
    {
        $first = DB::table('cag_product')
        ->whereNull('product_deleted_at')
        ->where('product_type','bundle');

        if($lang == 'th') {
            $first = $first->select('product_id','product_stock','product_name_th as product_name','product_value','product_attribute','product_normal_price','product_discount_price','product_route'
            ,'product_detail_th as product_detail','product_ingredients_th as product_ingredients','product_cate_name','product_meta_title','product_meta_keyword','product_meta_description');
        }else if($lang == 'en') {
            $first = $first->select('product_id','product_stock','product_name as product_name','product_value','product_attribute','product_normal_price','product_discount_price','product_route'
            ,'product_detail as product_detail','product_ingredients as product_ingredients','product_cate_name','product_meta_title','product_meta_keyword','product_meta_description');
        }

        $first = $first->first();

        if(!$first) {
            return [];
        }
        return $first;
        
    }

    static public function front_get_started_bundle($lang = '') 
    {
        $first = DB::table('cag_product as p')
        ->whereNull('p.product_deleted_at')
        ->where('p.product_active','1')
        ->where('product_type','get started')
        ->orderBy('p.product_sort','desc');

        if($lang == 'th') {
            $first = $first->select('p.product_id','p.product_stock','p.product_name_th as product_name','p.product_detail_th as product_detail','p.product_value','p.product_attribute','p.product_normal_price','p.product_discount_price','p.product_route');
        }else if($lang == 'en') {
            $first = $first->select('p.product_id','p.product_stock','p.product_name as product_name','p.product_detail as product_detail','p.product_value','p.product_attribute','p.product_normal_price','p.product_discount_price','p.product_route');
        }
        
        $first = $first->get();

        if(!$first) {
            return [];
        }
        
        return $first;
        
    }

    static public function cart_get_start($ref_id = '')
    {
        $first = DB::table('cag_get_sart_cart')
        ->whereNull('get_deleted_at')
        ->where('ref_customer_id',Auth::guard('ecom_customer')->user()->id);

        if($ref_id) {
            $first = $first->where('ref_product_id',$ref_id);
        }

        $first = $first->first();

        return $first;
    }

    static public function replen_box($lang)
    {
        $first = DB::table('cag_get_sart_cart as cgsc')
        ->join('cag_product as cp','cp.product_id','=','cgsc.ref_product_id')
        ->whereNull('cgsc.get_deleted_at')
        ->where('cgsc.ref_customer_id',Auth::guard('ecom_customer')->user()->id)
        ->where('cgsc.get_qty','>','0')
        ->where('cgsc.get_type','!=','bundle')
        ->orderBy('get_id','desc');

        $first = $first->get();

        return $first;
    }

    static public function email_product_image($id)
    {
        $first = DB::table('cag_product_image')
        ->whereNull('image_deleted_at')
        ->where('ref_product_id',$id)
        ->first();

        if(!$first) {
            return [];
        }
        return $first;
    }

}