<?php
/*
*     Author: Ravinder Mann
*     Email: ravi@codiator.com
*     Web: http://www.codiator.com 
*     Release: 1.4
*
* Please direct bug reports,suggestions or feedback to :
* http://www.codiator.com/contact/
*
* Car Trading Made Easy is a commercial software. Any distribution is strictly prohibited.
*
*/
include("config.php");
include_once("functions.inc.php"); 
if($redefaultLanguage=="English") $lang=trim(getLanguageName(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)));
if(isset($_GET['lang'])) $_SESSION["custom_lang"]=$lang=trim($_GET['lang']);
if(isset($_SESSION["custom_lang"])) $lang=$_SESSION["custom_lang"];

if(trim($lang)!="" && ($redefaultLanguage!=$lang || $lang=="English")){
setLanguageSession($host,$database,$username,$password,$languageTable,$lang);
$relanguage_tags=$_SESSION["auto_language"];
$autoadmin_settings['defaultlanguage']=$lang;
$_SESSION["autoadmin_settings"]["defaultlanguage"]=$lang;
}

if(isset($_GET['rtl'])) $_SESSION['rtl']=$_GET['rtl'];
if($rtl) $_SESSION['rtl']=true;

if($isThisDemo=="yes"){
if($webtheme=="default"){ $fieldtheme="smoothness"; $autoadmin_settings['websitelogo']="logo5b-dark.png"; }
if($webtheme=="amelia"){  $fieldtheme="blitzer"; }
if($webtheme=="cerulean"){  $fieldtheme="redmond"; }
if($webtheme=="cosmos"){  $fieldtheme="redmond"; }
if($webtheme=="cyborg"){  $fieldtheme="dark-hive"; }
if($webtheme=="flatly"){  $fieldtheme="hot-sneaks"; }
if($webtheme=="journal"){  $fieldtheme="humanity";  $autoadmin_settings['websitelogo']="logo5b-dark.png";}
if($webtheme=="readable"){  $fieldtheme="redmond";  $autoadmin_settings['websitelogo']="logo5b-dark.png";}
if($webtheme=="simplex"){  $fieldtheme="blitzer";  $autoadmin_settings['websitelogo']="logo5b-dark.png";}
if($webtheme=="slate"){  $fieldtheme="dark-hive"; }
if($webtheme=="spacelab"){  $fieldtheme="smoothness";  $autoadmin_settings['websitelogo']="logo5b-dark.png";}
if($webtheme=="united"){  $fieldtheme="ui-lightness"; }
if($webtheme=="yeti"){  $fieldtheme="black-tie"; }
if($webtheme=="custom"){  $fieldtheme="cupertino";  $autoadmin_settings['websitelogo']="logo5b-dark.png";}
}

if(!isset($_SESSION["reSubcategory"])) $_SESSION["reSubcategory"]="";

$ptype=trim($_GET["ptype"]);

$requerystring=$_POST['requerystring'];
if($ptype=="") $ptype=trim($_POST["ptype"]);
$ptype=htmlspecialchars($ptype, ENT_QUOTES, 'UTF-8');

if($ptype=="home" || $ptype=="viewMemberListing" || $ptype=="viewFullListing" || $ptype=="submitReListing" || $ptype=="addReListing" || $ptype=="editReListingForm"  || $ptype=="allMembers" || $ptype=="contactus" || $ptype=="updateReListing" || $ptype=="myprofile" || $ptype=="adminOptions"  || $ptype=="UpdateAdminOptions" || $ptype=="allMembers" || $ptype=="languagetags"  || $ptype=="updateLanguageTags" || $ptype=="categories" || $ptype=="pricerange" ||  $ptype=="updatePriceRange" || $ptype=="page" ||  $ptype=="features" ||  $ptype=="bodytype" ||  $ptype=="fueltype")
$fullScreenEnabled="false";

if($ptype!="checklogin"){ 
 if(!isset($_SESSION["myusername"])){ 
		if($ptype=="submitReListing" || $ptype=="addReListing" || $ptype=="editReListingForm"  || $ptype=="updateReListingForm" || $ptype=="myprofile" || $ptype=="adminOptions"  || $ptype=="UpdateAdminOptions" || $ptype=="allMembers" || $ptype=="languagetags"  || $ptype=="updateLanguageTags" || $ptype=="categories" || $ptype=="pricerange" ||  $ptype=="updatePriceRange" ||  $ptype=="features" ||  $ptype=="bodytype" ||  $ptype=="fueltype")	$ptype="";
	}
	
}

if(isset($_SESSION["showOnMap"])){
	$fullScreenEnabled="true";
}else{
	if($ptype=="showOnMap"){
		$_SESSION["showOnMap"]="true"; $fullScreenEnabled="true";
	}
}

if($ptype!="" && $ptype!="showOnMap"){
	$_SESSION["showOnMap"] = NULL;
	unset($_SESSION["showOnMap"]);
	$fullScreenEnabled="false";
}

$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);
$mem_id=$_SESSION["re_mem_id"];
$memtype=$_SESSION["memtype"];
$ip=$_SERVER["REMOTE_ADDR"];

$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$priceqr="select * from $priceTable";
$priceResult=mysqli_query($coni,$priceqr);
$priceRange=mysqli_fetch_assoc($priceResult);
$rentPriceRange=explode(",",$priceRange['rent']);
$salePriceRange=explode(",",$priceRange['sale']);
$rentRangeSize=sizeof($rentPriceRange);
$saleRangeSize=sizeof($salePriceRange);

if($ptype=="submitReListing"){
require_once('geoplugin.class.php');
 $geoplugin = new geoPlugin();
 $geoplugin->locate();
 $vRegion=$geoplugin->region;
 $vCity=$geoplugin->city;
 $vCountry=$geoplugin->countryName;      
}

if($ptype=="viewFullListing"){ 
	$reid=htmlspecialchars(trim($_GET["reid"]), ENT_QUOTES, 'UTF-8');
	$region=htmlspecialchars(trim($_GET["region"]), ENT_QUOTES, 'UTF-8');
	if($region===""){
	$reid=$_GET['reid']; 
	$viewListingRow=getListingData($reid);
	}else{
		if($autoadmin_settings['oodleplugin']==1 && function_exists("getOodleArray")){
		$combArray=convertArrayToClFormat(getOodleArray("","",$reid,"",$region));
		$viewListingRow=$combArray[0];
		$viewListingRow['category']=ucfirst($viewListingRow['category']);
		}
	}
	if(empty($viewListingRow)){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $full_url_path");
	}
	$browsertitle=__($viewListingRow['category']).", ".__($viewListingRow['subcategory'])." - ".substr($viewListingRow['headline'],0,120)." - ".$viewListingRow['city'];
	$homepagedescription=addslashes((substr($viewListingRow['description'],0,250)));
	$homepagekeywords=__($viewListingRow['category']).",".__($viewListingRow['subcategory']).",".$viewListingRow['city']." listing";
    $rePicArray=explode("::",$viewListingRow['pictures']);
    if($_SESSION["autoadmin_settings"]["refriendlyurl"]=="enabled"){
        $headline_slug=friendlyUrl($viewListingRow['headline']);    
        $urlLink=friendlyUrl($viewListingRow['category'],"_")."/".friendlyUrl($viewListingRow['subcategory'],"_")."/"."id-".$viewListingRow['id']."-".$region."-".$headline_slug;
    }else  $urlLink="index.php?ptype=viewFullListing&reid=".$viewListingRow['id'].$regionClause2;
	
}

