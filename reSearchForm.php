<?php 
include_once 'functions.inc.php';
$reCategory=htmlspecialchars($_POST['category'], ENT_QUOTES, 'UTF-8');
$reSubcategory=htmlspecialchars($_POST['subcategories'], ENT_QUOTES, 'UTF-8');
$rePrice=htmlspecialchars($_POST['price'], ENT_QUOTES, 'UTF-8');
$autoAge=htmlspecialchars($_POST['autoage'], ENT_QUOTES, 'UTF-8');
$bodyType=htmlspecialchars($_POST['bodytype'], ENT_QUOTES, 'UTF-8');
$fuelType=htmlspecialchars($_POST['fueltype'], ENT_QUOTES, 'UTF-8');
$transmissionType=htmlspecialchars($_POST['transmission'], ENT_QUOTES, 'UTF-8');
$listingBy=htmlspecialchars($_POST['listingby'], ENT_QUOTES, 'UTF-8');
$reQuery=htmlspecialchars(trim($_POST['requery']), ENT_QUOTES, 'UTF-8');
$reCity=htmlspecialchars(trim($_POST['city']), ENT_QUOTES, 'UTF-8'); 

if($reCategory=="") $reCategory=explode(",",$_SESSION["reCategory"]);
if($reSubcategory=="") $reSubcategory=explode(",",$_SESSION["reSubcategory"]);
if($rePrice=="") $rePrice=explode(",",$_SESSION["rePrice"]);
if($autoAge=="") $autoAge=explode(",",$_SESSION["autoAge"]);
if($bodyType=="") $bodyType=explode(",",$_SESSION["bodyType"]);
if($fuelType=="") $fuelType=explode(",",$_SESSION["fuelType"]);
if($transmissionType=="") $transmissionType=explode(",",$_SESSION["transmissionType"]);
if($listingBy=="") $listingBy=explode(",",$_SESSION["listingBy"]);
if($reQuery=="") $reQuery=$_SESSION["reQuery"];
if($reCity=="") $reCity=$_SESSION["reCity"];

$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$reqr1="select * from $categoryTable order by category asc";
$resultre1=mysqli_query($coni,$reqr1);	

