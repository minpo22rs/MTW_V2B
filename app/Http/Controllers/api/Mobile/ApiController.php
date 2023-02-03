<?php

namespace App\Http\Controllers\api\Mobile;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // function for index page -----------------------------------------//

	public function index(Request $request)
	{
        $banner = \App\Model\General::banner('main',4);
        $top1 = \App\Model\General::missgrand(1);
        $top3 = \App\Model\General::missgrand(2);
        $top9 = \App\Model\General::missgrand(3);
        $top15 = \App\Model\General::missgrand(4);
        $hotel = \App\Model\General::seller('hotel');
        $resterant = \App\Model\General::seller('resterant');
        $product = \App\Model\General::product();
        $location = \App\Model\General::location();
        $banners = \App\Model\General::banner('sub');
        $bannerf = \App\Model\General::banner('ad');
		$account = \App\Model\General::account($request->userid);
		$cater = \App\Model\General::category_restaurant_page();
		$cate = \App\Model\General::category_product_page();

		$data = [
			'bannermain' => $banner,
			'top1' => $top1,
			'top3' => $top3,
			'top9' => $top9,
			'top15' => $top15,
			'hotel' => $hotel,
			'restaurant' => $resterant,
			'product' => $product,
			'location' => $location,
			'banners' => $banners,
			'bannerf' => $bannerf,
			'account' => $account,
			'cate_p'  => $cate,
			'cate_r' => $cater,
		];

		return response()->json($data,200);
	}

	public function product_page(Request $request)
	{
        $product = \App\Model\General::product();
        $banners = \App\Model\General::banner('product1');
        $bannerf = \App\Model\General::banner('product2');
		$cate = \App\Model\General::category_product_page();

		$data = [
			'product' => $product,
			'banners' => $banners,
			'bannerf' => $bannerf,
			'cate_p'  => $cate,
		];

		return response()->json($data,200);
	}

	public function attraction_page()
	{
        $location = \App\Model\General::location();
        $banners = \App\Model\General::banner('attraction');

		$data = [
			'location' => $location,
			'banners' => $banners,
		];

		return response()->json($data,200);
	}

	public function attraction_member()
	{
        $location = \App\Model\General::location_m();

		return response()->json($location,200);
	}

	public function attraction_member_detail(Request $request)
	{
        $location = \App\Model\General::location_md($request->mId);

		return response()->json($location,200);
	}

    public function main_banner_index()
    {
        $banner = \App\Model\General::banner('main',4);

        return response()->json($banner,200);
    }

    public function top1_index()
    {
        $top1 = \App\Model\General::missgrand(1);

        return response()->json($top1,200);
    }

    public function top3_index()
    {
        $top3 = \App\Model\General::missgrand(2);

        return response()->json($top3,200);
    }

    public function top9_index()
    {
        $top9 = \App\Model\General::missgrand(3);

        return response()->json($top9,200);
    }

    public function top15_index()
    {
        $top15 = \App\Model\General::missgrand(4);

        return response()->json($top15,200);
    }

    public function button_banner_index()
    {
        $bannerb = \App\Model\General::banner('button');

        return response()->json($bannerb,200);
    }

    public function hotel_index()
    {
        $hotel = \App\Model\General::seller('hotel');

        return response()->json($hotel,200);
    }

    public function restaurant_index()
    {
        $resterant = \App\Model\General::seller('resterant');

        return response()->json($resterant,200);
    }

    public function product_index()
    {
        $product = \App\Model\General::product();

        return response()->json($product,200);
    }

    public function location_index()
    {
        $location = \App\Model\General::location();

        return response()->json($location,200);
    }

    public function sub_banner_index()
    {
        $banners = \App\Model\General::banner('sub');

        return response()->json($banners,200);
    }

    public function footer_banner_index()
    {
        $bannerf = \App\Model\General::banner('ad');

        return response()->json($bannerf,200);
    }

    // ------------------------------------------------------------------//
    // ---------------------- Vote Page ---------------------------------//

    public function regions_name(Request $request)
    {
        //dd($request->keyword);
        $region = \App\Model\General::regions_name($request->keyword);

        return response()->json($region,200);
    }


    public function contestant_page_2(Request $request)
    {
		//return response()->json($request,200);
        //dd($request->keyword)
        $conp2 = \App\Model\General::contestant_page_2($request->keyword);

       	return response()->json($conp2,200);
    }

	public function contestant_detail(Request $request)
	{
		//return response()->json($request,200);
		$cond = \App\Model\General::contestant_detail($request->ref_id);

		return response()->json($cond,200);
	}

	public function vote_contestant(Request $request)
	{
		$vote = \App\Model\General::vote_contestant($request->price,$request->score,$request->id,$request->id_v);

		return response()->json($vote,200);
	}

	public function vote_contestant_free(Request $request)
	{
		$check = \App\Model\General::check_free_account($request->id_v);
		if($check == '0') {
			$vote = \App\Model\General::vote_contestant($request->price,$request->score,$request->id,$request->id_v);
			\App\Model\General::change_free_account($request->id_v);
		}else {
			$vote = ['price'=>'','score'=>'','status'=>'E'];
		}

		return response()->json($vote,200);
	}

    // ------------------------------------------------------------------//
    // ---------------------- Product Page ------------------------------//

	public function category_product_page()
	{
		$cate = \App\Model\General::category_product_page();

		return response()->json($cate,200);
	}

	public function product_in_category_product_page(Request $request)
	{
        //$product = \App\Model\General::product();
		$product = \App\Model\General::product_in_category_product_page($request->cate_id);

		return response()->json($product,200);
	}

	public function product_detail_product_page(Request $request)
	{
		$productd = \App\Model\General::product_detail_product_page($request->pro_id);
		$productimg = \App\Model\General::product_detail_product_images($request->pro_id);
		$seller = \App\Model\General::product_detail_product_seller($request->pro_id);
		$similar = \App\Model\General::product_detail_product_similar($request->pro_id);

		$data = [
			'productd' => $productd,
			'productimg' => $productimg,
			'seller' => $seller,
			'similar' => $similar,
		];

		return response()->json($data,200);
	}

	public function category_restaurant_page()
	{
		$cater = \App\Model\General::category_restaurant_page();

		return response()->json($cater,200);
	}

	public function restaurant_detail(Request $request)
	{
		$restaurant = \App\Model\General::restaurant_detail($request->res_id);
		$vr = \App\Model\General::vouchers_restaurant($request->res_id);

		$data = [
			'restaurant'=>$restaurant,
			'vr'=>$vr,
		];

		return response()->json($data,200);
	}

	public function hotel_detail(Request $request)
	{
		$hotel = \App\Model\General::hotel_detail($request->hotel_id);
		$cr = \App\Model\General::choose_room($request->hotel_id);

		$data = [
			'hotel'=>$hotel,
			'cr'=>$cr,
		];

		return response()->json($data,200);
	}

	public function search_hotel(Request $request)
	{
		$hotel = \App\Model\General::search_hotel($request->keyword,$request->person);

		return response()->json($hotel,200);
	}

	public function search_rooms(Request $request)
	{
		$hotel = \App\Model\General::search_rooms($request->hotel_id,$request->person);

		return response()->json($hotel,200);
	}

	public function room_detail(Request $request)
	{
		$room = \App\Model\General::room_detail($request->roomId);

		return response()->json($room,200);
	}


    // ------------------------------------------------------------------//
    // ---------------------------Attraction-----------------------------//

	public function attraction_detail_product_page(Request $request)
	{
		$attraction = \App\Model\General::attraction_detail_product_page($request->attracId);
		$attractionmiss = \App\Model\General::attraction_detail_member($request->attracId);
		$attractionimg = \App\Model\General::attraction_detail_product_images($request->attracId);

		$data = [
			'attraction' => $attraction,
			'attractionmiss' => $attractionmiss,
			'attractionimg' => $attractionimg,
		];

		return response()->json($data,200);
	}

    // ------------------------------------------------------------------//
    // ----------------------------AUTH----------------------------------//

	public function login_user_mtwa(Request $request)
	{
		$user = \App\Model\General::login_user_mtwa($request->phone,$request->password);

		return response()->json($user,200);
	}

	public function register_user_mtwa(Request $request)
	{
		$user = \App\Model\General::register_user_mtwa($request->name,$request->email,$request->phone,$request->password,$request->otp_code);

		return response()->json($user,200);
	}

	public function otp_user_mtwa(Request $request)
	{
        dd("test");
		$otp = \App\Model\General::otp_user_mtwa($request->phone);

		return response()->json($otp,200);
	}

	public function reset_user_mtwa(Request $request)
	{
		$user = \App\Model\General::reset_user_mtwa($request->phone,$request->password,$request->otp_code);

		return response()->json($user,200);
	}

	public function otp_user_mtwa_reset(Request $request)
	{
		$otp = \App\Model\General::otp_user_mtwa_reset($request->phone);

		return response()->json($otp,200);
	}

    // ------------------------------------------------------------------//

	public function account(Request $request)
	{
		$account = \App\Model\General::account($request->userid);

		return response()->json($account,200);
	}

	public function otp_phone_mtwa_reset(Request $request)
	{
		$check = \App\Model\General::otp_phone_mtwa_reset($request->phone);

		return response()->json($check,200);
	}

	public function account_change(Request $request)
	{
		$account = \App\Model\General::account_change($request->userId,$request->type,$request->text,$request->text2);

		return response()->json($account,200);
	}

	public function address_detail(Request $request)
	{
		$detail = \App\Model\General::address_detail($request->userId);

		return response()->json($detail,200);
	}

	public function add_address(Request $request)
	{
		$account = \App\Model\General::add_address($request->userId,$request->name,$request->phone,
				$request->province,$request->district,$request->subdistrict,$request->postcode,$request->detail,$request->main);

		return response()->json($account,200);
	}

	public function vouchers_detail(Request $request)
	{
		$voucher = \App\Model\General::vouchers_detail($request->vouchersId);

		return response()->json($voucher,200);
	}

	public function sos()
	{
		$sos = \App\Model\General::sos();

		return response()->json($sos,200);
	}

	//------------------------------CART---------------------------------//

	public function add_cart(Request $request)
	{
		$cart = \App\Model\General::cart($request->userid,$request->pro_id,$request->qty,$request->seller);

		return response()->json($cart,200);
	}

	public function list_cart(Request $request)
	{
		$list_cart = \App\Model\General::list_cart($request->userId);

		return response()->json($list_cart,200);
	}

	public function qty_cart(Request $request)
	{
		$qty_cart = \App\Model\General::qty_cart($request->type,$request->cartId);

		return response()->json($qty_cart,200);
	}

	public function search_cart(Request $request)
	{
		//dd($request->cartId);

		$cart = \App\Model\General::search_cart($request->cartId,$request->sellerId);

		return response()->json($cart,200);
	}

	public function carts_restaurant(Request $request)
	{
		$cart = \App\Model\General::carts_restaurant($request->customer,$request->seller,$request->product,
													 $request->qty,$request->price,$request->total);

		return response()->json($cart,200);
	}

	public function carts_restaurant_list(Request $request)
	{
		$cart = \App\Model\General::carts_restaurant_list($request->seller);

		return response()->json($cart,200);
	}

	public function carts_restaurant_delete(Request $request)
	{
		$cart = \App\Model\General::carts_restaurant_delete($request->cartId);

		return response()->json($cart,200);
	}

    // ------------------------------------------------------------------//

	public function list_payment(Request $request)
	{
		$list = \App\Model\General::list_payment($request->userid);

		return response()->json($list,200);
	}

	public function e_pay()
	{
		//dd($_GET);
		$refno = date('ymdhis')+$_GET['id'];
		//dd($refno);
		$customer = \App\Model\General::account($_GET['id']);
		if($_GET['type'] == 'IW') {
			\App\Model\General::log_wallet($_GET['type'],$refno,$_GET['id'],$_GET['total']);
		}else if($_GET['type'] == 'R') {
			\App\Model\General::log_wallet($_GET['type'],$refno,$_GET['id'],$_GET['total'],$_GET['cartId']);
		}else if($_GET['type'] == 'H') {
			\App\Model\General::log_wallet($_GET['type'],$refno,$_GET['id'],$_GET['total'],
												   $_GET['cartId'],$_GET['start'],$_GET['endd']);
		}
		//dd($customer);
		$data = [
			'id' => $_GET['id'],
			'email' => $customer->email,
			'total' => $_GET['total'],
			'rand'	=> $refno,
			'text'	=> $_GET['type'],
			];
		//dd($data);
		return view('e-pay',$data);
	}

	public function e_pay_again()
	{
		$data = [
			'id' => $_GET['id'],
			'email' => $_GET['email'],
			'total' => $_GET['total'],
			'rand'	=> $_GET['refno'],
			'text'	=> $_GET['type'],
			];
		//dd($data);
		return view('e-pay',$data);
	}

	public function hotel_order(Request $request)
	{
		$refno = date('ymdhis')+$request->id;
		\App\Model\General::log_wallet('H',$refno,$request->id,$request->total,$request->hId,$request->start,$request->endd);
		$horder = ['status'=>'1'];
		return response()->json($horder,200);
	}

	public function check_rooms(Request $request)
	{
		$c = \App\Model\General::check_rooms($request->hId);

		return response()->json($c,200);
	}

	public function thank_you()
	{
		return view('call-back');
	}

	public function call_back(Request $request)
	{
		\App\Model\General::call_back_wallet($request->refno,$request->total,$request->productdetail);
	}

	//------------------------------WISHLISTS----------------------------//

	public function add_wishlists(Request $request)
	{
		$wishlist = \App\Model\General::add_wishlists($request->userid,$request->wishlist_id,$request->type);

		return response()->json($wishlist,200);
	}

	public function check_wishlists(Request $request)
	{
		$wl = \App\Model\General::check_wishlists($request->uId,$request->iId,$request->type);

		return response()->json($wl,200);
	}

	public function list_wishlists(Request $request)
	{
		$wishlist = \App\Model\General::list_wishlists($request->userid);

		return response()->json($wishlist,200);
	}

    // ------------------------------------------------------------------//

	//------------------------------CRONJOB------------------------------//


	public function reset_free_vote()
	{
		\App\Model\General::reset_free_vote();
	}

	public function cc_wallet()
	{
		\App\Model\General::cc_wallet();
	}

	public function opapp()
	{
		//
	}

    // ------------------------------------------------------------------//

	//-------------------------------ORDER-------------------------------//

	public function show_order(Request $request)
	{
		$order = \App\Model\General::show_order($request->userId);

		return response()->json($order,200);
	}

	public function show_vouchers(Request $request)
	{
		$order = \App\Model\General::show_vouchers($request->userId);

		return response()->json($order,200);
	}

	public function show_vouchers_useless(Request $request)
	{
		$order = \App\Model\General::show_vouchers_useless($request->userId);

		return response()->json($order,200);
	}

	public function show_vouchers_hotel(Request $request)
	{
		$order = \App\Model\General::show_vouchers_hotel($request->userId);

		return response()->json($order,200);
	}

	public function useless_vouchers_hotel(Request $request)
	{
		$order = \App\Model\General::useless_vouchers_hotel($request->userId);

		return response()->json($order,200);
	}

	public function order_hotel_detail(Request $request)
	{
		$order = \App\Model\General::order_hotel_detail($request->userId,$request->vId);

		return response()->json($order,200);
	}

    // ------------------------------------------------------------------//

	public function restaurant_image(Request $request)
	{
		$image = \App\Model\General::restaurant_image($request->resId);

		return response()->json($image,200);
	}

	public function vouchers_show_detail(Request $request)
	{
		$vd = \App\Model\General::vouchers_show_detail($request->userId,$request->vId);

		return response()->json($vd,200);
	}

	public function vouchers_order_detail(Request $request)
	{
		$vd = \App\Model\General::vouchers_order_detail($request->userId,$request->oId);

		return response()->json($vd,200);
	}

	public function seller_images(Request $request)
	{
		$si = \App\Model\General::seller_images($request->sId);

		return response()->json($si,200);
	}

	public function room_images(Request $request)
	{
		$si = \App\Model\General::room_images($request->sId);

		return response()->json($si,200);
	}

	public function product_by_cate(Request $request)
	{
		$pbc = \App\Model\General::product_by_cate($request->cId);

		return response()->json($pbc,200);

	}

	public function form_review(Request $request)
	{
		$k = \App\Model\General::form_review($request->sId,$request->uId,$request->type,$request->review,$request->rating);

		return response()->json($k,200);
	}

	public function ownreview(Request $request)
	{
		$k = \App\Model\General::ownreview($request->sId,$request->type);

		return response()->json($k,200);
	}

	public function reviewlist(Request $request)
	{
		$k = \App\Model\General::reviewlist($request->sId,$request->type);

		return response()->json($k,200);
	}

	public function stardust(Request $request)
	{
		$sd = \App\Model\General::stardust($request->sId,$request->type);

		return response()->json($sd,200);
	}

	public function search_everything(Request $request)
	{
		$sd = \App\Model\General::search_everything($request->keyword,$request->type);

		return response()->json($sd,200);
	}

	public function use_vouchers(Request $request)
	{
		$uv = \App\Model\General::use_vouchers($request->scanRes,$request->seller);

		return response()->json($uv,200);
	}

	public function appleIdsign(Request $request)
	{
		$ap = \App\Model\General::appleIdsign($request->appleId,$request->firstname,$request->lastname,$request->email);

		return response()->json($ap,200);
	}

	public function getProvinces()
	{
		$province = \App\Model\General::getProvinces();

		return response()->json($province,200);
	}

	public function getDistrict(Request $request)
	{
		$district = \App\Model\General::getDistrict($request->province);

		return response()->json($district,200);
	}

	public function getSubDistrict(Request $request)
	{
		$subdistrict = \App\Model\General::getSubDistrict($request->district,$request->type);

		return response()->json($subdistrict,200);
	}

}
