<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Checkout_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('email_model');
		$this->load->model('delivery_model');
		$this->load->model('sms_model');
		$this->load->model('address_model');
		$this->date_time = date('Y-m-d H:i:s');
		$this->date = date('Y-m-d');
	}



	function get_checkout_full_details($user_id, $quote_id, $shipping_city = '', $shipping_pincode = '', $coupon_code = '',$payment_type = '')
	{

		$validate_coupon = $this->Validate_coupon_code($user_id, $coupon_code, '');
		if ($coupon_code  != '') {
			if ($validate_coupon == 'invalid') {
				return $validate_coupon; 
			}
		}

		$shiping_detail = 0;
		$shipping_fee1 = 0;
		// get delivery details
		$delivery_array = array();
		if ($shipping_city) {
			$delivery_array = $this->delivery_model->get_delivery_city_details_request($shipping_city);
		}
		//print_r($delivery_array);
		$this->db->select("prod_id, attr_sku, vendor_id, qty");

		if ($user_id) {
			$this->db->where(array('user_id' => $user_id));
		} else if ($quote_id) {
			$this->db->where(array('qoute_id' => $quote_id));
		}
		$coupon_discount = 0;
		$query = $this->db->get('cartdetails');

		$product_detail_array = array();
		$total_mrp = $total_discount = $total_price = $total_item = $total_tax = 0;
		$total_shipping_fee = 0;
		$seller_pincode = 0;
		$imgurl = 0;
		$default_discount = 0;
		if ($query->num_rows() > 0) {
			$cart_result = $query->result_object();
			foreach ($cart_result as $cart_detail) {
				$prod_id = $cart_detail->prod_id;
				$sku = $cart_detail->attr_sku;
				$vendor_id = $cart_detail->vendor_id;
				$qty = $cart_detail->qty;

				//check product details
				$this->db->select("product_sku, prod_name,featured_img,web_url,is_heavy,sellerlogin.companyname as seller,sellerlogin.pincode as seller_pincode, vp.product_mrp, vp.product_sale_price, vp.product_stock, vp.product_purchase_limit, vp.id as vendor_prod_id,shipping,featured_img,vp.coupon_code,vp.product_tax_class");
				//join for get vendor product
				$this->db->join('vendor_product vp', 'vp.product_id = product_details.product_unique_id', 'INNER');
				$this->db->join('sellerlogin', 'sellerlogin.seller_unique_id = vp.vendor_id', 'INNER');

				$this->db->where(array('product_details.status' => 1, 'vp.enable_status' => 1, 'sellerlogin.status' => 1, 'product_unique_id' => $prod_id, 'vendor_id' => $vendor_id));

				$query_prod = $this->db->get('product_details');

				$product_detail = array();
				$product_detail['mrp1'] = 0;
				$product_detail['price1'] = 0;
				$product_detail['qty'] = 0;
				if ($query_prod->num_rows() > 0) {
					$prod_result = $query_prod->result_object();

					$product_detail['prodid'] = $prod_id;
					$product_detail['qty'] = $qty;
					$product_detail['mrp'] = price_format(0);
					$product_detail['price'] = price_format(0);
					$product_detail['totaloff'] = price_format(0);
					$product_detail['offpercent'] = 0;
					$product_detail['shipping_fee'] = $prod_result[0]->shipping;;
					$product_detail['seller_pincode'] = $prod_result[0]->seller_pincode;
					$product_detail['coupon_code_vendor'] = $prod_result[0]->coupon_code;

					$tax_details = $this->get_tax_data($prod_result[0]->product_tax_class);
					$product_detail['product_tax'] =  $tax_details['percent'];

					$ger_vendor_coupon_name = '';
					if ($prod_result[0]->coupon_code != '') {
						$this->db->where(array('sno' => $prod_result[0]->coupon_code, 'activate' => 'active'));
						$query_coupon = $this->db->get('coupancode_vendor');
						$status = '';
						if ($query_coupon->num_rows() > 0) {
							$coupon_result = $query_coupon->result_object()[0];
							$ger_vendor_coupon_name = $coupon_result->name;
						}
					}


					if ($devicetype == 1) {
						$img_decode = json_decode($prod_result[0]->featured_img);
						$img = '';
						if ($img_decode) {
							$img = $img_decode->{MOBILE};
						}
						$product_detail['imgurl'] = $img;
					} else {
						$img_decode = json_decode($prod_result[0]->featured_img);
						$img = '';
						if ($img_decode) {
							$img = $img_decode->{DESKTOP};
						}
						$product_detail['imgurl'] = $img;
					}



					if ($prod_result[0]->product_sku == $sku) {
						//check vendor product details

						$tot_mrp = ($prod_result[0]->product_mrp * $qty);
						$tot_price = ($prod_result[0]->product_sale_price * $qty);

						$product_detail['mrp'] = price_format($tot_mrp);
						$product_detail['price'] = price_format($tot_price);

						$product_detail['mrp1'] = $tot_mrp;
						$product_detail['price1'] = $tot_price;

						$discount_price = 0;
						if ($tot_price > 0) {
							$discount_price = ($tot_mrp - $tot_price);

							$discount_per = ($discount_price / $tot_mrp) * 100;
						}
						$product_detail['totaloff'] = price_format($discount_price);
						$product_detail['offpercent'] = round($discount_per) . '% off';
					} else {
						$vendor_prod_id = $prod_result[0]->vendor_prod_id;

						$this->db->select("prod_attr_value, price, mrp, stock");
						$this->db->where(array('product_id' => $prod_id, 'vendor_prod_id' => $vendor_prod_id, 'product_sku' => $sku));

						$query_prod_attr = $this->db->get('product_attribute_value');

						if ($query_prod_attr->num_rows() > 0) {
							$prod_attr_result = $query_prod_attr->result_object();

							$tot_mrp1 = ($prod_attr_result[0]->mrp * $qty);
							$tot_price1 = ($prod_attr_result[0]->price * $qty);

							$product_detail['mrp'] = price_format($tot_mrp1);
							$product_detail['price'] = price_format($tot_price1);

							$product_detail['mrp1'] = $tot_mrp1;
							$product_detail['price1'] = $tot_price1;

							$discount_price = 0;
							if ($tot_price1 > 0) {
								$discount_price = ($tot_mrp1 - $tot_price1);

								$discount_per = ($discount_price / $tot_mrp1) * 100;
							}
							$product_detail['totaloff'] = price_format($discount_price);
							$product_detail['offpercent'] = round($discount_per) . '% off';
						}
					}
					$is_heavy = $prod_result[0]->is_heavy;
					$shipping_fee1 = 0;
					if ($delivery_array) {
						$total_price_value = preg_replace('/\D/', "", $product_detail['price'], -1);
						if ($is_heavy == 1 &&  $total_price_value < $delivery_array['order_value']) {
							$shipping_fee1 = $delivery_array['big_item_fee'];
							$product_detail['shipping_fee'] = price_format($delivery_array['big_item_fee']);
						} else if ($is_heavy == 0) {
							$shipping_fee1 = $delivery_array['basic_fee'];
							$product_detail['shipping_fee'] = price_format($delivery_array['basic_fee']);
						}
					}
				}

				$net_tax_amount = ($product_detail['price1'] * 100) / ($product_detail['product_tax'] + 100);
				$tax_get = round($net_tax_amount * $product_detail['product_tax'] / 100, 2);


				$total_mrp += $product_detail['mrp1'];
				$total_tax += $tax_get;

				$default_discount += ($product_detail['price1']*5)/100;
				$total_price += $product_detail['price1'];
				$total_item += $product_detail['qty'];
				/*$total_shipping_fee += $shipping_fee1;*/
				$seller_pincode = $product_detail['seller_pincode'];
				$imgurl = $product_detail['imgurl'];



				if ($validate_coupon != 'invalid') {

					$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));
					$query_coupon = $this->db->get('coupancode');

					$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));
					$query_coupon_vendor = $this->db->get('coupancode_vendor');

					$status = '';
					if ($query_coupon->num_rows() > 0) {
						$coupon_result = $query_coupon->result_object()[0];
						$product_detail['coupon_type'] = $coupon_result->coupon_type;
						$product_detail['user_apply'] = $coupon_result->user_apply;
						$product_detail['coupon_value'] = $coupon_result->value;
						$product_detail['cap_value'] = $coupon_result->cap_value;
						if ($product_detail['coupon_type'] == 1) {
							$coupon_discount0 =  ($product_detail['price1'] / 100) * $coupon_result->value;
						} else if ($product_detail['coupon_type'] == 2) {
							$coupon_discount0 =  $product_detail['price1'] - $coupon_result->value;
						}
						if($coupon_discount0 >= $product_detail['cap_value'])
						{
							$coupon_discount0 = $product_detail['cap_value'];
						}
						$payable_amount = ($product_detail['price1'] - $coupon_result->value);
						$product_detail['coupon_discount_text'] = price_format($coupon_result->value);
						$product_detail['coupon_discount'] = $coupon_result->value;
						$product_detail['payable_amount'] = price_format($payable_amount);
						$product_detail['payable_amount_value'] = $payable_amount;
						$product_detail['total_price_value'] = $payable_amount;
						$product_detail['price1'] = $product_detail['payable_amount'];
						$coupon_discount += $coupon_discount0;
					} else if ($query_coupon_vendor->num_rows() > 0 && $coupon_code == $ger_vendor_coupon_name) {
						$coupon_result = $query_coupon_vendor->result_object()[0];
						$product_detail['coupon_type'] = $coupon_result->coupon_type;
						$product_detail['user_apply'] = $coupon_result->user_apply;
						$product_detail['coupon_value'] = $coupon_result->value;
						$product_detail['cap_value'] = $coupon_result->cap_value;
						if ($product_detail['coupon_type'] == 1) {
							$coupon_discount0 =  ($product_detail['price1'] / 100) * $coupon_result->value;
						} else if ($product_detail['coupon_type'] == 2) {
							$coupon_discount0 =  $product_detail['price1'] - $product_detail['coupon_value'];
						}
						if($coupon_discount0 >= $product_detail['cap_value'])
						{
							$coupon_discount0 = $product_detail['cap_value'];
						}
						
						$payable_amount = ($product_detail['price1'] - $coupon_result->value);
						$product_detail['coupon_discount_text'] = price_format($coupon_result->value);
						$product_detail['coupon_discount'] = $coupon_result->value;
						$product_detail['payable_amount'] = price_format($payable_amount);
						$product_detail['payable_amount_value'] = $payable_amount;
						$product_detail['total_price_value'] = $payable_amount;
						$product_detail['price1'] = $product_detail['payable_amount'];
						$coupon_discount += $coupon_discount0;
					} else {
						$product_detail['coupon_type'] = "";
						$product_detail['user_apply'] = "";
						$product_detail['coupon_value'] = "";
						$product_detail['cap_value'] = "";
						$product_detail['coupon_discount_text'] = "";
						$product_detail['coupon_discount'] = "";
						$product_detail['payable_amount'] = "";
						$product_detail['payable_amount_value'] = "";
						$product_detail['total_price_value'] = "";
					}
				}

				/*if($shipping_pincode != 0 && $shipping_pincode != ''){
					$shiping_detail = $this->address_model->get_shippinf_details_full($seller_pincode,$shipping_pincode,$total_price);		
				}
				
				$total_shipping_fee += $shiping_detail;*/
				
				$shipping_data = $this->calculateShippingFee($seller_pincode, $shipping_pincode, '10', '10','10', '300', $payment_type, $product_detail['price1'] / intval($qty),intval($qty));
					//print_r($shipping_data);
					$shipping_data_array[] = array(
						'prod_id' => $prod_id,
						'prod_qty' => intval($qty),
						'shipping_data' => $shipping_data
					);

					
					if ($shipping_data['status']) {
						// $shipping += round($shipping_data['data']['min_delivery_price'] * intval($qty));
						$shipping += round($shipping_data['data']['min_delivery_price']);
					} else {
						$shipping += get_settings('default_shipping_fee');
					}
				
				
				// Razorpay API Credentials
				$key_id = 'rzp_live_oVzpJnJRDQttrF';
				$key_secret = 'j3wOmrEPLY5St6hONRSKTv05';

				// Order details
				$data = [
					//"amount" => ($product_detail['price1'] + $shipping) * 100, // Amount in paise (e.g., 50000 = ₹500)
					"amount" => 1 * 100, // Amount in paise (e.g., 50000 = ₹500)
					"currency" => "INR",
					"receipt" => "receipt#1",
					"payment_capture" => 1 // Capture payment automatically
				];

				// Initialize cURL
				$ch = curl_init();

				// Set the URL
				curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders");

				// Set the HTTP method to POST
				curl_setopt($ch, CURLOPT_POST, true);

				// Set the request payload
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

				// Set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'Content-Type: application/json',
					'Content-Length: ' . strlen(json_encode($data))
				]);

				// Set the authentication
				curl_setopt($ch, CURLOPT_USERPWD, "$key_id:$key_secret");

				// Return response instead of printing
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				// Execute cURL request
				$response = curl_exec($ch);

				// Check for errors
				if (curl_errno($ch)) {
					echo 'cURL Error: ' . curl_error($ch);
				} else {
					// Decode the response
					$pay_orderId = '';
					$responseData = json_decode($response, true);
					if (isset($responseData['id'])) {
						// Order ID
						$pay_orderId = $responseData['id'];
						//echo "Order ID: " . $orderId;
					} else {
						//echo "Error: " . $responseData['error']['description'];
					}
				}

				// Close the cURL session
				curl_close($ch);

				
				
				
				
				$total_shipping_fee += $shipping;
				unset($product_detail['mrp1']);
				unset($product_detail['price1']);
				$product_detail_array[] = $product_detail;
			}
		}

		$address = array();
		$user_address = array("address_id" => '', "fullname" => '', "mobile" => '', "locality" => '', "fulladdress" => '', "city" => '', "state" => '', "pincode" => '', "email" => '', "addresstype" => '');

		if ($user_id) {
			$this->db->select("user_id, addressarray, defaultaddress");
			$this->db->where(array('user_id' => $user_id));

			$query = $this->db->get('address');

			if ($query->num_rows() > 0) {
				$address_result = $query->result_object();

				$addressarray = $address_result[0]->addressarray;
				$defaultaddress = $address_result[0]->defaultaddress;

				$address_arr = json_decode($addressarray, true);
				//print_r($address_arr);

				foreach ($address_arr as $address) {
					if ($address['address_id'] == $defaultaddress) {
						$user_address = $address;
					}
				}
			}
		}

		/*$tax_payable = 0;*/
		$shipping_fee = $total_shipping_fee;
		//$coupon_code = '';
		//$coupon_discount = 0;

		return array(
			'user_address' => $user_address, 'total_mrp' => price_format($total_mrp), 'total_discount' => price_format($total_mrp - $total_price), 'total_price' => price_format($total_price - round($default_discount,0)),
			'total_item' => $total_item,'pay_orderId' => $pay_orderId, 'tax_payable' => $total_tax, 'coupon_code' => $coupon_code, 'coupon_discount' => round($coupon_discount, 0), 'shipping_fee' => $shipping_fee, 'payable_amount' => price_format($total_price + $shipping_fee - round($coupon_discount, 0) - round($default_discount,0)), 'payable_amount_value' => $total_price + $shipping_fee - round($coupon_discount, 0), 'total_price_value' => ($total_price + $shipping_fee - round($coupon_discount, 0)) - round($default_discount,0), 'seller_pincode' => $seller_pincode, 'imgurl' => $imgurl,'default_discount' => round($default_discount,0)
		);
	}
	
	private function nimbuspostLogin()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.nimbuspost.com/v1/users/login',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
				"email": "udvala.eswar@gmail.com",
				"password": "Bittu@2024"
			}',
			CURLOPT_HTTPHEADER => array(
				'content-type: application/json'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		return json_decode($response, true);
	}
	
	public function calculateShippingFee($from_pincode, $to_pincode, $shipping_length_cms, $shipping_width_cms, $shipping_height_cms, $shipping_weight_kg, $payment_method, $product_mrp,$qty)
	{
		$login_response = $this->nimbuspostLogin();
		if ($login_response['status'] == true) {
			$token = $login_response['data'];

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.nimbuspost.com/v1/courier/serviceability',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode(
					array(
						"origin" => $from_pincode,
						"destination" => $to_pincode,
						"payment_type" => $payment_method,
						"order_amount" => $product_mrp,
						"weight" => intval($shipping_weight_kg*$qty),
						"length" => $shipping_length_cms,
						"breadth" => $shipping_width_cms,
						"height" => $shipping_height_cms,
					)
				),
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $token
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			$response = json_decode($response, true);
			//print_r($response);

			if ($response['status']) {
				if (!empty($response['data'])) {
					$delivery_price = PHP_INT_MAX;
					$min_delivery_price = 0;
					$delivery_day = date('D, d M');
					$courier_id = $courier_name = '';
					foreach ($response['data'] as $item) {
						if ($item['total_charges'] < $delivery_price && $item['id'] != 216) {
							$min_delivery_price = $item['total_charges'];
							$delivery_price = $min_delivery_price;
							$delivery_day = date('D, d M', strtotime($item['edd']));
							$courier_id = $item['id'];
							$courier_name = $item['name'];
						}
					}
					return array(
						'status' => true,
						'data' => array(
							'courier_id' => $courier_id,
							'courier_name' => $courier_name,
							'min_delivery_price' => round($min_delivery_price),
							'delivery_day' => $delivery_day,
						)
					);
				} else {
					return array('status' => false, 'error' => 'No data found in response');
				}
			} else {
				return array('status' => false, 'error' => 'Error in API response');
			}
		} else {
			return array('status' => false, 'error' => 'Error in login response');
		}
	}
	
	
	//function for place order

	function place_order_details($user_id, $qouteid, $fullname, $mobile, $locality, $fulladdress, $city, $state, $pincode, $addresstype, $email, $payment_id, $payment_mode, $coupon_code, $coupon_value, $city_id)
	{
		$status = array('status' => '');
		$delivery_array = $order = array();
		$this->load->model('cart_model');


		if ($city_id) {
			$delivery_array = $this->delivery_model->get_delivery_details_byid($city_id);
		}
		$order_id = '';

		$devicetype = 1;
		$this->db->select("prod_id, attr_sku, vendor_id, qty,qoute_id");

		if ($user_id) {
			$this->db->where(array('user_id' => $user_id));
		} else {
			$this->db->where(array('qoute_id' => $qouteid));
		}
		$query = $this->db->get('cartdetails');

		$product_detail_array = array();
		$total_mrp = $total_discount = $total_price = $total_item = $qoute_id = 0;

		if ($query->num_rows() > 0) {
			$order_id = strtoupper('ODR' . $this->random_strings(6) . date("hi") . rand(1, 99));

			$add_order = $this->create_order($order_id, $user_id, $qouteid, $fullname, $mobile, $locality, $fulladdress, $city, $state, $pincode, $addresstype, $email, $payment_id, $payment_mode, $coupon_code, $coupon_value, $city_id);

			if ($add_order != 'add') {
				return false;
			}
			$cart_result = $query->result_object();

			foreach ($cart_result as $cart_detail) {
				$prod_id = $cart_detail->prod_id;
				$sku = $cart_detail->attr_sku;
				$vendor_id = $cart_detail->vendor_id;
				$qty = $cart_detail->qty;
				$qoute_id = $cart_detail->qoute_id;

				//check product details
				$this->db->select("product_sku, prod_name, prod_name_ar,featured_img,web_url,is_heavy,return_policy_id, vp.product_mrp, vp.product_sale_price, vp.product_stock, vp.product_purchase_limit, vp.id as vendor_prod_id,
									prp.policy_validity,prp.policy_type_refund,prp.policy_type_replace,prp.policy_type_exchange,sellerlogin.pincode as seller_pincode,sellerlogin.phone as seller_phone,shipping,vp.coupon_code,vp.seller_price,vp.product_tax_class,product_hsn_code,product_unique_code");

				//join for get product return policy
				$this->db->join('product_return_policy prp', 'prp.id = product_details.return_policy_id', 'LEFT');

				//join for get vendor product
				$this->db->join('vendor_product vp', 'vp.product_id = product_details.product_unique_id', 'INNER');
				$this->db->join('sellerlogin', 'sellerlogin.seller_unique_id = vp.vendor_id', 'INNER');

				$this->db->where(array('product_unique_id' => $prod_id, 'vendor_id' => $vendor_id));

				$query_prod = $this->db->get('product_details');

				$product_detail = array();
				$product_detail['qty'] = 0;
				$product_detail['mrp'] = 0;
				$product_detail['price'] = 0;
				$product_detail['price1'] = 0;
				$product_detail['totaloff'] = 0;
				$product_detail['totaloff1'] = 0;
				if ($query_prod->num_rows() > 0) {
					$prod_result = $query_prod->result_object();
					$is_heavy = $prod_result[0]->is_heavy;

					$product_detail['prodid'] = $prod_id;
					$product_detail['sku'] = $prod_result[0]->product_sku;
					$product_detail['vendor_id'] = $vendor_id;
					$product_detail['name'] = $prod_result[0]->prod_name;
					$product_detail['name_ar'] = $prod_result[0]->prod_name_ar;
					$product_detail['web_url'] = $prod_result[0]->web_url;
					$product_detail['seller_pincode'] = $prod_result[0]->seller_pincode;
					$product_detail['shipping'] = $prod_result[0]->shipping;
					$product_detail['seller_phone'] = $prod_result[0]->seller_phone;
					$product_detail['coupon_code'] = $prod_result[0]->coupon_code;
					$product_detail['seller_price'] = $prod_result[0]->seller_price;
					$product_detail['product_hsn_code'] = $prod_result[0]->product_hsn_code;
					$product_detail['product_unique_code'] = $prod_result[0]->product_unique_code;

					$tax_details = $this->get_tax_data($prod_result[0]->product_tax_class);

					$product_detail['coupon_tax'] =  $tax_details['percent'];





					$ger_vendor_coupon_name = '';
					if ($prod_result[0]->coupon_code != '') {
						$this->db->where(array('sno' => $prod_result[0]->coupon_code, 'activate' => 'active'));
						$query_coupon0 = $this->db->get('coupancode_vendor');
						if ($query_coupon0->num_rows() > 0) {
							$coupon_result = $query_coupon0->result_object()[0];
							$ger_vendor_coupon_name = $coupon_result->name;
						}
					}

					$product_detail['qty'] = $qty;
					$product_detail['configure_attr'] = array();
					$product_detail['mrp'] = 0;
					$product_detail['price'] = 0;
					$product_detail['totaloff'] = 0;

					$img_decode = json_decode($prod_result[0]->featured_img);
					$img = '';

					if ($devicetype == 1) {
						if (isset($img_decode->{MOBILE})) {
							$img = $img_decode->{MOBILE};
						} else {
							$img = $prod_result[0]->featured_img;
						}
					} else {
						if (isset($img_decode->{DESKTOP})) {
							$img = $img_decode->{DESKTOP};
						} else {
							$img = $prod_result[0]->featured_img;
						}
					}


					$curl_handle = curl_init();
					curl_setopt($curl_handle, CURLOPT_URL, 'https://api.postalpincode.in/pincode/' . $product_detail['seller_pincode']);
					curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
					curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
					$buffer = curl_exec($curl_handle);
					curl_close($curl_handle);
					$satte_data = json_decode($buffer);
					$seller_state_name = $satte_data[0]->PostOffice[0]->State;

					$curl_handle0 = curl_init();
					curl_setopt($curl_handle0, CURLOPT_URL, 'https://api.postalpincode.in/pincode/' . $pincode);
					curl_setopt($curl_handle0, CURLOPT_CONNECTTIMEOUT, 2);
					curl_setopt($curl_handle0, CURLOPT_RETURNTRANSFER, 1);
					$buffer1 = curl_exec($curl_handle0);
					curl_close($curl_handle0);
					$satte1_data = json_decode($buffer1);
					$user_state_name = $satte1_data[0]->PostOffice[0]->State;





					$product_detail['imgurl'] = $img;
					$prod_type = "";
					if ($prod_result[0]->product_sku == $sku) {
						//check vendor product details

						$tot_mrp = $prod_result[0]->product_mrp;
						$tot_price = $prod_result[0]->product_sale_price;

						$product_detail['mrp'] = $tot_mrp;
						$product_detail['price'] = $tot_price;

						$tot_mrp1 = ($prod_result[0]->product_mrp * $qty);
						$tot_price1 = ($prod_result[0]->product_sale_price * $qty);

						$product_detail['mrp1'] = $tot_mrp1;
						$product_detail['price1'] = $tot_price1;

						$discount_price = $discount_price1 = 0;
						if ($tot_price > 0) {
							$discount_price = ($tot_mrp - $tot_price);
							$discount_price1 = ($tot_mrp1 - $tot_price1);
						}
						$product_detail['totaloff'] = $discount_price;
						$product_detail['totaloff1'] = $discount_price1;
						$prod_type = "simple";
					} else {
						$vendor_prod_id = $prod_result[0]->vendor_prod_id;

						$this->db->select("prod_attr_value, price, mrp, stock");
						$this->db->where(array('product_id' => $prod_id, 'vendor_prod_id' => $vendor_prod_id, 'product_sku' => $sku));

						$query_prod_attr = $this->db->get('product_attribute_value');


						if ($query_prod_attr->num_rows() > 0) {
							$prod_attr_result = $query_prod_attr->result_object();

							$tot_mrp1 = $prod_attr_result[0]->mrp;
							$tot_price1 = $prod_attr_result[0]->price;

							$product_detail['mrp'] = $tot_mrp1;
							$product_detail['price'] = $tot_price1;

							$tot_mrp12 = ($prod_attr_result[0]->mrp * $qty);
							$tot_price12 = ($prod_attr_result[0]->price * $qty);

							$product_detail['mrp1'] = $tot_mrp12;
							$product_detail['price1'] = $tot_price12;

							$discount_price = $discount_price1 = 0;
							if ($tot_price1 > 0) {
								$discount_price = ($tot_mrp1 - $tot_price1);
								$discount_price1 = ($tot_mrp12 - $tot_price12);
							}
							$product_detail['totaloff'] = $discount_price;
							$product_detail['totaloff1'] = $discount_price1;
							$product_detail['configure_attr'] = $this->cart_model->get_product_configure_attr(json_decode($prod_attr_result[0]->prod_attr_value), $prod_id, $vendor_id);

							$prod_type = "configure";
						}
					}

					$invoice_number = $this->generate_invoice_number($product_detail['vendor_id']);

					//calculate shipping fee
					$shipping_fee1 = 0;
					$delivery_date = '';
					if ($delivery_array) {

						$total_price_value = preg_replace('/\D/', "", $product_detail['price'], -1);
						if ($is_heavy == 1 &&  $total_price_value < $delivery_array->order_value) {
							$shipping_fee1 = $delivery_array->big_item_fee;
						} else if ($is_heavy == 0) {
							$shipping_fee1 = $delivery_array->basic_fee;
						}
						$estimated_delivery_time = $delivery_array->estimated_delivery_time;
						if ($estimated_delivery_time >= 1) {
							$delivery_date = date('Y-m-d', strtotime('+' . $estimated_delivery_time . ' days'));
						} else {
							$delivery_date = date('Y-m-d', strtotime('+1 days'));
						}
					}
					if ($pincode != 0 && $pincode != '') {
						$shipping_fee1 = $this->address_model->get_shippinf_details_full($product_detail['seller_pincode'], $pincode, $product_detail['price']);
					}

					//calculate shipping fee

					//calculate return date
					$policy_validity = $prod_result[0]->policy_validity;
					$policy_type_refund = $prod_result[0]->policy_type_refund;

					$return_last_date = '';
					if ($policy_validity > 0 && $policy_type_refund > 0) {
						$return_last_date =  date('Y-m-d', strtotime('+' . $policy_validity . ' days'));
					}
					//calculate return date
					$coupon_discount = 0;
					$validate_coupon = $this->Validate_coupon_code($user_id, $coupon_code, '');
					if ($validate_coupon != 'invalid') {

						$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));
						$query_coupon_vendor = $this->db->get('coupancode_vendor');

						if ($query_coupon_vendor->num_rows() > 0 && $coupon_code == $ger_vendor_coupon_name) {
							$coupon_result = $query_coupon_vendor->result_object()[0];
							$product_detail['coupon_type'] = $coupon_result->coupon_type;
							if ($product_detail['coupon_type'] == 1) {
								$coupon_discount =  ($product_detail['price'] / 100) * $coupon_result->value;
							} else if ($coupon_type == 2) {
								$coupon_discount =  $product_detail['price'] - $coupon_result->value;
							}
						} else {
							$coupon_discount = 0;
						}
					}


					$this->db->select("commission");
					$this->db->where("FLOOR(price_from) <= ", $prod_result[0]->seller_price);
					$this->db->where("FLOOR(price_to) >= ", $prod_result[0]->seller_price);



					$query_comm = $this->db->get('seller_commission');
					if ($query_comm->num_rows() > 0) {
						$comm_result = $query_comm->result_object();

						$admin_profit = number_format($comm_result[0]->commission);
					}
					
					$admin_profit = round(($product_detail['price']*2)/100,0);
					$level_profit = round(($product_detail['price']*3)/100,0);
					
					$default_discount = round(($product_detail['price']*$product_detail['coupon_tax'])/100,0);

					$sgst = 0;
					$cgst = 0;
					$igst = 0;
					
					$tot_prc = $product_detail['price'] * $product_detail['qty'];
					$price_with_discount = $tot_prc - $default_discount;
					
					$taxable_amount = round(($price_with_discount * 100) / ($product_detail['coupon_tax'] + 100), 2);
					$tax_value = ($price_with_discount) - $taxable_amount;
					if ($user_state_name != $seller_state_name) {
						$sgst = $tax_value / 2;
						$cgst = $tax_value / 2;
					} else {
						$igst = $tax_value;
					}

					$shipping_data = $this->calculateShippingFee($product_detail['seller_pincode'], $pincode, '10', '10','10', '300', $payment_mode, $product_detail['price'] / intval($product_detail['qty']),intval($product_detail['qty']));
					$courier_id = NULL;
					$courier_name = NULL;
					$pickup_type = NULL;

					if ($shipping_data['status']) {
						$courier_id = $shipping_data['data']['courier_id'];
						$courier_name = $shipping_data['data']['courier_name'];
						// $shipping = round($shipping_data['data']['min_delivery_price'] * $cart_detail['qty']);
						$shipping = round($shipping_data['data']['min_delivery_price']);
						$delivery_date = '';
					} else {
						$shipping = 0;
						$pickup_type = 'self';
					}



					/*$admin_profit = $prod_result[0]->product_sale_price - $prod_result[0]->seller_price;*/

					$tax_class = ($prod_result[0]->product_sale_price / 100) * $product_detail['coupon_tax'];

					$payable_value = $prod_result[0]->product_sale_price - $tax_class;

					/*$tds = round(($payable_value / 100) * 1, 2);
					$tcs = round(($payable_value / 100) * 1, 2);

					$gross_amount = round($prod_result[0]->seller_price - ($tds +  $tcs), 2);*/
					$tds = 0;
					$tcs = 0;
					$gross_amount = round($prod_result[0]->seller_price, 2);

					$gst_input = round(($admin_profit / 100) * 18, 2);

					$net_amount = round($gross_amount - ($admin_profit - $gst_input), 2);


					//order summary
					$order_prod = array();

					$order_prod['order_id'] = $order_id;
					$order_prod['prod_id'] = $product_detail['prodid'];
					$order_prod['prod_sku'] = $product_detail['sku'];
					$order_prod['vendor_id'] = $product_detail['vendor_id'];
					$order_prod['prod_name'] = $product_detail['name'];
					$order_prod['prod_name_ar'] = $product_detail['name_ar'];
					$order_prod['prod_img'] = $product_detail['imgurl'];
					$order_prod['prod_attr'] = json_encode($product_detail['configure_attr']);
					$order_prod['qty'] = $product_detail['qty'];
					$order_prod['prod_price'] = $product_detail['price'];
					$order_prod['shipping'] = $shipping;
					$order_prod['courier_id'] = $courier_id;
					$order_prod['courier_name'] = $courier_name;
					$order_prod['discount'] = $product_detail['totaloff'];
					$order_prod['create_date'] = date('Y-m-d H:i:s');
					$order_prod['status'] = 'Placed';
					$order_prod['status_date'] = date('Y-m-d');
					$order_prod['invoice_number'] = $invoice_number;
					$order_prod['delivery_date'] = $delivery_date;
					$order_prod['return_last_date'] = $return_last_date;
					$order_prod['coupon_code'] = $coupon_code;
					$order_prod['coupon_value'] = $coupon_discount;
					$order_prod['seller_price'] = $product_detail['seller_price'];
					$order_prod['admin_profit'] = $admin_profit;
					$order_prod['level_profit'] = $level_profit;
					$order_prod['tds'] = $tds;
					$order_prod['tcs'] = $tcs;
					$order_prod['gross_amount'] = $gross_amount;
					$order_prod['gst_input'] = $gst_input;
					$order_prod['net_amount'] = $net_amount;
					$order_prod['taxable_amount'] = $taxable_amount;
					$order_prod['cgst'] = $cgst;
					$order_prod['sgst'] = $sgst;
					$order_prod['igst'] = $igst;
					$order_prod['product_hsn_code'] = $product_detail['product_hsn_code'];
					$order_prod['product_unique_code'] = $product_detail['product_unique_code'];
					$order_prod['default_discount'] = $default_discount;

					$query = $this->db->insert('order_product', $order_prod);

					if ($query) {
						$this->update_vendor_stock($product_detail['prodid'], $product_detail['vendor_id'], $sku, $prod_type, $qty);
						//$this->update_vendor_payment($product_detail['prodid'],$product_detail['vendor_id'],$qty,$product_detail['price'],$shipping);
					}
				}

				$prod_commision_admin = ($product_detail['price'] * admin_commission)/100;
				$prod_commision_leveel_1 = ($product_detail['price'] * level_1_commission)/100;


				$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');
				
				$this->db->select('*');
				$this->db->where(array('wallet_id' => admin_wallet_id));
				$this->db->order_by('id','DESC');
				$this->db->limit(1,0);
				$query_wallet_his = $this->db->get('wallet_transaction_history');
				
				$old_balance = 0;
				if($query_wallet_his->num_rows() >0){
					$get_wallet = $query_wallet_his->result_object()[0];
				
					$old_balance = $get_wallet->balance;
				}

				$this->db->select('*');
				$this->db->where(array('user_id' => admin_user_id));
				$query_wallet = $this->db->get('wallet_summery');
				
				$get_wallet = $query_wallet->result_object()[0];
				
				
				$old_amount = $get_wallet->amount;
				$walet_history_upd['amount'] = $old_amount + $prod_commision_admin;
			
				$this->db->where(array('user_id'=>admin_user_id));
				$this->db->update('wallet_summery', $walet_history_upd);
				
				
				$this->db->select('*');
				$this->db->where(array('user_unique_id' => $user_id));
				$name_query = $this->db->get('appuser_login');
				
				$name_result1 = $name_query->result_object()[0];
					
				$fullname = $name_result1->fullname;
					
				
				$data_wallet_history['wallet_id'] = admin_wallet_id;
				$data_wallet_history['payment_type'] = 0;
				$data_wallet_history['transaction_id'] = $transaction_id;
				$data_wallet_history['transaction_type'] = 'credit';
				$data_wallet_history['amount'] = $prod_commision_admin;
				$data_wallet_history['balance'] = $old_balance + $prod_commision_admin;
				$data_wallet_history['product_id'] = $product_detail['prodid'];
				$data_wallet_history['order_id'] = $order_id;
				$data_wallet_history['user_id'] = $user_id;
				$data_wallet_history['remark'] = 'Admin Order Commisson From '.$fullname; 
				$data_wallet_history['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history',$data_wallet_history);
				
				
				$this->db->select('*');
				$this->db->where(array('user_unique_id' => $user_id));
				$query_qet = $this->db->get('appuser_login');
				$get_user_data = $query_qet->result_object()[0];
				
				$level_1_user_id = $get_user_data->level_1;
				
				if($level_1_user_id != admin_user_id && $level_1_user_id != '')
				{
					
					$this->db->select('*');
					$this->db->where(array('user_unique_id' => $user_id));
					$name_query = $this->db->get('appuser_login');
					
					$name_result1 = $name_query->result_object()[0];
						
					$fullname = $name_result1->fullname;
					
					
					$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');
				
					$this->db->select('*');
					$this->db->where(array('user_id' => $level_1_user_id));
					$this->db->order_by('id','DESC');
					$this->db->limit(1,0);
					$query_wallet_his1 = $this->db->get('wallet_transaction_history');
					
					$old_balance = 0;
					if($query_wallet_his1->num_rows() >0){
						$get_wallet = $query_wallet_his1->result_object()[0];
					
						$old_balance = $get_wallet->balance;
					}

					$this->db->select('*');
					$this->db->where(array('user_id' => $level_1_user_id));
					$query_wallet1 = $this->db->get('wallet_summery');
					
					$get_wallet = $query_wallet1->result_object()[0];
					
					
					$old_amount = $get_wallet->amount;
					$walet_history_upd['amount'] = $old_amount + $prod_commision_leveel_1;
				
					$this->db->where(array('user_id'=>$level_1_user_id));
					$this->db->update('wallet_summery', $walet_history_upd);
						
					
					$data_wallet_history['wallet_id'] = $get_wallet->wallet_id;
					$data_wallet_history['payment_type'] = 0;
					$data_wallet_history['transaction_id'] = $transaction_id;
					$data_wallet_history['transaction_type'] = 'credit';
					$data_wallet_history['amount'] = $prod_commision_leveel_1;
					$data_wallet_history['balance'] = $old_balance + $prod_commision_leveel_1;
					$data_wallet_history['product_id'] = $product_detail['prodid'];
					$data_wallet_history['order_id'] = $order_id;
					$data_wallet_history['user_id'] = $user_id;
					$data_wallet_history['remark'] = 'Order Commisson From '.$fullname; 
					$data_wallet_history['created_at'] = $this->date_time;
					$this->db->insert('wallet_transaction_history',$data_wallet_history);
					
				}
				
				



				$total_price += $product_detail['price1'];
				$total_item += $product_detail['qty'];
				$total_discount += $product_detail['totaloff1'];
				$seller_phone = $product_detail['seller_phone'];
			}


			$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));
			$query_coupon0 = $this->db->get('coupancode');
			if ($query_coupon0->num_rows() > 0) {

				$this->db->select("*");
				$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));

				$query_coupon = $this->db->get('coupancode');
				$coupon_discount = 0;
				if ($query_coupon->num_rows() > 0) {
					$coupon_result = $query_coupon->result_object()[0];

					$coupon_type = $coupon_result->coupon_type;
					$value = $coupon_result->value;

					if ($coupon_type == 1) {
						$coupon_discount =  ($total_price / 100) * $value;
					} else if ($coupon_type == 2) {
						$coupon_discount =  $value;
					}
				}
			}

			$order['total_price'] = $total_price;
			$order['discount'] = $total_discount;
			$order['total_qty'] = $total_item;
			/*$order['coupon_value'] = $coupon_discount;*/

			$this->db->where(array('order_id' => $order_id));
			$queryup = $this->db->update('orders', $order);

			$status['order_detail'] = $order;
			$status['order_id'] = $order_id;

			if ($queryup) {
				$status['status'] = 'update';
			}
		}


		/*$message = 'Dear customer your Order has been Placed Successfully. Order Id is ' . $order_id . ' and Total price is Rs.' . $total_price . '. Thank You For Shopping with Marurang. MRURNG';
		/*$sms_sent = $this->sms_model->send_sms($message, $mobile);*/

		/*$user = 'marurangecommerce';
		$pass = '79624227';
		$header_name = 'MRURNG';
		$templete_id = '1707167698445161295';
		$ch = curl_init('https://www.txtguru.in/imobile/api.php?');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$user&password=$pass&source=$header_name&dmobile=+91$mobile&dlttempid=$templete_id&&message=$message");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);*/

		



		if ($order_id) {
			if ($email != '') {
				$this->email_model->send_order_email($order_id, PLACE_ORDER_TEMP);
			}
			$this->email_model->send_order_email_admin_seller($order_id);
		}

		return $status;
	}

	function online_place_order_details($user_id, $qouteid, $order_id, $fullname, $mobile, $locality, $fulladdress, $city, $state, $pincode, $addresstype, $email, $payment_id, $payment_mode, $coupon_code, $coupon_value, $city_id)
	{
		$status = array('status' => '');
		$delivery_array = $order = array();
		$this->load->model('cart_model');


		if ($city_id) {
			$delivery_array = $this->delivery_model->get_delivery_details_byid($city_id);
		}

		$devicetype = 1;
		$this->db->select("prod_id, attr_sku, vendor_id, qty,qoute_id");

		if ($user_id) {
			$this->db->where(array('user_id' => $user_id));
		} else {
			$this->db->where(array('qoute_id' => $qouteid));
		}
		$query = $this->db->get('cartdetails');

		$product_detail_array = array();
		$total_mrp = $total_discount = $total_price = $total_item = $qoute_id = 0;

		if ($query->num_rows() > 0) {

			if (!empty($user_id)) {
				$address_detail = $this->address_model->get_user_address_details_full($user_id);
				$isNewAddress = true;
				foreach ($address_detail['address_details'] as $address) {
					if (
						$address['fullname'] === $fullname &&
						$address['mobile'] === $mobile &&
						$address['state'] === $state &&
						$address['pincode'] === $pincode &&
						$address['city_id'] === $city_id &&
						$address['email'] === $email &&
						$address['fulladdress'] === $fulladdress
					) {
						$isNewAddress = false;
						break; // Break the loop
					}
				}
				if ($isNewAddress) {
					// The new address is different, add it to the addresses array
					// Perform any additional actions or save the updated addresses array
					$this->address_model->add_user_address($fullname, $mobile, $pincode, $user_id, $locality, $fulladdress, $state, $city, $addresstype, $email, $city_id);
				} else {
					// The new address is not different, handle accordingly
				}
			}

			$add_order = $this->create_order($order_id, $user_id, $qouteid, $fullname, $mobile, $locality, $fulladdress, $city, $state, $pincode, $addresstype, $email, $payment_id, $payment_mode, $coupon_code, $coupon_value, $city_id);

			if ($add_order != 'add') {
				return false;
			}
			$cart_result = $query->result_object();

			foreach ($cart_result as $cart_detail) {
				$prod_id = $cart_detail->prod_id;
				$sku = $cart_detail->attr_sku;
				$vendor_id = $cart_detail->vendor_id;
				$qty = $cart_detail->qty;
				$qoute_id = $cart_detail->qoute_id;

				//check product details
				$this->db->select("product_sku, prod_name, prod_name_ar,featured_img,web_url,is_heavy,return_policy_id, vp.product_mrp, vp.product_sale_price, vp.product_stock, vp.product_purchase_limit, vp.id as vendor_prod_id,
									prp.policy_validity,prp.policy_type_refund,prp.policy_type_replace,prp.policy_type_exchange,sellerlogin.pincode as seller_pincode,sellerlogin.phone as seller_phone,shipping,vp.coupon_code,vp.seller_price,vp.product_tax_class");

				//join for get product return policy
				$this->db->join('product_return_policy prp', 'prp.id = product_details.return_policy_id', 'LEFT');

				//join for get vendor product
				$this->db->join('vendor_product vp', 'vp.product_id = product_details.product_unique_id', 'INNER');
				$this->db->join('sellerlogin', 'sellerlogin.seller_unique_id = vp.vendor_id', 'INNER');

				$this->db->where(array('product_unique_id' => $prod_id, 'vendor_id' => $vendor_id));

				$query_prod = $this->db->get('product_details');

				$product_detail = array();
				$product_detail['qty'] = 0;
				$product_detail['mrp'] = 0;
				$product_detail['price'] = 0;
				$product_detail['price1'] = 0;
				$product_detail['totaloff'] = 0;
				$product_detail['totaloff1'] = 0;
				if ($query_prod->num_rows() > 0) {
					$prod_result = $query_prod->result_object();
					$is_heavy = $prod_result[0]->is_heavy;

					$product_detail['prodid'] = $prod_id;
					$product_detail['sku'] = $prod_result[0]->product_sku;
					$product_detail['vendor_id'] = $vendor_id;
					$product_detail['name'] = $prod_result[0]->prod_name;
					$product_detail['name_ar'] = $prod_result[0]->prod_name_ar;
					$product_detail['web_url'] = $prod_result[0]->web_url;
					$product_detail['seller_pincode'] = $prod_result[0]->seller_pincode;
					$product_detail['shipping'] = $prod_result[0]->shipping;
					$product_detail['seller_phone'] = $prod_result[0]->seller_phone;
					$product_detail['coupon_code'] = $prod_result[0]->coupon_code;
					$product_detail['seller_price'] = $prod_result[0]->seller_price;

					$tax_details = $this->get_tax_data($prod_result[0]->product_tax_class);

					$product_detail['coupon_tax'] =  $tax_details['percent'];

					$ger_vendor_coupon_name = '';
					if ($prod_result[0]->coupon_code != '') {
						$this->db->where(array('sno' => $prod_result[0]->coupon_code, 'activate' => 'active'));
						$query_coupon = $this->db->get('coupancode_vendor');
						$status = '';
						if ($query_coupon->num_rows() > 0) {
							$coupon_result = $query_coupon->result_object()[0];
							$ger_vendor_coupon_name = $coupon_result->name;
						}
					}

					$product_detail['qty'] = $qty;
					$product_detail['configure_attr'] = array();
					$product_detail['mrp'] = 0;
					$product_detail['price'] = 0;
					$product_detail['totaloff'] = 0;

					$img_decode = json_decode($prod_result[0]->featured_img);
					$img = '';

					if ($devicetype == 1) {
						if (isset($img_decode->{MOBILE})) {
							$img = $img_decode->{MOBILE};
						} else {
							$img = $prod_result[0]->featured_img;
						}
					} else {
						if (isset($img_decode->{DESKTOP})) {
							$img = $img_decode->{DESKTOP};
						} else {
							$img = $prod_result[0]->featured_img;
						}
					}

					$product_detail['imgurl'] = $img;
					$prod_type = "";
					if ($prod_result[0]->product_sku == $sku) {
						//check vendor product details

						$tot_mrp = $prod_result[0]->product_mrp;
						$tot_price = $prod_result[0]->product_sale_price;

						$product_detail['mrp'] = $tot_mrp;
						$product_detail['price'] = $tot_price;

						$tot_mrp1 = ($prod_result[0]->product_mrp * $qty);
						$tot_price1 = ($prod_result[0]->product_sale_price * $qty);

						$product_detail['mrp1'] = $tot_mrp1;
						$product_detail['price1'] = $tot_price1;

						$discount_price = $discount_price1 = 0;
						if ($tot_price > 0) {
							$discount_price = ($tot_mrp - $tot_price);
							$discount_price1 = ($tot_mrp1 - $tot_price1);
						}
						$product_detail['totaloff'] = $discount_price;
						$product_detail['totaloff1'] = $discount_price1;
						$prod_type = "simple";
					} else {
						$vendor_prod_id = $prod_result[0]->vendor_prod_id;

						$this->db->select("prod_attr_value, price, mrp, stock");
						$this->db->where(array('product_id' => $prod_id, 'vendor_prod_id' => $vendor_prod_id, 'product_sku' => $sku));

						$query_prod_attr = $this->db->get('product_attribute_value');


						if ($query_prod_attr->num_rows() > 0) {
							$prod_attr_result = $query_prod_attr->result_object();

							$tot_mrp1 = $prod_attr_result[0]->mrp;
							$tot_price1 = $prod_attr_result[0]->price;

							$product_detail['mrp'] = $tot_mrp1;
							$product_detail['price'] = $tot_price1;

							$tot_mrp12 = ($prod_attr_result[0]->mrp * $qty);
							$tot_price12 = ($prod_attr_result[0]->price * $qty);

							$product_detail['mrp1'] = $tot_mrp12;
							$product_detail['price1'] = $tot_price12;

							$discount_price = $discount_price1 = 0;
							if ($tot_price1 > 0) {
								$discount_price = ($tot_mrp1 - $tot_price1);
								$discount_price1 = ($tot_mrp12 - $tot_price12);
							}
							$product_detail['totaloff'] = $discount_price;
							$product_detail['totaloff1'] = $discount_price1;
							$product_detail['configure_attr'] = $this->cart_model->get_product_configure_attr(json_decode($prod_attr_result[0]->prod_attr_value), $prod_id, $vendor_id);

							$prod_type = "configure";
						}
					}

					$invoice_number = $this->generate_invoice_number($product_detail['vendor_id']);

					//calculate shipping fee
					$shipping_fee1 = 0;
					$delivery_date = '';
					if ($delivery_array) {

						$total_price_value = preg_replace('/\D/', "", $product_detail['price'], -1);
						if ($is_heavy == 1 &&  $total_price_value < $delivery_array->order_value) {
							$shipping_fee1 = $delivery_array->big_item_fee;
						} else if ($is_heavy == 0) {
							$shipping_fee1 = $delivery_array->basic_fee;
						}
						$estimated_delivery_time = $delivery_array->estimated_delivery_time;
						if ($estimated_delivery_time >= 1) {
							$delivery_date = date('Y-m-d', strtotime('+' . $estimated_delivery_time . ' days'));
						} else {
							$delivery_date = date('Y-m-d', strtotime('+1 days'));
						}
					}
					if ($pincode != 0 && $pincode != '') {
						$shipping_fee1 = $this->address_model->get_shippinf_details_full($product_detail['seller_pincode'], $pincode, $product_detail['price']);
					}

					//calculate shipping fee

					//calculate return date
					$policy_validity = $prod_result[0]->policy_validity;
					$policy_type_refund = $prod_result[0]->policy_type_refund;

					$return_last_date = '';
					if ($policy_validity > 0 && $policy_type_refund > 0) {
						$return_last_date =  date('Y-m-d', strtotime('+' . $policy_validity . ' days'));
					}
					//calculate return date

					$coupon_discount = 0;
					$validate_coupon = $this->Validate_coupon_code($user_id, $coupon_code, '');
					if ($validate_coupon != 'invalid') {


						$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));
						$query_coupon_vendor = $this->db->get('coupancode_vendor');

						$status = '';
						if ($query_coupon_vendor->num_rows() > 0 && $coupon_code == $ger_vendor_coupon_name) {
							$coupon_result = $query_coupon_vendor->result_object()[0];
							if ($product_detail['coupon_type'] == 1) {
								$coupon_discount =  ($product_detail['price'] / 100) * $coupon_result->value;
							} else if ($coupon_type == 2) {
								$coupon_discount =  $product_detail['price'] - $coupon_result->value;
							}
						} else {
							$coupon_discount = 0;
						}
					}



					$this->db->select("commission");
					$this->db->where("FLOOR(price_from) <= ", $prod_result[0]->seller_price);
					$this->db->where("FLOOR(price_to) >= ", $prod_result[0]->seller_price);



					$query_comm = $this->db->get('seller_commission');
					if ($query_comm->num_rows() > 0) {
						$comm_result = $query_comm->result_object();

						$admin_profit = number_format($comm_result[0]->commission);
					}




					/*$admin_profit = $prod_result[0]->product_sale_price - $prod_result[0]->seller_price;*/

					$tax_class = ($prod_result[0]->product_sale_price / 100) * $product_detail['coupon_tax'];

					$payable_value = $prod_result[0]->product_sale_price - $tax_class;

					$tds = round(($payable_value / 100) * 1, 2);
					$tcs = round(($payable_value / 100) * 1, 2);

					$gross_amount = round($prod_result[0]->seller_price - ($tds +  $tcs), 2);

					$gst_input = round(($admin_profit / 100) * 18, 2);

					$net_amount = round($gross_amount - $gst_input, 2);






					//order summary
					$order_prod = array();

					$order_prod['order_id'] = $order_id;
					$order_prod['prod_id'] = $product_detail['prodid'];
					$order_prod['prod_sku'] = $product_detail['sku'];
					$order_prod['vendor_id'] = $product_detail['vendor_id'];
					$order_prod['prod_name'] = $product_detail['name'];
					$order_prod['prod_name_ar'] = $product_detail['name_ar'];
					$order_prod['prod_img'] = $product_detail['imgurl'];
					$order_prod['prod_attr'] = json_encode($product_detail['configure_attr']);
					$order_prod['qty'] = $product_detail['qty'];
					$order_prod['prod_price'] = $product_detail['price'];
					$order_prod['shipping'] = $product_detail['shipping'];
					$order_prod['discount'] = $product_detail['totaloff'];
					$order_prod['create_date'] = date('Y-m-d H:i:s');
					$order_prod['status'] = 'Placed';
					$order_prod['status_date'] = date('Y-m-d');
					$order_prod['invoice_number'] = $invoice_number;
					$order_prod['delivery_date'] = $delivery_date;
					$order_prod['return_last_date'] = $return_last_date;
					$order_prod['coupon_code'] = $coupon_code;
					$order_prod['coupon_value'] = $coupon_discount;
					$order_prod['seller_price'] = $seller_price;
					$order_prod['admin_profit'] = $admin_profit;
					$order_prod['tds'] = $tds;
					$order_prod['tcs'] = $tcs;
					$order_prod['gross_amount'] = $gross_amount;
					$order_prod['gst_input'] = $gst_input;
					$order_prod['net_amount'] = $net_amount;

					$query = $this->db->insert('order_product', $order_prod);

					if ($query) {
						$this->update_vendor_stock($product_detail['prodid'], $product_detail['vendor_id'], $sku, $prod_type, $qty);
						//$this->update_vendor_payment($product_detail['prodid'],$product_detail['vendor_id'],$qty,$product_detail['price'],$shipping);
					}
				}



				$total_price += $product_detail['price1'];
				$total_item += $product_detail['qty'];
				$total_discount += $product_detail['totaloff1'];
				$seller_phone = $product_detail['seller_phone'];
			}


			$this->db->select("*");
			$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));

			$query_coupon = $this->db->get('coupancode');
			$coupon_discount = 0;
			if ($query_coupon->num_rows() > 0) {
				$coupon_result = $query_coupon->result_object()[0];

				$coupon_type = $coupon_result->coupon_type;
				$value = $coupon_result->value;

				if ($coupon_type == 1) {
					$coupon_discount =  ($total_price / 100) * $value;
				} else if ($coupon_type == 2) {
					$coupon_discount =  $value;
				}
			}

			$order['total_price'] = $total_price;
			$order['discount'] = $total_discount;
			$order['total_qty'] = $total_item;
			/*$order['coupon_value'] = $coupon_discount;*/

			$this->db->where(array('order_id' => $order_id));
			$queryup = $this->db->update('orders', $order);

			$status['order_detail'] = $order;
			$status['order_id'] = $order_id;

			if ($queryup) {
				$status['status'] = 'update';
			}
		}

		/*$message = 'Dear customer your Order has been Placed Successfully. Order Id is ' . $order_id . ' and Total price is Rs.' . $total_price . '. Thank You For Shopping with Marurang. MRURNG';
		/*$sms_sent = $this->sms_model->send_sms($message, $mobile);*/

		/*$user = 'marurangecommerce';
		$pass = '79624227';
		$header_name = 'MRURNG';
		$templete_id = '1707167698445161295';
		$ch = curl_init('https://www.txtguru.in/imobile/api.php?');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$user&password=$pass&source=$header_name&dmobile=+91$mobile&dlttempid=$templete_id&&message=$message");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);

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
		$data2 = curl_exec($ch2);

		*/

		if ($order_id) {
			if ($email != '') {
				$this->email_model->send_order_email($order_id, PLACE_ORDER_TEMP);
			}
			$this->email_model->send_order_email_admin_seller($order_id);
		}
		
		return $status;
	}

	function get_tax_data($id)
	{
		$tax_details = array('percent' => '');
		$this->db->select("percent");
		$this->db->where(array('tax_id' => $id, 'status' => '1'));


		$query = $this->db->get('tax');
		if ($query->num_rows() > 0) {
			$category_result = $query->result_object();

			$tax_details['percent'] = html_entity_decode($category_result[0]->percent);
		}
		return $tax_details;
	}

	function generate_invoice_number($vendor_id)
	{
		$this->db->select("fullname, invoice_number");

		$this->db->where(array('seller_unique_id' => $vendor_id));

		$query = $this->db->get('sellerlogin');
		$seller_result = $query->result_object();

		$seller_name = $seller_result[0]->fullname;
		$invoice_number = $seller_result[0]->invoice_number;
		$next_inv = ($invoice_number + 1);

		$seller_inv = strtoupper(substr($seller_name, 0, 2));

		$current_year = date('y');
		$current_month = date('m');

		$pre_year = ($current_year - 1);
		$next_year = ($current_year + 1);

		if ($current_month <= 3) {
			$seller_inv .= '-' . $pre_year . $current_year . '-000' . $next_inv;
		} else if ($current_month > 3 && $current_month  <= 12) {
			$seller_inv .= '-' . $current_year . $next_year . '-000' . $next_inv;
		}

		$this->db->where(array('seller_unique_id' => $vendor_id));
		$queryup = $this->db->update('sellerlogin', array('invoice_number' => $next_inv));

		return $seller_inv;
	}

	function create_order($order_id, $user_id, $qouteid, $fullname, $mobile, $locality, $fulladdress, $city, $state, $pincode, $addresstype, $email, $payment_id, $payment_mode, $coupon_code, $coupon_value, $city_id)
	{
		$status = '';
		$order = array();

		$order['order_id'] = $order_id;
		$order['user_id'] = $user_id;
		$order['total_price'] = '';
		$order['payment_orderid'] = '';
		$order['payment_id'] = $payment_id;
		$order['payment_mode'] = $payment_mode;
		$order['qoute_id'] = $qouteid;
		$order['create_date'] = date('Y-m-d H:i:s');
		$order['discount'] = '';
		$order['fullname'] = $fullname;
		$order['mobile'] = $mobile;
		$order['locality'] = $locality;
		$order['fulladdress'] = $fulladdress;
		$order['city'] = $city;
		$order['state'] = $state;
		$order['pincode'] = $pincode;
		$order['addresstype'] = $addresstype;
		$order['email'] = $email;
		$order['status'] = 'Placed';
		$order['coupon_code'] = $coupon_code;
		$order['cityid'] = $city_id;
		$order['coupon_value'] = $coupon_value;

		$query = $this->db->insert('orders', $order);
		if ($query) {
			$status = 'add';
		}
		return $status;
	}

	//delete cart items

	function empty_cart($user_id, $quote_id)
	{
		if ($user_id) {
			$this->db->where(array('user_id' => $user_id));
		} else if ($quote_id) {
			$this->db->where(array('qoute_id' => $quote_id));
		}

		$query = $this->db->delete('cartdetails');
	}


	//update stock
	function update_vendor_stock($prodid, $vendor_id, $sku, $prod_type, $qty)
	{
		if ($prod_type == 'simple') {

			//check product stock
			$this->db->select("product_stock");

			$this->db->where(array('product_id' => $prodid, 'vendor_id' => $vendor_id));

			$query_prod = $this->db->get('vendor_product');

			if ($query_prod->num_rows() > 0) {
				$prod_result = $query_prod->result_object();

				$total_stock = $prod_result[0]->product_stock;
				$remain_stock = ($total_stock - $qty);

				if ($remain_stock > 0) {
					$stock_status = 'In Stock';
				} else {
					$stock_status = 'Out of Stock';
				}
				$stock = array();
				$stock['product_stock'] = $remain_stock;
				$stock['stock_status'] = $stock_status;

				$this->db->where(array('product_id' => $prodid, 'vendor_id' => $vendor_id));
				$queryup = $this->db->update('vendor_product', $stock);
			}
		} else if ($prod_type == 'configure') {
			//check product stock
			$this->db->select("pav.stock, vp.id");

			$this->db->join('vendor_product vp', 'vp.id = pav.vendor_prod_id', 'INNER');

			$this->db->where(array('vp.product_id' => $prodid, 'vp.vendor_id' => $vendor_id, 'pav.product_sku' => $sku));

			$query_prod = $this->db->get('product_attribute_value pav');

			if ($query_prod->num_rows() > 0) {
				$prod_result = $query_prod->result_object();

				$vendor_prod_id = $prod_result[0]->id;

				$total_stock = $prod_result[0]->stock;

				$remain_stock = ($total_stock - $qty);

				$stock = array();
				$stock['stock'] = $remain_stock;

				$this->db->where(array('product_id' => $prodid, 'vendor_prod_id' => $vendor_prod_id));
				$queryup = $this->db->update('product_attribute_value', $stock);
			}
		}
	}


	function update_vendor_payment($prodid, $vendor_id, $qty, $price, $shipping)
	{
	}

	///check copuon code

	function Validate_coupon_code($user_id, $coupon_code, $type = '')
	{

		$this->db->select("*");
		$date = date('Y-m-d');
		$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));

		$query_coupon = $this->db->get('coupancode');
		$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));
		$query_coupon_vendor = $this->db->get('coupancode_vendor');
		$status = '';
		if ($query_coupon->num_rows() > 0) {
			$coupon_result = $query_coupon->result_object()[0];

			$user_apply = $coupon_result->user_apply;

			if ($type != 'product') {
				if ($user_id) {
					$this->db->select("user_id");
					$this->db->where(array('user_id' => $user_id));

					$query_order = $this->db->get('orders');
					$total_applied = $query_order->num_rows();

					if ($total_applied > $user_apply) {
						return 'applied_exced';
					}
				} else {
					return $status = 'login_required';
				}
			}

			$fromdate = $coupon_result->fromdate;
			$todate = $coupon_result->todate;
			if ($fromdate != '0000-00-00' && $todate != '0000-00-00') {
				if ($date >= $fromdate && $date <= $todate) {
					return $coupon_result;
				} else {
					$status = 'expired';
				}
			} else {
				$status = 'invalid';
			}
		} else if ($query_coupon_vendor->num_rows() > 0) {
			$coupon_result = $query_coupon_vendor->result_object()[0];
			$user_apply = $coupon_result->user_apply;
			if ($type != 'product') {
				if ($user_id) {
					$this->db->select("user_id");
					$this->db->where(array('user_id' => $user_id));
					$query_order = $this->db->get('orders');
					$total_applied = $query_order->num_rows();
					if ($total_applied > $user_apply) {
						return 'applied_exced';
					}
				} else {
					return $status = 'login_required';
				}
			}
			$fromdate = $coupon_result->fromdate;
			$todate = $coupon_result->todate;
			if ($fromdate != '0000-00-00' && $todate != '0000-00-00') {
				if ($date >= $fromdate && $date <= $todate) {
					return $coupon_result;
				} else {
					$status = 'expired';
				}
			} else {
				$status = 'invalid';
			}
		} else {
			$status = 'invalid';
		}
		return $status;
	}


	function Validate_coupon_code_old($user_id, $coupon_code, $type = '')
	{

		$this->db->select("*");
		$date = date('Y-m-d');
		$this->db->where(array('name' => $coupon_code, 'activate' => 'active'));

		$query_coupon = $this->db->get('coupancode');
		$status = '';
		if ($query_coupon->num_rows() > 0) {
			$coupon_result = $query_coupon->result_object()[0];

			$user_apply = $coupon_result->user_apply;

			if ($type != 'product') {
				if ($user_id) {
					$this->db->select("user_id");
					$this->db->where(array('user_id' => $user_id));

					$query_order = $this->db->get('orders');
					$total_applied = $query_order->num_rows();

					if ($total_applied > $user_apply) {
						return 'applied_exced';
					}
				} else {
					return $status = 'login_required';
				}
			}

			$fromdate = $coupon_result->fromdate;
			$todate = $coupon_result->todate;
			if ($fromdate != '0000-00-00' && $todate != '0000-00-00') {
				if ($date >= $fromdate && $date <= $todate) {
					return $coupon_result;
				} else {
					$status = 'expired';
				}
			} else {
				$status = 'invalid';
			}
		} else {
			$status = 'invalid';
		}

		return $status;
	}


	/*
		Break All The Values In Valid Form
	*/

	function getValues($var)
	{
		if (is_array($var)) {
			$values = "'" . implode("','", $var) . "'";
		} else {
			$delm = array(",", "\n");
			$values = "'" . str_replace($delm, "','", $var) . "'";
		}
		return $values;
	}

	// string of specified length 
	function random_strings($length_of_string)
	{

		// String of all alphanumeric character 
		$str_result = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz';

		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result), 0, $length_of_string);
	}
	
	function random_strings_digit($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '0123456789'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}
}
