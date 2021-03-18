<?php

function getCourseActivities($db,$dbg,$crs,$qtr){
	$q="SELECT id FROM {$dbg}.50_activities WHERE course_id='$crs' AND quarter='$qtr'; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getScoresActivities($db,$dbg,$crs,$qtr){
	$q="SELECT activity_id AS id FROM {$dbg}.50_scores WHERE course_id='$crs' AND quarter='$qtr' GROUP BY activity_id; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */
