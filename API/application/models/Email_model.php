<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		$this->date_time = date('Y-m-d H:i:s');
    }

	function send_order_email_admin_seller($order_id){
	    //query for get order _details
			$this->db->select("total_price, create_date, fullname,mobile,locality,fulladdress,city,state,pincode,addresstype,email");
		
			$this->db->where(array('order_id'=>$order_id));		
			
			$query_order = $this->db->get('orders');
			
			$total_price=$create_date=$fullname= '';
			if($query_order->num_rows() >0){
				$order_result = $query_order->result_object();
				
				$total_price = price_format($order_result[0]->total_price);
				$create_date = date("M d, Y", strtotime($order_result[0]->create_date));
				$fullname = $order_result[0]->fullname;
				$mobile = $order_result[0]->mobile;
				$toemail = $order_result[0]->email;
				
			}
			
			
		//code for get order product details
		
		$this->db->select("op.prod_name, sl.companyname,sl.email,op.qty,op.prod_price,op.shipping,op.discount");
		//join for get vendor product
		$this->db->join('sellerlogin sl', 'sl.seller_unique_id = op.vendor_id','INNER');
			
		$this->db->where(array('op.order_id'=>$order_id));
		
		$query_prod = $this->db->get('order_product op');
		
		$partner_email =$partner_name=$product_name='';
	 
		if($query_prod->num_rows() >0){
		    $orderp_result = $query_prod->result_object();
		    $product_name = $orderp_result[0]->prod_name;
            $partner_name = $orderp_result[0]->companyname;
            $partner_email = $orderp_result[0]->email;
			
			$qty = $orderp_result->qty;
			$prod_price = price_format($orderp_result->prod_price);
			$shipping = price_format($orderp_result->shipping);
			$discount = price_format($orderp_result->discount);
			$total_paid += (($orderp_result->prod_price*$orderp_result->qty)+$orderp_result->shipping);
            
		}
			
	    //send to admin
		$messageadmin  = "<html><body>";
	
		$messageadmin .= "<table width='500px;' align='center' border='1' cellpadding='0' cellspacing='0' style='font-family: sans-serif;background: rgba(220, 220, 220, 0.17);font-size: 14px;'>";
			
		$messageadmin .= "<tbody>
						<tr>
							<td colspan='2'>Hello Admin</td>
						</tr>
						<tr><td style='padding: 10px;' colspan='2'> </td></tr>	
						<tr>
							<td style='padding: 10px;font-weight: 600;'>Order ID</td>
							<td style='padding: 10px;'>".$order_id." </td>
						</tr>
						<tr>
							<td style='padding: 10px;font-weight: 600;'>Seller Name</td>
							<td style='padding: 10px;'>".$partner_name." </td>
						</tr>
						<tr>
							<td style='padding: 10px;font-weight: 600;'>Order Date</td>
							<td style='padding: 10px;'>".$create_date." </td>
						</tr>
						<tr>
							<td style='padding: 10px;font-weight: 600;'>User Name</td>
							<td style='padding: 10px;'>".$fullname." </td>
						</tr>
                        <tr>
							<td style='padding: 10px;font-weight: 600;'>Amount</td>
							<td style='padding: 10px;'>".$total_paid." </td>
						</tr>
						<tr>
							<td style='padding: 10px;' colspan='2'> <a style='background-color: #2979fb; color: #fff; padding: 0px; border: 0px; font-size: 14px; display: inline-block; margin-top: 0px; border-radius: 2px; text-decoration: none; width: 160px; text-align: center; line-height: 32px;' href='{MANAGE_ORDER}' target='_blank' rel='noopener noreferrer' data-mce-href='{MANAGE_ORDER}' data-mce-style='background-color: #2979fb; color: #fff; padding: 0px; border: 0px; font-size: 14px; display: inline-block; margin-top: 0px; border-radius: 2px; text-decoration: none; width: 160px; text-align: center; line-height: 32px;'
							href='".SITE_URL."admin/manage_orders.php?status=pending' >Manage Your Order</a></td>
						</tr>
					</tbody>";
    
		$messageadmin .= "</table>";
			
		$messageadmin .= "</body></html>";
				
		$admin_email = get_settings('system_email');
		$admin_subj = 'New Order received for - '.$partner_name; 
		if($admin_email){
	    	send_email_smtp($admin_email,$messageadmin,$admin_subj);
		}
		
		
		//send email to 
		
		  //send to vendor
		$messagevendor  = "<html><body>";
	
		$messagevendor .= "<table width='500px;' align='center' border='1' cellpadding='0' cellspacing='0' style='font-family: sans-serif;background: rgba(220, 220, 220, 0.17);font-size: 14px;'>";
			
		$messagevendor .= "<tbody>
						<tr>
							<td colspan='2'>HI ".$partner_name."</td>
						</tr>
						<tr><td style='padding: 10px;' colspan='2'> </td></tr>	
						<tr>
							<td style='padding: 10px;font-weight: 600;'>Order ID</td>
							<td style='padding: 10px;'>".$order_id." </td>
						</tr>
						
						<tr>
							<td style='padding: 10px;font-weight: 600;'>Order Date</td>
							<td style='padding: 10px;'>".$create_date." </td>
						</tr>
						<tr>
							<td style='padding: 10px;font-weight: 600;'>Product Name</td>
							<td style='padding: 10px;'>".$product_name." </td>
						</tr>
                      <tr>
							<td style='padding: 10px;' colspan='2'> <a style='background-color: #2979fb; color: #fff; padding: 0px; border: 0px; font-size: 14px; display: inline-block; margin-top: 0px; border-radius: 2px; text-decoration: none; width: 160px; text-align: center; line-height: 32px;' href='{MANAGE_ORDER}' target='_blank' rel='noopener noreferrer' data-mce-href='{MANAGE_ORDER}' data-mce-style='background-color: #2979fb; color: #fff; padding: 0px; border: 0px; font-size: 14px; display: inline-block; margin-top: 0px; border-radius: 2px; text-decoration: none; width: 160px; text-align: center; line-height: 32px;'
							href='".SITE_URL."vendor/manage_orders.php?status=pending' >Manage Your Order</a></td>
						</tr>
					</tbody>";
    
		$messagevendor .= "</table>";
			
		$messagevendor .= "</body></html>";
				
	
		$vendor_subj = 'Confirmation required for new order received'; 
		if($partner_email){
		    send_email_smtp($partner_email,$messagevendor,$vendor_subj);
			$header = "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";
			//$retval = mail($partner_email,$vendor_subj,$messagevendor,$header);
	 
			 if( $retval == true ) {
				//echo "Message sent successfully...";
			 }else {
				//echo "Message could not be sent...";
			 }
			
		}
	    
	}
	
	function send_order_email($order_id,$template_id, $prod_id=''){
		if(!$template_id){
			return false;
		}
		
		$this->db->select("email_title, email_subject, email_body");
		
		$this->db->where(array('id'=>$template_id));		
		
		$query = $this->db->get('email_template');
		
		
		if($query->num_rows() >0){
			$email_result = $query->result_object();
			$subject = $email_result[0]->email_subject;
			$email_body = $email_result[0]->email_body;
		
			//query for get order _details
			$this->db->select("total_price, create_date, fullname,mobile,locality,fulladdress,city,state,pincode,addresstype,email");
		
			$this->db->where(array('order_id'=>$order_id));		
			
			$query_order = $this->db->get('orders');
			
			if($query_order->num_rows() >0){
				$order_result = $query_order->result_object();
				
				
				$create_date = date("M d, Y", strtotime($order_result[0]->create_date));
				$fullname = $order_result[0]->fullname;
				$mobile = $order_result[0]->mobile;
				$toemail = $order_result[0]->email;
				$address = $order_result[0]->fulladdress.'<br>'.$order_result[0]->locality.'<br>'.$order_result[0]->city.','.$order_result[0]->state.','.$order_result[0]->pincode;
				$android_app_link = get_settings('android_app_link');
				$ios_app_link = get_settings('ios_app_link');
				$system_name = get_settings('system_name');
				$ios_app_link_img = MEDIA_URL.'ios_store.png';
				$and_app_img =  MEDIA_URL.'google_play.png';
				
				
				$email_body = str_replace(array('{USER_NAME}','USER_NAME'),$fullname,$email_body);
				$email_body = str_replace(array('{ORDER_DATE}','ORDER_DATE'),$create_date,$email_body);
				$email_body = str_replace(array('{ORDER_ID}','ORDER_ID'),$order_id,$email_body);
				$email_body = str_replace(array('{USER_ADDRESS}','USER_ADDRESS'),$address,$email_body);
				$email_body = str_replace(array('{USER_PHONE}','USER_PHONE'),$mobile,$email_body);
				$email_body = str_replace(array('{STORE_NAME}','STORE_NAME'),$system_name,$email_body);
				$email_body = str_replace(array('{APP_LINK}','APP_LINK'),$android_app_link,$email_body);
				$email_body = str_replace(array('{IOS_APP}','IOS_APP'),$ios_app_link,$email_body);
				$email_body = str_replace(array('{AND_LINK_IMG}','AND_LINK_IMG'),$and_app_img,$email_body);
				$email_body = str_replace(array('{IOS_LINK_IMG}','IOS_LINK_IMG'),$ios_app_link_img,$email_body);
				$email_body = str_replace(array('{USER_EMAIL}','USER_EMAIL'),$toemail,$email_body);
				
				//query for get order _details
				$this->db->select("prod_name, prod_img, prod_attr,qty,prod_price,shipping,discount,delivery_date,companyname");
				$this->db->join('sellerlogin sl', 'sl.seller_unique_id = op.vendor_id','INNER');
				
				if($prod_id){
					$this->db->where(array('order_id'=>$order_id,'prod_id'=>$prod_id));		
				}else{
					$this->db->where(array('order_id'=>$order_id));		
				}				
				
				$query_order_prod = $this->db->get('order_product op');
				
				$html ='';
				$total_paid=0;
				if($query_order_prod->num_rows() >0){
					$order_prod_result = $query_order_prod->result_object();
					foreach($order_prod_result as $prod_details){
						$prod_name = $prod_details->prod_name;
						$prod_img = MEDIA_URL.$prod_details->prod_img;
						$prod_attr = $prod_details->prod_attr;
						$qty = $prod_details->qty;
						$prod_price = price_format($prod_details->prod_price);
						$shipping = price_format($prod_details->shipping);
						$discount = price_format($prod_details->discount);
						$delivery_date = date("M d, Y", strtotime($prod_details->delivery_date));
						$companyname = $prod_details->companyname;
						$total_paid += (($prod_details->prod_price*$prod_details->qty)+$prod_details->shipping);
						
						$html .='<tr>
								<td align="left">
									<table class="m_-4345841705994091849col" border="0" cellspacing="0" cellpadding="0" align="left">
										<tbody>
											<tr>
												<td class="m_-4345841705994091849link" style="padding-top: 20px;" align="center" valign="middle" width="120">
													<a style="color: #fff; text-decoration: none; outline: none; font-size: 13px;" href="" target="_blank" rel="noopener noreferrer">
														<img class="CToWUd" style="border: none; max-width: 125px; max-height: 125px;" src="'.$prod_img.'" alt="'.$prod_name.'" border="0" />
													</a>
												</td>
												<td style="padding-top: 20px; padding-left: 15px;" align="left" valign="top">
													<p class="m_-4345841705994091849link" style="margin-top: 0; margin-bottom: 7px;">
														<a style="font-family: Arial; font-size: 14px; font-weight: normal; font-style: normal; font-stretch: normal; line-height: 20px; color: #212121; text-decoration: none!important; word-spacing: 0.2em; max-width: 360px; display: inline-block; min-width: 352px; width: 352px;" href="" target="_blank" rel="noopener noreferrer">'.$prod_name.'</a>
														<span style="min-width: 100px; font-size: 12px; font-weight: bold; padding-right: 0px; line-height: 20px; text-align: right; display: inline-block; float: right;"> '.$prod_price.'</span>
													</p>
													<p style="line-height: 18px; margin-top: 0px; margin-bottom: 2px; font-family: Arial; font-size: 12px; color: #212121;">Delivery 
														<span style="line-height: 18px; font-family: Arial; font-size: 12px; font-weight: bold; color: #139b3b;"> by '.$delivery_date.'  </span>
													</p>
													<p style="line-height: 18px; margin-top: 0px; margin-bottom: 2px; font-family: Arial; font-size: 12px; color: #212121;">Seller: '.$companyname.'
														<span style="float: right; font-size: 12px; padding-right: 5px;">
															<span style="color: #878787; text-align: right; margin-right: 5px;">Delivery charges</span>
															<span style="float: right; text-align: right;">'.$shipping.'</span>
														</span>
													</p>
													<p style="line-height: 18px; margin-top: 0px; margin-bottom: 0px; font-family: Arial; font-style: normal; font-size: 12px; font-stretch: normal; color: #212121;">Qty: '.$qty.'</p>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>';
						
					}
				}
				
				$total_price = price_format($total_paid);
				$email_body = str_replace(array('{AMOUNT_PAID}','AMOUNT_PAID'),$total_price,$email_body);
				$email_body = str_replace(array('{PRODUCTS_DETAILS}','PRODUCTS_DETAILS'),$html,$email_body);
				
				//echo $email_body;
				send_email_smtp($toemail,$email_body,$subject);
				$header = "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";
				//$retval = mail($toemail,$subject,$email_body,$header);
         
				 if( $retval == true ) {
					//echo "Message sent successfully...";
				 }else {
					//echo "Message could not be sent...";
				 }
			}
				
		}
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
	
	// string of specified length 
	function random_strings($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}
   
}
