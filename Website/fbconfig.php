<?php
session_start();
// added in v4.0.0
require 'vendor/facebook/graph-sdk/src/Facebook/autoload.php';
include './Classes/Entities/EntityBase.php';
include './Classes/Entities/User.php';


use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphLocation;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;


$fb = new Facebook\Facebook([
  'app_id' => '1504323456292270',
  'app_secret' => '946d6447c4f44aeecc5ee101e0ac146b',
  'default_graph_version' => 'v2.9',
  ]);

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
 $helper = $fb->getRedirectLoginHelper();

$permissions = ['email','user_location']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://sitejinni.com/fbcallback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}


?>