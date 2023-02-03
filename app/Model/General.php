<?php

namespace App\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class General extends Authenticatable
{
    static public function test()
    {
        $product = DB::table('products')->get();
        return $product;
    }

    static public function banner($type = '',$paginate = '')
    {
        if($type == 'main') {
            $banner = DB::table('banners')->where('banner_type','M');

            if($paginate != '') {
                $banner = $banner->limit($paginate)->get();
            }else {
                $banner = $banner->get();
            }
        }else if($type == 'button') {
            $banner = DB::table('banners')->where('banner_type','B')->get();
        }else if($type == 'sub') {
            $banner = DB::table('banners')->where('banner_type','S')->first();
        }else if($type == 'ad') {
            $banner = DB::table('banners')->where('banner_type','F')->first();
        }else if($type == 'hotel') {
            $banner = DB::table('banners')->where('banner_type','H')->first();
        }else if($type == 'product1') {
            $banner = DB::table('banners')->where('banner_type','P1')->first();
        }else if($type == 'product2') {
            $banner = DB::table('banners')->where('banner_type','P2')->first();
        }else if($type == 'attraction') {
            $banner = DB::table('banners')->where('banner_type','A')->first();
        }

        return $banner;
    }

    static public function missgrand($type) 
    {
        if($type == 1) {
            // $miss = DB::table('users')->where('role','M')->OrderBy('rating','DESC')->first();
            $miss = DB::select("SELECT @n := @n + 1 as no_row,users.id,users.role,users.f_name,users.l_name,users.image,users.rating,thai_provinces.name_th as city
                                FROM (SELECT @n := 0) m ,users
								INNER JOIN thai_provinces ON users.province = thai_provinces.id 
                                WHERE users.role = 'M' 
                                ORDER BY users.rating DESC 
                                LIMIT 1");
        }else if($type == 2) {
            // $miss = DB::table('users')->where('role','M')->OrderBy('rating','DESC')->skip(1)->limit(2)->get();
            $miss = DB::select("SELECT @n := @n + 1 as no_row,users.id,users.role,users.f_name,users.l_name,users.image,users.rating,thai_provinces.name_th as city
                                FROM (SELECT @n := 1) m ,users
								INNER JOIN thai_provinces ON users.province = thai_provinces.id 
                                WHERE users.role = 'M' 
                                ORDER BY users.rating DESC 
                                LIMIT 2
                                OFFSET 1");
        }else if($type == 3) {
            // $miss = DB::table('users')->where('role','M')->OrderBy('rating','DESC')->skip(3)->limit(6)->get();
            $miss = DB::select("SELECT @n := @n + 1 as no_row,users.id,users.role,users.f_name,users.l_name,users.image,users.rating,thai_provinces.name_th as city
                                FROM (SELECT @n := 3) m  ,users
								INNER JOIN thai_provinces ON users.province = thai_provinces.id 
                                WHERE users.role = 'M' 
                                ORDER BY users.rating DESC 
                                LIMIT 4
                                OFFSET 3");
        }else if($type == 4) {
            // $miss = DB::table('users')->where('role','M')->OrderBy('rating','DESC')->skip(9)->limit(6)->get();
            $miss = DB::select("SELECT @n := @n + 1 as no_row,users.id,users.role,users.f_name,users.l_name,users.image,users.rating,thai_provinces.name_th as city
                                FROM (SELECT @n := 7) m ,users
								INNER JOIN thai_provinces ON users.province = thai_provinces.id 
                                WHERE users.role = 'M' 
                                ORDER BY users.rating DESC 
                                LIMIT 4
                                OFFSET 7");
        }

        return $miss;
    }
    // database table name users | column role -> M = missgrand , U = Normal User | column rating -> rating -> Bigint(20) -> set default 0 

    static public function seller($type)
    {
        if($type == 'hotel') {
            $seller = DB::table('sellers')->where('type','H')->OrderBy('rating','DESC')->get();
        }else if($type == 'resterant') {
            $seller = DB::table('sellers')->where('type','R')->OrderBy('rating','DESC')->get();
        }

        return $seller;
    }

    static public function product()
    {
        $product = DB::table('products')->where('status',1)->where('current_stock','>',0)->OrderBy('rating','DESC')->get();

        return $product;
    }

    static public function location()
    {
        $location = DB::table('locations')->OrderBy('rating','DESC')->get();

        return $location;
    }

    static public function location_m()
    {
        $location = DB::table('locations')->where('write_role','M')->OrderBy('rating','DESC')->get();

        return $location;
    }

    static public function location_md($mId)
    {
        $location = DB::table('locations')->where('write_by',$mId)->OrderBy('rating','DESC')->get();

        return $location;
    }

    static public function attraction_detail_product_page($ref_id)
    {
		//$ref_id = 1;
        $attraction = DB::table('locations');
		if($ref_id != '') {
			$attraction = $attraction->where('id',$ref_id);
		}
		$attraction = $attraction->first();
        //$product = $product->category_ids;
		
		return $attraction;
    }

    static public function attraction_detail_member($ref_id)
    {
		//$ref_id = 1;
        $attraction = DB::table('locations as l')
			->select('u.f_name','u.l_name')
			->join('users as u','u.id','=','l.write_by')->where('l.id',$ref_id)->first();
        //$product = $product->category_ids;
		
		return $attraction;
    }
	
    static public function attraction_detail_product_images($ref_id)
    {
		//$ref_id = 1;
        $attractionimg = DB::table('location_images');
		if($ref_id != '') {
			$attractionimg = $attractionimg->where('location_id',$ref_id);
		}
		$attractionimg = $attractionimg->get();
        //$product = $product->category_ids;
		
		return $attractionimg;
    }

    static public function regions_name($keyword)
    {
        $region = DB::table('regions');
        if($keyword != '') {
            $region = $region->where('keyword',$keyword);
        }
        $region = $region->first();
		
		return $region;
    }

    static public function contestant_page_2($region)
    {
        $con = DB::table('users')->select('users.id as id','users.f_name','users.l_name','thai_provinces.name_th','users.image','users.rating','users.short_detail','users.number')
			->join('thai_provinces','thai_provinces.id','=','users.province')
			->where('role','M');
        if($region != '') {
            $con = $con->where('region',$region);
        }
        $con = $con->get();
		
		return $con;
    }

    static public function contestant_detail($ref_id)
    {
        $con = DB::table('users')->select('users.id as id','users.f_name','users.l_name','thai_provinces.name_th'
										  ,'users.image','users.rating','users.short_detail','users.link_video',
										  DB::raw("DATE_FORMAT(users.birth, '%d/%m/%Y') as birth"),
										  'users.height','users.weight','users.proportion','users.skill','users.education'
										  ,'users.interest','users.detail','users.region')
			->join('thai_provinces','thai_provinces.id','=','users.province');
        if($ref_id != '') {
            $con = $con->where('users.id',$ref_id);
        }
        $con = $con->first();

        return $con;
    }

    static public function category_product_page()
    {
        $cate = DB::table('categories')->where('type_cat','P')->get();
		
		return $cate;
    }

    static public function product_in_category_product_page($ref_id)
    {
		//$ref_id = 1;
        $product = DB::table('products')
		->where('status',1)
		->where('current_stock','>',0);
		if($ref_id != '') {
			$product = $product->where('category_id',$ref_id);
		}
		$product = $product->OrderBy('rating','DESC')->get();
        //$product = $product->category_ids;
		
		return $product;
    }

    static public function product_detail_product_page($ref_id)
    {
		//$ref_id = 1;
        $productd = DB::table('products');
		if($ref_id != '') {
			$productd = $productd->where('id',$ref_id);
		}
		$productd = $productd->first();
        //$product = $product->category_ids;
		
		return $productd;
    }
	
    static public function product_detail_product_images($ref_id)
    {
		//$ref_id = 1;
        $productimg = DB::table('product_images');
		if($ref_id != '') {
			$productimg = $productimg->where('product_id',$ref_id);
		}
		$productimg = $productimg->get();
        //$product = $product->category_ids;
		
		return $productimg;
    }
	
    static public function product_detail_product_seller($ref_id)
    {
		//$ref_id = 1;
        $product = DB::table('products')->where('id',$ref_id)->first();
		
		$seller = DB::table('sellers')->where('id',$product->seller_id)->first();
		
        //$product = $product->category_ids;
		
		return $seller;
    }
	
    static public function product_detail_product_similar($ref_id)
    {
		//$ref_id = 1;
        $product = DB::table('products')->where('id',$ref_id)->first();
		
		$similar = DB::table('products')->where('seller_id',$product->seller_id)->where('id','!=',$ref_id)->get();
		
        //$product = $product->category_ids;
		
		return $similar;
    }

    static public function category_restaurant_page()
    {
        $cate = DB::table('categories')->where('type_cat','R')->get();
		
		return $cate;
    }
	
	static public function restaurant_detail($ref_id)
	{
		$restaurant = DB::table('sellers')->where('type','R');
		if($ref_id != '') {
			$restaurant = $restaurant->where('id',$ref_id);
		}
		$restaurant = $restaurant->first();
		
		return $restaurant;
	}
	
	static public function vouchers_restaurant($ref_id)
	{
		$vr = DB::table('restaurants')->where('seller_id',$ref_id)->get();
		
		return $vr;
	}
	
	static public function hotel_detail($ref_id)
	{
		//dd($ref_id);
		$hotel = DB::table('sellers')->where('type','H');
		if($ref_id != '') {
			$hotel = $hotel->where('id',$ref_id);
		}
		$hotel = $hotel->first();
		
		return $hotel;
	}
	
	static public function choose_room($ref_id)
	{
		$cr = DB::table('hotels')->where('seller_id',$ref_id)->get();
		
		return $cr;
	}
	
	static public function search_rooms($ref_id,$person)
	{
		$cr = DB::table('hotels')->where([['seller_id',$ref_id],['person','>=',$person]])->get();
		
		return $cr;
	}
	
	static public function room_detail($roomId)
	{
		$room = DB::table('hotels')->where('id',$roomId)->first();
		
		return $room;
	}
	
	static public function login_user_mtwa($user,$password)
	{
		$user = DB::table('users')->where('phone',$user)->where('password',md5($password))->first();
		if($user != '') {
			$data = ['user_id'=>$user->id,'statuslogin'=>'1','role'=>$user->role];
		}else {
			$data = ['user_id'=>'','statuslogin'=>'2'];
		}
		
		return $data;
	}
	
	static public function otp_user_mtwa($phone)
	{
		$otp_code = rand(1000, 9999);
		$username2 = 'apinya';
		$password2 = 'apinya';
		$password2 = md5($password2);
		$sender = 'lottoman';
		$msisdn = $phone;
		$msg = 'รหัสยืนยันการสมัครสมาชิก '.$otp_code;


		$url="http://v2.arcinnovative.com/APIConnect.php";

		$msg = str_replace("%","%25",$msg);
		$msg = str_replace("&","%26",$msg);
		$msg = str_replace("+","[2B]",$msg);

		$sender = str_replace("%","%25",$sender);
		$sender = str_replace("&","%26",$sender);
		$sender = str_replace("+","[2B]",$sender);

		$Parameter = "";
		$Parameter .= "sender=$sender&";
		$Parameter .= "msisdn=$msisdn&";
		$Parameter .= "msg=$msg&";
		$Parameter .= "smstype=sms&";
		$Parameter .= "username=$username2&";
		$Parameter .= "password=$password2&";
		$Parameter .= "ntype=in&";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"$url");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$Parameter);
		$status = curl_exec ($ch);
		$err = curl_error($ch);
		
		$c_o = DB::table('tb_otps')->where('phone',$phone)->count();
		if($c_o < 1) {
			$otp = DB::table('tb_otps')->insert([
				'phone' => $phone,
				'otp_code' => $otp_code
			]);
		}else if($c_o > 0) {
			$otp = DB::table('tb_otps')->where('phone',$phone)
				->update([
					'otp_code' => $otp_code,
				]);
		}
	}
	
	static public function register_user_mtwa($name,$email,$phone,$password,$otp_code)
	{
		$user = DB::table('users')->where('phone',$phone)->count();
		$user2 = DB::table('users')->where('email',$email)->count();
		if($user < 1) {
			if($user2 <1) {
				$otp = DB::table('tb_otps')->where('phone',$phone)->first();
				if($otp->otp_code == $otp_code) {
					DB::beginTransaction();
					try {
						$name_main = explode(" ",$name);
						$f_name = $name_main[0];
						$l_name = $name_main[1];
						DB::table('users')->insert([
							'f_name'	=> $f_name,
							'l_name' 	=> $l_name,
							'name'	 	=> $name,
							'email' 	=> $email,
							'phone'	 	=> $phone,
							'password'	=> md5($password),
							'wallet'	=> 0
						]);

						DB::commit();
						$data = ['statusregister' => '1'];
					} catch (\Exception $e) {
						DB::rollback();
						$data = ['statusregister' => '3','error' => $e->getMessage()];
					}
				}else {
					$data = ['statusregister'=>'4'];
				}
			}else {
				$data = ['statusregister'=>'2'];
			}
		}else {
			$data = ['statusregister'=>'2'];
		}
		
		return $data;
	}
	
	static public function otp_user_mtwa_reset($phone)
	{
		$otp_code = rand(1000, 9999);
		$username2 = 'apinya';
		$password2 = 'apinya';
		$password2 = md5($password2);
		$sender = 'lottoman';
		$msisdn = $phone;
		$msg = 'รหัสยืนยันการแก้ไขรหัสผ่าน '.$otp_code;


		$url="http://v2.arcinnovative.com/APIConnect.php";

		$msg = str_replace("%","%25",$msg);
		$msg = str_replace("&","%26",$msg);
		$msg = str_replace("+","[2B]",$msg);

		$sender = str_replace("%","%25",$sender);
		$sender = str_replace("&","%26",$sender);
		$sender = str_replace("+","[2B]",$sender);

		$Parameter = "";
		$Parameter .= "sender=$sender&";
		$Parameter .= "msisdn=$msisdn&";
		$Parameter .= "msg=$msg&";
		$Parameter .= "smstype=sms&";
		$Parameter .= "username=$username2&";
		$Parameter .= "password=$password2&";
		$Parameter .= "ntype=in&";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"$url");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$Parameter);
		$status = curl_exec ($ch);
		$err = curl_error($ch);
		
		$c_o = DB::table('tb_reset_otps')->where('phone',$phone)->count();
		if($c_o < 1) {
			$otp = DB::table('tb_reset_otps')->insert([
				'phone' => $phone,
				'otp_code' => $otp_code
			]);
		}else if($c_o > 0) {
			$otp = DB::table('tb_reset_otps')->where('phone',$phone)
				->update([
					'otp_code' => $otp_code,
				]);
		}
	}
	
