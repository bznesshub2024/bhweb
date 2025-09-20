<?php

		$smtp_host = 'smtpout.secureserver.net';
		$smtp_port = '465';
		$smtp_user = 'admin@bznesshub.com';
		$smtp_password = 'Mkir@53Gco56@s';
		$system_name = 'bznesshub';
		
		$toemail = 'chiragsavaliya67@gmail.com';
		$subject = 'test';
		$htmlMessage = 'data';
		
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
			echo 'Your email was sent, thanks chamil.';
		} else {
			show_error($CI->email->print_debugger());
		}
		