if($ptype=="page" && htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8')!=""){
	$qrpg0="select * from $pageTable where id='".mysqli_real_escape_string($coni,htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8'))."';";
	$resultpg0=mysqli_query($coni,$qrpg0);
	$page_info=mysqli_fetch_assoc($resultpg0);
	$browsertitle=$page_info['page_name']." - ".$browsertitle;
	$homepagedescription=(substr(strip_tags(preg_replace( '/\s+/', ' ', $page_info['page_content'])),0,250));
	$homepagekeywords=$page_info['keywords'];
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="generator" content="Car Trading Made Easy" />
<base href="<?php print $full_url_path; ?>" />
<?php if($ptype=="checklogin"){ ?><meta http-equiv="refresh" content="1;url=index.php?<?php print $requerystring; ?> "><?php } ?>
<?php if($ptype=="UpdateAdminOptions"){ ?><META HTTP-EQUIV=Refresh CONTENT="1 ; URL=index.php?ptype=adminOptions"> <?php } ?>
<title><?php print $browsertitle; ?></title>
<?php if(trim($homepagedescription)!=""){ ?>
<meta name="description" content="<?php print $homepagedescription; ?>">
<?php  } ?>
<?php if(trim($homepagekeywords)!=""){ ?>
<meta name="keywords" content="<?php print $homepagekeywords; ?>">
<?php  } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php if($ptype=="viewFullListing") { ?>
<meta property="og:image" content="<?php print $rePicArray[0]; ?>"/>
<meta property="og:title" content="<?php print $browsertitle; ?>"/>
<meta property="og:url" content="<?php print $full_url_path.$urlLink; ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:site_name" content="<?php print $reSiteName; ?>"/>
<meta property="og:description" content="<?php print $homepagedescription; ?>"/>
<?php } ?>

<?php if($ptype=="viewFullListing" || $ptype=="showOnMap" || $fullScreenEnabled=="true" || $ptype=="submitReListing" || $ptype=="editReListingForm" ){ ?>
<script src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false&key=<?php print trim($googlemapapikey); ?>"></script>
<script  src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
<?php } ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.multiselect.min.js"></script>
<script type="text/javascript" src="js/jquery.multiselect.filter.js"></script>
<script type="text/javascript" src="js/jquery.placeholder.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="css/font-awesome.min.css" />
<?php if($ptype=="viewFullListing"){ ?>
    <script type="text/javascript" src="js/jquery.lightbox-0.5.min.js"></script>
<?php  } ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php if($ptype=="viewFullListing" || $ptype=="showOnMap" || $fullScreenEnabled=="true" || $ptype=="submitReListing" || $ptype=="editReListingForm" ){ ?>
<script src="js/markerwithlabel_packed.js"></script>
<script src="js/markerclusterer_packed.js"></script>
<link rel="stylesheet" media="screen" type="text/css" href="css/jquery.bxslider.css" />
<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
<?php  } ?>

<script type="text/javascript" src="loadingImage.js"></script>
<script type="text/javascript"  src="infoResults.js"></script>
<script type="text/javascript"  src="js/reFunctions.js"></script>
<?php if($memtype==9 || $memtype==1) { ?>
<script type="text/javascript"  src="js/ajaxupload.js"></script>
<?php } ?>
<?php if($memtype==9) { ?>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/eye.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/layout.js?ver=1.0.2"></script>
<script type="text/javascript" src="js/adminOptions.js"></script>
<?php } ?>
<script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<?php if($ptype=="addeditpage"){ ?>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.js"></script>
<link rel="stylesheet" href="css/jquery.tagsinput.css" type="text/css" />
<?php  } ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php if($fieldtheme==""){ ?>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/smoothness/jquery-ui.css" />
<?php }else{ ?>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/<?php print $fieldtheme; ?>/jquery-ui.css" />
<?php } ?>
<link rel="stylesheet" media="screen" type="text/css" href="css/jquery.multiselect.css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/jquery.multiselect.filter.css" />
<?php if($ptype=="viewFullListing"){ ?><link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" /><?php } ?>
<?php if($webtheme==""){ ?>
<link rel="stylesheet" media="screen" type="text/css" href="css/default/bootstrap.css" />
<link rel="stylesheet" media="screen" type="text/css" href="css/default/bootstrap-theme.min.css" />
<?php }else{ ?>
<link rel="stylesheet" media="screen" type="text/css" href="css/<?php print $webtheme; ?>/bootstrap.css" />
<?php } ?>

<link rel="stylesheet" href="prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<script src="prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

 
<?php if($memtype==9) { ?><link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" /><?php } ?>
<link rel="stylesheet" href="css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<?php if((isset($_SESSION["autoadmin_settings"]) && $_SESSION["recustom_settings"]==1) || $fullScreenEnabled=="true"){ ?>
<link href="css/custom_style.php?ptype=<?php print $ptype; ?>&amp;fullscreen=<?php print $_GET["fullscreen"]; ?>&amp;fs=<?php print $fullScreenEnabled; ?>" rel="stylesheet" type="text/css" />
<?php } ?>

<?php  
if($_SESSION["rtl"]){ ?>
<link href="css/rtl_style.php?ptype=<?php print $ptype; ?>&amp;fullscreen=<?php print $_GET["fullscreen"]; ?>&amp;fs=<?php print $fullScreenEnabled; ?>" 
rel="stylesheet" type="text/css" />
<style> body {direction: rtl;}</style>
<?php } ?>
<style> 
   @media (max-width: 767px) {
  .navbar-nav .open .dropdown-menu {
  position:absolute;
  background-color:#fff;
  border:1px solid #ccc;    
  }
  }
</style>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    
<script type="text/javascript">
function _(message){
    console.log(message);
}
$(function(){
     var isIE8 = $.browser.msie && +$.browser.version === 8;
     var isIE7 = $.browser.msie  && parseInt($.browser.version, 10) === 7;
         
     $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:'winwidth:'+$(window).width(), type:27}, success: function(data){ }});
     $("tr.inactiveListing1 td").css("background-color",$('.alert-danger').css("background-color"));
     
	<?php if($fixedtopheader=="yes"){ ?>
	 var topbarHeight=$('.navbar').height();
	 $('#sidebar').css('margin-top',topbarHeight+'px');
	 $('#mainContent').css('margin-top',topbarHeight+'px');
	<?php }else{ ?>
	 $('#sidebar').css('margin-top','0px');
	 $('#mainContent').css('margin-top','0px');
	<?php } 
    $reCategory[0]=htmlspecialchars($_GET['category'], ENT_QUOTES, 'UTF-8');
    $reSubcategory[0]=htmlspecialchars($_GET['subcategories'], ENT_QUOTES, 'UTF-8');
	if(isset($_GET['requery'])) $reQuery=htmlspecialchars(trim($_GET['requery']), ENT_QUOTES, 'UTF-8');
    if(isset($_GET['city'])) $reCity=htmlspecialchars(trim($_GET['city']), ENT_QUOTES, 'UTF-8');
    if(isset($_POST['requery'])) $reQuery=htmlspecialchars(trim($_POST['requery']), ENT_QUOTES, 'UTF-8');
    if(isset($_POST['city'])) $reCity=htmlspecialchars(trim($_POST['city']), ENT_QUOTES, 'UTF-8');
       
	if(($ptype=="" || $ptype=="home") && $fullScreenEnabled!="true"){
	   if($reCategory[0]==""){ if($_SESSION["reCategory"]!="") $homeCategory=$_SESSION["reCategory"]; else $homeCategory=__("Any"); } 
else{ $homeCategory=$reCategory[0]; }
if($reSubcategory[0]==""){ if($_SESSION["reSubcategory"]!="") $homeSubcategory=$_SESSION["reSubcategory"]; else $homeSubcategory=__("Any"); } 
else{ $homeSubcategory=$reSubcategory[0]; }

		//if($_SESSION["reCategory"]!="") $homeCategory=$_SESSION["reCategory"]; else $homeCategory=__("Any");
		//if($_SESSION["reSubcategory"]!="") $homeSubcategory=$_SESSION["reSubcategory"]; else $homeSubcategory=__("Any");
		if($_SESSION["rePrice"]!="") $homePrice=$_SESSION["rePrice"]; else $homePrice=10;
		if($_SESSION["autoAge"]!="") $homeautoAge=$_SESSION["autoAge"]; else $homeautoAge=__("Any");
		if($_SESSION["bodyType"]!="") $homebodyType=$_SESSION["bodyType"]; else $homebodyType=__("Any");
		if($_SESSION["fuelType"]!="") $homefuelType=$_SESSION["fuelType"]; else $homefuelType=__("Any");
		if($_SESSION["transmissionType"]!="") $hometransmissionType=$_SESSION["transmissionType"]; else $hometransmissionType=__("Any");
		if($_SESSION["listingBy"]!="") $homelistingBy=$_SESSION["listingBy"]; else $listingBy=__("Any");
		if($reQuery==""){ if($_SESSION["reQuery"]!="") $homeQuery=$_SESSION["reQuery"]; else $homeQuery="";} else{ $homeQuery=$reQuery; }
        if($reCity==""){ if($_SESSION["reCity"]!="") $homeCity=$_SESSION["reCity"]; else $homeCity="";} else{ $homeCity=$reCity; }
		?>
	$('#reResults').html("<p align='center'><br /><br /><br /><img src='images/loading1.gif' /></p>");
    var allData='<?php print $homeCategory.":".$homeSubcategory.":".$homePrice.":".$homeautoAge.":".$homebodyType.":".$homefuelType.":".$hometransmissionType.":".$homelistingBy.":".$homeQuery.":".$homeCity; ?>';   
    $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData, type:1}, success: function(data){ $('#reResults').html(data); 
    onTextSearch();
    }});
    
	<?php if($_GET['brand']!=""){ ?>
	var allData='<?php print $relanguage_tags["Any"].":"; ?>:10:<?php print $relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$_GET['brand']; ?>:';    
    $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData, type:1}, success: function(data){ $('#reResults').html(data); 
    onTextSearch();
    }});
	<?php  } ?>
	
	<?php } ?>
	<?php if($ptype=="viewMemberListing"){ ?>
    var allData='<?php print $relanguage_tags["Any"].":"; ?>:10:<?php print $relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$relanguage_tags["Any"].":".$_GET['brand']; ?>:';  
    $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData, type:7}, success: function(data){ $('#reResults').html(data); 
    onTextSearch();
    }});
    
    <?php }  ?>
	<?php if($ptype=="viewFullListing"){ 
	$allData=$_SESSION["reCategory"].":".$_SESSION["reSubcategory"].":".$_SESSION["rePrice"].":".$_SESSION["autoAge"].":".$_SESSION["bodyType"].":".$_SESSION["fuelType"].":".$_SESSION["transmissionType"].":".$_SESSION["listingBy"].":".$_SESSION["reQuery"].":".$_SESSION["reCity"];
		?>
    $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:'<?php print $allData; ?>', type:1}, success: function(data){ $('#reResults2').html(data); 
    onTextSearch();
    }});

