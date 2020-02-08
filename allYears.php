<?php
$currentYear=date('Y');
$endYear=$currentYear-100;

for($i=$currentYear;$i>=$endYear;$i--){
print "<option value='$i'>$i</option>";
} 
?>