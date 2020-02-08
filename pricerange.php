<?php 
if($memtype==9){
include("config.php");
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");

if($_POST['pricetype']=="rent"){
$totalrange=$_POST['totalrange'];
$fullPriceRange="";

 for($i=0;$i<$totalrange;$i++){
 $fromPrice=$_POST['from-'.$i];
 $toPrice=$_POST['to-'.$i];
 if($fullPriceRange=="") $delim="";
 else $delim=",";  
 $fullPriceRange=$fullPriceRange.$delim.$fromPrice."-".$toPrice;
	}
$upqr1="update $priceTable set rent='$fullPriceRange'";
if($isThisDemo!="yes") $result1=mysqli_query($coni,$upqr1);
}

if($_POST['pricetype']=="sale"){
	$totalrange=$_POST['totalrange'];
	$fullPriceRange="";

	for($i=0;$i<$totalrange;$i++){
		$fromPrice=$_POST['from-'.$i];
		$toPrice=$_POST['to-'.$i];
		if($fullPriceRange=="") $delim="";
		else $delim=",";
		$fullPriceRange=$fullPriceRange.$delim.$fromPrice."-".$toPrice;
	}
	$upqr1="update $priceTable set sale='$fullPriceRange'";
	if($isThisDemo!="yes") $result2=mysqli_query($coni,$upqr1);
}

$priceqr="select * from $priceTable";
$priceResult=mysqli_query($coni,$priceqr);
$priceRange=mysqli_fetch_assoc($priceResult);
$rentPriceRange=explode(",",$priceRange['rent']);
$salePriceRange=explode(",",$priceRange['sale']);
$rentRangeSize=sizeof($rentPriceRange);
$saleRangeSize=sizeof($salePriceRange);

?>
<div id='perimeter'>
<fieldset id='reProfilePage'>
<legend>
<b><?php print $relanguage_tags["Update"]." ".$relanguage_tags["Price Range"];?></b>
</legend>
<div class="alert alert-info">
    <a class="close" data-dismiss="alert" href="#">x</a>
    <h4 class="alert-heading">Help</h4>
    Here you can create custom price range that would appear in the search form.</b>.
    </div>
<form action="index.php" method="post" enctype="multipart/form-data" name='rentpriceform' >
<h3 align=center'><?php print $relanguage_tags["Listings"]; if($result1) print " - ".$relanguage_tags["updated"].""; ?></h3>
<table id='resultTable'>
<tr class='headRow1'><td align='right'><b><?php print $relanguage_tags["From"];?></b></td><td></td>
<td align='left'><b><?php print $relanguage_tags["To"];?></b></td>
</tr>
<?php 
for($i=0;$i<$rentRangeSize;$i++){ 
list($priceFrom,$priceTo)=explode("-",$rentPriceRange[$i]);
if($priceTo=="Above" && $i==$rentRangeSize-1) $readOnly=" readonly='readonly' ";
print "<tr><td align='right'>$defaultCurrency<input type='text' name='from-$i' size='10' value='$priceFrom' /></td><td align='center'> to </td><td align='left'>$defaultCurrency<input type='text' name='to-$i' size='10' value='$priceTo' $readOnly /></td></tr>";
}
$readOnly="";
?>
<tr><td colspan='3' align='center'>
<input type='hidden' name='totalrange' value='<?php print $i; ?>' />
<input type='hidden' name='pricetype' value='rent' />
<input type='hidden' name='ptype' value='updatePriceRange' />
<input type='submit' name='submit' class='rebutton btn btn-large' id='updatePriceRange1' value='<?php print $relanguage_tags["Update"];?>' /></td></tr>
</table>
</form>
<br />
<!-- 
<form action="index.php" method="post" enctype="multipart/form-data" name='salepriceform' >
<h3 align=center'><?php print $relanguage_tags["Sale"]; if($result2) print " - ".$relanguage_tags["updated"].""; ?> ( K=1000 and M=1000000 )</h3>
<table id='resultTable'>
<tr class='headRow1'><td align='right'><b><?php print $relanguage_tags["From"];?></b></td><td></td>
<td align='left'><b><?php print $relanguage_tags["To"];?></b></td>
</tr>
<?php 
for($i=0;$i<$saleRangeSize;$i++){ 
list($priceFrom,$priceTo)=explode("-",$salePriceRange[$i]);
if($priceTo=="Above" && $i==$saleRangeSize-1) $readOnly=" readonly='readonly' ";
print "<tr><td align='right'>$defaultCurrency<input type='text' name='from-$i' size='10' value='$priceFrom' /></td><td align='center'> to </td><td align='left'>$defaultCurrency<input type='text' name='to-$i' size='10' value='$priceTo' $readOnly /></td></tr>";
}
$readOnly="";
?>
<tr><td colspan='3' align='center'>
<input type='hidden' name='totalrange' value='<?php print $i; ?>' />
<input type='hidden' name='pricetype' value='sale' />
<input type='hidden' name='ptype' value='updatePriceRange' />
<input type='submit' name='submit' class='rebutton' id='updatePriceRange2' value='<?php print $relanguage_tags["Update"];?>' /></td></tr>
</table>
</form>
-->
</fieldset>
</div>
<?php } ?>