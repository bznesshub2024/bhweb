<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/third_party/encryptfun.php';


class SellerController extends REST_Controller
{

	protected $request_method = 'post';


	public function __construct()
	{
		parent::__construct();

		// Load the user model
		$this->load->model('sellerProduct_model');
	}
	public function index_get()
	{
		$this->responses(1, 'Server OK');
	}

	public function seller_form_get()
	{
		$this->data['get_country'] = $this->sellerProduct_model->get_countrycode();
		$this->data['get_state'] = $this->sellerProduct_model->get_state();
		$this->data['get_city'] = $this->sellerProduct_model->get_city();
		$this->data['get_plans'] = $this->sellerProduct_model->get_plans();

		$this->load->view('website/become_seller.php', $this->data);  // ye view/website folder hai
	}

	public function thankyouseller_get()
	{
		$this->load->view('website/thankyouseller.php', $this->data);  // ye view/website folder hai
	}
	
	public function generate_invoice_post()
	{
		/*require '../admin/session.php';
		require '../admin/common_function.php';
		$Common_Function = new Common_Function();*/
		
		$orderid = $_POST['orderid'];
		$product_id = $_POST['product_id'];
		
		$link = generate_invoice($orderid,$product_id,1);
		
		 echo $url = base_url().$link;
		

		
		//$Common_Function->generate_invoice($conn,$orderid,$product_id,'');
	}

	function file_upload($file_name, $media_path)
	{
		include_once('libraries/php-image-resize-master/lib/ImageResize.php');

		$media_dir = $this->create_media_folder($media_path);
		$file_full_path = '';
		if (is_array($_FILES[$file_name]["name"])) {
			$count = count($_FILES[$file_name]["name"]);
			$file_full_path = array();
			for ($i = 0; $i < $count; $i++) {
				$path_info = '';
				if ($_FILES[$file_name]["name"][$i] != "") {
					$path_info = pathinfo($_FILES[$file_name]["name"][$i]);

					$extension = $path_info['extension'];
					$filename = $this->makeimagepath($path_info['filename']);

					$intFile = mt_rand();
					$file_full_path1 = $media_dir . '/' . $filename . $intFile . '.' . $extension;
					//$file_full_path1 = $media_dir.'/'.$intFile.$this->makeimagepath($_FILES[$file_name]["name"][$i]);
					move_uploaded_file($_FILES[$file_name]["tmp_name"][$i], $file_full_path1);

					$thumb = array();
					foreach ($this->img_dimension_arr as $value) {
						$height = $value[0];
						$width = $value[1];
						$destination_file = $media_dir . '/' . $filename . $intFile . '-' . $height . '-' . $width . '.' . $extension;

						$image = new ImageResize($file_full_path1);
						$image->resizeToBestFit($height, $width);
						$image->save($destination_file);
						$thumb[$height . '-' . $width] = str_replace($media_path, '', $destination_file);
					}
					//unlink($file_full_path1);
					$file_full_path[] = $thumb;
				}
			}
		} else {
			if ($_FILES[$file_name]["name"] != "") {
				$path_info = pathinfo($_FILES[$file_name]["name"]);

				$extension = $path_info['extension'];
				$filename = $this->makeimagepath($path_info['filename']);

				$intFile = mt_rand();
				$file_full_path1 = $media_dir . '/' . $filename . $intFile . '.' . $extension;
				//$file_full_path1 = $media_dir.'/'.$intFile.$this->makeimagepath($_FILES[$file_name]["name"]);
				move_uploaded_file($_FILES[$file_name]["tmp_name"], $file_full_path1);

				$thumb = array();
				foreach ($this->img_dimension_arr as $value) {
					$height = $value[0];
					$width = $value[1];
					$destination_file = $media_dir . '/' . $filename . $intFile . '-' . $height . '-' . $width . '.' . $extension;

					$image = new ImageResize($file_full_path1);
					$image->resizeToBestFit($height, $width);
					$image->save($destination_file);
					$thumb[$height . '-' . $width] = str_replace($media_path, '', $destination_file);
				}
				//unlink($file_full_path1);
				$file_full_path = $thumb;
			}
		}

		return $file_full_path;
	}

	//function for upload products image and resize image in multiple dimention
	function doc_upload($file_name, $media_path)
	{

		$media_dir = $this->create_media_folder($media_path);
		$file_full_path = '';
		if (is_array($_FILES[$file_name]["name"])) {
			$count = count($_FILES[$file_name]["name"]);
			$file_full_path = array();
			for ($i = 0; $i < $count; $i++) {
				if ($_FILES[$file_name]["name"][$i] != "") {
					$intFile = mt_rand();
					$file_full_path1 = $media_dir . '/' . $intFile . $this->makeimagepath($_FILES[$file_name]["name"][$i]);
					move_uploaded_file($_FILES[$file_name]["tmp_name"][$i], $file_full_path1);
					$file_full_path[] = str_replace($media_path, '', $file_full_path1);
				}
			}
		} else {
			if ($_FILES[$file_name]["name"] != "") {

				$intFile = mt_rand();
				$file_full_path1 = $media_dir . '/' . $intFile . $this->makeimagepath($_FILES[$file_name]["name"]);
				move_uploaded_file($_FILES[$file_name]["tmp_name"], $file_full_path1);

				$file_full_path = str_replace($media_path, '', $file_full_path1);
			}
		}

		return $file_full_path;
	}

