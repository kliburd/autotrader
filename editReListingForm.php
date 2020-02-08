<?php 
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$reid=mysqli_real_escape_string($coni,$_GET['reid']);

if($_SESSION["memtype"]==9) $qr1="select * from $reListingTable where id='$reid' ";
else  $qr1="select * from $reListingTable where id='$reid' and user_id='$mem_id'";
$result1=mysqli_query($coni,$qr1);
$fullRelisting=mysqli_fetch_assoc($result1);

$reqr1="select * from $categoryTable where category='".$fullRelisting['category']."'";
$resultre1=mysqli_query($coni,$reqr1);
?>
<div id='perimeter'>
<fieldset id='submitListingPage'>
<legend>
<b><?php print $relanguage_tags["Edit Listing"];?></b>
</legend>
<form action='index.php' method='post' name='editReListingForm' enctype="multipart/form-data"  class='form-horizontal'>
<input type='hidden' id='isSubmitListingForm' name='isSubmitListingForm' value='1' />

<div class="form-group">
 <label class="col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Brand"];?>:</b></label>
 <div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name='category' id='reCategory2' class="form-control">
<option value='Select' ><?php print $relanguage_tags["Select"]; ?></option>
<?php 
while($allCategories=mysqli_fetch_assoc($resultre1)){ 
	$allSubCats=$allCategories['subcategories'];
	$showPriceField=$allCategories['price'];
	?>
<option value='<?php print __($fullRelisting['category']);?>' <?php if($fullRelisting['category']==$allCategories['category']) print "selected='selected'"; ?> ><?php print __($fullRelisting['category']); ?></option>
<?php } 
$subcatArray=explode(":::",$allSubCats);
$totalSubCats=sizeof($subcatArray);
?>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div id='subcategoriesSection2'>
<div class="form-group">
 <label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Model"];?>:</b></label>
 <div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name='subcategory' id='subCategories' class="form-control" >
<?php for($i=0;$i<$totalSubCats;$i++){ ?>
<option value='<?php print __($subcatArray[$i]); ?>' <?php  if($subcatArray[$i]==$fullRelisting['subcategory']) print "selected='selected'";  ?>><?php print __($subcatArray[$i]); ?></option>
<?php } ?>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Listing by"];?>:</b></label>
 <div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<label class="radio"><?php print $relanguage_tags["Individual"];?> <input type="radio" id='byIndividual' name="relistingby"  <?php if($fullRelisting['relistingby']=="Individual") print " checked "; ?> value="Individual" /></label>
