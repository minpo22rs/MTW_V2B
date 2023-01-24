<?php

namespace App\Http\Controllers\Sapapps\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

####### Include
use Auth;
use DB;
use General;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->url  = 'dashboard';
        parent::__construct($this->url);
        $this->path_file .= '.dashboard';
        $this->menu = \App\Model\Menu::get_menu_name($this->url)['menu'];
        $this->menu_right = \App\Model\Menu::get_menu_name($this->url)['menu_right'];       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(\App\Model\analytics::count_order_recive() != 0) {
			$rp = (\App\Model\analytics::count_order_recive() / \App\Model\analytics::count_all()) * 100;
		}else {
			$rp = 0;
		}
		
		if(\App\Model\analytics::count_order_not_recive() != 0) {
			$nrp = (\App\Model\analytics::count_order_not_recive() != 0 / \App\Model\analytics::count_all()) * 100;
		}else {
			$nrp = 0;
		}
        \App\Model\analytics::product_per_month();
        $data = [
            'list_customer'                     => \App\Model\analytics::list_customer(),
            'list_call_customer_per_month'      => \App\Model\analytics::list_call_customer_per_month(),
            'list_call_customer_per_day'        => \App\Model\analytics::list_call_customer_per_day(),
            'list_call_customer_left'           => \App\Model\analytics::list_call_customer_left(),
            'target'                            => \App\Model\analytics::target(),
            'sale_order_accumulate_per_month'   => \App\Model\analytics::sale_order_accumulate_per_month(),
            'sale_order_per_day'                => \App\Model\analytics::sale_order_per_day(),
            'on_target'                         => \App\Model\analytics::on_target(),
            'sum_circulation'                   => \App\Model\analytics::sum_circulation(),
            'sum_order_invoice'                 => \App\Model\analytics::sum_order_invoice(),
            'sum_order_waiting_verify'          => \App\Model\analytics::sum_order_waiting_verify(),
            'sum_order_shipping'                => \App\Model\analytics::sum_order_shipping(),
            'sum_order_recive'                  => \App\Model\analytics::sum_order_recive(),
            'sum_order_not_recive'              => \App\Model\analytics::sum_order_not_recive(),
            'count_order_recive'                => \App\Model\analytics::count_order_recive(),
            'count_order_not_recive'            => \App\Model\analytics::count_order_not_recive(),
            'recive_per'                        => $rp,
            'not_recive_per'                    => $nrp,
            'recent'                            => \App\Model\analytics::recent_order(),
            'all'                               => \App\Model\analytics::count_all(),
            'pro_m'                             => \App\Model\analytics::product_per_month('dd'),
            'pro_m_name'                        => \App\Model\analytics::product_per_month(),
            'pro_d'                             => \App\Model\analytics::product_per_day('dd'),
            'pro_d_name'                        => \App\Model\analytics::product_per_day(),
            'pro_t'                             => \App\Model\analytics::product_top_10('dd'),
            'pro_t_name'                        => \App\Model\analytics::product_top_10(),
        ];
        return view($this->path_file.'.index', $data);
    }

    public function rank($id)
    {
        if($id == 'agent') {
            $date = date('Y-m-d');
            $tt = DB::table('account_admin as ac')
            ->join('dash_sale_order as so','so.so_created_at_ref_user_id','=','ac.id')
            ->join('dash_product_order as dpo','dpo.ref_so_id','=','so.id')
            ->join('dash_product as p','p.product_id','=','dpo.product_id')
            ->where('ac.role','agent')
            ->where('so.so_date',$date)
            ->whereNotIn('product_type',['2','3'])
            ->select(DB::raw('SUM(dpo.product_sum_price - dpo.product_discount) as product_price'),'ac.id')
            ->groupby('ac.id')->orderBy('product_price','DESC')->limit(6)->get();
            $month = date('m');
            $ww = DB::table('account_admin as ac')
            ->join('dash_sale_order as so','so.so_created_at_ref_user_id','=','ac.id')
            ->join('dash_product_order as dpo','dpo.ref_so_id','=','so.id')
            ->join('dash_product as p','p.product_id','=','dpo.product_id')
            ->where('ac.role','agent')
            ->where('so.so_date','LIKE','%-'.$month.'-%')
            ->whereNotIn('product_type',['2','3'])
            ->select(DB::raw('SUM(dpo.product_sum_price - dpo.product_discount) as product_price'),'ac.id')
            ->groupby('ac.id')->orderBy('product_price','DESC')->get();
            if(\App\Model\analytics::count_order_recive() != 0) {
                $rp = (\App\Model\analytics::count_order_recive() / \App\Model\analytics::count_all()) * 100;
            }else {
                $rp = 0;
            }
            
            if(\App\Model\analytics::count_order_not_recive() != 0) {
                $nrp = (\App\Model\analytics::count_order_not_recive() != 0 / \App\Model\analytics::count_all()) * 100;
            }else {
                $nrp = 0;
            }
            $data = [
                'list_customer'                     => \App\Model\analytics::list_customer(),
                'list_call_customer_per_month'      => \App\Model\analytics::list_call_customer_per_month(),
                'list_call_customer_per_day'        => \App\Model\analytics::list_call_customer_per_day(),
                'list_call_customer_left'           => \App\Model\analytics::list_call_customer_left(),
                'target'                            => \App\Model\analytics::target(),
                'sale_order_accumulate_per_month'   => \App\Model\analytics::sale_order_accumulate_per_month(),
                'sale_order_per_day'                => \App\Model\analytics::sale_order_per_day(),
                'on_target'                         => \App\Model\analytics::on_target(),
                'sum_circulation'                   => \App\Model\analytics::sum_circulation(),
                'sum_order_invoice'                 => \App\Model\analytics::sum_order_invoice(),
                'sum_order_waiting_verify'          => \App\Model\analytics::sum_order_waiting_verify(),
                'sum_order_shipping'                => \App\Model\analytics::sum_order_shipping(),
                'sum_order_recive'                  => \App\Model\analytics::sum_order_recive(),
                'sum_order_not_recive'              => \App\Model\analytics::sum_order_not_recive(),
                'count_order_recive'                => \App\Model\analytics::count_order_recive(),
                'count_order_not_recive'            => \App\Model\analytics::count_order_not_recive(),
                'recive_per'                        => $rp,
                'not_recive_per'                    => $nrp,
                'recent'                            => \App\Model\analytics::recent_order(),
                'all'                               => \App\Model\analytics::count_all(),
                //////////////////////////////
                'rank'                              => $tt,
                'rank_month'                        => $ww,
            ];
            return view($this->path_file.'.rank', $data);
        }else{
            return abort('404');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
