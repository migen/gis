<?php



function sessionizeProfessorCrids($db,$dbg,$tcid,$sem){
	$dbo=PDBO;
	$q=" SELECT crs.crid,cr.name AS classroom,cr.code AS crcode
		FROM {$dbg}.01_courses AS crs
		LEFT JOIN {$dbg}.01_classrooms AS cr ON cr.id=crs.crid
		WHERE crs.tcid='$tcid' AND crs.is_active=1 AND crs.semester='$sem'
		GROUP BY cr.id ORDER BY cr.section_id; ";
	$sth=$db->querysoc($q);	
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();
	$_SESSION['professor']['crids']=&$rows;	
	$_SESSION['professor']['numcrids']=&$count;
	$crids=buildArray($rows,'crid');
	$_SESSION['professor']['listcrids']=&$crids;	

}	/* fxn */


function queryPendingSubmitted($dbg,$tcid,$sem,$is_finalized){
	$dbo=PDBO;
	$q = "SELECT sxn.name AS section,sub.name AS subject,cr.name AS classroom,t.id AS tcid,t.code AS teacher_code,t.name AS teacher,
			crs.id AS crs,crs.name AS course,crs.id AS course_id,crs.semester AS sem,crs.position AS pos,				
			crs.is_numeric,crs.is_finalized,crs.with_scores			
		FROM  {$dbg}.01_courses AS crs
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
			LEFT JOIN {$dbo}.`00_contacts` AS t ON crs.tcid=t.id
			LEFT JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
			LEFT JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
			LEFT JOIN {$dbg}.01_sections AS sxn ON cr.section_id = sxn.id
		WHERE t.id='$tcid' AND crs.`is_active`='1' AND crs.is_finalized='$is_finalized' AND crs.semester='$sem'
		ORDER BY crs.crid,crs.position,crs.id 
		LIMIT 50";	
		return $q;

}	/* fxn */


function unipending($db,$dbg,$tcid,$sem,$is_finalzed=0){
	$q=queryPendingSubmitted($dbg,$tcid,$sem,$is_finalzed);
	$sth = $db->querysoc($q);
	$_SESSION['professor']['unipending']=$sth->fetchAll();
	$_SESSION['professor']['num_unipending']=$sth->rowCount();

}	/* fxn */

function unisubmitted($db,$dbg,$tcid,$sem,$is_finalized=1){
	$q=queryPendingSubmitted($dbg,$tcid,$sem,$is_finalized);
	$sth = $db->querysoc($q);	
	$_SESSION['professor']['unisubmitted']=$sth->fetchAll();
	$_SESSION['professor']['num_unisubmitted']=$sth->rowCount();

}	/* fxn */



function sessionizeProfessor($db,$dbg=PDBG){
	$sem= $_SESSION['settings']['semester'];$tcid= $_SESSION['user']['ucid'];
	$dbo=PDBO;	
	sessionizeProfessorCrids($db,$dbg,$tcid,$sem);	
	sessionizeAdvisories($db,$tcid,$dbg);	
	/* 1 pending & submitted */
	unipending($db,$dbg,$tcid,$sem,$is_finalized=0);			
	unisubmitted($db,$dbg,$tcid,$sem,$is_finalized=1);		
		
	/* ids array */
	$_SESSION['professor']['unipending_ids']=buildArray($_SESSION['professor']['unipending'],'crs');	
	$_SESSION['professor']['unisubmitted_ids']=buildArray($_SESSION['professor']['unisubmitted'],'crs');	
	$_SESSION['professor']['unicourse_ids']=array_merge($_SESSION['professor']['unipending_ids'],$_SESSION['professor']['unisubmitted_ids']);
			
	sessionizeSettingsGis($db,$dbg);
	sessionizeUserByUcid($db,$tcid);		
	sessionizeInfo();
	
}	/* fxn */ 

function sessionizeAdvisories($db,$tcid,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT id AS crid,id,name AS classroom
		FROM {$dbg}.01_classrooms WHERE acid='$tcid' AND is_active=1
		ORDER BY major_id,section_id;";		
	$sth=$db->querysoc($q);	
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();
	$_SESSION['professor']['advisories']=&$rows;	
	$_SESSION['professor']['num_advisories']=&$count;
	$advisories=buildArray($rows,'crid');
	$_SESSION['professor']['list_advisories']=&$advisories;	
	
}	/* fxn */


