<?php

class Sync extends Model{

public function __construct(){
	parent::__construct();
}


public function syncProfiles($dbg=PDBG){
$dbo=PDBO;

/*  1 */
$q="SELECT id FROM {$dbo}.`00_contacts`  WHERE id=parent_id ;  ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$ar=buildArray($rows,'id');
/*  2   */
$q = " 
SELECT DISTINCT(c.parent_id) AS id  FROM {$dbo}.`00_profiles` AS `p`
	LEFT JOIN {$dbo}.`00_contacts` AS c ON p.`contact_id` = c.`id`; ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$br=buildArray($rows,'id');

/*  3 - ix */
$ix=array_diff($ar,$br);
$q=" INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ";
foreach($ix AS $scid){ $q .= " ('$scid'),"; }
$q = rtrim($q,",");$q .= "; "; 
$this->db->query($q);

}	/* fxn */



public function syncAttendanceMonths($new_sy,$dbg=PDBG){
	$dbo=PDBO;	
	/* 1 - attmonths */
	$q=" SELECT id AS lid,name FROM {$dbo}.`05_levels` ORDER BY id;  ";
	$sth=$this->db->querysoc($q);
	$rows=$sth->fetchAll();

	foreach($rows AS $level){
		$q = " SELECT id FROM {$dbg}.05_attendance_months WHERE `level_id` = '".$level['lid']."' LIMIT 1;  ";
		$sth = $this->db->querysoc($q);
		$attmo = $sth->fetch();
		if(empty($attmo)){
			$q = " INSERT INTO {$dbg}.05_attendance_months (`level_id`) VALUES ('".$level['lid']."');  ";
			$sth = $this->db->query($q);
		}	
	}	

	/* 2 - attmonths_employees ??? */
	$q = " SELECT id FROM {$dbg}.05_attendance_months_employees WHERE `sy` = '$new_sy' LIMIT 1;  ";
	$sth = $this->db->querysoc($q);
	$attmo = $sth->fetch();
	if(empty($attmo)){
		$q = " INSERT INTO {$dbg}.05_attendance_months_employees (`sy`) VALUES ('$new_sy');  ";
		$sth = $this->db->query($q);
	}
		

}   /* fxn */




public function trimSummaries($dbg,$sy){
	$dbo=PDBO;	
	/* 2 */
	$q=" SELECT sum.`scid` AS `scid` FROM {$dbg}.05_summaries AS sum
			LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
			WHERE c.`is_active`='1'; ";	
	$sth=$this->db->querysoc($q);
	$a=$sth->fetchAll();
	$ar = buildArray($a,'scid');
	/* 1 */
	$q=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE `role_id` = '1' AND `is_active` = 1; ";
	$sth=$this->db->querysoc($q);
	$b=$sth->fetchAll();
	$br=buildArray($b,'scid');
	/* 3 */
	$ix = array_diff($ar,$br);	
	/* 1 - delete summaries - scid,sy */
	$q = "";
	foreach($ix AS $scid){ $q .= " DELETE FROM {$dbg}.`05_summaries` WHERE `scid` = $scid LIMIT 1; "; }
	$this->db->query($q);

}	/* fxn */


public function syncCStudents($dbg,$sy){
	$dbo=PDBO;
	/* 1 */
	$q="SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE `role_id` = '1' AND `is_active` = 1; ";
	$sth=$this->db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');
	
	/* 2 */
	$q="SELECT s.`contact_id` AS `scid` FROM {$dbg}.05_students AS s LEFT JOIN {$dbo}.`00_contacts` AS c ON s.`contact_id` = c.id
		WHERE c.`is_active` = '1' AND c.`role_id` = '1' ; ";	
	$sth=$this->db->querysoc($q);
	$b=$sth->fetchAll();
	$br=buildArray($b,'scid');
	/* 3 */
	$ix=array_diff($ar,$br);
	
	/* 1 - insert students - scid,sy */
	$q=" INSERT INTO {$dbg}.05_students (`contact_id`) VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";		
	$this->db->query($q);

}	/* fxn */



public function trimCStudents($dbg,$sy){
	$dbo=PDBO;
	/* 2 */
	$q=" SELECT s.`contact_id` AS `scid` FROM {$dbg}.05_students AS s   
		LEFT JOIN {$dbo}.`00_contacts` AS c ON s.contact_id = c.id
		WHERE c.is_active = 1 AND c.role_id = 1; ";	
	$sth=$this->db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');

	/* 1 */
	$q=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE `role_id`='1' AND `is_active`=1; ";
	$sth=$this->db->querysoc($q);
	$b=$sth->fetchAll();
	$br=buildArray($b,'scid');

	/* 3 */
	$ix = array_diff($ar,$br);
	
	/* 1 - delete summaries - scid,sy */
	$q = "";
	foreach($ix AS $scid){ 
		$q .= "DELETE FROM {$dbg}.05_students WHERE `scid`= '$scid' LIMIT 1; ";
	}
	$this->db->query($q);

}	/* fxn */




public function syncAttendanceEmployees($dbg,$sy){
	$dbo=PDBO;
	/* 1 */
	$q=" SELECT id AS ucid FROM {$dbo}.`00_contacts` WHERE `role_id` <> ".RSTUD." AND (id=parent_id) AND `is_active`='1' ORDER BY `id` ; ";
	$sth=$this->db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'ucid');
	
