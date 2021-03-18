<?php


function abc($db,$dbg){
	$dbo=PDBO;
	$q="select xxid,code,name from {$dbg}.05_classrooms WHERE id=88 LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	pr($q);
	pr($row);
	
}	/* fxn */

function getCcirList($db,$dbg,$cond="WHERE cr.section_id>2 AND cr.level_id>13"){
	$dbo=PDBO;
	$order="cr.level_id,cr.section_id";
	$qtr=$_SESSION['qtr'];
	
	$q = "SELECT cr.id,cr.num,cr.level_id,cr.name,cr.id AS crid,cr.name AS classroom,cond.id AS conduct_id,
	trts.id AS trait_id,l.department_id,count(summ.scid) AS num_students
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id	
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPECONDUCT."' AND is_active = '1'
		) AS cond ON cond.crid = cr.id				
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS trts ON trts.crid = cr.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON cr.id=summ.crid 
	$cond GROUP BY cr.id ORDER BY $order; ";	
	debug($q);
	// pr("ccirFxn-getCcirList $q");
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();		
	return $data;

}	/* fxn */


function getCcirList0($db,$dbg,$cond="WHERE cr.section_id>2 AND cr.level_id>13"){
	$dbo=PDBO;
	$order="cr.level_id,cr.section_id";
	$qtr=$_SESSION['qtr'];
	$q = "SELECT cr.id,cr.num,cr.level_id,cr.name,cr.id AS crid,cr.name AS classroom,cond.id AS conduct_id,
	trts.id AS trait_id,l.department_id,aq.is_finalized_q{$qtr} AS `is_locked`,count(summ.scid) AS num_students
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id	
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPECONDUCT."' AND is_active = '1'
		) AS cond ON cond.crid = cr.id				
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS trts ON trts.crid = cr.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON cr.id=summ.crid 
	$cond GROUP BY cr.id ORDER BY $order; ";
	debug($q);
	pr("ccirFxn-getCcirList $q");
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();		
	return $data;

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
		LEFT JOIN {$dbg}.05_summaries AS summ ON cr.id=summ.crid 
	$cond GROUP BY cr.id ORDER BY $order; ";
	// pr($q);
	debug($q);
	$sth=$db->querysoc($q);
	$rows = $sth->fetchAll();	
	return $rows;

}	/* fxn */




function sessionizeCirList($get,$db,$dbg){
	$dbo=PDBO;
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