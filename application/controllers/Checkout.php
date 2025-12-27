<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class Checkout extends REST_Controller {
	 
	 public function __construct() { 
        parent::__construct();
                
        // Load the Checkout model
        $this->load->model('checkout_model');
        $this->load->model('address_model');
		 $this->load->model('delivery_model');
		 $this->load->model('home_model');
		 $this->load->model('wallet_model');
    }
	public function send_email_get()
	{	echo "hi";
		send_email_smtp('chiragsavaliya67@gmail.com',"hello","fleek subject");
	}
	public function index_get()
	{	
		$qoute_id = $this->session->userdata("qoute_id");
		$user_id = $this->session->userdata("user_id");
		$city_id = $this->session->userdata("city_id");
		if($qoute_id != '' || $user_id != '')
		{
			$this->data['checkout'] = $this->checkout_model->get_checkout_full_details($user_id,$qoute_id,$city_id);
		}
		else
		{
			$this->data['checkout'] = array();
		}
		$this->data['address'] = $this->address_model->get_user_address_details_full($user_id);
		$this->data['get_city'] = $this->delivery_model->get_delivery_city_request();

		$this->data['wallet'] = $this->wallet_model->get_wallet_data();
        $this->data['wallet_summery'] = $this->wallet_model->get_wallet_summery($this->data['wallet']['wallet_id']);
        $this->data['wallet_bonus'] = $this->wallet_model->get_wallet_bonus($this->data['wallet']['wallet_id']);


		$this->load->view('website/checkout.php',$this->data);  // ye view/website folder hai
	
	}
	
	public function thankyou_get($order_id)
	{	
		$default_language = $this->session->userdata("default_language");
		 
		$this->data['order_id'] = $order_id;
		/*if ($order_id) {
			$this->email_model->send_order_email($order_id, PLACE_ORDER_TEMP);
			$this->email_model->send_order_email_admin_seller($order_id);  
		}
		$message_seller = 'Dear Marurang seller, you have Received a New Order . Please login into seller dashboard to see details. Order Id is ' . $order_id . ' – Regards, Marurang. MRURNG';
		$templete_id1 = '1707167698471095760';
		$ch1 = curl_init('https://www.txtguru.in/imobile/api.php?');
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, "username=$user&password=$pass&source=$header_name&dmobile=+91$seller_phone&dlttempid=$templete_id1&&message=$message_seller");
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		$data1 = curl_exec($ch1);


		$admin_phone = get_settings('system_phone');
		$message_admin = 'Hello Admin, new order placed by customer. Please login into admin dashboard to see details. Order Id is ' . $order_id . ' – Regards, Marurang. MRURNG';
		$templete_id2 = '1707167698477367042';
		$ch2 = curl_init('https://www.txtguru.in/imobile/api.php?');
		curl_setopt($ch2, CURLOPT_POST, 1);
		curl_setopt($ch2, CURLOPT_POSTFIELDS, "username=$user&password=$pass&source=$header_name&dmobile=+91$admin_phone&dlttempid=$templete_id2&&message=$message_admin");
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
		$data2 = curl_exec($ch2);*/
		
		$this->data['recommended_product'] = $this->home_model->get_home_products($default_language,'Recommended');
		$this->load->view('website/thankyou.php',$this->data);  // ye view/website folder hai
	
	} 
	
	
	public function get_city_post()
	{	
		$stateid = $this->post('stateid');
		$city_detail = $this->delivery_model->get_city($stateid);
		echo json_encode($city_detail);
	
	}
	
	public function get_state_post()
	{	
		$language = $this->post('language');
		$state_detail = $this->delivery_model->get_state();
		echo json_encode($state_detail);
	
	}
	
	public function addorder_get()
	{	
		$user_id = $this->input->get('user_id');
		$qouteid = $this->input->get('qouteid');
		$fullname = $this->input->get('fullname');
		$mobile = $this->input->get('mobile');
		$locality = $this->input->get('locality');
		$fulladdress = $this->input->get('fulladdress');
		$city = $this->input->get('city');
		$state = $this->input->get('state');
		$pincode = '';// $this->input->get('pincode');
		$addresstype = $this->input->get('addresstype');
		$email = $this->input->get('email');
		$payment_id = $this->input->get('payment_id');
		$payment_mode = $this->input->get('payment_mode');
		$response = $this->checkout_model->place_order_details($user_id,$qouteid,$fullname,$mobile,$locality,$fulladdress,$city,$state,$pincode,$addresstype,$email,$payment_id,$payment_mode);
		
		echo json_encode($response);
		
		
		
	}
	
	
	// function for get cart count
	public function checkout_post(){
		$requiredparameters = array('language');
		
		$language_code = removeSpecialCharacters($this->post('language'));	
		$user_id = removeSpecialCharacters($this->session->userdata('user_id'));	
		$qouteid = removeSpecialCharacters($this->session->userdata('qoute_id'));	
		$coupon_code = removeSpecialCharacters($this->post('coupon_code'));	
		$shipping_city = removeSpecialCharacters($this->post('shipping_city'));	
		$shipping_pincode = removeSpecialCharacters($this->post('shipping_pincode'));	
		$payment_type = removeSpecialCharacters($this->post('payment_type'));

		$wallet_money = removeSpecialCharacters($this->post('wallet_money'));

$bonus_virtual_price = removeSpecialCharacters($this->post('bonus_virtual_price'));

$globalJson = removeSpecialCharacters($this->post('globalJson'));
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
			if($qouteid != '' || $user_id != '') 
			{
				$cart_detail = $this->checkout_model->get_checkout_full_details($user_id,$qouteid,$shipping_city,$shipping_pincode,$coupon_code,$payment_type,$wallet_money,$globalJson);

				if($cart_detail == 'invalid')
				{
					$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('invalid_coupon',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail,
								'qouteid' => $qouteid
								
							], self::HTTP_OK);
				}
				if($cart_detail >0){	

					$validate_coupon = '';
					$coupon_discount = ''; 
					/*if(trim($coupon_code)){*/
					if(($cart_detail['coupon_discount1']))	{
						$validate_coupon = $this->checkout_model->Validate_coupon_code($user_id,$coupon_code,'');
								
						if($validate_coupon =='invalid'){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('invalid_coupon',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail,
								'qouteid' => $qouteid
								
							], self::HTTP_OK);
						}else if($validate_coupon =='login_required'){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('login_requireed',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail,
								'qouteid' => $qouteid
								
							], self::HTTP_OK);
						}else if($validate_coupon =='applied_exced'){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('applied_exced',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail,
								'qouteid' => $qouteid
								
							], self::HTTP_OK);
						}else if($validate_coupon =='expired'){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('coupon_expired',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail,
								'qouteid' => $qouteid
								
							], self::HTTP_OK);
						}else	if($validate_coupon->min_order >0 && $cart_detail['total_price_value'] < $validate_coupon->min_order ){
							$validate_coupon = 'less_amount';
						}else{
							$coupon_type = $validate_coupon->coupon_type;
							$value = $validate_coupon->value;
							
							if($coupon_type ==1){
								$coupon_discount =  ($cart_detail['total_price_value']/100)*$value;
							}else if($coupon_type ==2){
								$coupon_discount =  $cart_detail['total_price_value']-$value;
							}
							$payable_amount = ($cart_detail['total_price_value']-$value);
							
							$cart_detail['coupon_discount_text'] = price_format($value);
							$cart_detail['coupon_discount'] = $value;
							$cart_detail['payable_amount'] = price_format($payable_amount);
							$cart_detail['payable_amount_value'] = $payable_amount;
							$cart_detail['total_price_value'] = $payable_amount;
						}
						$cart_detail['coupon_code'] = $coupon_code;
						
					}
					else
					{		
						if($coupon_discount>0){
							$msgs = get_phrase('coupon_applied_successfully',$language_code);
							}else{
								$msgs = get_phrase('checkout_details',$language_code);
							}

								$this->response([
								$this->config->item('rest_status_field_name') => 1,	
								$this->config->item('rest_message_field_name') => $msgs,
								$this->config->item('rest_data_field_name') => $cart_detail,
								'qouteid' => $qouteid ], self::HTTP_OK);
					}	

					
					if($validate_coupon =='invalid'){
						$this->response([
							$this->config->item('rest_status_field_name') => 2,
							$this->config->item('rest_message_field_name') => get_phrase('invalid_coupon',$language_code),
							$this->config->item('rest_data_field_name') => $cart_detail,
							'qouteid' => $qouteid
							
						], self::HTTP_OK);
					}else if($validate_coupon =='less_amount'){
						$this->response([
							$this->config->item('rest_status_field_name') => 2,
							$this->config->item('rest_message_field_name') => get_phrase('amount_less_coupon_limit',$language_code),
							$this->config->item('rest_data_field_name') => $cart_detail,
							'qouteid' => $qouteid
							
						], self::HTTP_OK);
					}else{
						if($coupon_discount>0){
							$msgs = get_phrase('coupon_applied_successfully',$language_code);
						}else{
							$msgs = get_phrase('checkout_details',$language_code);
						}
						$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => $msgs,
							$this->config->item('rest_data_field_name') => $cart_detail,
							'qouteid' => $qouteid
							
						], self::HTTP_OK);
					}
					
				}else{
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('cart_empty',$language_code),
							$this->config->item('rest_data_field_name') => $cart_detail,
							'qouteid' => $qouteid
							
						], self::HTTP_OK);
				}
		
			}else{
				$user_address = array("address_id" =>'',"fullname"=>'',"mobile"=>'',"locality"=>'',"fulladdress"=>'',"city"=>'',"state"=>'',"pincode"=>'',"email"=>'',"addresstype"=>'');

				$res = array('user_address' =>$user_address, 'total_mrp' =>0, 'total_discount' =>0,'total_price'=>0,
			'total_item'=>0, 'tax_payable'=>0, 'coupon_code'=>$coupon_code,'coupon_discount'=>0, 'shipping_fee'=>0, 'payable_amount'=>0,'payable_amount_value'=>0,'total_price_value'=>0);
				$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('checkout_details',$language_code),
							$this->config->item('rest_data_field_name') => $res,
							'qouteid' => $qouteid
							
						], self::HTTP_OK);
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}
	
	// function for get cart count
	public function validateCoupon_post(){
		$requiredparameters = array('language','coupon_code','price');
		
		$language_code = removeSpecialCharacters($this->post('language'));	
		$total_price_value = removeSpecialCharacters($this->post('price'));	
		$coupon_code = removeSpecialCharacters($this->post('coupon_code'));	
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
			$cart_detail = array(  'coupon_code'=>$coupon_code,'coupon_discount'=>0,'payable_amount'=>0);
			if($total_price_value && $coupon_code){
					
					$validate_coupon = '';
						$validate_coupon = $this->checkout_model->Validate_coupon_code('',$coupon_code,'product');
						//print_r($validate_coupon);
						if($validate_coupon =='invalid'){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('invalid_coupon',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail
								
							], self::HTTP_OK);
						}else if($validate_coupon =='applied_exced'){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('applied_exced',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail
								
							], self::HTTP_OK);
						}else if($validate_coupon =='expired'){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('coupon_expired',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail
								
							], self::HTTP_OK);
						}else if($validate_coupon->min_order >0 && $total_price_value < $validate_coupon->min_order ){
							$this->response([
								$this->config->item('rest_status_field_name') => 2,
								$this->config->item('rest_message_field_name') => get_phrase('amount_less_coupon_limit',$language_code),
								$this->config->item('rest_data_field_name') => $cart_detail
								
							], self::HTTP_OK);
						}else{
							$coupon_type = $validate_coupon->coupon_type;
							$value = $validate_coupon->value;
							$coupon_discount =0;
							if($coupon_type ==1){
								$coupon_discount =  ($total_price_value/100)*$value;
							}else if($coupon_type ==2){
								$coupon_discount =  $total_price_value-$value;
							}
							$payable_amount = ($total_price_value-$coupon_discount);
							
							$cart_detail['coupon_discount'] = price_format($coupon_discount);
							$cart_detail['payable_amount'] = price_format($payable_amount);
							//$cart_detail['payable_amount_value'] = $payable_amount;
							//$cart_detail['total_price_value'] = $payable_amount;
							$cart_detail['coupon_code'] = $coupon_code;
							
							if($coupon_discount>0){
								if(empty($this->session->userdata('coupon_code')))
								{
									$newdata = array(
													   'coupon_code'  => $coupon_code,
													   'coupon_discount'  => price_format($coupon_discount),
													   'payable_amount'  => price_format($payable_amount),
													   'logged_in' => TRUE
												   );

									$set_data = $this->session->set_userdata($newdata);
								}
								$msgs = get_phrase('coupon_applied_successfully',$language_code);
							}else{
								$msgs = '';//get_phrase('checkout_details',$language_code);
							}
							$this->response([
								$this->config->item('rest_status_field_name') => 1,
								$this->config->item('rest_message_field_name') => $msgs,
								$this->config->item('rest_data_field_name') => $cart_detail
								
							], self::HTTP_OK);
						}
						
		
			}else{			
				
				$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => '',//get_phrase('checkout_details',$language_code),
							$this->config->item('rest_data_field_name') => $cart_detail
							
						], self::HTTP_OK);
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}
	 
  
  
	// function for placeOrder
	public function placeOrder_post(){
		$requiredparameters = array('language','fullname','mobile','locality','fulladdress','city','state','addresstype','email','payment_id','payment_mode','city_id');
		$language_code = removeSpecialCharacters($this->post('language'));	
		$user_id = removeSpecialCharacters($this->session->userdata('user_id'));	
		$qouteid = removeSpecialCharacters($this->session->userdata('qoute_id'));	
		$fullname = removeSpecialCharacters($this->post('fullname'));	
		$mobile = removeSpecialCharacters($this->post('mobile'));	
		$locality = removeSpecialCharacters($this->post('locality'));	
		$fulladdress = removeSpecialCharacters($this->post('fulladdress'));	
		$city = removeSpecialCharacters($this->post('city'));	 
		$state = removeSpecialCharacters($this->post('state_id'));	
		$pincode = removeSpecialCharacters($this->post('pincode'));	
		$addresstype = removeSpecialCharacters($this->post('addresstype'));	
		$email = removeSpecialCharacters($this->post('email'));	
		$payment_id = removeSpecialCharacters($this->post('payment_id'));	
		$payment_mode = removeSpecialCharacters($this->post('payment_mode'));	
		$coupon_code = removeSpecialCharacters($this->post('coupon_code'));
		$coupon_value = removeSpecialCharacters($this->post('coupon_value'));
		$city_id = removeSpecialCharacters($this->post('city_id'));
		

		$wallet_money = removeSpecialCharacters($this->post('wallet_money'));
		$bonus_virtual_price = removeSpecialCharacters($this->post('bonus_virtual_price'));

		$globalJson = removeSpecialCharacters($this->post('globalJson'));

		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
			if(($user_id || $qouteid) && $fullname && $mobile && $fulladdress && $city && $state && $addresstype && $payment_id && $payment_mode){
				
				$order_detail = $this->checkout_model->place_order_details($user_id,$qouteid,$fullname,$mobile,$locality,$fulladdress,$city,$state,$pincode,$addresstype,$email,$payment_id,$payment_mode,$coupon_code,$coupon_value,$city_id,$wallet_money,$globalJson);
				
				
				if($order_detail['status'] == 'update'){						
					$order_details['order_id'] = $order_detail['order_id'];
					$order_details['order_total'] = $order_detail['order_detail']['total_price'];
					$order_details['order_discount'] = $order_detail['order_detail']['discount'];
					$order_details['total_item'] = $order_detail['order_detail']['total_qty'];
					$order_details['order_msg'] = get_phrase('success_order',$language_code);
					

					$save_order['globalJson'] = $globalJson;
					$this->db->where(array('order_id' => $order_details['order_id']));
					$queryup = $this->db->update('orders', $save_order);


					$this->checkout_model->empty_cart($user_id, $qouteid);
					
					$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => get_phrase('order_details',$language_code),
							$this->config->item('rest_data_field_name') => $order_details
							
						], self::HTTP_OK);
				}else{
					$order_details['order_id'] = 0;
					$order_details['order_total'] = 0;
					$order_details['order_discount'] = 0;
					$order_details['total_item'] = 0;
					$order_details['order_msg'] = '';
					
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('cart_empty',$language_code),
							$this->config->item('rest_data_field_name') => $order_details
							
						], self::HTTP_OK);
				}
		
			}else if(!$user_id && !$qouteid ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('invalid_request',$language_code),
					$this->config->item('rest_data_field_name') => $cart_detail
					
				], self::HTTP_OK);
				
			}else if(!$fullname ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('username_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
			}else if(!is_numeric($mobile)){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('phone_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
			
			}/*else if(!is_numeric($pincode)){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('pincode_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}*/else if(!$fulladdress ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('address_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}else if(!$state ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('state_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}else if(!$city ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('city_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}else if(!$addresstype ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('addresstype_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}/*else if(!$email ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('email_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}*/else if(!$payment_id ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('payment_id_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}else if(!$payment_mode ){
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('payment_mode_mandatory',$language_code)
					//$this->config->item('rest_data_field_name') => $address_detail
											
				], self::HTTP_OK);
				
			}
    	}
    	else { 
      		echo $validation; //These are parameters are missing.
    	}
	}
	

}
