<?php 
include("config.php");
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = mysqli_real_escape_string($coni,$_POST['item_name']);
$item_number = mysqli_real_escape_string($coni,$_POST['item_number']);
$payment_status = mysqli_real_escape_string($coni,$_POST['payment_status']);
$payment_amount = mysqli_real_escape_string($coni,$_POST['mc_gross']);
$payment_currency = mysqli_real_escape_string($coni,$_POST['mc_currency']);
$txn_id = mysqli_real_escape_string($coni,$_POST['txn_id']);
$receiver_email = mysqli_real_escape_string($coni,$_POST['receiver_email']);
$payer_email = mysqli_real_escape_string($coni,$_POST['payer_email']);

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
	$info="Sucess: ".$item_name."<br />".$item_number."<br />".$payment_status."<br />".$payment_amount."<br />".$payment_currency."<br />".$txn_id;
	$upqr1="insert into ipn (info) values ('$info')";
	$result2=mysqli_query($coni,$upqr1);
	//$now_dttm=date("Y-m-d H:i:s");
	$dt_now = date("Y-m-d");
	$now_month = date("n");
	$now_day = date("j");
	$now_year = date("Y");
	$now_hour= date("H");
	$now_minute= date("i");
	$now_second= date("s");
	
	$minmonth = mktime($now_hour, $now_minute, $now_second, $now_month, $now_day + $featuredduration ,  $now_year );
	$future_dttm = date("Y-m-d H:i:s",$minmonth);
	$reqr1="update $reListingTable set listing_type='2', featured_till='$future_dttm' where id='$item_number' ";
	$resultre1=mysqli_query($coni,$reqr1);	
}
else if (strcmp ($res, "INVALID") == 0) {
$info="Failed: ".$item_name."<br />".$item_number."<br />".$payment_status."<br />".$payment_amount."<br />".$payment_currency."<br />".$txn_id;
	$upqr1="insert into ipn (info) values ('$info')";
	$result2=mysqli_query($coni,$upqr1);
}
}
fclose ($fp);
}
?>