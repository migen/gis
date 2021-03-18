<?php

function getUniscoresForSyncing($db,$dbg,$course_id,$scid,$sem){
	$dbo=PDBO;
	/* getScoresPerStudent */
	$q = "SELECT sc.activity_id AS aid
		FROM {$dbg}.10_scores AS sc
		WHERE sc.course_id='$course_id' AND sc.scid='$scid' AND sc.semester=$sem
		ORDER BY aid; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */ 


function syncStudentUniscores($db,$ar,$br,$scid,$crs,$sem){
	$dbo=PDBO;$dbg=PDBG;
	$ix=array_diff($ar,$br);
	$q="INSERT INTO {$dbg}.10_scores(`activity_id`,`scid`,`course_id`,`semester`)VALUES";
	foreach($ix AS $aid){ $q.="('$aid','$scid','$crs','$sem'),"; }
	$q=rtrim($q,",");$q.=";";
	$db->query($q);
	
}	/* fxn */

function delsyncStudentUniscores($db,$ar,$br,$scid,$crs,$sem){
	$dbo=PDBO;$dbg=PDBG;
	/* 2 */
	$jx=array_diff($br,$ar);
	$q="";
	foreach($jx AS $aid){ $q="DELETE FROM {$dbg}.10_scores WHERE `activity_id`=$aid; "; }	
	$db->query($q);
	
}	/* fxn */