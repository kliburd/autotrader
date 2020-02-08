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
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
error_reporting(1);
//date_default_timezone_set('America/Toronto');

function searchResults($reFullQuery,$onlyMemberListings="no",$showFavorite="no"){
 /*
 * Filters data through the functions registered for "searchResults" hook.
 * Passes the content through registered functions.
 */
  print call_plugin("searchResults",searchResults2($reFullQuery,$onlyMemberListings,$showFavorite));
}

function searchResults2($reFullQuery,$onlyMemberListings="no",$showFavorite="no"){
include("config.php"); 
ob_start();
list($reCategory,$reSubcategory,$rePrice,$autoAge,$bodyType,$fuelType,$transmissionType,$listingBy,$reQuery,$reCity,$listingsPerPage,$pageNum,$sortby)=explode(":",$reFullQuery);
$rePartialQuery="$reCategory:$reSubcategory:$rePrice:$autoAge:$bodyType:$fuelType:$transmissionType:$listingBy:$reQuery:$reCity";
$mem_id=$_SESSION["re_mem_id"];
reSetSearchSession($reCategory,$reSubcategory,$rePrice,$autoAge,$bodyType,$fuelType,$transmissionType,$listingBy,$reQuery,$reCity);

//print "$reFullQuery<br />";
//print $relanguage_tags[];
if($onlyMemberListings=="yes"){
	$extraMessage=" your ";
	$functionType=7;
}else{
	$functionType=1;
}

if($showFavorite==="yes") $functionType=26;
if($listingsPerPage=="")$listingsPerPage=40;
if($pageNum=="")$pageNum=1;


$startListingNum=($pageNum-1)*$listingsPerPage;
$endListingNum=$startListingNum+$listingsPerPage;
$startListingNum2=$startListingNum+1;

if($sortby==""){
	$sortby="dateUp";
}

if($sortby=="priceUp"){
	$priceSort="priceDown";
	$priceSortClass=$priceSort;
	$sortbyClause=" price desc ";
}
if($sortby=="priceDown"){
	$priceSort="priceUp";
	$priceSortClass=$priceSort;
	$sortbyClause=" price asc ";
}
if($priceSort==""){
$priceSort="priceDown";
$priceSortClass="";
}

if($sortby=="ageUp"){
	$yearSort="ageDown";
	$yearSortClass=$yearSort;
	$sortbyClause=" autoage desc ";
}
if($sortby=="ageDown"){
	$yearSort="ageUp";
	$yearSortClass=$yearSort;
	$sortbyClause=" autoage asc ";
}
if($yearSort==""){
	$yearSort="ageDown";
	$yearSortClass="";
}

if($sortby=="distanceUp"){
	$distanceSort="distanceDown";
	$distanceSortClass=$distanceSort;
	$sortbyClause=" mileage desc ";
}
if($sortby=="distanceDown"){
	$distanceSort="distanceUp";
	$distanceSortClass=$distanceSort;
	$sortbyClause=" mileage asc ";
}
if($distanceSort==""){
	$distanceSort="distanceDown";
	$distanceSortClass="";
}

if($sortby=="cityUp"){
	$citySort="cityDown";
	$citySortClass=$citySort;
	$sortbyClause=" city desc ";
}
if($sortby=="cityDown"){
	$citySort="cityUp";
	$citySortClass=$citySort;
	$sortbyClause=" city asc ";
}
if($citySort==""){
	$citySort="cityDown";
	$citySortClass="";
}
if($sortby=="dateUp"){
	$dateSort="dateDown";
	$dateSortClass=$dateSort;
	$sortbyClause=" dttm desc ";
}
if($sortby=="dateDown"){
	$dateSort="dateUp";
	$sortbyClause=" dttm asc ";
	$dateSortClass=$dateSort;
}
if($dateSort==""){
	$dateSort="dateDown";
	$dateSortClass="";
}

if($delete_after_days>0){
$str_older = date("Y-m-d");
$str_month = date("n");
$str_day = date("j");
$str_year = date("Y");
$minmonth = mktime(0, 0, 0, $str_month, $str_day - $delete_after_days ,  $str_year );
$str_older = date("Y-m-d",$minmonth);
$str_older_dttm="$str_older 23:59:59";

$qr00="select count(*) from $reListingTable";
$result00=mysqli_query($coni,$qr00);
$row00=mysqli_fetch_array($result00);
$numResults00=$row00[0];
$dttm_mod_clause=" and dttm_modified > '$str_older_dttm' ";
}else{
$dttm_mod_clause="";	
}

if(isset($_SESSION["memtype"]) && $_SESSION["memtype"]==9) $adminClause1=" id like '%' ";
else  $adminClause1=" listing_type <> 3 ";

if($functionType==7) $adminClause1=" id like '%' ";
if(isset($_SESSION["memtype"]) && $_SESSION["memtype"]==9){
$flagClause=" flag desc, ";    
}else $flagClause="";

if($showFavorite=="no"){
if($autoadmin_settings['oodleplugin']==1 && function_exists("getOodleArray") && $onlyMemberListings=="no"){
$qr0="select * from $reListingTable where $adminClause1 ".getRealValue($reCategory,"reCategory").getRealValue($reSubcategory,"reSubcategory")
.getRealValue($rePrice,"rePrice").getRealValue($autoAge,"autoAge").getRealValue($bodyType,"bodyType").getRealValue($fuelType,"fuelType").getRealValue($transmissionType,"transmissionType")
.getRealValue($listingBy,"listingBy").getRealValue($onlyMemberListings,"onlyMemberListings").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity")." 
 $dttm_mod_clause and listing_type<>'2' ;";
$result0=mysqli_query($coni,$qr0);
$numResults=mysqli_num_rows($result0);

$qr1="select * from $reListingTable where $adminClause1 ".getRealValue($reCategory,"reCategory").getRealValue($reSubcategory,"reSubcategory")
.getRealValue($rePrice,"rePrice").getRealValue($autoAge,"autoAge").getRealValue($bodyType,"bodyType").getRealValue($fuelType,"fuelType").getRealValue($transmissionType,"transmissionType")
.getRealValue($listingBy,"listingBy").getRealValue($onlyMemberListings,"onlyMemberListings").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity")
." $dttm_mod_clause and listing_type<>'2' order by $flagClause listing_type DESC, $sortbyClause limit $startListingNum,$listingsPerPage ; ";
$result=mysqli_query($coni,$qr1);

$qr2="select * from $reListingTable where $adminClause1 ".getRealValue($reCategory,"reCategory").getRealValue($reSubcategory,"reSubcategory")
.getRealValue($rePrice,"rePrice").getRealValue($autoAge,"autoAge").getRealValue($bodyType,"bodyType").getRealValue($fuelType,"fuelType").getRealValue($transmissionType,"transmissionType")
.getRealValue($listingBy,"listingBy").getRealValue($onlyMemberListings,"onlyMemberListings").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity")
." $dttm_mod_clause and listing_type<>'2' order by $sortbyClause ; ";
$result2=mysqli_query($coni,$qr2);

$featuredListings=array();
while($line = mysqli_fetch_assoc($result2)) $featuredListings[] = $line;

$cListings=array();
$oodleListingArray=array();

require_once('geoplugin.class.php');
$geoplugin = new geoPlugin();
$geoplugin->locate();
$vCountry=$geoplugin->countryName;
$oodlecRegion=getOodleRegion($vCountry);

if($oodlecRegion!="no"){
	if($listingOffset==0 || $listingOffset=="") $listingOffset=1;
	while($line = mysqli_fetch_assoc($result)) $cListings[] = $line;
	list($price1,$price2)=explode("-", $rePrice);
	if($rePrice!=10) $attr="price_".$price1."_".$price2;
	$oodleSubcats=explode(",",$reSubcategory);
	foreach($oodleSubcats as $oindex => $osubcatkey){
		$oodleListingArray=array_merge($oodleListingArray,getOodleArray($reCategory,$osubcatkey,$reQuery,$reCity,$oodlecRegion,$reMaxPictures,1,50,$attr));
	}
}

if(is_array($oodleListingArray)) $combArray=array_merge($cListings,convertArrayToClFormat($oodleListingArray));
else $combArray=$cListings;

if($sortby==="")$sortby="dateUp";
usort($combArray, $sortby);
$combArray=array_merge($featuredListings,$combArray);
$totalCombLists=sizeof($combArray);
$numResults=$totalCombLists;
$startFrom=$startListingNum;
$endAt=$endListingNum;
if($endAt>$numResults) $endAt=$numResults;
}else{
	$qr0="select * from $reListingTable where $adminClause1 ".getRealValue($reCategory,"reCategory").getRealValue($reSubcategory,"reSubcategory")
	.getRealValue($rePrice,"rePrice").getRealValue($autoAge,"autoAge").getRealValue($bodyType,"bodyType").getRealValue($fuelType,"fuelType").getRealValue($transmissionType,"transmissionType")
	.getRealValue($listingBy,"listingBy").getRealValue($onlyMemberListings,"onlyMemberListings").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity")."
	$dttm_mod_clause ; ";
	$result0=mysqli_query($coni,$qr0);
	$numResults=mysqli_num_rows($result0);
	
	$qr1="select * from $reListingTable where $adminClause1 ".getRealValue($reCategory,"reCategory").getRealValue($reSubcategory,"reSubcategory")
	.getRealValue($rePrice,"rePrice").getRealValue($autoAge,"autoAge").getRealValue($bodyType,"bodyType").getRealValue($fuelType,"fuelType").getRealValue($transmissionType,"transmissionType")
	.getRealValue($listingBy,"listingBy").getRealValue($onlyMemberListings,"onlyMemberListings").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity")
	." $dttm_mod_clause order by $flagClause listing_type DESC, $sortbyClause limit $startListingNum,$listingsPerPage ; ";
	$result=mysqli_query($coni,$qr1); 
	while($line = mysqli_fetch_assoc($result)) $combArray[] = $line;
	$startFrom=0;
	$endAt=sizeof($combArray);
}

}else{
$allfavs=explode(":",$_SESSION["marked_reid"]); 
$favcounter=0;
foreach($allfavs as $favc => $favid){
	$favArr=getFavRecord($favid); 
	if(is_array($favArr)) $combArray[$favcounter]=$favArr; 
	$favcounter++;
} 
if($sortby==="")$sortby="dateUp";
usort($combArray, $sortby);
$startFrom=0;
$endAt=sizeof($combArray);
$numResults=$endAt; 
$favClause1=" ".__("Favorite")." ";
}

$totalPages=ceil($numResults/$listingsPerPage);
if($endListingNum>$numResults)$endListingNum=$numResults;

$combArray=call_plugin("searchResultsRecords",$combArray);

$qrp="select price from $categoryTable where id like '%' and price='true' ".getRealValue($reCategory,"reCategory");
$resultp=mysqli_query($coni,$qrp);
if(mysqli_num_rows($resultp)>0){
	$showPrice="true";
	$otherRowSpan=7;
	$cityAlignment=" ";
}
else{
	$showPrice="false";
	$otherRowSpan=6;
	$cityAlignment=" align='center' ";
}

if($endListingNum>$numResults)$endListingNum=$numResults;

if($numResults>0){
print "<table id='resultTable' class='table table-striped'>";
print "<tr class='headRow1'><th colspan='2'><div class='pull-left'>".$relanguage_tags["Showing"]." <b>$startListingNum2 - $endListingNum</b> ".__("of")." $extraMessage<b>$numResults</b> ".$relanguage_tags["Listings"].".</div></th>
<th colspan='5' class='shownumResults'><div class='pull-right'>"; 
if($pageNum==1){
?>
<?php print $relanguage_tags["Show"];?> <select name='subtype' id='reListingsPerPage1' >
<option value='<?php print "$rePartialQuery:20:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==20)print " selected='selected' "; ?>>20</option>
<option value='<?php print "$rePartialQuery:40:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==40)print " selected='selected' "; ?>>40</option>
<option value='<?php print "$rePartialQuery:60:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==60)print " selected='selected' "; ?>>60</option>
<option value='<?php print "$rePartialQuery:80:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==80)print " selected='selected' "; ?>>80</option>
<option value='<?php print "$rePartialQuery:100:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==100)print " selected='selected' "; ?>>100</option>
<?php 
print "</select> ".$relanguage_tags["listings"]."/".$relanguage_tags["page"];
}
print "</div></th></tr>";
print "<tbody><tr class='headRow2'><td></td><td  style='color:#A4A4A4; text-align:right;'>".__("Sort by")."</td>";
if($showPrice=="true"){
?>
<td  class='hsorting' align='center'><a href='#'><span style="display:none;"><?php print "$rePartialQuery:$listingsPerPage:$pageNum:$priceSort-@@-$functionType"; ?></span><?php print $relanguage_tags["Price"];?></a><div class="<?php print $priceSortClass; ?>"></div></td>
<?php } ?>
<td class='hsorting'><a href='#'><span style="display:none;"><?php print "$rePartialQuery:$listingsPerPage:$pageNum:$yearSort-@@-$functionType"; ?></span><?php print __("Year");?></a><div class='<?php print $yearSortClass; ?>'></div></td>
<td class='hsorting'><a href='#'><span style="display:none;"><?php print "$rePartialQuery:$listingsPerPage:$pageNum:$distanceSort-@@-$functionType"; ?></span><?php print $relanguage_tags[$redefaultDistance];?></a><div class='<?php print $distanceSortClass; ?>'></div></td>
<td class='hsorting'><a href='#'><span style="display:none;"><?php print "$rePartialQuery:$listingsPerPage:$pageNum:$citySort-@@-$functionType"; ?></span><?php print $relanguage_tags["City"];?></a><div class='<?php print $citySortClass; ?>'></div></td>
<td class='hsorting'><a href='#'><span style="display:none;"><?php print "$rePartialQuery:$listingsPerPage:$pageNum:$dateSort-@@-$functionType"; ?></span><?php print $relanguage_tags["Date"];?></a><div class='<?php print $dateSortClass; ?>'></div></td></tr>
<tr><td colspan='7' class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<div class='container-fluid'>
<?php 
$count=0;
for($c=$startFrom;$c<$endAt;$c++){
if($count>=$listingsPerPage) break;
$row=$combArray[$c];
$smallDesc=utf8_substr($row['description'],0,250)."....";
list($listingDate,$listingTime)=explode(" ",$row['dttm']);
$rePicArray=explode("::",$row['pictures']);
$totalRePics=sizeof($rePicArray)-1;
if($row['price']==0)$row['price']="";
if($row['resize']==0)$row['resize']="";
$row['price']=number_format($row['price']);

if($row['price']=="") $priceValue=""; 
else{
    if($currency_before_price) $priceValue=$defaultCurrency.$row['price'];
    else $priceValue=$row['price']." ".$defaultCurrency;
}

if($totalRePics>=1) $firstPic=$rePicArray[0];
else $firstPic="images/no-image.png";

if($row['listing_type']==2){ $featuredClass= " featuredClass alert-info "; $featuredClassChild=" speciallistingChild "; }
elseif($row['listing_type']==3){$featuredClass= " inavtiveClass alert-danger "; $featuredClassChild=" inactivelistingChild "; }
elseif($row['flag']>0 && isset($_SESSION["memtype"]) && $_SESSION["memtype"]==9){
    $featuredClass= " flagClass alert-warning "; $featuredClassChild=" flaglistingChild ";
}else{ $featuredClass=""; $featuredClassChild=""; }

if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true){
$listingImageClause=" pull-right ";
$listingstatusClause=" style='float:right;' ";
$listingLabelClause=" pull-left ";
}else{
$listingImageClause=" pull-left ";
$listingstatusClause=" style='float:left;' ";
$listingLabelClause=" pull-right ";
}

/* Row starts */


if($totalRePics>1){ if($totalRePics>$reMaxPictures) $totalRePics=$reMaxPictures; } ?>
<div class='listingRow row <?php print $featuredClass; ?>' id='parent-row<?php print $row['id']; ?>'>
<div class='listingSmallImage col-sm-3 col-md-3 col-lg-3 <?php print $listingImageClause; ?>'>
<?php if($firstPic!="images/no-image.png"){
$style_attr=" style='display:block;' ";   
$piccount=0;  
foreach($rePicArray as $pid=>$pval){
if(trim($pval)!=""){  $piccount++;      
?>   
<div class='overlayContainer'> 
<a rel='prettyPhoto[<?php print $row['id']; ?>]' <?php print $style_attr; ?> href='<?php print $pval; ?>' ><img class='img-thumbnail img-responsive' border='0' src='timthumb.php?src=<?php print $pval; ?>&h=140' /><?php if($piccount==1){ ?><div class='imgOverlay1'><i class='icon-large icon-picture'></i> <?php print $totalRePics; ?></div><?php } ?></a>
</div>
<?php
$style_attr=" style='display:none;' ";
}   
}
}else{ ?>
<img border='0' src='timthumb.php?src=<?php print $firstPic; ?>&w=70' />    
<?php } ?>

</div>

<?php 
$listingTitle=trim($row['autoage']." ".$row['category']." ".$row['subcategory']);
if($row['city']!="")$listingAddress=$row['city'];
if($row['state']!="")$listingAddress=$listingAddress.", ".$row['state'];

$headline_slug=friendlyUrl($row['headline']);

if($row['user_id']=="oodle") $region_slug=$row['country']; else $region_slug="";
if($refriendlyurl=="enabled") $relistingLink=friendlyUrl($row['category'],"_")."/".friendlyUrl($row['subcategory'],"_")."/"."id-".$row['id']."-".$region_slug."-".$headline_slug;
else $relistingLink="index.php?ptype=viewFullListing&reid=".$row['id']."&title=$title_slug";
?>
<div class='col-xs-9 col-sm-9 col-md-9 col-lg-9'>
<div class='row'>    
 <div class='col-xs-8 col-sm-8 col-md-8 col-lg-8 listingTitle text-primary'><a href='<?php print $relistingLink; ?>'><?php print $listingTitle; ?></a></div>   
 <div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 listingPrice txt-align-r'><?php print $priceValue; ?></div>
</div>
 <div class='row'>
     <div class='col-sm-5 col-md-5 col-lg-5'>
         <div class='listingAddress'><?php print $listingAddress; ?></div>
         <div><?php print $listingDate; ?></div>
         </div>
     <div class='col-sm-3 col-md-3 col-lg-3'>
         <div class='listingBeds'><?php if($row['mileage']>0) print number_format($row['mileage'])." ".__($redefaultDistance); ?></div>
         <div class='listingBaths'><?php print __($row['fueltype']); ?></div>
     </div>
     <div class='col-sm-2 col-md-2 col-lg-2'>
         <div class='listingType'><?php print __($row['transmission']); ?></div>
         <div class='listingSubtype'><?php print __($row['drive']); ?></div>
     </div>
     <div class='col-sm-2 col-md-2 col-lg-2'>
         <div class='listingClassification txt-align-r'><?php print __($row['bodytype']); ?></div>
         <div class='listingSize txt-align-r'><?php print __($row['excolour']); ?></div>
     </div>
 </div>

 <div class='row' style='margin-top:10px;' >
<?php if($_SESSION["memtype"]==9){ ?>
 <div class='listing_status col-sm-4 col-md-4 col-lg-4' <?php print $listingstatusClause; ?> id='listingstatus<?php print $row['id']; ?>' ><?php print __("Change status");?>: 
         <select name='listingtype' id='listingtype' onchange="infoResults(this.value+'<?php print "::".$row['id']; ?>',14,'listingstatus<?php print $row['id']; ?>');">
<option value='1' <?php if($row['listing_type']=="" || $row['id']==1){ print "selected='selected'"; } ?>><?php print $relanguage_tags["Normal"];?></option>
<!-- <option value='3' <?php if($row['listing_type']==3){ print "selected='selected'"; } ?>>Top</option> -->
<option value='2' <?php if($row['listing_type']==2){ print "selected='selected'"; } ?>><?php print $relanguage_tags["Featured"];?></option>
<option value='3' <?php if($row['listing_type']==3){ print "selected='selected'"; } ?>><?php print __("Inactive");?></option>
</select>
</div>
<?php } ?>

<div class="col-sm-6 col-md-6 col-lg-6 listingAttributes">
<?php
print hasVisited($row['id']);
if($row['listing_type']==2){ print "<span class='featuredlisting label label-primary'>".$relanguage_tags["Featured"]."</span>"; }
if($row['flag']>0 && isset($_SESSION["memtype"]) && $_SESSION["memtype"]==9){ print "<span class='featuredlisting label label-danger'>".__("Flagged")." ".$row['flag']." ".__("times")."</span>"; }
?>
</div>
</div>

<div class='row'>
<div class='col-sm-12 col-md-12 col-lg-12'>
<?php showMemberNavigation($row['user_id'],$mem_id,$row['id'],1); ?>
<a class='moreInfo btn btn-sm btn-success' href='<?php print $relistingLink; ?>'><?php print $relanguage_tags["More Information"];?></a>
</div>
</div>
 </div>
</div> 

<?php 	
$count++;
}
?>
</div>

</td></tr>

<?php
if($delete_after_days>0){
if ($numResults00>$numResults) autoDeleteListings($str_older_dttm);
}
autoUpdateStatus();
//autoDeleteListings($listingdttm,$listingpics);
print "<tr class='headRow1'><td colspan='$otherRowSpan'><div class='pull-left' style='padding-top:10px;'>".$relanguage_tags["Showing"]." <b>$startListingNum2 - $endListingNum</b> ".__("of")." $extraMessage<b>$numResults</b> ".$relanguage_tags["Listings"].".</div>";

if($pageNum==1){
	?>
<div class='pull-right'><?php print $relanguage_tags["Show"];?> <select name='subtype' id='reListingsPerPage2' >
<option value='<?php print "$rePartialQuery:20:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==20)print " selected='selected' "; ?>>20</option>
<option value='<?php print "$rePartialQuery:40:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==40)print " selected='selected' "; ?>>40</option>
<option value='<?php print "$rePartialQuery:60:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==60)print " selected='selected' "; ?>>60</option>
<option value='<?php print "$rePartialQuery:80:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==80)print " selected='selected' "; ?>>80</option>
<option value='<?php print "$rePartialQuery:100:$pageNum:$sortby-@@-$functionType"; ?>' <?php if($listingsPerPage==100)print " selected='selected' "; ?>>100</option>
<?php 
print "</select> ".$relanguage_tags["Listings"]."/".$relanguage_tags["page"]."";
}
print "</div></td></tr>";
if($pageNum==1)$pgClassStart="disabled";
else $pgClassStart="pgNav";
if($pageNum==$totalPages)$pgClassEnd="disabled";
else $pgClassEnd="pgNav";
$nextPage=$pageNum+1;
$prevPage=$pageNum-1;

if($pageNum<5){
	$maxNumOfPagesInNavigation=5;
	$newFirstPage=1;
}else{
	$newFirstPage=$pageNum-2;
	$maxNumOfPagesInNavigation=$pageNum+2;
}

print "<tr><td colspan='7'><div class='pull-right'><ul class='pagination'>"; ?>
<li class='<?php print $pgClassStart; ?>'><a href='javascript: void(0)'><span style="display: none;"><?php print "$rePartialQuery:$listingsPerPage:$prevPage:$sortby-@@-$functionType"; ?></span><?php print $relanguage_tags["Previous"];?></a></li>
<?php 
if($maxNumOfPagesInNavigation>$totalPages) $maxNumOfPagesInNavigation=$totalPages;
for($pg=$newFirstPage;$pg<=$maxNumOfPagesInNavigation;$pg++){
    if($pg!=$pageNum){
     ?>
    <li><a href='javascript: void(0)' class='pgNav'><span style="display: none;"><?php print "$rePartialQuery:$listingsPerPage:$pg:$sortby-@@-$functionType"; ?></span><?php print $pg; ?></a></li>
<?php }else{
     ?>
    <li class='active'><a href='javascript: void(0)'><span style="display: none;"><?php print "$rePartialQuery:$listingsPerPage:$pg:$sortby-@@-$functionType"; ?></span><?php print $pg; ?></a></li>
<?php   
    }

}

?>
<li class='<?php print "$pgClassEnd"; ?>'><a href='javascript: void(0)'><span style="display:none"><?php print "$rePartialQuery:$listingsPerPage:$nextPage:$sortby-@@-$functionType"; ?></span><?php print $relanguage_tags["Next"];?></a></li></ul></div></td></tr>
<?php
print "</tbody></table>";
}else{
	print "<h4 align='center'>".$relanguage_tags["No results found"]."</h4>";
	
}
return ob_get_clean();
}

