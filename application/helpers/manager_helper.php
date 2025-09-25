<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('get_profile_image')) {
    function get_profile_image($user_id = null)
    {
        $CI =& get_instance();
        $CI->load->database();

        // if no user id passed, use session
        if ($user_id === null) {
            $user_id = $CI->session->userdata('user_id');
        }

        if (!$user_id) {
            return base_url('assets_web/images/icons/userprofile.png'); // fallback
        }

        $user = $CI->db->get_where('appuser_login', ['user_unique_id' => $user_id])->row();

        if (!empty($user) && !empty($user->profile_pic)) {
            return base_url('media/profile_pictures/'.$user->profile_pic);  // full path to stored image
        } else {
            return base_url('assets_web/images/icons/userprofile.png'); // fallback
        }
    }
}


if (!function_exists('check_wishlist')) {

   
    function check_wishlist($product_id, $user_id)
    {
        
        $CI =& get_instance(); // get CodeIgniter instance

        $CI->db->where('user_id', $user_id);
        $CI->db->where('prod_id', $product_id);
        $query = $CI->db->get('wishlistdetails'); // table name

        if($query->num_rows() > 0){
            return 1;
        } else {
            return 0;
        }

        //print_r([$product_id, $user_id]);
        //return $html;
    }
}


if ( ! function_exists('manager'))
{
	function manager($total_rows, $per_page_item) {
		$config['per_page']        = $per_page_item;
		$config['num_links']       = 2;
		$config['total_rows']      = $total_rows;
		$config['full_tag_open']   = '<ul class="pagination justify-content-end">';
		$config['full_tag_close']  = '</ul>';
		$config['prev_link']       = '<span class="page-link">Previous</span>';
		$config['prev_tag_open']   = '<li class="page-item">';
		$config['prev_tag_close']  = '</li>';
		$config['next_link']       = '<span class="page-link">Next</span>';
		$config['next_tag_open']   = '<li class="page-item">';
		$config['next_tag_close']  = '</li>';
		$config['cur_tag_open']    = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']   = '<span class="sr-only">(current)</span></span></li>';
		$config['num_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']   = '</span></li>';
		// $config['first_tag_open']  = '<span class="page-link">';
		// $config['first_tag_close'] = '</span>';
		// $config['last_tag_open']   = '<span class="page-link">';
		// $config['last_tag_close']  = '</span>';
		// $config['first_link']      = 'First';
		// $config['last_link']       = 'Last';
		$config['first_link'] = false;
		$config['last_link'] = false;
		return $config;
  }
}
if ( ! function_exists('get_settings'))
{

    function get_settings($type)
    {

        $CI = get_instance();
        $CI->load->database();
        $des = $CI->db->get_where('settings', array('type' => $type))->row('description');

        return $des;


    }
}


if ( ! function_exists('price_format'))
{

    function price_format($price)
    {
		$new_price =0;
		
		$currency = get_settings('system_currency_symbol');
		if($price>0){
			if (strpos($price,'.') !== false) {
			//	$new_price = $currency.''.number_format($price,2);
				$new_price = '₹ '.number_format($price,0);
			}else {
				//$new_price = $currency.''.number_format($price);
				$new_price = '₹ '.number_format($price);
			}
			
		}
        return $new_price;


    }
}

