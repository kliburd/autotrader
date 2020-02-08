<?php 
/*
 * Filters data through the functions registered for "addListingForm" hook.
 * Passes the content through registered functions.
 */
 
print call_plugin("addListingForm",addListingForm());

function addListingForm(){
    include("config.php");
ob_start();     
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$mem_id=$_SESSION["re_mem_id"];
$qr="select * from $rememberTable where id='$mem_id'";
$result=mysqli_query($coni,$qr);
$row=mysqli_fetch_assoc($result);

$reqr1="select * from $categoryTable order by category asc";
$resultre1=mysqli_query($coni,$reqr1);

?>
<div id='perimeter'>
<fieldset id='submitListingPage'>
<legend>
<b><?php print $relanguage_tags["Add Listing"];?></b>
</legend>
<form action='index.php' method='post' name='addReListingForm' class='form-horizontal'>
<input type='hidden' id='isSubmitListingForm' name='isSubmitListingForm' value='1' />

<div class="form-group">
 <label class="col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Brand"];?>:</b></label>
 <div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
 <select name='category' id='reCategory2' class="form-control" >
<option value='Select' selected='selected' ><?php print $relanguage_tags["Select"]; ?></option>
<?php 
while($allCategories=mysqli_fetch_assoc($resultre1)){ ?>
<option value='<?php print __($allCategories['category']);?>' ><?php print __($allCategories['category']); ?></option>
<?php } ?>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div id='subcategoriesSection2'></div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Listing by"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<label class="radio"><?php print $relanguage_tags["Individual"];?> <input type="radio" name="relistingby" checked value="Individual" /></label>
<label class="radio"><?php print $relanguage_tags["Agent"];?><input type="radio" name="relistingby" value="Agent" /></label>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>
 
<?php if($memtype==9){ ?>
<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Listing status"];?>:</b>
<font face='verdana' size='1'>(<?php print $relanguage_tags["this option is visible to admin only"];?>)</font></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<label class="radio"><?php print $relanguage_tags["Normal"];?> <input type="radio" name="listingexpire" id='listingNormal' checked value="normal" /></label>
<label class="radio"><?php print $relanguage_tags["Permanent"];?> <input type="radio" name="listingexpire" id="listingPermanent" value="permanent" /></label>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
<span id='listingStatus'></span>
</div>
<?php } ?>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags[$redefaultDistance];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='remileage' size='10' value='' onkeyup="if(this.value.match(/[^0-9 ]/g)) { this.value = this.value.replace(/[^0-9 ]/g, '');}" />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Make"]." ".$relanguage_tags["Year"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name='autoage' class="form-control">
<?php include("allYears.php"); ?>
</select>
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
<select name="bodytype" id="bodyType2" class="form-control">
<?php for($i=0;$i<$featureSize;$i++){ ?>
<option value="<?php print $relanguage_tags[$allFeaturesArray[$i]]; ?>"  <?php if(in_array($relanguage_tags[$allFeaturesArray[$i]],$bodyType)) print "selected='selected'"; ?> ><?php print $relanguage_tags[$allFeaturesArray[$i]]; ?></option>
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
<select name="fueltype" id="fuelType2" class="form-control">
<?php for($i=0;$i<$featureSize;$i++){ ?>
<option value="<?php print $relanguage_tags[$allFeaturesArray[$i]]; ?>"   <?php if(in_array($relanguage_tags[$allFeaturesArray[$i]],$fuelType)) print "selected='selected'"; ?> ><?php print $relanguage_tags[$allFeaturesArray[$i]]; ?></option>
<?php } ?>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Transmission"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name="transmission" id="transmissionType2" class="form-control">
<option value="<?php print $relanguage_tags["Automatic"];?>"  <?php if(in_array($relanguage_tags["Automatic"],$transmissionType)) print "selected='selected'"; ?> ><?php print $relanguage_tags["Automatic"];?></option>
<option value="<?php print $relanguage_tags["Manual"];?>"  <?php if(in_array($relanguage_tags["Manual"],$transmissionType)) print "selected='selected'"; ?> ><?php print $relanguage_tags["Manual"];?></option>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Exterior Colour"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='excolour' size='25' value=''  />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Interior Colour"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='incolour' size='25' value=''  />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Drive"];?> :</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<select name="drive" id="drive" class="form-control">
<option value="<?php print $relanguage_tags["FWD"];?>"><?php print $relanguage_tags["FWD"];?></option>
<option value="<?php print $relanguage_tags["RWD"];?>"><?php print $relanguage_tags["RWD"];?></option>
<option value="<?php print $relanguage_tags["AWD"];?>"><?php print $relanguage_tags["AWD"];?></option>
<option value="<?php print $relanguage_tags["4x4"];?>"><?php print $relanguage_tags["4x4"];?></option>
</select>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<div id='priceField' >
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Price"];?> (<?php print $defaultCurrency; ?>):</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='reprice' size='7' value='' onkeyup="if(this.value.match(/[^0-9 ]/g)) { this.value = this.value.replace(/[^0-9 ]/g, '');}" />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Features"];?>:</b></label>
<div class="col-sm-9 col-md-9 col-lg-9">
<table align='center' width='100%'>
<?php
$fqr2="select * from $featureTable";
$fresult2=mysqli_query($coni,$fqr2);
$frow2=mysqli_fetch_assoc($fresult2);
$allFeaturesArray=explode(":::",$frow2['all_features']);
$allFeatureSize=sizeof($allFeaturesArray);

