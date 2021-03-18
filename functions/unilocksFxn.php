<?php


function lockUnicourse($db,$dbg,$course_id,$sem){
	/* 1 */
	$dbo=PDBO;
	$today=$_SESSION['today'];		
	$q=" UPDATE {$dbg}.01_courses SET `is_finalized` = 1,`finalized_date`='$today' 
			WHERE `id`='$course_id' AND `semester`='$sem' LIMIT 1; "; 
	$db->query($q);				
	pr($q);
	
}	/* fxn */


function unlockUnicourse($db,$dbg,$course_id,$sem){
	$dbo=PDBO;
	$today=$_SESSION['today'];		
	$q=" UPDATE {$dbg}.01_courses SET `is_finalized`=0,`finalized_date`='' 
			WHERE `id`='$course_id' AND `semester`='$sem' LIMIT 1; "; 
	$db->query($q);				
		
}	/* fxn */


