<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SellerProduct_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

		$this->date_time = date('Y-m-d H:i:s');
		$this->img_dimension_arr = array(array(72, 72), array(200, 200), array(280, 310), array(400, 200), array(430, 590), array(600, 810));
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

			if ($devicetype == 1) {
				$img_decode = json_decode($seller_result[0]->logo);

				$img = $img_decode->{MOBILE};
				$seller_details['logo'] = $img;
			} else {
				$img_decode = json_decode($seller_result[0]->logo);
				$img = $img_decode->{DESKTOP};
				$seller_details['logo'] = $img;
			}

			if ($devicetype == 1) {
				$img_decode1 = json_decode($seller_result[0]->seller_banner);

				$img1 = $img_decode1->{MOBILE};
				$seller_details['seller_banner'] = $img1;
			} else {
				$img_decode1 = json_decode($seller_result[0]->seller_banner);
				$img1 = $img_decode1->{DESKTOP};
				$seller_details['seller_banner'] = $img1;
			}
		}
		return $seller_details;
	}

	function seller_signup($seller_name, $business_name, $website, $business_address, $business_details, $country, $state, $city, $pincode, $phone, $email, $password, $plan_id, $refer_code, $promote_refer_code, $file)
	{
		$status = '';
		$user_result = array();
		$this->db->select('*');
		$this->db->where(array('phone' => $phone));
		$query0 = $this->db->get('sellerlogin');
		if ($query0->num_rows() > 0) {
			$user_result['status'] = 'exist';
		} else {
			$seller_array = array();
			$n = 10;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $n; $i++) {
				$index = rand(0, strlen($characters) - 1);
				$randomString .= $characters[$index];
			}
			require '../admin/common_function.php';
			$Common_Function = new Common_Function();
			if ($file['seller_logo']['name']) {
				$seller_logo1 = $Common_Function->file_upload_app('seller_logo', '../media/');
				$seller_logo = json_encode($seller_logo1);
			} else {
				$seller_logo = '';
			}
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
			$seller_array['companyname'] = $business_name;
			$seller_array['fullname'] = $seller_name;
			$seller_array['address'] = $business_address;
			$seller_array['description'] = $business_details;
			$seller_array['city'] = $city;
			$seller_array['pincode'] = $pincode;
			$seller_array['state'] = $state;
			$seller_array['country'] = $country;
			$seller_array['phone'] = $phone;
			$seller_array['email'] = $email;
			$seller_array['password'] = $password;
			$seller_array['logo'] = $seller_logo;
			$seller_array['websiteurl'] = $website;
			$seller_array['tax_number'] = '';
			$seller_array['pan_card'] = '';
			$seller_array['aadhar_card'] = '';
			$seller_array['business_proof'] = '';
			$seller_array['pan_number'] = '';
			$seller_array['create_by'] = $datetime;
			$seller_array['update_by'] = $datetime;
			$seller_array['update_by'] = 0;
			$seller_array['groupid'] = 1;
			$seller_array['status'] = 1;
			
			$query = $this->db->insert('sellerlogin', $seller_array);
			
			
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
					$data_wallet_history['payment_type'] = 0;
					$data_wallet_history['transaction_id'] = $transaction_id;
					$data_wallet_history['transaction_type'] = 'credit';
					$data_wallet_history['amount'] = $level_1_commision;
					$data_wallet_history['balance'] = $old_balance + $level_1_commision;
					$data_wallet_history['product_id'] = '';
					$data_wallet_history['order_id'] = '';
					$data_wallet_history['user_id'] = $user_id;
					$data_wallet_history['remark'] = 'get Refer bonus from '.$seller_result1->fullname;
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
					$data_wallet_history2['payment_type'] = 0;
					$data_wallet_history2['transaction_id'] = $transaction_id;
					$data_wallet_history2['transaction_type'] = 'credit';
					$data_wallet_history2['amount'] = $level_2_commision;
					$data_wallet_history2['balance'] = $old_balance + $level_2_commision;
					$data_wallet_history2['product_id'] = '';
					$data_wallet_history2['order_id'] = '';
					$data_wallet_history2['user_id'] = $user_id;
					$data_wallet_history2['remark'] = 'get Refer bonus from '.$seller_result1->fullname;
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
					$data_wallet_history3['payment_type'] = 0;
					$data_wallet_history3['transaction_id'] = $transaction_id;
					$data_wallet_history3['transaction_type'] = 'credit';
					$data_wallet_history3['amount'] = $level_3_commision;
					$data_wallet_history3['balance'] = $old_balance + $level_3_commision;
					$data_wallet_history3['product_id'] = '';
					$data_wallet_history3['order_id'] = '';
					$data_wallet_history3['user_id'] = $user_id;
					$data_wallet_history3['remark'] = 'get Refer bonus from '.$seller_result1->fullname;
					$data_wallet_history3['created_at'] = $this->date_time;
					$this->db->insert('wallet_transaction_history', $data_wallet_history3);
				}
				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');
				
				$this->db->select('*');
				$this->db->where(array('user_unique_id' => $user_id));
				$name_query = $this->db->get('appuser_login');
				
				$name_result1 = $name_query->result_object()[0];
					
				$fullname = $name_result1->fullname;
				
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
				$data_wallet_history1['payment_type'] = 1;
				$data_wallet_history1['transaction_id'] = $transaction_id;
				$data_wallet_history1['transaction_type'] = 'credit';
				$data_wallet_history1['amount'] = $admin_commision;
				$data_wallet_history1['balance'] = $old_balance + $admin_commision;
				$data_wallet_history1['product_id'] = '';
				$data_wallet_history1['order_id'] = '';
				$data_wallet_history1['user_id'] = $user_id;
				$data_wallet_history1['remark'] = 'get Refer bonus from '.$fullname;
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
				
				$this->db->where(array('seller_unique_id'=>$seller_result1->seller_unique_id));
				$this->db->update('sellerlogin', $seller_upd_array);
				
			} else {
				$user_unique_id = 'U' . $this->random_strings(10);
				$referral_code = 'R' . $this->random_strings(8);
				$this->db->select('*');
				if ($refer_code != '') {
					$this->db->where(array('referral_code' => $refer_code));
				} else if ($promote_refer_code != '') {
					$this->db->where(array('referral_code' => $promote_refer_code));
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
					$data_wallet_history['payment_type'] = 1;
					$data_wallet_history['transaction_id'] = $transaction_id;
					$data_wallet_history['transaction_type'] = 'credit';
					$data_wallet_history['amount'] = $level_1_commision;
					$data_wallet_history['balance'] = $old_balance + $level_1_commision;
					$data_wallet_history['product_id'] = '';
					$data_wallet_history['order_id'] = '';
					$data_wallet_history['user_id'] = $user_id;
					$data_wallet_history['remark'] = 'get Refer bonus from '.$seller_result1->fullname;
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
					$data_wallet_history2['payment_type'] = 1;
					$data_wallet_history2['transaction_id'] = $transaction_id;
					$data_wallet_history2['transaction_type'] = 'credit';
					$data_wallet_history2['amount'] = $level_2_commision;
					$data_wallet_history2['balance'] = $old_balance + $level_2_commision;
					$data_wallet_history2['product_id'] = '';
					$data_wallet_history2['order_id'] = '';
					$data_wallet_history2['user_id'] = $user_id;
					$data_wallet_history2['remark'] = 'get Refer bonus from '.$seller_result1->fullname;
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
					$data_wallet_history3['payment_type'] = 1;
					$data_wallet_history3['transaction_id'] = $transaction_id;
					$data_wallet_history3['transaction_type'] = 'credit';
					$data_wallet_history3['amount'] = $level_3_commision;
					$data_wallet_history3['balance'] = $old_balance + $level_3_commision;
					$data_wallet_history3['product_id'] = '';
					$data_wallet_history3['order_id'] = '';
					$data_wallet_history3['user_id'] = $user_id;
					$data_wallet_history3['remark'] = 'get Refer bonus from '.$seller_result1->fullname;
					$data_wallet_history3['created_at'] = $this->date_time;
					$this->db->insert('wallet_transaction_history', $data_wallet_history3);
				}
				$transaction_id = 'txt' . $this->random_strings_digit(3) . date('dmYHi');
				
				$this->db->select('*');
				$this->db->where(array('user_unique_id' => $user_id));
				$name_query = $this->db->get('appuser_login');
				
				$name_result1 = $name_query->result_object()[0];
					
				$fullname = $name_result1->fullname;
				
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
				$data_wallet_history1['payment_type'] = 1;
				$data_wallet_history1['transaction_id'] = $transaction_id;
				$data_wallet_history1['transaction_type'] = 'credit';
				$data_wallet_history1['amount'] = $admin_commision;
				$data_wallet_history1['balance'] = $old_balance + $admin_commision;
				$data_wallet_history1['product_id'] = '';
				$data_wallet_history1['order_id'] = '';
				$data_wallet_history1['user_id'] = $user_id;
				$data_wallet_history1['remark'] = 'get Refer bonus from '.$fullname;
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
				
				$this->db->where(array('seller_unique_id'=>$seller_result1->seller_unique_id));
				$this->db->update('sellerlogin', $seller_upd_array);
			}
			if ($query) {
				$user_result['status'] = '1';
				$user_result['seller_id'] = $seller_result1->seller_unique_id;
			}
		}
		return $user_result;
	}


	function add_seller_product($seller_id, $category, $prod_name, $prod_sku, $prod_url, $prod_short, $prod_details, $prod_mrp, $prod_price, $selecttaxclass, $prod_qty, $unit, $material, $width, $count, $mtrs, $selectstock, $selectvisibility, $selectcountry, $prod_hsn, $prod_purchase_lmt, $selectbrand, $selectseller, $return_policy, $prod_remark, $prod_youtubeid, $is_heavy, $prod_name_ar, $prod_short_ar, $prod_details_ar, $selectrelatedprod, $selectupsell, $prod_status, $minorderqty, $_files)
	{
		require '../admin/common_function.php';
		$Common_Function = new Common_Function();

		$media_path = '../media/';
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$product_unique_id = 'P' . substr(str_shuffle($str_result), 0, 10);
		$featured_img = '';
		$prod_img_url = '';

		/*$featured_img = '';
		if (strlen($_FILES['featured_img']['name']) > 1) {
			$featured_img = json_encode(file_upload('featured_img', $media_path, $this->img_dimension_arr));
		}

		$product_image = '';
		if (is_array($_FILES['product_image']['name'])) {
			$product_image = json_encode(file_upload('product_image', $media_path, $this->img_dimension_arr));
		}*/

		$featured_img ='';
		if($_FILES['featured_img']['name']){
			$Common_Function->img_dimension_arr = $this->img_dimension_arr;
			$featured_img1 = $Common_Function->file_upload('featured_img',$media_path);
			$featured_img = json_encode($featured_img1);
		}
		$product_image ='';
		if(is_array($_FILES['product_image']['name'])){
			$Common_Function->img_dimension_arr = $this->img_dimension_arr;
			$prod_img_url_arr = $Common_Function->file_upload('product_image',$media_path);
			$product_image = json_encode($prod_img_url_arr);
		}
		
		$prod_video ='';
		if($_FILES['prod_video']['name']){
			$Common_Function->img_dimension_arr = $img_dimension_arr;
			$prod_youtubeid_arr = $Common_Function->file_upload_video('prod_video',$media_path);
			$prod_video = str_replace('"','',json_encode($prod_youtubeid_arr));
		}


		/*print_r($featured_img);
		echo "--------------------------------------------------------------------";
		print_r($product_image);
		die;*/


		// $prod_string = $Common_Function->makeurlnamebyname($prod_name);
		// $prod_url = $prod_string;
		// $this->db->where(array('web_url' => $prod_url));
		// $query00 = $this->db->get('product_details');
		// if ($query00->num_rows() > 0) {
		// 	$prod_url = $prod_url . '-' . $product_unique_id;
		// }


		/*if($_POST['prod_url']){
					$prod_url = $Common_Function->makeurlnamebyname($_POST['prod_url']);
				}else{
					$prod_url = $prod_string;
				}*/
				
				
		$name_sub = substr($prod_name, 0, 2);
		$name_text = strtoupper($name_sub);
		$random_string = random_int(100000, 999999);
		
		$product_unique_code = $name_text.$random_string;	
		
		$prod_string = $Common_Function->makeurlnamebyname($prod_name);
			
			if($prod_url){
				$prod_url = $Common_Function->makeurlnamebyname($prod_url);
			}else{
				$prod_url = $prod_string;
			}		

		if ($prod_sku == '') {

			$prod_sku = $Common_Function->makeSKUbyname($prod_name);

			$this->db->where(array('product_sku' => $prod_sku));
			$query01 = $this->db->get('product_details');
			if ($query01->num_rows() > 0) {
				$prod_sku = $prod_sku . '-' . $product_unique_id;
			}
		}

		/*if($_POST['prod_sku']){
					$prod_sku = $Common_Function->makeSKUbyname($_POST['prod_sku']);
				}else{
					$prod_sku = $Common_Function->makeSKUbyname($_POST['prod_name']);
				}*/

		$prod_type = 1;

		/*if(array_key_exists('selected_attr',$_POST) && array_key_exists('attr_combination',$_POST)){
					if(count($_POST['selected_attr']) >0  && count($_POST['attr_combination']) >0){
						$prod_type = '2';
					}
				}*/


		$enableproduct	=  0;
		$price_type = '';
		$datetime = date('Y-m-d');

		$prod_short = substr($prod_short, 0, 500);
		$seller_array = array();


		$seller_array['status'] = $prod_status;
		$seller_array['prod_name'] = $prod_name;
		$seller_array['prod_desc'] = $prod_short;
		$seller_array['prod_fulldetail'] = $prod_details;
		$seller_array['prod_img_url'] = $product_image;
		$seller_array['attr_set_id'] = 0;
		$seller_array['brand_id'] = $selectbrand;
		$seller_array['prod_type'] = $prod_type;
		$seller_array['price_type'] = $price_type;
		$seller_array['web_url'] = $prod_url;
		$seller_array['product_sku'] = $prod_sku;
		$seller_array['product_visibility'] = $selectvisibility;
		$seller_array['product_manuf_country'] = $selectcountry;
		$seller_array['product_hsn_code'] = $prod_hsn;
		$seller_array['product_video_url'] = $prod_video;
		$seller_array['return_policy_id'] = $return_policy;
		$seller_array['product_unique_id'] = $product_unique_id;
		$seller_array['featured_img'] = $featured_img;
		$seller_array['created_at'] = $datetime;
		$seller_array['created_by'] = $seller_id;
		$seller_array['is_heavy'] = $is_heavy;
		$seller_array['prod_name_ar'] = $prod_name_ar;
		$seller_array['prod_desc_ar'] = $prod_short_ar;
		$seller_array['prod_fulldetail_ar'] = $prod_details_ar;
		$seller_array['product_unique_code'] = $product_unique_code;


		$query = $this->db->insert('product_details', $seller_array);
		$product_id = $this->db->insert_id();
		if ($query) {

			$prod_id = $product_unique_id;
			$sql_cat = '';
			/*foreach($category as $category_id){
						$category_id = $category_id;
					}*/

			$cat_array = array();
			$cat_array['cat_id'] = $category;
			$cat_array['prod_id'] = $prod_id;
			$cat_array['created_at'] = $datetime;
			$cat_array['updated_at'] = $datetime;

			$query1 = $this->db->insert('product_category', $cat_array);

			$vendor_product_array['product_id'] = $prod_id;
			$vendor_product_array['vendor_id'] = $selectseller;
			$vendor_product_array['product_mrp'] = $prod_mrp;
			$vendor_product_array['product_sale_price'] = $prod_price;
			$vendor_product_array['product_tax_class'] = $selecttaxclass;
			$vendor_product_array['product_stock'] = $prod_qty;
			$vendor_product_array['stock_status'] = $selectstock;
			$vendor_product_array['product_purchase_limit'] = $prod_purchase_lmt;
			$vendor_product_array['product_remark'] = $prod_remark;
			$vendor_product_array['product_related_prod'] = $selectrelatedprod;
			$vendor_product_array['product_upsell_prod'] = $selectupsell;
			$vendor_product_array['enable_status'] = $enableproduct;
			$vendor_product_array['created_at'] = $datetime;

			$query1 = $this->db->insert('vendor_product', $vendor_product_array);

			$vendor_prod_id = $this->db->insert_id();

			$user_result['status'] = '1';
			$user_result['product_id'] = $product_id;
		}

		return $user_result;
	}

	function update_seller_product($seller_id, $product_id, $prod_name, $prod_details, $prod_active, $prod_mrp, $prod_price, $selectbrand, $category, $product_video_url, $in_stock, $prod_qty,$selecttaxclass, $_files)
	{
		

		$this->db->select('*');
		$this->db->where(array('product_unique_id' => $product_id));
		$query000 = $this->db->get('product_details');
		if ($query000->num_rows() > 0) {

			$prod_result = $query000->result_object();

			require '../admin/common_function.php';
			$Common_Function = new Common_Function();
			$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			$product_unique_id = 'P' . substr(str_shuffle($str_result), 0, 10);
			$featured_img = '';
			$prod_img_url = '';

			/* if (strlen($_FILES['featured_img']['name']) > 1) {
				$Common_Function = new Common_Function();
				$featured_img1 = $Common_Function->file_upload_app('featured_img', '../media/');
				$featured_img = json_encode($featured_img1);
			} else {
				$featured_img = $prod_result['featured_img'];
			} */
			
			
				$media_path = '../media/';
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$product_unique_id = 'P' . substr(str_shuffle($str_result), 0, 10);
		$featured_img = '';
		$prod_img_url = '';


			$featured_img = '';
			
			
			
			if (strlen($_FILES['featured_img']['name']) > 1) {
				$Common_Function->img_dimension_arr = $this->img_dimension_arr;
				$featured_img1 = $Common_Function->file_upload('featured_img',$media_path);
				$featured_img = json_encode($featured_img1);
				/*$featured_img = json_encode(file_upload('featured_img', $media_path, $this->img_dimension_arr));*/
			} else {
				$featured_img = $prod_result['featured_img'];
			}

			if (is_array($_FILES['product_image']['name'])) {
				/*$prod_img_url = json_encode(file_upload('product_image', $media_path, $this->img_dimension_arr));*/
				
				$Common_Function->img_dimension_arr = $this->img_dimension_arr;
				$prod_img_url_arr = $Common_Function->file_upload('product_image',$media_path);
				$prod_img_url = json_encode($prod_img_url_arr);
				
			} else {
				$prod_img_url = $prod_result['prod_img_url'];
			}
			
			
			if (strlen($_FILES['prod_video']['name']) > 1) {
				/*$prod_video = doc_upload('prod_video', 'product');*/
				
				$Common_Function->img_dimension_arr = $img_dimension_arr;
				$prod_youtubeid_arr = $Common_Function->file_upload_video('prod_video',$media_path);
				$prod_video = str_replace('"','',json_encode($prod_youtubeid_arr));
				
				
			}else{
				$prod_video = $prod_result['product_video_url'];
			}
			
			
			
			
			/*if(strlen($_FILES['prod_video']['name']) >1){
					$Common_Function->img_dimension_arr = $img_dimension_arr;
					$prod_youtubeid_arr = $Common_Function->file_upload_video('prod_video',$media_path);
					$prod_video = str_replace('"','',json_encode($prod_youtubeid_arr));
				}else{
					$prod_video = $prod_result['product_video_url'];
				}*/




			/* if ($_files['product_image']['name']) {
				$Common_Function = new Common_Function();
				$prod_img_url_arr = $Common_Function->file_upload_app('product_image', '../media/');
				$prod_img_url0 = json_encode($prod_img_url_arr);

				$prod_img_url = json_encode(array_merge(json_decode($prod_img_url0, true), json_decode($prod_result[0]->prod_img_url, true)));
			} else {
				$prod_img_url = $prod_result['prod_img_url'];
			} */

			$enableproduct	=  1;
			$price_type = '';
			$datetime = date('Y-m-d');

			$prod_short = substr($prod_short, 0, 100);
			$seller_array = array();


			$seller_array['prod_name'] = $prod_name;
			$seller_array['prod_fulldetail'] = $prod_details;
			$seller_array['brand_id'] = $selectbrand;
			if ($prod_img_url != '') {
				$seller_array['prod_img_url'] = $prod_img_url;
			}
			if ($featured_img != '') {
				$seller_array['featured_img'] = $featured_img;
			}
			$seller_array['updated_at'] = $datetime;
			$seller_array['created_by'] = $seller_id;
			$seller_array['product_video_url'] = $prod_video;

			$this->db->where('product_unique_id', $product_id);
			$upd_query = $this->db->update('product_details', $seller_array);
			
			

			if ($upd_query) {

				$prod_id = $product_unique_id;
				$sql_cat = '';
				/*foreach($category as $category_id){
						$category_id = $category_id;
					}*/


				$cat_array = array();
				$cat_array['cat_id'] = $category;
				$cat_array['updated_at'] = $datetime;

				$this->db->where('prod_id', $product_id);
				$upd_query1 = $this->db->update('product_category', $cat_array);

				$vendor_product_array['enable_status'] = $prod_active;
				$vendor_product_array['product_mrp'] = str_replace('Rs.', '', $prod_mrp);
				$vendor_product_array['product_sale_price'] = str_replace('Rs.', '', $prod_price);
				$vendor_product_array['product_stock'] = $prod_qty;
				$vendor_product_array['stock_status'] = $in_stock;
				$vendor_product_array['updated_at'] = $datetime;
				$vendor_product_array['product_tax_class'] = $selecttaxclass;

				$this->db->where(array('product_id' => $product_id, 'vendor_id' => $seller_id));
				$query1 = $this->db->update('vendor_product', $vendor_product_array);

				

				$vendor_prod_id = $this->db->insert_id();

				$user_result['status'] = '1';
			}
		} else {
			$user_result['status'] = 'notexist';
		}


		return $user_result;
	}
	
	function add_exising_product($seller_id, $product_id, $prod_name, $prod_details, $prod_active, $prod_mrp, $prod_price, $selectbrand, $category, $product_video_url, $in_stock, $prod_qty,$tax_class,$product_purchase_limit,$_files)
	{
		
		$this->db->select('*');
		$this->db->where(array('product_unique_id' => $product_id));
		$query000 = $this->db->get('product_details');
		if ($query000->num_rows() > 0) {
			
			
			$prod_result = $query000->result_object();

			$enableproduct	=  1;
			$price_type = '';
			$datetime = date('Y-m-d');
			
			$this->db->select('*');
			$this->db->where(array('vendor_id' => $seller_id,'product_id' => $product_id));
			$query0001 = $this->db->get('vendor_product');
			if ($query0001->num_rows() == 0) {
			

			$seller_array = array();
			
				$vendor_product_array['product_id'] = $product_id;
				$vendor_product_array['vendor_id'] = $seller_id;
				$vendor_product_array['product_mrp'] = str_replace('Rs.', '', $prod_mrp);
				$vendor_product_array['product_sale_price'] = str_replace('Rs.', '', $prod_price);
				$vendor_product_array['product_tax_class'] = $tax_class;
				$vendor_product_array['product_stock'] = $prod_qty;
				$vendor_product_array['stock_status'] = $in_stock;
				$vendor_product_array['product_purchase_limit'] = $product_purchase_limit;
				$vendor_product_array['enable_status'] = $prod_active;
				$vendor_product_array['created_at'] = $datetime;
				

				$query1 = $this->db->insert('vendor_product', $vendor_product_array);

				

				$vendor_prod_id = $this->db->insert_id();

				$user_result['status'] = '1';
			}
			else
			{
				$user_result['status'] = 'exist';
			}

		} else {
			$user_result['status'] = 'notexist';
		}


		return $user_result;
	}

	//Functiofor for get seller product
	function get_category_product_request($language, $sellerid, $pageno, $sortby, $devicetype)
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
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
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
					if ($language == "1") {
						$product_response['name'] = $product_details->name_ar;
					} else {
						$product_response['name'] = $product_details->name;
					}

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

					if ($devicetype == 1) {
						$img_decode = json_decode($product_details->img);

						$img = $img_decode->{MOBILE};
						$product_response['imgurl'] = $img;
					} else {
						$img_decode = json_decode($product_details->img);
						$img = $img_decode->{DESKTOP};
						$product_response['imgurl'] = $img;
					}

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
