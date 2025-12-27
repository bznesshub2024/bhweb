<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		$this->date_time = date('Y-m-d H:i:s');
    }

    //Functiofor validate user
    function validate_user($user_phone = '',$qouteid,$user_name,$refer_code = ''){
       $user_result = array();
	   
		$this->db->select('*');
		$this->db->where(array('phone' => $user_phone));
		$query = $this->db->get('appuser_login');
		
		if($query->num_rows() >0){
			$user_result['status'] = 'exist';
		   return $user_result;
		   die();
		}else {
			$user_unique_id = 'U'.$this->random_strings(10);
			$referral_code = 'R'.$this->random_strings(8);
			
			
			
			$this->db->select('*');
			if($refer_code != '')
			{
				$this->db->where(array('referral_code' => $refer_code));
			}
			else if(get_settings('promote_refer_code') != '')
			{
				$this->db->where(array('referral_code' => get_settings('promote_refer_code')));
			}
			else /* store config */
			{
				$this->db->where(array('user_unique_id' => admin_user_id));
			}
			$query_qet = $this->db->get('appuser_login');
			
			$get_user_data = $query_qet->result_object()[0];
			
			$level_1 = $get_user_data->user_unique_id;
			$level_2 = $get_user_data->level_1;
			$level_3 = $get_user_data->level_2;
			
			if($get_user_data->user_unique_id != '')
			{
				$refer_code = $get_user_data->referral_code;
			}
			
			$data['phone'] = $user_phone;
			$data['status'] = 1;
			$data['user_unique_id'] = $user_unique_id;
			$data['fullname'] = $user_name;
			$data['referral_code'] = $referral_code;
			$data['referral_link'] = $refer_code;
			$data['password'] = '';
			$data['create_by'] = $this->date_time;
			
			$data['level_1'] = $level_1;
			$data['level_2'] = $level_2;
			$data['level_3'] = $level_3;
			
			
			
			$this->db->insert('appuser_login',$data);
			
			$this->db->select('*');
			$this->db->where(array('phone' => $user_phone));
			$query1 = $this->db->get('appuser_login');
			
			$user_result1 = $query1->result_object()[0];
			
			$img_decode = json_decode($user_result1->profile_pic);
			
			
			$wallet_id = 'w_'.$this->random_strings(8);
			
			$data_wallet['user_id'] = $user_result1->user_unique_id;
			$data_wallet['wallet_id'] = $wallet_id;
			$data_wallet['amount'] = 0;
			$data_wallet['created_at'] = $this->date_time;
			$this->db->insert('wallet_summery',$data_wallet);
			
			if($refer_code != '' || get_settings('promote_refer_code') != '')
			{ 
		
				$refer_user_id = $get_user_data->user_unique_id;
				
				$this->db->select('*');
				$this->db->where(array('user_unique_id' => $user_result1->user_unique_id));
				$name_query = $this->db->get('appuser_login');
				
				$name_result1 = $name_query->result_object()[0];
					
				$fullname = $name_result1->fullname;
				
				$this->db->select('*');
				$this->db->where(array('user_id' => $refer_user_id));
				$query_wallet = $this->db->get('wallet_summery');
				
				$get_wallet = $query_wallet->result_object()[0];
				
				$old_amount = $get_wallet->amount;
				$walet_history_upd['amount'] = $old_amount + signup_reward;
			
				$this->db->where(array('user_id'=>$refer_user_id));
				$this->db->update('wallet_summery', $walet_history_upd);
				
				
				
				$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');
				
				$this->db->select('*');
				$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
				$this->db->order_by('id','DESC');
				$this->db->limit(1,0);
				$query_wallet_his = $this->db->get('wallet_transaction_history');
				
				$old_balance = 0;
				if($query_wallet_his->num_rows() >0){
					$get_wallet = $query_wallet_his->result_object()[0];
				
					$old_balance = $get_wallet->balance;
				}	
				
				$data_wallet_history['wallet_id'] = $get_wallet->wallet_id;
				$data_wallet_history['payment_type'] = 1;
				$data_wallet_history['transaction_id'] = $transaction_id;
				$data_wallet_history['transaction_type'] = 'credit';
				$data_wallet_history['amount'] = signup_reward;
				$data_wallet_history['balance'] = $old_balance + signup_reward;
				$data_wallet_history['product_id'] = '';
				$data_wallet_history['order_id'] = '';
				$data_wallet_history['user_id'] = $user_result1->user_unique_id;
				$data_wallet_history['remark'] = 'New User Signup Bonus From '.$fullname;
				$data_wallet_history['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history',$data_wallet_history);
				
				
			}
			else
			{
				
				$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');
				
				$this->db->select('*');
				$this->db->where(array('wallet_id' => admin_wallet_id));
				$this->db->order_by('id','DESC');
				$this->db->limit(1,0);
				$query_wallet_his = $this->db->get('wallet_transaction_history');
				
				$old_balance = 0;
				if($query_wallet_his->num_rows() >0){
					$get_wallet = $query_wallet_his->result_object()[0];
				
					$old_balance = $get_wallet->balance;
				}				
				
				$this->db->select('*');
				$this->db->where(array('user_unique_id' => $user_result1->user_unique_id));
				$name_query = $this->db->get('appuser_login');
				
				$name_result1 = $name_query->result_object()[0];
					
				$fullname = $name_result1->fullname;
								
				$data_wallet_history1['wallet_id'] = admin_wallet_id;
				$data_wallet_history1['payment_type'] = 1;
				$data_wallet_history1['transaction_id'] = $transaction_id;
				$data_wallet_history1['transaction_type'] = 'credit';
				$data_wallet_history1['amount'] = signup_reward;
				$data_wallet_history1['balance'] = $old_balance + signup_reward;
				$data_wallet_history1['product_id'] = '';
				$data_wallet_history1['order_id'] = '';
				$data_wallet_history1['user_id'] = $user_result1->user_unique_id;
				$data_wallet_history1['remark'] = 'New User Signup Bonus From '.$fullname;
				$data_wallet_history1['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history',$data_wallet_history1);
				
				
				$this->db->select('*');
				$this->db->where(array('user_id' => admin_user_id));
				$query_wallet = $this->db->get('wallet_summery');
				
				$get_wallet = $query_wallet->result_object()[0];
				
				
				$old_amount = $get_wallet->amount;
				$walet_history_upd['amount'] = $old_amount + signup_reward;
			
				$this->db->where(array('user_id'=>admin_user_id));
				$this->db->update('wallet_summery', $walet_history_upd);
				
			}
			
			if(isset($img_decode->{MOBILE})){		
			    $img = $img_decode->{MOBILE};
			}else{
			    $img =$user_result1->profile_pic;
			}		


			$this->db->select('*');
			$this->db->where(array('user_id' => $user_result1->user_unique_id));
			$query_seller_data = $this->db->get('sellerlogin');
			if($query_seller_data->num_rows() >0){
				$seller_data = $query_seller_data->result_object()[0];
				$seller_unique_id = $seller_data->seller_unique_id;
			}
			else
			{
				$seller_unique_id = '';
			}
			
			
			$user_result['user_id'] = $user_result1->user_unique_id;
			$user_result['seller_id'] = $seller_unique_id;
			$user_result['wallet_id'] = $wallet_id;
			$user_result['refer_code'] = $referral_code;
			$user_result['name'] = $user_result1->fullname;
			$user_result['phone'] = $user_result1->phone;
			$user_result['email'] = $user_result1->email;
			$user_result['status'] = $user_result1->status;
			$user_result['profile_pic'] = $img;
		}
		if($qouteid){
			//get_cart_product
			$usercart = $this->get_cart_details($user_result1->user_unique_id,'');
			
			$quotecart = $this->get_cart_details('',$qouteid);
			
			foreach($usercart as $product_id){
				if(in_array($product_id,$quotecart)){
					$this->db->where(array('prod_id'=>$product_id,'user_id'=>$user_result1->user_unique_id));
					$this->db->delete('cartdetails');
				}
			}
			$cart = array();
			
			$cart['user_id'] = $user_result1->user_unique_id;
			
			$this->db->where(array('qoute_id'=>$qouteid));
			$this->db->update('cartdetails', $cart);
			
		}
		
		return $user_result;
    }
    
	function update_user_password($user_phone,$user_password)
	{
		$user_result = array();
	   
		$this->db->select('*');
		$this->db->where(array('phone' => $user_phone));
		$query = $this->db->get('appuser_login');
		
		if($query->num_rows() >0){
		   $user_result1 = $query->result_object()[0];
			
			$img_decode = json_decode($user_result1->profile_pic);
						
			if(isset($img_decode->{MOBILE})){		
			    $img = $img_decode->{MOBILE};
			}else{
			    $img =$user_result1->profile_pic;
			}			
			
			$user_result['status'] = $user_result1->status;
			
			$update_pass['password'] = $user_password;
			
			$this->db->where(array('phone'=>$user_phone));
			$this->db->update('appuser_login', $update_pass);
			
			return $user_result;
			
			
		}else {
			$user_result['status'] = 'not_exist';
		   return $user_result;
		   die();
		}
	}
	
	//Functiofor validate login user
    function validate_user_login($user_phone = '',$qouteid){
       $user_result = array();
	   
		$this->db->select('*');
		$this->db->where(array('phone' => $user_phone));
		$query = $this->db->get('appuser_login');
		
		if($query->num_rows() >0){
		   $user_result1 = $query->result_object()[0];
			
			$img_decode = json_decode($user_result1->profile_pic);
						
			if(isset($img_decode->{MOBILE})){		
			    $img = $img_decode->{MOBILE};
			}else{
			    $img =$user_result1->profile_pic;
			}			
			
			$user_result['user_id'] = $user_result1->user_unique_id;
			$user_result['name'] = $user_result1->fullname;
			$user_result['phone'] = $user_result1->phone;
			$user_result['email'] = $user_result1->email;
			$user_result['status'] = $user_result1->status;
			$user_result['profile_pic'] = $img;
		}else {
			$user_result['status'] = 'not_exist';
		   return $user_result;
		   die();
		}
		if($qouteid){
			//get_cart_product
			$usercart = $this->get_cart_details($user_result1->user_unique_id,'');
			
			$quotecart = $this->get_cart_details('',$qouteid);
			
			foreach($usercart as $product_id){
				if(in_array($product_id,$quotecart)){
					$this->db->where(array('prod_id'=>$product_id,'user_id'=>$user_result1->user_unique_id));
					$this->db->delete('cartdetails');
				}
			}
			$cart = array();
			
			$cart['user_id'] = $user_result1->user_unique_id;
			
			$this->db->where(array('qoute_id'=>$qouteid));
			$this->db->update('cartdetails', $cart);
			
		}
		
		return $user_result;
    }
	
	function validate_user_seller_login($user_phone = '',$qouteid){
       $user_result = array();
	   
		$this->db->select('*');
		$this->db->join('wallet_summery ws', 'ws.user_id = al.user_unique_id','INNER');
		$this->db->where(array('al.phone' => $user_phone));
		$query = $this->db->get('appuser_login al');
		
		$this->db->select('*');
		$this->db->where(array('sl.phone' => $user_phone));
		$this->db->join('wallet_summery ws', 'ws.user_id = sl.user_id','INNER');
		$query_seller = $this->db->get('sellerlogin sl');
		
		if($query->num_rows() >0){
		   $user_result1 = $query->result_object()[0];
			
			$img_decode = json_decode($user_result1->profile_pic);
						
			if(isset($img_decode->{MOBILE})){		
			    $img = $img_decode->{MOBILE};
			}else{
			    $img =$user_result1->profile_pic;
			}			

			if(!empty($img)){
				$base_url = 'https://www.bznesshub.com/media/profile_pictures/';
				if (!preg_match('/^https?:\/\//', $img)) {
				    // Prepend base URL
				    $img = $base_url . ltrim($img, '/'); // remove leading slash if exists
				}
			}

			$this->db->select('*');
			$this->db->where(array('user_id' => $user_result1->user_unique_id));
			$query_seller_data = $this->db->get('sellerlogin');
			if($query_seller_data->num_rows() >0){
				$seller_data = $query_seller_data->result_object()[0];
				
				$seller_unique_id = $seller_data->seller_unique_id;
				$email = $seller_data->email;
				$isseller = '1';
				
				$img_decode = json_decode($seller_data->logo);
				if(isset($img_decode->{MOBILE})){		
					$img = $img_decode->{MOBILE};
				}else{
					$img = $seller_result1->logo;
				}		

				if(!empty($img)){
				$base_url = 'https://www.bznesshub.com/media/';
				if (!preg_match('/^https?:\/\//', $img)) {
				    // Prepend base URL
				    $img = $base_url . ltrim($img, '/'); // remove leading slash if exists
				}
				}
				
			}
			else
			{
				$seller_unique_id = '';
				$isseller = '0';
				$email = $user_result1->email;
			}
//print_r($img);die;

			
			
			$user_result['user_id'] = $user_result1->user_unique_id;
			$user_result['seller_id'] = $seller_unique_id;
			$user_result['wallet_id'] = $user_result1->wallet_id;
			$user_result['refer_code'] = $user_result1->referral_code;
			$user_result['isseller'] = $isseller;
			$user_result['name'] = $user_result1->fullname;
			$user_result['phone'] = $user_result1->phone;
			$user_result['email'] = $email;
			$user_result['status'] = $user_result1->status;
			$user_result['profile_pic'] = $img;
		} else if($query_seller->num_rows() >0){
		   $seller_result1 = $query_seller->result_object()[0];
			
			$img_decode = json_decode($seller_result1->logo);
						
			if(isset($img_decode->{MOBILE})){		
			    $img = $img_decode->{MOBILE};
			}else{
			    $img = $seller_result1->logo;
			}			


			if(!empty($img)){
				$base_url = 'https://www.bznesshub.com/media/';
				if (!preg_match('/^https?:\/\//', $img)) {
				    // Prepend base URL
				    $img = $base_url . ltrim($img, '/'); // remove leading slash if exists
				}
			}
			
			$user_result['user_id'] = $seller_result1->user_id;
			$user_result['seller_id'] = $seller_result1->seller_unique_id;
			$user_result['wallet_id'] = $seller_result1->wallet_id;
			$user_result['isseller'] = "1";
			$user_result['name'] = $seller_result1->fullname;
			$user_result['phone'] = $seller_result1->phone;
			$user_result['email'] = $seller_result1->email;
			$user_result['status'] = $seller_result1->status;
			$user_result['profile_pic'] = $img;
		}else {
			$user_result['status'] = 'not_exist';
		   return $user_result;
		   die();
		}
		if($qouteid){
			$usercart = $this->get_cart_details($user_result1->user_unique_id,'');
			
			$quotecart = $this->get_cart_details('',$qouteid);
			
			foreach($usercart as $product_id){
				if(in_array($product_id,$quotecart)){
					$this->db->where(array('prod_id'=>$product_id,'user_id'=>$user_result1->user_unique_id));
					$this->db->delete('cartdetails');
				}
			}
			$cart = array();
			
			$cart['user_id'] = $user_result1->user_unique_id;
			
			$this->db->where(array('qoute_id'=>$qouteid));
			$this->db->update('cartdetails', $cart);
			
		}
		
		return $user_result;
    }

	function verify_user_otp($mobile_number,$otp)
	{
	$user_result = array();
		 $this->db->select('*');
	   $this->db->where(array('phone' => $mobile_number,'otp' => $otp));
	   $query_m = $this->db->get('app_user_otp');
	   if($query_m->num_rows() >0){
		   $user_result['status'] = 1;
	   }
	   else
	   {
		   $user_result['status'] = 0;
	   }
	
		return $user_result;
		
	}
	
	//function for save user opt
	
	function save_user_otp($user_phone,$otp){
		$this->db->delete('app_user_otp',array('phone'=>$user_phone));
		
		$data['phone'] = $user_phone;
		$data['otp'] = $otp;
		
		$this->db->insert('app_user_otp',$data);
	}
	
	//function for get user opt
	
	function check_user_exists($user_phone){
		$id = 0;
		$this->db->select('id');
		$this->db->where(array('phone' => $user_phone));
		$query = $this->db->get('app_user_otp');
		
		if($query->result_object()){
			$user_result = $query->result_object()[0];
			$id = $user_result->id;
		}
		return $id;
	}
	


	function get_user_otp($user_phone){
		$otp = '';
		
		$this->db->select('otp');
		$this->db->where(array('phone' => $user_phone));
		$query = $this->db->get('app_user_otp');
		
		if($query->result_object()){
			$user_result = $query->result_object()[0];
			$otp = $user_result->otp;
		}
		return $otp;
	}
	
	function get_cart_details($user_id,$quote_id){
		$this->db->select("prod_id");
		
		if($user_id){
			$this->db->where(array('user_id'=>$user_id));
		}else {
			$this->db->where(array('qoute_id'=>$quote_id));
		}
		
		
		$query = $this->db->get('cartdetails');
		
		$cart_result = array();
		if($query->num_rows() >0){
			foreach($query->result_object() as $result){
				$cart_result[] = $result->prod_id;	
			}				
		}
		return $cart_result;
	}
	
	function get_user_review_ratings($user_id,$pageno){
		if($pageno >0){
			$start = ($pageno*LIMIT);
		}else{
			$start = 0;
		}
	   
		$this->db->select("pr.review_id,rating,pr.title as review_title,pr.comment as review_comment,pr.created_at as review_date, apl.fullname as user_name, pd.prod_name as product_name");
		$this->db->join('appuser_login apl', 'apl.user_unique_id = pr.user_id','INNER');
		$this->db->join('product_details pd', 'pd.product_unique_id = pr.product_id','INNER');
		$this->db->where(array('pr.user_id'=>$user_id));
		$this->db->order_by('pr.created_at','DESC');
		$this->db->limit(LIMIT,$start);
		$query_review = $this->db->get('product_review pr');
		
		$reviews = array();
		if($query_review->num_rows() >0){
			$reviews = $query_review->result_object();
		}
		return $reviews;
	}
	
	
	function get_user_profile($user_id){		
	   
		$this->db->select('user_unique_id, fullname, phone, email,profile_pic');
		$this->db->where(array('user_unique_id' => $user_id));
		$query = $this->db->get('appuser_login');
		
		$user_result = array();
		if($query->num_rows() >0){
			$user_result1 = $query->result_object()[0];
			
			$img_decode = json_decode($user_result1->profile_pic);
						
			if(isset($img_decode->{MOBILE})){		
			    $img = $img_decode->{MOBILE};
			}else{
			    $img =$user_result1->profile_pic;
			}			

			if(!empty($img)){
				$base_url = 'https://www.bznesshub.com/media/profile_pictures/';
				if (!preg_match('/^https?:\/\//', $img)) {
				    // Prepend base URL
				    $img = $base_url . ltrim($img, '/'); // remove leading slash if exists
				}
			}
			
			$user_result['user_id'] = $user_result1->user_unique_id;
			$user_result['name'] = $user_result1->fullname;
			$user_result['phone'] = $user_result1->phone;
			$user_result['email'] = $user_result1->email;
			$user_result['profile_pic'] = $img;
		}
		return $user_result;
	}
	
	
	
	
	// string of specified length 
	function random_strings($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}
	
	function random_strings_digit($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '0123456789'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}
	
   
}
