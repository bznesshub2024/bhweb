<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

		$this->date_time = date('Y-m-d H:i:s');
	}

	function delete_app_user($user_id)
	{
		$this->db->where(array('user_unique_id' => $user_id));

		$query = $this->db->delete('appuser_login');

		if ($query) {
			return 'delete';
		}
	}
	
	function add_seller($seller_name,$business_name,$business_details,$business_address,$gst_number,$state,$city,$pincode,$no_of_products,$phone,$email,$password,$pan_card,$aadhar_card,$business_proof,$seller_type,$plan_id,$refer_code,$payment_id)
	{
		$status = '';
		$seller_array = array();
		$n=10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
		  
			for ($i = 0; $i < $n; $i++) {
				$index = rand(0, strlen($characters) - 1);
				$randomString .= $characters[$index];
			}
		

		$seller_unique_id = 'S'.$randomString;
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
		$seller_array['no_of_products'] = $no_of_products;
		$seller_array['state'] = $state;
		$seller_array['country'] = 1;
		$seller_array['phone'] = $phone;
		$seller_array['email'] = $email;
		$seller_array['password'] = $password;
		$seller_array['logo'] = '';
		$seller_array['websiteurl'] = '';
		$seller_array['tax_number'] = $gst_number;
		$seller_array['pan_card'] = $pan_card;
		$seller_array['aadhar_card'] = $aadhar_card;
		$seller_array['business_proof'] = $business_proof;
		$seller_array['pan_number'] = '';
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
			
	
		if($query){
			$status = 'Add Seller Successfully';
		}
		return $status;	
		
	}
	
	
	function get_recent_products_request($language, $devicetype,$product_ids){
       $prod_result = array();
       $product_array = array();
	   
		$start = 0;
		$sortby = 1;
		
		if($product_ids){
			  $product_id = explode(',',$product_ids);		 
				  
			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
			$this->db->group_by("pd.product_unique_id"); 
			
			if($sortby==1){
				$this->db->order_by("vp2.mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("vp2.mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}
			
			$this->db->limit(10,$start);
			$query_prod = $this->db->get('product_details as pd');
			
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				$product_array = array();
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					if($language==1){
						$product_response['name'] = html_entity_decode($product_details->name_ar);
					}else{
						$product_response['name'] = html_entity_decode($product_details->name);
					}
					$product_response['web_url'] = $product_details->web_url;
					$product_response['sku'] = $product_details->sku;
					$product_response['active'] = $product_details->active;
					$product_response['vendor_id'] = $product_details->vendor_id;
					$product_response['mrp'] = price_format($product_details->mrp);
					$product_response['price'] = price_format($product_details->price);
					$product_response['stock'] = $product_details->stock;
					$product_response['remark'] = html_entity_decode($product_details->remark);
					$product_response['rating'] = 0;
					
					$discount_per = 0;
					$discount_price = 0;
					if($product_details->price >0){
						$discount_price = ($product_details->mrp-$product_details->price);
						
						$discount_per = ($discount_price/$product_details->mrp)*100;
						
					}
					$product_response['totaloff'] = price_format($discount_price);
					$product_response['offpercent'] = round($discount_per).'%';
					
					$img_decode = json_decode($product_details->img);
					
					if($devicetype == 1){
						if(isset($img_decode->{MOBILE})){					
							$img = $img_decode->{MOBILE};
						}else{
							$img = $product_details->img;
						}
						
					}else{
						if(isset($img_decode->{DESKTOP})){					
							$img = $img_decode->{DESKTOP};
						}else{
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
	
	function seller_order_datewise($payment_id,$seller_id)
	{
		
		$product_array = array();
		
		$this->db->select("from_date,to_date");
		$this->db->where(array('id' => $payment_id));
		$query = $this->db->get('payment');

		if ($query->num_rows() > 0) {
			$data_result = $query->result_object();

			$from_date = $data_result[0]->from_date;
			$to_date = $data_result[0]->to_date;
			
			
							
			$this->db->select('o.order_id,o.user_id,op.status, o.total_price, o.payment_orderid,o.payment_id,o.payment_mode,o.qoute_id,o.create_date,o.discount,op.qty,op.tds,op.tcs,op.gross_amount,op.gst_input,op.net_amount,op.prod_id');
			$this->db->join('order_product op', 'op.order_id = o.order_id', 'INNER');
			$this->db->where(array('op.vendor_id' => $seller_id ,'op.status' => 'Delivered','date(op.create_date) >=' => $from_date,'date(op.create_date) <=' => $to_date));
			$this->db->order_by("o.sno", 'DESC');
			$query_prod = $this->db->get('orders o');
		
		
		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();

			$product_array = array();
			foreach ($prod_result as $product_details) {
				$product_response = array();
				$product_response['orderid'] = $product_details->order_id;
				$product_response['qty'] = $product_details->qty;
				$product_response['total_price'] = $product_details->total_price;
				$product_response['tds'] = $product_details->tds;
				$product_response['tcs'] = $product_details->tcs;
				$product_response['gross_amount'] = $product_details->gross_amount;
				$product_response['gst_input'] = $product_details->gst_input;
				$product_response['net_amount'] = $product_details->net_amount;
				$product_response['status'] = $product_details->status;
				$product_response['order_date'] = date('d-m-Y',strtotime($product_details->create_date));
					
					
				$product_array[] = $product_response;	
			}
		}
					
			
		}
	return $product_array;	
	}
	
	function seller_payment($seller_id,$pageno)
	{
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}
		
		$this->db->select('pm.id,pm.seller_id,pm.amount,pm.from_date,pm.to_date,pm.payment_status,pm.transection_id,sl.companyname');
		$this->db->join('sellerlogin sl', 'pm.seller_id = sl.seller_unique_id', 'INNER');
		$this->db->where(array('pm.seller_id' => $seller_id));
		$this->db->order_by("pm.id", 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_prod = $this->db->get('payment pm');
		
		
		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();

			$product_array = array();
			foreach ($prod_result as $product_details) {
				$product_response = array();
				$product_response['id'] = $product_details->id;
				$product_response['seller_id'] = $product_details->seller_id;
				$product_response['amount'] = $product_details->amount;
				$product_response['date_range'] = date('d-m-Y',strtotime($product_details->from_date)).' TO '.date('d-m-Y',strtotime($product_details->to_date));
				$product_response['payment_status'] = $product_details->payment_status;
				$product_response['transection_id'] = $product_details->transection_id;
					
					
				$product_array[] = $product_response;	
			}
		}
		return $product_array;
		
	}

	function add_bank_details($ac_name,$ac_number,$ifsc_code,$upi_id,$user_id)
	{
		$this->db->select('*');
		$this->db->where(array('user_id' => $user_id));
		$check_query = $this->db->get('bank_details');
		$prod_result = array();
		
		$prod_result['ac_name'] = $ac_name;
		$prod_result['ac_number'] = $ac_number;
		$prod_result['ifsc_code'] = $ifsc_code;
		$prod_result['upi_id'] = $upi_id;
		$prod_result['user_id'] = $user_id;
			
		if($check_query->num_rows() > 0){
			
			$data_bank['ac_name'] = $ac_name;
			$data_bank['ac_number'] = $ac_number;
			$data_bank['ifsc_code'] = $ifsc_code;
			$data_bank['upi_id'] = $upi_id;
			$data_bank['updated_at'] = $this->date_time;
			
			$this->db->where(array('user_id'=>$user_id));
			$this->db->update('bank_details',$data_bank);
		
		}
		else
		{
			$data_bank['ac_name'] = $ac_name;
			$data_bank['ac_number'] = $ac_number;
			$data_bank['ifsc_code'] = $ifsc_code;
			$data_bank['upi_id'] = $upi_id;
			$data_bank['user_id'] = $user_id;
			$data_bank['created_at'] = $this->date_time;
			$this->db->insert('bank_details',$data_bank);
		}
		return $prod_result;
	}


	function get_seller_product($language, $pageno, $devicetype, $seller_id, $sortby)
	{
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


		$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
		$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
		$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
		$this->db->where_in('vp1.vendor_id', $seller_id);
		$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1));
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

		$this->db->order_by("pd.id", 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_prod = $this->db->get('product_details as pd');

		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();

			$product_array = array();
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
					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				} else {
					$img_decode = json_decode($product_details->img);
					$img = $img_decode->{DESKTOP};

					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				}

				$product_array[] = $product_response;
			}
		}
		return $product_array;
	}
	
	function get_seller_inactive_product($language, $pageno, $devicetype, $seller_id, $sortby)
	{	
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


		$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.enable_status=0 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
		$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
		$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
		$this->db->where_in('vp1.vendor_id', $seller_id);
		$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 0, 'seller.status' => 1));
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

		$this->db->order_by("pd.id", 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_prod = $this->db->get('product_details as pd');

		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();

			$product_array = array();
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
					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				} else {
					$img_decode = json_decode($product_details->img);
					$img = $img_decode->{DESKTOP};

					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				}

				$product_array[] = $product_response;
			}
		}
		return $product_array;
	}
	
	
	function get_seller_product_pending($language, $pageno, $devicetype, $seller_id, $sortby)
	{
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


		$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
		$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
		$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
		$this->db->where_in('vp1.vendor_id', $seller_id);
		$this->db->where(array('pd.status' => 0, 'vp1.enable_status' => 1, 'seller.status' => 1));
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

		$this->db->order_by("pd.id", 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_prod = $this->db->get('product_details as pd');

		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();

			$product_array = array();
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
					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				} else {
					$img_decode = json_decode($product_details->img);
					$img = $img_decode->{DESKTOP};

					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				}

				$product_array[] = $product_response;
			}
		}
		return $product_array;
	}

	function get_seller_product_bycategory($language, $pageno, $devicetype, $seller_id, $sortby, $cat_id)
	{
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


		$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
		$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
		$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
		$this->db->join('product_category pc', 'pc.prod_id = pd.product_unique_id', 'INNER');
		$this->db->where_in('vp1.vendor_id', $seller_id);
		$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1, 'pc.cat_id' => $cat_id));
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

		$this->db->order_by("pd.id", 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_prod = $this->db->get('product_details as pd');

		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();

			$product_array = array();
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
					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				} else {
					$img_decode = json_decode($product_details->img);
					$img = $img_decode->{DESKTOP};

					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				}

				$product_array[] = $product_response;
			}
		}
		return $product_array;
	}

	function get_seller_product_bybrand($language, $pageno, $devicetype, $seller_id, $sortby, $brand_id)
	{
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


		$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
		$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
		$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
		$this->db->join('brand bd', 'bd.brand_id = pd.brand_id', 'INNER');
		$this->db->where_in('vp1.vendor_id', $seller_id);
		$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1, 'bd.brand_id' => $brand_id));
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

		$this->db->order_by("pd.id", 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_prod = $this->db->get('product_details as pd');

		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();

			$product_array = array();
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
					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				} else {
					$img_decode = json_decode($product_details->img);
					$img = $img_decode->{DESKTOP};

					if ($img != '') {
						$product_response['imgurl'] = $img;
					} else {
						$product_response['imgurl'] = '';
					}
				}

				$product_array[] = $product_response;
			}
		}
		return $product_array;
	}

	function get_check_pincode_request($language, $pincode)
	{
		$data_response = 'Item is not deliverable for selected Pincode';

		$curl1 = curl_init();
		curl_setopt_array($curl1, array(
			CURLOPT_URL => 'https://api.nimbuspost.com/v1/users/login',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
									"email" : "marurangecommerce@gmail.com",
									"password" : "Borawar@739"				
								}',
			CURLOPT_HTTPHEADER => array(
				'content-type: application/json'
			),
		));
		$response1 = curl_exec($curl1);
		curl_close($curl1);
		$token_data = json_decode($response1);
		$token = $token_data->data;



		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.nimbuspost.com/v1/courier/serviceability',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Token ' . $token
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$response_pincode = json_decode($response);
		foreach ($response_pincode->data as $pin_data) {
			if ($pin_data->pincode == $pincode) {
				$data_response = 'Delivery Available Your Area';
			}
		}



		return $data_response;
	}

	function add_user_token($language_code,$token,$user_id,$is_seller)
	{
		$data['token'] = $token;
		$data['user_id'] = $user_id;
		$data['is_seller'] = $is_seller;


		$this->db->insert('app_token', $data);

		return 'done';
	}
	
	function withdrow_money_post($user_id, $amount)
	{
		$data['user_id'] = $user_id;
		$data['amount'] = round($amount,2);
		$data['created_at'] = $this->date_time;


		$this->db->insert('wallet_withdrow', $data);

		return 'done';
	}

	function wallet_summery($user_id, $wallet_id)
	{

		$this->db->select("wh.wallet_id,wh.payment_type,wh.transaction_id,wh.transaction_type,wh.amount,wh.remark,wh.created_at");

		$this->db->join('wallet_summery ws', 'wh.wallet_id = ws.wallet_id', 'INNER');
		$this->db->where(array('wh.wallet_id' => $wallet_id, 'ws.user_id' => $user_id));

		$this->db->order_by('wh.created_at', 'DESC');
		$query = $this->db->get('wallet_transaction_history wh');

		$cart_result = array();
		if ($query->num_rows() > 0) {
			$cart_results = $query->result_object();

			foreach ($cart_results as $cart_details) {

				$city_response = array();

				$city_response['wallet_id'] = $cart_details->wallet_id;

				$city_response['payment_type'] = $cart_details->payment_type;
				$city_response['transaction_id'] = $cart_details->transaction_id;
				$city_response['transaction_type'] = $cart_details->transaction_type;
				$city_response['amount'] = number_format(round($cart_details->amount,2));
				$city_response['remark'] = $cart_details->remark;

				$city_response['countryid'] = date('d-m-Y', strtotime($cart_details->created_at));



				$cart_result[] = $city_response;
			}
		}
		return $cart_result;
	}

	function wallet_total_amount($user_id, $wallet_id)
	{

		$amount = 0;
		$this->db->select("amount");
		$this->db->where(array('wallet_id' => $wallet_id, 'user_id' => $user_id));
		$query = $this->db->get('wallet_summery');

		if ($query->num_rows() > 0) {
			$data_result = $query->result_object();

			$amount = $data_result[0]->amount;
		}
		return round($amount,0);
	}


	function wallet_summary($user_id, $wallet_id)
    {

        // $CI =& get_instance();
        // $CI->load->database();
        // $CI->load->model('wallet_model'); // make sure the model is loaded

        // // if no user id passed, use session
        // if ($user_id === null) {
        //     $user_id = $CI->session->userdata('user_id');
        // }

        $wallet = $this->get_wallet_data($user_id); 
		$wallet_summery = $this->get_wallet_summery($wallet['wallet_id']);
		$wallet_bonus   = $this->get_wallet_bonus($wallet['wallet_id']);

		$total_bonus = 0;
		$deduct_wallet=0;
		$return_wallet=0;
		$deduct_virtual_wallet=0;
		$return_virtual_wallet=0;

		foreach($wallet_bonus as $wallet_bonus)
		{
			
			if($wallet_bonus->payment_type == '1')
			{
				$total_bonus = $total_bonus + $wallet_bonus->amount;
			}
	        if($wallet_bonus->payment_type == '6')
	        {
	            $deduct_wallet = $deduct_wallet + $wallet_bonus->amount;
	        }
	        if($wallet_bonus->payment_type == '8')
	        {
	            $return_wallet = $return_wallet + $wallet_bonus->amount;
	        }
	        if($wallet_bonus->payment_type == '7')
	        {
	            $deduct_virtual_wallet = $deduct_virtual_wallet + $wallet_bonus->amount;
	        }
	        if($wallet_bonus->payment_type == '9')
	        {
	            $return_virtual_wallet = $return_virtual_wallet + $wallet_bonus->amount;
	        }
		}
		$total_bonus=($total_bonus+$return_wallet)-$deduct_wallet;
		$unwithdraw_amount = '';
	    $total_virtual_amount=0;
	    if($wallet['amount'] > 0){
	    	if($total_bonus != 0)
	    	{
	    		$amount = $wallet['amount'] - $total_bonus;
	            $total_virtual_amount = ($amount+$return_virtual_wallet) - $deduct_virtual_wallet;
	    		
	    	}
	    	else
	    	{
	    		$amount = $wallet['amount'];
	            $total_virtual_amount = ($amount+$return_virtual_wallet) - $deduct_virtual_wallet;
	    	}
	    }
	    $both_message = " (".$total_bonus." New User Bonus + ".round($total_virtual_amount,2)." Virtual Partner/Order Commission)";

	    $array=[
	    	'total_wallet_balance'=>round($wallet['amount'],0),
	    	'newUserBonus'=>round($total_bonus,2),
	    	'virtualPartner'=>round($total_virtual_amount,2),
	    	'both_message'=>$both_message,

	    ];
	    return $array;

    }


    function get_wallet_data($user_id){
		
		$this->db->select('amount,wallet_id');
		$this->db->where(array('user_id' => $user_id));
		$query = $this->db->get('wallet_summery');
		
		$wallet_result = array();
		if($query->result_object()){
			$user_result = $query->result_object()[0];
			$wallet_result['amount'] = $user_result->amount;
			$wallet_result['wallet_id'] = $user_result->wallet_id; 
		}
		return $wallet_result;
	}

	function get_wallet_summery($wallet_id){
		
		$this->db->select("*");
		$this->db->where(array('wallet_id' => $wallet_id));
		$this->db->order_by("id", 'desc');
		$this->db->limit(8,0);
		
		
		$query = $this->db->get('wallet_transaction_history');
		
		$cart_result = array();
		if($query->num_rows() >0){
			$cart_result = $query->result_object();			
		}
		return $cart_result;
	}
	
	function get_wallet_bonus($wallet_id){
		
		$this->db->select("*");
		$this->db->where(array('wallet_id' => $wallet_id));
		$this->db->order_by("id", 'desc');
		
		
		$query = $this->db->get('wallet_transaction_history');
		
		$cart_result = array();
		if($query->num_rows() >0){
			$cart_result = $query->result_object();			
		}
		return $cart_result;
	}


	function bonus_wallet_summery($user_id, $wallet_id)
	{

		$total_bonus = 0;
		$this->db->select("wh.wallet_id,wh.payment_type,wh.transaction_id,wh.transaction_type,wh.amount,wh.remark,wh.created_at");

		$this->db->join('wallet_summery ws', 'wh.wallet_id = ws.wallet_id', 'INNER');
		$this->db->where(array('wh.wallet_id' => $wallet_id, 'ws.user_id' => $user_id));


		$query = $this->db->get('wallet_transaction_history wh');

		$cart_result = array();
		
		if ($query->num_rows() > 0) {
			$cart_results = $query->result_object();

			foreach ($cart_results as $cart_details) {
			
				if($cart_details->payment_type == 4)
				{
					$total_bonus = $total_bonus + $cart_details->amount;
				}
				
			}
		}
		else
		{
			$total_bonus = 0;
		}
		return round($total_bonus,0);
	}

	function wallet_summery_datewise($user_id, $wallet_id, $title, $start_date, $end_date)
	{

		$this->db->select("wh.wallet_id,wh.payment_type,wh.transaction_id,wh.transaction_type,wh.amount,wh.remark,wh.created_at,ws.amount as total_amount");

		$this->db->join('wallet_summery ws', 'wh.wallet_id = ws.wallet_id', 'INNER');
		$this->db->where(array('wh.wallet_id' => $wallet_id, 'ws.user_id' => $user_id));

		if ($start_date != '' && $end_date != '') {

			$this->db->where('DATE(wh.created_at) >=', date('Y-m-d', strtotime($start_date)));
			$this->db->where('DATE(wh.created_at) <=', date('Y-m-d', strtotime($end_date)));
		}
		$this->db->like('wh.remark', $title);

		$this->db->order_by('wh.created_at', 'DESC');
		$query = $this->db->get('wallet_transaction_history wh');

		$cart_result = array();
		if ($query->num_rows() > 0) {
			$cart_results = $query->result_object();

			foreach ($cart_results as $cart_details) {

				$city_response = array();

				$city_response['wallet_id'] = $cart_details->wallet_id;

				$city_response['payment_type'] = $cart_details->payment_type;
				$city_response['transaction_id'] = $cart_details->transaction_id;
				$city_response['transaction_type'] = $cart_details->transaction_type;
				$city_response['amount'] = number_format(round($cart_details->amount,2));
				$city_response['remark'] = $cart_details->remark;

				$city_response['countryid'] = date('d-m-Y h:i:sA', strtotime($cart_details->created_at));



				$cart_result[] = $city_response;
			}
		}
		return $cart_result;
	}


	function get_subcategory_request($language, $category_result, $parent_id = '', $devicetype)
	{

		$this->db->select('cat_id as id,cat_name as name, cat_name as name_ar, cat_img,cat_slug');

		$this->db->where(array('parent_id' => $parent_id, 'status' => 1));
		$this->db->order_by('cat_order', 'ASC');
		$query = $this->db->get('category');

		if ($query->num_rows() > 0) {
			$category_array = $query->result_object();
			foreach ($category_array as $cat_details) {
				$cat_response = array();
				$cat_response['id'] = $cat_details->id;
				if ($language == "1") {
					$cat_response['name'] = $cat_details->name_ar;
				} else {
					$cat_response['name'] = $cat_details->name;
				}

				$cat_response['cat_slug'] = $cat_details->cat_slug;

				$img_decode = json_decode($cat_details->cat_img);
				$img = '';

				if ($devicetype == 1) {
					if (isset($img_decode->{MOBILE})) {
						$img = $img_decode->{MOBILE};
					} else {
						$img = $cat_details->cat_img;
					}
				} else {
					if (isset($img_decode->{DESKTOP})) {
						$img = $img_decode->{DESKTOP};
					} else {
						$img = $cat_details->cat_img;
					}
				}
				$cat_response['imgurl'] = $img;
				$category_result[] = $cat_response;
				$category_result2 = $this->categoryTree($language, $cat_details->id, $devicetype);

				if ($category_result2) {
					$category_result = array_merge($category_result, $category_result2);
				} else {
					$category_result[] = $cat_response;
				}
			}
		}

		return $category_result;
	}

	function categoryTree($language, $parent_id, $devicetype)
	{
		$this->db->select('cat_id as id,cat_name as name, cat_name as name_ar, cat_img,cat_slug');

		$this->db->where(array('cat.status' => 1, 'cat.parent_id' => $parent_id));
		$this->db->order_by('cat.cat_order', 'ASC');

		$query = $this->db->get('category cat');

		if ($query->num_rows() > 0) {
			$category_array = $query->result_object();
			foreach ($category_array as $cat_details) {

				$cat_response['id'] = $cat_details->id;
				if ($language == "1") {
					$cat_response['name'] = $cat_details->name_ar;
				} else {
					$cat_response['name'] = $cat_details->name;
				}

				$cat_response['cat_slug'] = $cat_details->cat_slug;

				$img_decode = json_decode($cat_details->cat_img);
				$img = '';

				if ($devicetype == 1) {
					if (isset($img_decode->{MOBILE})) {
						$img = $img_decode->{MOBILE};
					} else {
						$img = $cat_details->cat_img;
					}
				} else {
					if (isset($img_decode->{DESKTOP})) {
						$img = $img_decode->{DESKTOP};
					} else {
						$img = $cat_details->cat_img;
					}
				}
				$cat_response['imgurl'] = $img;
				$category_result2 = $this->categoryTree($language, $cat_details->id, $devicetype);
				if ($category_result2) {
					$category_result[] = array_merge($cat_response, $category_result2);
				} else {
					$category_result[] = $cat_response;
				}
			}

			return $category_result;
		}
	}

	function get_category_product_request($language, $catid, $pageno, $sortby, $devicetype, $config_attr)
	{
		$prod_result = array();
		$product_array = array();

		if ($pageno > 0) {
			$start = ($pageno * 20);
		} else {
			$start = 0;
		}
		$config_attr_decode =  json_decode($config_attr);

		$this->db->select('product_category.prod_id');
		$this->db->join('product_details', 'product_details.product_unique_id = product_category.prod_id', 'INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id', 'INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id', 'INNER');

		if ($config_attr_decode) {
			$this->db->join('product_attribute_value pav', 'vp.id = pav.vendor_prod_id', 'INNER');
		}

		$this->db->where_in('product_category.cat_id', $catid);
		$this->db->where(array('(product_details.status' => 1, 'seller.status' => 1, 'vp.enable_status' => 1));

		$first_line = 0;
		if ($config_attr_decode) {
			foreach ($config_attr_decode as $config_attribute) {
				$attr_id = $config_attribute->attr_id;
				$attr_name = $config_attribute->attr_name;
				$attr_value = trim($config_attribute->attr_value);


				$query_prod = $this->db->query(' SELECT id FROM product_attributes_conf WHERE 
								attribute_id = "' . $attr_id . '" AND attribute_value = "' . $attr_value . '" ');

				if ($query_prod->num_rows() > 0) {
					if ($first_line == 0) {
						$this->db->like('pav.prod_attr_value', ':"' . $attr_value . '"');
					} else {
						$this->db->or_like('pav.prod_attr_value', ':"' . $attr_value . '"');
					}
				} else {
					$this->db->reset_query();
					return 'invalid_filter';
					die;
				}
				$first_line++;
			}
		}

		$this->db->group_end()->group_by("product_category.prod_id");

		$this->db->limit(LIMIT, $start);

		$query = $this->db->get('product_category');

		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$product_id = array();
			foreach ($category_result as $cat_product) {
				$product_id[] = $cat_product->prod_id;
			}


			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock,vp1.stock_status, vp1.product_remark as remark,seller.phone');


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
					if ($language == 1) {
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
					$product_response['stock_status'] = $product_details->stock_status;
					$product_response['remark'] = $product_details->remark;
					$product_response['seller_mobile'] = $product_details->phone;
					$product_response['rating'] = 0;

					$product_review_array = $this->get_product_review($product_details->id);

					if (!empty($product_review_array)) {
						$product_response['product_total_rating'] = $product_review_array['total_rating'];
						$product_response['product_rating_count'] = $product_review_array['rating_count'];
					} else {
						$product_response['product_total_rating'] = '';
						$product_response['product_rating_count'] = '';
					}

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

					$product_response['imgurl'] = str_replace("-430-590", '', $img);
					$product_array[] = $product_response;
				}
			}
		}

		return $product_array;
	}


	function get_explore_category_request($language, $devicetype, $cat_ids)
	{
		$category_result = array();

		$this->db->select('cat.cat_id,cat.cat_name,cat.cat_name_ar,cat.cat_img,cat.parent_id,cat.cat_slug, cat.web_banner');

		$this->db->where(array('cat.status' => 1, 'cat.cat_id' => $cat_ids));
		$this->db->order_by('cat.cat_order', 'ASC');

		//$this->db->limit(8, 0);
		$query = $this->db->get('category cat');

		if ($query->num_rows() > 0) {
			$category_array = $query->result_object();
			foreach ($category_array as $cat_details) {
				$cat_response = array();
				$cat_response['cat_id'] = $cat_details->cat_id;
				// 1 arabic 2 english
				if ($language == 1) {
					$cat_response['cat_name'] = $cat_details->cat_name_ar;
				} else {
					$cat_response['cat_name'] = $cat_details->cat_name;
				}


				$cat_response['parent_id'] = $cat_details->parent_id;
				$cat_response['cat_slug'] = $cat_details->cat_slug;

				$img_decode = json_decode($cat_details->cat_img);
				$img = '';

				if ($devicetype == 1) {
					if (isset($img_decode->{MOBILE})) {
						$img = $img_decode->{MOBILE};
					} else {
						$img = $cat_details->cat_img;
					}
				} else {
					if (isset($img_decode->{DESKTOP})) {
						$img = $img_decode->{DESKTOP};
					} else {
						$img = $cat_details->cat_img;
					}
				}

				$web_banner = '';
				if ($cat_details->web_banner) {
					$web_decode = json_decode($cat_details->web_banner);

					if ($devicetype == 1) {
						if (isset($web_decode->{MOBILE})) {
							$web_banner = $web_decode->{MOBILE};
						} else {
							$web_banner = $cat_details->web_banner;
						}
					} else {
						if (isset($web_decode->{DESKTOP})) {
							$web_banner = $web_decode->{DESKTOP};
						} else {
							$web_banner = $cat_details->web_banner;
						}
					}
				}

				$cat_response['imgurl'] = $img;
				$cat_response['web_banner'] = $web_banner;

				//get sub category 
				$this->db->select('cat.cat_id,cat.cat_name, cat.cat_name_ar,cat.cat_img,cat.parent_id,cat.cat_slug');

				$this->db->where(array('cat.status' => 1, 'cat.parent_id' => $cat_details->cat_id));
				$this->db->order_by('cat.cat_order', 'ASC');

				//$this->db->limit(8, 0);
				$querysubcat = $this->db->get('category cat');
				$cat_response['subcat_1'] = array();
				if ($querysubcat->num_rows() > 0) {
					$category_sub = $querysubcat->result_object();
					foreach ($category_sub as $subcat_details) {
						$scat_response = array();
						$scat_response['cat_id'] = $subcat_details->cat_id;
						// 1 arabic 2 english
						if ($language == 1) {
							$scat_response['cat_name'] = $subcat_details->cat_name_ar;
						} else {
							$scat_response['cat_name'] = $subcat_details->cat_name;
						}
						$scat_response['parent_id'] = $subcat_details->parent_id;
						$scat_response['cat_slug'] = $subcat_details->cat_slug;

						$img_decode = json_decode($subcat_details->cat_img);
						$img = '';

						if ($devicetype == 1) {
							if (isset($img_decode->{MOBILE})) {
								$img = $img_decode->{MOBILE};
							} else {
								$img = $subcat_details->cat_img;
							}
						} else {
							if (isset($img_decode->{DESKTOP})) {
								$img = $img_decode->{DESKTOP};
							} else {
								$img = $subcat_details->cat_img;
							}
						}
						$scat_response['imgurl'] = $img;

						//getsub sub category 
						$this->db->select('cat.cat_id,cat.cat_name, cat.cat_name_ar,cat.cat_img,cat.parent_id,cat.cat_slug');

						$this->db->where(array('cat.status' => 1, 'cat.parent_id' => $subcat_details->cat_id));
						$this->db->order_by('cat.cat_order', 'ASC');

						//$this->db->limit(8, 0);
						$querysubcat1 = $this->db->get('category cat');
						$scat_response['subsubcat_2'] = array();
						if ($querysubcat1->num_rows() > 0) {
							$category_sub1 = $querysubcat1->result_object();
							foreach ($category_sub1 as $subcat_details1) {
								$scat_response1 = array();
								$scat_response1['cat_id'] = $subcat_details1->cat_id;
								// 1 arabic 2 english
								if ($language == 1) {
									$scat_response1['cat_name'] = $subcat_details1->cat_name_ar;
								} else {
									$scat_response1['cat_name'] = $subcat_details1->cat_name;
								}

								$scat_response1['parent_id'] = $subcat_details1->parent_id;
								$scat_response1['cat_slug'] = $subcat_details1->cat_slug;

								$img_decode = json_decode($subcat_details1->cat_img);
								$img1 = '';

								if ($devicetype == 1) {
									if (isset($img_decode->{MOBILE})) {
										$img1 = $img_decode->{MOBILE};
									} else {
										$img1 = $subcat_details1->cat_img;
									}
								} else {
									if (isset($img_decode->{DESKTOP})) {
										$img1 = $img_decode->{DESKTOP};
									} else {
										$img1 = $subcat_details1->cat_img;
									}
								}
								$scat_response1['imgurl'] = $img1;

								$scat_response['subsubcat_2'][] = $scat_response1;
							}
						}
						$cat_response['subcat_1'][] = $scat_response;
					}
				}

				$category_result[] = $cat_response;
			}
		}

		return $category_result;
	}

	function get_product_review($prod_id, $pageno = '')
	{

		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select("pr.review_id,rating,pr.title as review_title,pr.comment as review_comment,pr.created_at as review_date, apl.fullname as user_name");
		$this->db->join('appuser_login apl', 'apl.user_unique_id = pr.user_id', 'INNER');
		$this->db->where(array('pr.product_id' => $prod_id, 'pr.status' => 1));
		$this->db->order_by('pr.created_at', 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_review = $this->db->get('product_review pr');

		if ($query_review->num_rows() > 0) {
			$prod_result = $query_review->result_object();

			$product_array = array();
			$rating_count = 0;
			$rating_star = 0;
			foreach ($prod_result as $product_details) {
				$rating_star += $product_details->rating;
				$rating_count++;
			}
			$product_array['total_rating'] = $rating_star / $rating_count;
			$product_array['rating_count'] = $rating_count;
		}
		return $product_array;
	}

	function get_vendor_coupon()
	{
		$coupon = array();
		$this->db->select("name,coupon_type,value,todate,coupandesc");
		$this->db->where(array('activate' => 'active'));


		$query = $this->db->get('coupancode_vendor');
		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			foreach ($category_result as $category_data) {
				$coupon_details = array();
				if ($category_data->coupon_type == 1) {
					$coupon_value = $category_data->value . '%';
				} else {
					$coupon_value = price_format($category_data->value);
				}


				$coupon_details['name'] = html_entity_decode($category_data->name);
				$coupon_details['coupandesc'] = html_entity_decode($category_data->coupandesc);
				$coupon_details['coupon_type'] = html_entity_decode($category_data->coupon_type);
				$coupon_details['coupon_value'] = html_entity_decode($coupon_value);
				$coupon_details['coupon_todate'] = html_entity_decode($category_data->todate);

				$coupon[] = $coupon_details;
			}
		}
		return $coupon;
	}


	function get_offers_product_request($language, $type)
	{
		$prod_result = array();
		$product_array = array();
		$start = 0;
		$sortby = 1;
		$devicetype = 1;

		if ($type != 'New') {

			$this->db->select('popular_product.product_id');
			$this->db->join('product_details', 'product_details.product_unique_id = popular_product.product_id', 'INNER');
			$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id', 'INNER');
			$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id', 'INNER');
			$this->db->where(array('product_details.status' => 1, 'vp.enable_status' => 1, 'seller.status' => 1, 'popular_product.type' => $type));
			//$this->db->group_by("popular_product.prod_id"); 
			$this->db->order_by("popular_product.id", 'ASC');

			$this->db->limit(15, $start);

			$query = $this->db->get('popular_product');
		} else {
			$this->db->select('product_unique_id as product_id');
			$this->db->where(array('status' => 1));
			$this->db->order_by("id", 'DESC');
			$this->db->limit(15, $start);
			$query = $this->db->get('product_details');
		}

		//print_r($this->db->last_query());    

		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$product_id = array();
			foreach ($category_result as $cat_product) {
				$product_id[] = $cat_product->product_id;
			}


			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN(' . $this->getValues($product_id) . ') AND vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1));
			$this->db->group_by("pd.product_unique_id");

			if ($type == 'New') {
				$this->db->order_by("pd.id", 'DESC');
			}

			/*if($sortby==1){
				$this->db->order_by("vp2.mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("vp2.mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}*/

			$query_prod = $this->db->get('product_details as pd');

			if ($query_prod->num_rows() > 0) {
				$prod_result = $query_prod->result_object();

				$product_array = array();
				foreach ($prod_result as $product_details) {
					$product_response = array();
					$product_response['id'] = $product_details->id;
					if ($language == 1) {
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

	//Functiofor for get category product
	function get_popular_product_request($language, $pageno, $sortby, $devicetype)
	{
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}
		$this->db->select('popular_product.product_id');
		$this->db->join('product_details', 'product_details.product_unique_id = popular_product.product_id', 'INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id', 'INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id', 'INNER');
		$this->db->where(array('product_details.status' => 1, 'vp.enable_status' => 1, 'seller.status' => 1));
		//$this->db->group_by("popular_product.prod_id"); 

		$this->db->limit(LIMIT, $start);

		$query = $this->db->get('popular_product');


		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$product_id = array();
			foreach ($category_result as $cat_product) {
				$product_id[] = $cat_product->product_id;
			}


			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN(' . $this->getValues($product_id) . ') AND vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1));
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

				$product_array = array();
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
	
	function get_newarrival_product_request($language, $pageno, $sortby, $devicetype)
	{
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}
		
		
		$this->db->select('product_unique_id as product_id');
			$this->db->where(array('status' => 1));
			$this->db->order_by("id", 'DESC');
			$this->db->limit(LIMIT, $start);
			$query = $this->db->get('product_details');


		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$product_id = array();
			foreach ($category_result as $cat_product) {
				$product_id[] = $cat_product->product_id;
			}


			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN(' . $this->getValues($product_id) . ') AND vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1));
			$this->db->group_by("pd.product_unique_id");
			
			$this->db->order_by("pd.id",'DESC');

			
			$query_prod = $this->db->get('product_details as pd');

			if ($query_prod->num_rows() > 0) {
				$prod_result = $query_prod->result_object();

				$product_array = array();
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
	
	function get_high_discount_product_request($language, $pageno, $sortby, $devicetype)
	{
		$prod_result = array();
		$product_array = array();
		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}
		
		$this->db->select('product_id,ROUND(product_sale_price/ product_mrp *100, 0) AS Percent');
		   $this->db->where(array('enable_status'=>1));
		   $this->db->order_by("id",'DESC');
		   $this->db->group_by("product_id"); 
		   $this->db->limit(LIMIT, $start);
		   $query = $this->db->get('vendor_product');
		

		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$product_id = array();
			foreach ($category_result as $cat_product) {
			   if($cat_product->Percent <= 50)
			   {
					$product_id[] = $cat_product->product_id;
			   }
			}


			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN(' . $this->getValues($product_id) . ') AND vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1));
			$this->db->group_by("pd.product_unique_id");
			
			$this->db->order_by("pd.id",'DESC');

			
			$query_prod = $this->db->get('product_details as pd');

			if ($query_prod->num_rows() > 0) {
				$prod_result = $query_prod->result_object();

				$product_array = array();
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

	function deliveryboy_list_request()
	{

		$city_result = array();



		$this->db->select('deliveryboy_unique_id,fullname,phone,email');

		$query = $this->db->get('deliveryboy_login');

		if ($query->num_rows() > 0) {

			$deliveryboy_array = $query->result_object();

			foreach ($deliveryboy_array as $deliveryboy_details) {

				$deliveryboy_response = array();

				$deliveryboy_response['deliveryboy_id'] = $deliveryboy_details->deliveryboy_unique_id;

				$deliveryboy_response['name'] = $deliveryboy_details->fullname;

				$deliveryboy_response['phone'] = $deliveryboy_details->phone;
				
				$deliveryboy_response['email'] = $deliveryboy_details->email;



				$city_result[] = $deliveryboy_response;
			}
		}



		return $city_result;
	}
	
	function city_list_request()
	{

		$city_result = array();



		$this->db->select('city_id,city_name,state_code');

		$query = $this->db->get('city');

		if ($query->num_rows() > 0) {

			$city_array = $query->result_object();

			foreach ($city_array as $city_details) {

				$city_response = array();

				$city_response['city_id'] = $city_details->city_id; 

				$city_response['city_name'] = $city_details->city_name;

				$city_response['state_code'] = $city_details->state_code;



				$city_result[] = $city_response;
			}
		}



		return $city_result;
	}
	
	
	function plan_list_request()
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
	
	function single_plan_list_request()
	{
		$plan_result = array();

		$this->db->select('plan_id, plan_name,plan_value');
		$this->db->order_by('plan_id', 'ASC');


		$query = $this->db->get('plans');
		$count = 1;
		if ($query->num_rows() > 0) {
			$delivery_array = $query->result_object();
			foreach ($delivery_array as $delivery_details) {
				if($count == 1)
				{
					$plan_response = array();
					$plan_response['plan_id'] = $delivery_details->plan_id;
					$plan_response['plan_name'] = $delivery_details->plan_name;
					$plan_response['plan_value'] = $delivery_details->plan_value;

					$plan_result[] = $plan_response;
				}
				$count++;
			}
		}

		return $plan_result;
	}

	function state_list_request()
	{

		$city_result = array();



		$this->db->select('stateid,name,countryid');

		$query = $this->db->get('state');

		if ($query->num_rows() > 0) {

			$city_array = $query->result_object();

			foreach ($city_array as $city_details) {

				$city_response = array();

				$city_response['stateid'] = $city_details->stateid;

				$city_response['name'] = $city_details->name;

				$city_response['countryid'] = $city_details->countryid;



				$city_result[] = $city_response;
			}
		}



		return $city_result;
	}
	
	
	function hsn_code_list_request()
	{

		$hsn_result = array();



		$this->db->select('id,hsn_code,status');
		$this->db->where(array('status' => 1));
		$query = $this->db->get('product_hsn_code');

		if ($query->num_rows() > 0) {

			$hsn_array = $query->result_object();

			foreach ($hsn_array as $hsn_details) {

				$hsn_response = array();

				$hsn_response['id'] = $hsn_details->id;

				$hsn_response['hsn_code'] = $hsn_details->hsn_code;

				$hsn_response['status'] = $hsn_details->status;



				$hsn_result[] = $hsn_response;
			}
		}



		return $hsn_result;
	}
	
	function return_policy_list_request()
	{

		$hsn_result = array();



		$this->db->select('id,title,status');
		$this->db->where(array('status' => 1));
		$query = $this->db->get('product_return_policy');

		if ($query->num_rows() > 0) {

			$hsn_array = $query->result_object();

			foreach ($hsn_array as $hsn_details) {

				$hsn_response = array();

				$hsn_response['id'] = $hsn_details->id;

				$hsn_response['title'] = $hsn_details->title;

				$hsn_response['status'] = $hsn_details->status;



				$hsn_result[] = $hsn_response;
			}
		}



		return $hsn_result;
	}
	
	function tax_list_request()
	{

		$hsn_result = array();



		$this->db->select('tax_id, name,status');
		$this->db->where(array('status' => 1));
		$query = $this->db->get('tax');

		if ($query->num_rows() > 0) {

			$hsn_array = $query->result_object();

			foreach ($hsn_array as $hsn_details) {

				$hsn_response = array();

				$hsn_response['tax_id'] = $hsn_details->tax_id;

				$hsn_response['name'] = $hsn_details->name;

				$hsn_response['status'] = $hsn_details->status;



				$hsn_result[] = $hsn_response;
			}
		}



		return $hsn_result;
	}


	function home_top_category_request()
	{

		$prod_result = array();

		$product_array = array();

		$start = 0;

		$sortby = 1;

		$devicetype = 1;


		$this->db->select('*');


		$this->db->where('cat_id != ', '10');
		$this->db->where_in('parent_id', '0');

		$this->db->limit(20, $start);
		$this->db->order_by('cat_order', 'ASC');


		$query_prod = $this->db->get('category');



		if ($query_prod->num_rows() > 0) {

			$prod_result = $query_prod->result_object();



			$product_array = array();

			foreach ($prod_result as $productdetails) {

				$product_response = array();

				$product_response['id'] = $productdetails->cat_id;

				$product_response['name'] = $productdetails->cat_name;

				$img_decode = json_decode($productdetails->cat_img);

				if ($devicetype == 1) {
					if (isset($img_decode->{MOBILE})) {
						$img = $img_decode->{MOBILE};
					} else {
						$img = $productdetails->cat_img;
					}
				} else {
					if (isset($img_decode->{DESKTOP})) {
						$img = $img_decode->{DESKTOP};
					} else {
						$img = $productdetails->cat_img;
					}
				}





				$product_response['imgurl'] = $img;

				$product_array[] = $product_response;
			}
		}





		return $product_array;
	}
	
	
	function delete_product($prod_id)
	{
		
		
		$this->db->where(array('product_unique_id' => $prod_id));
		$query_prod = $this->db->delete('product_details');
				
			
		$this->db->where(array('prod_id' => $prod_id));
		$query_cat = $this->db->delete('product_category');
				
		$this->db->where(array('prod_id' => $prod_id));
		$query_meta = $this->db->delete('product_meta');
		
		$this->db->where(array('product_id' => $prod_id));
		$query_attr_val = $this->db->delete('product_attribute_value');
		
		
		$this->db->where(array('product_id' => $prod_id));
		$query_vendor_val = $this->db->delete('vendor_product');
		
		$this->db->where(array('prod_id' => $prod_id));
		$query_prod_attr = $this->db->delete('product_attribute');
		
		$this->db->where(array('banner_id' => $prod_id,'clicktype' => '2'));
		$query_banner = $this->db->delete('home_custom_banner');
		
		$this->db->where(array('product_id' => $prod_id));
		$query_pop_prod = $this->db->delete('popular_product');
		
		$this->db->where(array('product_id' => $prod_id));
		$query_prod_rew = $this->db->delete('product_review');
		
		
		

		if ($query_prod) {
			return 'delete';
		}
	}
	
	function seller_active_check($user_id,$seller_id = '')
	{
		
		$seller_result = array();
		
			$this->db->select('*');

			$this->db->where(array('user_id' => $user_id));
			$query = $this->db->get('sellerlogin');

			 
			if ($query->num_rows() > 0) {
				$home_result = $query->result_object();
				foreach ($home_result as $seller) {
					$seller_result['status'] = $seller->status;
					$seller_result['no_of_products'] = $seller->no_of_products;
					$seller_result['isseller'] = 1;
				}
			}
			else
			{
				$seller_result['status'] = 0;
				$seller_result['no_of_products'] = 0;
				$seller_result['isseller'] = 0;
			}
		
		return $seller_result;
	}
	
	function seller_dashboard($seller_id)
	{
		
		$seller_result = array();
		
			$this->db->select('user_id');
			$this->db->where(array('seller_unique_id' => $seller_id));
			$query_user = $this->db->get('sellerlogin');

			
			if ($query_user->num_rows() > 0) {
				$user_result = $query_user->result_object();
				foreach ($user_result as $users) {
					$seller_user_id = $users->user_id;
				}
			}
			
			$this->db->select('amount');
			$this->db->where(array('user_id' => $seller_user_id));
			$query_wallet = $this->db->get('wallet_summery');

			
			if ($query_wallet->num_rows() > 0) {
				$wallet_result = $query_wallet->result_object();
				foreach ($wallet_result as $users_wallet) {
					$wallet_amount = $users_wallet->amount;
					$seller_result['wallet'] = round($wallet_amount,0);
				}
			}
			
			$this->db->select('SUM(prod_price*qty) as revenue');
			$this->db->where(array('status' => 'Delivered','vendor_id' => $seller_id));
			$query_revenue = $this->db->get('order_product');


			if ($query_revenue->num_rows() > 0) {
				$revenue_result = $query_revenue->result_object();
				foreach ($revenue_result as $seller_revenue) {
					$revenue_amount = $seller_revenue->revenue;
					$seller_result['revenue'] = round($revenue_amount,0);
				}
			}
			
			$this->db->select('id');
			$this->db->where(array('vendor_id' => $seller_id));
			$query_total_order = $this->db->get('order_product');


			$total_order = $query_total_order->num_rows();
			$seller_result['total_order'] = round($total_order,0);
			
			$this->db->select('id');
			$this->db->where(array('status' => 'Placed','vendor_id' => $seller_id));
			$query_pending_order = $this->db->get('order_product');


			$pending_order = $query_pending_order->num_rows();
			$seller_result['pending_order'] = round($pending_order,0);
			
			
			$this->db->select('id');
			$this->db->where(array('status' => 'Cancelled','vendor_id' => $seller_id));
			$query_cancell_order = $this->db->get('order_product');


			$cancell_order = $query_cancell_order->num_rows();
			$seller_result['cancell_order'] = round($cancell_order,0);
			
			$this->db->select('id');
			$this->db->where(array('status' => 'Delivered','vendor_id' => $seller_id));
			$query_delivered_order = $this->db->get('order_product');


			$delivered_order = $query_delivered_order->num_rows();
			$seller_result['delivered_order'] = round($delivered_order,0);
			
			$this->db->select('pd.product_unique_id');
			$this->db->join('vendor_product vp', 'pd.product_unique_id = vp.product_id', 'INNER');
			$this->db->where(array('vp.vendor_id' => $seller_id));
			$this->db->where_in('vp.enable_status', array('1','3'));
			$query_product = $this->db->get('product_details pd');


			$total_product = $query_product->num_rows();
			$seller_result['total_product'] = round($total_product,0);
			
			$this->db->select('SUM(prod_price*qty) as sale');
			$this->db->where(array('DATE(create_date)' => date('Y-m-d'),'vendor_id' => $seller_id));
			$query_sale = $this->db->get('order_product');


			if ($query_sale->num_rows() > 0) {
				$sale_result = $query_sale->result_object();
				foreach ($sale_result as $seller_sell) {
					$sale_amount = $seller_sell->sale;
					$seller_result['today_sale'] = round($sale_amount,0);
				}
			}
			
			$this->db->select('SUM(prod_price*qty) as month_sale');
			$this->db->where(array('Month(create_date)' => date('m'),'YEAR(create_date)' => date('Y'),'vendor_id' => $seller_id));
			$query_month_sale = $this->db->get('order_product');


			if ($query_month_sale->num_rows() > 0) {
				$month_sale_result = $query_month_sale->result_object();
				foreach ($month_sale_result as $seller_month_sell) {
					$month_sale_amount = $seller_month_sell->month_sale;
					$seller_result['monthly_sale'] = round($month_sale_amount,0);
				}
			}
			
			

		return $seller_result;
	}
	

	function order_status_data($order_id,$product_id)
	{
		$this->db->select('*');

		$this->db->where(array('order_id' => $order_id,'product_id' => $product_id));
		$query = $this->db->get('order_tracking_status');

		$banner_result = array();
		if ($query->num_rows() > 0) {
			$home_result = $query->result_object();
			foreach ($home_result as $order_tracking_status) {
				
				$cat_response = array();
				$cat_response['status'] = $order_tracking_status->status;
				$cat_response['message'] = $order_tracking_status->message;
				$cat_response['date'] = date('d-m-Y H:i:s A',strtotime($order_tracking_status->created_at));
				$banner_result[] = $cat_response;
				
			}
		}

		return $banner_result;
	}
	
	function get_header_banner_request($section, $dimension)
	{
		$this->db->select('*');

		$this->db->where(array('section' => $section));
		$query = $this->db->get('homepage_banner');

		$banner_result = array();
		if ($query->num_rows() > 0) {
			$home_result = $query->result_object();
			foreach ($home_result as $banners) {
				$img_decode1 = json_decode($banners->image);
				$banners->image = MEDIA_URL . $img_decode1->{$dimension};
				$banner_result[] = $banners;
			}
		}

		return $banner_result;
	}


	function get_home_products($language, $type)
	{
		$prod_result = array();
		$product_array = array();
		$start = 0;
		$sortby = 1;
		$devicetype = 1;

		if ($type != 'New0') {

			$this->db->select('popular_product.product_id');
			$this->db->join('product_details', 'product_details.product_unique_id = popular_product.product_id', 'INNER');
			$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id', 'INNER');
			$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id', 'INNER');
			$this->db->where(array('product_details.status' => 1, 'vp.enable_status' => 1, 'seller.status' => 1, 'popular_product.type' => $type));
			$this->db->order_by("popular_product.id", 'ASC');

			$this->db->limit(15, $start);

			$query = $this->db->get('popular_product');
		} else {
			$this->db->select('product_unique_id as product_id');
			$this->db->where(array('status' => 1));
			$this->db->order_by("id", 'DESC');
			$this->db->limit(15, $start);
			$query = $this->db->get('product_details');
		}


		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$product_id = array();
			foreach ($category_result as $cat_product) {
				$product_id[] = $cat_product->product_id;
			}


			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');


			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN(' . $this->getValues($product_id) . ') AND vp.enable_status=1 group by vp.product_id  ) as vp2', 'pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min', 'INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id', 'INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1, 'vp1.enable_status' => 1, 'seller.status' => 1));
			$this->db->group_by("pd.product_unique_id");

			if ($type == 'New') {
				$this->db->order_by("pd.id", 'DESC');
			}

			/*if($sortby==1){
				$this->db->order_by("vp2.mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("vp2.mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}*/

			$query_prod = $this->db->get('product_details as pd');

			if ($query_prod->num_rows() > 0) {
				$prod_result = $query_prod->result_object();

				$product_array = array();
				foreach ($prod_result as $product_details) {
					$product_response = array();
					$product_response['id'] = $product_details->id;
					if ($language == 1) {
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
					
					$product_review_array1 = $this->get_product_review_count($product_details->id);

					if(!empty($product_review_array1))
					{
						$product_response['rating'] = $product_review_array1['total_rating'];
						$product_response['product_total_rating'] = $product_review_array1['total_rating'];
						$product_response['product_rating_count'] = $product_review_array1['rating_count'];
					}
					else
					{
						$product_response['product_total_rating'] = '0';
						$product_response['product_rating_count'] = '0';
					}

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

					$product_response['imgurl'] = MEDIA_URL . $img;
					$product_array[] = $product_response;
				}
			}
		}

		return $product_array;
	}


	function get_product_review_count($prod_id, $pageno = '')
	{

		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select("pr.review_id,rating,pr.title as review_title,pr.comment as review_comment,pr.created_at as review_date, apl.fullname as user_name");
		$this->db->join('appuser_login apl', 'apl.user_unique_id = pr.user_id', 'INNER');
		$this->db->where(array('pr.product_id' => $prod_id, 'pr.status' => 1));
		$this->db->order_by('pr.created_at', 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_review = $this->db->get('product_review pr');

		if ($query_review->num_rows() > 0) {
			$prod_result = $query_review->result_object();

			$product_array = array();
			$rating_count = 0;
			$rating_star = 0;
			foreach ($prod_result as $product_details) {
				$rating_star += $product_details->rating;
				$rating_count++;
			}
			$product_array['total_rating'] = $rating_star / $rating_count;
			$product_array['rating_count'] = $rating_count;
		}
		return $product_array;
	}


	function get_storesetting_request($devicetype)
	{
		$category_result = array();
		$this->db->select('settings_id,type,description');
		$query = $this->db->get('settings');
		if ($query->num_rows() > 0) {
			$category_array = $query->result_object();
			$name = '';
			$phone = '';
			$whatsapp = '';
			$email_1 = '';
			$email_2 = '';
			$aboutus = '';
			$promote_refer_code = '';
			foreach ($category_array as $cat_details) {
				if ($cat_details->type == 'system_name') {
					$name = $cat_details->description;
				} else if ($cat_details->type == 'system_phone') {
					$phone = $cat_details->description;
				} else if ($cat_details->type == 'system_email') {
					$email_1 = $cat_details->description;
				} else if ($cat_details->type == 'system_other_email') {
					$email_2 = $cat_details->description;
				} else if ($cat_details->type == 'system_other_phone') {
					$whatsapp = $cat_details->description;
				} else if ($cat_details->type == 'aboutus') {
					$aboutus = strip_tags(html_entity_decode($cat_details->description));
				} else if ($cat_details->type == 'promote_refer_code') {
					$promote_refer_code = strip_tags(html_entity_decode($cat_details->description));
				}
			}
			$data[] = array('name' => $name, 'phone' => $phone, 'email_1' => $email_1, 'email_2' => $email_2, 'whatsapp' => $whatsapp, 'aboutus' => $aboutus, 'promote_refer_code' => $promote_refer_code);
		}
		return $data;
	}


	//Functiofor for get category product
	function get_search_product_request($langauge, $search, $devicetype)
	{
		$prod_result = array();
		$product_array = array();
		$start = 0;

		$pid = '';


		$keywords = $this->filterSearchKeys($search);
		$product_like = '';
		$product_meta_like = '';
		$s = 0;
		foreach ($keywords as $keys) {

			if ($s == 0) {
				$product_like .= " (prod_name like '%" . $keys . "%'  OR prod_name_ar like '%" . $keys . "%' OR prod_desc_ar like '%" . $keys . "%'  OR prod_fulldetail_ar like '%" . $keys . "%' OR pm.meta_title like '%" . $keys . "%' OR pm.meta_key like '%" . $keys . "%'  OR pm.meta_value like '%" . $keys . "%' )";
				//$product_meta_like .= " (pm.meta_title like '%".$keys."%' OR pm.meta_key like '%".$keys."%'  OR pm.meta_value like '%".$keys."%' )";
			} else {
				$product_like .= " AND (prod_name like '%" . $keys . "%' OR prod_name_ar like '%" . $keys . "%' OR prod_desc_ar like '%" . $keys . "%'  OR prod_fulldetail_ar like '%" . $keys . "%'  OR pm.meta_title like '%" . $keys . "%' OR pm.meta_key like '%" . $keys . "%'  OR pm.meta_value like '%" . $keys . "%' )";
				//$product_meta_like .= " OR (pm.meta_title like '%".$keys."%' OR pm.meta_key like '%".$keys."%'  OR pm.meta_value like '%".$keys."%' )";
			}
			$s++;
		}
		//echo $product_like;			  
		//get products details
		/*$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('vendor_product vp1', 'vp1.product_id = pd.product_unique_id','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			//$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
			
			//$this->db->like($product_like);
			
			$this->db->group_by("pd.product_unique_id"); 
			
		
			
			$this->db->limit(LIMIT,$start);*/









		$sql = "SELECT `pd`.`product_unique_id` as `id`, `pd`.`prod_name` as `name`, `pd`.`prod_name_ar` as `name_ar`, `pd`.`web_url` as `web_url`, `pd`.`product_sku` as `sku`, `pd`.`featured_img` as `img`,  `vp1`.`vendor_id`, `vp1`.`product_mrp` as `mrp`, `vp1`.`product_sale_price` `price`, `vp1`.`product_stock` as `stock`, `vp1`.`product_remark` as `remark`, 'active' as active
					FROM `product_details` as `pd`
					INNER JOIN `vendor_product` `vp1` ON `vp1`.`product_id` = `pd`.`product_unique_id`
					INNER JOIN `sellerlogin` `seller` ON `vp1`.`vendor_id` = `seller`.`seller_unique_id`
					LEFT JOIN  product_meta pm ON pm.prod_id = `pd`.`product_unique_id`
					LEFT JOIN  brand brand ON brand.brand_id = `pd`.`brand_id`
					WHERE `pd`.`status` = 1
					AND `vp1`.`enable_status` = 1
					AND `seller`.`status` = 1
					AND `brand`.`status` = 1
					AND  (" . $product_like . " OR brand.brand_name like '%" . $search . "%')
					GROUP BY `pd`.`product_unique_id`
					LIMIT 10";



		$query_prod = $this->db->query($sql);

		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();


			foreach ($prod_result as $product_details) {
				$product_response = array();
				$product_response['id'] = $product_details->id;
				if ($langauge == "1") {
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
				$product_response['sponsor'] = 0;

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


		return $product_array;
	}

	function getnotification_request($devicetype)
	{
		$category_result = array();
		$this->db->select('id,noti_title,noti_body,pid,sid,sku,cid,search,home,clicktype,noti_img,created_at');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('firebase_notification');
		if ($query->num_rows() > 0) {
			$category_array = $query->result_object();
			foreach ($category_array as $cat_details) {
				$cat_response = array();
				$cat_response['id'] = $cat_details->id;
				$cat_response['title'] = $cat_details->noti_title;
				$cat_response['noti_body'] = $cat_details->noti_body;
				$cat_response['pid'] = $cat_details->pid;
				$cat_response['sid'] = $cat_details->sid;
				$cat_response['sku'] = $cat_details->sku;
				$cat_response['cat_id'] = $cat_details->cid;
				$cat_response['search'] = $cat_details->search;
				$cat_response['home'] = $cat_details->home;
				$cat_response['clicktype'] = $cat_details->clicktype;
				$cat_response['date'] = $cat_details->created_at;



				if ($cat_details->cid != 0) {
					$this->db->select('*');
					$this->db->where(array('cat_id' => $cat_details->cid));
					$query_cat = $this->db->get('category');

					if ($query_cat->num_rows() > 0) {
						$cat_result = $query_cat->result_object();
						foreach ($cat_result as $cat_result_data) {
							$cat_response['cat_slug'] = $cat_result_data->cat_slug;
						}
					}
				} else {
					$cat_response['cat_slug'] = '';
				}

				$img_decode = json_decode($cat_details->noti_img);

				if ($devicetype == 1) {
					if (isset($img_decode->{MOBILE})) {
						$img = $img_decode->{MOBILE};
					} else {
						$img = $cat_details->noti_img;
					}
				} else {
					if (isset($img_decode->{DESKTOP})) {
						$img = $img_decode->{DESKTOP};
					} else {
						$img = $cat_details->noti_img;
					}
				}

				$cat_response['imgurl'] = $img;


				$category_result[] = $cat_response;
			}
		}
		return $category_result;
	}

	function getnotification_newpost_request($devicetype)
	{
		$category_result = array();
		$this->db->select('id,title,subtitle,image,date');
		$this->db->where('date BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('notification');
		if ($query->num_rows() > 0) {
			$category_array = $query->result_object();
			foreach ($category_array as $cat_details) {
				$cat_response = array();
				$cat_response['id'] = $cat_details->id;
				$cat_response['title'] = $cat_details->title;
				$cat_response['subtitle'] = $cat_details->subtitle;
				$cat_response['image'] = $cat_details->image;
				$cat_response['date'] = $cat_details->date;
				$category_result[] = $cat_response;
			}
		}
		return $category_result;
	}

	function get_search_sponsor_product_request($langauge, $search, $devicetype)
	{
		$prod_result = array();
		$product_array = array();
		$start = 0;


		$this->db->select('product_id');

		$s_query = $this->db->get('sponsor_product');

		$pid = '';

		if ($s_query->num_rows() > 0) {
			$s_category_array = $s_query->result_object();
			foreach ($s_category_array as $s_cat_details) {

				$pid = $pid . '"' . $s_cat_details->product_id . '",';
			}
		}

		$pid = rtrim($pid, ',');

		$keywords = $this->filterSearchKeys($search);
		$product_like = '';
		$product_meta_like = '';
		$s = 0;
		foreach ($keywords as $keys) {

			if ($s == 0) {
				$product_like .= " (prod_name like '%" . $keys . "%'  OR prod_name_ar like '%" . $keys . "%' OR prod_desc_ar like '%" . $keys . "%'  OR prod_fulldetail_ar like '%" . $keys . "%' OR pm.meta_title like '%" . $keys . "%' OR pm.meta_key like '%" . $keys . "%'  OR pm.meta_value like '%" . $keys . "%' )";
			} else {
				$product_like .= " AND (prod_name like '%" . $keys . "%' OR prod_name_ar like '%" . $keys . "%' OR prod_desc_ar like '%" . $keys . "%'  OR prod_fulldetail_ar like '%" . $keys . "%'  OR pm.meta_title like '%" . $keys . "%' OR pm.meta_key like '%" . $keys . "%'  OR pm.meta_value like '%" . $keys . "%' )";
			}
			$s++;
		}
		/*$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('vendor_product vp1', 'vp1.product_id = pd.product_unique_id','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			//$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
			
			//$this->db->like($product_like);
			
			$this->db->group_by("pd.product_unique_id"); 
			
		
			
			$this->db->limit(LIMIT,$start);*/

		$sql = "SELECT `pd`.`product_unique_id` as `id`, `pd`.`prod_name` as `name`, `pd`.`prod_name_ar` as `name_ar`, `pd`.`web_url` as `web_url`, `pd`.`product_sku` as `sku`, `pd`.`featured_img` as `img`,  `vp1`.`vendor_id`, `vp1`.`product_mrp` as `mrp`, `vp1`.`product_sale_price` `price`, `vp1`.`product_stock` as `stock`, `vp1`.`product_remark` as `remark`, 'active' as active
					FROM `product_details` as `pd`
					INNER JOIN `vendor_product` `vp1` ON `vp1`.`product_id` = `pd`.`product_unique_id`
					INNER JOIN `sellerlogin` `seller` ON `vp1`.`vendor_id` = `seller`.`seller_unique_id`
					LEFT JOIN  product_meta pm ON pm.prod_id = `pd`.`product_unique_id`
					LEFT JOIN  brand brand ON brand.brand_id = `pd`.`brand_id`
					WHERE `pd`.`status` = 1
					and vp1.product_id IN(" . $pid . ")
					AND `vp1`.`enable_status` = 1
					AND `seller`.`status` = 1
					AND `brand`.`status` = 1
					AND  (" . $product_like . " OR brand.brand_name like '%" . $search . "%')
					GROUP BY `pd`.`product_unique_id`
					LIMIT 100";



		$query_prod = $this->db->query($sql);

		if ($query_prod->num_rows() > 0) {
			$prod_result = $query_prod->result_object();


			foreach ($prod_result as $product_details) {
				$product_response = array();
				$product_response['id'] = $product_details->id;
				if ($langauge == "1") {
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


	// Remove unnecessary words from the search term and return them as an array
	function filterSearchKeys($query)
	{
		$query = trim(preg_replace("/(\s+)+/", " ", $query));
		$words = array();
		// expand this list with your words.
		// $list = array("or","I","you","they","to","but","that","this","those","then");
		$c = 0;
		foreach (explode(" ", $query) as $key) {
			//   if (in_array($key, $list)){
			//     continue;
			//}
			$words[] = trim($key);
			if ($c >= 15) {
				break;
			}
			$c++;
		}
		return $words;
	}

	public function tree_view($user_id)
	{
		$result = array();

		$query = $this->db->query("SELECT * FROM appuser_login WHERE user_unique_id = ?", array($user_id));

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {

				$row_result = array(
					'user_unique_id' => $row['user_unique_id'],
					//'create_by' => $row['create_by'],
					'fullname' => $row['fullname'] .' ('.date('d-m-Y',strtotime($row['create_by'])).')',
					'children' => array(),
				);

				$query1 = $this->db->query("SELECT user_unique_id FROM appuser_login WHERE level_1 = ?", array($row['user_unique_id']));

				if ($query1->num_rows() > 0) {
					$row_result['children'] = $this->categoryTree2($row['user_unique_id']);
				}

				$result[] = $row_result;
			}
		}
		// print_r($result);exit;
		return $result;
	}

	private function categoryTree2($level_1)
	{
		$result = array();

		$query = $this->db->query("SELECT * FROM appuser_login WHERE level_1 = ?", array($level_1));

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$row_result = array(
					'user_unique_id' => $row['user_unique_id'],
					//'create_by' => $row['create_by'],
					'fullname' => $row['fullname'] .' ('.date('d-m-Y',strtotime($row['create_by'])).')',
					'children' => $this->categoryTree2($row['user_unique_id']),
				);

				$result[] = $row_result;
			}
		}

		return $result;
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



	function get_daily_price_data()
	{
	    // Select all columns
	    $this->db->select('*');

	    // Set the table
	    $this->db->from('prize_money_contests');

	    // Order by 'id' descending
	    $this->db->order_by('id', 'DESC');

	    // Execute the query
	    $query = $this->db->get();

	    $prize_money_contests = $query->result_array();
$final_data=[];
foreach ($prize_money_contests as $contest) {

	$get_daily_price_view=$this->get_daily_price_view($contest['id']);

	$contest['reward_type_detail'] = $get_daily_price_view['reward_type_detail'];
$final_data[]=$contest;
}
	    // Return result as array
	    return $final_data;
	}


	function get_daily_price_view($id)
	{
	    // Select all columns
	    $this->db->select('*');

	    // Set the table
	    $this->db->from('prize_money_contests');

	    // Add where condition for the ID
	    $this->db->where('id', $id);

	    // Execute the query
	    $query = $this->db->get();
	    $reward_type_detail='';
	    if($query->result_array()[0]['reward_type']== 1){
	    	$reward_type_detail=$this->reward_type_one($query->result_array()[0]['schedule_date']);
	    }elseif(($query->result_array()[0]['reward_type']== 2) || ($query->result_array()[0]['reward_type']== 3)){
	    	$reward_type_detail=$this->reward_type_two_three($query->result_array()[0]['schedule_date']);
	    }elseif($query->result_array()[0]['reward_type']== 4){
	    	$reward_type_detail=$this->reward_type_four($id);
	    }
	    //echo '<pre>';print_r($reward_type_detail);die;
	    $array=[
	    	'prize_money_contests'=>$query->result_array(),
	    	'reward_type_detail'=>$reward_type_detail
	    ];
	    // Return single row as array
	    return $array; // fetch one row only
	}

	function reward_type_four($daily_prize_id)
	{
		$this->db->where('plan_value >', 1);
	$this->db->order_by('plan_value', 'DESC');
	$query = $this->db->get('sellerlogin');
	$data = $query->result_array();

	foreach ($data as &$user_data) {
	    $this->db->from('prize_money_contests_winner');
	    $this->db->where('sellers_id', $user_data['seller_unique_id']);
	    $this->db->where('prize_money_contests_id', $daily_prize_id);
	    
	    // Get only one row
	    $user_data['is_winner'] = $this->db->get()->row_array();
	    
	    // Optional: if you just want a boolean flag
	     $user_data['is_winner'] = $user_data['is_winner'] ? 1 : 0;

	    $this->db->from('prize_money_contests_winner');
		$this->db->where('sellers_id', $user_data['seller_unique_id']);
		$user_data['winner_count'] = $this->db->count_all_results();
	}
	return $data;
	}

	function reward_type_two_three($daily_prize_date)
	{
		$data = [];
		 $this->db->select('o.user_id, u.fullname, COUNT(o.sno) AS order_count, SUM(o.total_price) AS total_amount');
	    $this->db->from('orders AS o');
	    $this->db->join('appuser_login AS u', 'o.user_id = u.user_unique_id', 'inner');
	    $this->db->where('DATE(o.create_date)', $daily_prize_date);
	    $this->db->group_by(['o.user_id', 'u.fullname']);
	    $this->db->order_by('total_amount', 'DESC');
	    $query = $this->db->get();
	    $data = $query->result_array();

	    // ✅ Fetch individual orders for each user
	    foreach ($data as &$user_data) {
	        $this->db->select('order_id, total_price, create_date');
	        $this->db->from('orders');
	        $this->db->where('user_id', $user_data['user_id']);
	        $this->db->where('DATE(create_date)', $daily_prize_date);
	        $user_data['orders'] = $this->db->get()->result_array();
	    }

	  // $data['daily_prize_date'] = $daily_prize_date;
     // $data['daily_prize_winners'] = 5; // example limit
      return $data;

	}



	function reward_type_one($daily_prize_date)
	{
	    $this->db->select('
	        w.wallet_id,
	        s.user_id,
	        SUM(w.amount) AS total_amount,
	        u.fullname,
	        u.referral_code,
	        COUNT(CASE WHEN w.payment_type = 1 THEN 1 END) AS referral_count
	    ', false); // false to prevent escaping, so SQL functions work

	    $this->db->from('wallet_transaction_history AS w');
	    $this->db->join('wallet_summery AS s', 'w.wallet_id = s.wallet_id');
	    $this->db->join('appuser_login AS u', 's.user_id = u.user_unique_id');

	    $this->db->where('DATE(w.created_at)', $daily_prize_date);
	    $this->db->where('w.payment_type', 1);

	    $this->db->group_by('s.user_id, w.wallet_id');
	    $this->db->order_by('total_amount', 'DESC');

	    $query = $this->db->get();

	    return $query->result_array(); // return all rows as array
	}
	
}