<label class="radio"><?php print $relanguage_tags["Agent"];?> <input type="radio" id='reagentOther' name="relistingby" <?php if($fullRelisting['relistingby']=="Agent") print " checked "; ?>  value="Agent" /></label>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<?php if($memtype==9){ ?>
<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Listing status"];?>:</b>
<font face='verdana' size='1'>(<?php print $relanguage_tags["this option is visible to admin only"];?>)</font></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<label class="radio"><?php print $relanguage_tags["Normal"];?> <input type="radio" name="listingexpire" id='listingNormal' <?php if($fullRelisting['listing_expire']=="normal") print "checked"; ?> value="normal" /></label>
<label class="radio"><?php print $relanguage_tags["Permanent"];?> <input type="radio" name="listingexpire" id="listingPermanent"<?php if($fullRelisting['listing_expire']=="permanent") print "checked"; ?>  value="permanent" /></label>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
<span id='listingStatus'></span>
</div>
<?php } ?>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags[$redefaultDistance];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='remileage' size='10' value='<?php print $fullRelisting['mileage']; ?>' onkeyup="if(this.value.match(/[^0-9 ]/g)) { this.value = this.value.replace(/[^0-9 ]/g, '');}" />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Make"]." ".$relanguage_tags["Year"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='autoage' size='7' value='<?php print $fullRelisting['autoage']; ?>' onkeyup="if(this.value.match(/[^0-9 ]/g)) { this.value = this.value.replace(/[^0-9 ]/g, '');}" />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<?php 
$iqr2="select * from $bodytypeTable";
$iresult2=mysqli_query($coni,$iqr2);
$irow2=mysqli_fetch_assoc($iresult2);
$allFeaturesArray=explode(":::",$irow2['all_features']);
$featureSize=sizeof($allFeaturesArray);
?>
<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Body Type"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name="bodytype" id="bodyType2" class='form-control' >
<?php for($i=0;$i<$featureSize;$i++){ ?>
<option value="<?php print $relanguage_tags[$allFeaturesArray[$i]]; ?>"  <?php if($allFeaturesArray[$i]==$fullRelisting['bodytype']) print "selected='selected'"; ?> ><?php print $relanguage_tags[$allFeaturesArray[$i]]; ?></option>
<?php } ?>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<?php 
$iqr3="select * from $fueltypeTable";
$iresult3=mysqli_query($coni,$iqr3);
$irow3=mysqli_fetch_assoc($iresult3);
$allFeaturesArray=explode(":::",$irow3['all_features']);
$featureSize=sizeof($allFeaturesArray);
?>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Fuel Type"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name="fueltype" id="fuelType2" class='form-control' >
<?php for($i=0;$i<$featureSize;$i++){ ?>
<option value="<?php print $relanguage_tags[$allFeaturesArray[$i]]; ?>"   <?php if($allFeaturesArray[$i]==$fullRelisting['fueltype']) print "selected='selected'"; ?> ><?php print $relanguage_tags[$allFeaturesArray[$i]]; ?></option>
<?php } ?>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Transmission"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name="transmission" id="transmissionType2" class='form-control' >
<option value="<?php print $relanguage_tags["Automatic"];?>"  <?php if("Automatic"==$fullRelisting['transmission']) print "selected='selected'"; ?> ><?php print $relanguage_tags["Automatic"];?></option>
<option value="<?php print $relanguage_tags["Manual"];?>"  <?php if("Manual"==$fullRelisting['transmission']) print "selected='selected'"; ?> ><?php print $relanguage_tags["Manual"];?></option>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Exterior Colour"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='excolour' size='25' value='<?php print $fullRelisting['excolour']; ?>'  />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Interior Colour"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='incolour' size='25' value='<?php print $fullRelisting['incolour']; ?>'  />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Drive"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name="drive" id="drive">
<option value="<?php print $relanguage_tags["FWD"];?>" <?php if("FWD"==$fullRelisting['drive']) print "selected='selected'"; ?> ><?php print $relanguage_tags["FWD"];?></option>
<option value="<?php print $relanguage_tags["RWD"];?>" <?php if("RWD"==$fullRelisting['drive']) print "selected='selected'"; ?> ><?php print $relanguage_tags["RWD"];?></option>
<option value="<?php print $relanguage_tags["AWD"];?>" <?php if("AWD"==$fullRelisting['drive']) print "selected='selected'"; ?> ><?php print $relanguage_tags["AWD"];?></option>
<option value="<?php print $relanguage_tags["4x4"];?>" <?php if("4x4"==$fullRelisting['drive']) print "selected='selected'"; ?> ><?php print $relanguage_tags["4x4"];?></option>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<div id='priceField' >
<?php if($showPriceField=="true"){ ?>
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Price"];?> (<?php print $defaultCurrency; ?>):</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='reprice' size='7' value='<?php print $fullRelisting['price']; ?>' onkeyup="if(this.value.match(/[^0-9 ]/g)) { this.value = this.value.replace(/[^0-9 ]/g, '');}" />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
<?php  } ?>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Features"];?>:</b></label>
<div class=" col-sm-9 col-md-9 col-lg-9">
<table align='center' width='100%'>
<?php
$fqr2="select * from $featureTable";
$fresult2=mysqli_query($coni,$fqr2);
$frow2=mysqli_fetch_assoc($fresult2);
$allFeaturesArray=explode(":::",$frow2['all_features']);
$allFeatureSize=sizeof($allFeaturesArray);
$selectedFeatures=explode(":::",$fullRelisting['all_features']);
$count=1; 

