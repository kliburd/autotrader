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
$vargs[0]=viewFullListing($viewListingRow,$mem_id,$showMoreListings);
$vargs[1]=$viewListingRow;
$vdata=call_plugin("viewFullListing",$vargs);
print $vdata[0];

function viewFullListing($viewListingRow,$mem_id,$showMoreListings=""){
    global $ptype, $reid;
    include("config.php");
ob_start();   
$row=$viewListingRow;
$region=htmlspecialchars(trim($_GET["region"]), ENT_QUOTES, 'UTF-8');
if($row['user_id']!="oodle"){
	$reqr1="select price from $categoryTable where category='".$row['category']."'";
	$resultre1=mysqli_query($coni,$reqr1);
	$categoryRow=mysqli_fetch_assoc($resultre1);
	$allFeaturesArray=explode(":::",$row['all_features']);
	$allFeatureSize=sizeof($allFeaturesArray);
	
	$rePicArray=explode("::",$row['pictures']);
	$totalRePics=sizeof($rePicArray);
	if ($totalRePics > $reMaxPictures) $totalRePics = $reMaxPictures;
	if($row['show_image']=="yes"){
		$qr1="select photo from $rememberTable where id='".$row['user_id']."'";
		$result1=mysqli_query($coni,$qr1);
		$row1=mysqli_fetch_assoc($result1);
		$poster_pic=$row1['photo'];
	}
	if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true){
$contactImageClause=" style='float:left;' ";
}
if(trim($poster_pic)!="") $contact_image="<div class='recontact_image' $contactImageClause><img src='uploads/".$poster_pic."' height='125' alt='' /></div>";
else $contact_image="<div class='recontact_image' $contactImageClause><img src='images/identity.png' height='128' alt='' /></div>";

}else{
	//include_once("functions.inc.php");
	$rePicArray=explode("::",$row['pictures']);
	$totalRePics=sizeof($rePicArray);
	if ($totalRePics > $reMaxPictures) $totalRePics = $reMaxPictures;
	$poster_pic=$row['photo'];
	if(trim($poster_pic)!="") $contact_image="<div class='recontact_image'><img src='".$poster_pic."' height='125' alt='' /></div>";
	else $contact_image="<div class='recontact_image'><img src='images/identity.png' height='128' alt='' /></div>";

	require_once('geoplugin.class.php');
	$geoplugin = new geoPlugin();
	$geoplugin->locate();
	$vCountry=$geoplugin->countryName;
	$defaultCurrency=getOodleCurrency($vCountry,$defaultCurrency);
}

if($row['relistingby']=="owner") $row['relistingby']=$relanguage_tags["Individual"];
if($row['relistingby']=="reagent") $row['relistingby']=$row['listing_by_other'];
if($row['relistingby']=="") $row['relistingby']="Individual";
if($row['price']==0)$row['price']="";
if($row['resize']==0)$row['resize']="";

$_SESSION['currency_before_price']=$currency_before_price;
//$row['dttm_modified'] = date("d, m, Y", strtotime($row['dttm_modified']));
//print "marked: ".hasVisited($row['id']);

function printAttribute($attribute,$tag,$defaultCurrency=""){
   include_once("functions.inc.php");   
   if($attribute!=""){
     if($_SESSION['currency_before_price']) $full_attribute=$defaultCurrency.__($attribute);
     else  $full_attribute=__($attribute)." ".$defaultCurrency;  
     if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) $attrClause=" style='float:left;' ";
     print "<tr><td><b>".__($tag).":</b> <span class='attr_value' $attrClause>".$full_attribute."</span></td></tr>";
   } 
}

?>

