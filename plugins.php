<?php

$dir="plugins";
foreach(scandir($dir) as $filename) {
	if ($filename !== '.' AND $filename !== '..' AND $filename !== 'cgi-bin' AND is_dir("$dir/$filename") ) {
		if (file_exists($dir."/".$filename."/default.php")) include($dir."/".$filename."/default.php");
	}
}

?>