	function add_sellers_post()
	{
		$seller_name = $_POST['seller_name'];
		$business_name = $_POST['business_name'];
		$website = '';
		$business_address = $_POST['business_address'];
		$business_details = $_POST['business_details'];
		$gst = $_POST['tax_number'];
		$pan_number = '';
		$selectcountry = 1;
		$selectstate = $_POST['selectstate'];
		$selectcity = $_POST['selectcity'];
		$pincode = $_POST['pincode'];
		$no_of_products = $_POST['no_of_products'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$password = $_POST['passwords'];
		$seller_logo = $_POST['seller_logo'];
		$aadhar_card = $_POST['aadhar_card'];
		$pan_card = $_POST['pan_card'];
		
		$refer_code = $_POST['refer_code'];
		$seller_type = $_POST['seller_type'];
		if($seller_type == 'Street Merchant')
		{
			$plan_id = $_POST['plan_id'];
		}
		else
		{
			$plan_id = $_POST['plan_id1'];
		}
		$plan_value = $_POST['plan_value'];
		$payment_id = $_POST['payment_id'];
		
		
		$business_proof = '';
		
		$publickey_server = $this->config->item("encryption_key");
		$encruptfun = new encryptfun();
		$encryptedpassword = $encruptfun->encrypt($publickey_server, $password);
		$password  = $encryptedpassword;

		/*if($_FILES['seller_logo']['name']){
			$featured_img1 = file_upload('seller_logo',$media_path);
			$seller_logo = json_encode($featured_img1);
		}
		$aadhar_card ='';
		if(strlen($_FILES['aadhar_card']['name']) >1){			
			$aadhar_card = doc_upload('aadhar_card',$media_path);			
		}
		
		$pan_card ='';
		if(strlen($_FILES['pan_card']['name']) >1){			
			$pan_card = doc_upload('pan_card',$media_path);			
		}
		
		$business_proof ='';
		if(strlen($_FILES['business_proof']['name']) >1){			
			$business_proof = doc_upload('business_proof',$media_path);			
		}*/

		$seller_array = $this->sellerProduct_model->add_seller($seller_name, $business_name, $website, $business_address, $business_details, $gst, $pan_number, $selectcountry, $selectstate, $selectcity, $pincode,$no_of_products, $phone, $email, $password, $plan_id, $refer_code, $seller_type,$payment_id, $_FILES);




		$this->session->set_flashdata('seller_form_msg', $seller_array);
		return redirect('thankyou_seller');
		$this->load->view('website/thankyou_seller.php', $seller_array);
	}


	public function getSellerDetails_post()
	{
		$requiredparameters = array('language', 'sellerid', 'pageno', 'sortby', 'devicetype');

		$language_code = removeSpecialCharacters($this->post('language'));
		$sellerid = removeSpecialCharacters($this->post('sellerid'));
		$pageno = removeSpecialCharacters($this->post('pageno'));
		$sortby = removeSpecialCharacters($this->post('sortby'));
		$devicetype = removeSpecialCharacters($this->post('devicetype'));



		$validation = $this->parameterValidation($requiredparameters, $this->post()); //$this->post() holds post values

		$seller_product_array = array('seller_details' => array(), 'seller_products' => array());
		if ($validation == 'valid') {
			if ($sellerid) {
				$seller_array = $this->sellerProduct_model->get_seller_request($sellerid, $devicetype);
				if ($seller_array) {
					$seller_product_array = array('seller_details' => $seller_array, 'seller_products' => array());
					$product_array = $this->sellerProduct_model->get_category_product_request($sellerid, $pageno, $sortby, $devicetype);

					if ($product_array) {
						$seller_product_array = array('seller_details' => $seller_array, 'seller_products' => $product_array);
						$this->response([
							$this->config->item('rest_status_field_name') => 1,
							$this->config->item('rest_message_field_name') => '',
							'pageno' => $pageno,
							$this->config->item('rest_data_field_name') => $seller_product_array

						], self::HTTP_OK);
					} else {
						$this->response([
							$this->config->item('rest_status_field_name') => 0,
							$this->config->item('rest_message_field_name') => get_phrase('no_record_found', $language_code),
							'pageno' => $pageno,
							$this->config->item('rest_data_field_name') => $seller_product_array

						], self::HTTP_OK);
					}
				} else {
					$this->response([
						$this->config->item('rest_status_field_name') => 0,
						$this->config->item('rest_message_field_name') => get_phrase('no_record_found', $language_code),
						'pageno' => $pageno,
						$this->config->item('rest_data_field_name') => $seller_product_array

					], self::HTTP_OK);
				}
			} else if (!$sellerid) {
				$this->response([
					$this->config->item('rest_status_field_name') => 0,
					$this->config->item('rest_message_field_name') => get_phrase('seller_mandatory', $language_code),
					'pageno' => $pageno,
					$this->config->item('rest_data_field_name') => $seller_product_array

				], self::HTTP_OK);
			}
		} else {
			echo $validation; //These are parameters are missing.
		}
	}
}
