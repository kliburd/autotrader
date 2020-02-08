<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
//ob_start();
include("config.php");

$coni=mysqli_connect($host, $username, $password)or die("cannot connect");
mysqli_select_db($coni,$database)or die("cannot select DB");
mysqli_query($coni,"SET NAMES utf8");

$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysqli_real_escape_string($coni,$myusername);
$mypassword = mysqli_real_escape_string($coni,$mypassword);
$mypassword=md5($mypassword);

$sql="SELECT * FROM $rememberTable WHERE username='$myusername' and password='$mypassword' and status='Active' ";

$result=mysqli_query($coni,$sql);
$row=mysqli_fetch_assoc($result);
$count=mysqli_num_rows($result);

if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
//session_register("myusername");
$_SESSION["re_mem_id"]=$row['id'];
$_SESSION["memtype"]=$row['memtype'];
$_SESSION["myusername"]=$myusername;
//session_register("mypassword");
$_SESSION["mypassword"]=$mypassword;

//header("location:index.php?$requerystring");
//print "myusername: $myusername";

}
else {
echo "<h5 align='center'>".$relanguage_tags["Incorrect Username or Password"].". <a href='javascript:history.go(-1);'><b>".$relanguage_tags["Please try again"]."</b></a></h5>";
}

ob_end_flush();




?>