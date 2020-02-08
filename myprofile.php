<?php 
if(!isset($_SESSION["myusername"])) exit;
include_once("functions.inc.php");
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$rename=mysqli_real_escape_string($coni,$_POST["rename"]);
$rephone=mysqli_real_escape_string($coni,$_POST["rephone"]);
$reemail=mysqli_real_escape_string($coni,$_POST["reemail"]);
$rephone=mysqli_real_escape_string($coni,$_POST["rephone"]);
$repassword=mysqli_real_escape_string($coni,$_POST["repassword"]);
$rewebsite=mysqli_real_escape_string($coni,$_POST["rewebsite"]);
$readdress=mysqli_real_escape_string($coni,$_POST["readdress"]);
$formsubmit=mysqli_real_escape_string($coni,$_POST["formsubmit"]);
$name = $_FILES['photoimg']['name'];
//$upload_image=$_SESSION['upload_image'];

if($formsubmit==1){
	if(trim($name)!=""){
		$upload_image=uploadImage($mem_id);
		$photoClause=", photo='$upload_image' ";
        $qr00="select photo from $rememberTable where id='$mem_id';";
        $result00=mysqli_query($coni,$qr00);
        $row00=mysqli_fetch_array($result00);
        $oldPhoto=trim($row00['photo']);
        unlink("uploads/".$oldPhoto);
	}
    if(trim($repassword)!=""){
    $repassword=md5($repassword);
    $passClause=", password='$repassword'";
    }else $passClause="";
    $qr0="update $rememberTable set name='$rename', email='$reemail', phone='$rephone' , website='$rewebsite' , address='$readdress' ,
    ip='$ip' $photoClause $passClause where id='$mem_id'";
    if($isThisDemo!="yes") $result0=mysqli_query($coni,$qr0);

}

$qr="select * from $rememberTable where id='$mem_id'";
$result=mysqli_query($coni,$qr);
$row=mysqli_fetch_assoc($result);

?>
<div id='perimeter'>
<fieldset id='reProfilePage'>
<legend>
<b><?php print $relanguage_tags["My Profile"];?></b>
</legend>
<form action="index.php" method="post" enctype="multipart/form-data" name='imgform' class="form-horizontal" >

<?php 
if($formsubmit==1){
if($result0) print "<div class='alert alert-success'><a class='close' data-dismiss='alert' href='#'>x</a>".$relanguage_tags["Profile updated"].".</div>";
else print "<div class='alert alert-error'><a class='close' data-dismiss='alert' href='#'>x</a>".$relanguage_tags["Please try again"].".</div>";
}
?>
<div class="form-group">
 <label class="col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><?php print $relanguage_tags["Name"];?></label>
 <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><input type='text' name='rename' id="rename" value='<?php print $row['name']; ?>' /></div>
</div>
 
<div class="form-group">
<label class="col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><?php print $relanguage_tags["Phone"];?></label>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><input type='text' name='rephone' id="rephone"  value='<?php print $row['phone']; ?>' /></div>
</div>

<div class="form-group">
<label class="col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><?php print $relanguage_tags["Email"];?></label>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><input type='text' name='reemail' id="reemail"  value='<?php print $row['email']; ?>' /></div>
</div>

<div class="form-group">
<label class="col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><?php print $relanguage_tags["Password"];?></label>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><input type='password' name='repassword' id='repassword' value='' /></div>
</div>

<div class="form-group">
<label class="col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><?php print $relanguage_tags["Website"];?></label>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><input type='text' name='rewebsite' id="rewebsite"  size='30' value='<?php print $row['website']; ?>' /></div>
<input type='hidden' name='ptype' value='myprofile' />
<input type='hidden' name='formsubmit' value='1' />
</div>

<div class="form-group">
<label class="col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><?php print $relanguage_tags["Address"];?></label>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><textarea name='readdress' id="readdress"  cols='25' rows='4'><?php print $row['address']; ?></textarea></div>
</div>

<div class="form-group">
<label class="col-xs-3 col-sm-3 col-md-3 col-lg-3 control-label" for="reCategory2"><?php print $relanguage_tags["Your Photo"];?></label>
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9"><input type="file" name="photoimg" id="photoimg" class='rebutton' /><br /><br />
<div id='imageUploading'>
<?php if(trim($row['photo'])!=""){ ?>
<img width='200' src="uploads/<?php print $row['photo']; ?>" border="0" />
<?php } ?>
</div>
</div>
</div>

<div class="form-group">
<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
<input type='submit' class='btn btn-primary btn-large' id='reprofilesubmit' value='<?php print $relanguage_tags["Update Profile"];?>' />
</div>
</div>

</form>
</fieldset>
</div>
<?php 


?>