$('#viewListingImages').bxSlider({
    slideWidth: 100,
    minSlides: 2,
    maxSlides: 10,
    slideMargin: 10
  });
  
	<?php }  ?>

	$('#listing_Buttons span.ttip,span.alreadySeen,#listingAllowedThings div,#hidebar,#showbar, #pageorder, #pagename, .action_icon img, .listingcontact, .updateLangTag, .deleteLangTag').tooltip({ 
		placement:'bottom',
		delay: { show: 500, hide: 100 }
	}); 
	$("#reTextSearch").click(function(){
	$("#sfpType").val("home");
	});
	
	<?php if($ptype=="viewFullListing"){ ?>
	$("#listingImage a").lightBox();
	<?php } ?>

	$('.nav .favli').click(function(event){
	    event.preventDefault();  
		$('.nav li').removeClass("active");
		$(this).addClass("active");
		$('#reResults').html("<p align='center'><br /><br /><br /><img src='images/loading1.gif' /></p>");
        $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:'<?php print $relanguage_tags["Any"].":".$relanguage_tags["Any"]; ?>:10:', type:26}, success: function(data){ $('#reResults').html(data); 
       onTextSearch();
         }});
	});

	<?php if(isset($_SESSION["marked_reid"])){ ?>
	$('.nav .favli').css('display','block');
	<?php } ?>	
	
	$("#mainContent").on("click", "#viewListingImages span", function(event) {    
    event.preventDefault(); 
    var img = new Image();
    $("#image_cell").html("<div style='width:100%; text-align:center; padding-top:25%;'><img src='images/loader_light_blue.gif' /></div>");
    var icon_id=($(this).attr('id')).split('-');
    img.onload = function(){
    $("#image_cell").html("<div id='listingImage'><a data-fancybox-group='listgallery' href='"+$("#bimage-"+icon_id[1]).html()+"' ><img src='"+$("#bimage-"+icon_id[1]).html()+"' width='100%' /></a></div>");
    }
    img.src = $("#bimage-"+icon_id[1]).html();
    });
    
    $("a[rel^='prettyPhoto']").prettyPhoto();
    
	$("#mainContent").on("click", "#listingImage a", function(event) {
		event.preventDefault();
	    $(this).filter(':not(.fb)').fancybox({
	    	'transitionIn'	:	'elastic',
	    	'transitionOut'	:	'elastic',
	    	'speedIn'		:	600, 
	    	'speedOut'		:	200, 
	    	'overlayShow'	:	false,
			'showNavArrows' : false,
			'scrolling' : 'no',
			'type' : 'image'
	    }).addClass('fb');
	    $(this).triggerHandler('click');
	 });

    var contactFormHeight=700;
    if($(window).height()<550) contactFormHeight=$(window).height()-50;
    
	$("#mainContent").on("click", "a.listingcontact", function(event) {
		event.preventDefault();
	    $(this).filter(':not(.fb)').fancybox({
	    	'transitionIn'	:	'elastic',
	    	'transitionOut'	:	'elastic',
	    	'speedIn'		:	600, 
	    	'speedOut'		:	200, 
	    	'width' : 600,
			'height' : contactFormHeight,
	    	'type' : 'iframe',
	    	'overlayShow'	:	false,
			'showNavArrows' : false,
			'scrolling' : 'auto'
	    }).addClass('fb');
	    $(this).triggerHandler('click');
	 });
	 
	 
	$("#mainContent").on("click", ".listingSmallImage1 a, .mapInfoPic1 a", function(event) {
		event.preventDefault();
	    $(this).filter(':not(.fb)').fancybox({
	    	'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'type' : 'iframe',
			'width' : 680,
			'height' : 750,
			'overlayShow'	:	false,
			'scrolling' : 'no'
	    }).addClass('fb');
	    $(this).triggerHandler('click');
	 });
	
  $('input, textarea').placeholder();
  
  function onTextSearch(){
    $("a[rel^='prettyPhoto']").prettyPhoto();
    $('#resultTable tr.featuredClass td').css('background-color',$('.alert-info').css('background-color'));
    $('#resultTable tr.flagClass td').css('background-color',$('.alert-warning').css('background-color'));
    $('#resultTable tr.inavtiveClass td').css('background-color',$('.alert-danger').css('background-color'));  
  }
  
    $('#reSearch').click(function(){
    	$('#mapOverlayDiv input').css('display','none');
	
		var reCategory="";
		var subCategories="";
		var rePrice="";
		var autoAge="";
		var bodyType="";
		var fuelType="";
		var transmissionType="";
		var listingBy="";
		var delim=",";
		 $("#reCategory :selected").each(function(i, selected){ 
			 if(reCategory=="") delim=""; else delim=",";
			 reCategory = reCategory+delim+$(selected).val(); 
		});
		 $("#subCategories :selected").each(function(i, selected){ 
			 if(subCategories=="") delim=""; else delim=",";
			 subCategories = subCategories+delim+$(selected).val(); 
		});
		
		 $("#rePrice :selected").each(function(i, selected){ 
			 if(rePrice=="") delim=""; else delim=",";
			 rePrice = rePrice+delim+$(selected).val(); 
		});			

		 $("#autoAge :selected").each(function(i, selected){ 
			 if(autoAge=="") delim=""; else delim=",";
			 autoAge = autoAge+delim+$(selected).val(); 
		});	

		 $("#bodyType :selected").each(function(i, selected){ 
			 if(bodyType=="") delim=""; else delim=",";
			 bodyType = bodyType+delim+$(selected).val(); 
		});	

		 $("#fuelType :selected").each(function(i, selected){ 
			 if(fuelType=="") delim=""; else delim=",";
			 fuelType = fuelType+delim+$(selected).val(); 
		});	

		 $("#transmissionType :selected").each(function(i, selected){ 
			 if(transmissionType=="") delim=""; else delim=",";
			 transmissionType = transmissionType+delim+$(selected).val(); 
		});	

		 $("#listingBy :selected").each(function(i, selected){ 
			 if(listingBy=="") delim=""; else delim=",";
			 listingBy = listingBy+delim+$(selected).val(); 
		});	
		
		 $('.nav li').removeClass("active");
         $('.first_item').addClass("active");
         var reQuery=$('input#reQuery').val();
		 var reCity=$('input#reCity').val();
		 var allData=reCategory+":"+subCategories+":"+rePrice+":"+autoAge+":"+bodyType+":"+fuelType+":"+transmissionType+":"+listingBy+":"+reQuery+":"+reCity;
		  $('#reResults').html("<p align='center'><br /><br /><br /><img src='images/loading1.gif' /></p>");
		 <?php if($ptype=="" || $ptype=="home" || $ptype=="viewFullListing"  || $ptype=="showOnMap"  || $ptype=="adminOptions" || $ptype=="UpdateAdminOptions" || $ptype=="allMembers" || $ptype=="contactus" || $ptype=="languagetags" || $ptype=="updateLanguageTags" || $ptype=="page" || $_GET["cpage"]==1){ ?>
		 <?php if($fullScreenEnabled!="true"){ ?>
		     $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData, type:1}, success: function(data){ $('#reResults').html(data); 
		     $("a[rel^='prettyPhoto']").prettyPhoto();
		     onTextSearch(); }}); 
		 <?php } ?>
		 <?php } if($ptype=="viewMemberListing"){ ?>
		 $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData, type:7}, success: function(data){ $('#reResults').html(data); 
		 onTextSearch(); }}); 
		 <?php } ?>
		 if($(window).width()<=991){
         $("#reForm").hide('slow');
         $('#showSidebar').show();
         $('#hideSidebar').hide();
         }
     });    

    $("#reCity").autocomplete({
       source: "infoResults.php?type=30&stype=1",
       minLength: 2,
       select: function( event, ui ) { 
       $("#reCity").val(ui.item.value);
       }
	 });    

 $(document).on("click","ul.pagination li a, .hsorting a",function(event){
    event.preventDefault();
    var qData=$("span", this).html(); 
    var allData=qData.split("-@@-");
    console.log('allData: '+allData[0]+", "+allData[1]);
    $('#reResults').html("<p align='center'><br /><br /><br /><img src='images/loading1.gif' /></p>");  
    $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData[0], type:allData[1]}, success: function(data){ $('#reResults').html(data); }});
   });
    
    $(document).on("change", "#reListingsPerPage1, #reListingsPerPage2", function(){
        var qData=this.value; 
        var allData=qData.split("-@@-");
        $('#reResults').html("<p align='center'><br /><br /><br /><img src='images/loading1.gif' /></p>"); 
         $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData[0], type:allData[1]}, success: function(data){ $('#reResults').html(data); }});
    });    

    <?php if($ptype=="viewFullListing" || $ptype=="showOnMap"  || $fullScreenEnabled=="true"){ ?>
    var remap = $("#mapResults");
	<?php } ?>
	<?php if($ptype=="categories"){ ?>
	infoResults('0',16,'allcats');
	<?php }
	if($ptype=="features"){ ?>
	infoResults('-:::<?php print $featureTable; ?>',23,'allfeatures');
	<?php  } 
	if($ptype=="bodytype"){ ?>
	infoResults('-:::<?php print $bodytypeTable; ?>',23,'allbodytypes');
	<?php  } if($ptype=="fueltype"){ ?>
	infoResults('-:::<?php print $fueltypeTable; ?>',23,'allfueltypes');
	<?php  } ?>

	<?php if($ptype=="viewFullListing"){ ?>
	$("#closeMapListing").css('display','none');
	<?php  }else{ ?>
	$("#closeMapListing").css('display','block');
	<?php  } ?>
	
	$("#mapResults").click(function(){
		$("#theListing").hide("slow");
	});

	$(document).on('click', '#closeMapListing img', function() { $("#theListing").hide("slow"); });
	$(document).keydown(function(e) { if (e.keyCode == 27) $("#theListing").hide("slow"); });
		
	$('#addcat').click(function(){
		var catname=$.trim($('#catname').val());
		var catprice=document.getElementById('catprice').checked;
		if(catname.length > 2)
		infoResults(catname+':::true',16,'allcats');
		else{
		 alert("Please enter a brand name (min 2 characters)");
		}
	});

	$('#addfeature').click(function(){
		var featurename=$.trim($('#featurename').val());
		if(featurename.length > 2)
		infoResults(featurename+':::'+'<?php print $featureTable; ?>',23,'allfeatures');
		else{
		 alert("Please enter a feature name (min 1 characters)");
		}
	});

	$('#addbodytype').click(function(){
		var featurename=$.trim($('#bodyname').val());
		if(featurename.length > 2)
		infoResults(featurename+':::'+'<?php print $bodytypeTable; ?>',23,'allbodytypes');
		else{
		 alert("Please enter a body type (min 1 characters)");
		}
	});

	$('#addfueltype').click(function(){
		var featurename=$.trim($('#fuelname').val());
		if(featurename.length > 2)
		infoResults(featurename+':::'+'<?php print $fueltypeTable; ?>',23,'allfueltypes');
		else{
		 alert("Please enter a fuel type (min 1 characters)");
		}
	});

	
	$('#addNewTag').click(function(){
		var newKeyword=$.trim($('input#newtag').val());
		var newTranslation=$.trim($('input#newtranslation').val());
		if(newKeyword.length<=0 || newTranslation.length<=0){
		alert("Please specify keyword in English and the translation in <?php print $redefaultLanguage; ?>.");
			return false;
		}else{
		<?php 	if($isThisDemo=="no"){ ?>
		infoResults(newKeyword+':::'+newTranslation+':::'+'<?php print $redefaultLanguage; ?>',22,'addTagStatus');
		<?php } ?>
		}
	});
	
     $("#reCategory").multiselect({
        noneSelectedText: "<?php print __("Select Brand"); ?>",
    	selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["Brand"];?>: " + selectedValues.join(", ");
		   },
    	height:'275',
    	minWidth: '240',
    	checkAllText:"<?php print __("Check all"); ?>",
		uncheckAllText:"<?php print __("Uncheck all"); ?>"
		}).multiselectfilter();
     
	$("#rePrice").multiselect({
		selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				if(checkedItems[i].value==10) checkedItems[i].value="<?php print __("Any"); ?>";
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["Price"];?>: " + selectedValues.join(", ");
		   },
		multiple:false,
		height: 'auto',
		minWidth: '240',
		checkAllText:"<?php print __("Check all"); ?>",
		uncheckAllText:"<?php print __("Uncheck all"); ?>"
	});
	
	<?php if(($ptype=="" && $fullScreenEnabled!="true") || $ptype=="home" || $ptype=="viewMemberListing" || $ptype=="viewFullListing" || ($ptype=="showOnMap"  && $fullScreenEnabled!="true") || $ptype=="adminOptions"  || $ptype=="UpdateAdminOptions" || $ptype=="allMembers" || $ptype=="contactus" || $ptype=="page" || $_GET["cpage"]==1 || $fullScreenEnabled=="true"){ ?>
	$("#subcategoriesSection").css('display','block');
	$("#subCategories").multiselect({
	    noneSelectedText: '<?php print __("Select Model"); ?>',
		selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["Model"];?>: " + selectedValues.join(", ");
		   },
		   height:'275',
		   minWidth: '240',
		   checkAllText:"<?php print __("Check all"); ?>",
		   uncheckAllText:"<?php print __("Uncheck all"); ?>"
		}).multiselectfilter(); 
	<?php  }else{ ?>$("#subcategoriesSection").css('display','none'); <?php } ?>

	$("#autoAge").multiselect({
	    noneSelectedText: "<?php print __("Select Auto Age"); ?>",
		selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["How Old"];?>: " + selectedValues.join(", ");
		   },
		height: 'auto',
		minWidth: '240',
		checkAllText:"<?php print __("Check all"); ?>",
		uncheckAllText:"<?php print __("Uncheck all"); ?>"
	});

	$("#bodyType").multiselect({
	    noneSelectedText: "<?php print __("Select Body Type"); ?>",
		selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["Body Type"];?>: " + selectedValues.join(", ");
		   },
		height: 'auto',
		minWidth: '240',
		checkAllText:"<?php print __("Check all"); ?>",
		uncheckAllText:"<?php print __("Uncheck all"); ?>"
	});

	$("#fuelType").multiselect({
	    noneSelectedText: "<?php print __("Select Fuel Type"); ?>",
		selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["Fuel Type"];?>: " + selectedValues.join(", ");
		   },
		height: 'auto',
		minWidth: '240',
		checkAllText:"<?php print __("Check all"); ?>",
		uncheckAllText:"<?php print __("Uncheck all"); ?>"
	});

	$("#transmissionType").multiselect({
	    noneSelectedText: "<?php print __("Select Transmission"); ?>",
		selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["Transmission"];?>: " + selectedValues.join(", ");
		   },
		height: 'auto',
		minWidth: '240',
		checkAllText:"<?php print __("Check all"); ?>",
		uncheckAllText:"<?php print __("Uncheck all"); ?>"
	});

	$("#listingBy").multiselect({
	    noneSelectedText: "<?php print __("Select Listing By"); ?>",
		selectedText: function(numChecked, numTotal, checkedItems){
			var selectedValues = new Array();
			for (var i = 0; i < checkedItems.length; i++) {
				selectedValues[i]=checkedItems[i].value;
			}
		      return "<?php print $relanguage_tags["Seller"];?>: " + selectedValues.join(", ");
		   },
		height: 'auto',
		minWidth: '240',
		checkAllText:"<?php print __("Check all"); ?>",
		uncheckAllText:"<?php print __("Uncheck all"); ?>"
	});

 <?php include_once("functions.inc.php"); getCatsSubcats(); ?>	
 $('#reCategory').change(function(){
		 var reCategory=[];
		 var relatedSubCats=[];
		 var relatedCatPrice="";
		 var subCatPriceStatus=[];
		 var allsubcats="<option value='<?php print $relanguage_tags["Any"];?>' selected='selected'><?php print $relanguage_tags["Any"];?></option>";
		 
		$("#reCategory :selected").each(function(i, selected){ 
				 reCategory[i] = $(selected).val();
				 relatedSubCats[i]=catSubcats[reCategory[i]];
				 if(catSubcatsPrice[reCategory[i]]=='true') relatedCatPrice='true';
				 if(catSubcatsPrice[reCategory[i]]==undefined) relatedCatPrice='true';		
								 	 				 
		});

		relatedSubCats.clean(undefined);
				
		for(var i=0;i<relatedSubCats.length;i++){
		tempSubcat=relatedSubCats[i].split(':::');
		for(var j=0;j<tempSubcat.length;j++){
			allsubcats=allsubcats+" <option value='"+tempSubcat[j]+"' >"+tempSubcat[j]+"</option>";
			
		}
		
		}
		
		$('#subcategoriesSection').html("<br /><select name='subcategories[]' multiple id='subCategories'>"+allsubcats+"</select>");
		$("#subCategories").multiselect({
        noneSelectedText: '<?php print __("Select Model"); ?>',
        selectedText: function(numChecked, numTotal, checkedItems){
            var selectedValues = new Array();
            for (var i = 0; i < checkedItems.length; i++) {
                selectedValues[i]=checkedItems[i].value;
            }
              return "<?php print $relanguage_tags["Model"];?>: " + selectedValues.join(", ");
           },
           height:'275',
           minWidth: '240',
           checkAllText:"<?php print __("Check all"); ?>",
           uncheckAllText:"<?php print __("Uncheck all"); ?>"
        }).multiselectfilter();   
		});

	 $('#reCategory2').change(function(){
		 var reCategory=[];
		 var relatedSubCats=[];
		 var relatedCatPrice="";
		 var subCatPriceStatus=[];
		 var allsubcats="";
		 
		$("#reCategory2 :selected").each(function(i, selected){ 
				 reCategory[i] = $(selected).val(); 
				 relatedSubCats[i]=catSubcats[reCategory[i]];
				 if(catSubcatsPrice[reCategory[i]]=='true') relatedCatPrice='true';
						
				  				 
		});

		relatedSubCats.clean(undefined);
				
		for(var i=0;i<relatedSubCats.length;i++){
		tempSubcat=relatedSubCats[i].split(':::');
		for(var j=0;j<tempSubcat.length;j++){
			allsubcats=allsubcats+" <option value='"+tempSubcat[j]+"' >"+tempSubcat[j]+"</option>";
			
		}
		
		}
		if(relatedSubCats.length>0)	$('#subcategoriesSection2').html("<div class='form-group'><label class='col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label'><span class='required_field'>*</span><b><?php print $relanguage_tags["Model"].":</b>";?></label><div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'><select class='form-control' name='subcategory'  id='subCategories'>"+allsubcats+"</select></div><div class='col-xs-5 col-sm-5 col-md-5 col-lg-5'></div></div>");
		else $('#subcategoriesSection2').html("");

		if(relatedCatPrice=='true') $('#priceField').css('display','block');
		else $('#priceField').css('display','none');
	 });

	 $('#byIndividual').click(function(){
		 $('#byOtherSection').css('display','none');
	 });

	 $('#reagentOther').click(function(){
		 $('#byOtherSection').css('display','block');
	 });
	 
	 Array.prototype.clean = function(deleteValue) {
		  for (var i = 0; i < this.length; i++) {
		    if (this[i] == deleteValue) {         
		      this.splice(i, 1);
		      i--;
		    }
		  }
		  return this;
		};

	 	 
    $('#loginButton').click(function(){
	   var reusername=$.trim($('input#reusername').val());
	   var repassword=$.trim($('input#repassword').val());
	   var errorMessage="<?php print $relanguage_tags["Please enter your"];?>: ";
	   var errorCode=0;
	   if(reusername.length<=0){
		    errorMessage=errorMessage+"<?php print $relanguage_tags["Username"];?>";
		    errorCode=1;
	   }
	   if(repassword.length<=0){
		   if(errorCode==1) var errorMessage=errorMessage+" <?php print $relanguage_tags["and"];?> ";
		    errorMessage=errorMessage+"<?php print $relanguage_tags["Password"];?>";
		    errorCode=1;
	   }
	   if(errorCode==1){
		    alert(errorMessage);
		    return false;
	   } 
   });
   
   $("#sidebar1, #sidebar, #sidebarTabs").mouseout(function(){
      $(".tooltip").hide();
   });
   
    $('#sidebarLogin').on("click","#registerButton, #registerLink a",function(){
       var reusername=$('input#reusername').val();
       var repassword=$('input#repassword').val();
       var allData=reusername+":"+repassword;
       $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:allData, type:2}, success: function(data){
          $('#sidebarLogin').html(data); 
          $("#mapResults").trigger("resize");
          }
       });
    });
    
  $('#sidebarLogin').on("click","#forgotPasswordLink, #forgotPasswordLink2 a",function(){
          $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:'sidebarLogin', type:9}, success: function(data){
          $('#sidebarLogin').html(data); 
         }
       });
    });

  $('#sidebarLogin').on("click","#loginLink2 a",function(){
         $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:'sidebarLogin', type:4}, success: function(data){
          $('#sidebarLogin').html(data); 
         }
       });
    });
	
	 <?php include("js/v3map.php"); ?>
	 

