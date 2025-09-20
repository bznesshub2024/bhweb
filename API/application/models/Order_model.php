<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		$this->load->model('email_model');
		$this->date_time = date('Y-m-d H:i:s');
    }

	function delivery_boy_assign($order_id,$pid,$delivery_boy)
	{
		$this->db->select("token");
		$this->db->where(array('deliveryboy_unique_id' => $delivery_boy));
		$query = $this->db->get('deliveryboy_login');

		$token = '';
		if ($query->num_rows() > 0) {
			$data_result = $query->result_object(); 

			$token = $data_result[0]->token;
		}
		
		$api_key = 'AAAAp4h_Mrw:APA91bGWtchLjIVk8rsoUDRisXHxa3XshHo7uM-UYqjaOTw4dDN7dO6hYaIEesSzvsgdC-h8QSpUC2x9BEiYEipLmqq8HFAIqAAZgLiGMx0Rv2SBrZsrMcbOCExGmRE-fxniMhXAVg6E';
		
		$msg = array(

			'body'  => 'Order ID ' . $order_id,

			'title'     => 'New Order Ready for Pickup ',

			'vibrate'   => 1,

			'sound'     => 1,

			'imageUrl' => '',

			'image' => ''

		);

		$info = array('clicktype' => 0, 'deliveryboy_unique_id' => $delivery_boy);

		$fields = array(

			'to'  => '/topics/seller_user',

			'notification'          => $msg,

			"data" => $info

		);

		$headers = array(

			'Authorization: key=' . $api_key,

			'Content-Type: application/json'

		);
		
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		$result = curl_exec($ch);

		curl_close($ch);
			
		$delivery_boy_add['order_id'] = $order_id;
		$delivery_boy_add['product_id'] = $pid;
		$delivery_boy_add['status'] = '';
		$delivery_boy_add['delivery_boy'] = $delivery_boy;
		$delivery_boy_add['created_at'] = $this->date_time;
		$this->db->insert('delivery_boy_orders',$delivery_boy_add);
		
		$order_product_upd['deliveryid'] = $delivery_boy;
			
		$this->db->where(array('order_id'=>$order_id));
		$this->db->update('order_product', $order_product_upd);
	
	
	}
	
	function get_order_list_details($user_id){
		$this->db->select("o.order_id,o.status, o.total_price,o.payment_mode,o.create_date,
							o.discount,o.total_qty");
		

		$this->db->where(array('o.user_id'=>$user_id));
		
		$this->db->order_by("o.sno",'desc'); 
		
		$query = $this->db->get('orders o');
		
		$product_detail_array = array();
		$orders = array();
		
		if($query->num_rows() >0){
			$order_result = $query->result_object();
			foreach($order_result as $order_detail){
				$orders['order_id'] = $order_detail->order_id;
				$orders['status'] = $order_detail->status;
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = $order_detail->create_date;
				$orders['total_qty'] = $order_detail->total_qty;
				$orders['total_price'] = price_format($order_detail->total_price);
				$orders['discount'] = price_format($order_detail->discount);
				
				$product_detail_array[] = $orders;
			}
		}
		
		return $product_detail_array;

	}
	
	
	function get_order_list_details_seller($user_id,$pageno){
		
		if($pageno >0){
		   $start = ($pageno*LIMIT);
	   }else{
		   $start = 0;
	   }
		
		
		$this->db->select("o.order_id,op.status, o.total_price,o.payment_mode,o.create_date,
							o.discount,o.total_qty,op.vendor_id,op.prod_id,op.prod_name,op.prod_img");
			
		$this->db->JOIN('order_product op', 'o.order_id = op.order_id', 'INNER');

		$this->db->where(array('op.vendor_id'=>$user_id));
		
		$this->db->order_by("o.sno",'desc'); 
		$this->db->limit(LIMIT,$start);	
		$query = $this->db->get('orders o'); 
			
		$product_detail_array = array();
		$orders = array();
		
		if($query->num_rows() >0){
			$order_result = $query->result_object();
			foreach($order_result as $order_detail){
				$orders['order_id'] = $order_detail->order_id;
				$orders['status'] = $order_detail->status;
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = date('d-m-Y h:i:sA',strtotime($order_detail->create_date));
				$orders['total_qty'] = $order_detail->total_qty;
				$orders['total_price'] = price_format($order_detail->total_price);
				$orders['discount'] = price_format($order_detail->discount);
				$orders['prod_id'] = $order_detail->prod_id;
				$orders['prod_name'] = $order_detail->prod_name;
				$orders['prod_img'] = $order_detail->prod_img;
				
				$return_data = $this->order_return_track($order_detail->order_id,$order_detail->prod_id);
				$orders['return_order_reason'] = $return_data;
				
				$product_detail_array[] = $orders;
			}
		}
		
		return $product_detail_array;

	}
	
	function order_return_track($order_id,$prod_id)
	{
		$this->db->select('seller_reason');
		$this->db->where(array('prod_id' => $prod_id,'order_id'=>$order_id));
		$query_prod = $this->db->get('cancel_order_track');
		if($query_prod->num_rows() >0){
			$prod_result = $query_prod->result_object()[0];
			return $prod_result->seller_reason;
		}
		else
		{
			return '';
		}
	}
	
	
	function get_order_list_seller_statuswise($user_id,$pageno,$order_status = ''){
		
		if($pageno >0){
		   $start = ($pageno*LIMIT);
	   }else{
		   $start = 0;
	   }
	   
	   
		
		$this->db->select("o.order_id,op.status, o.total_price,o.payment_mode,o.create_date,
							o.discount,o.total_qty,op.vendor_id,op.prod_id,op.prod_name,op.prod_img");
			
		$this->db->JOIN('order_product op', 'o.order_id = op.order_id', 'INNER');

		if($order_status=='completed'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Delivered'));
		}
		else if($order_status=='Packed'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Packed'));
		}
		else if($order_status=='Placed'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Placed'));
		}
		else if($order_status=='Accepted'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Accepted'));
		}
		else if($order_status=='Shipped'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Shipped'));
		}
		else if($order_status=='Out for Delivery'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Out for delivery'));
		}
		else if($order_status=='Delivered'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Delivered'));
		}
		else if($order_status=='cancelled'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Cancelled'));
		}
		else if($order_status=='RTO'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'RTO'));
		}
		else if($order_status=='Return Accepted'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Return Accepted'));
		}
		else if($order_status=='Rejected'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Rejected'));
		}
		else if($order_status=='Return Rejected'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Return Rejected'));
		}
		else if($order_status=='Returned Completed'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Returned Completed'));
		}
		else if($order_status=='Return Requested'){
			$this->db->where(array('op.vendor_id'=>$user_id,'op.status' => 'Return Requested'));
		}
		else if($order_status == 'all'){	
			$this->db->where(array('op.vendor_id'=>$user_id));
		}
		else if($order_status == ''){	
			$this->db->where(array('op.vendor_id'=>$user_id));
		}


		
		
		$this->db->order_by("o.sno",'desc'); 
		$this->db->limit(LIMIT,$start);	
		$query = $this->db->get('orders o');

		//print_r($this->db->last_query());
			
		$product_detail_array = array();
		$orders = array();
		
		if($query->num_rows() >0){
			$order_result = $query->result_object();
			foreach($order_result as $order_detail){
				$orders['order_id'] = $order_detail->order_id;
				$orders['status'] = $order_detail->status;
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = date('d-m-Y h:i:sA',strtotime($order_detail->create_date));
				$orders['total_qty'] = $order_detail->total_qty;
				$orders['total_price'] = price_format($order_detail->total_price);
				$orders['discount'] = price_format($order_detail->discount);
				$orders['prod_id'] = $order_detail->prod_id;
				$orders['prod_name'] = $order_detail->prod_name;
				$orders['prod_img'] = $order_detail->prod_img;
				
				$product_detail_array[] = $orders;
			}
		}
		
		return $product_detail_array;

	}

	
	
	function get_order_full_details($user_id, $order_id,$pid){
		$this->db->select("o.order_id,o.status, o.total_price,o.payment_mode,o.create_date,
							o.discount,o.total_qty, o.fullname, o.mobile,o.locality, o.fulladdress,o.city,st.name as state,o.pincode,o.addresstype,o.email,o.coupon_code,o.coupon_value");
		
				$this->db->JOIN('state st', 'st.stateid = o.state','INNER');
		$this->db->where(array('o.user_id'=>$user_id, 'o.order_id'=>$order_id));
		
		
		$query = $this->db->get('orders o');
		
		$order_summery = array('order_id'=>'','status'=>'','payment_mode'=>'','create_date'=>'','total_qty'=>'','total_price'=>'','discount'=>'');
		 $shipping_address = array('fullname'=>'','mobile'=>'','locality'=>'','fulladdress'=>'','city'=>'','state'=>'','pincode'=>'','addresstype'=>'','email'=>'');
		$orders =$shipping = array();
			$order_product_array = $order_product = array();
				
		if($query->num_rows() >0){
				$order_result = $query->result_object();
				$order_detail = $order_result[0];
				$orders['order_id'] = $order_detail->order_id;
				
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = date('d-m-Y',strtotime($order_detail->create_date));
				
				
				
				
				$shipping['fullname'] = $order_detail->fullname;
				$shipping['mobile'] = $order_detail->mobile;
				$shipping['locality'] = $order_detail->locality;
				$shipping['fulladdress'] = $order_detail->fulladdress;
				$shipping['city'] = $order_detail->city;
				$shipping['state'] = $order_detail->state;
				$shipping['pincode'] = $order_detail->pincode;
				$shipping['addresstype'] = $order_detail->addresstype;
				$shipping['email'] = $order_detail->email;
				
				$shipping_address = $shipping;
				
				$this->db->select("op.prod_id,op.prod_sku,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status, sl.companyname,sl.seller_unique_id,op.default_discount");
				
				$this->db->JOIN('sellerlogin sl', 'sl.seller_unique_id = op.vendor_id','INNER');

				$this->db->where(array('op.order_id'=>$order_id, 'op.prod_id'=>$pid));
				
				
				$query_prod = $this->db->get('order_product op');
				
			
				if($query_prod->num_rows() >0){
					$order_prod_result = $query_prod->result_object();
					
					foreach($order_prod_result as $order_prod_detail){
						
						$default_discount = 0;
						if($order_prod_detail->default_discount != '')
						{
							$default_discount = $order_prod_detail->default_discount;
						}
						
						
						$order_product['prod_id'] = $order_prod_detail->prod_id;
						$order_product['prod_sku'] = $order_prod_detail->prod_sku;
						$order_product['prod_name'] = $order_prod_detail->prod_name;
						$order_product['prod_img'] = $order_prod_detail->prod_img;
						$order_product['qty'] = $order_prod_detail->qty;
						$order_product['prod_price'] = price_format($order_prod_detail->prod_price);
						$order_product['shipping'] = price_format($order_prod_detail->shipping);
						$order_product['discount'] = price_format($order_prod_detail->discount);
						$order_product['prod_mrp'] = price_format($order_prod_detail->prod_price+$order_prod_detail->discount);
						$order_product['status'] = $order_prod_detail->status;
						$order_product['default_discount'] = $default_discount;
						$order_product['coupon_code'] = $order_detail->coupon_code;
						$order_product['coupon_value'] = price_format($order_detail->coupon_value);
						$order_product['final_value'] = price_format(($order_prod_detail->prod_price-$order_detail->coupon_value)+$order_prod_detail->shipping - $default_discount);
						$order_product['companyname'] = $order_prod_detail->companyname;
						$order_product['vendor_id'] = $order_prod_detail->seller_unique_id;
						
						$product_seller_deta_array = $this->get_order_seller_details($order_prod_detail->seller_unique_id);
						
						$order_product['seller_name'] = $product_seller_deta_array['seller_name'];
						$order_product['seller_address'] = $product_seller_deta_array['seller_address'];
						$order_product['seller_state_name'] = $product_seller_deta_array['state_name'];
						$order_product['seller_city_name'] = $product_seller_deta_array['city_name'];
						
						$order_product['tax'] = 0;
						if($order_prod_detail->prod_attr){
							$attr = json_decode($order_prod_detail->prod_attr);
							/*$attribute = '';
							foreach($attr as $prod_attr){
								$attribute .= $prod_attr->attr_name.': '.$prod_attr->item.', ';
							}
							
							$order_product['attribute'] = rtrim($attribute,', ');*/							$order_product['attribute'] = $attr;
						}else{
							$order_product['attribute'] = '';
						}
						
						$orders['status'] = $order_prod_detail->status;
						$orders['total_qty'] = $order_prod_detail->qty;
						$orders['total_price'] = price_format($order_prod_detail->prod_price);
						$orders['discount'] = price_format($order_prod_detail->discount);
						$orders['total_mrp'] = price_format($order_prod_detail->discount+$order_prod_detail->prod_price);
						
						$order_summery = $orders;
						$order_product_array[] = $order_product;
					}
				}
			
		}
		
		return array('order_summery'=>$order_summery, 'shipping_address'=>$shipping_address,'product_details'=>$order_product_array);

	}
	
	
	function get_order_seller_details($vendor_id)
	{
		$data_array = array();
		$this->db->select("*");
		$this->db->where(array('seller_unique_id' => $vendor_id));

		$query_sell = $this->db->get('sellerlogin');
		
		if ($query_sell->num_rows() > 0) {
			$order_seller_result = $query_sell->result_object();

			$companyname = $order_seller_result[0]->companyname;
			$address = $order_seller_result[0]->address;
			$seller_state_id = $order_seller_result[0]->state;
			$seller_city_id = $order_seller_result[0]->city;
			
			$this->db->select("*");
			$this->db->where(array('stateid' => $seller_state_id));
			$query_state = $this->db->get('state');
			$order_state_result = $query_state->result_object();
			$state_name = $order_state_result[0]->name;
			
			$this->db->select("*");
			$this->db->where(array('city_id' => $seller_city_id));
			$query_city = $this->db->get('city');
			$order_city_result = $query_city->result_object();
			$city_name = $order_city_result[0]->city_name;
			
			$data_array['seller_name'] = $companyname;
			$data_array['seller_address'] = $address;
			$data_array['state_name'] = $state_name;
			$data_array['city_name'] = $city_name;
			
		}
		return $data_array;
	}
	
	function get_order_full_details_seller($user_id, $order_id,$pid){
		$this->db->select("o.order_id,o.status, o.total_price,o.payment_mode,o.create_date,
							o.discount,o.total_qty, o.fullname, o.mobile,o.locality, o.fulladdress,o.city,st.name as state,o.pincode,o.addresstype,o.email,o.coupon_code,o.coupon_value");
		
				$this->db->JOIN('state st', 'st.stateid = o.state','INNER');
				$this->db->JOIN('order_product op', 'o.order_id = op.order_id', 'INNER');

		$this->db->where(array('op.vendor_id'=>$user_id,'o.order_id'=>$order_id));
		
		
		$query = $this->db->get('orders o');
		
		$order_summery = array('order_id'=>'','status'=>'','payment_mode'=>'','create_date'=>'','total_qty'=>'','total_price'=>'','discount'=>'');
		 $shipping_address = array('fullname'=>'','mobile'=>'','locality'=>'','fulladdress'=>'','city'=>'','state'=>'','pincode'=>'','addresstype'=>'','email'=>'');
		$orders =$shipping = array();
			$order_product_array = $order_product = array();
				
		if($query->num_rows() >0){
				$order_result = $query->result_object();
				$order_detail = $order_result[0];
				$orders['order_id'] = $order_detail->order_id;
				
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = date('d-m-Y',strtotime($order_detail->create_date));
				
				
				
				
				$shipping['fullname'] = $order_detail->fullname;
				$shipping['mobile'] = $order_detail->mobile;
				$shipping['locality'] = $order_detail->locality;
				$shipping['fulladdress'] = $order_detail->fulladdress;
				$shipping['city'] = $order_detail->city;
				$shipping['state'] = $order_detail->state;
				$shipping['pincode'] = $order_detail->pincode;
				$shipping['addresstype'] = $order_detail->addresstype;
				$shipping['email'] = $order_detail->email;
				
				$shipping_address = $shipping;
				
				$this->db->select("op.prod_id,op.prod_sku,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status, sl.companyname,sl.seller_unique_id,op.default_discount");
				
				$this->db->JOIN('sellerlogin sl', 'sl.seller_unique_id = op.vendor_id','INNER');

				$this->db->where(array('op.order_id'=>$order_id, 'op.prod_id'=>$pid));
				
				
				$query_prod = $this->db->get('order_product op');
				
			
				if($query_prod->num_rows() >0){
					$order_prod_result = $query_prod->result_object();
					
					foreach($order_prod_result as $order_prod_detail){
						$order_product['prod_id'] = $order_prod_detail->prod_id;
						$order_product['prod_sku'] = $order_prod_detail->prod_sku;
						$order_product['prod_name'] = $order_prod_detail->prod_name;
						$order_product['prod_img'] = $order_prod_detail->prod_img;
						$order_product['qty'] = $order_prod_detail->qty;
						$order_product['default_discount'] = $order_prod_detail->default_discount;
						$order_product['prod_price'] = price_format($order_prod_detail->prod_price);
						$order_product['shipping'] = price_format($order_prod_detail->shipping);
						$order_product['discount'] = price_format($order_prod_detail->discount);
						$order_product['prod_mrp'] = price_format($order_prod_detail->prod_price+$order_prod_detail->discount);
						$order_product['status'] = $order_prod_detail->status;
						$order_product['coupon_code'] = $order_detail->coupon_code;
						$order_product['coupon_value'] = price_format($order_detail->coupon_value);
						$order_product['final_value'] = price_format(($order_prod_detail->prod_price-$order_detail->coupon_value)+$order_prod_detail->shipping - $order_prod_detail->default_discount);
						$order_product['companyname'] = $order_prod_detail->companyname;
						$order_product['vendor_id'] = $order_prod_detail->seller_unique_id;
						$order_product['tax'] = "0";
						if($order_prod_detail->prod_attr){
							$attr = json_decode($order_prod_detail->prod_attr);
							/*$attribute = '';
							foreach($attr as $prod_attr){
								$attribute .= $prod_attr->attr_name.': '.$prod_attr->item.', ';
		f					}
							
							$order_product['attribute'] = rtrim($attribute,', ');*/							$order_product['attribute'] = $attr;
						}else{
							$order_product['attribute'] = '';
						}
						
						$orders['status'] = $order_prod_detail->status;
						$orders['total_qty'] = $order_prod_detail->qty;
						$orders['total_price'] = price_format($order_prod_detail->prod_price);
						$orders['discount'] = price_format($order_prod_detail->discount);
						$orders['total_mrp'] = price_format($order_prod_detail->discount+$order_prod_detail->prod_price);
						
						$order_summery = $orders;
						$order_product_array[] = $order_product;
					}
				}
			
		}
		
		return array('order_summery'=>$order_summery, 'shipping_address'=>$shipping_address,'product_details'=>$order_product_array);

	}
	
	function get_order_track_details($language_code,$order_id){
		$this->db->select("o.order_id,o.status, o.total_price,o.payment_mode,o.create_date,
							o.discount,o.total_qty, o.fullname, o.mobile,o.locality, o.fulladdress,o.city,o.state,o.pincode,o.addresstype,o.email");
		

		$this->db->where(array( 'o.order_id'=>$order_id));
		
		
		$query = $this->db->get('orders o');
			$order_summery = array('order_id'=>'','status'=>'','payment_mode'=>'','create_date'=>'','total_qty'=>'','total_price'=>'','discount'=>'');
		 $shipping_address = array('fullname'=>'','mobile'=>'','locality'=>'','fulladdress'=>'','city'=>'','state'=>'','pincode'=>'','addresstype'=>'','email'=>'');
	
		$order_product_array = array();
		$orders =$shipping = array();
		//print_r($this->db->last_query());
		if($query->num_rows() >0){
				$order_result = $query->result_object();
				$order_detail = $order_result[0];
				$orders['order_id'] = $order_detail->order_id;
				$orders['status'] = $order_detail->status;
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = $order_detail->create_date;
				$orders['total_qty'] = $order_detail->total_qty;
				$orders['total_price'] = price_format($order_detail->total_price);
				$orders['discount'] = price_format($order_detail->discount);
				
				$order_summery = $orders;
				
				$shipping['fullname'] = $order_detail->fullname;
				$shipping['mobile'] = $order_detail->mobile;
				$shipping['locality'] = $order_detail->locality;
				$shipping['fulladdress'] = $order_detail->fulladdress;
				$shipping['city'] = $order_detail->city;
				$shipping['state'] = $order_detail->state;
				$shipping['pincode'] = $order_detail->pincode;
				$shipping['addresstype'] = $order_detail->addresstype;
				$shipping['email'] = $order_detail->email;
				
				$shipping_address = $shipping;
				
				$this->db->select("op.prod_id,op.prod_sku,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status, sl.companyname,sl.seller_unique_id");
				
				$this->db->JOIN('sellerlogin sl', 'sl.seller_unique_id = op.vendor_id','INNER');

				$this->db->where(array('op.order_id'=>$order_id));
				
				
				$query_prod = $this->db->get('order_product op');
				
				$order_product_array = $order_product = array();
				
				if($query_prod->num_rows() >0){
					$order_prod_result = $query_prod->result_object();
					
					foreach($order_prod_result as $order_prod_detail){
						$order_product['prod_id'] = $order_prod_detail->prod_id;
						$order_product['prod_sku'] = $order_prod_detail->prod_sku;
						$order_product['prod_name'] = $order_prod_detail->prod_name;
						$order_product['prod_img'] = $order_prod_detail->prod_img;
						$order_product['qty'] = $order_prod_detail->qty;
						$order_product['prod_price'] = price_format($order_prod_detail->prod_price);
						$order_product['shipping'] = price_format($order_prod_detail->shipping);
						$order_product['discount'] = price_format($order_prod_detail->discount);
						$order_product['prod_mrp'] = price_format($order_prod_detail->prod_price+$order_prod_detail->discount);
						$order_product['status'] = $order_prod_detail->status;
						$order_product['companyname'] = $order_prod_detail->companyname;
						$order_product['vendor_id'] = $order_prod_detail->seller_unique_id;
						if($order_prod_detail->prod_attr){
							$attr = json_decode($order_prod_detail->prod_attr);
							$attribute = '';
							foreach($attr as $prod_attr){
								$attribute .= $prod_attr->attr_name.': '.$prod_attr->item.', ';
							}
							
							$order_product['attribute'] = rtrim($attribute,', ');
						}else{
							$order_product['attribute'] = '';
						}
						
						$order_product_array[] = $order_product;
					}
				}
			
		}
		
		return array('order_summery'=>$order_summery, 'shipping_address'=>$shipping_address,'product_details'=>$order_product_array);

	}
	
	function change_order_status_details($order_id,$pid,$status1){
		$msg = "";
		$this->db->select("op.prod_id,op.status,op.prod_name,o.user_id,op.prod_price,ul.level_1");
				
		
		$this->db->where(array('op.order_id'=>$order_id,'op.prod_id'=>$pid));	

		$this->db->JOIN('orders o', 'o.order_id = op.order_id', 'INNER');
		$this->db->JOIN('appuser_login ul', 'ul.user_unique_id = o.user_id', 'INNER');
		
		$query_prod = $this->db->get('order_product op');
		
		if($query_prod->num_rows() >0){
			$order_prod_result = $query_prod->result_object();
			
			$status = $order_prod_result[0]->status;
			$prod_name = $order_prod_result[0]->prod_name;
			$user_id = $order_prod_result[0]->user_id;
			$prod_price = $order_prod_result[0]->prod_price;
			$level_1 = $order_prod_result[0]->level_1;
			
			$prod_commision_admin = ($prod_price * admin_commission)/100;
			$prod_commision = ($prod_price * level_1_commission)/100;
			
			if($status ==$status1){
				$msg = 'already_cancelled';
			}else if($status !='Delivered'){				
				$this->db->where(array('order_id'=>$order_id,'prod_id'=>$pid));		
		
				$query_prod1 = $this->db->update('order_product',array('status'=>$status1));
				
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
				$walet_history_upd['amount'] = $old_amount - $prod_commision_admin;
			
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
				$data_wallet_history['transaction_type'] = 'debit';
				$data_wallet_history['amount'] = $prod_commision_admin;
				$data_wallet_history['balance'] = $old_balance - $prod_commision_admin;
				$data_wallet_history['product_id'] = $pid;
				$data_wallet_history['order_id'] = $order_id;
				$data_wallet_history['user_id'] = $user_id;
				$data_wallet_history['remark'] = 'Return Order debit entry From '.$fullname; 
				$data_wallet_history['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history',$data_wallet_history);
				
				
				if($level_1 != admin_user_id && $level_1 != '')
				{
				
					$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');
				
					
					

					$this->db->select('*');
					$this->db->where(array('user_id' => $level_1));
					$query_wallet1 = $this->db->get('wallet_summery');
					
					$get_wallet = $query_wallet1->result_object()[0];
					
					
					$old_amount = $get_wallet->amount;
					$walet_history_upd['amount'] = $old_amount - $prod_commision;
				
					$this->db->where(array('user_id'=>$level_1));
					$this->db->update('wallet_summery', $walet_history_upd);
					
					$this->db->select('*');
					$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
					$this->db->order_by('id','DESC');
					$this->db->limit(1,0);
					$query_wallet_his1 = $this->db->get('wallet_transaction_history');
					
					$old_balance = 0;
					if($query_wallet_his1->num_rows() >0){
						$get_wallet = $query_wallet_his1->result_object()[0];
					
						$old_balance = $get_wallet->balance;
					}
						
					$this->db->select('*');
					$this->db->where(array('user_unique_id' => $user_id));
					$name_query = $this->db->get('appuser_login');
					
					$name_result1 = $name_query->result_object()[0];
						
					$fullname = $name_result1->fullname;	
					
					$data_wallet_history['wallet_id'] = $get_wallet->wallet_id;
					$data_wallet_history['payment_type'] = 0;
					$data_wallet_history['transaction_id'] = $transaction_id;
					$data_wallet_history['transaction_type'] = 'debit';
					$data_wallet_history['amount'] = $prod_commision;
					$data_wallet_history['balance'] = $old_balance - $prod_commision;
					$data_wallet_history['product_id'] = $pid;
					$data_wallet_history['order_id'] = $order_id;
					$data_wallet_history['user_id'] = $user_id;
					$data_wallet_history['remark'] = 'Return Order debit entry From '.$fullname; 
					$data_wallet_history['created_at'] = $this->date_time;
					$this->db->insert('wallet_transaction_history',$data_wallet_history); 
				}
				
				
				//$this->email_model->send_order_email($order_id,CANCEL_ORDER_TEMP, $pid);
				$msg = "done";
			}else{
				$msg = "invalid";
			}
		
		}else{
			$msg = "not_exist";
		}
		
		return $msg;
	}
	
	function seller_change_order_status_details($order_id,$pid,$status1){
		$msg = "";
		$this->db->select("op.prod_id,op.status,op.prod_name,o.user_id,op.prod_price,ul.level_1");
				
		
		$this->db->where(array('op.order_id'=>$order_id,'op.prod_id'=>$pid));	

		$this->db->JOIN('orders o', 'o.order_id = op.order_id', 'INNER');
		$this->db->JOIN('appuser_login ul', 'ul.user_unique_id = o.user_id', 'INNER');
		
		$query_prod = $this->db->get('order_product op');
		
		if($query_prod->num_rows() >0){
			$order_prod_result = $query_prod->result_object();
			
			$status = $order_prod_result[0]->status;
			$prod_name = $order_prod_result[0]->prod_name;
			$user_id = $order_prod_result[0]->user_id;
			$prod_price = $order_prod_result[0]->prod_price;
			$level_1 = $order_prod_result[0]->level_1;
			
			$prod_commision_admin = ($prod_price * admin_commission)/100;
			$prod_commision = ($prod_price * level_1_commission)/100;
			
			if($status == $status1 && $status1 == 'Cancelled' || $status == 'Cancelled'){
				$msg = 'already_cancelled';
			} else if($status1 != 'Cancelled' && $status != 'Cancelled'){
				
				$this->db->where(array('order_id'=>$order_id,'prod_id'=>$pid));		
		
				$query_prod1 = $this->db->update('order_product',array('status'=>$status1));
				
				$msg = 'done';
				
				
			}else if($status1 == 'Cancelled'){				
				$this->db->where(array('order_id'=>$order_id,'prod_id'=>$pid));		
		
				$query_prod1 = $this->db->update('order_product',array('status'=>$status1));
				
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
				$walet_history_upd['amount'] = $old_amount - $prod_commision_admin;
			
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
				$data_wallet_history['transaction_type'] = 'debit';
				$data_wallet_history['amount'] = $prod_commision_admin;
				$data_wallet_history['balance'] = $old_balance - $prod_commision_admin;
				$data_wallet_history['product_id'] = $pid;
				$data_wallet_history['order_id'] = $order_id;
				$data_wallet_history['user_id'] = $user_id;
				$data_wallet_history['remark'] = 'Return Order debit entry From '.$fullname; 
				$data_wallet_history['created_at'] = $this->date_time;
				$this->db->insert('wallet_transaction_history',$data_wallet_history);
				
				
				if($level_1 != admin_user_id && $level_1 != '')
				{
				
					$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');
				
					
					

					$this->db->select('*');
					$this->db->where(array('user_id' => $level_1));
					$query_wallet1 = $this->db->get('wallet_summery');
					
					$get_wallet = $query_wallet1->result_object()[0];
					
					
					$old_amount = $get_wallet->amount;
					$walet_history_upd['amount'] = $old_amount - $prod_commision;
				
					$this->db->where(array('user_id'=>$level_1));
					$this->db->update('wallet_summery', $walet_history_upd);
					
					$this->db->select('*');
					$this->db->where(array('wallet_id' => $get_wallet->wallet_id));
					$this->db->order_by('id','DESC');
					$this->db->limit(1,0);
					$query_wallet_his1 = $this->db->get('wallet_transaction_history');
					
					$old_balance = 0;
					if($query_wallet_his1->num_rows() >0){
						$get_wallet = $query_wallet_his1->result_object()[0];
					
						$old_balance = $get_wallet->balance;
					}
					
					$this->db->select('*');
					$this->db->where(array('user_unique_id' => $user_id));
					$name_query = $this->db->get('appuser_login');
					
					$name_result1 = $name_query->result_object()[0];
						
					$fullname = $name_result1->fullname;
					
					$data_wallet_history['wallet_id'] = $get_wallet->wallet_id;
					$data_wallet_history['payment_type'] = 0;
					$data_wallet_history['transaction_id'] = $transaction_id;
					$data_wallet_history['transaction_type'] = 'debit';
					$data_wallet_history['amount'] = $prod_commision;
					$data_wallet_history['balance'] = $old_balance - $prod_commision;
					$data_wallet_history['product_id'] = $pid;
					$data_wallet_history['order_id'] = $order_id;
					$data_wallet_history['user_id'] = $user_id;
					$data_wallet_history['remark'] = 'Return Order debit entry From '.$fullname; 
					$data_wallet_history['created_at'] = $this->date_time;
					$this->db->insert('wallet_transaction_history',$data_wallet_history); 
				}
				
				/*$this->email_model->send_order_email($order_id,CANCEL_ORDER_TEMP, $pid);*/
				$msg = "done";
			}else{
				$msg = "invalid";
			}
		
		}else{
			$msg = "not_exist";
		}
		
		return $msg;
	}
	
	function change_order_status_details_returned($order_id,$pid,$status1){
		$msg = "";
		$this->db->select("op.prod_id,op.status,op.prod_name,op.return_last_date,op.vendor_id");
				
		
		$this->db->where(array('op.order_id'=>$order_id,'op.prod_id'=>$pid));		
		
		$query_prod = $this->db->get('order_product op');
		
		if($query_prod->num_rows() >0){
			$order_prod_result = $query_prod->result_object();
			
			$status = $order_prod_result[0]->status;
			$prod_name = $order_prod_result[0]->prod_name;
			$return_last_date = $order_prod_result[0]->return_last_date;
			$vendor_id = $order_prod_result[0]->vendor_id;
			
			if($status ==$status1){
				$msg = 'already_returned';
			}else if($return_last_date < $this->date){
				$msg = "invalid";
			}else if($status == 'Delivered'){				
				$this->db->where(array('order_id'=>$order_id,'prod_id'=>$pid));		
		
				$query_prod1 = $this->db->update('order_product',array('status'=>'Return Requested'));
				
				$data['order_id'] = $order_id;
				$data['prod_id'] = $pid;
				$data['seller_id'] = $vendor_id;
				$data['create_at'] = $this->date_time;

				$this->db->insert('cancel_order_track', $data);
				
				$msg = "done";
			}else{
				$msg = "invalid";
			}
		
		}else{
			$msg = "not_exist";
		}
		
		return $msg;
	}
	
	 // kamal order api
    function get_order_list_detailsProd($langauge,$user_id){
/*		$this->db->select("o.order_id,o.status, o.total_price,o.payment_mode,o.create_date,	o.discount,o.total_qty");
		$this->db->where(array('o.user_id'=>$user_id));
		$this->db->order_by("o.sno",'desc'); 
		$query = $this->db->get('orders o');
*/		
     //   $sql = "SELECT o.order_id,o.status, o.total_price,o.payment_mode,o.create_date, o.discount,o.total_qty FROM orders o WHERE o.user_id = '$user_id'";
        $sql = "SELECT o.order_id, o.status, op.prod_id, op.vendor_id, op.prod_name ,  op.prod_name_ar , op.prod_img, op.prod_attr, o.total_price, op.qty, op.prod_price,op.shipping,
                op.status, op.discount, o.payment_mode,o.create_date, o.discount,o.total_qty FROM orders o, order_product op WHERE o.order_id= op.order_id
                AND o.user_id = '$user_id' ORDER BY  o.sno DESC";
        $query = $this->db->query($sql);// $query = $this->db->$sql;
		$product_detail_array = array();
		$orders = array();
		
		if($query->num_rows() >0){
			$order_result = $query->result_object();
			foreach($order_result as $order_detail){
				$orders['order_id'] = $order_detail->order_id;
				$orders['status'] = $order_detail->status;
				$orders['prod_id'] = $order_detail->prod_id;
				$orders['vendor_id'] = $order_detail->vendor_id;
				if($langauge ==1){
					$orders['prod_name'] = $order_detail->prod_name_ar;
				}else{
					$orders['prod_name'] = $order_detail->prod_name;
				}
				//$orders['prod_name'] = $order_detail->prod_name;
				$orders['prod_img'] = $order_detail->prod_img;
				$orders['prod_attr'] = $order_detail->prod_attr;
				$orders['prod_qty'] = $order_detail->qty;
				$orders['total_price'] = price_format($order_detail->total_price);
				$orders['prod_status'] = $order_detail->status;	
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = date('d-m-Y',strtotime($order_detail->create_date));
				$orders['deliverd_date'] = date('d-m-Y');
				
				$orders['order_tracking'] = $this->order_status_data($order_detail->order_id,$order_detail->prod_id);
				
				
				$product_detail_array[] = $orders;
			}
		}
		
		return $product_detail_array;

	}
	
	function order_status_data($order_id,$product_id)
	{
		$this->db->select('*');

		$this->db->where(array('order_id' => $order_id,'product_id' => $product_id));
		$query = $this->db->get('order_tracking_status');

		$banner_result = array();
		if ($query->num_rows() > 0) {
			$home_result = $query->result_object();
			foreach ($home_result as $order_tracking_status) {
				
				$cat_response = array();
				$cat_response['status'] = $order_tracking_status->status;
				$cat_response['message'] = $order_tracking_status->message;
				$cat_response['date'] = date('d-m-Y H:i:s A',strtotime($order_tracking_status->created_at));
				$banner_result[] = $cat_response;
				
			}
		}

		return $banner_result;
	}
	
	function get_order_full_detailsProd($user_id, $order_id){
		$this->db->select("o.order_id,o.status, o.total_price,o.payment_mode,o.create_date,
							o.discount,o.total_qty, o.fullname, o.mobile,o.locality, o.fulladdress,o.city,o.state,o.pincode,o.addresstype,o.email");
		

		$this->db->where(array('o.user_id'=>$user_id, 'o.order_id'=>$order_id));
		
		
		$query = $this->db->get('orders o');
		
		$order_summery = array('order_id'=>'','status'=>'','payment_mode'=>'','create_date'=>'','total_qty'=>'','total_price'=>'','discount'=>'');
		 $shipping_address = array('fullname'=>'','mobile'=>'','locality'=>'','fulladdress'=>'','city'=>'','state'=>'','pincode'=>'','addresstype'=>'','email'=>'');
		$orders =$shipping = array();
			$order_product_array = $order_product = array();
				
		if($query->num_rows() >0){
				$order_result = $query->result_object();
				$order_detail = $order_result[0];
				$orders['order_id'] = $order_detail->order_id;
				$orders['status'] = $order_detail->status;
				$orders['payment_mode'] = $order_detail->payment_mode;
				$orders['create_date'] = $order_detail->create_date;
				$orders['total_qty'] = $order_detail->total_qty;
				$orders['total_price'] = price_format($order_detail->total_price);
				$orders['discount'] = price_format($order_detail->discount);
				$orders['total_mrp'] = price_format($order_detail->discount+$order_detail->total_price);
				
				$order_summery = $orders;
				
				$shipping['fullname'] = $order_detail->fullname;
				$shipping['mobile'] = $order_detail->mobile;
				$shipping['locality'] = $order_detail->locality;
				$shipping['fulladdress'] = $order_detail->fulladdress;
				$shipping['city'] = $order_detail->city;
				$shipping['state'] = $order_detail->state;
				$shipping['pincode'] = $order_detail->pincode;
				$shipping['addresstype'] = $order_detail->addresstype;
				$shipping['email'] = $order_detail->email;
				
				$shipping_address = $shipping;
				
				$this->db->select("op.prod_id,op.prod_sku,op.prod_name,op.prod_img,op.prod_attr,op.qty,op.prod_price,op.shipping,op.discount,op.status, sl.companyname,sl.seller_unique_id");
				
				$this->db->JOIN('sellerlogin sl', 'sl.seller_unique_id = op.vendor_id','INNER');

				$this->db->where(array('op.order_id'=>$order_id));
				
				
				$query_prod = $this->db->get('order_product op');
				
			
				if($query_prod->num_rows() >0){
					$order_prod_result = $query_prod->result_object();
					
					foreach($order_prod_result as $order_prod_detail){
						$order_product['prod_id'] = $order_prod_detail->prod_id;
						$order_product['prod_sku'] = $order_prod_detail->prod_sku;
						$order_product['prod_name'] = $order_prod_detail->prod_name;
						$order_product['prod_img'] = $order_prod_detail->prod_img;
						$order_product['qty'] = $order_prod_detail->qty;
						$order_product['prod_price'] = price_format($order_prod_detail->prod_price);
						$order_product['shipping'] = price_format($order_prod_detail->shipping);
						$order_product['discount'] = price_format($order_prod_detail->discount);
						$order_product['prod_mrp'] = price_format($order_prod_detail->prod_price+$order_prod_detail->discount);
						$order_product['status'] = $order_prod_detail->status;
						$order_product['companyname'] = $order_prod_detail->companyname;
						$order_product['vendor_id'] = $order_prod_detail->seller_unique_id;
						$order_product['tax'] = 0;
						if($order_prod_detail->prod_attr){
							$attr = json_decode($order_prod_detail->prod_attr);
							$attribute = '';
							foreach($attr as $prod_attr){
								$attribute .= $prod_attr->attr_name.': '.$prod_attr->item.', ';
							}
							
							$order_product['attribute'] = rtrim($attribute,', ');
						}else{
							$order_product['attribute'] = '';
						}
						
						$order_product_array[] = $order_product;
					}
				}
			
		}
		
		return array('order_summery'=>$order_summery, 'shipping_address'=>$shipping_address,'product_details'=>$order_product_array);

	}
	/*
		Break All The Values In Valid Form
	*/
	
	function getValues($var){
		if(is_array($var)){
			$values = "'".implode("','" , $var )."'";
		}else{ 
			$delm = Array(",","\n");
			$values = "'".str_replace($delm , "','" , $var)."'";  
		}
		return $values;
	}
	
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
