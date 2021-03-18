<?php

if(!defined('CTYPECOND')){ DEFINE('CTYPECOND',5); }

function getProfileForTranscript($db,$scid){
	$dbo=PDBO;
	$q="SELECT pr.*,c.code AS studcode,c.name AS studname,c.lrn,c.role_id,c.parent_id
		FROM {$dbo}.00_profiles AS pr
		INNER JOIN {$dbo}.00_contacts AS c ON pr.contact_id=c.id
		WHERE c.id=$scid LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);	
	$data['student']=$sth->fetch();
	return $data;
	
}

function attendanceMonths($db,$lvl,$sy,$dbg){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbg}.05_attendance_months WHERE `level_id`={$lvl} LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();		
}	/* fxn */


function getAttendanceByEnrollment($db,$dbg,$scid){
	$dbo=PDBO;
	$q="SELECT *,id AS attid FROM {$dbg}.05_attendance WHERE `scid`='$scid'; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();

	
}	/* fxn */
	
function getClassroomInfo($db,$dbg,$crid){
	$dbo=PDBO;
	$q="SELECT cr.id AS crid,cr.id,cr.name,cr.label,cr.acid,cr.level_id,c.name AS adviser 
		FROM {$dbg}.05_classrooms AS cr LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		WHERE cr.id='$crid' LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */
	
function getGradesByEnrollment($db,$dbg,$scid){
	$dbo=PDBO;
	$q="SELECT g.id,g.*,crs.name AS course,crs.label,crs.semester,crs.is_num
		FROM {$dbg}.50_grades AS g
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id		
		WHERE g.scid='$scid' AND (crs.crstype_id=".CTYPEACAD." OR crs.crstype_id=".CTYPECOND.")
		ORDER BY crs.position;";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();	
}	/* fxn */


function getEnrollmentsByScid($db,$scid,$order="DESC"){
	$dbo=PDBO;
	// $q="SELECT e.* FROM {$dbo}.05_enrollments AS e WHERE scid='$scid' ORDER BY sy $order; ";
	$q="SELECT e.* FROM {$dbo}.05_enrollments AS e WHERE scid='$scid' ORDER BY sy $order LIMIT 2; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;		
}	/* fxn */

function getStudentInfo($db,$scid){
	$dbo=PDBO;
	$q="SELECT id,parent_id,code,name,role_id FROM {$dbo}.`00_contacts` WHERE id='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['student']=$student=$sth->fetch();
	$role_id=$student['role_id'];
/* 	$data['is_bed']=($role_id==1)? true:false;
	$data['is_uni']=($role_id==8)? true:false;
	$data['is_student']=(($role_id==1) || ($role_id==8))? true:false;
	$data['begsy']=$_SESSION['settings']['sy_beg'];	 */
	return $data;
	
}	/* fxn */


