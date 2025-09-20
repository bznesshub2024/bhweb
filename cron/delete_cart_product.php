<?php

require_once('/var/www/vhosts/fleekmart.com/httpdocs/cron/db_connection.php');

ini_set('memory_limit','64M');
ini_set('max_execution_time', 0);

error_reporting(E_ERROR); 
ini_set('display_error','1');

if($argv[1] != 'b386732f449badb4fbbfcd79dce0d3b1'){
	echo "You don't have permission to execute this script.";
	die;		
}else{
	$date = date('Y-m-d', strtotime('today - 30 days'));
	$query1 = $conn->query("DELETE FROM `cartdetails` WHERE user_id = '' AND DATE(created_at) < '".$date."'");
}
?>