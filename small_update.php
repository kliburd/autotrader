<?php include("config.php"); 

$con=$coni=mysqli_connect($host,$username,$password) or die("Could not connect. Please try again.");
mysqli_select_db($coni,$database);
mysqli_query($coni,"SET NAMES utf8");


$qr0="ALTER TABLE admin_options ADD jsontexturl varchar(2500) NOT NULL ;";
$result0=mysqli_query($coni,$qr0);
 
if($result0) print "<h3 align='center'>Added support for jsontexturl.</h3>";
else print "<h3 align='center'>".mysqli_errno().": ".mysqli_error().". If you've refreshed this page after update or already updated then discard this message.</h3>";


?>