	static public function reset_user_mtwa($phone,$password,$otp_code)
	{
		$otp = DB::table('tb_reset_otps')->where('phone',$phone)->first();
		$check = DB::table('users')->where('phone',$phone)->count();
		if($check > 0) {
			if($otp->otp_code == $otp_code) {
				DB::beginTransaction();
				try {
					DB::table('users')->where('phone',$phone)->update([
						'password'	=> md5($password),
					]);

					DB::commit();
					$data = ['statusregister' => '1'];
				} catch (\Exception $e) {
					DB::rollback();
					$data = ['statusregister' => '3','error' => $e->getMessage()];
				}
			}else {
				$data = ['statusregister'=>'4'];
			}
		}else {
			$data = ['statusregister'=>'2'];
		}
		
		return $data;
	}
	
	static public function vote_contestant($price,$score,$id,$id_v)
	{
		if($price != '' && $score != '') {
			$n_price = $price;
			$n_score = (float)$score;
			$n_id = (int)$id;
			$rating = DB::table('users')->where('id',$n_id)->first();
			$account = DB::table('users')->where('id',$id_v)->first();
			if($account->wallet >= $n_price) {
				$rate = $rating->rating;
				$t_rate = $rate+$n_score;
				$wallet = $account->wallet;
				$t_wallet = $wallet-$n_price;
				DB::beginTransaction();
				try {
					DB::table('users')->where('id',$n_id)->update(['rating'=>$t_rate]);
					DB::table('users')->where('id',$id_v)->update(['wallet'=>$t_wallet]);
					
					$acc = DB::table('users')->where('id',$id_v)->first();
					$con = DB::table('users')->where('id',$id)->first();
					$detail = 'คุณ '.$acc->name.' ได้ทำการโหวตให้ '.$con->name;
					$v = DB::table('wallets')->insert([
						'status' 	=> 'S',
						'user_id'	=> $id_v,
						'type'		=> 'V',
						'payment' 	=> 'Wallets',
						'ref_type_id'	=> $id,
						'detail'	=> $detail,
						'price'		=> $price,
						'score'		=> $score,
					]);
					DB::commit();
				}catch (\Exception $e) {
					DB::rollback();
					$data = ['price'=>'','score'=>'','status'=>'F'];
				}

				$data = ['price'=>$n_price,'score'=>$t_rate,'status'=>'S'];
			}else {
				$data = ['price' => $price,'score'=>'','status'=>'C'];
			}
		}
		
		return $data;
	}
	
