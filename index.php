<?php
session_start();
error_reporting(0);
include("site.inc.php");
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$aopt=mysqli_fetch_assoc(mysqli_query($coni,"select splashpage from admin_options;"));

if($aopt['splashpage']!="none" && !isset($_GET['ptype']) && !isset($_POST['ptype']) && !isset($_SESSION["myusername"]) && !isset($_POST['city']) && !isset($_GET['city']) ){
 if(trim($aopt['splashpage']!="")){ include("splash/".$aopt['splashpage']); exit; }   
}
mysqli_close($con);
 
include("header.php"); 
$containerClass="container"; $rowClass="row";
?>
<div id='wrapper'> 
<div class='<?php print $containerClass; ?>'>
<?php
if(($ptype=="" && $fullScreenEnabled!="true") || $ptype=="home" || $ptype=="viewMemberListing" || $ptype=="viewFullListing" || ($ptype=="showOnMap"  && $fullScreenEnabled!="true") || $ptype=="adminOptions"  || $ptype=="UpdateAdminOptions" || $ptype=="allMembers" || $ptype=="contactus" || $ptype=="page" || $_GET["cpage"]==1){
	if($ptype=="viewMemberListing")	$reextraMessage=" ".$relanguage_tags["your listings"]." ";
	else $reextraMessage=" ".$relanguage_tags["all listings"]." ";
	?>

<div class='<?php print $rowClass; ?>'>
<div class='col-md-4 col-lg-4 sbar'>
  <div id="sidebar">
  
  <div id="sidebar1">
  <div class='a_block'>
    <h3><span id='showSidebar' class="icon-double-angle-down"></span><span id='hideSidebar' class="icon-double-angle-up"></span><?php print __("Search").$reextraMessage; ?></h3>
    <?php include("reSearchForm.php"); ?>
  </div>
  </div>  <!-- end #sidebar1 -->
 

  <?php  if(trim($sidebarad)!=""){ ?>
  <div id='sidebarad1'><?php print $sidebarad; ?></div>
 <?php } ?>
  </div> <!-- end #sidebar -->
 </div>
<div class='col-md-8 col-lg-8'>  
  <div id="mainContent">
  	<div id='reResults'>
  	<?php if($ptype=="viewFullListing") include("viewFullListing.php"); ?>
  	<?php if($ptype=="adminOptions" || $ptype=="UpdateAdminOptions") include("adminOptions.php"); ?>
    <?php if($ptype=="allMembers") include("allMembers.php"); ?> 
    <?php if($ptype=="showOnMap"  && $fullScreenEnabled!="true") print "<div id='mapResults'></div>" ?>	
    <?php if($ptype=="contactus") include("contactus.php"); ?>
    <?php if($ptype=="page"){ include("page.php"); $fullScreenEnabled="false"; } ?>
    <?php if($_GET["cpage"]==1) include("pluginPage.php"); ?>
    <?php if($ptype=="categoriesEdit") loadPage("categoriesEdit.php"); ?>
  </div>    
  </div><!-- end #mainContent -->
 </div> 
</div>

<?php
} 

if($fullScreenEnabled=="true"){
    ?>
<div style="width:100%;">

 <div style="width:269px;" id='mapSidebar' >
 <div id='showbar' data-original-title="<?php print $relanguage_tags["Show the sidebar"]; ?>"></div>
 <div id="sidebar" class='ui-widget-content'>
  <div id="sidebarTabs"><div id='hidebar' data-original-title="<?php print $relanguage_tags["Hide the sidebar"]; ?>"></div>
    <ul>
    <li><a href="#sidebar1"><?php print __("Search"); ?></a></li>
    <li><a href="#sidebarResults"><?php print __("Results"); ?></a></li>
    </ul>       
  <div id="sidebar1">
    <div class='a_block'>
    <!-- <div id="logo2"></div> -->
    <h3><?php print $relanguage_tags["Search"].$reextraMessage; ?></h3>
    <?php include("reSearchForm.php"); ?>
    </div>
    
    <?php  if(trim($sidebarad)!=""){ ?>
     <div id='sidebarad1'><?php print $sidebarad; ?></div>
    <?php } ?>
 
  </div>  <!-- end #sidebar1 -->
  <div id='sidebarResults'></div>
  </div>
   
  </div> <!-- end #sidebar -->
  </div> <!-- end mapSidebar -->



<div style="width:80%;" id='mapContainer'>
<div id="mainContent"><div id='mapResults'></div><div id='theListing'></div><div id='MapLoadingImage'><img src='images/maploading1.gif' alt='loading' /></div>
<div id='modeButton'><a class='btn btn-primary btn-large' href='index.php?ptype=home&<?php print str_replace("ptype=", "",htmlspecialchars($_SERVER['QUERY_STRING'])); ?>'><i class='icon-align-justify'></i> <?php print __("Switch to text mode"); ?></a></div>
</div> <!-- end span8 -->
</div>

</div> <!-- end row -->
<div class="nolisting alert alert-info"><a class="close"  onclick="$('.alert').hide()" data-dismiss="alert" href="#">x</a>
<h4 style="text-align:'center'"><?php print $relanguage_tags["No listings found for your search criteria"]; ?>.
<?php if($isThisDemo=="yes") print "The demo has limited listings."  ?> 
</h4></div>
    <?php 
}

if($ptype=="checklogin") loadPage("checklogin.php");
if($ptype=="submitReListing") loadPage("submitReListing.php");
if($ptype=="addReListing") loadPage("addReListing.php");
if($ptype=="editReListingForm") loadPage("editReListingForm.php");
if($ptype=="updateReListing") loadPage("updateReListing.php");
if($ptype=="myprofile") loadPage("myprofile.php");
if($ptype=="languagetags" || $ptype=="updateLanguageTags") loadPage("languagetags.php");
if($ptype=="categories" || $ptype=="updateCategories") loadPage("categories.php");
if($ptype=="pricerange" || $ptype=="updatePriceRange") loadPage("pricerange.php");
if($ptype=="features") loadPage("features.php");
if($ptype=="fueltype") loadPage("fueltype.php");
if($ptype=="bodytype") loadPage("bodytype.php");
if($ptype=="addeditpage") loadPage("addeditpage.php");
if($ptype=="oodle" || $ptype=="updateOodle") loadPage("plugins/oodle/options.php");

?>
</div>
</div>

<?php include("footer.php"); ?>