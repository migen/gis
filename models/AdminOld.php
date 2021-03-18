<?php

class Admin extends Model{



public function __construct(){
	parent::__construct();
}



function keygen($len=6){
	$alpha   = str_shuffle('qwertyupasdfghjkzxcvbnm');
	$alpha1  = substr(str_shuffle('qwertyupasdfghjkzxcvbnm'),5,2);
	$alpha2  = substr(str_shuffle('qwertyupasdfghjkzxcvbnm'),5,2);
	$nums    = substr(str_shuffle('23456789'),5,2);
	$pass 	 = $alpha1.$nums.$alpha2;

	if(($len >= 7) && ($len <= 12)){
		$charsLeft = $len - 6;		
		$alpha3  = substr($alpha,0,$charsLeft);
		$pass .= $alpha3;
	}	
	return $pass;	
}



public function jasmin($fields,$table=null,$where=null){		# for jsAutoSuggest/mingoSearch
	$fs = implode($fields,',');
	$table = isset($table)? $table : $this->dbtable;
	$q = "select $fs from $table $where ";		
	// echo "q: $q <br />";
	$sth = $this->db->query($q);
	if(!$sth){ pr($q); die('Query failed.');  }		
	
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	return $sth->fetchAll();
}





public function cqByAdmin0($ucid,$dbg=PDBG){
$q = "
	SELECT 
		pcrs.id AS supcourse_id,pcrs.name AS supcourse,	
		cq.id AS cqid,		
		cq.*,crs.*,		
		crs.name AS course,crs.crid AS crid,crs.crstype_id AS ctype_id,
		c.id AS tcid,c.account,c.name AS teacher,
		cp.`ctp` AS pass,
		l.name AS level,sec.name AS section		
	FROM {$dbo}.`05_subjects`_coordinators AS sac
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON sac.subject_id 	 = sub.id
		LEFT JOIN {$dbg}.05_courses AS crs ON crs.subject_id 		 = sub.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid 	 = cr.id
		LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id 	 	 = sec.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id 			 = l.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id = crs.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid 	 = c.id 
		LEFT JOIN {$dbo}.`00_ctp` AS cp ON crs.tcid 		 = cp.contact_id 		
	   LEFT JOIN {$dbg}.05_courses AS pcrs ON 
					( crs.supsubject_id = pcrs.subject_id 					
				AND  crs.crid = pcrs.crid )		
	WHERE 
			sac.hcid 	=	'$ucid'		
		AND	sac.department_id 	= l.department_id
			
;";
pr($q);
$sth = $this->db->querysoc($q);
$data['cq']['cq']		 = $sth->fetchAll();
$data['cq']['num_cq']  = count($data['cq']['cq']);				
return $data['cq'];
	
}



public function cqByAdmin($ucid,$dbg=PDBG){
$q = "
	SELECT 
		cq.id AS cqid,		
		cq.*,crs.*,		
		crs.name AS course,crs.crid AS crid,crs.crstype_id AS ctype_id,
		c.id AS tcid,c.account,c.name AS teacher,
		cp.`ctp` AS pass,
		l.name AS level,sec.name AS section		
	FROM {$dbo}.`05_subjects`_coordinators AS sac
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON sac.subject_id 	 = sub.id
		LEFT JOIN {$dbg}.05_courses AS crs ON crs.subject_id 		 = sub.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid 	 = cr.id
		LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id 	 	 = sec.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id 			 = l.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id = crs.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid 	 = c.id 
		LEFT JOIN {$dbo}.`00_ctp` AS cp ON crs.tcid 		 = cp.contact_id 		

	WHERE 
			sac.hcid 	=	'$ucid'		
		AND	sac.department_id 	= l.department_id
			
;";
// pr($q);
$sth = $this->db->querysoc($q);
$data['cq']['cq']		 = $sth->fetchAll();
$data['cq']['num_cq']  = count($data['cq']['cq']);		
// pr($data['cq']);		
return $data['cq'];
	
}



public function aqByAdmin($ucid,$dbg=PDBG){
$q = "
	SELECT 
		cr.id AS 'crid',cr.`name` AS 'classroom',cr.acid AS acid,
		c.account,c.name AS adviser,cp.`ctp` AS pass,
		aq.id AS aqid,
		aq.*,cr.*			
	FROM {$dbg}.05_advisers_quarters AS aq 		
		LEFT JOIN {$dbg}.05_classrooms AS cr ON aq.crid = cr.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id 
		LEFT JOIN {$dbo}.`00_ctp` AS cp ON cr.acid = cp.contact_id 		
	WHERE 
		cr.hcid = '$ucid'	
;";

$sth = $this->db->querysoc($q);
$data['aq']['aq']		= $sth->fetchAll();
$data['aq']['num_aq'] = count($data['aq']['aq']);				
return $data['aq'];

}
 
 
 
 
public function sessionizeAdmin($dbg=PDBG){	/* RACAD=4 */
$ucid = $_SESSION['user']['ucid'];

/* 1 - cq */
$data['cq'] = $this->cqByAdmin($ucid);

/* 2 - aq */
$data['aq'] = $this->aqByAdmin($ucid);

$_SESSION['admin']	= $data;
$this->urooms($ucid);

}	/* fxn */






} /* Admin */



