<?php


function unsetSessionVariables(){
	unset($_SESSION['flash_reminder']); 
	unset($_SESSION['classroom']); 
	unset($_SESSION['crid']); 
	unset($_SESSION['ratings']); 
	unset($_SESSION['students']); 
	unset($_SESSION['boys']); 
	unset($_SESSION['girls']); 
	unset($_SESSION['days_left']); 
}	/* fxn */


function clubs($db,$dbg,$tcid){
	$dbo=PDBO;
	try{
		$q="SELECT * FROM {$dbg}.05_clubs WHERE `tcid`='$tcid';";
		$sth=@$db->query($q);
		if($sth){ $sth->setFetchMode(PDO::FETCH_ASSOC);$rows=$sth->fetchAll();return $rows; } 
		return array();
	} catch(Exception $e){} 
}	/* fxn */

function advisories($db,$dbg,$tcid,$qtr,$sem){
	$dbo=PDBO;
	$q = "
		SELECT  
			cr.id AS crid,cr.id AS crid,cr.acid AS acid,
			cr.acid,cr.name AS classroom,cr.level_id,cr.section_id,
			aq.is_finalized_q1,aq.is_finalized_q2,aq.is_finalized_q3,aq.is_finalized_q4,
			l.is_k12,l.name AS level,sec.name AS section
		FROM  {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`05_levels` AS l ON (cr.level_id = l.id)
			LEFT JOIN {$dbo}.`05_sections` AS sec ON (cr.section_id = sec.id)
			LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON (aq.crid = cr.id)
		WHERE cr.acid = '$tcid'; ";		
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */



function conductTraits($db,$dbg,$tcid,$qtr,$sem){
	$dbo=PDBO;
	$q = "SELECT 
			tc.id AS tcid,tc.code AS teacher_code,tc.name AS teacher,				
			cr.id AS crid,cr.name AS classroom,
			IF(crs.crstype_id='".CTYPECONDUCT."',1,0) AS is_conduct,			
			crs.id AS course_id,crs.name AS course,cr.level_id,crs.crstype_id,
			crs.with_scores,crs.is_aggregate,crs.supsubject_id,
			l.name AS level,sec.name AS section,sub.name AS subject,l.conduct_ctype_id,			
			cq.is_finalized_q1,cq.is_finalized_q2,cq.is_finalized_q3,cq.is_finalized_q4 
		FROM  {$dbg}.05_courses AS crs
			INNER JOIN {$dbo}.`05_subjects` AS sub ON (crs.subject_id = sub.id)
			INNER JOIN {$dbo}.`00_contacts` AS tc ON (crs.tcid = tc.id)
			INNER JOIN {$dbg}.05_classrooms AS cr ON (crs.crid = cr.id)
			INNER JOIN {$dbo}.`05_levels` AS l ON (cr.level_id = l.id)
			INNER JOIN {$dbo}.`05_sections` AS sec ON (cr.section_id = sec.id)							
			INNER JOIN {$dbg}.05_courses_quarters AS cq ON (cq.course_id = crs.id)							
		WHERE crs.tcid = '$tcid' AND crs.`is_active` = '1' AND crs.crstype_id != '".CTYPEACAD."' 
		ORDER BY crs.crid,crs.position,crs.id 
		LIMIT 50; "; 
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function submitted($db,$dbg,$tcid,$qtr,$sem){
	$dbo=PDBO;
	$q = "SELECT 	
			crs.semester AS sem,crs.position AS pos,
			tc.id AS tcid,tc.code AS teacher_code,tc.name AS teacher,		
			cr.name AS classroom,
			crs.id AS course_id, crs.name AS course,crs.label,
			crs.with_scores,crs.is_aggregate,crs.supsubject_id,
			l.name AS level,sec.name AS section,
			sub.name AS subject,
			cq.is_finalized_q1,cq.is_finalized_q2,cq.is_finalized_q3,cq.is_finalized_q4 					
		FROM  {$dbg}.05_courses AS crs
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON (crs.subject_id = sub.id)
			LEFT JOIN {$dbo}.`00_contacts` AS tc ON (crs.tcid = tc.id)
			LEFT JOIN {$dbg}.05_classrooms AS cr ON (crs.crid = cr.id)
			LEFT JOIN {$dbo}.`05_levels` AS l ON (cr.level_id = l.id)
			LEFT JOIN {$dbo}.`05_sections` AS sec ON (cr.section_id = sec.id)							
			LEFT JOIN {$dbg}.05_courses_quarters AS cq ON (cq.course_id = crs.id)										
		WHERE 
				tc.id = '$tcid' AND crs.`is_active` = '1'					
			AND ( crs.crstype_id = '".CTYPEACAD."'  )
			AND cq.is_finalized_q$qtr = '1'  
			AND (crs.semester = 0 || crs.semester = ".$sem.")			
		ORDER BY crs.crid,crs.position,crs.id 
		LIMIT 50; ";	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function pending($db,$dbg,$tcid,$qtr,$sem){
	$dbo=PDBO;
	$q = " 				
		SELECT 
			crs.semester AS sem,crs.position AS pos,
			tc.id AS tcid,tc.code AS teacher_code,tc.name AS teacher,
			cr.name AS classroom,
			crs.id AS course_id, crs.name AS course,crs.label,crs.is_num,
			crs.with_scores,crs.is_aggregate,crs.supsubject_id,
			l.name AS level,sec.name AS section,
			sub.name AS subject,
			cq.is_finalized_q1,cq.is_finalized_q2,cq.is_finalized_q3,cq.is_finalized_q4 			
		FROM  {$dbg}.05_courses AS crs
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON (crs.subject_id = sub.id)
			LEFT JOIN {$dbo}.`00_contacts` AS tc ON (crs.tcid = tc.id)
			LEFT JOIN {$dbg}.05_classrooms AS cr ON (crs.crid = cr.id)
			LEFT JOIN {$dbo}.`05_levels` AS l ON (cr.level_id = l.id)
			LEFT JOIN {$dbo}.`05_sections` AS sec ON (cr.section_id = sec.id)							
			LEFT JOIN {$dbg}.05_courses_quarters AS cq ON (crs.id = cq.course_id)										
		WHERE 
				tc.id = '$tcid' AND crs.`is_active` = '1'	
			AND ( crs.crstype_id = '".CTYPEACAD."'  )
			AND cq.is_finalized_q$qtr 	= '0'  
			AND (crs.semester = 0 || crs.semester = ".$sem.")
		ORDER BY crs.crid,crs.position,crs.id 
		LIMIT 50 
	";	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */





function sessionizeTeacher($db,$dbg=PDBG){
	$qtr= $_SESSION['qtr'];$tcid= $_SESSION['user']['ucid'];$sem= ($qtr<3)? 1:2;
	$dbo=PDBO;
	
	require_once(SITE.'functions/loads.php');
	sessionizeTeacherCrids($db,$dbg,$tcid);	
	/* courses - pending, @num is rownumber or rowNumber */
	/* SET @num = 0; SELECT @num:=@num+1 AS num,* FROM tbl */	
	/* 1 pending */
	$data['pending'] = pending($db,$dbg,$tcid,$qtr,$sem);			
	/* 2 courses - submitted */
	$data['submitted'] = submitted($db,$dbg,$tcid,$qtr,$sem);		
	/* 3 conducts or traits */
	$data['conducts'] = conductTraits($db,$dbg,$tcid,$qtr,$sem);
	/* 4 advisory classrooms homerooms */
	$data['advisories'] = advisories($db,$dbg,$tcid,$qtr,$sem);
	/* 5 clubs */
	$data['clubs']=clubs($db,$dbg,$tcid,$qtr,$sem);	
	
	/* counts */
	$data['num_advisories']=count($data['advisories']);
	$data['num_pending']=count($data['pending']);
	$data['num_submitted']=count($data['submitted']);
	$data['num_conducts']=count($data['conducts']);
	$data['num_clubs']=count($data['clubs']); 
		
	/* ids array */
	$data['advisory_ids']	= buildArray($data['advisories'],'crid');
	$data['pending_ids']	= buildArray($data['pending'],'course_id');	
	$data['submitted_ids']	= buildArray($data['submitted'],'course_id');	
	$data['conduct_ids']	= buildArray($data['conducts'],'course_id');	
	$data['course_ids']		= array_merge($data['pending_ids'],$data['submitted_ids'],$data['conduct_ids']);	
		
	sessionizeSettingsGis($db,$dbg);
	// urooms($db,$tcid);
	sessionizeUserByUcid($db,$tcid);		
	sessionizeInfo();
	$data['sy'] = $_SESSION['sy'];
		
	$_SESSION['teacher'] = $data;
	unsetSessionVariables();	
	
}	/* fxn */ 