if ( ! function_exists('send_email_smtp'))
{

  function send_email_smtp($toemail,$htmlMessage,$subject){
		
		$smtp_host = get_settings('smtp_host');
		$smtp_port = get_settings('smtp_port');
		$smtp_user = get_settings('smtp_user');
		$system_email = get_settings('system_email');
		$smtp_password = get_settings('smtp_password');
		$system_name = get_settings('system_name');

		$config['protocol'] = "smtp";
		$config['smtp_host'] = $smtp_host;
		$config['smtp_port'] = $smtp_port;
		$config['smtp_user'] = $smtp_user;
		$config['smtp_pass'] = $smtp_password;
		$config['smtp_crypto'] = 'tls';
		$config['charset'] = "utf-8"; 
		$config['mailtype'] = "html";

		$CI = &get_instance();
		$CI->load->library('session');
		$CI->load->library('email');

		$CI->email->initialize($config);
		$CI->email->set_newline("\r\n");
		$CI->email->from($smtp_user, $system_name);
		$list = array($toemail);
		$CI->email->to($list);

		$CI->email->subject($subject);
		$CI->email->message($htmlMessage);

		if ($CI->email->send()) {
			return true;
		} else {
			 //show_error($CI->email->print_debugger());
			//log_message('error', 'Email sending failed. Error: ' . $CI->email->print_debugger());
			return false;
		}
		
	}
}
function minify($html)
{
	// Remove extra white spaces
	$html = preg_replace('/\s+/', ' ', $html);

	// Remove HTML comments
	$html = preg_replace('/<!--(.*?)-->/', '', $html);

	// Remove spaces around tags
	$html = preg_replace('/\s+<\s/', '<', $html);
	$html = preg_replace('/\s+>/', '>', $html);

	return $html;
}


if ( ! function_exists('removeSpecialCharacters'))
{

    function removeSpecialCharacters($value)
    {
		if(is_string($value)){
			if(!is_JSON($value)){
				
				$value = str_replace('"','&quot;',$value);
				$value = str_replace("'",'&#039;',$value);
				$value = str_replace("\\",'',$value);
				$value = str_replace("<",'&lt;',$value);
				$value = str_replace(">",'&gt;',$value);
			}else{
				$value = str_replace("<",'&lt;',$value);
				$value = str_replace(">",'&gt;',$value);
			}
		}
		return trim($value);
    }
}
if ( ! function_exists('is_JSON'))
{

    function is_JSON()
    {
		call_user_func_array("json_decode",func_get_args());
		return (json_last_error()===JSON_ERROR_NONE);
    }
}


if(!function_exists("get_curl")){
    function get_curl($url){
        $user_agent='Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/3B48b Safari/419.3';

        $headers = array
        (
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,fr;q=0.8;q=0.6,en;q=0.4,ar;q=0.2',
            'Accept-Encoding: gzip,deflate',
            'Accept-Charset: utf-8;q=0.7,*;q=0.7',
            'cookie:datr=; locale=en_US; sb=; pl=n; lu=gA; c_user=; xs=; act=; presence='
        ); 

        $ch = curl_init( $url );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "GET");
        curl_setopt($ch, CURLOPT_POST, false);     
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, base_url());

        $result = curl_exec( $ch );
       
        curl_close( $ch );

        return $result;
    }
}