function __($tag){
    session_start();
    $translation=$tag;
    if(isset($_SESSION["auto_language"][$tag])) $translation=$_SESSION["auto_language"][$tag];
    elseif(isset($_SESSION["auto_language"][strtolower($tag)])) $translation=$_SESSION["auto_language"][strtolower($tag)];
    else $translation=$tag;
    return trim($translation);
}


function autoDeleteListings($str_older_dttm){
	include("config.php");
	$qrexp="select pictures from $reListingTable where 	dttm_modified <= '$str_older_dttm' and listing_type='1'";
	$resultexp=mysqli_query($coni,$qrexp);
	$expcount=0;
		while($allexpPics=mysqli_fetch_assoc($resultexp)){
		$thepics=explode("::",$allexpPics['pictures']);
		$totpics=sizeof($thepics);
		for($i=0;$i<$totpics;$i++) if(trim($thepics[$i])!="") unlink($thepics[$i]);
		$expcount++;
		}
	$delqr="delete from $reListingTable where dttm_modified <= '$str_older_dttm' and listing_type='1' ";
	$resultdel=mysqli_query($coni,$delqr);
	
}

function dateDown($a, $b)
{
	$t1 = strtotime($a['dttm']);
	$t2 = strtotime($b['dttm']);
	return $t1 - $t2;
}

function dateUp($a, $b)
{
	$t1 = strtotime($a['dttm']);
	$t2 = strtotime($b['dttm']);
	return $t2 - $t1;
}

function listingTypeSort($a, $b){
	return $b['listing_type'] - $a['listing_type'];
}

function priceDown($a, $b)
{
	return $a['price'] - $b['price'];
}

function priceUp($a, $b)
{
	return $b['price'] - $a['price'];
}

function distanceDown($a, $b)
{
	return $a['mileage'] - $b['mileage'];
}

function distanceUp($a, $b)
{
	return $b['mileage'] - $a['mileage'];
}

function cityDown($a, $b)
{
	return strcasecmp($a['city'],$b['city']);
}

function cityUp($a, $b)
{
	return strcasecmp($b['city'],$a['city']);
}

function autoUpdateStatus(){
	include("config.php");
	$now_dttm=date("Y-m-d H:i:s");	
	$reqr1="update $reListingTable set listing_type=1, dttm_modified = '$now_dttm' where listing_type='2' and  featured_till<='$now_dttm' and featured_till<>'0000-00-00 00:00:00' ";
	$resultre1=mysqli_query($coni,$reqr1);	
	//print $reqr1;
}

function hasVisited($reid){
	include("config.php");
	if(trim($_SESSION["reid"])=="") if(isset($_COOKIE['reidvisit'])) $_SESSION["reid"] = $_COOKIE['reidvisit'];
	if(trim($_SESSION["marked_reid"])=="") if(isset($_COOKIE['markedreid'])) $_SESSION["marked_reid"] = $_COOKIE['markedreid'];
	
	$allreid=explode(":",$_SESSION["reid"]);
	$allMarkedreid=explode(":",$_SESSION["marked_reid"]);
	$retString="";
	
	if(in_array($reid,$allreid)) $retString="<span class='alreadySeen label label-info' title='".$relanguage_tags["You have already seen this listing"].".'>".$relanguage_tags["Viewed"]."</span>";
	if(in_array($reid,$allMarkedreid)) $retString=$retString."<span class='listingMarked label label-success' title='".$relanguage_tags["This listing has been liked by you"].".'>".$relanguage_tags["Liked"]."</span>";
	return $retString;
}

