<?php


public function syncGrades($params){	

require_once(SITE."functions/reports.php");
$db =& $this->model->db;


$data['crid'] 	= $crid = $params[0];
$ssy = $_SESSION['sy'];
$data['sy'] 	= $sy 	= isset($params[1])? $params[1]:$ssy;
$today = $_SESSION['today'];
	
$dbyr = $sy.US;
$dbg  = VCPREFIX.$dbyr.DBG;	
$dbg  = VCPREFIX.$dbyr.DBG;	

$data['cr'] 	= $cr 	= $this->model->getClassroomDetails($crid,$dbg);
$crstype	= isset($params[2])? $params[2] : 1;

/* ----------------------------------------------------------------------------------- */

$data['students'] 		= $students		= classyear($db,$dbg,$sy,$crid);		/* GModel */
$data['courses']		= $courses		= cridCourses($db,$dbg,$crid,$acad=$crstype,$agg=1);


$ar = buildArray($courses,'course_id');

/* 1 - sync Grades  ------------------------------------------------------------------ */
foreach($students AS $row){ 
	$scid = $row['scid'];
	$q = " SELECT course_id FROM {$dbg}.50_grades WHERE `crstype_id` = '".$crstype."'  AND `scid` = '$scid'; ";
	$sth = $this->model->db->querysoc($q);
	$courses = $sth->fetchAll();
	$br = buildArray($courses,'course_id');
		
	$ix = array_diff($ar,$br);
	
	if(!empty($ix)){
		$q = " INSERT INTO {$dbg}.50_grades (`course_id`,`scid`,`crstype_id`) VALUES  ";
		foreach($ix AS $crs){
			$q .= " ('$crs','$scid','".$crstype."'),";
		}
		$q = rtrim($q,",");
		$q .= ";";	
		$this->model->db->query($q);
	}

}	/* foreach-students */


/* -------------- 2 - sync summaries ---------------------------- */
/*  no need to insert into dbgis.05_summaries since classlist is derived from dbgis.05_summaries  */
 
 /* ----------------- 2B update summaries.acid ------------------------------------- */

	$q = "UPDATE {$dbg}.05_summaries AS a 
		INNER JOIN (
			SELECT 
				c.id AS contact_id,c.crid AS crid,cr.acid
			FROM {$dbo}.`00_contacts` AS c
				INNER JOIN {$dbg}.05_classrooms AS cr ON c.crid = cr.id
			WHERE c.crid = '$crid'
		) AS b ON a.scid = b.contact_id 
		SET a.crid 	 = b.crid,
			a.acid = b.acid; ";		  
	$this->model->db->query($q);					


/* -------------- 3 - sync attendance ---------------------------- */

$q = " INSERT IGNORE INTO {$dbg}.05_attendance (`scid`) VALUES  ";
foreach($students AS $row){ 
	$scid = $row['scid'];	
	$q .= " ('$scid'),";
}	/* foreach-sync attendance */
$q = rtrim($q,",");
$q .= ";";
$this->model->db->query($q);


/* -------------- 4 - lock_init ---------------------------- */
// $ctype = ($crstype==1)? 'grades' : 'club';
$ctype =  'grades';
$q = " UPDATE {$dbg}.05_classrooms SET 
		`is_init_grades` = '1',`init_grades_date` = '$today' 
	WHERE `id` = '$crid' LIMIT 1;  ";
$this->model->db->query($q);


/* -------------- 5 - redirect ---------------------------- */
// $url = isset($_SESSION['url'])? $_SESSION['url']: "mis/classrooms/".$cr['level_id'].DS.$sy;
$url = "mis/syncer";
$_SESSION['message'] = "Grades Synced";
redirect($url);

}	/* fxn */

