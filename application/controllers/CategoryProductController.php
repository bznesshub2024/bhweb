<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class CategoryProductController extends REST_Controller {
		 
	 public function __construct() { 
        parent::__construct();
                
        // Load the user model
        $this->load->model('categoryProduct_model');
		$this->load->model('product_model');
    }
	public function index_get($cat_slug)
	{
		$default_language = $this->session->userdata("default_language");
		$this->data['cat_details'] = $this->categoryProduct_model->get_category_details($default_language,$cat_slug);
		$this->data['product_custom_cloth'] = $this->categoryProduct_model->get_product_custom_cloth_with_cat($this->data['cat_details']->cat_id);
		if(!$this->data['cat_details']){
			redirect('/404', 'refresh');
		}
		
		$this->data['cat_slags'] = $this->categoryProduct_model->get_category_details($default_language,$cat_slug);
				
		$main_cat1 = $this->categoryProduct_model->get_sub_category_request($this->data['cat_details']->cat_id);
				if(!empty($main_cat1))
				{
					$main_cat2 = $this->categoryProduct_model->get_sub_category_request($main_cat1);
				}
				else
				{
					$main_cat2 = array();
				}
				$main_cat = array_merge($main_cat1,$main_cat2);
		
		
		if(!empty($main_cat))
		{
			$this->data['product_filter'] = $this->product_model->get_product_filter($main_cat)['attribute_array'];
			$this->data['brand_filter'] = $this->product_model->get_product_filter($main_cat)['brand_array'];
			$this->data['price_filter'] = $this->product_model->get_product_filter($main_cat)['price_filter'];
		}	
		else
		{
			$this->data['product_filter'] = $this->product_model->get_product_filter($this->data['cat_slags']->cat_id)['attribute_array'];
			$this->data['brand_filter'] = $this->product_model->get_product_filter($this->data['cat_slags']->cat_id)['brand_array'];
			$this->data['price_filter'] = $this->product_model->get_product_filter($this->data['cat_slags']->cat_id)['price_filter'];
		}
		
		//$this->data['product_filter'] = $this->product_model->get_product_filter($this->data['cat_slags']->cat_id);
		$this->data['product_short_by'] = $this->product_model->get_product_sortby($default_language);
		
		
		/*$filters = $this->categoryProduct_model->get_product_filter($this->data['cat_details']->cat_id);
		$this->data['product_filter'] =  $filters;
		$this->data['brand_filter'] =  $filters['brand_array'];
		$this->data['price_filter'] = $filters['price_filter'];*/
		
		$this->load->view('website/productFilter.php',$this->data);  // ye view/website folder hai
	}
	
	function get_category_product_post()
	{
		$catid = $this->input->post('catid');
		$sortby = $this->input->post('sortby');
		$pageno = $this->input->post('pageno');
		$response = $this->categoryProduct_model->get_category_product_request($catid,$pageno,$sortby,1);
		
		echo json_encode($response);
	}
	
	public function getCategoryProduct_post(){
		$requiredparameters = array('language','catid','pageno','sortby','devicetype','config_attr');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$catid = removeSpecialCharacters($this->post('catid'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$config_attr = removeSpecialCharacters($this->post('config_attr'));
		$config_brand = removeSpecialCharacters($this->post('config_brand'));
		$min_price = removeSpecialCharacters($this->post('min_price'));
		$max_price = removeSpecialCharacters($this->post('max_price'));
		$rating = removeSpecialCharacters($this->post('rating'));

		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		$product_count =0;
		$product_array = array();
    	if($validation=='valid') {
			if($catid){
				
				$main_cat1 = $this->categoryProduct_model->get_sub_category_request($catid);
				if(!empty($main_cat1))
				{
					$main_cat2 = $this->categoryProduct_model->get_sub_category_request($main_cat1);
				}
				else
				{
					$main_cat2 = array();
				}
				$main_cat = array_merge($main_cat1,$main_cat2);
				if(!empty($main_cat))
				{
					$product_array = $this->categoryProduct_model->get_category_product_request($language_code,$main_cat,$pageno,$sortby,$devicetype,$config_attr,$config_brand,$min_price,$max_price,$rating);
				}
				else
				{
					$product_array = $this->categoryProduct_model->get_category_product_request($language_code,$catid,$pageno,$sortby,$devicetype,$config_attr,$config_brand,$min_price,$max_price,$rating);
				}
				
				
				//$product_array = $this->categoryProduct_model->get_category_product_request($language_code,$catid,$pageno,$sortby,$devicetype,$config_attr);
				
				
				if($product_array =='invalid_filter'){
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('invalid_filter',$language_code),
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}else if($product_array){
					
					
					if(!empty($main_cat))
					{
						$product_count = $this->categoryProduct_model->get_category_product_count($main_cat,$pageno,$sortby,$devicetype,$config_attr);
					}
					else
					{
						$product_count = $this->categoryProduct_model->get_category_product_count($catid,$pageno,$sortby,$devicetype,$config_attr);
						
					}
					
					
					//$product_count = $this->categoryProduct_model->get_category_product_count($catid,$pageno,$sortby,$devicetype,$config_attr);
				
					$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => '',
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						'total_products' => $product_array['total_products'],
						$this->config->item('rest_data_field_name') => $product_array['product_array']
						
					], self::HTTP_OK);
				}else{
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}
			}else if(!$catid){
				$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('category_id_mandatory',$language_code),
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
	public function getCategorysponsorProduct_post(){
		$requiredparameters = array('language','catid','pageno','sortby','devicetype','config_attr');
		
		$language_code = removeSpecialCharacters($this->post('language'));
		$catid = removeSpecialCharacters($this->post('catid'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));
		$config_attr = removeSpecialCharacters($this->post('config_attr'));
		
		
		
		$validation = $this->parameterValidation($requiredparameters,$this->post());
		$product_count =0;
		$product_array = array();
    	if($validation=='valid') {
			if($catid){
				$product_array = $this->categoryProduct_model->get_category_sponsor_product_request($language_code,$catid,$pageno,$sortby,$devicetype,$config_attr);
				
				if($product_array =='invalid_filter'){
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('invalid_filter',$language_code),
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}else if($product_array){
					$product_count = $this->categoryProduct_model->get_category_sponsor_product_count($catid,$pageno,$sortby,$devicetype,$config_attr);
				
					$this->response([
						$this->config->item('rest_status_field_name') => 1,
						$this->config->item('rest_message_field_name') => '',
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}else{
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found',$language_code),
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
				}
			}else if(!$catid){
				$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('category_id_mandatory',$language_code),
						'pageno' => ($pageno+1),
						'productCount' => $product_count,
						$this->config->item('rest_data_field_name') => $product_array
						
					], self::HTTP_OK);
			}
			
    	}
    	else {
      		echo $validation;
    	}
		
	}
	
  

}