var a=10;

 	$('#reprofileimage').click(function(){
	var reprofileimage=$("input[@name=reprofileimage]:checked").val();
	infoResults(reprofileimage,6,'listingProfileImage');
	});

	$('#reprofileimage2').click(function(){
		var reprofileimage=$("input[@name=reprofileimage]:checked").val();
		infoResults('no',6,'listingProfileImage');
	});
	
	$('#reAddListingButton').click(function(){
		var reCategory=$.trim($('select#reCategory2').val());
		var subCategories=$.trim($('select#subCategories').val());
		var byother=$.trim($('input#byother').val());
		var recity=$.trim($('input#recity').val());
		var reheadline=$.trim($('input#reheadline').val());
		var redescription=$.trim($('#redescription').val());
		var rename=$.trim($('input#rename').val());
		var reemail=$.trim($('input#reemail').val());
		var isSubmitListingForm=$('input#isSubmitListingForm').val();
		var errorMessage="<?php print $relanguage_tags["Please specify"];?>: ";
		var startErrorLen=errorMessage.length;
		var errorCode=0;
		
		if(reCategory.length<=0 || reCategory=="Select") errorMessage=errorMessage+"\n<?php print $relanguage_tags["Brand"];?>";
		if(subCategories.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Model"];?>";
		if(recity.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["City"];?>";
		<?php if($headlinelength > 0){ ?>
        if(reheadline.length<=<?php print $headlinelength; ?>) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Headline"];?> (<?php print $headlinelength; ?> <?php print $relanguage_tags["characters"];?>)";
        <?php } ?>
        <?php if($descriptionlength > 0){ ?>
        if(redescription.length<=<?php print $descriptionlength; ?>) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Description"];?> (<?php print $relanguage_tags["atleast"];?> <?php print $descriptionlength; ?> <?php print $relanguage_tags["characters"];?>)";
        <?php } ?>
		if(rename.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Name"];?>";
		if(reemail.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Email"];?>";
		else{
			if (echeck(reemail)==false) return false;			 
		}

		var endErrorLen=errorMessage.length;
		if(startErrorLen<endErrorLen){
		    alert(errorMessage);
		    return false;
	   }else{
			return true;
		   }
	});

	$('#resmtpAuth').change(function(){
	var resmtpAuth=$('select#resmtpAuth').val();
	if(resmtpAuth=="gmail"){
	$('input#resmtp').val("smtp.gmail.com");
	$('input#resmtpPort').val("587");
	$('#emailusername').html("Gmail/Apps Email");
	$('#emailpassword').html("Gmail/Apps Password");
	}else{
		$('input#resmtp').val("");
		$('input#resmtpPort').val("");
		$('#emailusername').html("Username");
		$('#emailpassword').html("Password");
	}
	});

	$('#visitor_submit').click(function(){
		var visitor_name=$.trim($('input#visitor_name').val());	
		var visitor_email=$.trim($('input#visitor_email').val());
		var visitor_message=$.trim($('#visitor_message').val());
		var errorMessage="<?php print $relanguage_tags["Please specify"];?>: ";
		var errorMessageprevLen=errorMessage.length;
		if(visitor_name.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Name"];?>";
		if(visitor_email.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Email"];?>";
		if(visitor_message.length<=0) errorMessage=errorMessage+"\n<?php print $relanguage_tags["Message"];?>";

		if(errorMessage.length>errorMessageprevLen){
		    alert(errorMessage);
		    return false;
		}else{
			return true;
		   }
		});
	$('#listingNormal').click(function(){
		$('#listingStatus').css('display','inline');
	$('#listingStatus').html("Listing will be removed automatically after some days as defined in admin options.");
	});

	$('#listingPermanent').click(function(){
		$('#listingStatus').css('display','inline');
		$('#listingStatus').html("Listing will never expire.");
	});

	var ppcurrency=$('select#ppcurrency').val();
    $('#ppdefaultcurrency').html(ppcurrency);
    
	$('#ppcurrency').change(function(){
    var ppcurrency=$('select#ppcurrency').val();
    $('#ppdefaultcurrency').html(ppcurrency);
	});

	
	$('.refileup').click(function(){
    	var fileid=$(this).attr('id');
		var filenum = fileid.split("-");
		var filenumprev=filenum[1]-1;
		var reMaxPictures=<?php print $reMaxPictures; ?>;
		var errorst;
		var fieldothers;
		if(filenumprev >= 0){
		for(var i=0;i<=filenumprev;i++){
		fieldothers=$.trim($('#reimg'+i).html());
		if(fieldothers.search("<?php print $relanguage_tags["File Uploading Please Wait"]; ?>")>=0 || fieldothers=="")
			errorst=1;
		}
		}
		if(errorst==1){
		alert("<?php print $relanguage_tags["Please upload previous files first"];?>");
		return false;
			}else return true;
		
	});

	$('#rewebTheme').change(function() {
		  var webtheme = $(this).find(":selected").val();
		  $(".webscreen").html("<img src='css/"+webtheme+"/screen.jpg' />");
		});

	<?php if($ptype=="addeditpage"){ ?>
	$('textarea.tinymce1').tinymce({
		script_url : 'tinymce/jscripts/tiny_mce/tiny_mce.js',
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,|,sub,sup,|,charmap,emotions,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		content_css : "css/style.css",
	});

	$('#keywords').tagsInput();

	<?php  } ?>
	
$('.updateLangTag').click(function(){
 <?php if($isThisDemo=="yes"){ ?>
    alert("Language tags can't be updated in demo."); 
 <?php }else{ ?> 
   var clickid= (this.id).split('-');   
   var langkey=$('#'+'keyword-'+clickid[1]).text(); 
   var langtrans=$('#'+'trans-'+clickid[1]).val(); 
   var divid='langResult-'+clickid[1]; 
   var lang=$("#defLang").val(); 
   $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:langkey+':::'+langtrans+':::'+lang, type:28}, success: function(data){ $('#'+divid).html(data); }}); 
 <?php } ?>       
});

<?php if($isThisDemo=="yes"){ ?>
	$('.deletepiclink').click(function(){
	alert("Picture deletion has been disabled in demo.");
	return false;
	});
	$('#addNewTag').click(function(){
		alert("Adding a translation has been disabled in demo.");
		return false;
		});
	$('#addcat').click(function(){
		alert("Adding a brand is disabled in the demo.");
		return false;
		});
	$('#updateAdminOptionsButton').click(function(){
		alert("Updating admin options has been disabled in demo.");
		return false;
		});
	
	$('#reprofilesubmit').click(function(){
		alert("Updating profile has been disabled in demo.");
		return false;
		});
	$('#languageUpdateButton').click(function(){
			alert("Updating language tags has been disabled in demo.");
			return false;
	});	
	$('#updatePriceRange1,#updatePriceRange2').click(function(){
		alert("Updating price range has been disabled in demo.");
		return false;
	});		
<?php } ?>

$('.dropdown-toggle').dropdown();
$('.dropdown-menu').on("click", function(e) { e.stopPropagation(); });
$('#reForm .ui-multiselect').css('width', '225px');

$('#showSidebar').click(function(){
   $("#reForm").show('slow');
   $('#showSidebar').hide();
   $('#hideSidebar').show(); 
});

$('#hideSidebar').click(function(){
   $("#reForm").hide('slow');
   $('#showSidebar').show();
   $('#hideSidebar').hide(); 
});

});

$(window).on('load', function(){
   if($(window).width()<=768){ 
      $('.nav > li').css('display','inline');
      $('.nav > li > a').css('display','inline');
      var topbarHeight=$('.navbar').height();
      <?php if($fixedtopheader=="yes"){ ?>
      $('#sidebar').css('margin-top',topbarHeight+'px');
      <?php }else{ ?>
      $('#sidebar').css('margin-top','0px');    
      <?php } ?>    
      $('#mainContent').css('margin-top','10px');
      }else{
      $('.nav > li').css('display','block');
      $('.nav > li > a').css('display','block');  
      }

    <?php if($fullScreenEnabled!="true"){ ?>
          if($(window).width()<=991){
              $("#reForm").hide();
              $('#showSidebar').css('display','inline');
              <?php if($fixedtopheader=="yes"){ ?>
              $('#sidebar').css('margin-top',topbarHeight+'px');
              <?php }else{ ?>
              $('#sidebar').css('margin-top','0px');    
              <?php } ?>
          }
      <?php } ?>

       <?php if($_SESSION["rtl"]){ ?>
      if($(window).width()>970) $('.sbar').css('float','right');
      else $('.sbar').css('float','none');
      <?php } ?>
      try {setWidthHeight();}catch(err){}    
});


$(window).resize(function () {
  $.ajax({ type: 'GET', url: 'infoResults.php', data:{q:'winwidth:'+$(window).width(), type:27}, success: function(data){ }});  
  if($(window).width()<=1000){ $(".ui-multiselect").width('95%'); }
  //console.log("resized window2: "+$(window).width());
  if($(window).width()<=768){ 
      $('.nav > li').css('display','inline');
      $('.nav > li > a').css('display','inline');
      }else{
      $('.nav > li').css('display','block');
      $('.nav > li > a').css('display','block');
      }
       <?php if($_SESSION["rtl"]){ ?>
      if($(window).width()>970) $('.sbar').css('float','right');
      else $('.sbar').css('float','none');
      <?php } ?>
  try {setWidthHeight();}catch(err){}     
}).resize();

<?php include("reFunctions.php"); ?>
function silentErrorHandler() {return true;}
window.onerror=silentErrorHandler;

</script>
	
</head>

<body>
    <?php $mapMode=false; if(($ptype=="showOnMap" && $_GET['fullscreen']=="true") || $fullScreenEnabled=="true") $mapMode=true; ?>
 <div class="navbar <?php if($fixedtopheader=="yes") print "navbar-fixed-top"; ?> navbar-default" >
    <div class="menuside pull-right"><ul class="nav navbar-nav pull-right"><li><a href="rss.php"><img style='border:0;' src="images/rss.png" alt='rss'></a></li>
    <?php 
    if($isThisDemo=="yes"){
    if(!$_SESSION['rtl']){ ?><li><a href="?ptype=<?php print $ptype; ?>&amp;rtl=1&amp;lang=hebrew" class="label">RTL</a></li><?php }
    else{ ?><li><a href="?ptype=<?php print $ptype; ?>&amp;rtl=0&amp;lang=english" class="label label-important">LTR</a></li><?php } 
    }
    ?>
    </ul></div>
    
    <?php $brandShown=false; if($mapMode){
        $navBarStyle1=' style="margin-right:100px;" ';
        ?>
        <div class="container" style='width:100%;' >
        <?php 
        if(trim($autoadmin_settings['websitelogo'])!=""){ ?>
        <div id='logo'><a style="margin-left:5px;" href="<?php print $full_url_path; ?>"><img src='uploads/<?php print $autoadmin_settings['websitelogo']; ?>' alt='<?php print $reSiteName; ?>' /></a></div>
        <?php }else{ ?>
        <a class="navbar-brand" style="margin-left:5px;" href="<?php print $full_url_path; ?>"><?php print $reSiteName; ?></a>
    <?php  } $brandShown=true; } ?>
    
    <?php if(!$brandShown){ ?><div class="container"> <?php  } ?>
        <!--
    <button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button">
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
    -->
    <?php if(!$brandShown){ 
           if(trim($autoadmin_settings['websitelogo'])!=""){ ?>
           <div id='logo'><a href="<?php print $full_url_path; ?>"><img src='uploads/<?php print $autoadmin_settings['websitelogo']; ?>' alt='<?php print $reSiteName; ?>' /></a></div>
           <?php }else{ ?>
           <a class="navbar-brand" href="<?php print $full_url_path; ?>"><?php print $reSiteName; ?></a> 
    <?php } } ?>
    <?php  if(trim($toplinkad)!=""){ ?>
   <div style="float:left; margin:10px auto 0 40px;" id="top_ad_menu"><?php print $toplinkad; ?></div>
    <?php } ?>
    
    <div class="pull-right top_menu">
    <ul class="nav navbar-nav"  >
    <li class='first_item <?php if($ptype=="" || $ptype=="home") print "active"; ?>'><a href='index.php'><?php print $relanguage_tags["Home"];?></a></li>
  
    <?php 
    if($refriendlyurl=="enabled")$contactPageLink="contact-us";
    else $contactPageLink="index.php?ptype=contactus";
        
    $qrpg="select id, page_name, topmenu, footermenu from $pageTable order by page_order asc;";
    $resultpg=mysqli_query($coni,$qrpg);
    while($apage=mysqli_fetch_assoc($resultpg)){
         if($refriendlyurl=="enabled"){
            $pageLink=friendlyUrl($apage['page_name'],"_")."-".$apage['id'];
            
        }else{
            $pageLink="index.php?ptype=page&amp;id=".$apage['id'];
            
        }
    if($apage['topmenu']==1){     
    ?>
    <li <?php if(htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8')== $apage['id']) print " class='active' "; ?>><a href='<?php print $pageLink; ?>'><?php print $apage['page_name'];?></a></li>
    <?php } 
    } ?>
    <li class='favli' id='favli' style="display:none;"><a href='#'><?php print __("Favorite");?></a></li>
    <li <?php if($ptype=="contactus") print " class='active' "; ?>><a href='<?php print $contactPageLink; ?>'><?php print $relanguage_tags["Contact us"];?></a></li>
    <!--<li class='login_link btn-primary' id='loginlink'><a href='loginForm.php'><?php print __("Login");?></a></li>-->
    <li class="divider-vertical"></li>
          <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                <?php if(!isset($_SESSION['myusername'])) print __("Login"); else{ print $relanguage_tags["Welcome"];?> <b><?php print $_SESSION["myusername"]."</b>"; } ?><strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px;">
              <?php include("loginForm.php"); ?>
            </div>
          </li>
    </ul>
    <?php if($isThisDemo=="yes"){ if($ptype=="viewFullListing")$ptype2="home"; else $ptype2=$ptype; 
    if($webtheme!="") $theme_menu=ucfirst($webtheme); else $theme_menu="Themes";
    ?>
     <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print $theme_menu; ?> Theme <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="index.php?theme=default&amp;ptype=<?php print $ptype2; ?>">Default</a></li>
          <li><a href="index.php?theme=amelia&amp;ptype=<?php print $ptype2; ?>">Amelia</a></li>
          <li><a href="index.php?theme=cerulean&amp;ptype=<?php print $ptype2; ?>">Cerulean</a></li>
          <li><a href="index.php?theme=cosmos&amp;ptype=<?php print $ptype2; ?>">Cosmos</a></li>
          <li><a href="index.php?theme=cyborg&amp;ptype=<?php print $ptype2; ?>">Cyborg</a></li>
          <li><a href="index.php?theme=flatly&amp;ptype=<?php print $ptype2; ?>">Flatly</a></li>
          <li><a href="index.php?theme=journal&amp;ptype=<?php print $ptype2; ?>">Journal</a></li>
          <li><a href="index.php?theme=readable&amp;ptype=<?php print $ptype2; ?>">Readable</a></li>
          <li><a href="index.php?theme=simplex&amp;ptype=<?php print $ptype2; ?>">Simplex</a></li>
          <li><a href="index.php?theme=slate&amp;ptype=<?php print $ptype2; ?>">Slate</a></li>
          <li><a href="index.php?theme=spacelab&amp;ptype=<?php print $ptype2; ?>">Spacelab</a></li>
          <li><a href="index.php?theme=united&amp;ptype=<?php print $ptype2; ?>">United</a></li>
          <li><a href="index.php?theme=yeti&amp;ptype=<?php print $ptype2; ?>">Yeti</a></li>
          <li><a href="index.php?theme=custom&amp;ptype=<?php print $ptype2; ?>">Custom</a></li>
        </ul>
      </li>
     </ul>
    <?php } ?> 
    </div> <!-- nav-collapse -->
       
    <?php if(!$brandShown){ ?></div> <!-- container --> <?php  } ?>
  
<?php if($brandShown){ ?>  </div> <!-- End Container1 --> <?php }  ?>
    </div> <!-- navbar-inner -->
 
 