	/* 2 */
	$q=" SELECT att.ecid AS ucid FROM {$dbg}.06_attendance_employees AS att INNER JOIN {$dbo}.`00_contacts` AS c ON att.ecid = c.id 
		WHERE  c.`role_id` <> ".RSTUD." AND (c.id=c.parent_id)  AND c.`is_active` = '1' ORDER BY c.`id`; ";
	$sth = $this->db->querysoc($q);
	$b=$sth->fetchAll();
	$br=buildArray($b,'ucid');

	$ix = array_diff($ar,$br);
	
	/* 3 */
	$q=" INSERT INTO {$dbg}.06_attendance_employees (`ecid`) VALUES  ";
	foreach($ix AS $ucid){ $q .= " ('$ucid'),"; }
	$q=rtrim($q,",");$q .= "; ";		
	$this->db->query($q);		

}	/* fxn */


public function syncCrsQtrs($dbg=PDBG){	
	$dbo=PDBO;	
	$q = " SELECT id FROM {$dbg}.05_courses WHERE is_active = '1' ORDER BY id; ";
	$sth = $this->db->querysoc($q);
	$crs = $sth->fetchAll();
	$ar = buildArray($crs,'id');
	$q = " SELECT cq.course_id AS id FROM {$dbg}.05_courses_quarters AS cq
			INNER JOIN {$dbg}.05_courses AS crs ON cq.course_id = crs.id WHERE crs.is_active = 1; ";
	$sth = $this->db->querysoc($q);
	$cq = $sth->fetchAll();
	$br = buildArray($cq,'id');	
	$ix = array_diff($ar,$br);	
	$q = " INSERT INTO {$dbg}.05_courses_quarters (`course_id`) VALUES  ";
	foreach($ix AS $crsid){ $q .= " ('$crsid'),"; }
	$q = rtrim($q,",");$q .= "; ";			
	$this->db->query($q);
	debug($q);
	echo "Courses-Quarters synced done.";

}	/* fxn */


public function syncAdvQtrs($dbg=PDBG){
	$dbo=PDBO;	
	$q=" SELECT cr.`id` FROM {$dbg}.05_classrooms AS cr INNER JOIN {$dbo}.`05_sections` AS sec  
			ON cr.section_id = sec.id ORDER BY cr.`id`; ";
	$sth=$this->db->querysoc($q);
	$cr=$sth->fetchAll();
	$ar=buildArray($cr,'id');
	
	$q=" SELECT aq.`crid` AS `id` FROM {$dbg}.05_advisers_quarters AS aq
			INNER JOIN {$dbg}.05_classrooms AS cr ON aq.crid = cr.id INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id;";
	$sth=$this->db->querysoc($q);
	$aq=$sth->fetchAll();
	$br=buildArray($aq,'id');	
	$ix=array_diff($ar,$br);
	$q=" INSERT INTO {$dbg}.05_advisers_quarters (`crid`) VALUES  ";
	foreach($ix AS $crid){ $q .= " ('$crid'),"; }
	$q=rtrim($q,",");$q.="; ";			
	$this->db->query($q);
	debug($q);
	echo "Advisers-Quarters synced done.";

}	/* fxn */


public function syncCtp($dbg=PDBG){
$dbo=PDBO;
/*  1 */
$q="SELECT id FROM {$dbo}.`00_contacts` ORDER BY `id` ;  ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$ar=buildArray($rows,'id');

/*  2   */
$q="SELECT DISTINCT(contact_id) AS id FROM {$dbo}.`00_ctp` ORDER BY `contact_id`; ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$br=buildArray($rows,'id');

/*  3 - ix */
$ix=array_diff($ar,$br);
$q=" INSERT INTO {$dbo}.`00_ctp` (`contact_id`,`ctp`) VALUES ";
foreach($ix AS $ucid){ $q .= " ('$ucid','pass'),"; }
$q=rtrim($q,",");$q .= "; "; 
$this->db->query($q);

}	/* fxn */



public function syncPhotos($dbg=PDBG){
$dbo=PDBO;
$dbp=PDBP;
/*  1 */
$q="SELECT id FROM {$dbo}.`00_contacts` WHERE `id`=`parent_id`;  ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$ar=buildArray($rows,'id');

/*  2   */
$q="SELECT DISTINCT(c.parent_id) AS id FROM {$dbp}.photos AS `p`
	INNER JOIN {$dbo}.`00_contacts` AS c ON p.`contact_id` = c.`id`";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$br=buildArray($rows,'id');

/*  3 - ix */
$ix=array_diff($ar,$br);

$q="INSERT INTO {$dbp}.photos(`contact_id`) VALUES ";
foreach($ix AS $pcid){ $q .= " ('$pcid'),"; }
$q=rtrim($q,",");$q.="; "; 
$this->db->query($q);


}	/* fxn */




