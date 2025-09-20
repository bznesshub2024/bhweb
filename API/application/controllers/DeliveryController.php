<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class DeliveryController extends REST_Controller {
	
	protected $request_method ='post'; 
	
		 
	 public function __construct() { 
        parent::__construct();
                
        // Load the user model
        $this->load->model('delivery_model');
    }
	public function index_get()
	{
		$this->responses(1,'Server OK');
	}
	
	public function get_delivery_city_post(){
		$requiredparameters = array('language');
		
		$language_code = removeSpecialCharacters($this->post('language'));		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		$delivery_array = $this->delivery_model->get_delivery_city_request();
			
			if(count($delivery_array) >0){
				$this->responses(1,'delivery_city',$delivery_array);
			}else{
				$this->responses(0,get_phrase('no_record_found',$language_code),$delivery_array);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	public function delivery_city_details_post(){
		$requiredparameters = array('language','city_id');
		
		$language_code = removeSpecialCharacters($this->post('language'));		
		$city_id = removeSpecialCharacters($this->post('city_id'));		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
			if($city_id){
				$delivery_array = $this->delivery_model->get_delivery_city_details_request($city_id);
				
				if(count($delivery_array) >0){
					$this->responses(1,'delivery_city',$delivery_array);
				}else{
					$this->responses(0,get_phrase('no_record_found',$language_code),$delivery_array);
				}
			}else{
				$delivery_array = array('basic_fee'=>'','order_value'=>'','big_item_fee'=>'','estimated_delivery_time'=>'','prime_delivery_time'=>'');
				$this->responses(0,get_phrase('city_mandatory',$language_code),$delivery_array);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	


}
