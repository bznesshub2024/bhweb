<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';


class Home extends REST_Controller {
	protected $request_method ='get'; 
 public function __construct() {
        parent::__construct();
		 $this->load->model('home_model');
		 $this->load->model('categoryProduct_model');		 
		 $this->load->model('category_model');		 
		 $this->load->model('address_model');		 
		
    }
	
	public function login_data_get()
	{
	    
		$this->load->view('website/login.php',$this->data);  // ye view/website folder hai
	}
	
	public function thankyou_seller_get()
	{
		$this->load->view('website/thankyou_seller.php',$this->data); 
	}
	
	public function tree_view_get()
	{
		$this->load->view('website/tree_view.php',$this->data); 
	}

	public function logout_data_get()
	{
		$this->session->sess_destroy();
		redirect('','refresh');
		//$this->load->view('website/index.php',$this->data);  // ye view/website folder hai
	}
	
	public function sitemap_get()
	{
		$data = "";
        $this->data['category'] = $this->home_model->all_category_request();
        $this->data['product'] = $this->home_model->all_product_request();
		$this->load->view('website/sitemap.php',$this->data); 
	} 
	
	
	public function send_whatsapp_msg_get()
	{
		
		
		$url = 'https://betablaster.in/api/send.php?number=' . $_REQUEST['number'] . '&type=' . $_REQUEST['type'] . '&message=' . $_REQUEST['message'] . '&media_url=' . $_REQUEST['media_url']  . '&filename=' . $_REQUEST['filename'] . '&instance_id=' . $_REQUEST['instance_id'] . '&access_token=' . $_REQUEST['access_token'];

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		  'Content-Type: application/json',
		  'charset: utf-8',
		));

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
		  echo 'Error: ' . curl_error($ch);
		} else {
		  echo $response;
		}

		curl_close($ch);
	}

	public function all_category_get()
	{
		$this->data['category'] = $this->home_model->get_category();
		$this->load->view('website/top_category.php',$this->data);
	}
	
	function getsubcatdata_get(){
		
		$cat_id = $this->input->get('cat_id');
		$default_language = $this->session->userdata("default_language");
		$response = $this->home_model->get_sub_category($default_language,$cat_id);
		
		echo json_encode($response);
	}

	public function coupon_list_get()
	{
		$this->data['vendor_coupon'] = $this->home_model->get_vendor_coupon();
		$this->load->view('website/coupon_list.php',$this->data);
	}


	public function offers_get()
	{
		$this->data['offers_product'] = $this->home_model->get_home_products($default_language,'home_bottom');
		$this->load->view('website/offers.php',$this->data);
	}
	
	public function newarrival_get()
	{
		$this->data['new_product'] = $this->home_model->get_home_new_products($default_language,'New');
		$this->load->view('website/newarrival.php',$this->data);
	}
	
	public function high_discount_get()
	{
		$this->data['high_product'] = $this->home_model->get_high_discount_products($default_language);
		$this->load->view('website/high_discount.php',$this->data);
	}
	
	public function regarding_price_get()
	{
		$this->data['regarding_price_product'] = $this->home_model->get_regarding_price_products($default_language);
		$this->load->view('website/regarding_price.php',$this->data);
	}


	public function notification_get()
	{
		$this->data['notification'] = $this->home_model->getnotification_request(1);
		$this->data['firebase_notification'] = $this->home_model->get_firebase_notification_request(1);
		$this->load->view('website/notification.php',$this->data);
	}
	
	public function myaddress_get()
	{
		$user_id = $this->session->userdata("user_id");
		$this->data['address'] = $this->address_model->get_user_address_details_full($user_id);;
		$this->load->view('website/manage-address.php',$this->data);
	}


	public function sub_category_get($slug)
	{
		
		$this->data['title'] = $slug;
		
		$this->data['sub_cat'] = $this->home_model->sub_category(2,2,$slug);
		//print_r($this->data['sub_cat']);die;
		$this->load->view('website/sub_category.php',$this->data);
		
	}
	

	public function explore_sub_get($cat_id)
	{
		$category_result = array();
		$category_array = $this->home_model->get_subcategory_request(2,$category_result,$cat_id,1);
		$catid_array = array('10');
		if(count($category_array) >0){
			
			foreach($category_array as $cat_ids){
				$catid_array[] = $cat_ids['id'];
			}
		}
		$this->data['exolore_category_product'] = $this->categoryProduct_model->get_category_product_request(2,$catid_array,0,1,1,'');
		$this->data['exolore_category'] = $this->home_model->get_explore_category_request(2,$devicetype,$cat_id);
		$this->load->view('website/customize-clothing.php',$this->data);
	}

	public function explore_get()
	{
		$category_result = array();
		$category_array = $this->home_model->get_subcategory_request(2,$category_result,10,1);		
		$catid_array = array('10');
		if(count($category_array) >0){
			
			foreach($category_array as $cat_ids){
				$catid_array[] = $cat_ids['id'];
			}
		}
		$this->data['category'] = $this->home_model->get_explore_category();
		$this->data['exolore_category'] = $this->home_model->get_explore_category_request(2,$devicetype,10);
		$this->data['exolore_category_product'] = $this->categoryProduct_model->get_category_product_request(2,$catid_array,0,1,1,'');
		$this->load->view('website/explore.php',$this->data);
	}

	public function track_order_get()
	{
		$this->load->view('website/track.php',$this->data);
	}

	public function personal_info_get()
	{
		$this->load->view('website/personal_info.php',$this->data);
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
		/*$this->data['search_sponsor'] = $this->home_model->get_search_sponsor_product_request($default_language,$src,2);*/
		$this->load->view('website/search.php',$this->data);
	}
	
	public function get_search_products_get()
	{
	
		$default_language = $this->session->userdata("default_language");
		$src = $this->input->get('search');
		$response = $this->home_model->get_search_product_request($default_language,$src,2);
		echo json_encode($response);
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
	
	public function faq_get()
	{
		$this->data['page_content'] = $this->home_model->get_faq_data_request();
		$this->load->view('website/faq.php',$this->data);
	}
	
	public function free_shipping_get()
	{
		$this->data['page_content'] = $this->home_model->get_free_shipping_data_request();
		$this->load->view('website/free_shipping.php',$this->data);
	}

	public function feedback_get()
	{
		$this->data['page_content'] = $this->home_model->get_feedback_data_request();
		$this->load->view('website/feedback.php',$this->data);
	}

	public function help_get()
	{
		$this->data['page_content'] = $this->home_model->get_help_data_request();
		$this->load->view('website/help.php',$this->data);
	}
	

	public function contact_get()
	{
		$this->data['page_content'] = $this->home_model->get_contact_data_request();
		$this->load->view('website/contact.php',$this->data);
	}


	public function contactsave_post()
	{
	 $name    = $this->input->post('name');
	 $email   = $this->input->post('email');
	 $mobile  = $this->input->post('mobile');
	 $message = $this->input->post('message');

$messageadmin  = "<html><body>";

$messageadmin .= "<table width='500px;' align='center' border='1' cellpadding='0' cellspacing='0' style='font-family: sans-serif;background: rgba(220, 220, 220, 0.17);font-size: 14px;'>";

$messageadmin .= "<tbody>
<tr>
<td colspan='2'>Hello Admin</td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Name</td>
<td style='padding: 10px;'>".$name." </td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Email</td>
<td style='padding: 10px;'>".$email." </td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Mobile</td>
<td style='padding: 10px;'>".$mobile." </td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Message</td>
<td style='padding: 10px;'>".$message." </td>
</tr>
</tbody>";
$messageadmin .= "</table>";
$messageadmin .= "</body></html>";

$admin_email = 'contact@bznesshub.com';
$admin_subj = 'Contact Us'; 
//print_r($messageadmin);die;
send_email_smtp($admin_email,$messageadmin,$admin_subj);



	 $this->session->set_flashdata('success', 'Thank you! Your message has been saved.');
	 redirect($_SERVER['HTTP_REFERER']);
	}

	public function feedbacksave_post()
	{
	 $name    = $this->input->post('name');
	 $email   = $this->input->post('email');
	 $mobile  = $this->input->post('mobile');
	 $message = $this->input->post('message');

$messageadmin  = "<html><body>";

$messageadmin .= "<table width='500px;' align='center' border='1' cellpadding='0' cellspacing='0' style='font-family: sans-serif;background: rgba(220, 220, 220, 0.17);font-size: 14px;'>";

$messageadmin .= "<tbody>
<tr>
<td colspan='2'>Hello Admin</td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Name</td>
<td style='padding: 10px;'>".$name." </td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Email</td>
<td style='padding: 10px;'>".$email." </td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Mobile</td>
<td style='padding: 10px;'>".$mobile." </td>
</tr>
<tr>
<td style='padding: 10px;font-weight: 600;'>Message</td>
<td style='padding: 10px;'>".$message." </td>
</tr>
</tbody>";
$messageadmin .= "</table>";
$messageadmin .= "</body></html>";

$admin_email = 'admin@bznesshub.com';
$admin_subj = 'Feedback'; 
//print_r($messageadmin);die;
send_email_smtp($admin_email,$messageadmin,$admin_subj);



	 $this->session->set_flashdata('success', 'Thank you! Your message has been saved.');
	 redirect($_SERVER['HTTP_REFERER']);
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
		$this->data['home_section10'] = $this->home_model->get_header_banner_request('section10','1900-320');
		$this->data['home_section11'] = $this->home_model->get_header_banner_request('section11','1900-320');
		$this->data['home_section12'] = $this->home_model->get_header_banner_request('section12','1900-320');
		$this->data['home_section5'] = $this->home_model->get_header_section5_request('section5');
		$this->data['home_section6'] = $this->home_model->get_header_banner_request('section6','1900-320');
		$this->data['home_bottom_banner'] = $this->home_model->get_header_banner_request('section8','610-400');
		$this->data['offers_product'] = $this->home_model->get_home_products($default_language,'Offers');
		
		$default_language = $this->session->userdata("default_language");
		$this->data['category'] = $this->home_model->get_category();
	
		$product_ids = '';
		
		if (!empty($_SESSION['recent_session'])) {

			$product_ids = implode(',', $_SESSION['recent_session']);

		}
		
		$this->data['recent_product'] = $this->home_model->get_recent_products_request($default_language,2,$product_ids);

		
	
		
		$this->load->view('website/index.php',$this->data);
	}


	public function home_page_get()
	{	
		
		$this->data['header_banner'] = $this->home_model->get_header_banner_request('section1','1920-680');
		$this->data['home_section2'] = $this->home_model->get_home_section2_request('section2');
		$this->data['home_section4'] = $this->home_model->get_header_banner_request('section4','1930-150');
		$this->data['home_section10'] = $this->home_model->get_header_banner_request('section10','1900-320');
		$this->data['home_section11'] = $this->home_model->get_header_banner_request('section11','1900-320');
		$this->data['home_section12'] = $this->home_model->get_header_banner_request('section12','1900-320');
		$this->data['home_section5'] = $this->home_model->get_header_section5_request('section5');
		$this->data['home_section6'] = $this->home_model->get_header_banner_request('section6','1900-320');
		$this->data['home_bottom_banner'] = $this->home_model->get_header_banner_request('section8','610-400');
		
		$default_language = $this->session->userdata("default_language");
		$this->data['new_product'] = $this->home_model->get_home_products($default_language,'New');
		$this->data['popular_product'] = $this->home_model->get_home_products($default_language,'Popular');
		$this->data['recommended_product'] = $this->home_model->get_home_products($default_language,'Recommended');
		$this->data['offers_product'] = $this->home_model->get_home_products($default_language,'Offers');
		$this->data['most_product'] = $this->home_model->get_home_products($default_language,'Most');
		$this->data['custom_product'] = $this->home_model->get_home_products($default_language,'Custom');
		$this->data['home_bottom_product'] = $this->home_model->get_home_products($default_language,'home_bottom');
		$this->data['category'] = $this->home_model->get_category();
	
		
		$this->load->view('website/home.php',$this->data);
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
	
	
	
	function get_home_small_banner_get(){
		
		$type = $this->input->get('type');
		$size = $this->input->get('size');
		$response = $this->home_model->get_header_banner_request($type,$size);
		
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
	
	public function bank_details_get()
	{
		$this->load->view('website/bank_details.php',$this->data);
	}
	
	public function add_bank_details_post()
	{
		$ac_name = $this->input->post('ac_name');
		$ac_number = $this->input->post('ac_number');
		$ifsc_code = $this->input->post('ifsc_code');
		$upi_id = $this->input->post('upi_id');
		$user_id = $this->session->userdata("user_id");
		$response = $this->home_model->add_bank_details($ac_name,$ac_number,$ifsc_code,$upi_id,$user_id);
		
		return redirect('bank-details');
	}
	
	public function add_user_details_post()
	{
		$email = $this->input->post('email');
		$user_id = $this->session->userdata("user_id");
		$response = $this->home_model->add_user_details($email,$user_id);
		
		return redirect('personal_info');
	}
	
	
}