$count=1; 
for($i=0;$i<$allFeatureSize;$i++){
	if($count==1)
	print "<tr><td><input type='checkbox' name='feature-$i' value='".$allFeaturesArray[$i]."' />&nbsp;".$relanguage_tags[$allFeaturesArray[$i]]."</td>";
	if($count==2)
	print "<td><input type='checkbox' name='feature-$i' value='".$allFeaturesArray[$i]."' />&nbsp;".$relanguage_tags[$allFeaturesArray[$i]]."</td>";
	if($count==3){
	print "<td><input type='checkbox' name='feature-$i' value='".$allFeaturesArray[$i]."' />&nbsp;".$relanguage_tags[$allFeaturesArray[$i]]."</td></tr>";
	$count=0;
	}
	$count++;
}
?>
</table>
<input type='hidden' name='totalfeatures' value='<?php print $i; ?>' />
</div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Address"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='readdress' size='75' value='' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["City"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='recity' id='recity' value='<?php print $GLOBALS['vCity']; ?>'>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["State"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='restate'  id='restate' value='<?php print $GLOBALS['vRegion']; ?>'>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Country"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='recountry'  id='recountry' value='<?php print $GLOBALS['vCountry']; ?>'>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Postal Code"];?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class='textinput form-control' name='repostal' value=''>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>
<!-- 
<font face='verdana' size='1'>* <b><?php print $relanguage_tags["Please enter correct postal code as it will be used to display a satellite map"];?>.</b></font>
-->

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
<input type='text' class="form-control" readonly name='latitude' id='listingLatitude' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="listingLongitude"><b><?php print __("Longitude");?>:</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='text' class="form-control" readonly name='longitude' id='listingLongitude' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>
</div>

<div id='addListingMap' style="width:650px; height:400px; display:none;"></div>
<br /><br />

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Headline"];?>:</b></label>
<div class="col-sm-9 col-md-9 col-lg-9">
<input type='text' class='textinput form-control' maxlength="150" name='reheadline' id='reheadline' style="width:90%;" value=''>
</div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Description"];?>:</b></label>
<div class="col-sm-9 col-md-9 col-lg-9">
<textarea NAME="redescription" id='redescription'  class="form-control"  style="width:90%;" ROWS=25></textarea>
</div>
</div>

<p><b><?php print $relanguage_tags["Contact Information"];?>:</b></p>
<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="rename"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Name"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> ><input type='text' class="form-control" name='rename' id='rename' value='<?php print $row['name']; ?>' /></div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="rephone"><b><?php print $relanguage_tags["Phone"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> ><input type='text' class="form-control" name='rephone' id='rephone' value='<?php print $row['phone']; ?>' /></div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="reemail"><span class='required_field'><sup>*</sup></span><b><?php print $relanguage_tags["Email"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> ><input type='text' class="form-control" name='reemail' id='reemail' value='<?php print $row['email']; ?>' /></div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="rewebsite"><b><?php print $relanguage_tags["Website"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> ><input type='text' class="form-control" name='rewebsite' id='rewebsite' size='30' value='http://' />
<input type='hidden' name='ptype' value='myprofile' /><input type='hidden' name='formsubmit' value='1' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label" for="remyaddress"><b><?php print $relanguage_tags["Address"];?></b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> ><textarea name='remyaddress' id='remyaddress' class="form-control" style="width:90%;" cols='25' rows='4'><?php print $row['address']; ?></textarea></div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div class="form-group">
<label class="col-sm-3 col-md-3 col-lg-3 control-label"><b><?php print $relanguage_tags["Show profile image"];?>?</b></label>
<div class="col-sm-4 col-md-4 col-lg-4" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<label class="radio"><?php print $relanguage_tags["Yes"];?> <input type="radio" name="reprofileimage" id='reprofileimage'  value="yes"></label>
<label class="radio"><?php print $relanguage_tags["No"];?> <input type="radio" name="reprofileimage" id='reprofileimage2' value="no"></label>
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
</div>

<div id='listingProfileImage'></div>

<div class="form-group">
<div class="col-sm-4 col-md-4 col-lg-4 pull-right" <?php if(isset($_SESSION['rtl']) && $_SESSION['rtl']==true) print " style='float:right;' "; ?> >
<input type='hidden' name='ptype' value='addReListing' />
<input type='submit' class='btn btn-primary btn-lg' id='reAddListingButton' value='<?php print $relanguage_tags["Add Listing"];?>' />
</div>
<div class="col-sm-5 col-md-5 col-lg-5"></div>
<p class="help-block"><font style="font-size:10px; color:red;"><?php print $relanguage_tags["Fields marked with are required"];?></font></p>
</div>

</form>
</fieldset>
</div>
<?php
return ob_get_clean();
}
?>