function generate_invoice($ordersno, $product_id, $save_pdf)
	{
		
		require_once('./tcpdf/tcpdf.php');
		
		$files = glob('./media/invoice/*');
		array_map('unlink', $files);
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$system_name = get_settings('system_name');
		$currency = get_settings('system_currency_symbol');
		$system_email = get_settings('system_email');

		// set document information
		$pdf->SetCreator($system_name);
		$pdf->SetAuthor($system_name);
		$pdf->SetTitle($system_name);
		$pdf->SetSubject($system_name);
		$pdf->SetKeywords($system_name);

		// set default header data

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetHeaderData('media/google_play.png', PDF_HEADER_LOGO_WIDTH, '', '', array(0, 0, 0), array(255, 255, 255));
		$pdf->SetTitle('Invoice - ' . $_REQUEST["orderid"]);
		$pdf->SetMargins(20, 0, 20, true);
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$pdf->SetFont('freeserif', '', 8);
		$pdf->AddPage();

		
		
		$CI = get_instance();
		$CI->load->database();
		// Assuming you are inside a CodeIgniter controller method

		// First query
		$CI->db->select('o.order_id, o.user_id, o.status, o.total_price, o.payment_orderid, o.payment_id, o.payment_mode, o.qoute_id, DATE(o.create_date) as create_date_formatted, o.discount, o.total_qty, o.fullname, o.mobile, o.fulladdress, o.city, o.state, o.addresstype, o.email');
		$CI->db->from('orders o');
		$CI->db->where('o.order_id', $ordersno);
		$query = $CI->db->get();
		$data = $query->row_array(); // Assuming you want to get a single row
			

		// Second query
		$CI->db->select('name');
		$CI->db->from('country');
		$CI->db->where('id', $data['country']); // Assuming you got the country ID from the first query
		$query_country = $CI->db->get();
		$country_data = $query_country->row_array();
		$country_name = $country_data['name'];

		$address = $data['fulladdress'] . ', ' . $data['city'] . ', ' . $data['state'] . ', ' . $country_name;
		$create_date = date('d-m-Y', strtotime($data['create_date_formatted']));

		// Third query
		$CI->db->select('op.prod_id, op.prod_sku, op.prod_name, op.prod_img, op.prod_attr, op.qty, op.prod_price, op.shipping, op.discount, op.status, sl.companyname, op.invoice_number, op.vendor_id, vp.product_tax_class, op.product_hsn_code, op.product_unique_code, op.taxable_amount, op.cgst, op.sgst, op.igst,op.default_discount');
		$CI->db->from('order_product op');
		$CI->db->join('sellerlogin sl', 'sl.seller_unique_id = op.vendor_id');
		$CI->db->join('vendor_product vp', 'vp.product_id = op.prod_id');
		$CI->db->where('op.order_id', $ordersno);
		$CI->db->where('op.prod_id', $product_id); // Assuming $product_id is defined somewhere
		$query_product = $CI->db->get();
		$product_data = $query_product->row_array(); // Assuming you want to get a single row
		
		$prod_attr1 = '';
		$prod_attr = $product_data['prod_attr'];
		/*if ($prod_attr) {
				$attr = json_decode($prod_attr);
				$attribute = '';
				foreach ($attr as $prod_attr) {
					$attribute .= $prod_attr->attr_name . ': ' . $prod_attr->item . ', ';
				}

				$prod_attr1 = rtrim($attribute, ', ');
			}*/
			
		$prod_attr1 = is_array(json_decode($prod_attr)) ? rtrim(implode(', ', array_map(function ($prod_attr) {
			if (preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $prod_attr->item)) {
				list($r, $g, $b) = sscanf($prod_attr->item, "#%02x%02x%02x");
				$darkerColor = "rgb(" . ($r * 0.8) . ", " . ($g * 0.8) . ", " . ($b * 0.8) . ")";
				$label = $prod_attr->item . '&nbsp;<label style="height: 15px; width: 15px; border-radius: 20px !important;margin-bottom:3px; background-color: ' . $prod_attr->item . '; border: 1px solid ' . $darkerColor . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>';
				return $prod_attr->attr_name . ': ' . $label;
			} else {
				return $prod_attr->attr_name . ': ' . $prod_attr->item;
			}
			}, json_decode($prod_attr))), ', ') : '';	
			
		

		// Fourth query
		$CI->db->select('percent');
		$CI->db->from('tax');
		$CI->db->where('tax_id', $product_data['product_tax_class']); // Assuming you got the tax class from the third query
		$query_tax = $CI->db->get();
		$tax_data = $query_tax->row_array();
		$total_tax_percent = $tax_data['percent'];

		// Fifth query
		$CI->db->select('companyname, fullname, address, city, pincode, state, country, phone, email, logo, tax_number, pan_number, cin_number');
		$CI->db->from('sellerlogin');
		$CI->db->where('seller_unique_id', $product_data['vendor_id']); // Assuming you got the vendor ID from the third query
		$query_seller = $CI->db->get();
		$seller_data = $query_seller->row_array();
		$cname = $seller_data['companyname'];
		$address_seller = $seller_data['address'];
		// Retrieve other fields as needed
		
		$default_discount = 0;
		if($product_data['default_discount'] != '')
		{
			$default_discount = $product_data['default_discount'];
		}

		// Calculate tax value and subtotal
		$tax_value = ($product_data['prod_price'] * $product_data['qty']) - $product_data['taxable_amount'] - $default_discount;
		$subtotal = $product_data['taxable_amount'] + $tax_value;

		if ($seller_data['tax_number'] == '') {
			$query_admin = $CI->db->get_where('admin_login', array('seller_id' => 1));
			$admin_data = $query_admin->row_array();
			$tax = $admin_data['gst_no'];
		} else {
			$tax = $seller_data['tax_number'];
		}

		// Now you can use the retrieved data as needed in your application

		
		
		
		
		
		
		$seller_logo = '';
		if($logo != '')
		{		
			$seller_logo = UPLOAD_URL .$seller_data['logo'];
		}
		
		$gst_total = round($product_data['cgst'] + $product_data['sgst'] + $product_data['igst']);
		
		if($gst_total == 0)
		{
			 $invoice_title = 'Bill Of Supply';
		}
		else
		{
			 $invoice_title = 'Tax Invoice';
		}

		$html2 = '
		<html>
			<head></head>
			<body style="font-size: 8px;font-family:sans-serif;">
				<div style="text-align: left;">
					<img src="'.$seller_logo.'" alt="Logo"
						style="width: 50px; height: auto;">
				</div>
				<div style="text-align:center;">
					<b>'. $invoice_title .'</b>
				</div>
				<table style="line-height: 1.5; margin-bottom:10px">
					<tr><td ><b style="font-size:10px;">Sold By: <span style="font-size:9px;">' . $cname . '</span></b> </td>
						<td style="text-align:right;"><b>Invoice Number:</b> #' . $product_data['invoice_number'] . '</td>
					</tr>
					<tr>
						<td colspan="2"><b style="font-size:10px;">Ship-from Address:</b> <span style="font-size:8px;">' . $address_seller . '</span></td>
					</tr>
					<tr>
						<td colspan="2" style="font-size:10px;"><b style="font-size:10px;">GSTIN: </b>' . $tax . '</td>
					</tr>				
				</table>
				<h1></h1>
				<div style="text-align: left;border-top:1px solid #000;"></div>
				<table style="line-height: 1.5;">
					<tr>
						<td width="35%"><b  style="font-size:9px;">Order ID:</b> <span style="font-size:8px;">' . $ordersno . ' </span></td>
						<td width="25%" style="text-align:left;font-size:9px;"><b>Bill To</b></td>
						<td width="25%" style="text-align:left;font-size:9px;"><b>Shipping To</b></td>
						<td width="15%"style="text-align:left;"></td>
					</tr>
					<tr>
						<td><b  style="font-size:9px;">Order Date:</b> <span style="font-size:8px;">' . $create_date . '</span></td>
						<td style="text-align:left;font-size:9px;"><b>' . $data['fullname'] . '</b></td>
						<td style="text-align:left;font-size:9px;"><b>' . $data['fullname'] . '</b></td>
						<td style="font-size:8px;text-align:left;" rowspan="5"></td>
					</tr>
					<tr>
						<td><b  style="font-size:9px;">Invoice Date:</b> <span style="font-size:8px;"> ' . $create_date . '</span></td>
						<td style="text-align:left;"><span style="font-size:8px;">' . $address . '</span></td>
						<td style="text-align:left;"><span style="font-size:8px;">' . $address . '</span></td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:left;"><b  style="font-size:9px;">Phone:</b> <span style="font-size:8px;"> ' . $data['mobile'] . '</span></td>
						<td style="text-align:left;"><b  style="font-size:9px;">Phone:</b> <span style="font-size:8px;"> ' . $data['mobile'] . '</span></td>
					</tr>
					
				</table>
				<div></div>
				<div style="border-bottom:1px solid #000;">
					<table style="line-height: 2; width:100%; font-size: 8px;">
						<tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
							<td style="border:1px solid #cccccc;width:140px;">Item Description</td>
							<td style = "text-align:right;border:1px solid #cccccc;width:60px">MRP (Rs.)</td>
							<td style = "text-align:right;border:1px solid #cccccc;width:55px;">Discount</td>
							<td style = "text-align:right;border:1px solid #cccccc;width:30px;">Qty</td>
							<td style = "text-align:right;border:1px solid #cccccc;width:48px;">Gross Amount</td>
							<td style = "text-align:right;border:1px solid #cccccc;width:48px;">Taxable Amount</td>
							<td style = "text-align:right;border:1px solid #cccccc;width:35px;">GST</td>
							<td style = "text-align:right;border:1px solid #cccccc;width:66px;">Subtotal (Rs.)</td>
						</tr>
						<tr>
							<td style="border:1px solid #cccccc;">' . $product_data['prod_name'] . '<br>HSN : ' . $product_data['product_hsn_code'] . '<br>' . $prod_attr1 . '</td>
							<td style = "text-align:right; border:1px solid #cccccc;">' . number_format($product_data['prod_price'] + $product_data['discount']) . '</td>
							<td style = "text-align:right; border:1px solid #cccccc;">' . number_format($product_data['discount']) . '</td>
							<td style = "text-align:right; border:1px solid #cccccc;">' . number_format($product_data['qty']) . '</td>
							<td style = "text-align:right; border:1px solid #cccccc;">' . number_format(($product_data['prod_price'] * $product_data['qty'])) . '</td>
							<td style = "text-align:right; border:1px solid #cccccc;">' . $product_data['taxable_amount'] . '</td>
							<td style = "text-align:right; border:1px solid #cccccc;">' . $gst_total . '</td>
							<td style = "text-align:right; border:1px solid #cccccc;">' . $subtotal . '</td>
						</tr>
						<tr style = "font-weight: bold;">
							<td colspan="2"></td>
							<td style = "text-align:right;" colspan="4">CGST (Rs.)</td>
							<td style = "text-align:right;" colspan="2">' . round($product_data['cgst'],2) . '</td>
						</tr>
						<tr style = "font-weight: bold;">
							<td colspan="2"></td>
							<td style = "text-align:right;" colspan="4">SGST (Rs.)</td>
							<td style = "text-align:right;" colspan="2">' . round($product_data['sgst'],2) . '</td>
						</tr>
						<tr style = "font-weight: bold;">
							<td colspan="2"></td>
							<td style = "text-align:right;" colspan="4">IGST (Rs.)</td>
							<td style = "text-align:right;" colspan="2">' . round($product_data['igst'],2) . '</td>
						</tr>
						<tr style = "font-weight: bold;">
							<td colspan="2"></td>
							<td style = "text-align:right;" colspan="4">Shipping (Rs.)</td>
							<td style = "text-align:right;" colspan="2">' . number_format($product_data['shipping']) . '</td>
						</tr>
						<tr style = "font-weight: bold;">
							<td colspan="2"></td>
							<td style = "text-align:right;" colspan="4">BH Customer Discount (Rs.)</td>
							<td style = "text-align:right;" colspan="2">-' . $default_discount . '</td>
						</tr>
						<tr style = "font-weight: bold;">
							<td colspan="2"></td>
							<td style = "text-align:right;" colspan="4">Total (Included GST)</td>
							<td style = "text-align:right;" colspan="2">Rs.' . number_format(($subtotal + $product_data['shipping'])) . '</td>
						</tr>
						<tr><td colspan="10" style = "text-align:right;"><span style="font-size:10px;">' . $cname . '</span></td></tr>
						<tr><td></td></tr>
						<tr>
							<td style = "text-align:right;" colspan="10">Authorized Signatory</td>
						</tr>
					</table>
				</div>
				<p><i>Note: This is a computer generated invoice doesn’t require signature.</i></p>
			</body>
		</html>';

	

		$pdf->writeHTML($html2, true, false, true, false, '');
		// print_r($html2);
		// exit;
		$file_name = 'Invoice-' . $product_data['invoice_number'] . '.pdf';
		//Close and output PDF document
		if ($save_pdf) {
			$pdf_string = $pdf->Output($file_name, 'S');
			$file_path = './media/invoice/' . $file_name;
			file_put_contents($file_path, $pdf_string);

			return $file_path;
		} else {
			$pdf_string = $pdf->Output($file_name, 'D');
		}
	}
	
	function hexToRgb($hex)
{
    // Remove the "#" symbol
    $hex = str_replace("#", "", $hex);
    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return array("r" => $r, "g" => $g, "b" => $b);
}

	
	function getDarkColorStyle($color)
{
    $rgb = hexToRgb($color);
    $dark_color = "rgb(" . $rgb['r'] * 0.8 . "," . $rgb['g'] * 0.8 . ',' . $rgb['b'] * 0.8 . ")";
    return 'background-color:' . $color . '; border: 1px solid ' . $dark_color . ';';
}