function reSetSearchSession($reCategory,$reSubcategory,$rePrice,$autoAge,$bodyType,$fuelType,$transmissionType,$listingBy,$reQuery,$reCity){
$_SESSION["reCategory"]=$reCategory;
$_SESSION["reSubcategory"]=$reSubcategory;
$_SESSION["autoAge"]=$autoAge;
$_SESSION["bodyType"]=$bodyType;
$_SESSION["fuelType"]=$fuelType;
$_SESSION["transmissionType"]=$transmissionType;
$_SESSION["listingBy"]=$listingBy;
$_SESSION["rePrice"]=$rePrice;
$_SESSION["reQuery"]=$reQuery;
$_SESSION["reCity"]=$reCity;
}

function showMemberNavigation($current_mem_id,$mem_id,$reid,$rePageType){
include("config.php");
if($current_mem_id!="oodle"){
if($current_mem_id==$mem_id || $_SESSION["memtype"]==9){ print "<a class='moreInfo btn btn-sm btn-info' href='index.php?ptype=editReListingForm&reid=$reid'>".$relanguage_tags["Edit Listing"]."</a>"; ?>
<span onclick="javascript:confirmListingdelete('<?php print $reid; ?>',<?php print $rePageType; ?>);" class='moreInfo btn btn-sm btn-info'><?php print $relanguage_tags["Delete Listing"]; ?></span>
<?php 
}
}
}

function registerUser($q){
    include("config.php");
    //list($reusername,$temp)=split(":",$q);
    if(isset($_SESSION["myusername"])){
        ?>
        Welcome <b><?php print $_SESSION["myusername"]; ?></b>
        <?php
    }else{
        /* onkeyup="if(this.value.match(/[^\w+$ ]/g)) { this.value = this.value.replace(/[^\w+$ ]/g, '');}" */
        $randnum=rand(100,10000);
        ?>
        <h3 align='center'><?php print $relanguage_tags["Please register"];?></h3>
        <form id="registerForm" name="registerForm" class="registerForm"  method="post" action="reRegister.php">
        <table border='0' style="margin:10px auto;">
        <tr><td><b><?php print $relanguage_tags["Username"];?>:</b></td><td><input id="reusername"  name="myusername" size='20'  type="text" maxlength="255" value="<?php print $_SESSION['reg_username']; ?>" onblur="infoResults(this.value,5,'usernameMessage');"  /> 
        <br /><div id='usernameMessage'></div></td></tr>
        <tr><td><b><?php print $relanguage_tags["Email"];?>:</b></td><td><input id="reemail"  name="myemail" size='20' type="text" maxlength="255" value="<?php print $_SESSION['reg_email']; ?>"/> </td></tr>
        <tr><td><b><?php print $relanguage_tags["Password"];?>:</b></td><td><input id="repassword"  name="mypassword" size='20' type='password'  maxlength="255" value=""/> </td></tr>
        <tr><td><b><?php print $relanguage_tags["Confirm"];?>:</b></td><td><input id="recpassword"  name="mycpassword" size='20' type='password'  maxlength="255" value=""/> </td></tr>
        <?php if($enableRegisterCaptcha){ ?>
        <tr><td colspan='2'>
        <div id='captchaImage'>
        <img id="captcha" src="securimage/securimage_show.php?<?php print $randnum; ?>" alt="CAPTCHA Image" />
        </div>
        </td></tr>
        <tr><td><b><?php print __("Enter the words"); ?></b></td><td><input type="text" name="captcha_code" id="captcha_code" size="10" maxlength="6" /></td></tr>
        <?php } ?>
        <tr><td colspan='2' align='right'><input id="registerButton2"  class='btn btn-sm btn-success' type="button" name="register" value="<?php print $relanguage_tags["Register"]; ?>" onclick="return validateRegForm()" /></td></tr>
        <tr><td colspan='2' align='right'></td></tr>
        <tr><td colspan='2' align='right'>
        <span class='small' id='loginLink2'><?php print $relanguage_tags["Already registered"];?>? <a href='javascript: void(0)'><?php print $relanguage_tags["Login here"];?></a></span><br />
        <span id='forgotPasswordLink2' class='small'><a href='javascript: void(0)'><?php print $relanguage_tags["Forgot password"]; ?>?</a></span></td></tr>
        </table>
        </form>
        <?php
    }
    
}

function showLoginForm(){
	include("config.php");
	include("loginForm.php");
}

function checkUsernameExists($q){
if(trim($q)!=""){
include("config.php");	
$qr="select id from $rememberTable where username='$q';";	
$result=mysqli_query($coni,$qr);
if(mysqli_num_rows($result)>0) print "<span class='redMessage'>Username not available. Please choose a different username.</span>";
}
}

/* Saves registration data in database */
function completeRegistration($q){
    include("config.php");
    include_once 'securimage/securimage.php';
    $securimage = new Securimage();
    list($reusername,$reemail,$retextpassword,$captcha_code,$page)=explode(":::",$q,5);
    $repassword=md5($retextpassword);
    $_SESSION['reg_username']=$reusername;
    $_SESSION['reg_email']=$reemail;
    if ($securimage->check($captcha_code) == false && $enableRegisterCaptcha) {
        if($page!="splash"){
            print __("Please enter the word challenge exactly as it appears")." ".$captcha_code." ".__("is incorrect")."."; ?>
            <br /><a href='javascript: void(0)' onclick="infoResults('register',2,'sidebarLogin');"><?php print $relanguage_tags["Please try again"]; ?></a>.
    <?php   }else print "1";
    }else{
    $str_today = date("Y-m-d");
    $ip=$_SERVER["REMOTE_ADDR"];
    $qr="insert into $rememberTable (username,password,email,dttm,ip) values ('$reusername','$repassword','$reemail','$str_today','$ip')";
    if(mysqli_query($coni,$qr)){
        if($page!="splash"){
        print "<h3 align='center'>".$relanguage_tags["Registration successful"]."</h3>";
        ?>
        <h5 align='center'><a href='javascript: void(0)' onclick="infoResults('login',4,'sidebarLogin');"><?php print $relanguage_tags["Login here"]; ?></a>.</h5>
        <?php 
        }else print "2";
        sendPassword($reemail,'register',$retextpassword);
    }else{
    if($page!="splash"){    
     print "<h4 align='center'>".$relanguage_tags["Registration failed."]."</h4>";
     if(mysqli_errno()==1062){
      print "<h5 align='center'>".$relanguage_tags["Account associated with"]." $reemail or $reusername ".$relanguage_tags["already exists"].".";
     ?>
     <br /><a href='javascript: void(0)' onclick="infoResults('register',2,'sidebarLogin');"><?php print $relanguage_tags["Please try again"]; ?></a>.
     <?php 
      print"</h5>";
     }
    }else print "3";
    }
    }
}
function forgotPasswordForm($q){
    include("config.php");
    if(isset($_SESSION["myusername"])){
        ?>
            Welcome <b><?php print $_SESSION["myusername"]; ?></b>
            <?php
        }else{
            ?>
<form id="forgotPasswordForm" name="forgotPasswordForm" >
<table border='0' align='center' width='98%'>
<tr><td align='center'><b><?php print $relanguage_tags["Email"]; ?>:</b><input id="reemail"  name="myemail"  type="text" maxlength="255" value="" /></td></tr>
<tr><td align='center'><input id="forgotPasswordButton"  class='btn btn-sm btn-info' type="button" name="register" value="<?php print $relanguage_tags["Send Password"]; ?>" onclick="return processForgotPassForm();" /></td></tr>
<tr><td align='center'><br />
<span class='small' id='loginLink2'><?php print $relanguage_tags["Already registered"];?>? <a href='javascript: void(0)'><?php print $relanguage_tags["Login here"]; ?></a></span><br />
<span class='small' id='registerLink'><a href='javascript: void(0)' ><?php print $relanguage_tags["Register"]; ?>?</a></span></td></tr>
</table></form>
            <?php }
}

/* Emails the password to the member's email */
function sendPassword($email,$requestType='forgot',$mpassword=''){
include("config.php");
$qr="select * from $rememberTable where email='$email'";
$result=mysqli_query($coni,$qr);
print "<p align='center'>";
if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);    
    $visitor_email=$gmailUsername;
    if($requestType=='forgot'){
    if($email=="test@finethemes.com") exit;
    $mytextpassword=randomString(8);  
    $mypassword=md5($mytextpassword);  
    $qr2="update $rememberTable set password='$mypassword' where email='$email'";
    $result2=mysqli_query($coni,$qr2);
    $msgbody=__("A forgot password request was initiated. Your login info is mentioned below with a new password").": <br /><br />
    ".__("Username").": ".$row['username']."<br />
    ".__("Password").": ".$mytextpassword."<br /><br />
    - <b>$reSiteName</b>";
    $subject=__("Password retrieval");
    print __("New password sent to your registered email").".<br /><span class='small'><a href='index.php'>".__("Login here")."</a></span></p>";
    if($email=="test@finethemes.com") exit;
    }elseif($requestType=='register'){
    $msgbody=__("Thank you for registering. Your login info is mentioned below").": <br /><br />
    ".__("Username").": ".$row['username']."<br />
    ".__("Password").": ".$mpassword."<br /><br />
    - <b>$reSiteName</b>";
    $subject=__("Login Information");   
    }else{
    $msgbody=__("Your login info is mentioned below").": <br /><br />
    ".__("Username").": ".$row['username']."<br />
    ".__("Password").": ".$mpassword."<br /><br />
    - <b>$reSiteName</b>";
    $subject=__("Login Information");      
    }
    
    $to_email=$email;
    $to_name="Member";
    
sendReEmail($visitor_email,$msgbody,$to_email,$to_name,$subject,false); 
}else print "Email not found";

}

/* Generates a random string */
function randomString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}

function showProfileImage($q){
include("config.php");
$mem_id=$_SESSION["re_mem_id"];
if($q!="no"){
$qr="select * from $rememberTable where id='$mem_id'";
$result=mysqli_query($coni,$qr);
$row=mysqli_fetch_assoc($result);
if($result) if(trim($row['photo'])!="") print "<img src='uploads/".$row['photo']."' width='200' />";
}else{
print "";
}
}

function markReListing($reid){
	include("config.php");
	$_SESSION["marked_reid"]=$reid.":".$_SESSION["marked_reid"];
	$reCookieTime = 60 * 60 * 24 * 12 + time();
	setcookie('markedreid', $_SESSION["marked_reid"], $reCookieTime);
	print '<span class="btn btn-success">'.$relanguage_tags["Listing marked"]."</span>";
}

function getFavRecord($favid){
	include("config.php");
	if(trim($favid)!=""){
		$qr="select * from $reListingTable where id='$favid' "; 
		$result=mysqli_query($coni,$qr);
		if(mysqli_num_rows($result)) return mysqli_fetch_assoc($result);
		else{
			require_once('geoplugin.class.php');
			$geoplugin = new geoPlugin();
			$geoplugin->locate();
			$vCountry=$geoplugin->countryName;
			$oodlecRegion=getOodleRegion($vCountry);
			if(function_exists("getOodleArray"))
			$oodleArr=convertArrayToClFormat(getOodleArray("","",$favid,"",$oodlecRegion));
			return $oodleArr[0];
		}
	}
}

function deleteReListing($reid){
  if(isset($_SESSION["myusername"])){
	include("config.php");
	if($_SESSION["memtype"]==9){
        $qr0="select pictures from $reListingTable where id='$reid' ";
        $deleteClause="";
    }else{
        $qr0="select pictures from $reListingTable where id='$reid' and user_id='".$_SESSION["re_mem_id"]."'";
        $mem_id=$_SESSION["re_mem_id"];
        $deleteClause=" and user_id='$mem_id' ";
    }
	$result0=mysqli_query($coni,$qr0);
	$row0=mysqli_fetch_assoc($result0);
	$allPictures=explode("::",$row0['pictures']);
	$totalPics=sizeof($allPictures);
	
	$qr="delete from $reListingTable where id='$reid' $deleteClause";
	$result=mysqli_query($coni,$qr);
	if($result){
		for($i=0;$i<$totalPics;$i++){
		if(trim($allPictures[$i])!="")
		list($temppart,$actualImgName)=explode("uploads/",$allPictures[$i]);
		unlink("uploads/".$actualImgName);
		//print "deleting: ".$actualImgName;
		}
		exit;
		print "<h5 align='center'>Listing # $reid deleted.</h5>";
	}
	
  }else print "Please sign in"; 
	
}

function deleteRePhoto($qr){
include("config.php");
list($reimgid,$reid)=explode(":::",$qr);
list($temppart,$actualImgName)=explode("uploads/",$reimgid);
if(unlink("uploads/".$actualImgName)) print "<h4 align='center'>".$relanguage_tags["Image Deleted"].".</h4>";
else print "<h4 align='center'>Picture $reimgid couldn't be deleted. Please check if the file exists and permissions of the upload folder</h4>";

$reqr1="select pictures from $reListingTable where id='$reid' ";
$resultre1=mysqli_query($coni,$reqr1);
$row=mysqli_fetch_assoc($resultre1);
$allpictures=$row['pictures'];
if(trim($reimgid)!=""){
	//$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);
	$allpictures=str_replace("$reimgid::", "", $allpictures);
}
$reqr2="update $reListingTable set pictures='$allpictures'  where id='$reid' ";
$resultre2=mysqli_query($coni,$reqr2);
//print "<br /><br />$reimgid"."<br /><br />$reqr2<br />";
}

function changeMemberStatus($q){
include("config.php");
list($memstatus,$rememid)=explode("::",$q);
if($memstatus=="Ban" || $memstatus=="Active"){
$reqr1="update $rememberTable set status='$memstatus' where id='$rememid' ";
$resultre1=mysqli_query($coni,$reqr1);
if($resultre1){
if($memstatus=="Ban")	print "Banned";
if($memstatus=="Active")	print "Activated";
}
}
if($memstatus=="Delete"){	
	$reqr1="delete from $rememberTable where id='$rememid' ";
	$resultre1=mysqli_query($coni,$reqr1);
	if($resultre1){
		print "Deleted";
	}	
}
}

