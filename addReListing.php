<div id='memberArea'>
<?php 
if(!isset($_SESSION["myusername"])) exit;
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
if(function_exists('set_magic_quotes_runtime')) @set_magic_quotes_runtime(0);
if((function_exists('get_magic_quotes_gpc') && @get_magic_quotes_gpc() == 1) || @ini_get('magic_quotes_sybase')) $_POST = remove_magic($_POST);

$reCategory=mysqli_real_escape_string($coni,$_POST['category']);
$reSubcategory=mysqli_real_escape_string($coni,$_POST['subcategory']);
$relistingby=mysqli_real_escape_string($coni,$_POST['relistingby']);
//$byother=mysqli_real_escape_string($coni,$_POST['byother']);
$remileage=mysqli_real_escape_string($coni,$_POST['remileage']);
$autoage=mysqli_real_escape_string($coni,$_POST['autoage']);
$bodytype=mysqli_real_escape_string($coni,$_POST['bodytype']);
$fueltype=mysqli_real_escape_string($coni,$_POST['fueltype']);
$transmission=mysqli_real_escape_string($coni,$_POST['transmission']);
$excolour=mysqli_real_escape_string($coni,$_POST['excolour']);
$incolour=mysqli_real_escape_string($coni,$_POST['incolour']);
$drive=mysqli_real_escape_string($coni,$_POST['drive']);
$totalfeatures=mysqli_real_escape_string($coni,$_POST['totalfeatures']);

for($i=0;$i<$totalfeatures;$i++){
$a_feature=mysqli_real_escape_string($coni,$_POST['feature-'.$i]);
if($a_feature!=""){	
if($i==0) $all_features=$a_feature;
else $all_features=$all_features.":::".$a_feature;
}
}

$reprice=mysqli_real_escape_string($coni,$_POST['reprice']);
$readdress=trim(mysqli_real_escape_string($coni,strip_tags($_POST['readdress'])));
$recity=trim(mysqli_real_escape_string($coni,strip_tags($_POST['recity'])));
$restate=trim(mysqli_real_escape_string($coni,strip_tags($_POST['restate'])));
$repostal=trim(mysqli_real_escape_string($coni,strip_tags($_POST['repostal'])));
$recountry=trim(mysqli_real_escape_string($coni,strip_tags($_POST['recountry'])));
$reheadline=mysqli_real_escape_string($coni,strip_tags($_POST['reheadline']));
$redescription=mysqli_real_escape_string($coni,strip_tags($_POST['redescription']));
$rename=mysqli_real_escape_string($coni,strip_tags($_POST['rename']));
$rephone=mysqli_real_escape_string($coni,strip_tags($_POST['rephone']));
$reemail=mysqli_real_escape_string($coni,strip_tags($_POST['reemail']));
$rewebsite=mysqli_real_escape_string($coni,strip_tags($_POST['rewebsite']));
$remyaddress=mysqli_real_escape_string($coni,strip_tags($_POST['remyaddress']));
$reprofileimage=mysqli_real_escape_string($coni,$_POST['reprofileimage']);
$errorMessage="<font size='3'><b>".$relanguage_tags["Please specify"].":</b></font>";
$today_date_time = date("Y-m-d H:i:s");
$listing_expire=mysqli_real_escape_string($coni,$_POST['listingexpire']);
$prevErrorLen=strlen($errorMessage);
$latitude=mysqli_real_escape_string($coni,$_POST['latitude']);
$longitude=mysqli_real_escape_string($coni,$_POST['longitude']);
if($rewebsite=="http://" || $rewebsite=="https://") $rewebsite="";

$reCategory=__($reCategory); 
$reSubcategory=__($reSubcategory);
$bodytype=array_search(strtolower($bodytype),array_map('strtolower',$relanguage_tags));
$fueltype=array_search(strtolower($fueltype),array_map('strtolower',$relanguage_tags));
$transmission=array_search(strtolower($transmission),array_map('strtolower',$relanguage_tags));
$drive=array_search(strtolower($drive),array_map('strtolower',$relanguage_tags));

if(strlen($reCategory)<=0 || $reCategory=="Select") $errorMessage=$errorMessage."<br />".$relanguage_tags["Category"];
if(strlen($reSubcategory)<=0) $errorMessage=$errorMessage."<br />".$relanguage_tags["Sub Category"];
if(strlen($recity)<=0) $errorMessage=$errorMessage."<br />".$relanguage_tags["City"];
if($headlinelength > 0 && strlen($reheadline)<=$headlinelength) $errorMessage=$errorMessage."<br />".$relanguage_tags["Headline"]." (".$relanguage_tags["at least"]." $headlinelength ".$relanguage_tags["characters"].")";
if($descriptionlength > 0 && strlen($redescription)<=$descriptionlength) $errorMessage=$errorMessage."<br />".$relanguage_tags["Description"]." (".$relanguage_tags["at least"]." $descriptionlength ".$relanguage_tags["characters"].")";
if(strlen($rename)<=0) $errorMessage=$errorMessage."<br />Your name".$relanguage_tags["Your name"];
if(strlen($reemail)<=0) $errorMessage=$errorMessage."<br />Your email".$relanguage_tags["Your email"];

