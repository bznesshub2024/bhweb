<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class BrandController extends REST_Controller {
	
	protected $request_method ='post'; 
	
		 
	 public function __construct() { 
        parent::__construct();
                
        // Load the brand model
        $this->load->model('brand_model');
        $this->load->model('product_model');
		
    }
	public function index_get()
	{
		$this->responses(1,'Server OK');
	}

	public function all_brand_get()
	{
		$this->load->model('cart_model');
		$default_language = $this->session->userdata("default_language");
		$this->data['brand'] = $this->brand_model->get_brand_request($default_language,2);
		$this->load->view('website/brand.php',$this->data);  // ye view/website folder hai
	}

	public function brand_product_get($brand_id)
	{
		$default_language = $this->session->userdata("default_language");
		$this->data['brand_product'] = $this->brand_model->get_brand_product_request($default_language,$brand_id,'','',2);
		$this->data['brand_id'] = $brand_id;
		$this->data['product_short_by'] = $this->product_model->get_product_sortby($default_language);
		$this->load->view('website/brand_product.php',$this->data); 
	}
	
	public function getBrand_post(){
		$requiredparameters = array('language','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		$default_language = $this->session->userdata("default_language");
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		$brand_array = $this->brand_model->get_brand_request($default_language,$devicetype);
			
			if(count($brand_array) >0){
				$this->responses(1,get_phrase('brand_results',$language_code),$brand_array);
			}else{
				$this->responses(0,get_phrase('no_record_found',$language_code),$brand_array);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	
	public function getBrandProduct_post(){
		$requiredparameters = array('language','brand_id','pageno','sortby','devicetype');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$brand_id = removeSpecialCharacters($this->post('brand_id'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		
		$default_language = $this->session->userdata("default_language");
		
		$validation = $this->parameterValidation($requiredparameters,$this->post()); //$this->post() holds post values
		
    	if($validation=='valid') {
      		$product_array = $this->brand_model->get_brand_product_request($default_language,$brand_id,$pageno,$sortby,$devicetype);
			
			if($product_array){
				$this->response([
					$this->config->item('rest_status_field_name') => 1,
					$this->config->item('rest_message_field_name') => get_phrase('brand_product',$language_code),
					'pageno' => ($pageno+1),
					'total_product' => $product_array['total_count'],
					$this->config->item('rest_data_field_name') => $product_array['product_array']
					
				], self::HTTP_OK);
			}else{
				
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
					'pageno' => ($pageno+1),
					'total_product' => 0,
					$this->config->item('rest_data_field_name') => $product_array['product_array']
					
				], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation; //These are parameters are missing.
    	}
		
	}
	
	
	
	
	
  

}
