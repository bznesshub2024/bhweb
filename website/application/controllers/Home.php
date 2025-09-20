<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';


class Home extends REST_Controller {
	protected $request_method ='get'; 
 public function __construct() {
        parent::__construct();
		 $this->load->model('home_model');
		 $this->load->model('categoryProduct_model');		 
		
    }
	
	public function login_data_get()
	{
		$this->load->view('website/login.php',$this->data);  // ye view/website folder hai
	}

	public function logout_data_get()
	{
		$this->session->sess_destroy();
		redirect('','refresh');
		//$this->load->view('website/index.php',$this->data);  // ye view/website folder hai
	}
	
	
	public function track_order_get()
	{
		$this->load->view('website/track.php',$this->data);  // ye view/website folder hai
	}
	
	public function register_get()
	{
		$this->load->view('website/register.php',$this->data);  // ye view/website folder hai
	}

	public function search_data_get($search)
	{
		$default_language = $this->session->userdata("default_language");
		$src = $_REQUEST['search'];
		$this->data['search_title'] = $src;
		$this->data['search'] = $this->home_model->get_search_product_request($default_language,$src,2);
		$this->load->view('website/search.php',$this->data);
	}
	
	public function cart_details_get()
	{
		$default_language = $this->session->userdata("default_language");
		$this->load->model('cart_model');
		$qoute_id = $this->session->userdata("qoute_id");
		$user_id = $this->session->userdata("user_id");
		 
		$this->data['cart'] = $this->cart_model->get_cart_full_details($default_language,$user_id,1,$qoute_id,'');
		
		$this->load->view('website/cart.php',$this->data);  // ye view/website folder hai
	}
	
	public function privacy_get()
	{
		$this->data['page_content'] = $this->home_model->get_privacy_data_request();
		$this->load->view('website/privacy.php',$this->data);
	}
	
	public function refund_get()
	{
		$this->data['page_content'] = $this->home_model->get_refund_data_request();
		$this->load->view('website/refund.php',$this->data);
	}

	public function about_get()
	{
		$this->data['page_content'] = $this->home_model->get_aboutus_data_request();
		$this->load->view('website/about.php',$this->data);
	}
	
	public function about_us_get()
	{
		$this->data['page_content'] = $this->home_model->get_aboutus_data_request();
		$this->load->view('website/about_us.php',$this->data);
	}
	
	public function faq_get()
	{
		$this->load->view('website/faq.php');
	}

	public function contact_get()
	{
		$this->load->view('website/contact.php',$this->data);
	}
	
	public function tearm_get()
	{
		$this->data['page_content'] = $this->home_model->get_term_data_request();
		$this->load->view('website/termsandcon.php',$this->data);
	}
	
	public function error_get()
	{
		$this->load->view('website/404.php',$this->data);
	}
	
	
	public function index_get()
	{	
		
		$this->data['header_banner'] = $this->home_model->get_header_banner_request('section1','1920-680');
		$this->data['home_section2'] = $this->home_model->get_home_section2_request('section2');
		$this->data['home_section4'] = $this->home_model->get_header_banner_request('section4','1930-150');
		$this->data['home_section5'] = $this->home_model->get_header_section5_request('section5');
		$this->data['home_section6'] = $this->home_model->get_header_banner_request('section6','1900-320');
		$this->data['home_bottom_banner'] = $this->home_model->get_header_banner_request('section8','610-400');
		
		$default_language = $this->session->userdata("default_language");
		$this->data['new_product'] = $this->home_model->get_home_products($default_language,'New');
		$this->data['popular_product'] = $this->home_model->get_home_products($default_language,'Popular');
		$this->data['recommended_product'] = $this->home_model->get_home_products($default_language,'Recommended');
		$this->data['offers_product'] = $this->home_model->get_home_products($default_language,'Offers');
		$this->data['home_bottom_product'] = $this->home_model->get_home_products($default_language,'home_bottom');
		$this->data['category'] = $this->home_model->get_category();
	
		
		$this->load->view('website/index.php',$this->data);  // ye view/website folder hai
	}
	
	function get_home_products_get(){
		$type = $this->input->get('type');
		$default_language = $this->session->userdata("default_language");
		$response = $this->home_model->get_home_products($default_language,$type);
		
		echo json_encode($response);
	}
	function get_home_cat_products_get(){
		$type = $this->input->get('type');
		$default_language = $this->session->userdata("default_language");
		$response = $this->home_model->get_home_cat_products($default_language,$type);
		
		echo json_encode($response);
	}
	function get_home_bottom_banner_get(){
		
		$response = $this->home_model->get_header_banner_request('section8','610-400');
		
		echo json_encode($response);
	}
	
	
	function delete_cart(){
		
		$prod_id = $this->input->get('prod_id');
		$user_id = $this->input->get('user_id');
		$qouteid = $this->input->get('qouteid');
		$response = $this->home_model->delete_product_cart($prod_id,$user_id,$qouteid);
		
		echo json_encode($response);
	}
	
	public function cart_count_get()
	{
		$this->load->model('cart_model');
		$qoute_id = $this->session->userdata("qoute_id");
		$user_id = $this->session->userdata("user_id");
		 
	    $response = $this->cart_model->get_cart_full_details($this->session->userdata("default_language"),$user_id,1,$qoute_id);
		
		echo json_encode($response['total_item']);

	}
	
	public function set_language_get()
	{
		$lang_Val = $this->input->get('lang_Val');
		$newdata = array(
						   'default_language'  => $lang_Val,
						   'logged_in' => TRUE
					   );
		 $set_data = $this->session->set_userdata($newdata);
	}
	
	public function wishlist_count_get()
	{
		$this->load->model('wishlist_model');
		$qoute_id = $this->session->userdata("qoute_id");
		$user_id = $this->session->userdata("user_id");
		 
	    $response = $this->wishlist_model->get_cart_full_details($this->session->userdata("default_language"),$user_id,2,'','');
		echo json_encode($response['total_item']);

	}
	
}
