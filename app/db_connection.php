<?php
//also change DB connection in cron folder 
define('HOST', 'localhost');
define('DB1', 'u774033453_bznesshub');
define('USER', 'u774033453_bznesshub');
define('PASS', '2CkbLC8HWFjY2rTn');


$conn = new mysqli(HOST, USER, PASS, DB1);

error_reporting(0);

$defaultstatus= "inactive";

$publickey_server ="9856325423368475";


define('BASEURL', "https://www.bznesshub.com/");

$image_size = 5000000;
$file_kb = ($image_size/1000).' KB';
 date_default_timezone_set("Asia/Kolkata");

$datetime = date('Y-m-d h:i:s');
$media_path = "../media/"; 


define('MEDIAURL',BASEURL."media/");
define('UPLOAD_URL', BASEURL . "media/");
$img_dimension_arr = array(array(72,72),array(200,200),array(280,310),array(400,200), array(430,590),array(600,810));
$img_dimension_arr_cat = array(array(72,72),array(200,200),array(400,200));
// app product image     - 185x250,     (185x205 no use) product details main - 430x 590
// website product image - 280x 380    (280x310 no use) 
// refer website sareewave - 360x460

// 1920x 670 = 2.86% of 1920 
$admin_name = "bussinesshub";
$admin_website = BASEURL;
$admin_emailid ="admin@bussinesshub.in";
$admin_phone = "+919999999999";

define('DELIVER_ORDER_TEMP',5);
define('CANCEL_ORDER_TEMP',2);define('sms_username','marurangecommerce');define('sms_password','79624227');define('sms_headername','MRURNG');define('sms_template_3','1707167698436768081');


require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
//require '../PHPMailer/PHPMailerAutoload.php';
//require '/home3/a2zshcic/public_html/PHPMailer/PHPMailerAutoload.php';
?>
