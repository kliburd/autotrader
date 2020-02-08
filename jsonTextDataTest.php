<?php
include("functions.inc.php");
print $_GET['callback'].'('.json_encode(getTextDataJson($_GET['nelatitude'],$_GET['nelongitude'],$_GET['swlatitude'],$_GET['swlongitude'],$_GET['pagenum'])).')';
?>