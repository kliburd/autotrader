<?php
if($memtype==9){ 
include_once("functions.inc.php");
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
if(function_exists('set_magic_quotes_runtime')) @set_magic_quotes_runtime(0);
if((function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc() == 1) || @ini_get('magic_quotes_sybase')) $_POST = remove_magic($_POST);

if($ptype=="UpdateAdminOptions"){
$siteoutercolor=mysqli_real_escape_string($coni,$_POST['siteoutercolor']);
$siteheadercolor=mysqli_real_escape_string($coni,$_POST['siteheadercolor']);
$siteheaderfontcolor=mysqli_real_escape_string($coni,$_POST['siteheaderfontcolor']);
$siteinnercolor=mysqli_real_escape_string($coni,$_POST['siteinnercolor']);
$sitebordercolor=mysqli_real_escape_string($coni,$_POST['sitebordercolor']);
$sitefooterfontcolor=mysqli_real_escape_string($coni,$_POST['sitefooterfontcolor']);
$fixedtopheader=mysqli_real_escape_string($coni,$_POST['fixedtopheader']);

$searchformcolor=mysqli_real_escape_string($coni,$_POST['searchformcolor']);
$searchformbordercolor=mysqli_real_escape_string($coni,$_POST['searchformbordercolor']);
$searchformfontcolor=mysqli_real_escape_string($coni,$_POST['searchformfontcolor']);
$webtheme=mysqli_real_escape_string($coni,$_POST['webtheme']);
$fieldtheme=mysqli_real_escape_string($coni,$_POST['fieldtheme']);
$menuboxcolor=mysqli_real_escape_string($coni,$_POST['menuboxcolor']);
$menuboxfontcolor=mysqli_real_escape_string($coni,$_POST['menuboxfontcolor']);

$menuboxbordercolor=mysqli_real_escape_string($coni,$_POST['menuboxbordercolor']);
$websitetitle=mysqli_real_escape_string($coni,$_POST['websitetitle']);
$googlemapapikey=mysqli_real_escape_string($coni,$_POST['googlemapapikey']);
$logoname = $_FILES['photoimg']['name'];
$removewebsitelogo=mysqli_real_escape_string($coni,$_POST['removewebsitelogo']);
$websitefooter=mysqli_real_escape_string($coni,$_POST['websitefooter']);
$defaultcountry=mysqli_real_escape_string($coni,$_POST['defaultcountry']);
$defaultcurrency=mysqli_real_escape_string($coni,$_POST['defaultcurrency']);
$defaultlanguage=mysqli_real_escape_string($coni,$_POST['defaultlanguage']);
$refriendlyurl=mysqli_real_escape_string($coni,$_POST['refriendlyurl']);
$geoipenable=mysqli_real_escape_string($coni,$_POST['geoipenable']);
$emaildebug=mysqli_real_escape_string($coni,$_POST['emaildebug']);

$ppcurrency=mysqli_real_escape_string($coni,$_POST['ppcurrency']);
$ppemail=mysqli_real_escape_string($coni,$_POST['ppemail']);
$featuredduration=mysqli_real_escape_string($coni,$_POST['featuredduration']);
$featuredprice=mysqli_real_escape_string($coni,$_POST['featuredprice']);
$notifyadmin=mysqli_real_escape_string($coni,$_POST['notifyadmin']);
$listingreview=mysqli_real_escape_string($coni,$_POST['listingreview']);
$listingemail=mysqli_real_escape_string($coni,$_POST['listingemail']);
$headlinelength=mysqli_real_escape_string($coni,$_POST['headlinelength']);
$descriptionlength=mysqli_real_escape_string($coni,$_POST['descriptionlength']);

$smtpauth=mysqli_real_escape_string($coni,$_POST['smtpauth']);
$resmtp=mysqli_real_escape_string($coni,$_POST['resmtp']);
$resmtpport=mysqli_real_escape_string($coni,$_POST['resmtpport']);
$smtpusername=mysqli_real_escape_string($coni,$_POST['smtpusername']);
$smtppassword=mysqli_real_escape_string($coni,$_POST['smtppassword']);
if(trim($smtppassword)==".......") $smtpPasswordClause="";
else $smtpPasswordClause=",smtppassword='$smtppassword'";
$googlemapapikey=mysqli_real_escape_string($coni,$_POST['googlemapapikey']);
$recaptchaprivatekey=mysqli_real_escape_string($coni,$_POST['recaptchaprivatekey']);
$recaptchapublickey=mysqli_real_escape_string($coni,$_POST['recaptchapublickey']);
$wordpressapikey=mysqli_real_escape_string($coni,$_POST['wordpressapikey']);
$splashpage=mysqli_real_escape_string($coni,$_POST['splashpage']);

$fullscreenenabled=mysqli_real_escape_string($coni,$_POST['fullscreenenabled']);
$enableregistercaptcha=mysqli_real_escape_string($coni,$_POST['enableregistercaptcha']);
$rtl=mysqli_real_escape_string($coni,$_POST['rtl']);
$googlelogin=mysqli_real_escape_string($coni,$_POST['googlelogin']);
$yahoologin=mysqli_real_escape_string($coni,$_POST['yahoologin']);
$currencybeforeprice=mysqli_real_escape_string($coni,$_POST['currencybeforeprice']);
if($enableregistercaptcha=="") $enableregistercaptcha=0;
if($rtl=="") $rtl=0;
if($googlelogin=="") $googlelogin=0;
if($yahoologin=="") $yahoologin=0;
if($currencybeforeprice=="") $currencybeforeprice=0;

$browsertitle=mysqli_real_escape_string($coni,$_POST['browsertitle']);
$tagline=mysqli_real_escape_string($coni,$_POST['tagline']);
$homepagedescription=mysqli_real_escape_string($coni,$_POST['homepagedescription']);
$homepagekeywords=mysqli_real_escape_string($coni,$_POST['homepagekeywords']);

$toplinkad=mysqli_real_escape_string($coni,$_POST['toplinkad']);
$sidebarad=mysqli_real_escape_string($coni,$_POST['sidebarad']);

$jsonurl=mysqli_real_escape_string($coni,$_POST['jsonurl']);
$jsontexturl=mysqli_real_escape_string($coni,$_POST['jsontexturl']);
$markerjsonurl=mysqli_real_escape_string($coni,$_POST['markerjsonurl']);
$listingjsonurl=mysqli_real_escape_string($coni,$_POST['listingjsonurl']);

$topmenubackgroundcolor=mysqli_real_escape_string($coni,$_POST['topmenubackgroundcolor']);
$topmenubordercolor=mysqli_real_escape_string($coni,$_POST['topmenubordercolor']);
$topmenufontcolor=mysqli_real_escape_string($coni,$_POST['topmenufontcolor']);

$contactaddress=mysqli_real_escape_string($coni,$_POST['contactaddress']);
$contactformemail=mysqli_real_escape_string($coni,$_POST['contactformemail']);
if($redefaultCountry!=$defaultcountry && trim($defaultcountry)!="") $defaultcountry_latlng=getLonglat($defaultcountry);

$gclientid=mysqli_real_escape_string($coni,trim($_POST['gclientid']));
$gclientsecret=mysqli_real_escape_string($coni,trim($_POST['gclientsecret']));

$delete_after_days=mysqli_real_escape_string($coni,$_POST['delete_after_days']);
$fb_app_id=mysqli_real_escape_string($coni,$_POST['fbappid']);
$fb_app_secret=mysqli_real_escape_string($coni,$_POST['fbappsecret']);

if(trim($fb_app_id)=="##########") $fb_appClause="";
else $fb_appClause=",fb_app_id='$fb_app_id'";

if(trim($fb_app_secret)=="##########") $fb_app_secretClause="";
else $fb_app_secretClause=",fb_app_secret='$fb_app_secret'";

if(trim($logoname)!=""){
	$websitelogo=uploadImage($mem_id);
	$websitelogoClause=", websitelogo='$websitelogo' ";
}else{
	if($removewebsitelogo=="yes") $websitelogoClause=", websitelogo='' ";
}

$qr="update $adminOptionTable set siteoutercolor='$siteoutercolor',siteheadercolor='$siteheadercolor',siteheaderfontcolor='$siteheaderfontcolor',fixedtopheader='$fixedtopheader',
siteinnercolor='$siteinnercolor',sitebordercolor='$sitebordercolor',sitefooterfontcolor='$sitefooterfontcolor',searchformcolor='$searchformcolor',searchformbordercolor='$searchformbordercolor',
searchformfontcolor='$searchformfontcolor',menuboxcolor='$menuboxcolor',menuboxfontcolor='$menuboxfontcolor',menuboxbordercolor='$menuboxbordercolor',notifyadmin='$notifyadmin',listingemail='$listingemail',
websitetitle='$websitetitle',websitefooter='$websitefooter',defaultcountry='$defaultcountry',defaultcurrency='$defaultcurrency',defaultlanguage='$defaultlanguage',smtpauth='$smtpauth',resmtp='$resmtp',resmtpport='$resmtpport',
smtpusername='$smtpusername' $smtpPasswordClause,googlemapapikey='$googlemapapikey',recaptchaprivatekey='$recaptchaprivatekey',recaptchapublickey='$recaptchapublickey' $fb_appClause $fb_app_secretClause,
wordpressapikey='$wordpressapikey',browsertitle='$browsertitle',refriendlyurl='$refriendlyurl',geoipenable='$geoipenable',emaildebug='$emaildebug',homepagedescription='$homepagedescription',homepagekeywords='$homepagekeywords', headlinelength='$headlinelength',descriptionlength='$descriptionlength',
toplinkad='$toplinkad',ppcurrency='$ppcurrency',ppemail='$ppemail',featuredduration='$featuredduration',featuredprice='$featuredprice',sidebarad='$sidebarad',topmenubackgroundcolor='$topmenubackgroundcolor',topmenubordercolor='$topmenubordercolor',
topmenufontcolor='$topmenufontcolor',webtheme='$webtheme', googlemapapikey='$googlemapapikey', listingreview='$listingreview',fieldtheme='$fieldtheme',contactaddress='$contactaddress',contactformemail='$contactformemail',defaultcountry_latlng='$defaultcountry_latlng',jsonurl='$jsonurl',jsontexturl='$jsontexturl',fullscreenenabled='$fullscreenenabled',enableregistercaptcha='$enableregistercaptcha',rtl='$rtl',google_login='$googlelogin',yahoo_login='$yahoologin',currency_before_price='$currencybeforeprice',markerjsonurl='$markerjsonurl',listingjsonurl='$listingjsonurl', delete_after_days='$delete_after_days',gclientid='$gclientid', gclientsecret='$gclientsecret', tagline='$tagline', splashpage='$splashpage' $websitelogoClause ;";

if($isThisDemo!="yes") $result=mysqli_query($coni,$qr);
if($result) print "<p align='center' class='info_success'>Admin options updated.</p>";
else print "<p align='center' class='info_error'>Admin options couldn't be updated. Please try again</p>".mysqli_errno()." - ".mysqli_error();
}

$qr1="select * from $adminOptionTable";
$result1=mysqli_query($coni,$qr1);
$adminOptions=mysqli_fetch_assoc($result1);
$_SESSION["autoadmin_settings"]=$adminOptions;
$_SESSION["recustom_settings"]=1;
if($defaultlanguage!="" && $defaultlanguage!=$redefaultLanguage) $redefaultLanguage=$_SESSION["custom_lang"]=$defaultlanguage;

$adminQr="select * from $languageTable where language='$redefaultLanguage'";
$adminResult=mysqli_query($coni,$adminQr);
while($langOptions=mysqli_fetch_assoc($adminResult)){
	$languageTags[$langOptions['keyword']]=$langOptions['translation'];
}
$_SESSION["auto_language"]=$languageTags;

}
?>