<div id='rememberAction'>
<table id='resultTable'>
<tr class='headRow1'><td colspan='2'><h4 style='margin:0; display:inline;'><?php print $row['autoage']." ".__($row['category'])." - ".__($row['subcategory'])." - ".$row['city']." (".__("Listing id")." #".$row['id'].")"; ?></h4>
<?php if($row['listing_type']==2){ print "<span class='featuredlisting label label-primary'>".$relanguage_tags["Featured"]."</span>"; } print hasVisited($row['id']); ?>
<div class="pull-right" id='closeMapListing' style="cursor:pointer;"><img src='images/fancy_close.png' height='20' alt='close' /></div>
</td></tr>
<tr>
<td style='vertical-align:top; width:100%;'>
<div class='container-fluid'> 
<div class='row'>  
<div class='col-sm-7 col-md-7 col-lg-7' id='image_cell'>     
<?php if (trim($rePicArray[0]!="")){ ?>    
<div id='listingImage'><a data-fancybox-group='listgallery' href='<?php print $rePicArray[0]; ?>' ><img src='<?php print $rePicArray[0]; ?>' style='width:100%;' alt='listing image' /></a></div>
<?php } ?>
</div>
<div class='col-sm-5 col-md-5 col-lg-5 reAttributes'>
<?php
 $_SESSION["reid"]=$row['id'].":".$_SESSION["reid"];
 $allMarkedreid=explode(":",$_SESSION["marked_reid"]);
 $full_address="";
    if($row['address']!="") $full_address=$row['address'];
    if($row['city']!="") $full_address=$full_address.", ".$row['city'];
    if($row['state']!="") $full_address=$full_address.", ".$row['state'];
    if($row['postal']!="") $full_address=$full_address.", ".$row['postal'];
    if($row['country']!="") $full_address=$full_address.", ".$row['country'];
    $full_address=trim($full_address,',');
    $automodel=__($row['autoage'])." ".__($row['category'])." ".__($row['subcategory']);
?>
<div class="model_attr"><?php print $automodel; ?></div>
<table id='listing_attributes'>
<?php    
 list($ldate,$ltime)=explode(" ",$row['dttm_modified']);
 printAttribute($row['relistingby'],"Listing by");
 printAttribute(number_format($row['price']),"Price",$defaultCurrency);
 if($row['mileage']>0)printAttribute(number_format($row['mileage']),$redefaultDistance);
 printAttribute($row['fueltype'],"Fuel Type");
 printAttribute($row['transmission'],"Transmission");
 printAttribute($row['bodytype'],"Body Type");
 printAttribute($row['excolour'],"Exterior Colour");
 printAttribute($row['incolour'],"Interior Colour");
 printAttribute($row['drive'],"Drive");
 printAttribute($ldate,"Date Listed");
 
 ?>   
</table>
 <div class="address_attr"><?php print $full_address; ?></div>
</div>
</div> <!-- End row -->
<div class='row'>  
<div class='col-sm-12 col-md-12 col-lg-12'> 
<div id='listing_Buttons'>
<?php if(in_array($row['id'],$allMarkedreid)){ ?>
<div id='reAlreadyMarkedListing'><span class="btn btn-primary ttip" title='<?php print $relanguage_tags["This listing has been liked by you"];?>.'><?php print $relanguage_tags["Liked"]." ".$relanguage_tags["Listing"];?></span></div>
<?php }else{ ?>
<div id='reMarkedListing'><span class='btn btn-default' title='<?php print $relanguage_tags["Mark this listing to find it easily in future"];?>.'  onclick="infoResults('<?php print $row['id']; ?>',8,'reMarkedListing');"><?php print __("Watch");?></span></div>
<?php } ?>
<a title='<?php print $relanguage_tags["Click above to send a message to the poster of this listing"]; ?>' href='contactPoster.php?reid=<?php print $row['id']; ?>' class='btn btn-default listingcontact'><?php print __("Contact");?></a>
<?php
$ip=$_SERVER["REMOTE_ADDR"];
$listing_id=$row['id'];
$fqr="select * from flagging where ip='$ip' and listing_id='$listing_id'";
$fresult=mysqli_query($coni,$fqr); 
if(mysqli_num_rows($fresult) > 0){
    $reportButton=__("Reported");
    $reportClause=' disabled="disabled" ';
}else{
    $reportButton=__("Report this");
    $reportClause="";
}

?>
<div id='reFlaggedListing'><span onclick="infoResults('<?php print $row['id']; ?>',29,'reFlaggedListing');" class="btn btn-danger listingflag" title="" data-original-title="<?php print __("Flag this listing"); ?>" <?php print $reportClause; ?> ><?php print $reportButton; ?></span></div>
<br />
</div>
</div>
</div> <!-- End row -->
</div> <!-- end container -->
</td>
</tr>

<tr>
    <td colspan='2' style='text-align:center;'>
<?php 

