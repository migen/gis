<?php



function getUcirList($db,$dbg,$cond="WHERE cr.section_id>2 AND cr.level_id>13"){
	$dbo=PDBO;
	$order="cr.level_id,cr.section_id";
	$qtr=$_SESSION['qtr'];
	
	$q = "SELECT cr.id,cr.num,cr.level_id,cr.name,cr.id AS crid,cr.name AS classroom,cond.id AS conduct_id,
	trts.id AS trait_id,l.department_id,count(summ.scid) AS num_students
	FROM {$dbg}.01_classrooms AS cr
		LEFT JOIN {$dbg}.01_levels AS l ON cr.level_id = l.id	
		LEFT JOIN {$dbg}.05_summaries AS summ ON cr.id=summ.crid 
	$cond GROUP BY cr.id ORDER BY $order; ";	
	debug($q);
	// pr("ccirFxn-getCcirList $q");
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();		
	return $data;

}	/* fxn */



function sessionizeUcirList($get,$db,$dbg){
	$dbo=PDBO;
	if(isset($get['all'])){
		if(!isset($_SESSION['ucirlist_all'])){ 		
			$_SESSION['ucirlist_all'] = getUcirList($db,$dbg,$cond=NULL);
		} 	
		$classrooms = $_SESSION['ucirlist_all'];	
	} else {
		if(!isset($_SESSION['ucirlist'])){ 	
			$cond = " WHERE cr.section_id > '2' ";			
			$_SESSION['ucirlist'] = getUcirList($db,$dbg,$cond);
		} 	
		$classrooms = $_SESSION['ucirlist'];	
	}
	return $classrooms;

}	/* fxn */