<?php
session_start();
// added in v4.0.0
require 'vendor/facebook/graph-sdk/src/Facebook/autoload.php';
include './Classes/Entities/EntityBase.php';
include './Classes/Entities/User.php';
include './Classes/DataAccess.php';


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

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
    $response = $fb->get("/me?fields=id,name,email,location", $accessToken);
    $gobject = $response->getGraphUser();
    $fullname = $gobject->getName();
    $namearr = str_getcsv($fullname, " ");
    $user = new User($gobject->getEmail(), "FBLOGIN", $gobject->getEmail(), $namearr[0], 
                     $namearr[1], $gobject->getLocation()->getField("name"), "", "", 
                     "", "", "", "", "", "");

    $exuser = User::GetUserbyID($user->userid);
    if($exuser == NULL)
        $user->AddEntity ();

    $_SESSION["user"] = $user;
    if(isset($_SESSION["destpage"]) && $_SESSION["destpage"] != NULL) {
        $destpage = $_SESSION["destpage"];
        unset($_SESSION["destpage"]);
        die('<script type="text/javascript">window.location.href="http://' . $destpage . '";</script>');
    } else {
        die('<script type="text/javascript">window.location.href="userPortfolioPage.php";</script>');
    }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

