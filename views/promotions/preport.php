<?php if(isset($_GET['debug'])){ pr($q); } ?>


<?php
$level_id = $classroom['level_id'];
$incfile = "";

/* 1:ps to gr3, 2:gr4-gr6, 3:hs */
if(isset($_GET['tpl'])){	
	switch($_GET['tpl']){
		case 1: $incfile = "tpl01_06.php"; break;
		case 2: $incfile = "tpl07_09.php"; break;
		default: $incfile = "tpl10_13.php"; break;		
	}
	

} else {
	switch($level_id){
		case $level_id <= 6: $incfile = "tpl01_06.php"; break;
		case $level_id <= 9: $incfile = "tpl07_09.php"; break;
		default: $incfile = "tpl10_13.php"; break;
		
	}

}


include_once($incfile);
		