	static public function change_free_account($id_v)
	{
		if($id_v != '') {
			DB::beginTransaction();
			try {
				DB::table('users')->where('id',$id_v)->update(['free_vote'=>'1',
															  'free_vote_created_at' => date('Y-m-d h:i:s')
															  ]);
				DB::commit();
			}catch (\Exception $e) {
				DB::rollback();
			}
		}
	}
	
	static public function check_free_account($id_v)
	{
		if($id_v != '') {
			$c = DB::table('users')->where('id',$id_v)->first();
			$check = $c->free_vote;
		}else {
			$check = '0';
		}
		return $check;
	}
	
	static public function account($id)
	{
		$account = DB::table('users')->where('id',$id)->first();
		
		return $account;
	}
	
	static public function otp_phone_mtwa_reset($phone)
	{
		if($phone != '') {
			$otp_code = rand(1000, 9999);
			$username2 = 'apinya';
			$password2 = 'apinya';
			$password2 = md5($password2);
			$sender = 'lottoman';
			$msisdn = $phone;
			$msg = 'รหัสยืนยันการแก้ไขเบอร์โทรศัพท์ '.$otp_code;


			$url="http://v2.arcinnovative.com/APIConnect.php";

			$msg = str_replace("%","%25",$msg);
			$msg = str_replace("&","%26",$msg);
			$msg = str_replace("+","[2B]",$msg);

			$sender = str_replace("%","%25",$sender);
			$sender = str_replace("&","%26",$sender);
			$sender = str_replace("+","[2B]",$sender);

			$Parameter = "";
			$Parameter .= "sender=$sender&";
			$Parameter .= "msisdn=$msisdn&";
			$Parameter .= "msg=$msg&";
			$Parameter .= "smstype=sms&";
			$Parameter .= "username=$username2&";
			$Parameter .= "password=$password2&";
			$Parameter .= "ntype=in&";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"$url");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$Parameter);
			$status = curl_exec ($ch);
			$err = curl_error($ch);