function changeListingStatus($q){
    include("config.php");
    if($isThisDemo=="yes"){ print "Listing status can't be updated in demo"; exit; }
    list($listingstatus,$reid)=explode("::",$q);    
    if($listingstatus==2){
        $dt_now = date("Y-m-d");
        $now_month = date("n");
        $now_day = date("j");
        $now_year = date("Y");
        $now_hour= date("H");
        $now_minute= date("i");
        $now_second= date("s");
        if($featuredduration=="" || $featuredduration==0) $featuredduration=30;
        $minmonth = mktime($now_hour, $now_minute, $now_second, $now_month, $now_day + $featuredduration ,  $now_year );
        $future_dttm = date("Y-m-d H:i:s",$minmonth);
        $reqr1="update $reListingTable set listing_type='$listingstatus', featured_till='$future_dttm' where id='$reid' ";
    }
    else{ $reqr1="update $reListingTable set listing_type='$listingstatus' where id='$reid' "; }
    $resultre1=mysqli_query($coni,$reqr1); 
    if($listingstatus==1) $listingstatusString="normal";
    if($listingstatus==2) $listingstatusString="featured";
    if($listingstatus==3) $listingstatusString="Inactive";
    if($isThisDemo=="yes" && $listingstatus==3){
    print "<br />Listing status can't be changed to 'Inactive' in the demo.";    
    }else { if($resultre1) print "Status changed to $listingstatusString"; }
     
    
}

function safelyExecute($q,$type){

	try{
		
	include("config.php");
	$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
	mysqli_select_db($coni,$database);
    mysqli_query($coni,"SET NAMES utf8");
	$q=mysqli_real_escape_string($coni,$q);
	
	if($type==1) searchResults($q);
	if($type==2) registerUser($q);
	if($type==3) completeRegistration($q);
	if($type==4) showLoginForm();
	if($type==5) checkUsernameExists($q);
	if($type==6) showProfileImage($q);
	if($type==7) searchResults($q,"yes");
	if($type==8) markReListing($q);
	if($type==9) forgotPasswordForm($q);
	if($type==10) sendPassword($q);
	if($type==11) deleteReListing($q);
	if($type==12) deleteRePhoto($q);
	if($type==13) changeMemberStatus($q);
	if($type==14) changeListingStatus($q);
	if($type==15) changeStatus($q);
	if($type==16) addcategory($q);
	if($type==17) subcategorysection($q);
	if($type==18) addsubcategory($q);
	if($type==19) removecategory($q);
	if($type==20) removesubcategory($q);
	if($type==21) showsubcatprice($q);
	if($type==22) addNewTag($q);
	if($type==23) addNewElement($q);
	if($type==24) removeElement($q);
	if($type==25) showMapListing($q);
	if($type==26) searchResults($q,"no","yes");
	if($type==27) setJSvariables($q);
    if($type==28) updateLangTag($q);
    if($type==29) flagListing($q);
    if($type==30) splashSearchAutoComplete($q);
    
	}catch(Exeption $e){ print "Function Type - $type : ".$e; }
	mysqli_close($con);

}

/* Returns matching results for splash page query shich are shown in a dropdown */

function splashSearchAutoComplete($q){
    $term=mysqli_real_escape_string($coni,$_GET['term']);
    $stype=mysqli_real_escape_string($coni,$_GET['stype']);
    $qr="select distinct city from listing where city like '%$term%';";
    $result=mysqli_query($coni,$qr);
    $matchingCities=array();
    while($record=mysqli_fetch_assoc($result)){
        $matchingCities[]=$record['city'];
    }
    print json_encode($matchingCities);
}

/* Flag a listing */
function flagListing($listing_id){
    $ip=$_SERVER["REMOTE_ADDR"];
    
    $qr="select * from flagging where ip='$ip' and listing_id='$listing_id'";
    $result=mysqli_query($coni,$qr); 
    if($result){
        if(mysqli_num_rows($result) <= 0){
            $qr2="insert into flagging (listing_id,ip) values ('$listing_id','$ip')"; 
            $result2=mysqli_query($coni,$qr2);
            $qr3="update listing set flag=flag+1 where id='$listing_id'";
            $result3=mysqli_query($coni,$qr3); 
            if($result2 && $result3){
                print '<span class="btn btn-warning" disabled="disabled">'.__("Listing reported")."</span>";
            }
        }else{
            print '<span class="btn btn-warning" disabled="disabled">'.__("Listing reported")."</span>";
        }
    }
    
}

function updateLangTag($q){
    include("config.php");
    list($keyword,$translation,$defaultLanguage)=explode(":::",$q); $translation=trim($translation);
    $qr00="select * from $languageTable where translation='$translation' and keyword <> '$keyword' and language='$defaultLanguage'"; 
    $result00=mysqli_query($coni,$qr00);
    if(mysqli_num_rows($result00)<1){
     $qr="update $languageTable set translation='$translation' where keyword = '$keyword' and language='$defaultLanguage'";  
     if($isThisDemo!="yes") $result=mysqli_query($coni,$qr); 
     if($result) print "Translation updated"; else print "Translation couldn't be updated.";
    }else{
        $row00=mysqli_fetch_assoc($result00);
        print "<p align='center'>Same translation already exist for the keyword <b>'".$row00['keyword']."'</b>. Please use a unique translation.<p>";
    }
}

function setJSvariables($q){
   $allVariables=explode("::",$q); 
   foreach($allVariables as $varid => $varval){
   list($variableName,$variableValue)=explode(":",$varval);    
   $_SESSION[$variableName]=$variableValue;
   }
   
}

function addNewElement($q){
	list($itemName,$itemTable)=explode(":::",$q);
	addNewFeature($itemName,$itemTable);
}

function removeElement($q){
	list($itemName,$itemTable)=explode(":::",$q);
	removeFeature($itemName,$itemTable);
}

function showMapListing($reid){
	include("config.php"); $ptype="showOnMap";
	list($reid,$region)=explode("::",$reid);
	if($region==="") $viewListingRow=getListingData($reid);
	else $viewListingRow=getListingData($reid,$region);
    $showMoreListings="no";
	include("viewFullListing.php");

}

function addNewTag($q){
	include("config.php");
	list($keyword,$translation,$defaultLanguage)=explode(":::",$q);
	$qr0="select * from $languageTable where keyword='$keyword' and language='$defaultLanguage'";
	$result0=mysqli_query($coni,$qr0);
	$qr2="insert into $languageTable (keyword,translation,language) values ('$keyword','$translation','$defaultLanguage')";
	
	if($isThisDemo=="no"){
	if(@mysqli_num_rows($result0)<1){
	$result2=mysqli_query($coni,$qr2);
	if($result2){
		print "<p align='center'>New keyword and translation ".stripslashes($category)." has been added.</p>";
		unset($_SESSION["auto_language"]);
	}else print "<p align='center'>Keyword and translation ".stripslashes($category)." couldn't be added. Please try again.</p>";
	}else{
		print "<p align='center'>The keyword and translation ".stripslashes($category)." already exists. ".mysqli_error()."</p>";
	}
	}else print "Adding a new keyword and translation has been disabled in the demo.";
	
}

function addNewFeature($newFeature,$itemTable){
	include("config.php");	
	$qr0="select * from $itemTable";
	$result0=mysqli_query($coni,$qr0);
	
	$row0=mysqli_fetch_assoc($result0);
	if($isThisDemo=="no" && trim($newFeature)!="-"){
		if(strpos($row0['all_features'], $newFeature)===false){
			if(trim($row0['all_features'])=="") $row0['all_features']=$newFeature;
			else $row0['all_features']=$row0['all_features'].":::".$newFeature;
			$qr1="update $itemTable set all_features='".$row0['all_features']."'";
			$result1=mysqli_query($coni,$qr1);
			//print $qr1;
			//if(strtolower($redefaultLanguage)=="english") 
			addNewTag("$newFeature:::$newFeature:::$redefaultLanguage");
			if($result1) print "<p align='center'>The new item ".stripslashes($newFeature)." has been added.</p>";
			else print "<p align='center'>The new item ".stripslashes($newFeature)." couldn't be added. ".mysqli_error()."</p>";
		
	}else{
		print "<p align='center'>$newFeature already exists in your list of $itemTable.</p>";
	}
 }else print "<p align='center'>Adding a new item is disabled in the demo.</p>";
 
 $allFeatures=explode(":::",$row0['all_features']);
 $totalFeatures=sizeof($allFeatures);
 
 if($totalFeatures>0){
 ?>
 		<br /><br />
 		<b>Existing <?php print $itemTable; ?></b><br />
 		<div id='categorylist'>
 	<select id='featureselect' name='featureselect' size='<?php print $totalFeatures; ?>' >
 	<?php 
 		for($i=0;$i<$totalFeatures;$i++){
 		print "<option name='feature-$i' value='".htmlspecialchars($allFeatures[$i], ENT_QUOTES)."'>".stripslashes($allFeatures[$i])."</option>";
 		}
    print "</select></div><br /><br />"; ?>
    <input type='button' onclick="infoResults(document.getElementById('featureselect').value+':::'+'<?php print $itemTable; ?>',24,'categorylist');" id='removeFeature' value='Remove Selected Item' /><br /><br />
    <div id='subfeaturesection'></div>
    </div>
    <?php 
 }    
    ?>
<?php     
}

function removeFeature($featureName,$itemTable){
	include("config.php");
	
	if($isThisDemo=="no" && trim($featureName)!=""){
		$qr2="select * from $itemTable";
		$result2=mysqli_query($coni,$qr2);
		$row2=mysqli_fetch_assoc($result2);
		$allFeaturesArray=explode(":::",$row2['all_features']);
		
        $allFeaturSize=sizeof($allFeaturesArray);
		for($i=0;$i<$allFeaturSize;$i++){
			$allFeaturesArray[$i]=mysqli_real_escape_string($coni,$allFeaturesArray[$i]);
			if(trim($allFeaturesArray[$i])==stripslashes($featureName)){
				unset($allFeaturesArray[$i]);
			}
			//print $allFeaturesArray[$i]." ".stripslashes($featureName)."<Br />";
		}
		
		$row2['all_features']=implode(":::",$allFeaturesArray);
		$qr3="update $itemTable set all_features='".$row2['all_features']."'";
		$result3=mysqli_query($coni,$qr3);
		//print $qr3;
		if($result3) print "<p align='center'>The item ".stripslashes($featureName)." has been removed.</p>";
		else print "<p align='center'>The item ".stripslashes($featureName)." couldn't be removed. ".mysqli_error()."</p>";
		
		if($allFeaturSize>0){
			?>
		 		<br /><br />
		 		<b>Existing <?php print $itemTable; ?></b><br />
		 	
		 	<select id='featureselect' name='featureselect' size='<?php print $allFeaturSize; ?>' >
		 	<?php 
		 		for($i=0;$i<$allFeaturSize;$i++){
		 		if(trim($allFeaturesArray[$i])!="")
		 		print "<option name='feature-$i' value='".htmlspecialchars($allFeaturesArray[$i], ENT_QUOTES)."'>".stripslashes($allFeaturesArray[$i])."</option>";
		 		}
		    print "</select></div><br /><br />"; ?>
		   		    <div id='subfeaturesection'></div>
		    
		    <?php 
		 }    
		    
	}else print "<p align='center'>Removing a item is disabled in the demo.</p>";
	
}

function showsubcatprice($q){
print "Price enabled: ".$q;
}

function removecategory($category){
	include("config.php");
	if($isThisDemo=="no"){
	if(trim($category)!=""){
		$qr2="delete from $categoryTable where category='$category'";
		$result2=mysqli_query($coni,$qr2);
		if($result2) print "<p align='center'>Category ".stripslashes($category)." has been deleted.</p>";
		else print "<p align='center'>Category ".stripslashes($category)." couldn't be deleted.</p>";

		$qr3="select * from $categoryTable";
		$result3=mysqli_query($coni,$qr3);
		$totalcats=mysqli_num_rows($result3);
		if($totalcats>0){
			$i=0;
			?>
			<select id='categoryselect' name='categoryselect' size='<?php print $totalcats; ?>' onclick="infoResults(this.value,17,'subcatsection');" >
			<?php 
				while($allcategories=mysqli_fetch_assoc($result3)){
				print "<option name='cat-$i' value='".htmlspecialchars($allcategories['category'], ENT_QUOTES)."'>".$allcategories['category']."</option>";
				$i++;	
				}
		   print "</select>";
		 
			}
			
	}
	}else{
	print "Removing a category has been disabled in the demo.";
	}
}

function removesubcategory($q){
	include("config.php");
	if($isThisDemo=="no"){
	list($subcategory,$category)=explode(":::",$q);
	//print "$subcategory,$category";
	
	if(trim($category)!=""){
		$qr2="select * from $categoryTable where category='$category'";
		$result2=mysqli_query($coni,$qr2);
		$allsubcats=mysqli_fetch_assoc($result2);
		$allsubcatsarray=explode(":::",$allsubcats['subcategories']);
		//$allsubcatsPricearray=explode(":::",$allsubcats['price']);
		$allsubcatsize=sizeof($allsubcatsarray);
		for($i=0;$i<$allsubcatsize;$i++){
			$allsubcatsarray[$i]=mysqli_real_escape_string($coni,$allsubcatsarray[$i]);
			if($allsubcatsarray[$i]==$subcategory){
				unset($allsubcatsarray[$i]);
				//unset($allsubcatsPricearray[$i]);
			}
			//print $allsubcatsarray[$i]." ".$subcategory."<Br />";
		}
		$allsubcats['subcategories']=implode(":::",$allsubcatsarray);
		//$allsubcats['price']=implode(":::",$allsubcatsPricearray);
		
		$qr3="update $categoryTable set subcategories='".$allsubcats['subcategories']."' where category='$category'";
		$result3=mysqli_query($coni,$qr3);
		if($result3) print "<p align='center'>Sub category ".stripslashes($subcategory)." has been deleted.</p>";
		else print "<p align='center'>Sub category ".stripslashes($subcategory)." couldn't be deleted.</p>";	
		//print $qr3;".stripslashes($subcat)."
		
		$qr3="select * from $categoryTable where category='$category'";
		$result3=mysqli_query($coni,$qr3);
		$totalcats=mysqli_num_rows($result3);
		if($totalcats>0){
			$allsubcats=mysqli_fetch_assoc($result3);
			$allsubcategories=explode(":::",$allsubcats['subcategories']);
			$subcatsize=sizeof($allsubcategories);
			if(strlen($allsubcats['subcategories'])>0){
				?>
		 	<select id='subcategoryselect' name='subcategoryselect' size='<?php print $subcatsize; ?>' >
			<?php 
			 for($i=0;$i<$subcatsize;$i++){
			 print "<option name='subcat-$i' value='".htmlspecialchars($allsubcategories[$i], ENT_QUOTES)."'>".$allsubcategories[$i]."</option>";
				}
		   print "</select><br /><br /><br />";
		
		 }
		}
		
}
	}else{
		print "Removing a sub category has been disabled in the demo.";
	}
}

