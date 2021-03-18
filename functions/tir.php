<?php

function getTirList($db,$dbg=PDBG,$cond=NULL){
$dbo=PDBO;
$q = "SELECT cr.id,cr.name,cr.id AS crid,cr.name AS classroom,trts.id AS trait_id,l.department_id
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN ( SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS trts ON trts.crid = cr.id $cond
	ORDER BY cr.level_id,cr.section_id; ";
$sth=$db->querysoc($q);
return $sth->fetchAll();


}	/* fxn */


function sessionizeTirList($get,$db,$dbg){
$dbo=PDBO;
if(isset($get['all'])){
	if(!isset($_SESSION['tirlist_all'])){ 		
		$_SESSION['tirlist_all'] = getTirList($db,$dbg,$cond=NULL);
	} 	
	$classrooms = $_SESSION['tirlist_all'];	
} else {
	if(!isset($_SESSION['tirlist'])){ 	
		$cond = " WHERE sxn.id > '2' ";			
		$_SESSION['tirlist'] = getTirList($db,$dbg,$cond);
	} 	
	$classrooms = $_SESSION['tirlist'];	
}
return $classrooms;


}	/* fxn */

