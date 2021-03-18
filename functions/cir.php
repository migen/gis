<?php

function getCirListByBrid($db,$dbg,$cond="WHERE cr.section_id>2 AND cr.section_id>2"){
	$dbo=PDBO;
	$order="cr.level_id,cr.section_id";
	$qtr=$_SESSION['qtr'];
	$q = "SELECT cr.id,cr.num,cr.level_id,cr.name,cr.id AS crid,cr.name AS classroom,cond.id AS conduct_id,
	trts.id AS trait_id,l.department_id,aq.is_finalized_q{$qtr} AS `is_locked`,count(summ.scid) AS num_students
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id	
		LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON aq.crid=cr.id	
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPECONDUCT."' AND is_active = '1'
		) AS cond ON cond.crid = cr.id				
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS trts ON trts.crid = cr.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON cr.id=summ.crid 
	$cond GROUP BY cr.id ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$rows = $sth->fetchAll();	
	return $rows;

}	/* fxn */


function getCirList($db,$dbg,$cond="WHERE cr.section_id>2"){
	$dbo=PDBO;
	$order="cr.level_id,cr.section_id";
	$qtr=$_SESSION['qtr'];
	$q = "SELECT cr.id,cr.num,cr.level_id,cr.name,cr.id AS crid,cr.name AS classroom,cond.id AS conduct_id,
	trts.id AS trait_id,l.department_id,aq.is_finalized_q{$qtr} AS `is_locked`,count(summ.scid) AS num_students
	FROM {$dbg}.05_classrooms AS cr	
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id	
		LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON aq.crid=cr.id	
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPECONDUCT."' AND is_active = '1'
		) AS cond ON cond.crid = cr.id				
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS trts ON trts.crid = cr.id
		LEFT JOIN (
			SELECT c.id,summ.scid,summ.crid FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
		) AS summ ON cr.id=summ.crid 
		
	$cond GROUP BY cr.id ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$rows = $sth->fetchAll();	
	return $rows;

}	/* fxn */




function sessionizeCirList($get,$db,$dbg){
	if(isset($get['all'])){
		if(!isset($_SESSION['cirlist_all'])){ 		
			$_SESSION['cirlist_all'] = getCirList($db,$dbg,$cond=NULL);
		} 	
		$classrooms = $_SESSION['cirlist_all'];	
	} else {
		if(!isset($_SESSION['cirlist'])){ 	
			$cond = " WHERE cr.section_id > '2' ";			
			$_SESSION['cirlist'] = getCirList($db,$dbg,$cond);
		} 	
		$classrooms = $_SESSION['cirlist'];	
	}
	return $classrooms;

}	/* fxn */


function sessionizeCirListByBrid($get,$db,$dbg,$cond){
	if(!isset($_SESSION['cirlist'])){ 	
		$_SESSION['cirlist'] = getCirListByBrid($db,$dbg,$cond);
	} 	
	$classrooms = $_SESSION['cirlist'];	
	return $classrooms;

}	/* fxn */
