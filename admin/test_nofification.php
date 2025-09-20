<?php
 echo "inside here 1";
 require_once 'google-api-php-client--PHP7.4/vendor/autoload.php';
$serviceAccountPath = 'bussinesshub-f206d-firebase-adminsdk-lxu9o-88590fb252.json';

// Your Firebase project ID
$projectId = 'bussinesshub-f206d';
use Google\Client;
function getAccessToken($serviceAccountPath) {
    echo " inside 1 ";
   $client = new Client();
   $client->setAuthConfig($serviceAccountPath);
   $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
   $client->useApplicationDefaultCredentials();
   $token = $client->fetchAccessTokenWithAssertion();
     echo " inside 2 ".$token;
   return $token['access_token'];
}


// URL for the FCM endpoint
$url = 'https://fcm.googleapis.com/v1/projects/bussinesshub-f206d/messages:send';

// Get the access token
$accessToken = getAccessToken($serviceAccountPath);

 echo "inside here 3";
// Message data
$message = [
    'message' => [
        'topic' => 'app_user',
        'notification' => [
            'title' => 'Notification Title',
            'body' => 'Notification Body'
        ]
    ]
];

// Convert message to JSON
$messageJson = json_encode($message);
 echo "<br>inside here 5";
// Send the request
$headers = [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
];

 echo "<br>inside here 6";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $messageJson);

 echo "<br>inside here 7";
$response = curl_exec($ch);

if ($response === FALSE) {
     echo "inside here 7";
    die('FCM Send Error: ' . curl_error($ch));
}

curl_close($ch);

echo 'FCM Response: ' . $response;

?>