if(strlen($errorMessage)>$prevErrorLen){
print $errorMessage;
}else{
	$fullAddress=$readdress.", ".$recity.", ".$restate.", ".$repostal.",".$recountry;
	$fullAddress2=$recity.", ".$restate.", ".$repostal.",".$recountry;
	$fullAddress3=$restate.", ".$repostal.",".$recountry;
	$fullAddress4=$repostal.",".$recountry;
	if(trim($latitude)=="" || trim($longitude)==""){
	list($latitude,$longitude)=explode("::",getLonglat($fullAddress));
	if($latitude==0 || $longitude==0) list($latitude,$longitude)=explode("::",getLonglat($fullAddress2));
	if($latitude==0 || $longitude==0) list($latitude,$longitude)=explode("::",getLonglat($fullAddress3));
	if($latitude==0 || $longitude==0) list($latitude,$longitude)=explode("::",getLonglat($fullAddress4));
	}
	$reheadline=substr($reheadline,0,150);
	$reheadline=breakBigString($reheadline,60);
	if(strtolower($redefaultLanguage)!="japanese" && strtolower($redefaultLanguage)!="chinese simplified") $redescription=breakBigString($redescription,60);
	if($listingreview=="yes" && $memtype!=9) $listing_type=3; else $listing_type=1;
   
$qr="insert into $reListingTable(user_id,subcategory,listing_by_other,autoage,bodytype,fueltype,transmission,mileage,excolour,incolour,drive,all_features,price,city,state,country,description,contact_name,contact_phone,
contact_email,contact_website,contact_address,show_image,ip,dttm,dttm_modified,address,postal,category,
headline,relistingby,latitude,longitude,listing_expire,listing_type) 
values('$mem_id','$reSubcategory','$byother','$autoage','$bodytype','$fueltype','$transmission','$remileage','$excolour','$incolour','$drive','$all_features','$reprice','$recity','$restate','$recountry','$redescription','$rename','$rephone',
'$reemail','$rewebsite','$remyaddress','$reprofileimage','$ip','$today_date_time','$today_date_time','$readdress','$repostal','$reCategory',
'$reheadline','$relistingby','$latitude','$longitude','$listing_expire','$listing_type')";
//print $qr."<br />";
mysqli_query($coni,"SET NAMES utf8");
if($isThisDemo!="yes"){ 
    
$result=mysqli_query($coni,$qr);
if(!$result) "<h4 align='center'>".$relanguage_tags["Listing could not be added"]." ".$relanguage_tags["Please try again"].".</h4>";
else{
if($listing_type==1) print "<h3 align='center'>".$relanguage_tags["Listing added"].".</h3>";
else print "<h3 align='center'>".__("Listing will be first reviewed by the admin before it goes live").".</h3>";
$reid=mysqli_insert_id();
if($notifyadmin=="yes"){
    $full_site_url = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("#/[^/]*\.php$#simU", "/", $_SERVER["PHP_SELF"])."?ptype=viewFullListing&reid=".$reid;
    $msgbody="A new listing has been posted on ".$full_site_url." by $reemail<br /><br />".$relanguage_tags["Listing id"].": $reid<br /><br />- $reSiteName";
    sendReEmail($reemail,$msgbody,$contactformemail,"Admin","Listing posted: ".$reheadline,false);
}
//pingSitemap();
}
}else{
    print "<h3 align='center'>Adding a listing has been disabled in the demo.</h3>";
    
}
?>
<div class='listingButtons2'><?php 
if(trim($ppemail)!="" && $featuredduration>0 && $featuredprice>0 && $row['listing_type']!=2){
	featuredButton($mem_id,$mem_id,$reid); 
?>
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<?php } ?>
</div>
<h4 align='center'><?php print $relanguage_tags["Add images for your listing"]." (".$relanguage_tags["max"]." ".$reMaxPictures. ", <u>".$relanguage_tags["one at a time"]."</u>)</h4>"; ?>
<div class='table-responsive'>
<table align='center' class='table' id='listingImageTable'><tr>
<?php 
$rowcount=0;
for($i=0;$i<$reMaxPictures;$i++){

print "<td>";
getListingImageUploadForm($reid,$i);
print "</td>";
$rowcount++;
if($rowcount==2){
	print "</tr><tr>";
	$rowcount=0;
}
}
?>
</tr></table></div>
<p align='center'>

<input type="button" class='rebutton' VALUE="<?php print __("Go To My Listings"); ?>" ONCLICK="window.location.href='index.php?ptype=viewMemberListing'">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" class='rebutton' VALUE="<?php print __("Add Another Listing"); ?>" ONCLICK="window.location.href='index.php?ptype=submitReListing'">

</p>
<?php } ?>
</div>
<?php 



?>