			$c_o = DB::table('tb_phone_otps')->where('phone',$phone)->count();
			if($c_o < 1) {
				$otp = DB::table('tb_phone_otps')->insert([
					'phone' => $phone,
					'otp_code' => $otp_code
				]);
			}else if($c_o > 0) {
				$otp = DB::table('tb_phone_otps')->where('phone',$phone)
					->update([
						'otp_code' => $otp_code,
					]);
			}
			$data = ['status' => '1'];
		}else {
			$data = ['status' => '0'];
		}
		return $data;
	}
	
	static public function address_detail($userId)
	{
		$detail = DB::table('user_address')->where('userId',$userId)->get();
		
		return $detail;
	}
	
	static public function add_address($userId,$name,$phone,$province,$district,$subdistrict,$postcode,$detail,$main)
	{
		DB::beginTransaction();
		try{
			if($main == '1') {
				$check = DB::table('user_address')->where([['userId',$userId],['default','1']])->count();
				if($check > 0) {
					$old = DB::table('user_address')->where([['userId',$userId],['default','1']])->first();
					DB::table('user_address')
						->where('id',$old->id)
						->update([
							'default'=>'0',
						]);
				}
			}
			DB::table('user_address')->insert([
				'userId'=>$userId,
				'name'=>$name,
				'phone'=>$phone,
				'province'=>$province,
				'district'=>$district,
				'subdistrict'=>$subdistrict,
				'postcode'=>$postcode,
				'detail'=>$detail,
				'default'=>$main
			]);
			DB::commit();
			$data = ['status' => '1'];
		}catch (\Exception $e) {
			DB::rollback();
			$data = ['status' => '0'];
		}
		return $data;
	}
	
	static public function account_change($userId,$type,$text,$text2)
	{
		if($userId != '' && $type != '' && $text != '') {
			if($type == 'checkpassword') {
				$check = DB::table('users')->where([['id',$userId],['password',md5($text)]])->count();
				if($check > 0) {
					$data = ['status' => '1'];
				}else if($check < 1) {
					$data = ['status' => '3'];
				}
			}else if($type == 'phone') {
				$otp = DB::table('tb_phone_otps')
					->where('phone',$text2)
					->first();
				if($otp->otp_code == $text) {
					DB::table('users')
						->where('id',$userId)
						->update([
							'phone'=>$text2,
						]);
					$data = ['status' => '1'];
				}else {
					$data = ['status' => '4'];
				}
			}else {
				DB::beginTransaction();
				try {
					if($type == 'bio') {
						DB::table('users')
						->where('id',$userId)
						->update([
							'Bio'=>$text,
						]);
					}else if($type == 'name') {
						$name_main = explode(" ",$text);
						$f_name = $name_main[0];
						$l_name = $name_main[1];
						DB::table('users')
						->where('id',$userId)
						->update([
							'name'=>$text,
							'f_name'=>$f_name,
							'l_name'=>$l_name,
						]);
					}else if($type == 'email') {
						DB::table('users')
						->where('id',$userId)
						->update([
							'email'=>$text,
						]);
					}else if($type == 'gender') {
						if($text == 'MALE') {
							$gen = 'M';
						}else if($text == 'FEMALE') {
							$gen = 'F';
						}
						DB::table('users')
						->where('id',$userId)
						->update([
							'gender'=>$gen,
						]);
					}else if($type == 'birth') {
						DB::table('users')
						->where('id',$userId)
						->update([
							'birth'=>$text,
						]);
					}else if($type == 'password') {
						DB::table('users')
						->where('id',$userId)
						->update([
							'password'=>md5($text),
						]);
					}
					DB::commit();
					$data = ['status' => '1'];
				}catch (\Exception $e) {
					DB::rollback();
					$data = ['status' => '0'];
				}
			}
		}else {
			$data = ['status' => '2'];
		}
		return $data;
	}
	
	static public function vouchers_detail($vouchersId)
	{
		$voucher = DB::table('restaurants')->where('id',$vouchersId)->first();
		
		return $voucher;
	}
	
	static public function sos()
	{
		$sos = DB::table('emergency_tels')->get();
		
		return $sos;
	}
	
	static public function cart($acc_id,$pro_id,$qty,$seller)
	{
		if($acc_id != '' && $pro_id != '' && $qty != '' && $seller != '') {
			DB::beginTransaction();
			try {
				$o_s = DB::table('cart_sellers')->where('customer',$acc_id)->where('seller',$seller)->count();
				if($o_s < 1) {
					DB::table('cart_sellers')->insert([
						'customer' => $acc_id,
						'seller' => $seller,
					]);
					$id = DB::getPdo()->lastInsertId();
				}else {
					$c_s = DB::table('cart_sellers')->where('customer',$acc_id)->where('seller',$seller)->first();
					$id = $c_s->cs_id;
				}
				$o_c = DB::table('carts')->where('ref_cs_id',$id)->where('product',$pro_id)->first();
				$c_c = DB::table('carts')->where('ref_cs_id',$id)->where('product',$pro_id)->count();
				$p = DB::table('products')->where('id',$pro_id)->first();
				if($c_c < 1) {
					$cart = DB::table('carts')
						->insert([
							'customer' => $acc_id,
							'ref_cs_id' => $id,
							'product' => $pro_id,
							'seller' => $seller,
							'price' => $p->purchase_price,
							'total' => $qty*$p->purchase_price,
						]);
				}else if($c_c >0) {
					$cart = DB::table('carts')
						->where('ref_cs_id',$id)
						->where('product',$pro_id)
						->update([
							'qty' => $o_c->qty + $qty,
							'total' => ($o_c->qty + $qty)*$p->purchase_price,
						]);
				}
				DB::commit();
				$data = ['status_cart' => 'S'];
			}catch(\Exception $e) {
				DB::rollback();
				$data = ['status_cart' => 'F','catch' => $e->getMessage()];
			}
		}

		return $data;
	}
	
	static public function carts_restaurant($customer,$seller,$product,$qty,$price,$total)
	{
		if($customer !=''&& $seller !=''&& $product !=''&& $qty !=''&& $price !=''&& $total !='') {
			DB::beginTransaction();
			try {
				$check = DB::table('carts_restaurant')->where('customer',$customer)->count();
				if($check > 0) {
					DB::table('carts_restaurant')->where('customer',$customer)->delete();
				}
				DB::table('carts_restaurant')->insert([
					'customer'=>$customer,
					'seller'=>$seller,
					'product'=>$product,
					'qty'=>$qty,
					'price'=>$price,
					'total'=>$total,
				]);
				DB::commit();
				$data = ['status_cart' => 'S'];
				
			} catch(\Exception $e) {
				DB::rollback();
				$data = ['status_cart' => 'F'];
			}
		}
		return $data;
	}
	
	static public function carts_restaurant_list($sellerId)
	{
		$cart = DB::table('carts_restaurant')
			->join('restaurants','carts_restaurant.product','=','restaurants.id')
			->where('customer',$sellerId)
			->first();
		
		return $cart;
	}
	
	static public function carts_restaurant_delete($cartId)
	{
		DB::beginTransaction();
		try {
			DB::table('carts_restaurant')->where('c_id',$cartId)->delete();
			DB::commit();
			$data = ['status_del' => '1'];
		}catch(\Exception $e) {
			DB::rollback;
			$data = ['status_del' => '1'];
		}
		
		return $data;
	}
	
	static public function list_cart($userId)
	{
		$cart_sellers = DB::table('cart_sellers')
			->join('sellers','sellers.id','=','cart_sellers.seller')
			->where('customer',$userId)
			->get();
		
		$carts = DB::table('carts')
			->join('products','products.id','=','carts.product')
			->where('customer',$userId)
			->get();
		
		
		$total = DB::table('carts')
			->where('customer',$userId)
			->sum('total');
		
		$data = [
				'seller' => $cart_sellers,
				'product' => $carts,
				'total' =>$total,
			];
		return $data;
	}
	
	static public function qty_cart($type,$cartId)
	{
		if($type != '' && $cartId != '') {
			DB::beginTransaction();
			try {
				$c_c = DB::table('carts')->where('cart_id',$cartId)->first();
				if($type == 'plus') {
					DB::table('carts')->where('cart_id',$cartId)
						->update(['qty'=>$c_c->qty + 1,'total'=>$c_c->price*($c_c->qty + 1)]);
				}else if($type == 'minus') {
					DB::table('carts')->where('cart_id',$cartId)
						->update(['qty'=>$c_c->qty - 1,'total'=>$c_c->price*($c_c->qty - 1)]);
				}
				$n_c = DB::table('carts')->where('cart_id',$cartId)->first();
				DB::commit();
				$data = ['status_cart' => 'S','check' => $n_c->product,'type' => $type,'qty' => $n_c->qty];
			}catch(\Exception $e) {
				DB::rollback();
				$data = ['status_cart' => 'F','type' => $type,'qty' => ''];
			}
		}
		return $data;
	}
	
	static public function search_cart($cartId,$sellerId)
	{
		
		$sellerId = str_replace('[','',$sellerId);
		$sellerId = str_replace(']','',$sellerId);
		$sellerId = explode(',',$sellerId);
		$seller =[];
		for($i=0;$i<count($sellerId);$i++){
			$sellers = array_push($seller,(int)$sellerId[$i]);
		}
		
		$cart_sellers = DB::table('cart_sellers')->join('sellers','sellers.id','=','cart_sellers.seller')
			->whereIn('cart_sellers.seller',$seller)->get();
		
		$cartId = str_replace('[','',$cartId);
		$cartId = str_replace(']','',$cartId);
		$cartId = explode(',',$cartId);
		$cart =[];
		for($i=0;$i<count($cartId);$i++){
			$carts = array_push($cart,(int)$cartId[$i]);
		}
		

		$carts = DB::table('carts')->join('products','products.id','=','carts.product')->whereIn('carts.cart_id',$cart)->get();
		
		$data = [
				'seller' => $cart_sellers,
				'product' => $carts,
			];
		return $data;
	}
	
	static public function add_wishlists($userid,$wishlist_id,$type)
	{
		if($userid != '' && $wishlist_id != '' && $type != '') {
			DB::beginTransaction();
			try {
				$check = DB::table('wishlists')
					->where('customer_id',$userid)
					->where('type',$type)
					->where('product_id',$wishlist_id)
					->count();
				if($check < 1) {
					DB::table('wishlists')
						->insert([
							'customer_id' => $userid,
							'type' => $type,
							'product_id' => $wishlist_id,
						]);
					$status = 'S';
				}else if($check > 0) {
					DB::table('wishlists')
					->where('customer_id',$userid)
					->where('type',$type)
					->where('product_id',$wishlist_id)->delete();
					$status = 'SD';
				}
				DB::commit();
				$data = ['status_wishlist' => $status];
			} catch(\Exception $e) {
				DB::rollback();
				$data = ['status_wishlist' => 'F','what_is'=>$e->getMessage()];
			}
		}

		return $data;
	}
	
	static public function check_wishlists($uId,$iId,$type)
	{
		if($uId != ''&& $iId != '' && $type != '') {
			$p = DB::table('wishlists')
				->where('wishlists.customer_id',$uId)
				->where('wishlists.type',$type)
				->where('wishlists.product_id',$iId)
				->count();
			if($p > 0) {
				$data = ['check' => '1'];
			}else if($p < 1) {
				$data = ['check' => '2'];
			}
		}
		return $data;
	}
	
	static public function list_wishlists($userid)
	{
		if($userid != '') {
			$p = DB::table('wishlists')->join('products','products.id','=','wishlists.product_id')
				->where('wishlists.customer_id',$userid)
				->where('wishlists.type','P')
				->get();
		
			$r = DB::table('wishlists')->join('sellers','sellers.id','=','wishlists.product_id')
				->where('wishlists.customer_id',$userid)
				->where('wishlists.type','R')
				->get();
			$h = DB::table('wishlists')->join('sellers','sellers.id','=','wishlists.product_id')
				->where('wishlists.customer_id',$userid)
				->where('wishlists.type','H')
				->get();
			$a = DB::table('wishlists')->join('locations','locations.id','=','wishlists.product_id')
				->where('wishlists.customer_id',$userid)
				->where('wishlists.type','A')
				->get();
			
			
			$data = [
				'p'=>$p,
				'h'=>$h,
				'r'=>$r,
				'a'=>$a,
			];
		}else {
			$data = [
				'p'=>[],
				'h'=>[],
				'r'=>[],
				'a'=>[],
			];
		}
		
		return $data;
	}
	
	static public function list_payment($user_id)
	{
		$list = DB::table('wallets')->where('user_id',$user_id)->where('status','!=','CC')->where('status','!=','W')->orderBy('id','DESC')->get();
		
		return $list;
	}
	
	static public function log_wallet($type,$refno,$user_id,$price,$ref_id='',$start='',$end='')
	{
		if($type == 'IW'){
			$acc = DB::table('users')->where('id',$user_id)->first();
			$detail = 'เติมเงินเข้า wallet เป็นจำนวน '.$price.' บาท โดยคุณ '.$acc->name;
			//dd($detail);
			$lw = DB::table('wallets')->insert([
				'status' 	=> 'W',
				'user_id'	=> $user_id,
				'type'		=> $type,
				'payment' 	=> 'Pay Solutions',
				'ref_type_id'	=> $ref_id,
				'refno'		=> $refno,
				'detail'	=> $detail,
				'price'		=> $price,
			]);
		}else if($type == 'V'){
			$acc = DB::table('users')->where('id',$user_id)->first();
			$con = DB::table('users')->where('id',$ref_id)->first();
			$detail = 'คุณ '.$acc->name.' ได้ทำการโหวตให้ '.$con->name;
			$v = DB::table('wallets')->insert([
				'status' 	=> 'S',
				'user_id'	=> $user_id,
				'type'		=> $type,
				'payment' 	=> 'Wallets',
				'ref_type_id'	=> $ref_id,
				'detail'	=> $detail,
				'price'		=> $price,
				'score'		=> $refno,
			]);
		}else if($type == 'R'){
			$acc = DB::table('users')->where('id',$user_id)->first();
			$detail = 'คุณ '.$acc->name.' ได้ทำการซื้อ Vouchers';
			$r = DB::table('wallets')->insert([
				'status' 	=> 'W',
				'user_id'	=> $user_id,
				'type'		=> $type,
				'payment' 	=> 'Pay Solutions',
				'detail'	=> $detail,
				'price'		=> $price,
				'refno'		=> $refno,
			]);
			$or = DB::table('orders')->insert([
				'status_pay' => 'W',
				'order_type' => 'R',
				'refno' => $refno,
				'customer'=>$user_id,
				'total'=>$price,
			]);
			$o_id = DB::getPdo()->lastInsertId();
			$cart = DB::table('carts_restaurant')->where('c_id',$ref_id)->first();
			for($i = 0;$i<$cart->qty;$i++) {
				$ord = DB::table('order_details')->insert([
					'ref_o_id' => $o_id,
					'seller' => $cart->seller,
					'product' => $cart->product,
				]);
			}
			DB::table('carts_restaurant')->where('c_id',$ref_id)->delete();
		}else if($type == 'H'){
			$h = DB::table('hotels')->where('id',$ref_id)->first();
			if($h->prepaid == '2') {
				$sttext = 'WG';
			}else if($h->prepaid == '1') {
				$sttext = 'W';
			}
			
			$acc = DB::table('users')->where('id',$user_id)->first();
			$detail = 'คุณ '.$acc->name.' ได้ทำการจองห้องพัก';
			$r = DB::table('wallets')->insert([
				'status' 	=> $sttext,
				'user_id'	=> $user_id,
				'type'		=> $type,
				'payment' 	=> 'Pay Solutions',
				'detail'	=> $detail,
				'price'		=> $price,
				'refno'		=> $refno,
			]);
			$or = DB::table('orders')->insert([
				'status_pay' => $sttext,
				'order_type' => 'H',
				'refno' => $refno,
				'customer'=>$user_id,
				'total'=>$price,
				'start'=>$start,
				'end'=>$end,
			]);
			$o_id = DB::getPdo()->lastInsertId();
			$ord = DB::table('order_details')->insert([
				'ref_o_id' => $o_id,
				'seller' => $h->seller_id,
				'product' => $ref_id,
			]);
			DB::table('vouchers_hotel')->insert([
				'ref_o_id'=>$o_id,
				'customer'=>$user_id,
				'product'=>$ref_id,
				'status'=>'on',
			]);
				
			DB::table('hotels')->where('id',$ref_id)->update([
				'quant_room_for_mtwa'=>$h->quant_room_for_mtwa - 1
			]);
			
		}
	}
	
	static public function reset_free_vote()
	{
		DB::table('users')->update([
			'free_vote' => '0',
			'free_vote_created_at' => null,
		]);
	}
	
	static public function cc_wallet()
	{
		DB::table('wallets')->where('status','W')->update([
			'status' => 'CC',
		]);
	}
	
	static public function call_back_wallet($refno='',$total,$key)
	{
		if($refno) {
			if($key == 'IW') {
				DB::table('wallets')->where('refno',$refno)->update(['status'=>'S']);
				$acc = DB::table('wallets')->where('refno',$refno)->first();
				$acc2 = DB::table('users')->where('id',$acc->user_id)->first();
				$price = $acc2->wallet + $total;
				DB::table('users')->where('id',$acc->user_id)->update(['wallet'=>$price]);
			}else if($key == 'R') {
				DB::table('wallets')->where('refno',$refno)->update(['status'=>'S']);
				DB::table('orders')->where([['refno',$refno],['order_type',$key]])->update(['status_pay'=>'S']);
				$orders = DB::table('orders as o')->join('order_details as od','od.ref_o_id','=','o.o_id')
					->where('o.refno',$refno)->get();
				foreach($orders as $order) {
					DB::table('vouchers_restaurant')->insert([
						'customer'=>$order->customer,
						'product'=>$order->product,
						'status'=>'on',
						'ref_order_id'=>$order->o_id,
					]);
				}
			}else if($key == 'H') {
				DB::table('wallets')->where('refno',$refno)->update(['status'=>'S']);
				DB::table('orders')->where([['refno',$refno],['order_type',$key]])->update(['status_pay'=>'S']);
				
			}
		}
	}
	
	static public function show_order($userId)
	{
		$order = DB::table('orders as o')->join('order_details as od','o.o_id','=','od.ref_o_id')
		->join('restaurants as r','r.id','=','od.product')
		->where('o.customer',$userId)
		->orderBy('o.o_id','DESC')->get();

		return $order;
	}
	
	static public function vouchers_order_detail($userId,$oId)
	{
		$order = DB::table('orders as o')->join('order_details as od','o.o_id','=','od.ref_o_id')
		->join('restaurants as r','r.id','=','od.product')
		->join('users as u','u.id','=','o.customer')
		->where([['o.customer',$userId],['o.o_id',$oId]])
		->first();

		return $order;
	}
	
	static public function order_hotel_detail($userId,$vId)
	{
		$v = DB::table('vouchers_hotel as vh')
		->join('orders as o','o.o_id','=','vh.ref_o_id')
		->join('hotels as h','h.id','=','vh.product')
		->join('users as u','u.id','=','vh.customer')
		->join('sellers as s','s.id','=','h.seller_id')
		->select('vh.v_id','vh.product','h.name','h.thumbnail as image','o.refno','o.start','o.end','o.o_created_at',
				 'h.purchase_price','s.shopname','s.address','u.name as username','h.details','h.person','o.status_pay',
				 'o.o_updated_at as cdate','s.position_url','u.email','vh.customer','s.phone','vh.status','s.id as seller')
		->where('o.customer',$userId)
		->where('vh.v_id',$vId)
		->first();

		return $v;
	}
	
	static public function show_vouchers($userId)
	{
		$order = DB::table('vouchers_restaurant as vh')
			->join('restaurants as h','h.id','=','vh.product')
			->join('orders as o','o.o_id','=','vh.ref_order_id')
			->where([['o.customer',$userId],['vh.status','on']])
			->where('o.status_pay','S')
			->orderBy('vh.v_id','DESC')
			->get();

		return $order;
	}
	
	static public function show_vouchers_useless($userId)
	{
		$order = DB::table('vouchers_restaurant as vh')
			->join('restaurants as h','h.id','=','vh.product')
			->join('orders as o','o.o_id','=','vh.ref_order_id')
			->where([['o.customer',$userId],['vh.status','off']])
			->where('o.status_pay','S')
			->orderBy('vh.v_id','DESC')
			->get();

		return $order;
	}
	
	static public function show_vouchers_hotel($userId)
	{
		$order = DB::table('vouchers_hotel as vh')
			->join('hotels as h','h.id','=','vh.product')
			->join('orders as o','o.o_id','=','vh.ref_o_id')
			->select('vh.v_id','vh.product','h.name','h.thumbnail as image','o.status_pay','o.o_created_at','h.purchase_price')
			->where([['o.customer',$userId],['vh.status','on']])
			->whereIn('o.status_pay',['S','WG'])
			->orderBy('vh.v_id','DESC')
			->get();

		return $order;
	}
	
	static public function useless_vouchers_hotel($userId)
	{
		$order = DB::table('vouchers_hotel as vh')
			->join('hotels as h','h.id','=','vh.product')
			->join('orders as o','o.o_id','=','vh.ref_o_id')
			->select('vh.v_id','vh.product','h.name','h.thumbnail as image','o.status_pay','o.o_created_at','h.purchase_price')
			->where([['o.customer',$userId],['vh.status','off']])
			->whereIn('o.status_pay',['S','WG'])
			->orderBy('vh.v_id','DESC')
			->get();

		return $order;
	}
	
	static public function search_hotel($keyword,$person)
	{
		$hotel = DB::table('sellers as s')
			->join('hotels as h','h.seller_id','=','s.id')
			->select('s.id','s.shopname','s.rating','s.image','s.position_url')
			->where('h.quant_room_for_mtwa','>',0)
			->where([['person','>=',$person],['address','like','%'.$keyword.'%']])
			->get();
		
		return $hotel;
	}
	
	static public function check_rooms($hId)
	{
		$c = DB::table('hotels')->where('id',$hId)->first();
		if($c->quant_room_for_mtwa > 0) {
			$data = ['status' => '1'];
		}else if($c->quant_room_for_mtwa < 1) {
			$data = ['status' => '0'];
		}
		
		return $data;
			
	}
	
	static public function restaurant_image($resId)
	{
		$c = DB::table('restaurants as r')
			->join('restaurant_images as ri','ri.restaurant_id','=','r.id')
			->where('r.id',$resId)->get();
		
		return $c;
			
	}
	
	static public function vouchers_show_detail($userId,$vId)
	{
		$v = DB::table('vouchers_restaurant as vh')
		->join('orders as o','o.o_id','=','vh.ref_order_id')
		->join('restaurants as h','h.id','=','vh.product')
		->join('users as u','u.id','=','vh.customer')
		->join('sellers as s','s.id','=','h.seller_id')
		->select('vh.v_id','vh.product','h.name','h.images as image','o.refno','o.o_created_at','vh.status',
				 'h.purchase_price','h.unit_price','s.shopname','s.address','u.name as username','h.details','o.status_pay',
				 'o.o_updated_at as cdate','u.email','vh.customer','h.howto','h.term','h.datestart','h.dateend',
				 'h.willget','s.phone','s.id as seller')
		->where('o.customer',$userId)
		->where('vh.v_id',$vId)
		->first();

		return $v;
			
	}
	
	static public function seller_images($sId)
	{
		$i = DB::table('seller_images')->where('seller_id',$sId)->get();
		
		return $i;
	}
	
	static public function room_images($sId)
	{
		$i = DB::table('hotel_images')->where('hotel_id',$sId)->get();
		
		return $i;
	}
	
	static public function product_by_cate($cId)
	{
		$i = DB::table('restaurants as rs')
			->join('sellers as s','s.id','=','rs.seller_id')
			->select('s.*')
			->where('category_id',$cId)->get();
		
		return $i;
	}
	
	static public function form_review($sId,$uId,$type,$review,$rate)
	{
		DB::beginTransaction();
		try{
			$seller = DB::table('sellers')->where('id',$sId)->first();
			DB::table('reviews')->insert([
				'product_id'=>$sId,
				'customer_id'=>$uId,
				'type'=>$type,
				'comment'=>$review,
				'rating'=>$rate,
			]);
			$count = DB::table('reviews')->where('product_id',$sId)->count();
			$sum = DB::table('reviews')->where('product_id',$sId)->sum('rating');
			$n_rate = $sum / $count;
			if($type == 'R' || $type == 'H') {
				DB::table('sellers')
					->where('id',$sId)
					->update([
						'rating'=>$n_rate,
					]);
			}else if($type == 'A') {
				DB::table('locations')
					->where('id',$sId)
					->update([
						'rating'=>$n_rate,
					]);
			}
			DB::commit();
			$data = ['statuspost'=>'1'];
		}catch(\Exception $e) {
			DB::rollback();
			$data = ['statuspost'=>'2'];
		}
		return $data;
	}
	
	static public function ownreview($sId,$type)
	{
		if($type == 'H' || $type == 'R') {
			$data = DB::table('sellers')
				->select('shopname as name','image as image')
				->where('id',$sId)->first();
		}else if($type == 'A') {
			$data = DB::table('locations')
				->select('name as name','img_url as image')
				->where('id',$sId)->first();
		}
		return $data;
	}
	
	static public function reviewlist($sId,$type)
	{
		$data = DB::table('reviews as r')
			->select('r.id as id','u.id as user','u.name as name','u.image as image','r.comment as comment')
			->join('users as u','u.id','=','r.customer_id')
			->where([['type',$type],['product_id',$sId]])
			->orderBy('r.id','DESC')
			->get();

		return $data;
	}
	
	static public function stardust($sId,$type)
	{
		if($type == 'attrac') {
			$data = DB::table('locations')->where('id',$sId)->first();
			$rate = $data->rating;
		}else if($type == 'hotel') {
			$data = DB::table('sellers')->where('id',$sId)->first();
			$rate = $data->rating;
		} else if($type == 'restaurant') {
			$data = DB::table('sellers')->where('id',$sId)->first();
			$rate = $data->rating;
		} else if($type == 'review') {
			$data = DB::table('reviews')->where('id',$sId)->first();
			$rate = $data->rating;
		}
		return $rate;
	}
	
	static public function search_everything($keyword,$type)
	{
		if($type == 'V') {
			$data = DB::table('users as u')
				->join('thai_provinces as tp','tp.id','=','u.province')
				->select('u.*','tp.name_th')
				->where('u.role','M')
				->where('u.search_name','like','%'.$keyword.'%')
				->orWhere('tp.name_th','like','%'.$keyword.'%')
				->get();
		}else if($type == 'R') {
			$data = DB::table('sellers')
				->where('type','R')
				->where('search_name','like','%'.$keyword.'%')
				->get();
		}else if($type == 'A') {
			$data = DB::table('locations')
				->where('search_name','like','%'.$keyword.'%')
				->get();
		}
		
		return $data;
	}
	
	static public function use_vouchers($scanRes,$sellerOwn)
	{
		if (strpos($scanRes, 'MTW') !== false) {
			$mtw = explode(',',$scanRes)[0];
			$refno = explode(',',$scanRes)[1];
			$seller = explode(',',$scanRes)[2];
			$customer = explode(',',$scanRes)[3];
			$type = explode(',',$scanRes)[4];
			$vId = explode(',',$scanRes)[5];
			if($sellerOwn == $seller) {
				if($type == 'R'){
					$order = DB::table('vouchers_restaurant as vh')
						->join('orders as o','o.o_id','=','vh.ref_order_id')
						->join('restaurants as h','h.id','=','vh.product')
						->where([['o.customer',$customer],['vh.status','on'],['o.refno',$refno],['vh.v_id',$vId]])
						->count();
					$order_c = DB::table('vouchers_restaurant as vh')
						->join('orders as o','o.o_id','=','vh.ref_order_id')
						->join('restaurants as h','h.id','=','vh.product')
						->where([['o.customer',$customer],['vh.status','on'],['o.refno',$refno],['vh.v_id',$vId]])
						->first();
				}else if($type == 'H'){
					$order = DB::table('vouchers_hotel as vh')
						->join('hotels as h','h.id','=','vh.product')
						->join('orders as o','o.o_id','=','vh.ref_o_id')
						->where([['o.customer',$customer],['vh.status','on'],['o.refno',$refno],['vh.v_id',$vId]])
						->whereIn('o.status_pay',['S'])
						->count();
					$order_c = DB::table('vouchers_hotel as vh')
						->join('hotels as h','h.id','=','vh.product')
						->join('orders as o','o.o_id','=','vh.ref_o_id')
						->where([['o.customer',$customer],['vh.status','on'],['o.refno',$refno],['vh.v_id',$vId]])
						->whereIn('o.status_pay',['S'])
						->first();
				}
				
				if($order > 0){
					$datenow = date('Y-m-d');
					if($type == 'R') {
						if($datenow <= $order_c->dateend) {
							DB::beginTransaction();
							try {
								DB::table('vouchers_restaurant')
									->where('v_id',$vId)
									->update([
										'status'=>'off',
									]);
								
								DB::commit();
								$data = ['status'=>'S'];
							}catch(\Exception $e) {
								DB::rollback();
								$data = ['status'=>'F'];
							}
						}else {
							$data = ['status'=>'EXP'];
						}
					}else if($type == 'H') {
						$time = date_create_from_format('j/m/Y', $order_c->start);
						$newformat = date_format($time, 'Y-m-d');
						if($datenow == $newformat) {
							DB::beginTransaction();
							try {
								DB::table('vouchers_hotel')
									->where('v_id',$vId)
									->update([
										'status'=>'off',
									]);
								
								DB::commit();
								$data = ['status'=>'S'];
							}catch(\Exception $e) {
								DB::rollback();
								$data = ['status'=>'F'];
							}
						}else {
							$data = ['status'=>'EXP'];
						}
					}
				}else if($order < 1){
					$data = ['status'=>'NI'];
				}
			}else {
				$data = ['status'=>'NOS'];
			}
		}else {
			$data = ['status'=>'NO'];
		}
		
		return $data;
	}
	
	static public function appleIdsign($appleId,$firstname,$lastname,$email)
	{
		$check = DB::table('users')->where('appleId',$appleId)->count();
		$name = $firstname.' '.$lastname;
		if($check < 1) {
			DB::beginTransaction();
			try {
				DB::table('users')->insert([
					'appleId'=>$appleId,
					'name' =>$name,
					'f_name' => $firstname,
					'l_name' => $lastname,
					'email'	 => $email,
				]);
				$id = DB::getPdo()->lastInsertId();
				$user = DB::table('users')->where('id',$id)->first();
				DB::commit();
				$data = ['userId' => $user->id,'role'=>$user->role,'status'=>'S'];
			}catch(\Exception $e) {
				DB::rollback();
				$data = ['userId' => '','status'=>'F'];
			}
		}else if($check > 0) {
			$user = DB::table('users')->where('appleId',$appleId)->first();
			$data = ['userId' => $user->id,'role'=>$user->role,'status'=>'S'];
		}
			
		return $data;
		
	}
	
	static public function getProvinces() 
	{
		$province = DB::table('thai_provinces')->get();
		$ps[] = 'จังหวัด';
		foreach($province as $p) {
			$ps[] = $p->name_th;
		}
		
		$provinces = ['name' => $ps];  
		
		return $provinces;
	}
	
	static public function getDistrict($province) 
	{
		$p = DB::table('thai_provinces')->where('name_th',$province)->first();
		$district = DB::table('amphures')->where('province_id',$p->id)->get();
		$ps[] = 'อำเภอ';
		foreach($district as $d) {
			$ps[] = $d->name_th;
		}
		
		$district = ['name' => $ps];  
		
		return $district;
	}
	
	static public function getSubDistrict($district,$type) 
	{
		if($type == 'T') {
			$p = DB::table('amphures')->where('name_th',$district)->first();
			$district = DB::table('tumbon')->where('amphure_id',$p->id)->get();
			$ps[] = 'ตำบล';
			foreach($district as $d) {
				$ps[] = $d->name_th;
			}
		}else if($type == 'P') {
			$district = DB::table('tumbon')->where('name_th',$district)->groupby('zip_code')->get();
			$ps[] = 'รหัสไปรษณีย์';
			foreach($district as $d) {
				$ps[] = strval($d->zip_code);
			}
		}
		
		$district = ['name' => $ps];  
		
		return $district;
	}

}
