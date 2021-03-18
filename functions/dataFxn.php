<?php

function getAllTeachers($db){
	$dbo=PDBO;
	$q = " SELECT  c.id AS tcid,c.code,pc.name AS teacher
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
		WHERE c.`role_id` = '".RTEAC."'	
		ORDER BY pc.name ASC; ";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getAllClassrooms($db,$dbg){
	$dbo=PDBO;
	$q = " 
		SELECT c.id AS tcid,c.code,pc.name AS adviser,l.name AS level,sxn.name AS section,cr.*,cr.id AS crid 
		FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`05_levels` AS l ON l.id = cr.level_id
			LEFT JOIN {$dbo}.`05_sections` AS sxn ON sxn.id = cr.section_id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id = cr.acid
			LEFT JOIN {$dbo}.`00_contacts` AS pc ON pc.id = c.parent_id
		WHERE sxn.`id` > '2'
		ORDER BY l.id ; ";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getClassroomStudents($db,$dbg,$crid){
	$dbo=PDBO;
	$q = "SELECT summ.id AS summid,summ.scid AS sumscid,cr.acid AS acid,
				c.is_male,summ.crid AS crid,c.id AS scid,c.code AS student_code,c.name AS student	
			FROM {$dbg}.`05_summaries` AS summ
				LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid  = c.id
				LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid 	 = cr.id
			WHERE summ.crid 	= '$crid' AND c.is_active			= 1
				ORDER BY c.is_male, c.name ASC;	";
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getStudentReps($db,$sy=DBYR){
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$axis=$_SESSION['settings']['has_axis'];
	$q="SELECT c.name AS student,cr.name AS classroom,cr.num,summ.scid,p.birthdate,ctp.ctp,c.account,
			summ.crid,cr.level_id,l.department_id AS dept_id
			
		";
	if($axis){ $q.=",summ.paymode_id,pm.name AS paymode"; }
		
	$q.="
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=c.id)
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		LEFT JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id ";
	if($axis){ $q.=" LEFT JOIN {$dbo}.03_paymodes AS pm ON summ.paymode_id=pm.id "; }
	$q.="WHERE c.role_id=1 AND summ.crid>0 AND (cr.section_id<>1) AND c.is_active=1
		GROUP BY cr.id ORDER BY cr.level_id LIMIT 100;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	return $data;	
}	/* fxn */