public function syncAttTimes($dbg=PDBG){
$dbo=PDBO;
/* 1 */
$q=" SELECT id FROM {$dbo}.`00_contacts` WHERE id=parent_id ORDER BY `id`; ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$ar=buildArray($rows,'id');

/* 2 -  */
$q="SELECT c.`id` AS id FROM {$dbg}.attendance_times AS at INNER JOIN {$dbo}.`00_contacts` AS c ON at.contact_id = c.`id` 
WHERE c.`id` = c.`parent_id` ORDER BY c.`id`; ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$br=buildArray($rows,'id');

/* 3 - ix */
$ix=array_diff($ar,$br);

$q="INSERT INTO {$dbg}.attendance_times(`contact_id`) VALUES ";
foreach($ix AS $pcid){ $q .= " ('$pcid'),"; }
$q = rtrim($q,",");$q .= "; "; 
$this->db->query($q);

}	/* fxn */



public function syncSubjectsCoordinators($dept_id,$dbg=PDBG){
	$dbo=PDBO;
	/* 1 */
	$subjects=$this->fetchRows("{$dbo}.`05_subjects`",'id,name','id',' WHERE is_active = 1 ');
	$ar=buildArray($subjects,'id');
	/* 2 - */ 
	$q=" SELECT subject_id AS id FROM {$dbo}.`05_subjects`_coordinators WHERE `department_id` = '$dept_id' ORDER BY subject_id; ";
	$sth=$this->db->querysoc($q);
	$sacs=$sth->fetchAll();
	$br=buildArray($sacs,'id');

	/* 3 - ix */
	$ix = array_diff($ar,$br);

	$q = " INSERT INTO {$dbo}.`05_subjects`_coordinators (`subject_id`,`department_id`) VALUES ";
	foreach($ix AS $subid){ $q .= " ('$subid','$dept_id'),"; }
	$q = rtrim($q,",");$q .= "; "; 
	$this->db->query($q);

}	/* fxn */




public function activeStudentsArray($dbg=PDBG){
	$dbo=PDBO;
	$q=" SELECT `id` AS `scid` FROM {$dbo}.`00_contacts` WHERE (id=parent_id) AND `role_id` = '1' AND `is_active` = 1; ";
	$sth=$this->db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');	
	return $ar;
}	/* fxn */




public function syncIteachers($dbg=PDBG){
	$dbo=PDBO;

/*  1 */
$q="  SELECT id FROM {$dbo}.`00_contacts`  WHERE (id=parent_id) AND `is_active` = '1' AND `role_id` = '".RTEAC."' ;  ";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$ar=buildArray($rows,'id');

/*  2   */
$q="SELECT DISTINCT(c.parent_id) AS id FROM {$dbg}.`iteachers` AS `it` LEFT JOIN {$dbo}.`00_contacts` AS c ON it.`asee_cid` = c.`id` 
	WHERE 	c.`role_id` = '".RTEAC."' AND c.`id`=c.`parent_id` AND c.`is_active` = '1';";
$sth=$this->db->querysoc($q);
$rows=$sth->fetchAll();
$br=buildArray($rows,'id');

/*  3 - ix */
$ix = array_diff($ar,$br);

$q="INSERT INTO {$dbg}.iteachers(`asee_cid`) VALUES ";
foreach($ix AS $cid){ $q .= " ('$cid'),"; }
$q = rtrim($q,",");$q .= "; "; 

$this->db->query($q);

}	/* fxn */



public function syncBalance($ucid){
	$dbo=PDBO;
	$q = "INSERT INTO {$dbo}.balances(`contact_id`,`balance`) VALUES ('$ucid','0'); ";
	$this->db->query($q);
}	/* fxn */



public function syncTuitions($dbg=PDBG){
	$dbo=PDBO;	
	$q="SELECT id AS level_id FROM {$dbo}.`05_levels`; ";
	$sth=$this->db->querysoc($q);
	$rows=$sth->fetchAll();
	$ar=buildArray($rows,'level_id');

	$q="SELECT * FROM {$dbo}.`03_tuitions`; ";
	$sth=$this->db->querysoc($q);
	$rows=$sth->fetchAll();
	$br=buildArray($rows,'level_id');

	/*  3 - ix */
	$ix=array_diff($ar,$br);
	$q=" INSERT INTO {$dbo}.`03_tuitions`(`level_id`) VALUES ";
	foreach($ix AS $level_id){ $q .= " ('$level_id'),"; }
	$q = rtrim($q,",");$q .= "; "; 
	$this->db->query($q);
}	/* fxn */













} 	/* SyncModel */



