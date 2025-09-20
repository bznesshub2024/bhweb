<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


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
				$new_price = $currency.''.number_format($price,2);
			}else {
				$new_price = $currency.''.number_format($price);
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
		
		$CI =& get_instance();
		$CI->load->library('session');
		
		$CI->email->initialize($config);
		$CI->email->set_newline("\r\n");
		$CI->email->from($smtp_user, $system_name);
		$list = array($toemail);
		$CI->email->to($list);
		
		$CI->email->subject($subject);
		$CI->email->message($htmlMessage);



		if ($CI->email->send()) {
			//echo 'Your email was sent, thanks chamil.';
		} else {
			//show_error($CI->email->print_debugger());
		}
	}
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