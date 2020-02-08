<?php
error_reporting(0);
ob_start();
include("connect.inc.php");

$social_name="Yahoo";

if(trim($_POST['myemail'])!="") finish_registration($social_name);
else g_login($social_name);

function g_login($social_name){
include("config.php");    
include_once("functions.inc.php");
require 'openid/openid.php';

try {
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
    if(!$openid->mode) {
            $openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
            $openid->identity = 'https://me.yahoo.com';
            header('Location: ' . $openid->authUrl());
    } elseif($openid->mode == 'cancel') {
        echo '<h5 align="center">'.__("User has canceled authentication!").' <a href="index.php">'.__("Go back").'</a></h5>';
    } else {
        $openid->validate();
        $_SESSION['openid_identity']=$openid->identity;
        $userinfo = $openid->getAttributes(); 
        list($user_profile['username'],$temp)=split("@",$userinfo['contact/email']);
        $user_profile['email'] = $userinfo['contact/email'];
        $user_profile['name'] = $userinfo['namePerson/first']." ".$userinfo['namePerson/last'];
        login_process($user_profile,$social_name);
       
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}        
     
}


ob_flush();   
?>