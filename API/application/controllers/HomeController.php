<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/third_party/encryptfun.php';


class HomeController extends REST_Controller {
	
	protected $request_method ='post'; 
	
		 
	 public function __construct() { 
        parent::__construct();
		require_once APPPATH.'third_party/encryptfun.php';
                
        // Load the user model
        $this->load->model('home_model');
        $this->load->model('sellerProduct_model');
    }
	public function index_get()
	{
		$this->responses(1,'Server OK');
	}
	
	public function generate_invoice_post()
	{

		$requiredparameters = array('language','order_id','product_id');


		$language_code = removeSpecialCharacters($this->post('language'));
		$order_id = removeSpecialCharacters($this->post('order_id'));
		$product_id = removeSpecialCharacters($this->post('product_id'));
		
		$validation = $this->parameterValidation($requiredparameters, $this->post());
		
		if ($validation == 'valid') {
			
			$link = generate_invoice($order_id,$product_id,1);
			if ($link) {

				$this->responses(1, "Generate Invoice", 'https://www.bznesshub.com/media/'.str_replace('../media/','',$link));
			} else {

				$this->responses(0, get_phrase('no_record_found', $language_code),'');
			}

			
		?>
		
		<?php 
			
		} else {
			echo $validation;
		}
	}
	
	public function order_status_data_post()
	{

		$requiredparameters = array('language','order_id','product_id');


		$language_code = removeSpecialCharacters($this->post('language'));
		$order_id = removeSpecialCharacters($this->post('order_id'));
		$product_id = removeSpecialCharacters($this->post('product_id'));
		
		$validation = $this->parameterValidation($requiredparameters, $this->post());
		
		if ($validation == 'valid') {
			
			$product_array = $this->home_model->order_status_data($order_id,$product_id);
			
			if(!empty($product_array)){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => 'Get order Status Sucessfully.',
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					$this->config->item('rest_data_field_name') => array()
					
				], self::HTTP_OK);
			}
			
		} else {
			echo $validation;
		}
	}
	
	public function getPopularProduct_post(){
		$requiredparameters = array('language','pageno','sortby','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->get_popular_product_request($language_code,$pageno,$sortby,$devicetype);
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => '',
					'label' => get_phrase('popular_product',$language_code),
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'label' => get_phrase('popular_product',$language_code),
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	
	public function newarrival_product_post(){
		$requiredparameters = array('language','pageno','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->get_newarrival_product_request($language_code,$pageno,$sortby,$devicetype);
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => '',
					'label' => 'New Products',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'label' => 'New Products',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function high_discount_product_post(){
		$requiredparameters = array('language','pageno','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->get_high_discount_product_request($language_code,$pageno,$sortby,$devicetype);
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => '',
					'label' => '50% off Products',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'label' => '50% off Products',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	
	public function seller_payment_post(){
		$requiredparameters = array('language','seller_id','pageno');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->seller_payment($seller_id,$pageno);
			
			if(!empty($product_array)){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => 'Get Seller Payment Sucessfully.',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => array()
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function seller_order_datewise_post(){
		$requiredparameters = array('language','payment_id');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$payment_id = removeSpecialCharacters($this->post('payment_id'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->seller_order_datewise($payment_id,$seller_id);
			
			if(!empty($product_array)){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => 'Get Seller order Date Wise Sucessfully.',
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					$this->config->item('rest_data_field_name') => array()
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function add_user_token_post(){
		$requiredparameters = array('language','token','user_id','is_seller');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$token = removeSpecialCharacters($this->post('token'));
		$user_id = removeSpecialCharacters($this->post('user_id'));
		$is_seller = removeSpecialCharacters($this->post('is_seller'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->add_user_token($language_code,$token,$user_id,$is_seller);
			
			if($product_array == 'done'){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => 'Add Token Sucessfully.',
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function get_seller_product_post(){
		
		$requiredparameters = array('language','pageno','devicetype','seller_id','sortby');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->get_seller_product($language_code,$pageno,$devicetype,$seller_id,$sortby);
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => 'Get Sucessfully.',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function get_seller_inactive_product_post(){
		
		$requiredparameters = array('language','pageno','devicetype','seller_id','sortby');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->get_seller_inactive_product($language_code,$pageno,$devicetype,$seller_id,$sortby);
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => 'Get Sucessfully.',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function get_seller_product_pending_post(){
		
		$requiredparameters = array('language','pageno','devicetype','seller_id','sortby');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$product_array = $this->home_model->get_seller_product_pending($language_code,$pageno,$devicetype,$seller_id,$sortby);
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => 'Get Sucessfully.',
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function get_seller_product_bycategory_post(){
		
		$requiredparameters = array('language','pageno','devicetype','seller_id','sortby','cat_id');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$cat_id = removeSpecialCharacters($this->post('cat_id'));
		
		$invalid_response = array( "pageno"=> "0");
		$product_array = array();
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
			
			if(!$cat_id){
				$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => 'Category Id Mandatory',
						'pageno' => $pageno,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
			}
			else
			{
				$product_array = $this->home_model->get_seller_product_bycategory($language_code,$pageno,$devicetype,$seller_id,$sortby,$cat_id);
				
				if($product_array){
					$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => 'Get Sucessfully.',
						'pageno' => $pageno,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}else{
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
						'pageno' => $pageno,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function get_seller_product_bybrand_post(){
		
		$requiredparameters = array('language','pageno','devicetype','seller_id','sortby','brand_id');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$brand_id = removeSpecialCharacters($this->post('brand_id'));
		
		$invalid_response = array( "pageno"=> "0");
		$product_array = array();
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
			
			if(!$brand_id){
				$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => 'Brand Id Mandatory',
						'pageno' => $pageno,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
			}
			else
			{
				$product_array = $this->home_model->get_seller_product_bybrand($language_code,$pageno,$devicetype,$seller_id,$sortby,$brand_id);
				
				if($product_array){
					$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => 'Get Sucessfully.',
						'pageno' => $pageno,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}else{
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
						'pageno' => $pageno,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function home_top_category_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$city_array = $this->home_model->home_top_category_request();
			if(count($city_array) >0){

				$this->responses(1,'Shop Our Top Categories',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function check_pincode_post(){

		$requiredparameters = array('language','pincode');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$check_pincode = removeSpecialCharacters($this->post('pincode'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$city_array = $this->home_model->get_check_pincode_request($language_code,$check_pincode);
			if(count($city_array) >0){

				$this->responses(1,'Check Delivery Status',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function withdrow_money_post(){

		$requiredparameters = array('language','user_id','amount');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$user_id = removeSpecialCharacters($this->post('user_id'));		
		$amount = removeSpecialCharacters($this->post('amount'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
		$fail_response = array();

    	if($validation=='valid') {

			 if($user_id && $amount){
			
				$data_array = $this->home_model->withdrow_money_post($user_id,$amount);
				if($data_array == 'done'){

					$this->responses(1,'Withdrow Request Done',$data_array);

				}else{

					$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

				}

			 }else if(!$user_id){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('user_id_mandatory',$language_code),
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			}else if(!$amount){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => 'Amount Value is Empty',
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			}
			 
		
    	}
    	else {
				echo $validation;
    	}

	}


	public function add_wallet_money_post(){
		$requiredparameters = array('amount','user_id','razorpay_payment_id');
		$user_id = removeSpecialCharacters($this->post('user_id'));		
		$amount = removeSpecialCharacters($this->post('amount'));	
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		if($validation!='valid') {
			echo $validation;die;
		}
		$razorpay_payment_id = removeSpecialCharacters($this->post('razorpay_payment_id'));	

		$this->db->select('*');
		$this->db->where(array('user_unique_id' => $user_id));
		$query1 = $this->db->get('appuser_login');
		
		$user_result1 = $query1->result_object()[0];

	    //$wallet_id = 'w_'.$this->random_strings(8);


		$this->db->select('*');
		$this->db->where(array('user_id' => $user_id));
		$query_wallet = $this->db->get('wallet_summery');
		$get_wallet = $query_wallet->result_object()[0];
		$old_amount = $get_wallet->amount;

		$walet_history_upd['amount'] = $old_amount + $amount;
		$wallet_id =$get_wallet->wallet_id;
		$this->db->where(array('user_id'=>$user_id));
		$this->db->update('wallet_summery', $walet_history_upd);
		


		$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');

		$this->db->select('*');
		$this->db->where(array('wallet_id' => $wallet_id));
		$this->db->order_by('id','DESC');
		$this->db->limit(1,0);
		$query_wallet_his = $this->db->get('wallet_transaction_history');

		$old_balance = 0;
		if($query_wallet_his->num_rows() >0){
			$get_wallet = $query_wallet_his->result_object()[0];
		
			$old_balance = $get_wallet->balance;
		}		

		$data_wallet_history1['wallet_id'] = $wallet_id;
		$data_wallet_history1['payment_type'] = 5;
		$data_wallet_history1['transaction_id'] = $transaction_id;
		$data_wallet_history1['transaction_type'] = 'credit';
		$data_wallet_history1['amount'] = $amount;
		$data_wallet_history1['balance'] = $old_balance + $amount;
		$data_wallet_history1['product_id'] = '';
		$data_wallet_history1['order_id'] = '';
		$data_wallet_history1['user_id'] = $user_result1->user_unique_id;
		$data_wallet_history1['remark'] = 'Add Money to your Wallet';
		$data_wallet_history1['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert('wallet_transaction_history',$data_wallet_history1);

		$this->response([
						'status' => 1,
						'msg' => 'Wallet Add money Successfully'
						
		], self::HTTP_OK);


	}
function random_strings($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}
	function random_strings_digit($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}

	
	public function wallet_summery_post(){

		$requiredparameters = array('language','user_id','wallet_id');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$user_id = removeSpecialCharacters($this->post('user_id'));		
		$wallet_id = removeSpecialCharacters($this->post('wallet_id'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
		$fail_response = array();
		$wallet_bonus = 0;

    	if($validation=='valid') {

			 if($user_id && $wallet_id){
			
				$wallet_balance_array = $this->home_model->wallet_total_amount($user_id,$wallet_id);
				$wallet_summary = $this->home_model->wallet_summary($user_id,$wallet_id);
				$wallet_bonus = $this->home_model->bonus_wallet_summery($user_id,$wallet_id);
				$data_array = $this->home_model->wallet_summery($user_id,$wallet_id);
				if(!empty($data_array)){
					
					$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => 'Wallet Summery',
							'wallet' => $wallet_balance_array,
							'wallet_summary' => $wallet_summary,
							'bonus' => $wallet_bonus,
							$this->config->item('rest_data_field_name') =>$data_array
							
						], self::HTTP_OK);

					/*$this->responses(1,'Wallet Summery',$data_array);*/

				}else{

					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
							'wallet' => $wallet_balance_array,
							'wallet_summary' => $wallet_summary,
							'bonus' => $wallet_bonus,
							$this->config->item('rest_data_field_name') =>$data_array
							
						], self::HTTP_OK);
			
					/*$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);*/

				}

			 }else if(!$user_id){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('user_id_mandatory',$language_code),
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			}else if(!$wallet_id){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => 'Wallet Id is Empty',
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			}
			 
		
    	}
    	else {
				echo $validation;
    	}

	}
	
	
	public function add_bank_details_post(){

		$requiredparameters = array('language','user_id');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$user_id = removeSpecialCharacters($this->post('user_id'));		
		$ac_name = removeSpecialCharacters($this->post('ac_name'));		
		$ac_number = removeSpecialCharacters($this->post('ac_number'));		
		$ifsc_code = removeSpecialCharacters($this->post('ifsc_code'));		
		$upi_id = removeSpecialCharacters($this->post('upi_id'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
		$fail_response = array();

    	if($validation=='valid') {

			 if($user_id){
			
				$data_array = $this->home_model->add_bank_details($ac_name,$ac_number,$ifsc_code,$upi_id,$user_id);
				if(!empty($data_array)){

					$this->responses(1,'Add Bank Details Successfully',$data_array);

				}else{

					$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

				}

			 }else if(!$user_id){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('user_id_mandatory',$language_code),
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			
			}
			 
		
    	}
    	else {
				echo $validation;
    	}

	}
	
	public function tree_view_post(){

		$requiredparameters = array('language','user_id');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$user_id = removeSpecialCharacters($this->post('user_id'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
		$fail_response = array();

    	if($validation=='valid') {

			 if($user_id){
			
				$data_array = $this->home_model->tree_view($user_id);
				if(!empty($data_array)){

					$this->responses(1,'Tree View',$data_array);

				}else{

					$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

				}

			 }else if(!$user_id){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('user_id_mandatory',$language_code),
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			
			}
			 
		
    	}
    	else {
				echo $validation;
    	}

	}
	
	public function wallet_summery_datewise_post(){

		$requiredparameters = array('language','user_id','wallet_id');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$user_id = removeSpecialCharacters($this->post('user_id'));		
		$wallet_id = removeSpecialCharacters($this->post('wallet_id'));		
		$title = removeSpecialCharacters($this->post('title'));		
		$start_date = removeSpecialCharacters($this->post('start_date'));		
		$end_date = removeSpecialCharacters($this->post('end_date'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
		$fail_response = array();

    	if($validation=='valid') {

			 if($user_id && $wallet_id){
			
				$wallet_balance_array = $this->home_model->wallet_total_amount($user_id,$wallet_id);
				$wallet_bonus = $this->home_model->bonus_wallet_summery($user_id,$wallet_id);
				$data_array = $this->home_model->wallet_summery_datewise($user_id,$wallet_id,$title,$start_date,$end_date);
				if(!empty($data_array)){

					/*$this->responses(1,'Wallet Summery Date wise',$data_array);*/
					
					$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => 'Wallet Summery Date wise',
							'wallet' => $wallet_balance_array,
							'bonus' => $wallet_bonus,
							$this->config->item('rest_data_field_name') =>$data_array
							
						], self::HTTP_OK);
					
					

				}else{

					/*$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);*/
					
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
							'wallet' => $wallet_balance_array,
							'bonus' => $wallet_bonus,
							$this->config->item('rest_data_field_name') =>$data_array
							
						], self::HTTP_OK);
					
					

				}

			 }else if(!$user_id){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('user_id_mandatory',$language_code),
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			}else if(!$wallet_id){				
					$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => 'Wallet Id is Empty',
							$this->config->item('rest_data_field_name') =>$fail_response
							
						], self::HTTP_OK);
			}
			 
		
    	}
    	else {
				echo $validation;
    	}

	}
	
	
	public function add_seller_product_post(){
		
		$requiredparameters = array('seller_id','prod_name','prod_details','prod_mrp','prod_price','brand','category');
		$category = $_POST['category'];
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$prod_name = removeSpecialCharacters($this->post('prod_name'));
		$prod_sku = removeSpecialCharacters($this->post('prod_sku'));
		$prod_url = removeSpecialCharacters($this->post('prod_url'));
		$prod_short = removeSpecialCharacters($this->post('prod_short'));
		$prod_details = removeSpecialCharacters($this->post('prod_details'));
		$prod_mrp = removeSpecialCharacters($this->post('prod_mrp'));
		$prod_price = removeSpecialCharacters($this->post('prod_price'));
		$selecttaxclass = removeSpecialCharacters($this->post('tax_class'));
		$return_policy = removeSpecialCharacters($this->post('return_policy'));
		$prod_hsn = removeSpecialCharacters($this->post('prod_hsn'));
		$prod_qty = removeSpecialCharacters($this->post('prod_qty'));
		$unit = removeSpecialCharacters($this->post('unit'));
		$material = removeSpecialCharacters($this->post('material'));
		$width = removeSpecialCharacters($this->post('width'));
		$count = removeSpecialCharacters($this->post('count'));
		$mtrs = removeSpecialCharacters($this->post('mtrs'));
		$minorderqty = removeSpecialCharacters($this->post('minorderqty'));
		$prod_youtubeid = removeSpecialCharacters($this->post('product_video_url'));
		if($material == '')
		{
			$material = '';
		}
		if($width == '')
		{
			$width = '';
		}
		if($count == '')
		{
			$count = '';
		}
		if($mtrs == '')
		{
			$mtrs = '';
		}
		if($unit == '')
		{
			$unit = '';
		}
		if($prod_qty == '')
		{
			$prod_qty = 1;
		}
		if($minorderqty == '')
		{
			$minorderqty = '';
		}
		if($prod_youtubeid == '')
		{
			$prod_youtubeid = '';
		}
		$prod_status = removeSpecialCharacters($this->post('status'));
		if($prod_status == '')
		{
			$prod_status = 0;
		}
		$prod_status = 0;
		$selectstock = 'In Stock';
		$selectvisibility = 1;
		$selectcountry = 1;
		$prod_purchase_lmt = 10;
		$selectbrand = removeSpecialCharacters($this->post('brand'));
		$selectseller = $seller_id;
		$prod_remark = '';
		$is_heavy = 0;
		
		$prod_name_ar = '';
		$prod_short_ar = '';
		$prod_details_ar = '';
		
		$selectrelatedprod = '';
		$selectupsell = '';
		
		$invalid_response = array( "status"=> "","seller_id"=> "");
				
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		if($validation=='valid') {
			$validate_user = $this->sellerProduct_model->add_seller_product($seller_id,$category,$prod_name,$prod_sku,$prod_url,$prod_short,$prod_details,$prod_mrp,$prod_price,$selecttaxclass,$prod_qty,$unit,$material,$width,$count,$mtrs,$selectstock,$selectvisibility,$selectcountry,$prod_hsn,$prod_purchase_lmt,$selectbrand,$selectseller,$return_policy,$prod_remark,$prod_youtubeid,$is_heavy,$prod_name_ar,$prod_short_ar,$prod_details_ar,$selectrelatedprod,$selectupsell,$prod_status,$minorderqty,$_FILES);
			if($validate_user){
				if($validate_user['status'] ==1){
					$this->responses(1,'Add Product successfully',$validate_user);
				}else if($validate_user['status'] =='exist'){
						$this->responses(0,'Product already exist',$invalid_response);
				}else{
					$this->responses(0,'user status disabled',$invalid_response);
				}
			}else{
				$this->responses(0,'invalid_request',$invalid_response);
			}
		}
	}
	
	public function add_seller_post()
	{

		$requiredparameters = array('language', 'seller_name', 'business_name', 'business_details', 'business_address', 'gst_number', 'state', 'city', 'pincode', 'phone', 'email', 'password');


		$language_code = removeSpecialCharacters($this->post('language'));
		$seller_name = removeSpecialCharacters($this->post('seller_name'));
		$business_name = removeSpecialCharacters($this->post('business_name'));
		$business_details = removeSpecialCharacters($this->post('business_details'));
		$business_address = removeSpecialCharacters($this->post('business_address'));
		$gst_number = removeSpecialCharacters($this->post('gst_number'));
		$state = removeSpecialCharacters($this->post('state'));
		$city = removeSpecialCharacters($this->post('city'));
		$pincode = removeSpecialCharacters($this->post('pincode'));
		$no_of_products = 0;
		$phone = removeSpecialCharacters($this->post('phone'));
		$email = removeSpecialCharacters($this->post('email'));
		$password = removeSpecialCharacters($this->post('password'));

		$publickey_server = $this->config->item("encryption_key");
		$encruptfun = new encryptfun();
		$encryptedpassword = $encruptfun->encrypt($publickey_server, $password);
		$password  = $encryptedpassword;

		$media_path = '../media/';

		$pan_card = '';
		if (strlen($_FILES['pan_card']['name']) > 1) {
			$pan_card = file_upload('pan_card', $media_path);
		}

		$aadhar_card = '';
		if (strlen($_FILES['aadhar_card']['name']) > 1) {
			$aadhar_card = file_upload('aadhar_card', $media_path);
		}

		$business_proof = '';
		if (strlen($_FILES['business_proof']['name']) > 1) {
			$business_proof = file_upload('business_proof', $media_path);
		}
		
		
		$seller_type = $_POST['seller_type'];
		if($seller_type == 'Street Merchant')
		{
			$plan_id = $_POST['selectplan'];
		}
		else
		{
			$plan_id = $_POST['selectplan'];
		}
		$refer_code = $_POST['refer_code'];
		$plan_value = $_POST['plan_value'];
		$payment_id = $_POST['payment_id'];

		$validation = $this->parameterValidation($requiredparameters, $this->post());

		if ($validation == 'valid') {
			$about_array = $this->home_model->add_seller($seller_name, $business_name, $business_details, $business_address, $gst_number, $state, $city, $pincode,$no_of_products, $phone, $email, $password, $pan_card, $aadhar_card, $business_proof,$seller_type,$plan_id,$refer_code,$payment_id);

			if (!empty($about_array)) {

				$this->responses(1, 'Add Seller', $about_array);
			} else {

				$this->responses(0, get_phrase('no_record_found', $language_code), $about_array);
			}
		} else {
			echo $validation;
		}
	}
	
	
	public function update_seller_product_post(){
		
		$requiredparameters = array('seller_id','product_id','prod_name','prod_details','prod_mrp','prod_price','brand','category','prod_active');
		
		
		$category = removeSpecialCharacters($this->post('category'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$product_id = removeSpecialCharacters($this->post('product_id'));
		$prod_name = removeSpecialCharacters($this->post('prod_name'));
		$prod_details = removeSpecialCharacters($this->post('prod_details'));
		$prod_mrp = removeSpecialCharacters($this->post('prod_mrp'));
		$prod_price = removeSpecialCharacters($this->post('prod_price'));
		$selectbrand = removeSpecialCharacters($this->post('brand'));
		$prod_active = removeSpecialCharacters($this->post('prod_active')); 
		$selecttaxclass = removeSpecialCharacters($this->post('tax_class'));
		
		
		$product_video_url = removeSpecialCharacters($this->post('product_video_url'));
		$in_stock = removeSpecialCharacters($this->post('in_stock'));
		$prod_qty = removeSpecialCharacters($this->post('prod_qty'));
		
		$invalid_response = array( "status"=> "","seller_id"=> "");
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		if($validation=='valid') {
		/*if($seller_id && $prod_name && $prod_details && $prod_mrp && $prod_price && $brand && $category){*/
			
			$validate_user = $this->sellerProduct_model->update_seller_product($seller_id,$product_id,$prod_name,$prod_details,$prod_active,$prod_mrp,$prod_price,$selectbrand,$category,$product_video_url,$in_stock,$prod_qty,$selecttaxclass,$_FILES);
			if($validate_user){
				if($validate_user['status'] ==1){
					$this->responses(1,'Update Product successfully',$validate_user);
				}else if($validate_user['status'] =='notexist'){
						$this->responses(0,'Product Not exist',$invalid_response);
				}else{
					$this->responses(0,'user status disabled',$invalid_response);
				}
			}else{
				$this->responses(0,'invalid_request',$invalid_response);
			}
		}
	}
	
	public function delete_product_post()
	{
		$requiredparameters = array('language', 'devicetype', 'prod_id');

		$language_code = removeSpecialCharacters($this->post('language'));
		$prod_id = removeSpecialCharacters($this->post('prod_id'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));



		$validation = $this->parameterValidation($requiredparameters, $this->post());

		$seller_product_array = array();
		if ($validation == 'valid') {

			if ($prod_id) {

				$user = $this->home_model->delete_product($prod_id);
				if ($user == 'delete') {
					$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => 'Delete Product Successfully',
						$this->config->item('rest_data_field_name') => $seller_product_array

					], self::HTTP_OK);
				} else {
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found', $language_code),
						$this->config->item('rest_data_field_name') => $seller_product_array

					], self::HTTP_OK);
				}
			}
		} else {
			echo $validation;
		}
	}
	
	public function add_exising_product_post(){
		
		$requiredparameters = array('seller_id','product_id','prod_name','prod_details','prod_mrp','prod_price','brand','category','prod_active');
		
		$category = removeSpecialCharacters($this->post('category'));
		$seller_id = removeSpecialCharacters($this->post('seller_id'));
		$product_id = removeSpecialCharacters($this->post('product_id'));
		$prod_name = removeSpecialCharacters($this->post('prod_name'));
		$prod_details = removeSpecialCharacters($this->post('prod_details'));
		$prod_mrp = removeSpecialCharacters($this->post('prod_mrp'));
		$prod_price = removeSpecialCharacters($this->post('prod_price'));
		$selectbrand = removeSpecialCharacters($this->post('brand'));
		$prod_active = removeSpecialCharacters($this->post('prod_active'));
		$tax_class = removeSpecialCharacters($this->post('tax_class'));
		$product_purchase_limit = removeSpecialCharacters($this->post('product_purchase_limit'));
		
		
		$product_video_url = removeSpecialCharacters($this->post('product_video_url'));
		$in_stock = removeSpecialCharacters($this->post('in_stock'));
		$prod_qty = removeSpecialCharacters($this->post('prod_qty'));
		
		$invalid_response = array( "status"=> "","seller_id"=> "");
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		if($validation=='valid') {
		/*if($seller_id && $prod_name && $prod_details && $prod_mrp && $prod_price && $brand && $category){*/
			
			$validate_user = $this->sellerProduct_model->add_exising_product($seller_id,$product_id,$prod_name,$prod_details,$prod_active,$prod_mrp,$prod_price,$selectbrand,$category,$product_video_url,$in_stock,$prod_qty,$tax_class,$product_purchase_limit,$_FILES);
			if($validate_user){
				if($validate_user['status'] ==1){
					$this->responses(1,'Add Product successfully',$validate_user);
				}else if($validate_user['status'] =='notexist'){
						$this->responses(0,'Product Not exist',$invalid_response);
				}else if($validate_user['status'] =='exist'){
						$this->responses(0,'Product already exist in Your Account',$invalid_response);
				}else{
					$this->responses(0,'user status disabled',$invalid_response);
				}
			}else{
				$this->responses(0,'invalid_request',$invalid_response);
			}
		}
	}
	
	public function signup_post(){
		$requiredparameters = array('seller_name','business_name','website','business_address','business_details','country','state','city','pincode','phone','email','password','plan_id');
		$seller_name = removeSpecialCharacters($this->post('seller_name'));
	 	$business_name  = removeSpecialCharacters($this->post('business_name'));
	 	$website  = removeSpecialCharacters($this->post('website'));
	 	$business_address  = removeSpecialCharacters($this->post('business_address'));
		$business_details  = removeSpecialCharacters($this->post('business_details'));
		$country  = removeSpecialCharacters($this->post('country'));
		$state  = removeSpecialCharacters($this->post('state'));
		$city  = removeSpecialCharacters($this->post('city'));
		$pincode  = removeSpecialCharacters($this->post('pincode'));
		$phone  = removeSpecialCharacters($this->post('phone'));
		$email  = removeSpecialCharacters($this->post('email'));
		$passwords  = removeSpecialCharacters($this->post('password'));
		$seller_logo  = removeSpecialCharacters($this->post('seller_logo'));
		$plan_id  = removeSpecialCharacters($this->post('plan_id'));
		$refer_code  = removeSpecialCharacters($this->post('refer_code'));
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
		$publickey_server = $this->config->item("encryption_key");
        $encruptfun = new encryptfun();
        $encryptedpassword = $encruptfun->encrypt($publickey_server, $this->post('password'));
		$passwords  = $encryptedpassword;
		
		
		$store_array = $this->home_model->get_storesetting_request('1');
		
		$promote_refer_code = $store_array[0]['promote_refer_code'];
		
		
		$invalid_response = array( "status"=> "","seller_id"=> "");
		
 		if($seller_name && $business_name){
			/*$doc_array = $this->sellerProduct_model->save_documents_details($_FILES, $seller_logo );
				if($doc_array){
					$this->responses(1,get_phrase('document_save_successfully',$language_code),array());
				}else{
					$this->responses(0, get_phrase('invalid_request',$language_code),$invalid_response);
				}*/
			$validate_user = $this->sellerProduct_model->seller_signup($seller_name,$business_name,$website,$business_address,$business_details,$country,$state,$city,$pincode,$phone,$email,$passwords,$plan_id,$refer_code,$promote_refer_code,$_FILES);
			if($validate_user){
				if($validate_user['status'] ==1){
					$this->responses(1,'Register successfully',$validate_user);
				}else if($validate_user['status'] =='exist'){
						$this->responses(0,'phone already exist',$invalid_response);
				}else{
					$this->responses(0,'user status disabled',$invalid_response);
				}
			}else{
				$this->responses(0,'invalid_request',$invalid_response);
			}
		}
	}
	
	public function home_all_data_post(){
	
	$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

		$main_array = array();
    	if($validation=='valid') {
	
			$top_slider_array = $this->home_model->get_header_banner_request('section1','1920-680');
				$main_array[0] = [
					'index' => '1',
					'label' => 'Top Slider',
					'data_banner' => $top_slider_array,
					'data_product' => array()
					
				];
				
			$top_banner_array = $this->home_model->get_header_banner_request('section6','1900-320');

				$main_array[1] = [
					'index' => '2',
					'label' => 'Top Banner',
					'data_banner' => $top_banner_array,
					'data_product' => array()
					
				];
				
			$today_deals_array = $this->home_model->get_home_products($language_code,'New');
			
			$main_array[2] = [
					'index' => '3',
					'label' => "Today's Deal",
					'data_banner' => array(),
					'data_product' => $today_deals_array
					
				];
				
			$top_selling_banner_array = $this->home_model->get_header_banner_request('section4','1930-150');
			
			$main_array[3] = [
					'index' => '4',
					'label' => "Top Selling Banner",
					'data_banner' => $top_selling_banner_array,
					'data_product' => array()
					
				];
			
			$top_selling_product_array = $this->home_model->get_home_products($language_code,'Popular');	
			
			$main_array[4] = [
					'index' => '5',
					'label' => "Top Selling Products",
					'data_banner' => array(),
					'data_product' => $top_selling_product_array
					
				];
				
			$trendind_banner_array = $this->home_model->get_header_banner_request('section10','1900-320');
			
			$main_array[5] = [
					'index' => '6',
					'label' => "Trending Products Banner",
					'data_banner' => $trendind_banner_array,
					'data_product' => array()
					
				];
				
			$this->responses(1,'All data',$main_array);
			
		}
    	else {
				echo $validation;
    	}
	
	}
	
	public function home_all_data2_post(){
	
	$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

		$main_array = array();
    	if($validation=='valid') {
	
	
			$trending_products_array = $this->home_model->get_home_products($language_code,'Recommended');
				$main_array[0] = [
					'index' => '1',
					'label' => "Trending Products",
					'data_banner' => array(),
					'data_product' => $trending_products_array
				];
				
			$three_banner_array = $this->home_model->get_header_banner_request('section8','610-400');
			$main_array[1] = [
					'index' => '2',
					'label' => '1*2 Banner',
					'data_banner' => $three_banner_array,
					'data_product' => array()
					
				];
				
			$like_array = $this->home_model->get_home_products($language_code,'Offers');
				$main_array[2] = [
					'index' => '3',
					'label' => "You May Like Products",
					'data_banner' => array(),
					'data_product' => $like_array
				];
				
			$populor_array = $this->home_model->get_header_banner_request('section11','1900-320');
			$main_array[3] = [
					'index' => '4',
					'label' => 'Most Popular Banner',
					'data_banner' => $populor_array,
					'data_product' => array()
				];
				
			$populor_products_array = $this->home_model->get_home_products($language_code,'Most');
				$main_array[4] = [
					'index' => '5',
					'label' => "Most Popular Products",
					'data_banner' => array(),
					'data_product' => $populor_products_array
				];
				
			$custom_array = $this->home_model->get_header_banner_request('section12','1900-320');
			$main_array[5] = [
					'index' => '6',
					'label' => 'Customize Your Clothing Banner',
					'data_banner' => $custom_array,
					'data_product' => array()
				];
				
			$custom_product_array = $this->home_model->get_home_products($language_code,'Custom');
				$main_array[6] = [
					'index' => '7',
					'label' => "Customize Your Clothing Products",
					'data_banner' => array(),
					'data_product' => $custom_product_array
				];
				
				
			$this->responses(1,'All data 2',$main_array);
			
		}
    	else {
				echo $validation;
    	}
	
	}
	
	public function home_top_slider_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$city_array = $this->home_model->get_header_banner_request('section1','1920-680');
			if(count($city_array) >0){

				$this->responses(1,'Top Slider',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_top_banner_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$city_array = $this->home_model->get_header_banner_request('section6','1900-320');
			if(count($city_array) >0){

				$this->responses(1,'Top Banner',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function seller_dashboard_post(){

		$requiredparameters = array('seller_id');

		$seller_id = removeSpecialCharacters($this->post('seller_id'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

			$data_array = $this->home_model->seller_dashboard($seller_id);
			if(count($data_array) >0){

				$this->responses(1,"Seller Dashboard Data",$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function seller_active_check_post(){

		$requiredparameters = array('user_id','seller_id');

		$user_id = removeSpecialCharacters($this->post('user_id'));		
		$seller_id = removeSpecialCharacters($this->post('seller_id'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

			$data_array = $this->home_model->seller_active_check($user_id,$seller_id);
			if(count($data_array) >0){

				$this->responses(1,"Seller Active",$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function recent_view_product_post(){

		$requiredparameters = array('language','product_id');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$product_id = removeSpecialCharacters($this->post('product_id'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

			$data_array = $this->home_model->get_recent_products_request($language_code,2,$product_id);
			if(count($data_array) >0){

				$this->responses(1,"Recent Products",$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	
	public function home_today_deal_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_home_products($language_code,'New');
			if(count($data_array) >0){

				$this->responses(1,"Today's Deal",$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_top_selling_banner_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_header_banner_request('section4','1930-150');
			if(count($data_array) >0){

				$this->responses(1,'Top Selling',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_top_selling_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_home_products($language_code,'Popular');
			if(count($data_array) >0){

				$this->responses(1,'Top Selling',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_trending_products_banner_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_header_banner_request('section10','1900-320');
			if(count($data_array) >0){

				$this->responses(1,'Trending Products',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_trending_products_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_home_products($language_code,'Recommended');
			if(count($data_array) >0){

				$this->responses(1,'Trending Products',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_three_banner_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_header_banner_request('section8','610-400');
			if(count($data_array) >0){

				$this->responses(1,'1*2 Banner',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_you_may_like_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_home_products($language_code,'Offers');
			if(count($data_array) >0){

				$this->responses(1,'You May Like',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_most_populor_banner_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_header_banner_request('section11','1900-320');
			if(count($data_array) >0){

				$this->responses(1,'Most Popular',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_most_populor_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_home_products($language_code,'Most');
			if(count($data_array) >0){

				$this->responses(1,'Most Popular',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation; 
    	}

	}
	
	
	public function home_customize_clothing_banner_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_header_banner_request('section12','1900-320');
			if(count($data_array) >0){

				$this->responses(1,'Customize Your Clothing',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation;
    	}

	}
	
	public function home_customize_clothing_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {

      		$data_array = $this->home_model->get_home_products($language_code,'Custom');
			if(count($data_array) >0){

				$this->responses(1,'Customize Your Clothing',$data_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$data_array);

			}

    	}
    	else {
				echo $validation; 
    	}

	}
	
	public function bannerClick_post()
	{
		$language = $this->post('language');
		$type = $this->post('type');
		$sku = $this->post('sku');

		if ($type == 'product') {
			$this->load->model('product_model');
			$prod_details = $this->db->get_where('product_details', array('web_url' => $sku))->row_array();
			$product_array = $this->product_model->get_product_request($language, $prod_details['product_unique_id'], $prod_details['product_sku']);
			$this->response([
				$this->config->item('rest_status_field_name') => 1,
				'msg' => 'Get data successfully',
				$this->config->item('rest_data_field_name') => $product_array
			], self::HTTP_OK);
		} elseif ($type == 'shop') {
			$cat_details = $this->db->get_where('category', array('cat_slug' => $sku))->row_array();
			$this->load->model('categoryProduct_model');
			$sub_categories = $this->db->get_where('category', array('parent_id' => $cat_details['cat_id'], 'status' => '1'))->result_array();
			foreach ($sub_categories as &$sub_category) {
				$sub_category['cat_img'] = UPLOAD_URL . $sub_category['cat_img'];
			}
			$product_array = $this->categoryProduct_model->get_category_product_request_banner($language, $cat_details['cat_id']);
			if ($product_array) {
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => '',
					'cat_id' => $cat_details['cat_id'],
					'cat_name' => $cat_details['cat_name'],
					'pageno' => 0,
					'sub_cat' => $sub_categories,
					'sub_product' => $product_array['product_array'],
					'total_pages' => $product_array['total_pages']

				], self::HTTP_OK);
			} else {
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found', $language),
					'pageno' => 0,
					'cat_id' => $cat_details['cat_id'],
					'cat_name' => $cat_details['cat_name'],
					'sub_cat' => $sub_categories,
					'sub_product' => [],
					'total_pages' => 0

				], self::HTTP_OK);
			}
		} elseif ($type == 'brand') {
			$this->load->model('brand_model');
			$product_array = $this->brand_model->get_brand_product_request($language, $sku);
			if ($product_array) {
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => '',
					'pageno' => 0,
					'total_pages' => $product_array['total_pages'],
					$this->config->item('rest_data_field_name') => $product_array['product_array']

				], self::HTTP_OK);
			} else {
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found', $language),
					'pageno' => 0,
					'total_pages' => $product_array['total_pages'],
					$this->config->item('rest_data_field_name') => $product_array['product_array']

				], self::HTTP_OK);
			}
		} else {
			$this->response([
				$this->config->item('rest_status_field_name') => 1,
				'msg' => 'No record found',
				$this->config->item('rest_data_field_name') => []
			], self::HTTP_OK);
		}
	}
	
	public function customize_clothing_products_post(){

		$requiredparameters = array('language','catid','pageno','sortby','devicetype','config_attr');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$cat_id = removeSpecialCharacters($this->post('catid'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$config_attr = removeSpecialCharacters($this->post('config_attr'));
		
		
		$category_result = array();
		$category_array = $this->home_model->get_subcategory_request($language_code,$category_result,$cat_id,1);
		$catid_array = array('10');
		if(count($category_array) >0){
			
			foreach($category_array as $cat_ids){
				$catid_array[] = $cat_ids['id'];
			}
		}
		
		$exolore_category_product = array();
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());

    	if($validation=='valid') {
			
			$exolore_category_product['category'] = $this->home_model->get_explore_category_request(2,$devicetype,$cat_id);
			$exolore_category_product['product'] = $this->home_model->get_category_product_request($language_code,$catid_array,$pageno,$sortby,$devicetype,$config_attr);
		
			if(count($exolore_category_product) >0){

				$this->responses(1,'Customize Your Own Clothing',$exolore_category_product);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$exolore_category_product);

			}

    	}
    	else {
				echo $validation; 
    	}

	}
	
	
	public function deliveryboy_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		

    	if($validation=='valid') {

      		$deliveryboy_array = $this->home_model->deliveryboy_list_request();
			if(count($deliveryboy_array) >0){

				$this->responses(1,'Deliveryboy List',$deliveryboy_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$deliveryboy_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	public function city_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		

    	if($validation=='valid') {

      		$city_array = $this->home_model->city_list_request();
			if(count($city_array) >0){

				$this->responses(1,'City List',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	public function state_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		

    	if($validation=='valid') {

      		$city_array = $this->home_model->state_list_request();
			if(count($city_array) >0){

				$this->responses(1,'State List',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	public function plan_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		

    	if($validation=='valid') {

      		$plan_array = $this->home_model->plan_list_request(); 
			if(count($plan_array) >0){

				$this->responses(1,'Plan List',$plan_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$plan_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	public function single_plan_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		

    	if($validation=='valid') {

      		$plan_array = $this->home_model->single_plan_list_request(); 
			if(count($plan_array) >0){

				$this->responses(1,'Plan List',$plan_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$plan_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	
	public function hsn_code_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		

    	if($validation=='valid') {

      		$city_array = $this->home_model->hsn_code_list_request();
			if(count($city_array) >0){

				$this->responses(1,'HSN Code List',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	public function return_policy_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		

    	if($validation=='valid') {

      		$city_array = $this->home_model->return_policy_list_request();
			if(count($city_array) >0){

				$this->responses(1,'Return Policy List',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	public function tax_list_post(){

		$requiredparameters = array('language');

		$language_code = removeSpecialCharacters($this->post('language'));		


		$validation = $this->parameterValidation($requiredparameters,$this->post());

		
		$city_array = array();
    	if($validation=='valid') {

      		$city_array = $this->home_model->tax_list_request();
			if(count($city_array) >0){

				$this->responses(1,'Tax List',$city_array);

			}else{

				$this->responses(0,get_phrase('no_record_found',$language_code),$city_array);

			}

			

    	}

    	else {

      		echo $validation;

    	}

		

	}
	
	public function get_offers_post(){
		$requiredparameters = array('language','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		// $product_array = $this->home_model->get_offers_product_request($language_code,'Offers');
      		$product_array = $this->home_model->get_home_products($language_code,'home_bottom');
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => '',
					'label' => 'Offers',
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}else{
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'label' => 'Offers',
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}


	public function getnotification_post(){
		$requiredparameters = array('language','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$seller_array = $this->home_model->getnotification_request($devicetype);
			
			if(count($seller_array) >0){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					'msg' => 'Get Notification Successfully',
					$this->config->item('rest_data_field_name') => $seller_array
						
				], self::HTTP_OK);
			}else{
				$this->responses(0,get_phrase('no_record_found',$language_code),$seller_array);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function getnotification_newpost_post(){
		$requiredparameters = array('language','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$seller_array = $this->home_model->getnotification_newpost_request($devicetype);
			
			if(count($seller_array) >0){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					'msg' => 'Get Notification Successfully',
					$this->config->item('rest_data_field_name') => $seller_array
						
				], self::HTTP_OK);
			}else{
				$this->responses(0,get_phrase('no_record_found',$language_code),$seller_array);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}

	public function get_coupon_code_post(){
		$requiredparameters = array('language','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
      		$seller_array = $this->home_model->get_vendor_coupon();
			
			if(count($seller_array) >0){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					'msg' => 'Get Offers Successfully',
					$this->config->item('rest_data_field_name') => $seller_array
						
				], self::HTTP_OK);
			}else{
				$this->responses(0,get_phrase('no_record_found',$language_code),$seller_array);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	//searh product
	
	public function search_post(){
		$requiredparameters = array('language','search','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$search = removeSpecialCharacters($this->post('search'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		
    	if($validation=='valid') {
			if($search){
				$product_array = $this->home_model->get_search_product_request($language_code,$search,$devicetype);
				
				if($product_array){
					$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => 'search data',
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}else{
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}
			}else{
				$product_array= array();
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('search_mandotary',$language_code),
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}			
	
	public function search_sponsor_post(){
		$requiredparameters = array('language','search','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$search = removeSpecialCharacters($this->post('search'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
			if($search){
				$product_array = $this->home_model->get_search_sponsor_product_request($language_code,$search,$devicetype);
				
				if($product_array){
					$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => '',
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}else{
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}
			}else{
				$product_array= array();
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('search_mandotary',$language_code),
					$this->config->item('rest_data_field_name') => $product_array
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	
	public function get_app_update_post(){
		$res = array('appversion' => 3, 'date' => '17-12-2022', 'contactus' => '9856323333','whatsapp'=>'8563254444');
				$this->response([
							$this->config->item('rest_status_field_name') => 1,
						    $this->config->item('rest_message_field_name') => 'Please Update The APP',
							'forcelogout' => true,
							'logoutversion' => 3,
							$this->config->item('rest_data_field_name') => $res
							
						], self::HTTP_OK);
	}

	public function get_storesetting_post(){
		$requiredparameters = array('language','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$user_id = removeSpecialCharacters($this->post('user_id'));
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		$seller_array = $this->home_model->get_storesetting_request($devicetype);
			
			
			if($seller_array){
				$seller_array = array("name"=> $seller_array[0]['name'],"phone"=> $seller_array[0]['phone'],"email_1"=> $seller_array[0]['email_1'],"email_2"=> $seller_array[0]['email_2'],"whatsapp" => '+91'.$seller_array[0]['whatsapp']);
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					'msg' => 'Get Settings Successfully',
					$this->config->item('rest_data_field_name') => $seller_array
						
				], self::HTTP_OK);
			}else{
				$seller_array = array("name"=> '',"phone"=> '',"email_1"=> '',"email_2"=> '',"whatsapp" => '');
				$this->responses(0,get_phrase('no_record_found',$language_code),$seller_array);
			}
			
    	}
    	else {
      		echo $validation; 
    	}
		
	}
	
  

}
