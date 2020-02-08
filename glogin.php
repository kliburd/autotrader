<?php
error_reporting(0);
ob_start();
include("connect.inc.php");

/*
 * https://console.developers.google.com
 * https://www.google.com/settings/u/0/security
 */
$social_name="Google";

if(trim($_POST['myemail'])!="") finish_registration($social_name);
else g_login($social_name);

function g_login($social_name){
include("config.php");    
include_once("functions.inc.php");
require_once 'Google/Client.php';

$client_id = $gclientid;
$client_secret = $gclientsecret;
$redirect_uri = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"])."glogin.php";

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setAccessType("offline");
$client->setScopes("email");

if(isset($refresh_token) && !isset($_SESSION['access_token'])){
    $_SESSION['openid_identity']=$refresh_token;
    $_SESSION['access_token'] = $client->refreshToken($refresh_token);
}

if (isset($_GET['code']) && !isset($_SESSION['access_token'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $json=$_SESSION['access_token'];
  $g_attributes=json_decode($json, true);
  if(isset($g_attributes['refresh_token'])) $_SESSION['openid_identity']=$g_attributes['refresh_token'];
  include_once("Google/JWT.php");
  $id_token=JWT::decode($g_attributes['id_token'], $client_secret, false);
  $user_profile['email'] = $id_token->email;
  login_process($user_profile,$social_name);
  
} else {
  $authUrl = $client->createAuthUrl();
  header('Location: ' . $authUrl);
}
 

}
ob_flush();       
?>