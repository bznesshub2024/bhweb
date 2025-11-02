<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class UserAuthController extends REST_Controller {
	
	protected $request_method ='post'; 
	
		 
	 public function __construct() { 
        parent::__construct();
       require_once APPPATH.'third_party/encryptfun.php';
       
        // Load the user model
        $this->load->model('sms_model');
        $this->load->model('user_model');
    }
	public function index_get()
	{
		//$this->load->view('welcome_message');
	}
	
	public function login_post(){
		$requiredparameters = array('language','phone','qouteid');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$user_password  = removeSpecialCharacters($this->post('user_password'));
	 	$qouteid  = removeSpecialCharacters($this->post('qouteid'));
		
		$publickey_server = $this->config->item("encryption_key");
        $encruptfun = new encryptfun();
        $encryptedpassword = $encruptfun->encrypt($publickey_server, $this->post('user_password'));
		$user_password  = $encryptedpassword;
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		$invalid_response = array( "id"=> "","user_unique_id"=> "","fullname"=> "", "address"=> "", "city"=> "","pincode"=> "", "state"=> "", "country"=> "",
                                "region"=> "", "phone"=> "", "email"=> "", "password"=> "", "profile_pic"=> "", "status"=> "","flagid"=> "","create_by"=> "",
        "update_by"=> "");
    	if($validation=='valid') {
			if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code),$invalid_response);
			} else if(is_numeric($mobile_number)){
				$validate_user = $this->user_model->validate_user_login($mobile_number,$qouteid,$user_password);
				if($validate_user){
					if($validate_user['status'] ==1){
						$this->responses(1,get_phrase('login_successfully',$language_code),$validate_user);
					}else if($validate_user['status'] =='not_exist'){
						$this->responses(0,get_phrase('user_not_exist',$language_code),$invalid_response);
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
	public function signup_post(){
		$requiredparameters = array('language','phone','user_name');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$user_name  = removeSpecialCharacters($this->post('user_name'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		if(is_numeric($mobile_number)){
				$otp = $this->sms_model->generateNumericOTP(6);
				//$otp = '123456';
				$message = $otp.' is your OTP.';
				//$sms_sent = $this->sms_model->send_sms($message, $mobile_number);
				$sms_sent = 'Your Message Has Been Sent';
				if($sms_sent == 'disabled'){
					$this->responses(0,get_phrase('sms_disabled',$language_code));
				}else if($sms_sent == "Your Message Has Been Sent"){
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
	
	public function forgot_otp_post(){
		$requiredparameters = array('language','phone');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		if(is_numeric($mobile_number)){
				$otp = $this->sms_model->generateNumericOTP(6);
				//$otp = '123456';
				////$message = $otp.' is your OTP.';
				/*$sms_sent = $this->sms_model->send_sms($message, $mobile_number);*/
				//$sms_sent = "Your Message Has Been Sent";
				
				$country_code = '91';
    				$send_mobile_number = $country_code . $mobile_number;
    				$template_id = '1707173096363007016';
    					$receipents = array(
    						"otp" => $otp
    					);
    					
    					
    				$message = "Dear Customer {1} is the OTP for your login at BznessHub. In case you have not requested this, please contact us at admin@bznesshub.com - BznessHub"; 
                    $message = str_replace("{1}", $receipents["otp"], $message);
    				
    					$sms_sent = $this->sms_model->send_sms_new($template_id,$send_mobile_number,$message);
				
				
				
				if($sms_sent == 'disabled'){
					$this->responses(0,get_phrase('sms_disabled',$language_code));
				}else if($sms_sent == "Your Message Has Been Sent"){
					$this->responses(1,get_phrase('sms_sent',$language_code),array('otp'=>$otp,'mobile'=>$mobile_number));
				}else{
					$this->responses(0,get_phrase('sms_failed',$language_code));
				}
			}else if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code));
			}else{
				$this->responses(0,get_phrase('mobile_numeric',$language_code));
			}
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	
	public function  update_password_post()
	{
		$requiredparameters = array('language','phone','otp','password');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$otp  = removeSpecialCharacters($this->post('otp'));
		
		$publickey_server = $this->config->item("encryption_key");
        $encruptfun = new encryptfun();
        $encryptedpassword = $encruptfun->encrypt($publickey_server, $this->post('password'));
		$user_password  = $encryptedpassword;
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		$invalid_response = array( "id"=> "", "phone"=> "", "password"=> "");
    	if($validation=='valid') {
			$validate_user = $this->user_model->update_user_password($mobile_number,$user_password);
			
			if($validate_user['status'] ==1){
				$this->responses(1,'Password Update Successfully.');
			}else if($validate_user['status'] =='not_exist'){
				$this->responses(0,get_phrase('user_not_exist',$language_code),$invalid_response);
			}else{
				$this->responses(0,get_phrase('user_status_disabled',$language_code),$invalid_response);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
	}

	public function send_otp_post(){
		$requiredparameters = array('language','phone');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	
		$invalid_response = array('otp'=>'','user_id'=>'');
		$validation = $this->parameterValidation($requiredparameters,$this->post()); 
		
    	if($validation=='valid') {
			// $check_user_exists=$this->user_model->check_user_exists($mobile_number);
			// if($check_user_exists == 0){
			// 	$this->response([
			// 			'status' => 0,
			// 			'msg' => 'User Not exists'
						
			// 	], self::HTTP_OK);
			// 	die;
			// }


      		if(is_numeric($mobile_number)){
				$otp = $this->sms_model->generateNumericOTP(6);	 
				//$otp = '123456';
				//$message = 'Dear customer welcome onboard ! '.$otp.' is your OTP to login your Bznesshub account. Bznesshub';
				/*$sms_sent = $this->sms_model->send_sms($message, $mobile_number);*/
				//$sms_sent = $this->sms_model->send_sms_new($message, $mobile_number);
				//$sms_sent = 'Your Message Has Been Sent';
				
				$country_code = '91';
    				$send_mobile_number = $country_code . $mobile_number;
    				$template_id = '1707176180987228939';
    					$receipents = array(
    						"otp" => $otp
    					);
    					
    					
    				$message = "Dear Customer {1} is the OTP for your login at BznessHub. In case you have not requested this, please contact us at admin@bznesshub.com - BznessHub nBgZvgZ2rsZ"; 
                    $message = str_replace("{1}", $receipents["otp"], $message);
    				
    					$sms_sent = $this->sms_model->send_sms_new($template_id,$send_mobile_number,$message);
				
				if($sms_sent == 'disabled'){
					$this->responses(0,get_phrase('sms_disabled',$language_code),$invalid_response);
				}else if($sms_sent == "Your Message Has Been Sent"){ 
					$this->user_model->save_user_otp($mobile_number,$otp);
					$this->responses(1,get_phrase('sms_sent',$language_code),array('otp'=>$otp,'user_id'=>$mobile_number));
				}else{
					$this->responses(0,get_phrase('sms_failed',$language_code),$invalid_response);
				}
			}else if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code),$invalid_response);
			}else{
				$this->responses(0,get_phrase('mobile_numeric',$language_code),$invalid_response);
			}
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	
	public function send_otp_verify_post(){
	    $requiredparameters = array('language','phone','otp');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$otp  = removeSpecialCharacters($this->post('otp'));
	 	$qouteid  = removeSpecialCharacters($this->post('qouteid'));
	 	$user_password  = removeSpecialCharacters($this->post('user_password'));
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		$invalid_otp_response = array('status' => '');
		$invalid_response = array('user_id' => '','seller_id' => '','wallet_id' => '','refer_code' => '','isseller' => '','name' => '','phone' => '','email' => '','status' => '','profile_pic' => '');
    	if($validation=='valid') {
			$validate_otp = $this->user_model->verify_user_otp($mobile_number,$otp);
			if(!$otp){
				$this->responses(0,get_phrase('otp_mandatory',$language_code),$invalid_otp_response);
			}else if($validate_otp['status'] == 0){
				$this->responses(0,get_phrase('invalid_otp',$language_code),$invalid_otp_response);
			}else if(!$mobile_number){
				$this->responses(0,get_phrase('mobile_mandatory',$language_code),$invalid_response);
			}else if($validate_otp['status'] == 1){
				
				$validate_user = $this->user_model->validate_user_seller_login($mobile_number,$qouteid,$user_password);
				if($validate_user){
					if($validate_user['status'] ==1){
						$this->responses(1,get_phrase('login_successfully',$language_code),$validate_user);
					}else if($validate_user['status'] =='not_exist'){
						$this->responses(0,get_phrase('user_not_exist',$language_code),$invalid_response);
					}else{
						$this->responses(0,get_phrase('user_status_disabled',$language_code),$invalid_response);
					}
					
				}else{
					$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
				}
				
				
				/*$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => 'Verify Otp Successfully',
							$this->config->item('rest_data_field_name') => $invalid_response
							
						], self::HTTP_OK);*/
				
			}else{
				$this->responses(0,get_phrase('invalid_request',$language_code),$invalid_response);
			}
    	}
    	else {
      		echo $validation;
    	}
	}
	
	public function verify_otp_post(){
	    $requiredparameters = array('language','phone','otp','qouteid','user_name');
		
		$language_code = removeSpecialCharacters($this->post('language'));
	 	$mobile_number  = removeSpecialCharacters($this->post('phone'));
	 	$otp  = removeSpecialCharacters($this->post('otp'));
	 	$qouteid  = removeSpecialCharacters($this->post('qouteid'));
	 	$user_name  = removeSpecialCharacters($this->post('user_name'));
	 	$refer_code  = removeSpecialCharacters($this->post('refer_code'));
	 	
		$publickey_server = $this->config->item("encryption_key");
        $encruptfun = new encryptfun();
        $encryptedpassword = $encruptfun->encrypt($publickey_server, $this->post('user_password'));
		$user_password  = $encryptedpassword;
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		$invalid_response = array( "user_id"=> "","seller_id"=> "","wallet_id"=> "","refer_code"=> "","isseller"=> "","name"=> "","fullname"=> "", "address"=> "", "city"=> "","pincode"=> "", "state"=> "", "country"=> "",
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
			/*}else if(!$user_name){
				$this->responses(0,get_phrase('user_name_mandatory',$language_code));*/
			}else if(is_numeric($mobile_number) && $otp){
				$validate_user = $this->user_model->validate_user($mobile_number,$qouteid,$user_name,$refer_code);
				if($validate_user){
					if($validate_user['status'] ==1){
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
	
	public function updateUserProfile_post()
{
    // Required parameters
    $requiredParameters = array('language', 'user_id');

    $language_code = removeSpecialCharacters($this->post('language'));
    $user_id       = removeSpecialCharacters($this->post('user_id'));
    $email         = removeSpecialCharacters($this->post('email'));

    $updateData = [];

    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        //$config['upload_path']   = './media/profile_pictures/';

    	$uploadPath = '/home/u774033453/domains/bznesshub.com/public_html/media/profile_pictures/';
    	//print_r($uploadPath);die;

		// Create folder if it doesn't exist
		if (!is_dir($uploadPath)) {
		    mkdir($uploadPath, 0755, true);
		}

		$config['upload_path'] = $uploadPath;

        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = time() . '_' . $_FILES['profile_pic']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_pic')) {
            $uploadData = $this->upload->data();
            $updateData['profile_pic'] = $uploadData['file_name'];
        } else {
            // Upload failed
            $this->response([
                'status' => 0,
                'msg'    => $this->upload->display_errors(),
                'data'   => []
            ], self::HTTP_OK);
            return; // Stop execution if upload fails
        }
    }

    // Handle email update
    if (!empty($email)) {
        $updateData['email'] = $email;
    }

    // Update database only if there is something to update
    if (!empty($updateData)) {
        $this->db->where('user_unique_id', $user_id);
        $this->db->update('appuser_login', $updateData);
    }

    // Return success response
    $this->response([
        'status' => 1,
        'msg'    => 'Profile updated successfully',
        'data'   => $updateData
    ], self::HTTP_OK);
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
