<?php
session_start();
include("functions.inc.php");
$id=$_GET['id'];
$region=$_SESSION["autoadmin_settings"]["defaultcountry"];
$latlng=explode(",",$_GET['latlng']);
$latlng[0]=substr($latlng[0],0,-1);
$latlng[1]=substr($latlng[1],0,-1);
$margs[0]=getMarkerInfo($latlng[0],$latlng[1],$id,$region);
$margs[1]=$id;
$margs[2]=$region;
$margs[3]=$latlng;
if(trim($latlng[0])!="" && trim($latlng[1])!="'"){
$markerData=call_plugin("getMarkerInfo",$margs);
print $markerData[0];
}
?>