for($i=0;$i<$allFeatureSize;$i++){
	if(in_array($allFeaturesArray[$i],$selectedFeatures)) $isChecked=" checked='yes' ";
	if($count==1){
	print "<tr><td><input type='checkbox' name='feature-$i' $isChecked value='".$allFeaturesArray[$i]."' />&nbsp;".$relanguage_tags[$allFeaturesArray[$i]]."</td>";
	}if($count==2){
	print "<td><input type='checkbox' name='feature-$i' $isChecked value='".$allFeaturesArray[$i]."' />&nbsp;".$relanguage_tags[$allFeaturesArray[$i]]."</td>";
	}if($count==3){
	print "<td><input type='checkbox' name='feature-$i'$isChecked  value='".$allFeaturesArray[$i]."' />&nbsp;".$relanguage_tags[$allFeaturesArray[$i]]."</td></tr>";
	$count=0;
	}
	$count++;
	$isChecked="";
}
?>
</table>
<input type='hidden' name='totalfeatures' value='<?php print $i; ?>' />
</div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Address"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='readdress' size='75' value="<?php print $fullRelisting['address']; ?>" />
<input type='hidden' name='readdress2' id='readdress2' size='75' value="<?php print $fullRelisting['address']; ?>" />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["City"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='recity' id='recity' value="<?php print $fullRelisting['city']; ?>">
<input type='hidden' name='recity2'  id='recity2' value="<?php print $fullRelisting['city']; ?>">
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["State"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='restate'  id='restate' value="<?php print $fullRelisting['state']; ?>">
<input type='hidden' name='restate2'  id='restate2' value="<?php print $fullRelisting['state']; ?>">
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Country"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='recountry'  id='recountry' value="<?php print $fullRelisting['country']; ?>">
<input type='hidden' name='recountry2'  id='recountry2' value="<?php print $fullRelisting['country']; ?>">
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Postal Code"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='repostal' value='<?php print $fullRelisting['postal']; ?>'>
<input type='hidden' name='repostal2' id='repostal' value='<?php print $fullRelisting['postal']; ?>'>
<!-- <font face='verdana' size='1'>* <b><?php print $relanguage_tags["Please enter correct postal code as it will be used to display a satellite map"];?>.</b></font> -->
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>
 
<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="customLocation"><b><?php print __("Select custom location");?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='checkbox' id='customLocation'  />
<p class="help-block"><font style="font-size:10px;">(<?php print __("You will be able to choose the address by clicking on map");?>)</font></p>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div id='listinglatLong' style="display:none;">
<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="listingLatitude"><b><?php print __("Latitude");?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' readonly name='latitude' value='<?php print $fullRelisting['latitude']; ?>' id='listingLatitude' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="listingLongitude"><b><?php print __("Longitude");?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' readonly name='longitude' value='<?php print $fullRelisting['longitude']; ?>' id='listingLongitude' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>
</div>

<div id='addListingMap' style="width:650px; height:400px; display:none;"></div>
<br /><br />

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Headline"];?>:</b></label>
<div class=" col-sm-9 col-md-9 col-lg-9">
<input type='text' maxlength="150" class='textinput form-control' name='reheadline' id='reheadline' style="width:90%;"  value="<?php print $fullRelisting['headline']; ?>">
</div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Description"];?>:</b></label>
<div class=" col-sm-9 col-md-9 col-lg-9">
<TEXTAREA NAME="redescription" id='redescription' class='form-control'  style="width:90%;" ROWS=25><?php print $fullRelisting['description']; ?></TEXTAREA>
</div>
</div>

<p><b><?php print $relanguage_tags["Contact Information"];?>:</b></p>
<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="rename"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Name"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' name='rename' class='form-control' id='rename' value='<?php print $fullRelisting['contact_name']; ?>' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="rephone"><b><?php print $relanguage_tags["Phone"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' name='rephone' class='form-control' value='<?php print $fullRelisting['contact_phone']; ?>' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="reemail"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Email"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' name='reemail' class='form-control' id='reemail' value='<?php print $fullRelisting['contact_email']; ?>' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group"><?php if($fullRelisting['contact_website']=="")$fullRelisting['contact_website']="http://"; ?>
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="rewebsite"><b><?php print $relanguage_tags["Website"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' name='rewebsite' class='form-control' size='30' value='<?php print $fullRelisting['contact_website']; ?>' />
<input type='hidden' name='ptype' value='myprofile' /><input type='hidden' name='formsubmit' value='1' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="remyaddress"><b><?php print $relanguage_tags["Address"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<textarea name='remyaddress' class="form-control" id='remyaddress' style="width:90%;" cols='25' rows='4'><?php print $fullRelisting['contact_address']; ?></textarea>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Show profile image"];?>?</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<label class="radio"><?php print $relanguage_tags["Yes"];?><input type="radio"  <?php if($fullRelisting['show_image']=="yes") print " checked "; ?>  name="reprofileimage" id='reprofileimage'  value="yes"></label>
<label class="radio"><?php print $relanguage_tags["No"];?><input type="radio" name="reprofileimage" id='reprofileimage2'  <?php if($fullRelisting['show_image']=="no") print " checked "; ?>   value="no"></label>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div id='listingProfileImage'></div>

<div class="form-group">
<div class="col-sm-4 col-md-4 col-lg-4 pull-right" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='hidden' name='ptype' value='updateReListing' />
<input type='hidden' name='reid' value='<?php print $reid; ?>' />
<input type='hidden' name='listingtype' value='<?php print $fullRelisting['listing_type']; ?>' />
<input type='submit' class='btn btn-primary btn-lg' id='reAddListingButton' value='<?php print $relanguage_tags["Update Listing"];?>' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
<p class="help-block"><font style="font-size:10px; color:red;"><?php print $relanguage_tags["Fields marked with are required"];?></font></p>
</div>
</form>
</fieldset>
</div>