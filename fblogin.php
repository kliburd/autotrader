<?php
error_reporting(0);
include("connect.inc.php");

$social_name="facebook";

if(trim($_POST['myemail'])!="") finish_registration($social_name);
else fb_login();

function fb_login($social_name){
include("config.php");
require 'facebook/facebook.php';
$config = array();
$config['appId'] = $fb_app_id; 
$config['secret'] = $fb_app_secret; 

$facebook = new Facebook($config);

$user = $facebook->getUser();

if ($user) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me?fields=name,email');
		login_process($user_profile,$social_name);
				
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

// Login or logout url will be needed depending on current user state.
if ($user) {
	$logoutUrl = $facebook->getLogoutUrl();
} else {
	$login_url = $facebook->getLoginUrl(array('scope' => 'email'));
	header("Location: ".$login_url);
}

}


?>