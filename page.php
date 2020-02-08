<?php
include("config.php");
$id=mysqli_real_escape_string($coni,$_GET['id']);
$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");
$qr="select * from $pageTable where id='$id';";
$result=mysqli_query($coni,$qr);
$page=mysqli_fetch_assoc($result);
?>
<div id='perimeter'>
<fieldset id='reProfilePage'>
<legend>
<?php print $page['page_name'];?>
</legend>
<?php print $page['page_content']; ?>
</fieldset>
</div>