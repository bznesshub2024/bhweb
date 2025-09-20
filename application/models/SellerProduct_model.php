<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SellerProduct_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

		$this->date_time = date('Y-m-d H:i:s');
	}

	function get_seller_request($sellerid, $devicetype)
	{
		$this->db->select('companyname,fullname,description,logo,seller_banner');

		$this->db->where(array('status' => 1, 'seller_unique_id' => $sellerid));

		$query = $this->db->get('sellerlogin');

		$seller_details = array();
		if ($query->num_rows() > 0) {
			$seller_result = $query->result_object();

			$seller_details['companyname'] = $seller_result[0]->companyname;
			$seller_details['fullname'] = $seller_result[0]->fullname;
			$seller_details['description'] = $seller_result[0]->description;

			$img_decode = json_decode($seller_result[0]->logo);
			if ($devicetype == 1) {
				if (isset($img_decode->{MOBILE})) {
					$img = $img_decode->{MOBILE};
				} else {
					$img = $seller_result[0]->logo;
				}
			} else {
				if (isset($img_decode->{DESKTOP})) {
					$img = $img_decode->{DESKTOP};
				} else {
					$img = $seller_result[0]->logo;
				}
			}
			$seller_details['logo'] = $img;

			$img_decode1 = json_decode($seller_result[0]->seller_banner);

			if ($devicetype == 1) {
				if (isset($img_decode1->{MOBILE})) {
					$img1 = $img_decode1->{MOBILE};
				} else {
					$img1 = $seller_result[0]->seller_banner;
				}
			} else {
				if (isset($img_decode1->{DESKTOP})) {
					$img1 = $img_decode1->{DESKTOP};
				} else {
					$img1 = $seller_result[0]->seller_banner;
				}
			}
			$seller_details['seller_banner'] = $img1;
		}
		return $seller_details;
	}
	//Functiofor for get seller product
	function get_category_product_request($sellerid, $pageno, $sortby, $devicetype)
	{
		$prod_result = array();
		$product_array = array();

		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}
		$this->db->select('product_category.prod_id');
		$this->db->join('product_details', 'product_details.product_unique_id = product_category.prod_id', 'INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id', 'INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id', 'INNER');
		$this->db->where_in('seller.seller_unique_id', $sellerid);
		$this->db->where(array('product_details.status' => 1, 'seller.status' => 1, 'vp.enable_status' => 1));
		$this->db->group_by("product_category.prod_id");

		$this->db->limit(LIMIT, $start);

		$query = $this->db->get('product_category');


		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$product_id = array();
			foreach ($category_result as $cat_product) {
				$product_id[] = $cat_product->prod_id;
			}


			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN(' . $this->getValues($product_id) . ') AND vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');

			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1, 'seller.status' => 1, 'vp1.enable_status' => 1));
			$this->db->group_by("pd.product_unique_id");

			if ($sortby == 1) {
				$this->db->order_by("vp2.mrp_min", 'ASC');
			} else if ($sortby == 2) {
				$this->db->order_by("vp2.mrp_min", 'DESC');
			} else if ($sortby == 3) {
				$this->db->order_by("pd.created_at", 'DESC');
			} else if ($sortby == 4) {
				$this->db->order_by("pd.prod_rating_count", 'DESC');
			}

			$query_prod = $this->db->get('product_details as pd');

			if ($query_prod->num_rows() > 0) {
				$prod_result = $query_prod->result_object();

				foreach ($prod_result as $product_details) {
					$product_response = array();
					$product_response['id'] = $product_details->id;
					$product_response['name'] = $product_details->name;
					$product_response['web_url'] = $product_details->web_url;
					$product_response['sku'] = $product_details->sku;
					$product_response['active'] = $product_details->active;
					$product_response['vendor_id'] = $product_details->vendor_id;
					$product_response['mrp'] = price_format($product_details->mrp);
					$product_response['price'] = price_format($product_details->price);
					$product_response['stock'] = $product_details->stock;
					$product_response['remark'] = $product_details->remark;
					$product_response['rating'] = 0;

					$discount_per = 0;
					$discount_price = 0;
					if ($product_details->price > 0) {
						$discount_price = ($product_details->mrp - $product_details->price);

						$discount_per = ($discount_price / $product_details->mrp) * 100;
					}
					$product_response['totaloff'] = price_format($discount_price);
					$product_response['offpercent'] = round($discount_per) . '% off';
					$img_decode = json_decode($product_details->img);

					if ($devicetype == 1) {
						if (isset($img_decode->{MOBILE})) {
							$img = $img_decode->{MOBILE};
						} else {
							$img = $product_details->img;
						}
					} else {
						if (isset($img_decode->{DESKTOP})) {
							$img = $img_decode->{DESKTOP};
						} else {
							$img = $product_details->img;
						}
					}
					$product_response['imgurl'] = $img;
					$product_array[] = $product_response;
				}
			}
		}

		return $product_array;
	}

	/*
		Break All The Values In Valid Form
	*/

	function getValues($var)
	{
		if (is_array($var)) {
			$values = "'" . implode("','", $var) . "'";
		} else {
			$delm = array(",", "\n");
			$values = "'" . str_replace($delm, "','", $var) . "'";
		}
		return $values;
	}

	function get_countrycode()
	{
		$delivery_result = array();

		$this->db->select('id, name');
		$this->db->order_by('name', 'ASC');


		$query = $this->db->get('country');

		if ($query->num_rows() > 0) {
			$delivery_array = $query->result_object();
			foreach ($delivery_array as $delivery_details) {
				$delivery_response = array();
				$delivery_response['id'] = $delivery_details->id;
				$delivery_response['name'] = $delivery_details->name;

				$delivery_result[] = $delivery_response;
			}
		}

		return $delivery_result;
	}
	function get_state()
	{
		$delivery_result = array();

		$this->db->select('stateid, name');
		$this->db->order_by('name', 'ASC');
		$this->db->where('countryid', '1');

		$query = $this->db->get('state');

		if ($query->num_rows() > 0) {
			$delivery_array = $query->result_object();
			foreach ($delivery_array as $delivery_details) {
				$delivery_response = array();
				$delivery_response['id'] = $delivery_details->stateid;
				$delivery_response['name'] = $delivery_details->name;

				$delivery_result[] = $delivery_response;
			}
		}

		return $delivery_result;
	}




	function add_seller($seller_name, $business_name, $website, $business_address, $business_details, $gst, $pan_number, $selectcountry, $selectstate, $selectcity, $pincode,$no_of_products, $phone, $email, $password, $plan_id, $refer_code, $seller_type,$payment_id, $_files)
	{
		$status = '';
		$seller_array = array();
		$n = 10;
		require './admin/common_function.php';
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$img_dimension_arr = array(array(72, 72), array(200, 200), array(280, 310), array(400, 200), array(430, 590), array(600, 810));
		$randomString = '';
		
		$email = str_replace(' ', '', $email);

		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		$Common_Function = new Common_Function();
		$seller_logo = '';
		if (strlen($_FILES['seller_logo']['name']) > 1) {
			$seller_logo1 = $Common_Function->file_upload_app('seller_logo', './media/');
			$seller_logo = json_encode($seller_logo1);
		} else {
			$seller_logo = '';
		}
		
		if (strlen($_FILES['pan_card']['name']) > 1) {
			$pan_card1 = $Common_Function->file_upload_app('pan_card', './media/');
			$pan_card = json_encode($pan_card1);
		} else {
			$pan_card = '';
		}
		
		$aadhar_card = '';
		if (strlen($_FILES['aadhar_card']['name']) > 1) {
			$aadhar_card1 = $Common_Function->file_upload_app('aadhar_card', './media/');
			$aadhar_card = json_encode($aadhar_card1);
		} else {
			$aadhar_card = '';
		}

		$business_proof = '';
		if (strlen($_FILES['business_proof']['name']) > 1) {
			$business_proof1 = $Common_Function->file_upload_app('business_proof', './media/');
			$business_proof = json_encode($business_proof1);
		} else {
			$business_proof = '';
		}
		// print_r($_FILES);
		// print_r($seller_logo);
		// print_r($pan_card);
		// print_r($aadhar_card);
		// print_r($business_proof);
		// exit;

		$seller_unique_id = 'S' . $randomString;
		$datetime = date('Y-m-d H:i:s');

		$this->db->select('*');
		$this->db->where(array('plan_id' => $plan_id));
		$plan_query = $this->db->get('plans');

		$plan_result1 = $plan_query->result_object()[0];

		$plan_value = $plan_result1->plan_value;
		$admin_commision = ($plan_value * seleer_add_admin_commission) / 100;
		$level_1_commision = ($plan_value * seller_level_1_commission) / 100;
		$level_2_commision = ($plan_value * seller_level_2_commission) / 100;
		$level_3_commision = ($plan_value * seller_level_3_commission) / 100;

		$this->db->select('*');
		$this->db->where(array('phone' => $phone));
		$check_query = $this->db->get('appuser_login');

		$wallet_id = 'w_' . $this->random_strings(8);



		$seller_array['seller_unique_id'] = $seller_unique_id;
		$seller_array['companyname'] = ucwords($business_name);
		$seller_array['fullname'] = ucwords($seller_name);
		$seller_array['address'] = $business_address;
		$seller_array['description'] = $business_details;
		$seller_array['city'] = $selectcity;
		$seller_array['pincode'] = $pincode;
		$seller_array['no_of_products'] = $no_of_products;
		$seller_array['state'] = $selectstate;
		$seller_array['country'] = $selectcountry;
		$seller_array['phone'] = $phone;
		$seller_array['email'] = $email;
		$seller_array['password'] = $password;
		$seller_array['logo'] = $seller_logo;
		$seller_array['websiteurl'] = $website;
		$seller_array['tax_number'] = $gst;
		$seller_array['pan_card'] = $pan_card;
		$seller_array['aadhar_card'] = $aadhar_card;
		$seller_array['business_proof'] = $business_proof;
		$seller_array['pan_number'] = $pan_number;
		$seller_array['seller_type'] = $seller_type;
		$seller_array['plan_id'] = $plan_id;
		$seller_array['plan_value'] = $plan_value;
		$seller_array['create_by'] = $datetime;
		$seller_array['update_by'] = $datetime;
		$seller_array['update_by'] = 0;
		$seller_array['groupid'] = 1;
		
		$query = $this->db->insert('sellerlogin', $seller_array);
		
		
		$seller_pay_array['plan_id'] = $plan_id;
		$seller_pay_array['plan_value'] = $plan_value;
		$seller_pay_array['payment_id'] = $payment_id;
		$seller_pay_array['seller_id'] = $seller_unique_id;
		
		$query = $this->db->insert('seller_plan_payment', $seller_pay_array);

		$this->db->select('*');
		$this->db->where(array('phone' => $phone));
		$get_seller_query1 = $this->db->get('sellerlogin');

		$seller_result1 = $get_seller_query1->result_object()[0];



		if ($check_query->num_rows() > 0) {

			$user_result1 = $check_query->result_object()[0];

			$level_1 = $user_result1->level_1;
			$level_2 = $user_result1->level_2;
			$level_3 = $user_result1->level_3;
			$user_id = $user_result1->user_unique_id;
			


			/*$data_wallet['user_id'] = $user_id;
			$data_wallet['wallet_id'] = $wallet_id;
			$data_wallet['amount'] = 0;
			$data_wallet['created_at'] = $this->date_time;
			$this->db->insert('wallet_summery', $data_wallet);*/


			if ($level_1 != admin_user_id && $level_1 != '') {

				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');

				$this->db->select('*');
				$this->db->where(array('user_id' => $level_1));
				$query_wallet1 = $this->db->get('wallet_summery');

				$get_wallet = $query_wallet1->result_object()[0];


				$old_amount = $get_wallet->amount;
				$walet_history_upd['amount'] = $old_amount + $level_1_commision;

				$this->db->where(array('user_id' => $level_1));
				$this->db->update('wallet_summery', $walet_history_upd);

				$this->db->select('*');
				$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
				$this->db->order_by('id', 'DESC');
				$this->db->limit(1, 0);
				$query_wallet_his1 = $this->db->get('wallet_transaction_history');

				$old_balance = 0;
				if ($query_wallet_his1->num_rows() > 0) {
					$get_wallet = $query_wallet_his1->result_object()[0];

					$old_balance = $get_wallet->balance;
				}


				$data_wallet_history['wallet_id'] = $get_wallet->wallet_id;
				$data_wallet_history['payment_type'] = 4;
				$data_wallet_history['transaction_id'] = $transaction_id;
				$data_wallet_history['transaction_type'] = 'credit';
				$data_wallet_history['amount'] = $level_1_commision;
				$data_wallet_history['balance'] = $old_balance + $level_1_commision;
				$data_wallet_history['product_id'] = '';
				$data_wallet_history['order_id'] = '';
				$data_wallet_history['user_id'] = $user_id;
				$data_wallet_history['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
				$data_wallet_history['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history', $data_wallet_history);
			}

			if ($level_2 != admin_user_id && $level_2 != '') {

				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');

				$this->db->select('*');
				$this->db->where(array('user_id' => $level_2));
				$query_wallet1 = $this->db->get('wallet_summery');

				$get_wallet = $query_wallet1->result_object()[0];


				$old_amount = $get_wallet->amount;
				$walet_history_upd2['amount'] = $old_amount + $level_2_commision;

				$this->db->where(array('user_id' => $level_2));
				$this->db->update('wallet_summery', $walet_history_upd2);

				$this->db->select('*');
				$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
				$this->db->order_by('id', 'DESC');
				$this->db->limit(1, 0);
				$query_wallet_his2 = $this->db->get('wallet_transaction_history');

				$old_balance = 0;
				if ($query_wallet_his2->num_rows() > 0) {
					$get_wallet = $query_wallet_his2->result_object()[0];

					$old_balance = $get_wallet->balance;
				}


				$data_wallet_history2['wallet_id'] = $get_wallet->wallet_id;
				$data_wallet_history2['payment_type'] = 4;
				$data_wallet_history2['transaction_id'] = $transaction_id;
				$data_wallet_history2['transaction_type'] = 'credit';
				$data_wallet_history2['amount'] = $level_2_commision;
				$data_wallet_history2['balance'] = $old_balance + $level_2_commision;
				$data_wallet_history2['product_id'] = '';
				$data_wallet_history2['order_id'] = '';
				$data_wallet_history2['user_id'] = $user_id;
				$data_wallet_history2['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
				$data_wallet_history2['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history', $data_wallet_history2);
			}

			if ($level_3 != admin_user_id && $level_3 != '') {

				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');


				$this->db->select('*');
				$this->db->where(array('user_id' => $level_3));
				$query_wallet1 = $this->db->get('wallet_summery');

				$get_wallet = $query_wallet1->result_object()[0];


				$old_amount = $get_wallet->amount;
				$walet_history_upd3['amount'] = $old_amount + $level_3_commision;

				$this->db->where(array('user_id' => $level_3));
				$this->db->update('wallet_summery', $walet_history_upd3);

				$this->db->select('*');
				$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
				$this->db->order_by('id', 'DESC');
				$this->db->limit(1, 0);
				$query_wallet_his3 = $this->db->get('wallet_transaction_history');

				$old_balance = 0;
				if ($query_wallet_his3->num_rows() > 0) {
					$get_wallet = $query_wallet_his3->result_object()[0];

					$old_balance = $get_wallet->balance;
				}


				$data_wallet_history3['wallet_id'] = $get_wallet->wallet_id;
				$data_wallet_history3['payment_type'] = 4;
				$data_wallet_history3['transaction_id'] = $transaction_id;
				$data_wallet_history3['transaction_type'] = 'credit';
				$data_wallet_history3['amount'] = $level_3_commision;
				$data_wallet_history3['balance'] = $old_balance + $level_3_commision;
				$data_wallet_history3['product_id'] = '';
				$data_wallet_history3['order_id'] = '';
				$data_wallet_history3['user_id'] = $user_id;
				$data_wallet_history3['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
				$data_wallet_history3['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history', $data_wallet_history3);
			}


			$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');

			$this->db->select('*');
			$this->db->where(array('wallet_id' => admin_wallet_id));
			$this->db->order_by('id', 'DESC');
			$this->db->limit(1, 0);
			$query_wallet_his = $this->db->get('wallet_transaction_history');

			$old_balance = 0;
			if ($query_wallet_his->num_rows() > 0) {
				$get_wallet = $query_wallet_his->result_object()[0];

				$old_balance = $get_wallet->balance;
			}


			$data_wallet_history1['wallet_id'] = admin_wallet_id;
			$data_wallet_history1['payment_type'] = 4;
			$data_wallet_history1['transaction_id'] = $transaction_id;
			$data_wallet_history1['transaction_type'] = 'credit';
			$data_wallet_history1['amount'] = $admin_commision;
			$data_wallet_history1['balance'] = $old_balance + $admin_commision;
			$data_wallet_history1['product_id'] = '';
			$data_wallet_history1['order_id'] = '';
			$data_wallet_history1['user_id'] = $user_id;
			$data_wallet_history1['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
			$data_wallet_history1['created_at'] = $this->date_time;
			$this->db->insert('wallet_transaction_history', $data_wallet_history1);


			$this->db->select('*');
			$this->db->where(array('user_id' => admin_user_id));
			$query_wallet = $this->db->get('wallet_summery');

			$get_wallet = $query_wallet->result_object()[0];


			$old_amount = $get_wallet->amount;
			$walet_history_upd['amount'] = $old_amount + $admin_commision;

			$this->db->where(array('user_id' => admin_user_id));
			$this->db->update('wallet_summery', $walet_history_upd);


			$seller_upd_array['level_1'] = $level_1;
			$seller_upd_array['level_2'] = $level_2;
			$seller_upd_array['level_3'] = $level_3;
			$seller_upd_array['user_id'] = $user_id;
			$seller_upd_array['plan_id'] = $plan_id;
			$seller_upd_array['plan_value'] = $plan_value;

			$this->db->where(array('seller_unique_id' => $seller_result1->seller_unique_id));
			$this->db->update('sellerlogin', $seller_upd_array);
		} else {

			$user_unique_id = 'U' . $this->random_strings(10);
			$referral_code = 'R' . $this->random_strings(8);

			$this->db->select('*');
			if ($refer_code != '') {
				$this->db->where(array('referral_code' => $refer_code));
			} else if (get_settings('promote_refer_code') != '') {
				$this->db->where(array('referral_code' => get_settings('promote_refer_code')));
			} else {
				$this->db->where(array('user_unique_id' => admin_user_id));
			}
			$query_qet = $this->db->get('appuser_login');


			$get_user_data = $query_qet->result_object()[0];

			$level_1 = $get_user_data->user_unique_id;
			$level_2 = $get_user_data->level_1;
			$level_3 = $get_user_data->level_2;
			$user_id = $user_unique_id;

			$data['phone'] = $phone;
			$data['status'] = 1;
			$data['user_unique_id'] = $user_unique_id;
			$data['fullname'] = $seller_name;
			$data['referral_code'] = $referral_code;
			$data['referral_link'] = $refer_code;
			$data['password'] = '';
			$data['create_by'] = $this->date_time;

			$data['level_1'] = $level_1;
			$data['level_2'] = $level_2;
			$data['level_3'] = $level_3;


			$this->db->insert('appuser_login', $data);

			$data_wallet['user_id'] = $user_id;
			$data_wallet['wallet_id'] = $wallet_id;
			$data_wallet['amount'] = 0;
			$data_wallet['created_at'] = $this->date_time;
			$this->db->insert('wallet_summery', $data_wallet);


			if ($level_1 != admin_user_id && $level_1 != '') {

				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');

				$this->db->select('*');
				$this->db->where(array('user_id' => $level_1));
				$query_wallet1 = $this->db->get('wallet_summery');

				$get_wallet = $query_wallet1->result_object()[0];


				$old_amount = $get_wallet->amount;
				$walet_history_upd['amount'] = $old_amount + $level_1_commision;

				$this->db->where(array('user_id' => $level_1));
				$this->db->update('wallet_summery', $walet_history_upd);

				$this->db->select('*');
				$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
				$this->db->order_by('id', 'DESC');
				$this->db->limit(1, 0);
				$query_wallet_his1 = $this->db->get('wallet_transaction_history');

				$old_balance = 0;
				if ($query_wallet_his1->num_rows() > 0) {
					$get_wallet = $query_wallet_his1->result_object()[0];

					$old_balance = $get_wallet->balance;
				}


				$data_wallet_history['wallet_id'] = $get_wallet->wallet_id;
				$data_wallet_history['payment_type'] = 4;
				$data_wallet_history['transaction_id'] = $transaction_id;
				$data_wallet_history['transaction_type'] = 'credit';
				$data_wallet_history['amount'] = $level_1_commision;
				$data_wallet_history['balance'] = $old_balance + $level_1_commision;
				$data_wallet_history['product_id'] = '';
				$data_wallet_history['order_id'] = '';
				$data_wallet_history['user_id'] = $user_id;
				$data_wallet_history['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
				$data_wallet_history['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history', $data_wallet_history);
			}

			if ($level_2 != admin_user_id && $level_2 != '') {

				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');



				$this->db->select('*');
				$this->db->where(array('user_id' => $level_2));
				$query_wallet1 = $this->db->get('wallet_summery');

				$get_wallet = $query_wallet1->result_object()[0];


				$old_amount = $get_wallet->amount;
				$walet_history_upd2['amount'] = $old_amount + $level_2_commision;

				$this->db->where(array('user_id' => $level_2));
				$this->db->update('wallet_summery', $walet_history_upd2);

				$this->db->select('*');
				$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
				$this->db->order_by('id', 'DESC');
				$this->db->limit(1, 0);
				$query_wallet_his2 = $this->db->get('wallet_transaction_history');

				$old_balance = 0;
				if ($query_wallet_his2->num_rows() > 0) {
					$get_wallet = $query_wallet_his2->result_object()[0];

					$old_balance = $get_wallet->balance;
				}


				$data_wallet_history2['wallet_id'] = $get_wallet->wallet_id;
				$data_wallet_history2['payment_type'] = 4;
				$data_wallet_history2['transaction_id'] = $transaction_id;
				$data_wallet_history2['transaction_type'] = 'credit';
				$data_wallet_history2['amount'] = $level_2_commision;
				$data_wallet_history2['balance'] = $old_balance + $level_2_commision;
				$data_wallet_history2['product_id'] = '';
				$data_wallet_history2['order_id'] = '';
				$data_wallet_history2['user_id'] = $user_id;
				$data_wallet_history2['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
				$data_wallet_history2['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history', $data_wallet_history2);
			}

			if ($level_3 != admin_user_id && $level_3 != '') {

				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');


				$this->db->select('*');
				$this->db->where(array('user_id' => $level_3));
				$query_wallet1 = $this->db->get('wallet_summery');

				$get_wallet = $query_wallet1->result_object()[0];


				$old_amount = $get_wallet->amount;
				$walet_history_upd3['amount'] = $old_amount + $level_3_commision;

				$this->db->where(array('user_id' => $level_3));
				$this->db->update('wallet_summery', $walet_history_upd3);

				$this->db->select('*');
				$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
				$this->db->order_by('id', 'DESC');
				$this->db->limit(1, 0);
				$query_wallet_his3 = $this->db->get('wallet_transaction_history');

				$old_balance = 0;
				if ($query_wallet_his3->num_rows() > 0) {
					$get_wallet = $query_wallet_his3->result_object()[0];

					$old_balance = $get_wallet->balance;
				}



				$data_wallet_history3['wallet_id'] = $get_wallet->wallet_id;
				$data_wallet_history3['payment_type'] = 4;
				$data_wallet_history3['transaction_id'] = $transaction_id;
				$data_wallet_history3['transaction_type'] = 'credit';
				$data_wallet_history3['amount'] = $level_3_commision;
				$data_wallet_history3['balance'] = $old_balance + $level_3_commision;
				$data_wallet_history3['product_id'] = '';
				$data_wallet_history3['order_id'] = '';
				$data_wallet_history3['user_id'] = $user_id;
				$data_wallet_history3['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
				$data_wallet_history3['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history', $data_wallet_history3);
			}


			$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');

			$this->db->select('*');
			$this->db->where(array('wallet_id' => admin_wallet_id));
			$this->db->order_by('id', 'DESC');
			$this->db->limit(1, 0);
			$query_wallet_his = $this->db->get('wallet_transaction_history');

			$old_balance = 0;
			if ($query_wallet_his->num_rows() > 0) {
				$get_wallet = $query_wallet_his->result_object()[0];

				$old_balance = $get_wallet->balance;
			}


			$data_wallet_history1['wallet_id'] = admin_wallet_id;
			$data_wallet_history1['payment_type'] = 4;
			$data_wallet_history1['transaction_id'] = $transaction_id;
			$data_wallet_history1['transaction_type'] = 'credit';
			$data_wallet_history1['amount'] = $admin_commision;
			$data_wallet_history1['balance'] = $old_balance + $admin_commision;
			$data_wallet_history1['product_id'] = '';
			$data_wallet_history1['order_id'] = '';
			$data_wallet_history1['user_id'] = $user_id;
			$data_wallet_history1['remark'] = 'Become Virtual Partner Bonus from ' . $seller_result1->fullname;
			$data_wallet_history1['created_at'] = $this->date_time;
			$this->db->insert('wallet_transaction_history', $data_wallet_history1);


			$this->db->select('*');
			$this->db->where(array('user_id' => admin_user_id));
			$query_wallet = $this->db->get('wallet_summery');

			$get_wallet = $query_wallet->result_object()[0];


			$old_amount = $get_wallet->amount;
			$walet_history_upd['amount'] = $old_amount + $admin_commision;

			$this->db->where(array('user_id' => admin_user_id));
			$this->db->update('wallet_summery', $walet_history_upd);




			$seller_upd_array['level_1'] = $level_1;
			$seller_upd_array['level_2'] = $level_2;
			$seller_upd_array['level_3'] = $level_3;
			$seller_upd_array['user_id'] = $user_unique_id;
			$seller_upd_array['plan_id'] = $plan_id;
			$seller_upd_array['plan_value'] = $plan_value;

			$this->db->where(array('seller_unique_id' => $seller_result1->seller_unique_id));
			$this->db->update('sellerlogin', $seller_upd_array);
		}


		if ($query) {
			$status = 'Add Seller Successfully';
		}
		return $status;
	}

	function get_city()
	{
		$delivery_result = array();

		$this->db->select('city_id, city_name');
		$this->db->order_by('city_name', 'ASC');
		//$this->db->where('state_code', '38');


		$query = $this->db->get('city');

		if ($query->num_rows() > 0) {
			$delivery_array = $query->result_object();
			foreach ($delivery_array as $delivery_details) {
				$delivery_response = array();
				$delivery_response['id'] = $delivery_details->city_id;
				$delivery_response['name'] = $delivery_details->city_name;

				$delivery_result[] = $delivery_response;
			}
		}

		return $delivery_result;
	}

	function get_plans()
	{
		$plan_result = array();

		$this->db->select('plan_id, plan_name,plan_value');
		$this->db->order_by('plan_id', 'ASC');


		$query = $this->db->get('plans');

		if ($query->num_rows() > 0) {
			$delivery_array = $query->result_object();
			foreach ($delivery_array as $delivery_details) {
				$plan_response = array();
				$plan_response['plan_id'] = $delivery_details->plan_id;
				$plan_response['plan_name'] = $delivery_details->plan_name;
				$plan_response['plan_value'] = $delivery_details->plan_value;

				$plan_result[] = $plan_response;
			}
		}

		return $plan_result;
	}

	function random_strings($length_of_string)
	{

		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result), 0, $length_of_string);
	}

	function random_strings_digit($length_of_string)
	{

		// String of all alphanumeric character 
		$str_result = '0123456789';

		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result), 0, $length_of_string);
	}
}
