<?php
/*
*     Author: Ravinder Mann
*     Email: ravi@codiator.com
*     Website: http://www.codiator.com
*     Release: 1.4
*
* Please direct bug reports,suggestions or feedback to :
* http://www.codiator.com/contact/
*
* Car Trading Made Easy is a commercial software. Any distribution is strictly prohibited.
*
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING);
error_reporting(0);
session_start();

include("site.inc.php");
include_once("plugin_handler.inc.php"); 
include_once "plugins.php";

if($host=="" || $database=="" || $username=="" ) header('Location: install/index.php');
$reListingTable="listing"; 
$rememberTable="member";
$adminOptionTable="admin_options";
$languageTable="languages";
$priceTable="pricerange";
$pageTable="pages";
$categoryTable="categories";
$featureTable="features";
$bodytypeTable="bodytype";
$fueltypeTable="fueltype";
$reMaxPictures=15;
$isThisDemo="no";
$enableMap=true;
$version_num="Version: 1.4.2";
$changelog="https://www.finethemes.com/changelog/index.php?id=7&";

$SMTPAuth=true;

/* Follow us links */
$googleFollow="";
$twitterFollow="";
$facebookFollow="";
/* Follow us links ends */

$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
    
/*
 * $defaultCityZoom This is the zoom level of the visitor city and it is used when visitor first visits the website and geoIP is enabled in the admin options. 
 * $defaultCountryZoom is the zoom level of the default country if there's not a single listing and map loads the default country set in admin options.
 * In all other cases the script automatically sets the zoom level as per the number of markers found in a given area.
 */
 
$defaultCityZoom=11;
$defaultCountryZoom=4;

include_once("siteSettings.php");
$autoadmin_settings=setOptionValues($host,$database,$username,$password,$adminOptionTable);

if(trim($autoadmin_settings["fullscreenenabled"]=="true")) $fullScreenEnabled="true"; else $fullScreenEnabled="false";
$enableRegisterCaptcha = $autoadmin_settings["enableregistercaptcha"] ? true : false;
$_SESSION['rtl']=$rtl = $autoadmin_settings["rtl"] ? true : false;
if(isset($_GET['rtl']) && $_GET['rtl']==1)$_SESSION['rtl']=$rtl=true;
$google_login = $autoadmin_settings["google_login"] ? true : false;
$yahoo_login = $autoadmin_settings["yahoo_login"] ? true : false;
$currency_before_price = $autoadmin_settings["currency_before_price"] ? true : false;

$webtheme=trim($autoadmin_settings['webtheme']);
if(isset($_GET['theme'])) $_SESSION['theme']=$_GET['theme'];
if(isset($_SESSION['theme']))$webtheme=trim($_SESSION['theme']);
$fieldtheme=trim($autoadmin_settings['fieldtheme']);
$googlemapapikey=$autoadmin_settings['googlemapapikey'];
$fixedtopheader=$autoadmin_settings['fixedtopheader'];
$notifyadmin=$autoadmin_settings['notifyadmin'];
$listingreview=$autoadmin_settings['listingreview'];
$listingemail=$autoadmin_settings['listingemail'];
$defaultCurrency=trim($autoadmin_settings['defaultcurrency']);
$redefaultCountry=trim($autoadmin_settings['defaultcountry']);
$defaultcountry_latlng=trim($autoadmin_settings['defaultcountry_latlng']);
$redefaultLanguage=trim($autoadmin_settings['defaultlanguage']);
$refriendlyurl=trim($autoadmin_settings['refriendlyurl']);
$emaildebug=trim($autoadmin_settings['emaildebug']);
if($redefaultLanguage=="")$redefaultLanguage="English";
if(!isset($_SESSION["auto_language"]) || !isset($_SESSION["custom_lang"])){
    $_SESSION["custom_lang"]=$redefaultLanguage;
    $relanguage_tags=setLanguageValues($host,$database,$username,$password,$languageTable,$redefaultLanguage);
}
else $relanguage_tags=$_SESSION["auto_language"];
$ppcurrency=trim($autoadmin_settings['ppcurrency']);
$ppemail=trim($autoadmin_settings['ppemail']);
$featuredduration=trim($autoadmin_settings['featuredduration']);
$featuredprice=trim($autoadmin_settings['featuredprice']);
$redefaultDistance=trim($autoadmin_settings['defaultdistance']);
$resmtp=trim($autoadmin_settings['resmtp']);
$resmtpport=trim($autoadmin_settings['resmtpport']);
$gmailUsername=trim($autoadmin_settings['smtpusername']);
$gmailPassword=trim($autoadmin_settings['smtppassword']);
$reSiteName=trim($autoadmin_settings['websitetitle']);
$reSiteFooter=trim($autoadmin_settings['websitefooter']);
$geoipenable=trim($autoadmin_settings['geoipenable']);
$WordPressAPIKey = trim($autoadmin_settings['wordpressapikey']);
$reCaptchaPrivateKey = trim($autoadmin_settings['recaptchaprivatekey']);
$reCaptchaPublicKey =trim($autoadmin_settings['recaptchapublickey']);
$googleMapAPIKey=trim($autoadmin_settings['googlemapapikey']);
$browsertitle=trim($autoadmin_settings['browsertitle']);
$tagline=trim($autoadmin_settings['tagline']);
$homepagedescription=trim($autoadmin_settings['homepagedescription']);
$homepagekeywords=trim($autoadmin_settings['homepagekeywords']);
$toplinkad=trim($autoadmin_settings['toplinkad']);
$sidebarad=trim($autoadmin_settings['sidebarad']);
$contactaddress=trim($autoadmin_settings['contactaddress']);
$contactformemail=trim($autoadmin_settings['contactformemail']);
$headlinelength=trim($autoadmin_settings['headlinelength']);
$descriptionlength=trim($autoadmin_settings['descriptionlength']);
$delete_after_days=trim($autoadmin_settings['delete_after_days']);
$fb_app_id=trim($autoadmin_settings['fb_app_id']);
$fb_app_secret=trim($autoadmin_settings['fb_app_secret']);
$gclientid=trim($autoadmin_settings['gclientid']);
$gclientsecret=trim($autoadmin_settings['gclientsecret']);

?>