if($totalRePics>1) { ?>
<div id='viewListingImages'>
<?php 
$imgRowCount=0;
for($imgCount=0;$imgCount<$totalRePics;$imgCount++){ 
if(trim($rePicArray[$imgCount])!=""){
print "<div class='slide'><span id='image_icon-$imgCount'><a href='#'><img src='timthumb.php?src=$rePicArray[$imgCount]&amp;h=100' alt='listing image' /></a></span></div>"; 
}
}

?>
</div>
<?php 
print "<div style='display:none;'>";
for($imgCount=0;$imgCount<$totalRePics;$imgCount++){ 
if(trim($rePicArray[$imgCount])!="") print "<span id='bimage-$imgCount'>$rePicArray[$imgCount]</span>";
}
print "</div>";
}
?>
    </td>
</tr>

<?php if($allFeatureSize>1){ ?>
<tr><td colspan='2'>
<div class='listingItem'><b><?php print $relanguage_tags["Features"];?></b><br />
<table style="text-align:'center'; width:100%;" class='table table-striped table-bordered'>
<?php
$count=1; 
for($i=0;$i<$allFeatureSize;$i++){
	if($count==1)
	print "<tr><td><div class='featureItem'>".$relanguage_tags[$allFeaturesArray[$i]]."</div></td>";
	if($count==2)
	print "<td><div class='featureItem'>".$relanguage_tags[$allFeaturesArray[$i]]."</div></td>";
	if($count==3){
	print "<td><div class='featureItem'>".$relanguage_tags[$allFeaturesArray[$i]]."</div></td></tr>";
	$count=0;
	}
	$count++;
} 
?>
</table>
</div>
</td></tr>
<?php } ?>
<tr id='reDescriptionRow'>
<td colspan='2'><div id='listingAllowedThings'><?php print $reAllowedThings; ?></div>
<div class='listingItem'><b><span class='reListingHeadline'><?php print $row['headline']; ?></span></b></div>
<div class='listingItem'><b><?php print $relanguage_tags["Description"];?>:</b><br /><div class='reListingDescription'><?php print nl2br($row['description']); ?></div></div>
<?php if($ptype=="viewFullListing"){ ?>
<div class='listingItem'><b><?php print $relanguage_tags["Location on map"];?>:</b></div>
<div id='reListingOnMap'></div>
<?php } ?>
<?php if($row['contact_name']!="" || $row['contact_phone']!="" || $row['contact_email']!="" || $row['contact_website']!="" || $row['contact_address']!=""){ ?>
<div class='reContactInformation alert alert-warning'><b><?php print $relanguage_tags["Contact Information"];?></b>
<?php print $contact_image; if($row['contact_name']!=""){ ?><div class='recontact_info'><br /><b><?php print $relanguage_tags["Name"];?>:</b> <?php print $row['contact_name']; }
if($row['contact_phone']!="") print "<br /><b>".$relanguage_tags["Phone"]." :</b> ".$row['contact_phone'];
if($autoadmin_settings['listingemail']=="yes") print "<br /><b>".$relanguage_tags["Email"].":</b> ".$row['contact_email'];
if($row['contact_website']!="") print "<br /><b>".$relanguage_tags["Website"].":</b> <a href='".$row['contact_website']."' target='_blank'>".$row['contact_website']."</a>";
if($row['contact_address']!="") print "<br /><b>".$relanguage_tags["Address"]."</b><br />".nl2br($row['contact_address']); 

?></div></div>
<?php } ?>
<div class='listingButtons' style="margin-bottom:40px;"><?php 
if(isset($_SESSION["memtype"]) && trim($ppemail)!="" && $featuredduration>0 && $featuredprice>0 && $row['listing_type']!=2 && $row['user_id']!="oodle") featuredButton($row['user_id'],$mem_id,$row['id']); 
showMemberNavigation($row['user_id'],$mem_id,$row['id'],2); 
if(isset($_SESSION["memtype"]) && trim($ppemail)!="" && $featuredduration>0 && $featuredprice>0  && $row['listing_type']!=2 && $row['user_id']!="oodle"){
?>
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php } ?>
</div>
</td>
</tr>

</table>
</div>

<?php if($showMoreListings!="no"){ ?>
<h3 class='reHeading1'><?php print $relanguage_tags["Similar listings based on your search criteria"];?></h3>
<div id='reResults2'></div>
<?php
}
return ob_get_clean();
}
?>