function addcategory($category){
	include("config.php");
	
	list($category,$catprice)=explode(":::",$category);
	if(trim($category)!="" && trim($category)!="0"){
	$reqr1="select * from $categoryTable where category='$category' ";
	$resultre1=mysqli_query($coni,$reqr1);	
	
	if(mysqli_num_rows($resultre1)>0){
		print "<p align='center'>Brand ".stripslashes($category)." already exists.</p>";
	}else{
		if($isThisDemo=="no"){
		$qr2="insert into $categoryTable (category,price) values ('$category','$catprice')";
		$result2=mysqli_query($coni,$qr2);
		addNewTag("$category:::$category:::$redefaultLanguage");
		if($result2) print "<p align='center'>Brand ".stripslashes($category)." has been added.</p>";
		else print "<p align='center'>Brand ".stripslashes($category)." couldn't be added.</p>";
		}else{
			print "Adding a brand is disabled in the demo.";
		}
	}
	}
	$qr3="select * from $categoryTable";
	$result3=mysqli_query($coni,$qr3);
	$totalcats=mysqli_num_rows($result3);
	if($totalcats>0){
		$i=0;
		?>
		<br /><br />
		<b>Existing Brands</b><br />
		<div id='categorylist'>
	<select id='categoryselect' name='categoryselect' size='<?php print $totalcats; ?>' onclick="infoResults(this.value,17,'subcatsection');" >
	<?php 
		while($allcategories=mysqli_fetch_assoc($result3)){
		print "<option name='cat-$i' value='".htmlspecialchars($allcategories['category'], ENT_QUOTES)."'>".$allcategories['category']."</option>";
		$i++;	
		}
   print "</select></div>";
   ?>
  
   <?php
   print "<br /><br /><div id='subcatsection'></div>";
	}
	
}

function subcategorysection($category){
	?>
<input type='button' value='Remove Selected Brand' id='removecat' onclick="if(confirm('Do you really want to delete brand <?php print $category; ?>. All models under this brand would also be deleted.')) infoResults('<?php print $category; ?>',19,'categorylist');"  />
	<br /><br />
	<?php 
print "<br /><b>Add a model for $category</b><br />";
?>
<input type='text' name='subcatname' id='subcatname' size='35' /><br /><br />
<input type='button' id='addsubcat' onclick="infoResults(document.getElementById('subcatname').value+':::'+'<?php print $category; ?>',18,'subcatlist');" value='Add Model' />
<br /><br />
<div id='allsubcats'>
<div id='subcatlist'>
<?php 
include("config.php");
$qr3="select * from $categoryTable where category='$category'";
$result3=mysqli_query($coni,$qr3);
$totalcats=mysqli_num_rows($result3);
$allsubcats=mysqli_fetch_assoc($result3);
?>
Is the price field enabled for brand <b><?php print $category; ?></b>: <?php print $allsubcats['price']; ?><br /><br />
<?php 
if($totalcats>0){
	
	$allsubcategories=explode(":::",$allsubcats['subcategories']);
	$subcatsize=sizeof($allsubcategories);
	if(strlen($allsubcats['subcategories'])>0){
?>
  
   <b>Existing Models</b><br /><br />
	<select id='subcategoryselect' name='subcategoryselect' size='<?php print $subcatsize; ?>'  >
	<?php 
	//$tstring="a\'test";
	//$tstring=htmlspecialchars($tstring, ENT_QUOTES);
	 for($i=0;$i<$subcatsize;$i++){
		print "<option name='subcat-$i' value='".htmlspecialchars($allsubcategories[$i], ENT_QUOTES)."'>".$allsubcategories[$i]."</option>";
			
		}
   print "</select><br /><br />";
   ?>
   </div></div>
   <input type='button' value='Remove Selected Model' id='removecat' onclick="infoResults(document.getElementById('subcategoryselect').value+':::'+'<?php print $category; ?>',20,'subcatlist');" />
    
     <?php 
 }
}
?>

<?php 	
}

function addsubcategory($q){
include("config.php");

list($subcat,$category)=explode(":::",$q);

if(trim($subcat)!=""){
$qr3="select * from $categoryTable where category='$category'";
$result3=mysqli_query($coni,$qr3);
$totalcats=mysqli_num_rows($result3);

if($totalcats>0){
	$allsubcats=mysqli_fetch_assoc($result3);
	$allsubcategories=explode(":::",$allsubcats['subcategories']);
	$subcatsize=sizeof($allsubcategories);
	
	if(strpos($allsubcats['subcategories'], $subcat)===false){
	if(trim($allsubcats['subcategories'])!=""){
		$allsubcats['subcategories']=mysqli_real_escape_string($coni,$allsubcats['subcategories']).":::".$subcat;
		//$allsubcats['price']=mysqli_real_escape_string($coni,$allsubcats['price']).":::".$price;
	}
	else{
		$allsubcats['subcategories']=$subcat;
		//$allsubcats['price']=$price;
	}
	if($isThisDemo=="no"){
	$qr4="update $categoryTable set subcategories='".$allsubcats['subcategories']."' where category='$category'";
	$result4=mysqli_query($coni,$qr4);
	//print $qr4;
	addNewTag("$subcat:::$subcat:::$redefaultLanguage");
	if($result4) print "<p align='center'>Model ".stripslashes($subcat)." has been added to $category.</p>";
	else print "<p align='center'>Model ".stripslashes($subcat)." couldn't be added to $category. ".mysqli_error().".</p>";
	$newSubCat="<option name='subcat-$i' value='".htmlspecialchars($subcat, ENT_QUOTES)."'>".stripslashes($subcat)."</option>";
	$optsize=$subcatsize+1;
	}else{
		print "Adding a model is disabled in the demo.";
		$optsize=$subcatsize;
	}
	}else{
		print "<b>Model $subcat exists.</b><br /><br />";
		$newSubCat="";
		$optsize=$subcatsize;
	}
	
?> <div id='subcatlist'>
	<select id='subcategoryselect' name='subcategoryselect' size='<?php print $optsize; ?>' >
	<?php 
	 for($i=0;$i<$subcatsize;$i++){
		print "<option name='subcat-$i' value='".htmlspecialchars($allsubcategories[$i], ENT_QUOTES)."'>".stripslashes($allsubcategories[$i])."</option>";
	  }
		print $newSubCat;
   print "</select><br /><br />";
   ?>
   </div>
  <!-- <input type='button' value='Remove Selected Sub Category' id='removecat' onclick="infoResults(document.getElementById('subcategoryselect').value+':::'+'<?php print $category; ?>',20,'allsubcats');" />-->
    
   <?php 
	
		
 }
}else{
	print "<b>Please enter sub category name.</b>";
}

}

function getRealValue($value,$type){
    //print "$type=$value<br />";
    include("config.php");
    //print "value= $value,$type - ".$relanguage_tags["Any"]."<Br />";
    
    if($type=="reCategory"){
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        for($j=0;$j<$totSize;$j++){
            if(trim($allValues[$j])!="") $allValues[$j]=__($allValues[$j]);
         }       
        //print "<br />categories ($value)<br />";
        //print_r($allValues);
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==$relanguage_tags["Any"] || $allValues[$i]=="" || $allValues[$i]=="Any"){
                $retString=$retString." and category like '%'";
                break;
            }else{
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                $retString=$retString." $delimClause category='".$allValues[$i]."' ";
            }
            
        }
        if($retString!="" && $retString!=" and category like '%'") $retString=$retString." ) ";
        return $retString;
        
    }
    
    if($type=="reSubcategory"){
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        //print_r($allValues);
        for($j=0;$j<$totSize;$j++){
            if(trim($allValues[$j])!="") $allValues[$j]=__($allValues[$j]);
        }
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==$relanguage_tags["Any"] || $allValues[$i]=="" || $allValues[$i]=="Any"){
                $retString=$retString." and subcategory like '%'";
                break;
            }
            else{
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                $retString=$retString." $delimClause subcategory='".$allValues[$i]."' ";
            }
                
        }
        if($retString!="" && $retString!=" and subcategory like '%'") $retString=$retString." ) ";
        return $retString;
    
    }
    
if($type=="autoAge"){ 
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==$relanguage_tags["Any"] || $allValues[$i]=="" || $allValues[$i]=="Any"){
                $retString=$retString." and autoage like '%' ";
                break;
            }
            else{
                list($fromAge,$toAge)=explode("-",$allValues[$i]);
                $currentYear=date("Y");
                $fromYear=$currentYear-$fromAge; 
                $toYear=$currentYear-$toAge;  
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                
                if($toAge=="Above"){
                    $retString=$retString." $delimClause  ( autoage <= $fromYear or autoage = 0 ) ";
                    //$value=" and ( price >= $fromPrice or price = 0 ) ";
                }else{
                    $retString=$retString." $delimClause  ( autoage <= $fromYear and autoage >= $toYear or autoage = 0 ) ";
                    //$value=" and ( price <= $toPrice and price >= $fromPrice or price = 0 ) ";
                }
            }
    
        }
        if($retString!="" && $retString!=" and autoage like '%' ") $retString=$retString." ) ";
        return $retString;
    
    }
    
    if($type=="bodyType"){
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        //print_r($allValues);
        for($j=0;$j<$totSize;$j++){
            if(trim($allValues[$j])!="") $allValues[$j]=array_search($allValues[$j],$relanguage_tags);
        }
        
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==$relanguage_tags["Any"] || $allValues[$i]=="" || $allValues[$i]=="Any"){
                $retString=$retString." and bodytype like '%'";
                break;
            }
            else{
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                $retString=$retString." $delimClause bodytype='".$allValues[$i]."' ";
            }
    
        }
        if($retString!="" && $retString!=" and bodytype like '%'") $retString=$retString." ) ";
        return $retString;
    
    }
    
    
    if($type=="fuelType"){
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        //print_r($allValues);
        for($j=0;$j<$totSize;$j++){
            if(trim($allValues[$j])!="") $allValues[$j]=array_search($allValues[$j],$relanguage_tags);
        }
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==$relanguage_tags["Any"] || $allValues[$i]=="" || $allValues[$i]=="Any"){
                $retString=$retString." and fueltype like '%'";
                break;
            }
            else{
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                $retString=$retString." $delimClause fueltype='".$allValues[$i]."' ";
            }
    
        }
        if($retString!="" && $retString!=" and fueltype like '%'") $retString=$retString." ) ";
        return $retString;
    
    }
    
    
    if($type=="transmissionType"){
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        //print_r($allValues);
        for($j=0;$j<$totSize;$j++){
            if(trim($allValues[$j])!="") $allValues[$j]=array_search($allValues[$j],$relanguage_tags);
        }
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==$relanguage_tags["Any"] || $allValues[$i]=="" || $allValues[$i]=="Any"){
                $retString=$retString." and transmission like '%'";
                break;
            }
            else{
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                $retString=$retString." $delimClause transmission='".$allValues[$i]."' ";
            }
    
        }
        if($retString!="" && $retString!=" and transmission like '%'") $retString=$retString." ) ";
        return $retString;
    
    }
    
    
    if($type=="listingBy"){
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        //print_r($allValues);
        for($j=0;$j<$totSize;$j++){
            if(trim($allValues[$j])!="") $allValues[$j]=array_search($allValues[$j],$relanguage_tags);
        }
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==$relanguage_tags["Any"] || $allValues[$i]=="" || $allValues[$i]=="Any"){
                $retString=$retString." and relistingby like '%'";
                break;
            }
            else{
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                $retString=$retString." $delimClause relistingby='".$allValues[$i]."' ";
            }
    
        }
        if($retString!="" && $retString!=" and relistingby like '%'") $retString=$retString." ) ";
        return $retString;
    
    }
    
    if($type=="rePrice"){
        $allValues=explode(",",$value);
        $totSize=sizeof($allValues);
        for($i=0;$i<$totSize;$i++){
            if($allValues[$i]==10 || $allValues[$i]==""){
                $retString=$retString." and price like '%' ";
                break;
            }
            else{
                //print "$totSize - $fromPrice,$toPrice<br />";
                list($fromPrice,$toPrice)=explode("-",$allValues[$i]);
                $fromPrice=str_replace("K", "000", $fromPrice);
                $fromPrice=str_replace("M", "000000", $fromPrice);
                $toPrice=str_replace("K", "000", $toPrice);
                $toPrice=str_replace("M", "000000", $toPrice);
                $fromPrice=str_replace("k", "000", $fromPrice);
                $fromPrice=str_replace("m", "000000", $fromPrice);
                $toPrice=str_replace("k", "000", $toPrice);
                $toPrice=str_replace("m", "000000", $toPrice);
                
                if($retString=="") $delimClause=" and ( ";
                else $delimClause=" or ";
                
                if($toPrice=="Above"){
                    $retString=$retString." $delimClause  ( price >= $fromPrice or price = 0 ) ";
                    //$value=" and ( price >= $fromPrice or price = 0 ) ";
                }else{
                    $retString=$retString." $delimClause  ( price <= $toPrice and price >= $fromPrice or price = 0 ) ";
                    //$value=" and ( price <= $toPrice and price >= $fromPrice or price = 0 ) ";
                }
            }
    
        }
        if($retString!="" && $retString!=" and price like '%' ") $retString=$retString." ) ";
        return $retString;
    
    }
    
    if($type=="reQuery"){
    $value=trim($value);
    if($value==""){
        $value="";
    }else{
        $allQueryTags=explode(" ",$value);
        $totsize=sizeof($allQueryTags);
        $vprefix="  and ( ";
        if($totsize<=1){
            $value=" address like '%$value%' OR country like '%$value%' OR state like '%$value%' OR id like '%$value%' OR postal like '%$value%' ";
        }else{
        $value="";
        for($i=0;$i<$totsize;$i++){
        
        if($i<($totsize-1)) $orsuffix=" OR ";
        else $orsuffix=" ";
        $allQueryTags[$i]=trim($allQueryTags[$i]);
        if($allQueryTags[$i]!=""){
        $value=$value." address like '%$allQueryTags[$i]%' OR country like '%$allQueryTags[$i]%' OR state like '%$allQueryTags[$i]%' OR id like '%$allQueryTags[$i]%'  OR postal like '%$allQueryTags[$i]%' ".$orsuffix;
        }
        
        }
        }
        
        $value=$vprefix.$value." ) ";
    }
    
    return $value;          
    }

