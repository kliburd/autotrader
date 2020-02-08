<div id='perimeter'>
<fieldset id='rePluginPage'>
<?php
if(function_exists($ptype)) $ptype();
else "<h3 align='center'>".__("Function $ptype does not exist in plugin default.php file")."</h3>";
?>
</fieldset>
</div>