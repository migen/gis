<?php
$level_id = $classroom['level_id'];


$incfile = "";
$level_id = 8;

echo "<h5>Level ID statically = 8</h5>";

switch($level_id){
	case $level_id <= 6: $incfile = "tpl01_06.php"; break;
	case $level_id <= 9: $incfile = "tpl07_09.php"; break;
	default: $incfile = "tpl10_13.php"; break;
	
}

pr($incfile);
include_once($incfile);
		


