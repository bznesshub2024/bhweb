<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/third_party/encryptfun.php';


class UserAuthController extends REST_Controller {
	
	protected $request_method ='post'; 
	
		 
	 public function __construct() { 
        parent::__construct();
                
        // Load the user model
        $this->load->model('sms_model');
        $this->load->model('user_model');
    }
	public function index_get()
	{
		//$this->load->view('welcome_message');
	}
	
	
	public function login_post()
	{
		$requiredparameters = array('language','phone','qouteid');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$qouteid  = removeSpecialCharacters($this->post('qouteid'));
	 	$otp_login  = removeSpecialCharacters($this->post('otp_login'));
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
		$invalid_response = array( "id"=> "","user_unique_id"=> "","fullname"=> "", "address"=> "", "city"=> "","pincode"=> "", "state"=> "", "country"=> "",
                                "region"=> "", "phone"=> "", "email"=> "", "password"=> "", "profile_pic"=> "", "status"=> "","flagid"=> "","create_by"=> "",
        "update_by"=> "");
    	if($validation=='valid') {
			if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code),$invalid_response);
			}else if(is_numeric($mobile_number)){
				$validate_user = $this->user_model->validate_user_login($mobile_number,$qouteid,$otp_login);
				
				if($validate_user){
					if($validate_user['status'] ==1){
						if(empty($this->session->userdata('user_id')))
						{
							$newdata = array(
											   'user_id'  => $validate_user['user_id'],
												'is_seller'  => $validate_user['is_seller'],
											   'referral_code'  => $validate_user['referral_code'],
												'user_name'  => $validate_user['name'],
												'user_phone'  => $validate_user['phone'],
												'user_email'  => $validate_user['email'],
											   'logged_in' => TRUE
										   ); 
							 $set_data = $this->session->set_userdata($newdata);
						}
						$this->responses(1,get_phrase('login_successfully',$language_code),$validate_user);
						
					}else if($validate_user['status'] =='not_exist'){
						$this->responses(0,get_phrase('user_not_exist',$language_code),$invalid_response);
					}else if($validate_user['status'] =='wrong_otp'){
						$this->responses(0,'Wrong Otp',$invalid_response);
					}else{
						$this->responses(0,get_phrase('user_status_disabled',$language_code),$invalid_response);
					}
					
				}else{
					$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
				}
			}else{
				$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}
	
	public function login_otp_post(){
		
		$requiredparameters = array('language','phone');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		if(is_numeric($mobile_number)){
				
				$validate_user = $this->user_model->validate_user_login_first($mobile_number);
				if($validate_user['status'] == 'not_exist')
				{
					$this->responses(0,get_phrase('user_not_exist',$language_code));
				}
				else
				{
					$otp = $this->sms_model->generateNumericOTP(6);
					
					
					$country_code = '91';
    				$send_mobile_number = $country_code . $mobile_number;
    				$template_id = '1707173096363007016';
    					$receipents = array(
    						"otp" => $otp
    					);
    					
    					
    				$message = "Dear Customer {1} is the OTP for your login at BznessHub. In case you have not requested this, please contact us at admin@bznesshub.com - BznessHub"; 
                    $message = str_replace("{1}", $receipents["otp"], $message);
    				
    					$sms_sent = $this->sms_model->sendSms($template_id,$send_mobile_number,$message);
					
					
					
					//$message = 'Dear customer welcome onboard ! '.$otp.' is your OTP to login your Marurang account. MRURNG';
					//$sms_sent = $this->sms_model->send_sms_new($message, $mobile_number);
					//$sms_sent = 'sent';
					
					if($sms_sent == 'disabled'){
						$this->responses(0,get_phrase('sms_disabled',$language_code));
					}else if($sms_sent == 'sent'){
						$this->user_model->save_user_otp($mobile_number,$otp);
						$this->responses(1,get_phrase('sms_sent',$language_code),array('otp'=>$otp,'user_id'=>$mobile_number));
					}else{
						$this->responses(0,get_phrase('sms_failed',$language_code));
					}
				}
			}else if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code));
			}else{
				$this->responses(0,get_phrase('mobile_numeric',$language_code));
			}
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	
	public function signup_post(){
		
		$requiredparameters = array('language','phone','user_name');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$user_name  = removeSpecialCharacters($this->post('user_name'));
	 	$refer_code  = removeSpecialCharacters($this->post('refer_code'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		if(is_numeric($mobile_number)){
				$otp = $this->sms_model->generateNumericOTP(6);
				
				//$message = 'Dear customer welcome onboard ! '.$otp.' is your OTP to login your Marurang account. MRURNG';
				/*$sms_sent = $this->sms_model->send_sms($message, $mobile_number);*/
				$country_code = '91';
				$send_mobile_number = $country_code . $mobile_number;
				$template_id = '1707173096901291380';
					$receipents = array(
						"otp" => $otp
					);
					
				$message = "OTP for creating an account for Bzness Hub request is {1}. Please enter this to verify your identity and proceed with the creating an account request. - Bzness Hub"; 
                $message = str_replace("{1}", $receipents["otp"], $message);
				
					$sms_sent = $this->sms_model->sendSms($template_id,$send_mobile_number,$message);
				//$sms_sent = $this->sms_model->send_sms_new($message, $mobile_number);
				//$sms_sent = 'sent';
				//print_r($sms_sent);
				if($sms_sent == 'disabled'){
					$this->responses(0,get_phrase('sms_disabled',$language_code));
				}else if($sms_sent == 'sent'){
					$this->user_model->save_user_otp($mobile_number,$otp);
					$this->responses(1,get_phrase('sms_sent',$language_code),array('otp'=>$otp,'user_id'=>$mobile_number));
				}else{
					$this->responses(0,get_phrase('sms_failed',$language_code));
				}
			}else if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code));
			}else if(!$user_name){
				$this->responses(0,get_phrase('user_name_mandatory',$language_code));
			}else{
				$this->responses(0,get_phrase('mobile_numeric',$language_code));
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	
	public function verify_otp_post(){
	    $requiredparameters = array('language','phone','otp','qouteid','user_name');
		
		//echo 'ddsds';
		// echo $otp1 = $this->user_model->get_user_otp($mobile_number);
		
		
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$otp  = removeSpecialCharacters($this->post('otp'));
	 	$qouteid  = removeSpecialCharacters($this->post('qouteid'));
	 	$user_name  = removeSpecialCharacters($this->post('user_name'));
	 	$refer_code  = removeSpecialCharacters($this->post('refer_code'));
	 	
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		$invalid_response = array( "id"=> "","user_unique_id"=> "","fullname"=> "", "address"=> "", "city"=> "","pincode"=> "", "state"=> "", "country"=> "",
                                "region"=> "", "phone"=> "", "email"=> "", "password"=> "", "profile_pic"=> "", "status"=> "","flagid"=> "","create_by"=> "",
        "update_by"=> "");
        
       
        
    	if($validation=='valid') {
			$otp1 = $this->user_model->get_user_otp($mobile_number);
			if(!$otp){
				$this->responses(0,get_phrase('otp_mandatory',$language_code),$invalid_response);
			}else if($otp !=$otp1){
				$this->responses(0,get_phrase('invalid_otp',$language_code),$invalid_response);
			}else if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code),$invalid_response);
			}else if(!$user_name){
				$this->responses(0,get_phrase('user_name_mandatory',$language_code));
			}else if(is_numeric($mobile_number) && $otp){
				$validate_user = $this->user_model->validate_user($mobile_number,$qouteid,$user_name,$refer_code);
				if($validate_user){
					if($validate_user['status'] ==1){
						if(empty($this->session->userdata('user_id')))
						{
							$newdata = array(
											   'user_id'  => $validate_user['user_id'],
											   'is_seller'  => $validate_user['is_seller'],
											   'referral_code'  => $validate_user['referral_code'],
											   'user_name'  => $validate_user['name'],
											   'user_phone'  => $validate_user['phone'],
											   'user_email'  => $validate_user['email'],
											   'logged_in' => TRUE
										   );
							 $set_data = $this->session->set_userdata($newdata);
						}
						$this->responses(1,get_phrase('login_successfully',$language_code),$validate_user);
					}else if($validate_user['status'] =='exist'){
						$this->responses(0,get_phrase('phone_already_exist',$language_code),$invalid_response);
					}else{
						$this->responses(0,get_phrase('user_status_disabled',$language_code),$invalid_response);
					}
					
				}else{
					$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
				}
			}else{
				$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}
	
	
	public function verify_otp_old_post(){
		
	    $requiredparameters = array('language','phone','otp','qouteid');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$otp  = removeSpecialCharacters($this->post('otp'));
	 	$qouteid  = removeSpecialCharacters($this->post('qouteid'));
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		$invalid_response = array( "id"=> "","user_unique_id"=> "","fullname"=> "", "address"=> "", "city"=> "","pincode"=> "", "state"=> "", "country"=> "",
                                "region"=> "", "phone"=> "", "email"=> "", "password"=> "", "profile_pic"=> "", "status"=> "","flagid"=> "","create_by"=> "",
        "update_by"=> "");
    	if($validation=='valid') {
			$otp1 = $this->user_model->get_user_otp($mobile_number);
      		
			if(!$otp){
				$this->responses(0,get_phrase('otp_mandatory',$language_code),$invalid_response);
			}else if($otp !=$otp1){
				$this->responses(0,get_phrase('invalid_otp',$language_code),$invalid_response);
			}else if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code),$invalid_response);
			}else if(is_numeric($mobile_number) && $otp){
				$validate_user = $this->user_model->validate_user($mobile_number,$qouteid);
				if($validate_user){
					if($validate_user['status'] ==1){
						if(empty($this->session->userdata('user_id')))
						{
							$newdata = array(
											   'user_id'  => $validate_user['user_id'],
											   'logged_in' => TRUE
										   );
							 $set_data = $this->session->set_userdata($newdata);
						}
						$this->responses(1,get_phrase('login_successfully',$language_code),$validate_user);
					}else{
						$this->responses(0,get_phrase('user_status_disabled',$language_code),$invalid_response);
					}
					
				}else{
					$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
				}
			}else{
				$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}
	
	
	public function getUserReview_post(){
	    $requiredparameters = array('language','user_id','pageno');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$user_id  = removeSpecialCharacters($this->post('user_id'));
	 	$pageno = removeSpecialCharacters($this->post('pageno'));
		$review_array = array();
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		if($validation=='valid') {
			      		
			if($user_id){
				$review_array = $this->user_model->get_user_review_ratings($user_id,$pageno);
				if($review_array){
						$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => '',
							'pageno' => $pageno,		
							$this->config->item('rest_data_field_name') => $review_array
							
						], self::HTTP_OK);
					}else{
						$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),	
							'pageno' => $pageno,							
							$this->config->item('rest_data_field_name') => $review_array							
						], self::HTTP_OK);
					}
			}else{
				$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('user_id_missing',$language_code),	
							'pageno' => $pageno,							
							$this->config->item('rest_data_field_name') => $review_array							
						], self::HTTP_OK);
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}
	
	public function getUserProfile_post(){
	    $requiredparameters = array('language','user_id');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$user_id  = removeSpecialCharacters($this->post('user_id'));
	 	
		$review_array = array();
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		if($validation=='valid') {
			      		
			if($user_id){
				$review_array = $this->user_model->get_user_profile($user_id);
				if($review_array){
						$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => '',	
							$this->config->item('rest_data_field_name') => $review_array
							
						], self::HTTP_OK);
					}else{
						$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),							
							$this->config->item('rest_data_field_name') => $review_array							
						], self::HTTP_OK);
					}
			}else{
				$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('user_id_missing',$language_code),					
							$this->config->item('rest_data_field_name') => $review_array							
						], self::HTTP_OK);
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}
  

}