?>
<form id='reForm' method='post' name='form2' action='index.php' enctype="multipart/form-data" >
<table><tr>
<td>
<select name='category[]' multiple id='reCategory' >
<option value='<?php print $relanguage_tags["Any"]; ?>' <?php if(in_array($relanguage_tags["Any"],$reCategory) || $reCategory[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any"]; ?></option>
<?php 
while($allCategories=mysqli_fetch_assoc($resultre1)){ ?>
<option value='<?php print __($allCategories['category']);?>' <?php if(in_array(__($allCategories['category']),$reCategory)) print "selected='selected'"; ?> ><?php print __($allCategories['category']); ?></option>
<?php } ?>
</select>
</td></tr>
<tr><td  style="vertical-align: top" >
<div id='subcategoriesSection'>
<?php
if(($ptype=="showOnMap" || $ptype=="viewFullListing" || $ptype=="home" || $ptype=="" || $fullScreenEnabled=="true") && isset($_SESSION["reSubcategory"])){ 
	$reCategoryString=getCommaStringFromArray($reCategory);
	$reqr2="select * from $categoryTable where id like '%' ".getRealValue($reCategoryString,"reCategory");
	$resultre2=mysqli_query($coni,$reqr2);
	?><br>
	<select name='subcategories[]' multiple id='subCategories' >
	<option value='<?php print $relanguage_tags["Any"]; ?>' <?php if(in_array($relanguage_tags["Any"],$reSubcategory) || $reSubcategory[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any"]; ?></option>
	<?php 
    $subCatList=array();
    while($allSubCategories=mysqli_fetch_assoc($resultre2)){ 
    $subCatListPart=explode(":::",$allSubCategories['subcategories']);
    $subCatList=array_merge($subCatList,$subCatListPart);
    //print_r($subCatList);
    }
    sort($subCatList);
    $subCatSize=sizeof($subCatList);
    for($i=0;$i<$subCatSize;$i++){
        ?>
    <option value='<?php print __($subCatList[$i]);?>' <?php if(in_array(__($subCatList[$i]),$reSubcategory)) print "selected='selected'"; ?> ><?php print __($subCatList[$i]); ?></option>
    <?php }
     ?>
    </select>
<?php 	
}
?>
</div>
</td></tr>

<tr><td>
<div id='rePriceRange'>
<select name="price[]" multiple id="rePrice">
<option value="10"  <?php if(in_array(10,$rePrice) || $rePrice[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any Range"];?></option>
<?php for($i=0;$i<$rentRangeSize;$i++){
list($opriceFrom,$opriceTo)=explode("-",$rentPriceRange[$i]);  
if($opriceTo=="Above") $opricerange=$opriceFrom."-".__("Above");   
else $opricerange=$rentPriceRange[$i];

list($priceFrom,$priceTo)=explode("-",$rentPriceRange[$i]);

if(trim($priceFrom)!="" && $priceTo!=""){
    if($priceTo!="Above"){
      if($currency_before_price) $priceTo=$defaultCurrency.$priceTo;
      else $priceTo=$priceTo." ".$defaultCurrency;
     }    
    if($priceTo=="Above") $priceToTrans=__($priceTo); else $priceToTrans=$priceTo;
    if($currency_before_price) $priceFrom=$defaultCurrency.$priceFrom;
    else $priceFrom=$priceFrom." ".$defaultCurrency; 
    
?>
<option class='rent_options' value="<?php print str_replace("Above", __("Above"), $rentPriceRange[$i]); ?>" <?php if($rePrice[0]!="" && in_array($opricerange,$rePrice)) print "selected='selected'"; ?> ><?php print $priceFrom." - ".$priceToTrans; ?></option>
<?php  } } ?>

</select> 
</div>
</td></tr>

<tr><td  ><br>
<select name="autoage[]" multiple id="autoAge">
<option value='<?php print $relanguage_tags["Any"];?>'  <?php if(in_array($relanguage_tags["Any"],$autoAge) || $autoAge[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any"];?></option>
<option value="0-1"  <?php if(in_array("0-1",$autoAge))  print "selected='selected'"; ?> ><?php print $relanguage_tags["Less than"]." 1 ".$relanguage_tags["year old"]; ?></option>
<option value="1-3"  <?php if(in_array("1-3",$autoAge))  print "selected='selected'"; ?> >1 - 3 <?php print $relanguage_tags["year old"]; ?></option>
<option value="3-5"  <?php if(in_array("3-5",$autoAge))  print "selected='selected'"; ?> >3 - 5  <?php print $relanguage_tags["year old"]; ?></option>
<option value="5-7"  <?php if(in_array("5-7",$autoAge))  print "selected='selected'"; ?> >5 - 7  <?php print $relanguage_tags["year old"]; ?></option>
<option value="7-9"  <?php if(in_array("7-9",$autoAge))  print "selected='selected'"; ?> >7 - 9  <?php print $relanguage_tags["year old"]; ?></option>
<option value="9-Above"  <?php if(in_array("9-Above",$autoAge))  print "selected='selected'"; ?> >9 <?php print $relanguage_tags["or above year old"]; ?></option>
</select>
</td></tr>

<?php 
$iqr2="select * from $bodytypeTable";
$iresult2=mysqli_query($coni,$iqr2);
$irow2=mysqli_fetch_assoc($iresult2);
$allFeaturesArray=explode(":::",$irow2['all_features']);
$featureSize=sizeof($allFeaturesArray);
?>
<tr><td  ><br>
<select name="bodytype[]" multiple id="bodyType">
<option value='<?php print $relanguage_tags["Any"];?>'  <?php if(in_array($relanguage_tags["Any"],$bodyType) || $bodyType[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any"];?></option>
<?php for($i=0;$i<$featureSize;$i++){ ?>
<option value="<?php print $relanguage_tags[$allFeaturesArray[$i]]; ?>"  <?php if(in_array($relanguage_tags[$allFeaturesArray[$i]],$bodyType)) print "selected='selected'"; ?> ><?php print $relanguage_tags[$allFeaturesArray[$i]]; ?></option>
<?php } ?>
</select>
</td></tr>

<?php 
$iqr3="select * from $fueltypeTable";
$iresult3=mysqli_query($coni,$iqr3);
$irow3=mysqli_fetch_assoc($iresult3);
$allFeaturesArray=explode(":::",$irow3['all_features']);
$featureSize=sizeof($allFeaturesArray);
?>

<tr><td  ><br>
<select name="fueltype[]" multiple id="fuelType">
<option value="<?php print $relanguage_tags["Any"];?>"  <?php if(in_array($relanguage_tags["Any"],$fuelType) || $fuelType[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any"];?></option>
<?php for($i=0;$i<$featureSize;$i++){ ?>
<option value="<?php print $relanguage_tags[$allFeaturesArray[$i]]; ?>"   <?php if(in_array($relanguage_tags[$allFeaturesArray[$i]],$fuelType)) print "selected='selected'"; ?> ><?php print $relanguage_tags[$allFeaturesArray[$i]]; ?></option>
<?php } ?>
</select>
</td></tr>

<tr><td  ><br>
<select name="transmission[]" multiple id="transmissionType">
<option value='<?php print $relanguage_tags["Any"];?>'  <?php if(in_array($relanguage_tags["Any"],$transmissionType) || $transmissionType[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any"];?></option>
<option value="<?php print $relanguage_tags["Automatic"];?>"  <?php if(in_array($relanguage_tags["Automatic"],$transmissionType)) print "selected='selected'"; ?> ><?php print $relanguage_tags["Automatic"];?></option>
<option value="<?php print $relanguage_tags["Manual"];?>"  <?php if(in_array($relanguage_tags["Manual"],$transmissionType)) print "selected='selected'"; ?> ><?php print $relanguage_tags["Manual"];?></option>
</select>
</td></tr>

<tr><td  ><br>
<select name="listingby[]" multiple id="listingBy">
<option value='<?php print $relanguage_tags["Any"];?>'  <?php if(in_array($relanguage_tags["Any"],$listingBy) || $transmissionType[0]=="") print "selected='selected'"; ?> ><?php print $relanguage_tags["Any"];?></option>
<option value="<?php print $relanguage_tags["Individual"];?>"  <?php if(in_array($relanguage_tags["Individual"],$listingBy)) print "selected='selected'"; ?> ><?php print $relanguage_tags["Individual"];?></option>
<option value="<?php print $relanguage_tags["Agent"];?>"  <?php if(in_array($relanguage_tags["Agent"],$listingBy)) print "selected='selected'"; ?> ><?php print $relanguage_tags["Agent"];?></option>
</select>
</td></tr>

<tr><td><br><div class="form-group">
<input size='32' style='width:225px;' type='text' class="form-control"  name='requery' value='<?php print htmlspecialchars($reQuery, ENT_QUOTES, 'UTF-8'); ?>' id='reQuery' placeholder='<?php print $relanguage_tags["Keyword"];?>/<?php print $relanguage_tags["Street"];?>/<?php print $relanguage_tags["ID"];?>/<?php print $relanguage_tags["Postal"];?>'>
</div>
</td></tr>

<tr><td  ><div class="form-group">
<input size='32' style='width:225px;' type='text' class="form-control ui-autocomplete-input" name='city' value='<?php print htmlspecialchars($reCity, ENT_QUOTES, 'UTF-8'); ?>' id='reCity' placeholder='<?php print $relanguage_tags["City"];?>'>
<input type='hidden' name='ptype' id='sfpType' value='showOnMap'>
</div>
</td></tr>


<tr><td   style="vertical-align: top; text-align:center;" ><br>
<?php if($fullScreenEnabled!="true"){ ?>
<button type='button' class='rebutton btn btn-sm btn-primary' id='reSearch' ><i class="icon-search"></i> <?php print $relanguage_tags["Search"];?></button>&nbsp;&nbsp;&nbsp;&nbsp;
<?php  } ?>
<?php if(($ptype=="showOnMap" && $_GET['fullscreen']=="true") || $fullScreenEnabled=="true"){ ?>
<button type='button'  class='rebutton  btn btn-sm btn-primary'  id='reSearchMap2'><i class="icon-map-marker"></i> <?php print $relanguage_tags["Show on map"]; ?></button>
<?php }else{ ?>
<button type='submit'  class='rebutton  btn btn-sm btn-primary'  id='reSearchMap2'><i class="icon-map-marker"></i> <?php print $relanguage_tags["Show on map"]; ?></button>
<?php } ?>
</td></tr>

</table>
</form>