<?php

function getShsList($db,$dbg,$cond=NULL){
$dbo=PDBO;
$q="SELECT cr.id,cr.num,cr.level_id,cr.name,cr.label,cr.id AS crid,cr.name AS classroom,cond.id AS conduct_id,trts.id AS trait_id,
		l.department_id,s.name AS section
	FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id	
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id = s.id	
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPECONDUCT."' AND is_active = '1'
		) AS cond ON cond.crid = cr.id				
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS trts ON trts.crid = cr.id						
	$cond ORDER BY cr.level_id,cr.section_id; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function sessionizeShsList($db,$dbg){
	$dbo=PDBO;
	if(!isset($_SESSION['shslist'])){ 	
		$cond = " WHERE cr.`section_id`>2 AND cr.`level_id`>13 ";			
		$_SESSION['shslist']=getShsList($db,$dbg,$cond);
	} 	
	$rows=$_SESSION['shslist'];	
	return $rows;

}	/* fxn */

/* shslevels */

function getShsLevels($db,$dbg,$cond=NULL){
$dbo=PDBO;
$q="SELECT l.id AS lvl,l.id,l.name AS level,l.department_id
	FROM {$dbo}.`05_levels` AS l $cond ORDER BY l.id; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function sessionizeShsLevels($db,$dbg){
	if(!isset($_SESSION['shsLevels'])){ 	
		$cond = " WHERE l.`id`>13 ";			
		$_SESSION['shsLevels']=getShsLevels($db,$dbg,$cond);
	} 	
	$rows=$_SESSION['shsLevels'];	
	return $rows;

}	/* fxn */

function getGenaveSummary($db,$dbg,$crid,$fields="summ.id",$cond=NULL,$order="summ.ave_q7 DESC"){
$dbo=PDBO;
	$q="SELECT $fields,summ.scid,c.code AS studcode,c.name AS student,summ.ave_q5,summ.ave_q6,summ.ave_q7
		FROM {$dbg}.05_summaries AS summ
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
	WHERE summ.crid='$crid' $cond ORDER BY $order;";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function getGenaveCombo($db,$dbg,$crids,$fields="summ.id",$cond=NULL,$order="summ.ave_q7 DESC"){
	$dbo=PDBO;
	$where="";foreach($crids AS $crid){ $where.=" summ.crid=$crid OR";	 } $where=rtrim($where,"OR");
	$q="SELECT $fields,summ.scid,c.code AS studcode,c.name AS student,summ.ave_q5,summ.ave_q6,summ.ave_q7
		FROM {$dbg}.05_summaries AS summ
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
	WHERE ( $where ) $cond ORDER BY $order;";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */

function getClassroomName($db,$dbg,$crid){
	$dbo=PDBO;
	$q="SELECT id,name FROM {$dbg}.05_classrooms WHERE id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();	
}	/* fxn */

