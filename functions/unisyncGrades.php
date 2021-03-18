<?php

function getStudentUnigrades($db,$dbg,$scid){
	$dbo=PDBO;
	$q=" SELECT course_id AS crs FROM {$dbg}.10_grades WHERE scid=$scid ORDER BY course_id; ";debug($q,"unisyncGrades-getStudent..");
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */