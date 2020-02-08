<?php
include("functions.inc.php");
print getTextDataJson($_GET['nelatitude'],$_GET['nelongitude'],$_GET['swlatitude'],$_GET['swlongitude'],$_GET['pagenum']);
?>