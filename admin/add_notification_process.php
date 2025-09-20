<?php
include('session.php');

// API access key from Google API's Console

define( 'API_ACCESS_KEY', 'AAAAp4h_Mrw:APA91bGWtchLjIVk8rsoUDRisXHxa3XshHo7uM-UYqjaOTw4dDN7dO6hYaIEesSzvsgdC-h8QSpUC2x9BEiYEipLmqq8HFAIqAAZgLiGMx0Rv2SBrZsrMcbOCExGmRE-fxniMhXAVg6E');
//define( 'API_ACCESS_KEY', 'dXICYf_HSWWHfUyAM3bQIZ:APA91bG8VhbqnjnN265xTIsm94XW4w-Wg12inwbpjZ1SYzATngOnLrOy1aUTM_wYOro0qOQayWHtEBbu1zkGw0miPgwvApi2cMV7eodkDv_ByDl_lmPId3DkrrcKoylyjyNi2MzLAs8T');

//print_r($_FILES);
//die;

require_once 'google-api-php-client--PHP7.4/vendor/autoload.php';
$serviceAccountPath = 'bussinesshub-f206d-firebase-adminsdk-lxu9o-88590fb252.json';

// Your Firebase project ID
$projectId = 'bussinesshub-f206d';
use Google\Client;
function getAccessToken($serviceAccountPath) {
   $client = new Client();
   $client->setAuthConfig($serviceAccountPath);
   $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
   $client->useApplicationDefaultCredentials();
   $token = $client->fetchAccessTokenWithAssertion();
   return $token['access_token'];
}


// URL for the FCM endpoint
$url = 'https://fcm.googleapis.com/v1/projects/bussinesshub-f206d/messages:send';

// Get the access token
$accessToken = getAccessToken($serviceAccountPath);




// prep the bundle

if(isset($_POST['action']) && $_POST['action'] == 'sendNotification'){

    if($_POST['title'] == '')
	{
		$title = " ";
	}
	else
	{
		$title = $_POST['title'];
	}
	if($_POST['body'] == '')
	{
		$body = " ";
	}
	else
	{
		$body = $_POST['body'];
	}
	if($_POST['selectupsell'] == '')
	{
		$pid = "0";
		$sku = "0";
		$finalimage = "0";
		$name = "0";
	}
	else
	{
		$pid = $_POST['selectupsell'];
	}
	if($_POST['selectseller'] == '')
	{
		$sid = "0";
	}
	else
	{
		$sid = $_POST['selectseller'];
	}
	if($_POST['cid'] == '')
	{
		$cid = "0";
		$finalimage = "0";
		$name = "0";
	}
	else
	{
		$cid = $_POST['cid'];
		$stmt1 = $conn->prepare("SELECT cat_name, cat_img FROM category WHERE  cat_id = ?");
	   $stmt1->bind_param("s", $cid);
	   $stmt1->execute();	 
	   $data = $stmt1->bind_result( $col1, $col2);
		
		while ($stmt1->fetch()) {
			$name = $col1;
			$finalimage = $col2;
			/*$featured_img = $col2;
			$imgarray = json_decode($featured_img, true);
			$finalimage = $imgarray['430-590'];  */
		
		}
	}
	if($_POST['search'] == '')
	{
		$search = "0";
	}
	else
	{
		$search = $_POST['search'];
	}
	if($_POST['type'] == '')
	{
		$clicktype = "0";
	}
	else
	{
		$clicktype = $_POST['type'];
	}

		
	$home = "0";

	
	$stmt = $conn->prepare("SELECT prod_name, product_sku, featured_img FROM product_details WHERE  product_unique_id = ?");
   $stmt->bind_param("s", $pid);
   $stmt->execute();	 
   $data = $stmt->bind_result( $col1, $col2, $col3);
	
	while ($stmt->fetch()) {
		$name = $col1;
		$sku = $col2;
		$finalimage = $col3;
		/*$featured_img = $col3;
		$imgarray = json_decode($featured_img, true);
		$finalimage = $imgarray['430-590'];  */
	
	}
    $noti_image = $_FILES;
	//print_r($noti_image['image']);
    //die; 

    $currentimestamp=date("d-m-Y");

   // $obj=new Image();

  // $noti_image['image']['name']
  if($_FILES['notification_image']['name']) {
	  $Common_Function->img_dimension_arr = $img_dimension_arr;
	  $brand_image1 = $Common_Function->file_upload('notification_image',$media_path);
	  //$finalimage = json_encode($brand_image1);
	  $finalimage = $brand_image1['430-590'];
  }
  //print_r($brand_image1['600-600']);
 // print_r($finalimage);
  //echo " notiimge ".$finalimage;

    /*$msg = array

            (

                'body'  => $body,

                'title'     => $title,

                'vibrate'   => 1,

                'sound'     => 1,

                'imageUrl'	=> MEDIAURL.$brand_image1['430-590'],

                'image'	=> MEDIAURL.$brand_image1['430-590']

            );*/
			
	// clicktype - "1",pid - "12", cid - "0", search -"", home- "0"	
	
//print_r($msg);
  //$info = array('clicktype'=>$clicktype,'pid'=>$pid,'sid'=>$sid,'name'=>$name,'sku'=>$sku,'img'=>$finalimage, 'cid' => $cid, 'search' => $search, 'home' => $home);
  $stmt11 = $conn->prepare("INSERT INTO firebase_notification( clicktype, pid,prod_name,sid,noti_title,noti_body,sku,noti_img,cid,search,home,created_at)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");	$stmt11->bind_param( "ssssssssssss",  $clicktype, $pid,$name,$sid,$title,$body,$sku,$finalimage,$cid,$search,$home,$datetime);	$stmt11->execute();	$stmt11->store_result();
//print_r($info);
// clicktype 1 - tournament , clicktype = 7 homepage

/*$fields = array

(

    'to'  => '/topics/app_user',

    'notification'          => $msg,

    "data" => $info

);

$headers = array

(

    'Authorization: key=' . API_ACCESS_KEY,

    'Content-Type: application/json'

);*/


$message = [
    'message' => [
        'topic' => 'app_user',
        'notification' => [
            'title' => $title,
            'body' => $body,
			'image'	=> MEDIAURL.$finalimage
        ],
		'data' => [
			'clicktype' => $clicktype,
			'pid' => $pid,
			'sid' => $sid,
			'name' => $name,
			'sku' => $sku,
			'img' => $finalimage,
			'cid' => $cid,
			'search' => $search,
			'home' => $home
		]
    ]
];
$messageJson = json_encode($message);

$headers = [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $messageJson);

/*$ch = curl_init();

curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );

curl_setopt( $ch,CURLOPT_POST, true );

curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );

curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );

curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) ); */

$result = curl_exec($ch );

curl_close( $ch );

echo $result;
return $result;
}



?>