if($type=="reKeyword"){
    $value=trim($value);
    if($value==""){
        $value="";
    }else{
        $allQueryTags=explode(" ",$value);
        $totsize=sizeof($allQueryTags);
        $vprefix="  and ( ";
        if($totsize<=1){
            $value=" category like '%$value%' OR subcategory like '%$value%' OR
            address like '%$value%' OR country like '%$value%' OR state like '%$value%' OR
            description like '%$value%' OR headline like '%$value%' OR id like '%$value%'  OR postal like '%$value%' ";
        }else{
        $value="";
        for($i=0;$i<$totsize;$i++){
        
        if($i<($totsize-1)) $orsuffix=" OR ";
        else $orsuffix=" ";
        $allQueryTags[$i]=trim($allQueryTags[$i]);
        if($allQueryTags[$i]!=""){
        $value=$value." category like '%$allQueryTags[$i]%' OR subcategory like '%$allQueryTags[$i]%' OR  
        address like '%$allQueryTags[$i]%' OR country like '%$allQueryTags[$i]%' OR state like '%$allQueryTags[$i]%' OR 
        description like '%$allQueryTags[$i]%' OR headline like '%$allQueryTags[$i]%' OR id like '%$allQueryTags[$i]%'  OR postal like '%$allQueryTags[$i]%' ".$orsuffix;
        }
        
        }
        }
        
        $value=$vprefix.$value." ) ";
    }
    
    return $value;          
    }
    
    if($type=="reCity"){
        if($value=="") $value="";
        else $value=" and ( city like '%$value%' )";
        return $value;
    }
    
    if($type=="onlyMemberListings"){
        $mem_id=$_SESSION["re_mem_id"];
        if($value=="no") $value="";
        if($value=="yes") $value=" and user_id='$mem_id' ";
        return $value;
    }
    
}

function changeStatus($q){
include("config.php");
$qr="update $adminOptionTable set uid='$q';";
$result=mysqli_query($coni,$qr);
print "done";
}

function getCommaStringFromArray($theArray){
	$theString="";
	$delim=",";
	foreach($theArray as $thename=>$thevalue){
		if($theString!="")$delim=","; else $delim="";
		$theString=$theString.$delim.$thevalue;
	}	
	return $theString;
}

function getCatsSubcats($q=""){
	include("config.php");
	//print "tq=$q";
	$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
	mysqli_select_db($coni,$database);
	mysqli_query($coni,"SET NAMES utf8");
	$reqr1="select * from $categoryTable";
	$resultre1=mysqli_query($coni,$reqr1);
	$jsArray="";
	print ' var catSubcats=new Array(); ';
	print ' var catSubcatsPrice=new Array(); ';
	while($allCategories=mysqli_fetch_assoc($resultre1)){
		$temSubCats=explode(":::",$allCategories['subcategories']);
        asort($temSubCats);
		$totalSubCats=sizeof($temSubCats);
		for($i=0;$i<$totalSubCats;$i++){
			$temSubCats[$i]=__($temSubCats[$i]);
		} 
		$allCategories['subcategories']=implode(":::",$temSubCats);
		if($jsArray==""){
			print ' catSubcats["'.__($allCategories['category']).'"]="'.$allCategories['subcategories'].'"; ';
		}
		else{
			print ' catSubcats["'.__($allCategories['category']).'"]=catSubcats["'.__($allCategories['category']).'"]+":::"+"'.$allCategories['subcategories'].'"; ';
		}
		
		print ' catSubcatsPrice["'.__($allCategories['category']).'"]="'.$allCategories['price'].'"; ';
	}
	if($showPrice=="true") print " var showPriceField='true'; ";
	
}

function getOodleCurrency($region,$defaultCurrency){
	$currencies=array("canada"=>"$", "united states"=>"$", "usa"=>"$", "ireland"=>"€", "india"=>"Rs ", "united kingdom"=>"£");
	$region=strtolower($region);
	if(array_key_exists($region, $currencies)) return $currencies[$region];
	else $defaultCurrency;
}

function getOodleRegion($region){
	$regions=array("canada"=>"canada", "united states"=>"usa", "ireland"=>"ireland", "india"=>"india", "united kingdom"=>"uk");
	$region=strtolower($region);
	if(array_key_exists($region, $regions)) return $regions[$region];
	else "no";
}

function escapeJavaScriptText($string)
{
	return json_decode(str_replace("\u2029","",str_replace("\u2028", "", json_encode($string))));
}

function utf8_substr($str,$start)
{
	preg_match_all("/./u", $str, $ar);

	if(func_num_args() >= 3) {
		$end = func_get_arg(2);
		return join("",array_slice($ar[0],$start,$end));
	} else {
		return join("",array_slice($ar[0],$start));
	}
}

function getListingData($reid){
	include("config.php");
	$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
	mysqli_select_db($coni,$database);
	mysqli_query($coni,"SET NAMES utf8");
	$reid=mysqli_real_escape_string($coni,$reid);
	//$_SESSION["reid"]=$reid.":".$_SESSION["reid"];
	$allMarkedreid=explode(":",$_SESSION["marked_reid"]);
	
	$reCookieTime = 60 * 60 * 24 * 12 + time();
	list($tempw,$redomain)=explode(".",$_SERVER['HTTP_HOST'],2);
	setcookie('reidvisit', $_SESSION["reid"], $reCookieTime,"/", ".".$redomain, 1, true);
	
	$qr="select * from $reListingTable where id='$reid'";
	$result=mysqli_query($coni,$qr);
	$row=mysqli_fetch_assoc($result);
	return $row;	
}

function getLonglat2($address){
	define("MAPS_HOST", "maps.google.com");
	define("KEY", $googleMapAPIKey);
	$base_url = "http://" . MAPS_HOST . "/maps/geo?output=csv&key=" . KEY;
	$request_url = $base_url . "&q=" . urlencode($address);
	//print $request_url."<br />";
	
	if(ini_get('allow_url_fopen') ) {
	$googleResult=file_get_contents($request_url);
	}else{
	if (!_iscurlinstalled()){ 
		echo "<p align='center'>cURL is NOT installed. Google geocoding won't work. Please ask your hosting provider to enable it.</p>";
	}else{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$googleResult = curl_exec ($ch);
		
	}
	}
	list($responseCode,$temp,$latitude,$longitude)=explode(",",$googleResult);
	return "$latitude::$longitude";
}

function getLongLat($address){
    $address=urlencode($address);
    $request_url = $base_url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";
    
    if(ini_get('allow_url_fopen') ) {
    $googleResult=file_get_contents($request_url);
    }else{
    if (!_iscurlinstalled()){ 
        echo "<p align='center'>cURL is NOT installed. Google geocoding won't work. Please ask your hosting provider to enable it.</p>";
    }else{
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $googleResult = curl_exec ($ch);
   }
    }
    $googlemap=json_decode($googleResult);
    if(!empty($googlemap)){
    foreach($googlemap->results as $res){
        $address = $res->geometry;
        $latlng = $address->location;
        $formattedaddress = $res->formatted_address;
    }
    }
 
    return $latlng->lat."::".$latlng->lng;
    
}

function getMarkersJson1(){
include("config.php"); 
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");   
$qr="select id, latitude as la, longitude as lo from $reListingTable";
$result=mysqli_query($coni,$qr);
$count=0;
   $markers=array();
    while($marker=mysqli_fetch_assoc($result)){
     if($customMarkers) $marker['ca']=strtolower(str_replace(" ", "-", $marker['ca'])); 
     if($marker['lt']==1) unset($marker['lt']);   
     $markers[] = $marker;
     //$count++; if($count>=1000) break;
     }
 return json_encode($markers);   
}

function getMarkersJson2(){
    include("config.php");
    $con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
    mysqli_select_db($coni,$database);
    mysqli_query($coni,"SET NAMES utf8");
    $reCategoryArray=$_GET['category'];
    $reSubcategoriesArray=$_GET['subcategories'];
    $reautoAge=$_GET['autoage'];
    $rebodyType=$_GET['bodytype'];
    $refuelType=$_GET['fueltype'];
    $retransmissionType=$_GET['transmission'];
    $relistingBy=$_GET['listingby'];
    $rePriceArray=$_GET['price'];
    $reQuery=mysqli_real_escape_string($coni,$_GET['requery']);
    $reCity=mysqli_real_escape_string($coni,trim($_GET['city']));
    $favorite=$_GET['favorite'];
    if($customMarkers) $customMarkerClause=", category as ca "; else $customMarkerClause="";
       
    reSetSearchSession($reCategoryArray,$reSubcategoriesArray,$rePriceArray,$reautoAge,$rebodyType,$refuelType,$retransmissionType,$relistingBy,$reQuery,$reCity);
    if($favorite==1){
       $allfavs=rtrim(str_replace(":", ",", $_SESSION["marked_reid"]),',');
       $qr0="select id,latitude as la,longitude as lo, listing_type as lt, price as pr, category, subcategory as su from $reListingTable where id IN ($allfavs);";
     }else{
   $qr0="select id,latitude as la,longitude as lo, listing_type as lt, price as pr, category, subcategory as su from $reListingTable where  listing_type <> 3  ".getRealValue($reCategoryArray,"reCategory").getRealValue($reSubcategoriesArray,"reSubcategory")
    .getRealValue($rePriceArray,"rePrice").getRealValue($reautoAge,"autoAge").getRealValue($rebodyType,"bodyType").getRealValue($refuelType,"fuelType").getRealValue($retransmissionType,"transmissionType")
    .getRealValue($relistingBy,"listingBy").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity").";";
    }
    $result0=mysqli_query($coni,$qr0);
    $totalRows=mysqli_num_rows($result0);
    //print $qr0;
   // return json_encode($qr0);
    $markers=array();  
    while($marker=mysqli_fetch_assoc($result0)){
     if(!isset($allmarkers[$marker['la'].",".$marker['lo']])) $allmarkers[$marker['la'].",".$marker['lo']]=0;    
     else $allmarkers[$marker['la'].",".$marker['lo']]=$allmarkers[$marker['la'].",".$marker['lo']]+1; 
     
     if($allmarkers[$marker['la'].",".$marker['lo']]>0){
       foreach($markers as $key => $tempmarker){ if ( $tempmarker['la'] == $marker['la'] && $tempmarker['lo'] == $marker['lo'] ) unset($markers[$key]); }
     }   
     if($customMarkers) $marker['ca']=strtolower(str_replace(" ", "-", $marker['ca'])); 
     if($marker['lt']==1) unset($marker['lt']);   
     $markers[] = $marker;
     }
 
 $markers=call_plugin("allMarkers",$markers);
 
 return json_encode($markers);
 
}

