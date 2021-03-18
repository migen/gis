<?php
$level_id = $classroom['level_id'];


$incfile = "";
$level_id = 4;

// echo "<h5>Level ID statically = $level_id </h5>";

switch($level_id){
	case $level_id <= 6: $incfile = "pfoot01_06.php"; break;
	case $level_id <= 9: $incfile = "tpl07_09_back.php"; break;
	default: $incfile = "tpl10_13_back.php"; break;
	
}

include_once($incfile);
		


