<?php


if(!defined('CTYPECOND')){ DEFINE('CTYPECOND',5); }

function getProfileForTranscript($db,$scid){
	$dbo=PDBO;
	$q="SELECT pr.*,pr.id AS prid,c.code AS studcode,c.name AS studname,c.lrn,c.role_id,c.parent_id
		FROM {$dbo}.00_contacts AS c 
		LEFT JOIN {$dbo}.00_profiles AS pr ON pr.contact_id=c.id		
		WHERE c.id=$scid LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);	
	$row=$sth->fetch();
	if(empty($row['prid'])){
		$q="INSERT INTO {$dbo}.00_profiles(contact_id)VALUES($scid); ";$sth=$db->query($q);
		$_SESSION['message']=($sth)? "Insert Profile succeeded.":"Insert Profile failed.";
	}
	return $row;
	
}	/* fxn */



function getEnrollmentSummaryByStudent($db,$scid,$order="ASC"){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.05_enrollments WHERE scid='$scid' ORDER BY sy $order; ";
	debug("transcriptFxn-getEnrollmentSummaryByScid: $q");
	$sth=$db->querysoc($q);	
	$data['ensumm']=$rows=$sth->fetchAll();
	$data['ensumm_count']=$count=$sth->rowCount();

/* 	
	for($i=0;$i<$count;$i++){
		extract($rows[$i]);
		$r1=getClassroomdetailsBySY($db,$sy,$crid);
		$rows[$i]['classroom']=$r1['classroom'];		
 	}	 
 */ 		
	
	return $data;		
}	/* fxn */


function getClassroomdetailsBySY($db,$sy,$crid){
	$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT acid,name AS classroom FROM {$dbg}.05_classrooms WHERE id=$crid LIMIT 1;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
	

}	/* fxn */


function getStudentGrades($db,$sy,$scid){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT g.id,g.*,crs.name AS course,crs.label,crs.semester,crs.is_num
		FROM {$dbg}.50_grades AS g
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id		
		WHERE g.scid='$scid' AND (crs.crstype_id=".CTYPEACAD." OR crs.crstype_id=".CTYPECOND.")
		ORDER BY crs.position LIMIT 2;";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();	
}	/* fxn */


function getStudentGrades_shs($db,$sy,$crid,$scid,$sem){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$semester = NULL;
	if($sem==1){ $semester = " AND ( crs.semester = '0' || crs.semester = 1 ) "; }
	elseif($sem==2){ $semester = " AND ( crs.semester = '0' || crs.semester = 2 ) "; }
	
	$q = "SELECT crs.name AS course,tcon.id AS tcid,tcon.code AS teacher_code,tcon.name AS teacher,
			crs.label AS subject,crs.crid,crs.*,g.`id` AS `gid`,g.*		
		FROM {$dbg}.05_courses AS crs
			LEFT JOIN {$dbg}.50_grades AS g ON g.course_id = crs.id
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			LEFT JOIN {$dbo}.`00_contacts` AS tcon ON crs.tcid = tcon.id		
		WHERE crs.`crid`='$crid' AND crs.`is_active`='1' AND crs.`is_displayed`='1' 
			AND crs.`crstype_id` <> ".CTYPETRAIT." AND g.`scid`='$scid' $semester
		ORDER BY crs.position,crs.id LIMIT 2; ";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();	
}	/* fxn */



function getAttendanceMonths($db,$lvl,$sy){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT * FROM {$dbg}.05_attendance_months WHERE `level_id`={$lvl} LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();		
}	/* fxn */



function getAttendanceByStudent($db,$sy,$scid){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT *,id AS attid FROM {$dbg}.05_attendance WHERE `scid`='$scid'; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();	
}	/* fxn */




















// 20201023 -----------------------------------





	
	
	
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