function getMarkerInfo($latitude,$longitude,$list_id,$region="usa"){
include("config.php");
$row0=array();

if(trim($list_id)=="" || $list_id==0){
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");

$reCategory=$_SESSION["reCategory"];
$reSubcategory=$_SESSION["reSubcategory"];
$autoAge=$_SESSION["autoAge"];
$bodyType=$_SESSION["bodyType"];
$fuelType=$_SESSION["fuelType"];
$transmissionType=$_SESSION["transmissionType"];
$listingBy=$_SESSION["listingBy"];
$rePrice=$_SESSION["rePrice"];
$reQuery=$_SESSION["reQuery"];
$reCity=$_SESSION["reCity"];
$latitude=mysqli_real_escape_string($coni,$latitude);
$longitude=mysqli_real_escape_string($coni,$longitude);

$qr="select * from $reListingTable where listing_type <> 3 and latitude like '$latitude%' and longitude like '$longitude%'".getRealValue($reCategory,"reCategory").getRealValue($reSubcategory,"reSubcategory")
    .getRealValue($rePrice,"rePrice").getRealValue($autoAge,"autoAge").getRealValue($bodyType,"bodyType").getRealValue($fuelType,"fuelType").getRealValue($transmissionType,"transmissionType")
    .getRealValue($listingBy,"listingBy").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity").";";

$result=mysqli_query($coni,$qr);
$markerContent=$listingDelimeter="";
$totalResults=mysqli_num_rows($result);
while($listingTemp=mysqli_fetch_assoc($result)) $listing[]=$listingTemp;
$region=$regionClause1=$regionClause2="";
}else{
$combArray=convertArrayToClFormat(getOodleArray("","",$list_id,"",$region));
$oodleListing=$combArray[0];
$oodleListing['category']=ucfirst($oodleListing['category']);   
$listing[]=$oodleListing;
$regionClause1="::$region";
$regionClause2="&region=$region";
}

if($totalResults>1) $markerContent="<div class='label label-primary' style='font-size: 125%; text-align:center;'>$totalResults ".__("Listings Found Here")."</div><br /><br />";
$count=0;

$listing=call_plugin("markerRecord",$listing);

foreach($listing as $lid=>$row0){
        
if($row0['listing_type']==2){
      $featuredClass=" style='background-color:#F9FDF8;' "; $featuredTag="<span class='featuredlisting label label-primary'>".__("Featured")."</span>"; 
    }else{
        $featuredTag="";
        $featuredClass="";
    }
       
if($totalResults>1){
    $headlineLength=40;
    $descriptionSize=170;
    $thumbnailHeight=60;
    $markerHeightStyle=" style='min-height:140px; ' ";
}else{
    $headlineLength=40;
    $descriptionSize=350;
    $thumbnailHeight=120;
}

$infoTextWidth="70%";
$headlineH=4;
if(isset($_SESSION["winwidth"]) && ($_SESSION["winwidth"]<=1024 && $_SESSION["winwidth"]>=500)){
     $headlineLength=20; 
     $descriptionSize=60; 
     $infoTextWidth="70%"; 
     $thumbnailHeight=60;
     $headlineH=4;
     $attributClause="<br /><font style='font-size:85%;'><b>".__($row0['category'])." - ".__($row0['subcategory'])."</b> (#".$row0['id']."), $priceString<b>".__("Phone").":</b> ".$row0['contact_phone'].", <b>".__("Address").":</b> ".$row0['address'].", <b>".__("City").":</b> ".$row0['city'];
}

/*
    $markerContent=$markerContent.$listingDelimeter."<div class='markerInfo' $featuredClass $markerHeightStyle>$classClause<h4 style='display:inline;color:#000;'>".preg_replace( '/\s+/', ' ', addslashes($row0['headline']))."</h4><br /><font style='font-size:85%;'><b>".__($row0['category'])." - ".__($row0['subcategory'])."</b> (#".$row0['id']."), $priceString<b>".__("Phone").":</b> ".$row0['contact_phone'].", <b>".__("Address").":</b> ".$row0['address'].", <b>".__("City").":</b> ".$row0['city']."</font><br /><div class='mapInfoText' style='float:left; width:70%; padding:10px 10px 0 0;'>$smallDescription $featuredTag<br />$newTabButton $listingLink</div>";
$markerContent=$markerContent."<div class='mapInfoPic'>$map_image</div></div>";
*/

$smallDescription=nl2br(utf8_substr(preg_replace( '/\s+/', ' ', escapeJavaScriptText($row0['description'])),0,$descriptionSize))."....";

if(isset($_SESSION["winwidth"]) && $_SESSION["winwidth"]<500){
     $headlineLength=20; 
     $thumbnailHeight=40;
     $headlineH=5;
     }

if(isset($_SESSION["winwidth"]) && ($_SESSION["winwidth"]<400 && $_SESSION["winwidth"]>=200)){
     $markerPopStyle="min-height:120px; min-width:250px;"; 
     }

$smallHeadline=nl2br(utf8_substr(preg_replace( '/\s+/', ' ', escapeJavaScriptText($row0['headline'])),0,$headlineLength))."..";
$smallHeadline="<h$headlineH style='display:inline; color:#000;'>$smallHeadline</h$headlineH>";

$row0['address']=addslashes(escapeJavaScriptText($row0['address']));
$rePicArray=explode("::",$row0['pictures']);
if(trim($rePicArray[0])=="") $rePicArray[0]="images/no-image.png";

$oodleregion=$region_slug=$oodleurlregion="";

if($_SESSION["autoadmin_settings"]["refriendlyurl"]=="enabled"){
$headline_slug=friendlyUrl($row0['headline']);    
$newTabLink=friendlyUrl($row0['category'],"_")."/".friendlyUrl($row0['subcategory'],"_")."/"."id-".$row0['id']."-".$region."-".$headline_slug;
}else  $newTabLink="index.php?ptype=viewFullListing&reid=".$row0['id'].$regionClause2;

$row0['price']=number_format($row0['price']);

if($row0['price']!="" && $row0['price']!=0){
if($currency_before_price) $priceString="<b>".__("Price").":</b> ".$_SESSION["autoadmin_settings"]["defaultcurrency"].$row0['price'].", ";
else $priceString="<b>".__("Price").":</b> ".$row0['price']." ".$_SESSION["autoadmin_settings"]["defaultcurrency"].", ";    
} 

    $newTabButton="<a class='btn btn-sm btn-info pull-right' style='margin-top:5px;' target='_blank' href='$newTabLink'>".__("Direct Link")."</a>";
    
    $listingLink="<a class='btn btn-sm btn-primary pull-right' style='margin-top:5px; margin-right:5px;' href='#' id='theListingLink'><span id='".$row0['id'].$oodleregion."'>".__("More Info")."</span></a>";
    
    if($count>0) $listingDelimeter="<hr />";
    
    $style_attr=" style='display:block;' "; 
$map_image="";    
foreach($rePicArray as $pid=>$pval){
if(trim($pval)!=""){        
$map_image=$map_image."<a rel='prettyPhoto[".$row0['id']."]' $style_attr href='$pval' ><img border='0' height='$thumbnailHeight' src='timthumb.php?h=$thumbnailHeight&src=$pval' /></a>";
$style_attr=" style='display:none;' ";
}   
}

if(isset($_SESSION["winwidth"]) && $_SESSION["winwidth"]<500){
    $newTabButton="<div><a class='btn btn-sm btn-info' style='margin-top:5px;' target='_blank' href='$newTabLink'>".__("Direct Link")."</a></div>";
    $row0['price']=number_format($row0['price']);
    $listingLink="<div><a class='btn btn-sm btn-primary' style='margin-top:5px; margin-right:5px;' href='#' id='theListingLink'><span id='".$row0['id'].$oodleregion."'>".__("More Info")."</span></a></div>";

    $markerContent=$markerContent.$listingDelimeter."<div class='markerInfo' $featuredClass $markerHeightStyle>$classClause<br />".$smallHeadline."<br /><div style='margin-bottom:5px;'>$map_image</div> $featuredTag $newTabButton $listingLink</div>";
}else{
    $markerContent=$markerContent.$listingDelimeter."<div class='markerInfo' $featuredClass $markerHeightStyle>$classClause".$smallHeadline."$attributClause</font><br /><div class='mapInfoText' style='float:left; width:$infoTextWidth; padding:10px 10px 0 0;'>$smallDescription $featuredTag<br />$newTabButton $listingLink</div>";
$markerContent=$markerContent."<div class='mapInfoPic'>$map_image</div></div>";
}

$count++;    
}
//return $markerContent;
if($totalResults>1) $markerContent="<div style='height:200px;'>".$markerContent."</div>";
return json_encode($markerContent); 
  
}

function getTextDataJson($nelatitude,$nelongitude,$swlatitude,$swlongitude,$pageNum){
 include_once("plugin_handler.inc.php"); 
 print call_plugin("sidebarTextResults",getTextDataJson2($nelatitude,$nelongitude,$swlatitude,$swlongitude,$pageNum));   
}

function getTextDataJson2($nelatitude,$nelongitude,$swlatitude,$swlongitude,$pageNum){
include("config.php");
ob_start(); 
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");   

$alltextListings=array();
$boundListings=array();
$allmarkers=array();

if($listingsPerPage=="")$listingsPerPage=10;
if($pageNum=="" || $pageNum==0)$pageNum=1;

$startListingNum=($pageNum-1)*$listingsPerPage;
$endListingNum=$startListingNum+$listingsPerPage;
$startListingNum2=$startListingNum+1;

    $reCategoryArray=$_GET['category'];
    $reSubcategoriesArray=$_GET['subcategories'];
    $reautoAge=$_GET['autoage'];
    $rebodyType=$_GET['bodytype'];
    $refuelType=$_GET['fueltype'];
    $retransmissionType=$_GET['transmission'];
    $relistingBy=$_GET['listingby'];
    $rePrice=$_GET['price'];
    $reQuery=mysqli_real_escape_string($coni,$_GET['requery']);
    $reCity=mysqli_real_escape_string($coni,trim($_GET['city']));
    $favorite=$_GET['favorite'];

 if($favorite==1){
       $allfavs=rtrim(str_replace(":", ",", $_SESSION["marked_reid"]),',');
       $qr="select id, latitude as la, longitude as lo, category, subcategory, headline, pictures, price from $reListingTable where id IN ($allfavs);";
     }else{
$qr="select id, latitude as la, longitude as lo, category, subcategory, headline, pictures, price from $reListingTable where listing_type <> 3  ".getRealValue($reCategoryArray,"reCategory").getRealValue($reSubcategoriesArray,"reSubcategory")
    .getRealValue($rePrice,"rePrice").getRealValue($reautoAge,"autoAge").getRealValue($rebodyType,"bodyType").getRealValue($refuelType,"fuelType").getRealValue($retransmissionType,"transmissionType")
    .getRealValue($relistingBy,"listingBy").getRealValue($reQuery,"reQuery").getRealValue($reCity,"reCity").";";
     }
$result=mysqli_query($coni,$qr);
//print "$qr<br />swlatitude=$swlatitude,<br />swlongitude=$swlongitude,<br />nelatitude=$nelatitude,<br />nelongitude=$nelongitude<br /><br />";
while($tlisting = mysqli_fetch_assoc($result)){
 if(coordinate_in_bounds($swlatitude, $swlongitude, $nelatitude, $nelongitude, $tlisting['la'], $tlisting['lo'])){
  $boundListings[]=$tlisting;
 }
//print "<br />coordinates: $swlatitude, $swlongitude, $nelatitude, $nelongitude, <br /><br />".$tlisting['la'].", ".$tlisting['lo'];
}

$numResults=sizeof($boundListings);
$totalPages=ceil($numResults/$listingsPerPage);
if($pageNum>$totalPages)$pageNum=$totalPages;

$allTextListings="";
$thumbnailWidth=80;
$count=0;

if($endListingNum>$numResults)$endListingNum=$numResults;

//print "$startListingNum, $endListingNum, $numResults<br />";
if($numResults>0){
for($c=$startListingNum;$c<$endListingNum;$c++){
 if($count>=$listingsPerPage) break;
 $tlisting=$boundListings[$c];   
 $count++;
 
 $rePicArray=explode("::",$tlisting['pictures'],3); 
if(isset($rePicArray) && $rePicArray[0]!=""){
$picClause="<div class='textimage'><img src='timthumb.php?w=$thumbnailWidth&src=".$rePicArray[0]."' /></div>";
//$picClause="<div class='textimage'><img width='$thumbnailWidth' src='".$rePicArray[0]."' /></div>";
}else $picClause="<div class='textimage'><img width='$thumbnailWidth' src='images/no-image.png' /></div>";
if($tlisting['price']>0){
    if($currency_before_price) $priceClause="<br /><span class='textcontent_price'>".__("Price").": $defaultCurrency ".$tlisting['price']."</span>"; 
    else $priceClause="<br /><span class='textcontent_price'>".__("Price").": ".$tlisting['price']." $defaultCurrency</span>";
} else $priceClause="";

$allTextListings="<div class='textrecord' id='textrecord-".$tlisting['id']."'>$picClause<div class='textcontent'><span class='textcontent_headline'>".substr($tlisting['headline'], 0, 21)."..</span><br /><span class='textcontent_type'>".__($tlisting['category'])." - ".__($tlisting['subcategory'])."</span>$priceClause</div><span class='textlatlong' style='display:none;'>".$tlisting['la'].",".$tlisting['lo']."</span></div>".$allTextListings;

}
}

if($pageNum==1)$pgClassStart="disabled";
else $pgClassStart="pgNav";
if($pageNum==$totalPages)$pgClassEnd="disabled";
else $pgClassEnd="pgNav";
$nextPage=$pageNum+1;
$prevPage=$pageNum-1;

if($pageNum<5){
    $maxNumOfPagesInNavigation=5;
    $newFirstPage=1;
}else{
    $newFirstPage=$pageNum-2;
    $maxNumOfPagesInNavigation=$pageNum+2;
}

print $allTextListings;


if(strlen(trim($allTextListings)) > 0){
print "<table id='textResultsTable'><tr><td colspan='5'><div><ul class='pagination'>"; ?>
<li class='<?php print $pgClassStart; ?>'><a href='javascript: void(0)'  id='testResultLink-<?php print $prevPage; ?>'><?php print __("Previous");?></a></li>
<?php 
if($maxNumOfPagesInNavigation>$totalPages) $maxNumOfPagesInNavigation=$totalPages;
for($pg=$newFirstPage;$pg<=$maxNumOfPagesInNavigation;$pg++){
    if($pg!=$pageNum){
     ?>
    <li><a href='javascript: void(0)' class='pgNav' id='testResultLink-<?php print $pg; ?>'><?php print $pg; ?></a></li>
<?php }else{
     ?>
    <li class='active'><a href='javascript: void(0)' id='testResultLink-<?php print $pg; ?>'><?php print $pg; ?></a></li>
<?php } 
}
?>
<li class='<?php print "$pgClassEnd"; ?>'><a href='javascript: void(0)' id='testResultLink-<?php print $nextPage; ?>'><?php print __("Next");?></a></li></ul></div></td></tr>
<?php
print "</table>";
}else{
    print "<p style='margin-top:10px;text-align:center;'>".__("No results found").".</p>";
} 

return ob_get_clean();
}

function coordinate_in_bounds($sw_lat, $sw_lng, $ne_lat, $ne_lng, $lat, $lng) {
    $inLng = false;
    $inLat = false;
    if($sw_lat > $ne_lat) $inLat = $lat > $ne_lat && $lat < $sw_lat;
    else $inLat = $lat < $ne_lat && $lat > $sw_lat;
    
    $inLng = $lng < $ne_lng && $lng > $sw_lng;
    return $inLat && $inLng;
    }

function _iscurlinstalled() {
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else{
		return false;
	}
}

function getListingImageUploadForm($reid,$divid,$reimgid=""){
include("config.php");
$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);

?>
<div id='reimg<?php print $divid; ?>'>
<?php if(trim($reimgid)!=""){ list($temppart,$actualImgName)=explode("uploads/",$reimgid); ?>
<?php if($isThisDemo=="yes"){ ?>
<p align='center'><a class='deletepiclink' ><?php print $relanguage_tags["Delete Picture"]; ?></a></p><br />
<?php }else{ ?>
<p align='center'><a href='javascript: void(0)' onclick="infoResults('<?php print $reimgid.":::".$reid; ?>',12,'reimg<?php print $divid; ?>')" /><?php print $relanguage_tags["Delete Picture"]; ?></a></p><br />
<?php } ?>
 

<?php 
print "<img src='timthumb.php?w=250&src=$reimgid' width='250' border='0' />";
 } 
 
 ?>
