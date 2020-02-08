<?php
error_reporting(0);
include("config.php");
include("functions.inc.php");
require_once('recaptcha/recaptchalib.php');
?>
<!DOCTYPE html>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
$MyBlogURL = $_SERVER['HTTP_HOST'];
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
if(trim($reCaptchaPrivateKey)!="" && trim($reCaptchaPublicKey)!=""){ 
$resp = recaptcha_check_answer ($reCaptchaPrivateKey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
if (!$resp->is_valid)$recaptchaResponse="no";
else $recaptchaResponse="yes";
}else $recaptchaResponse="yes";

$visitor_name=$_POST["visitor_name"];
$visitor_email=$_POST["visitor_email"];
$visitor_message=$_POST["visitor_message"];
$reid=mysqli_real_escape_string($coni,$_POST["reid"]);

if($reid!="contactuspage"){
$msgbody="$visitor_name has ".$relanguage_tags["sent you following message for your listing on"]." ".$_SERVER['HTTP_HOST']."<br /><br />
".$relanguage_tags["Name"].": $visitor_name<br />
".$relanguage_tags["Email"].": $visitor_email<br /><br />
<b>".$relanguage_tags["Message"]."</b><br /><br />
".nl2br($visitor_message)."<br /><br />
".$relanguage_tags["Listing id"].": $reid<br /><br />
-".$reSiteName;
$subject=$relanguage_tags["Message from your listing on "]."$reSiteName";

$qr="SELECT contact_name, contact_email FROM $reListingTable WHERE id='$reid'";
$result= mysqli_query($coni,$qr);
$row=mysqli_fetch_assoc($result);
$to_email=trim($row['contact_email']);
$to_name=trim($row['contact_name']);
mysqli_close($con);

if($to_name=="") $to_name="Poster";
//print $qr1."<br />";

}else{
	$msgbody="$visitor_name ".$relanguage_tags["has sent you following message through the contact us page of"]." ".$_SERVER['HTTP_HOST']."<br /><br />
	Name: $visitor_name<br />
	Email: $visitor_email<br /><br />
	<b>Message</b><br /><br />
	".nl2br($visitor_message)."<br /><br />
	-".$reSiteName;
	$subject=$relanguage_tags["Message from the contact us page of"]." $reSiteName";	
	$to_email=$contactformemail;
	$to_name=$reSiteName;
}
/*
if(trim($WordPressAPIKey)!=""){
	
	$akismet = new Akismet($MyBlogURL ,$WordPressAPIKey);
	$akismet->setCommentAuthor($visitor_name);
	$akismet->setCommentAuthorEmail($visitor_email);
	//$akismet->setCommentAuthorURL($url);
	$akismet->setCommentContent($visitor_message);
	if($akismet->isCommentSpam()){
		print "<h3 align='center'>Spam detected.</h3>";
		exit;
	}
}
*/

if ($recaptchaResponse=="no") {
 print "<h3 align='center'>".$relanguage_tags["The reCAPTCHA wasn't entered correctly"].". <a href='javascript:history.go(-1);'>".$relanguage_tags["Go back and try again"]."</a>.</h3>";
}else{ //send email
	sendReEmail($visitor_email,$msgbody,$to_email,$to_name,$subject);	
}

?>
</body>
</html>