</div>
<form action="ajaxupload.php" method="post" name="unobtrusive" id="unobtrusive" enctype="multipart/form-data">
<input type="hidden" name="maxSize" value="1024000" />
<input type="hidden" name="maxW" value="1200" />
<input type="hidden" name="fullPath" value="<?php print $full_url_path."uploads/"; ?>" />
<input type="hidden" name="relPath" value="uploads/" />
<input type="hidden" name="colorR" value="255" />
<input type="hidden" name="colorG" value="255" />
<input type="hidden" name="colorB" value="255" />
<input type="hidden" name="maxH" value="1000" />
<input type="hidden" name="filename" value="filename" />
<p><input type="file" name="filename" id="filename-<?php print $divid; ?>" class="refileup" value="filename" onchange="ajaxUpload(this.form,'ajaxupload.php?filename=filename&amp;maxSize=1024000&amp;maxW=1200&amp;fullPath=<?php print $full_url_path."uploads/"; ?>&amp;relPath=uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=1000&amp;reid=<?php print $reid; ?>&amp;reimgid=<?php print $reimgid; ?>&amp;repicid=<?php print $divid; ?>','reimg<?php print $divid; ?>','<?php print $relanguage_tags["File Uploading Please Wait"]; ?>...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; <?php print $relanguage_tags["Error in upload"];?>.'); return false;" /></p>
<noscript><p><input type="submit" class='rebutton' name="submit" value="Upload Image" /></p></noscript>
</form>
<?php 	
//print $relanguage_tags["File Uploading Please Wait"]." - ".$relanguage_tags["File Uploading Please Wait"];
}


/* Sends email using phpmailer */
function sendReEmail($visitor_email,$msgbody,$to_email,$to_name,$subject,$show_response=true,$debug=''){
    include("config.php");
    if(is_ip_private($_SERVER['REMOTE_ADDR']) == false){
    if($gmailUsername!="" && $gmailPassword!=""){
    require_once("phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->IsSMTP(); // send via SMTP
    $mail->SMTPAuth   = $SMTPAuth;                  // enable SMTP authentication
    $mail->CharSet = 'UTF-8';
    if($emaildebug=="yes") $mail->SMTPDebug = 1;
    if($resmtp=="smtp.gmail.com") $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
    if($resmtpport==465) $mail->SMTPSecure = "ssl";
    $mail->Host       = $resmtp;      // sets GMAIL as the SMTP server
    $mail->Port       = $resmtpport;
    $mail->Username = $gmailUsername; // SMTP username
    $mail->Password = $gmailPassword; // SMTP password
    $mail->From = $gmailUsername;
    $mail->FromName = $reSiteName;
    $mail->AddAddress($to_email,$to_name);
    $mail->AddReplyTo($visitor_email,$reSiteName);
    $mail->WordWrap = 50; // set word wrap
    $mail->IsHTML(true); // send as HTML
    $mail->Subject = $subject;
    $mail->Body = $msgbody;
    
    if(!$mail->Send())
    {
    if($show_response) echo "<h3 align='center'>".$relanguage_tags["Message can not be sent"].": " . $mail->ErrorInfo."<br /><a href='javascript:history.go(-1);'>".$relanguage_tags["Go back"]."</a></h3>";
        //sendReEmail2($visitor_email,$msgbody,$to_email,$to_name,$subject);
    }
    else
    {
    if($show_response) echo "<h3 align='center'>".$relanguage_tags["Message has been sent"].". <a href='javascript:history.go(-1);'><b>".$relanguage_tags["Go back"]."</b></a></h3>";
    }
    }
 }else{
    if($show_response) print "<h3 align='center'>".__("Email can't be sent through localhost.")."</h3>";
 }  
}

/* Checks if it is a private IP. It is useful as email phpmailer function hangs on localhost */
function is_ip_private ($ip) {
    $pri_addrs = array (
                      '10.0.0.0|10.255.255.255', // single class A network
                      '172.16.0.0|172.31.255.255', // 16 contiguous class B network
                      '192.168.0.0|192.168.255.255', // 256 contiguous class C network
                      '169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
                      '127.0.0.0|127.255.255.255' // localhost
                     );

    $long_ip = ip2long ($ip);
    if ($long_ip != -1) {
        foreach ($pri_addrs AS $pri_addr) {
            list ($start, $end) = explode('|', $pri_addr);
             if ($long_ip >= ip2long ($start) && $long_ip <= ip2long ($end)) return true;
        }
    }

    return false;
}

function sendReEmail2($visitor_email,$msgbody,$to_email,$to_name,$subject,$show_response=true,$debug=""){
	include("config.php");

	require("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
	$mail->IsSendmail(); // telling the class to use SendMail transport

	try {
		$mail->AddReplyTo($visitor_email, $reSiteName);
		$mail->AddAddress($to_email,$to_name);
		$mail->SetFrom($gmailUsername, $reSiteName);
		$mail->AddReplyTo($visitor_email, $reSiteName);
		$mail->Subject = $subject;
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		$mail->Body = $msgbody;
		 
		if(!$mail->Send())
		{
			if($show_response) echo "<h3 align='center'>".$relanguage_tags["Message can not be sent"].": " . $mail->ErrorInfo."<br /><a href='javascript:history.go(-1);'>".$relanguage_tags["Go back"]."</a></h3>";
		}
		else
		{
			if($show_response) echo "<h3 align='center'>".$relanguage_tags["Message has been sent"].". <a href='javascript:history.go(-1);'><b>".$relanguage_tags["Go back"]."</b></a></h3>";
		}
		 
	} catch (phpmailerException $e) {
		echo "phpmailerException: ".$e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		echo "Exception: ".$e->getMessage(); //Boring error messages from anything else!
	}


}

function breakBigString($bigString,$maxStringLen){
	$descriptionArray=explode(" ",$bigString);
	$descriptionArraySize=sizeof($descriptionArray);
	$totalDescriptionLength=0;
	//print "array: $descriptionArraySize";
	if($descriptionArraySize>1){
	for($j=0;$j<$descriptionArraySize;$j++){
		$descParts=round(strlen($descriptionArray[$j])/$maxStringLen);
		if(strlen($descriptionArray[$j])>$maxStringLen){
			for($i=1;$i<=$descParts;$i++){
				$splitAt=$i * $maxStringLen;
				$descriptionArray[$j]=substr_replace($descriptionArray[$j], " ", $splitAt, 0);
			}
			//print "<br />long pc $j, $descParts: ".$descriptionArray[$j];
		}
	}
	$bigString=implode(" ",$descriptionArray);
	}else{
		//print "0 array - opt 2<br />";
		if(strlen($bigString)>$maxStringLen){
			$descParts=round(strlen($bigString)/$maxStringLen);
			//print "desc parts: ".$descParts;
			for($i=1;$i<=$descParts;$i++){
					$splitAt=$i * $maxStringLen;
					//print "<br />split at: ".$splitAt;
					$bigString=substr_replace($bigString, " ", $splitAt, 1);
				}
				//print "<br />long pc $j, $descParts: ".$descriptionArray[$j];
			
		}
	}
	
	return $bigString;
}

function uploadImage($mem_id){
    include("config.php");
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
	$full_url_path=dirname(__FILE__)."/";
	$path = $full_url_path."uploads/";
    if($isThisDemo=="yes"){
    print "<h3 align='center'>Adding / Editing an image has been disabled in the demo due to misuse.</h3>"; 
    exit;
    }
	$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$name = $_FILES['photoimg']['name'];
		$size = $_FILES['photoimg']['size'];
		list($old_img_name,$old_ext)=explode("\.",$name);
		if(strlen($name))
		{
			list($txt, $ext) = explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024)) // Image size max 1 MB
				{
					$actual_image_name = $old_img_name.time().$mem_id.".".$ext;
					$tmp = $_FILES['photoimg']['tmp_name'];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
					{
						//mysqli_query($coni,"update $rememberTable set photo='$actual_image_name' WHERE id='$mem_id'");
						return $actual_image_name;
						//echo "<img src='uploads/".$actual_image_name."' class='preview'>";
					}
					else
					echo "<p align='center'>Failed uploading image.</p>";
				}
				else
				echo "<p align='center'>Image file size max 1 MB</p>";
			}
			else
			echo "<p align='center'>Invalid file format..</p>";
		}
		else
		echo "<p align='center'>Please select image..!</p>";
		exit;

	}

}

function featuredButton($current_mem_id,$mem_id,$reid){
	include("config.php");
	//print "$current_mem_id, $mem_id".$_SESSION["memtype"];
	if($current_mem_id==$mem_id || $_SESSION["memtype"]==9){
		$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);
	?>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="<?php print $ppemail; ?>">
	<input type="hidden" name="item_name" value="Featured Listing">
	<input type="hidden" name="item_number" value="<?php print $reid; ?>">
	<input type="hidden" name="amount" value="<?php print $featuredprice; ?>">
	<input type="hidden" name="currency_code" value="<?php print $ppcurrency; ?>">
	<input type="hidden" name="button_subtype" value="products">
	<input type="hidden" name="cn" value="Add special instructions to the seller">
	<input type="hidden" name="no_shipping" value="2">
	<input type="hidden" name="rm" value="1">
	<input type="hidden" name="return" value="<?php print $full_url_path; ?>">
	<input type="hidden" name="cancel_return" value="<?php print $full_url_path; ?>">
	<input type="hidden" name="bn" value="PP-BuyNowBF">
	<input  type="submit" class='btn btn-sm btn-primary' value='<?php print $relanguage_tags["Buy Featured"]; ?>' name="submit">
	
	<?php 
	}
}
function friendlyUrl($str = '',$replace='-') {

    $friendlyURL = htmlentities($str, ENT_COMPAT, "UTF-8", false); 
    $friendlyURL = preg_replace('/&([a-z]{1,2})(?:acute|lig|grave|ring|tilde|uml|cedil|caron);/i','\1',$friendlyURL);
    $friendlyURL = html_entity_decode($friendlyURL,ENT_COMPAT, "UTF-8"); 
    $friendlyURL = preg_replace('/[^a-z0-9-]+/i', $replace, $friendlyURL);
    $friendlyURL = preg_replace('/-+/', $replace, $friendlyURL);
    $friendlyURL = trim($friendlyURL, $replace);
    $friendlyURL = strtolower($friendlyURL);
    return $friendlyURL;

}

function remove_magic($array, $depth = 5)
{
	if($depth <= 0 || count($array) == 0)
	return $array;

	foreach($array as $key => $value)
	{
		if(is_array($value))
		$array[stripslashes($key)] = remove_magic($value, $depth - 1);
		else
		$array[stripslashes($key)] = stripslashes($value);
	}

	return $array;
}

function pingSitemap(){
	$full_url_path = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"]);
	$sitemap = $full_url_path."sitemap.php";

	$pingurls = array(
			"http://www.google.com/webmasters/tools/ping?sitemap=",
			"http://submissions.ask.com/ping?sitemap=",
			"http://webmaster.live.com/ping.aspx?siteMap="
	);
	if (_iscurlinstalled()){
		foreach ($pingurls as $pingurl) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $pingurl.$sitemap);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
			
		}
	}
}

function loadPage($filename){
    global $fullRelisting, $ptype, $memtype, $mem_id;
    include("config.php");
    ?>
    <div class='row'>
    <div class='col-sm-4 col-md-4 col-lg-4'>
    <div id="sidebar">
     <div id='sidebarLogin'>
     <span class='a_block'>
      <?php include("loginForm.php"); ?>
    <!-- <div class='ssocial'><a href='rss.php'><img border='0' src='images/rss.png' /></a></div> -->
     </span>
    </div>
    </div> <!-- end #sidebar -->
    </div>    <!-- end span4 -->
    <div class='col-sm-8 col-md-8 col-lg-8'>  
     <div id="mainContent">
      <?php include($filename); ?>
     </div> <!-- end #mainContent -->
    </div> <!-- end span8 -->
    </div> <!-- end row -->
            <br class="clearfloat" />
    <?php 
}


function getLanguageName($langCode){
	$language="English";

	switch ($langCode){
		case "ar":
			$language="﻿Arabic";
			break;

		case "bg":
			$language="Bulgarian";
			break;

		case "ca":
			$language="Catalan";
			break;

		case "zh":
			$language="Chinese Simplified";
			break;

		case "cs":
			$language="Czech";
			break;

		case "da":
			$language="Danish";
			break;

		case "nl":
			$language="Dutch";
			break;

		case "en":
			$language="English";
			break;

		case "et":
			$language="Estonian";
			break;

		case "fi":
			$language="Finnish";
			break;

		case "fr":
			$language="French";
			break;

		case "de":
			$language="German";
			break;

		case "el":
			$language="Greek";
			break;

		case "ht":
			$language="Haitian Creole";
			break;

		case "he":
			$language="Hebrew";
			break;

		case "hi":
			$language="Hindi";
			break;

		case "hu":
			$language="Hungarian";
			break;

		case "id":
			$language="Indonesian";
			break;

		case "it":
			$language="Italian";
			break;

		case "ja":
			$language="Japanese";
			break;

		case "ko":
			$language="Korean";
			break;

		case "lv":
			$language="Latvian";
			break;

		case "lt":
			$language="Lithuanian";
			break;

		case "no":
			$language="Norwegian";
			break;

		case "pl":
			$language="Polish";
			break;

		case "pt":
			$language="Portuguese";
			break;

		case "ro":
			$language="Romanian";
			break;

		case "ru":
			$language="Russian";
			break;

		case "sk":
			$language="Slovak";
			break;

		case "sl":
			$language="Slovenian";
			break;

		case "es":
			$language="Spanish";
			break;

		case "sv":
			$language="Swedish";
			break;

		case "th":
			$language="Thai";
			break;

		case "tr":
			$language="Turkish";
			break;

		case "uk":
			$language="Ukrainian";
			break;

		case "vi":
			$language="Vietnamese";
			break;
	}
	return $language;

}

function isThisMobile(){
    $mobile_browser = '0';

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');

    if (in_array($mobile_ua,$mobile_agents)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['ALL_HTTP']),'operamini')>0) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
        $mobile_browser = 0;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iemobile')>0) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),' ppc;')>0) {
        $mobile_browser++;
    }

    if ($mobile_browser > 0) {
        return true;
    }
    else {
        return false;
    }

}


?>