<?php
class Registrar extends Model{



public function __construct(){
	parent::__construct();
}






public function level($level_id,$dbg=PDBG){

	$q = " SELECT 
				l.id,l.name AS level,l.is_k12,
				cr.level_id,cr.section_id,
				cr.id AS crid,cr.name AS classroom,
				sec.id AS section_id,sec.name AS section 
			FROM {$dbo}.`05_levels` AS l 
				INNER JOIN {$dbg}.05_classrooms AS cr ON cr.level_id = l.id
				INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
			WHERE l.id = '$level_id'	
	";
	$sth = $this->db->querysoc($q);
	$data['level'] = $sth->fetchAll(); 
	return $data;

}


 
public function profiles($crid,$dbg=PDBG){
	$q = " 
  		SELECT 
			c.id AS contact_id,c.id AS scid,c.code AS student_code,c.name AS student,c.is_active,
			p.sms,p.email,p.province_id,p.city_id,p.address,p.barangay,p.street,
			p.first_name,p.middle_name,p.last_name,p.suffix,p.birthdate,p.age,c.is_male,
			p.nationality_id,p.religion_id,n.name AS nationality,r.name AS religion,
			prov.name AS province,
			ct.name AS city
		FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			INNER JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN {$dbo}.nationalities AS n ON p.nationality_id = n.id
			LEFT JOIN {$dbo}.religions AS r ON p.religion_id = r.id
			LEFT JOIN {$dbo}.provinces AS prov ON p.province_id = prov.id
			LEFT JOIN {$dbo}.cities AS ct ON p.city_id = ct.id
		WHERE cr.id = '$crid'
		
	";
	$sth = $this->db->querysoc($q);
	$data['students'] = $sth->fetchAll(); 
		
	return $data;

}	/* fxn */



public function getProfile($contact_id,$dbg=PDBG){
	$q = " SELECT 
		c.id AS contact_id,c.code AS student_code,c.account,c.name AS student,c.`sy`,c.`sy` AS year,
		p.sms,p.email,p.province_id,p.city_id,p.barangay,p.street,p.address,
		p.first_name,p.middle_name,p.last_name,p.suffix,p.birthdate,p.age,c.is_male,p.is_finalized,
		p.nationality_id,p.religion_id,
		n.name AS nationality,r.name AS religion,
		prov.name AS province,ct.name AS city		
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = c.id		
		LEFT JOIN {$dbo}.nationalities AS n ON p.nationality_id = n.id
		LEFT JOIN {$dbo}.religions AS r ON p.religion_id = r.id
		LEFT JOIN {$dbo}.provinces AS prov ON c.province_id = prov.id
		LEFT JOIN {$dbo}.cities AS ct ON c.city_id = ct.id		
	WHERE c.id = '$contact_id'
	LIMIT 1		
	";
	$sth = $this->db->querysoc($q);
	return $sth->fetch(); 
	

}	/* fxn */




public function getSections($level_id=1,$dbg=PDBG){
	
	$q = " 
		SELECT
			sec.id AS id,sec.name AS name
		FROM {$dbo}.`05_sections` AS sec
			INNER JOIN {$dbg}.05_classrooms AS cr ON cr.section_id = sec.id
		WHERE cr.level_id = '$level_id'	
	";
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


public function getSubjects($dbg,$level_id=1,$ctype=NULL){
$cond = (!is_null($ctype))? ' AND sub.crstype_id = '.$ctype : NULL;

	$q = " 
		SELECT
			DISTINCT(sub.id),sub.name AS name
		FROM {$dbg}.05_courses AS crs
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id  	 = sub.id
		WHERE 
				cr.level_id = '$level_id'	
				$cond				
	";
	// $_SESSION['q'] =  $q;
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


/* xxcq.quarter AS course_qtr, */
public function getInfoCourse($course_id,$dbg=PDBG){

	$q = "
		SELECT  
			crs.id AS course_id,crs.*,
			teac.name AS teacher,teac.account,
			sub.id AS subject_id,sub.name AS subject,
			cty.*,
			if(l.is_k12 = 1 AND l.is_ps = 0,1,0) AS is_kpup,			
			cr.level_id,cr.section_id,l.name AS level,sec.name AS section,
			l.*,cq.*
		FROM   {$dbg}.05_classrooms AS cr
		LEFT JOIN  {$dbg}.05_courses AS crs ON crs.crid = cr.id
		LEFT JOIN  {$dbo}.`05_crstypes` AS cty ON crs.crstype_id = cty.id
		LEFT JOIN {$dbo}.`00_contacts` AS teac ON crs.tcid = teac.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id = crs.id
		WHERE crs.id =  '$course_id' LIMIT 1		
	";
	// pr($q); exit;
	$sth = $this->db->querysoc($q);
	return $sth->fetch();	
}	/* for informant */

/* xxaq.quarter,*/ 
public function getInfoClassroom($crid,$dbg=PDBG){	/* almost like getClassroomDetails */

$q = "
	SELECT 
		cr.id,cr.id AS crid,cr.level_id,cr.section_id,cr.name AS classroom,
		l.name AS level,sec.name AS section,cr.acid,
		l.is_ps,l.is_gs,l.is_hs,l.is_k12,	
		ctp.ctp,c.account AS login,c.code AS teacher_code,c.name AS teacher,
		aq.is_finalized_q1,aq.is_finalized_q2,aq.is_finalized_q3,aq.is_finalized_q4
	FROM   {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
		LEFT JOIN {$dbo}.`00_ctp` ON cr.acid = ctp.contact_id
		LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON aq.crid = cr.id
	WHERE cr.id = '$crid' LIMIT 1 
";
// pr($q);
$sth = $this->db->querysoc($q);
return $sth->fetch();

}	/* fxn */




/* for editStudent  */
public function getStudent($scid,$dbg=PDBG){
	
	$q  = " 
		SELECT 
			c.id AS contact_id,c.code AS student_code,c.name AS student,c.is_active AS status,
		FROM {$dbg}.05_students AS s 
			INNER JOIN {$dbo}.`00_contacts` AS c ON s.contact_id = c.id
		WHERE c.id = '$contact_id' LIMIT 1
	";
	
	$sth = $this->db->querysoc($q);
	return $sth->fetch();	
}	/* getStudent */

public function getCourses($crid,$dbg=PDBG){
		
	$q = "
		SELECT 
			crs.id AS course_id,crs.name AS course,
			sub.code AS subject
		FROM {$dbg}.05_courses AS crs
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		WHERE 
				crs.crid = '$crid'
			AND crs.crstype_id		 = '1'				
		ORDER BY crs.position		
	"; 
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();	
	
}	/* fxn */


public function grade($grade_id,$dbg=PDBG){ 
	
$q  = "
	SELECT 
		c.id AS scid,c.code AS student_code,c.name AS student,
		crs.name AS course,			
		g.*,g.id AS gid,g.scid,
		sum.id AS sumid
	FROM {$dbg}.50_grades AS g 
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
		INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id 
		INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = g.scid 
	WHERE 
		g.id = '$grade_id' LIMIT 1 ";	
	$sth = $this->db->querysoc($q);
	return $sth->fetch();

}	/* fxn */




public function readStudent($id,$dbg=PDBG){	

	$q = "
			SELECT 
				c.id,c.name,c.code,ctp.ctp AS pass,c.is_active AS status,c.is_active,c.is_cleared,
				s.is_sectioned,
				c.`sy`,
				c.crid AS crid,
				c.is_male,
				cr.acid AS acid
			FROM {$dbg}.05_students AS s
				LEFT JOIN {$dbg}.05_classrooms AS cr ON s.crid = cr.id			
				LEFT JOIN {$dbo}.`00_contacts` AS c ON s.contact_id = c.id			
				LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id			
				LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id			
			WHERE c.id = $id LIMIT 1

		";
		// pr($q); exit;
	$sth = $this->db->querysoc($q);
	return $sth->fetch(); 				
}	/* fxn */

/* like sessionizeStudent */
public function readOneStudent($scid,$dbg=PDBG){	
	$q = "
		SELECT 
			p.*,s.*,
			c.id AS contact_id,c.name,c.account,
			c.code AS student_code,ctp.ctp AS pass,c.is_active AS status 			
		FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			INNER JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id						
		WHERE c.id = '$scid'
		LIMIT 1;
	";
	$sth = $this->db->querysoc($q);
	return $sth->fetch(); 				
}	/* fxn */



public function getStudentLevel($scid,$dbg=PDBG){	
	$q = " 
		SELECT
			c.id,c.crid AS crid,c.`sy`,cr.level_id
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		WHERE c.id = '$scid' ;
	";
	
	$sth = $this->db->querysoc($q);
	return $sth->fetch();
		

}	/* fxn */


/* registrars/reports */
public function getClassroomsByDepartment($ps=1,$gs=0,$hs=0,$dbg=PDBG){
	
$cond = " l.`is_ps` = '$ps'  ";
if($ps){ $cond = " l.`is_ps` = '1'  "; } 
if($gs){ $cond .= " OR l.`is_gs` = '1'  "; } 
if($hs){ $cond .= " OR l.`is_hs` = '1'  "; } 


$q = " 
	SELECT 
		cr.id,cr.name,cr.level_id,cr.section_id,
		l.name AS level,l.is_k12,l.is_ps,l.is_gs,l.is_hs,
		sec.name AS section
	FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
	WHERE $cond
	ORDER BY cr.level_id ASC; 
";

// pr($q);	exit;
$sth	= $this->db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



public function sessionizeRegistrar($dbg){
	require_once(SITE."functions/depts.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize.php");
	$db =& $this->db;

	$ucid 			= $_SESSION['user']['ucid'];

	/* 1 - departments */
	$q = " SELECT * FROM {$dbo}.`88_contacts_departments` WHERE `contact_id` = '$ucid'; ";
	$sth = $this->db->querysoc($q);
	$data['department'] = $dept = $sth->fetch();
	
	$depts = deptsPush($dept,$depts=array());
	
	/* 2 - levels */
	if(!empty($depts)){
		$q = " SELECT l.id,l.name FROM {$dbo}.`05_levels` AS l ";
		$q .= " WHERE ";
		foreach($depts AS $dept){
			$q .= " l.department_id = '$dept' OR ";
		}
		$q = rtrim($q," OR ");
		$q .= " ORDER BY l.id ASC; ";
		$sth = $this->db->querysoc($q);
		$levels = $data['levels'] = $sth->fetchAll();
	} else {
		$levels = $data['levels'] = array();
	}

	/* 3 - classrooms */

	if(!empty($depts)){
		$q = "
			SELECT 
				cr.id,cr.name,cr.level_id,cr.section_id,
				l.name AS level,l.is_k12,l.is_ps,l.is_gs,l.is_hs,
				sec.name AS section
			FROM {$dbg}.05_classrooms AS cr
				LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
				LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id			
		";
		$q .= " WHERE ";
		foreach($depts AS $dept){
			$q .= " l.department_id = '$dept' OR ";
		}
		$q = rtrim($q," OR ");

		$q .= " ORDER BY l.id ASC; ";
		$sth = $this->db->querysoc($q);
		$classrooms = $data['classrooms'] = $sth->fetchAll();
	} else {
		$classrooms = $data['classrooms'] = array();
	}
		
	unset($_SESSION['courses_locked']);	/* for registrars-gradebook */
			
	/* ================================================================================= */
			
	$data['num_classrooms'] = count($data['classrooms']);
	$data['num_levels'] 	= count($data['levels']);
	$data['crids']	= buildArray($data['classrooms'],'id');	
	
		
	sessionizeSettingsGis($db,$dbg);
	if($_SESSION['settings']['has_axis']){
		require_once(SITE."functions/sessionize_account.php");
		sessionizeAccount($db);	
	}
	$this->urooms($ucid);
	sessionizeInfo();
	
	/* 4 */
if(($_SESSION['user']['role_id']==RREG) && ($_SESSION['user']['privilege_id']==2)){ 
	$_SESSION['user']['home']='registration'; $_SESSION['home']='registration'; 
}	
	
	$_SESSION['registrar']	= $data;

		
}	/* fxn */





public function generateCode($dbg,$sy=NULL,$role_id=NULL,$prefix=NULL,$delim='-',$numchar=4){

$sy 		= isset($sy)? $sy : date('Y');
$with_role 	= isset($role_id)? " AND `role_id` = '$role_id' " : NULL;
$code = '';
if(is_null($prefix)){
	$prefix 	= substr($sy,2,2);		
}

$q 		= " SELECT count(id) AS `num` FROM {$dbo}.`00_contacts` WHERE `year` = '$sy' $with_role LIMIT 1; ";
// pr($q);
$sth	= $this->db->querysoc($q);
$row 	= $sth->fetch();
$nxtnum = $row['num']+1;

$char = '';
for($i=0;$i<$numchar;$i++) $char.= '0';

$numnxtnum 	= strlen($nxtnum);

$suffix = '';
if($numchar>$numnxtnum){ 
	$numzero = $numchar - $numnxtnum; 
	for($i=0;$i<$numzero;$i++) $suffix .= '0';
	$suffix .= $nxtnum;
} else {
	$suffix = $nxtnum;
} 


$code .= $prefix.$delim.$suffix;
return $code;

}	/* fxn */






public function student_only($dbg,$scid,$fields=NULL){	/* for armcontroller-sectioner registration */

	$q = " 
		SELECT 		
			c.`id` AS `scid`,c.`code` AS `student_code`,c.`name` AS `student`,
			p.first_name AS fname,p.middle_name AS mname,p.last_name AS lname,						
			cr.*,cr.name AS classroom,cr.id AS crid,cr.acid AS acid,
			l.*,l.name AS level,
			sec.name AS section,
			p.*,s.*,c.*
			$fields		
		FROM {$dbo}.`00_contacts` AS `c`
			LEFT JOIN {$dbg}.05_students AS `s` ON s.`contact_id` = c.`id`
			LEFT JOIN {$dbo}.`00_profiles` AS `p` ON p.`contact_id` = c.`id`			
			LEFT JOIN {$dbg}.`05_summaries` AS `summ` ON summ.`scid` = c.`id`
			LEFT JOIN {$dbg}.05_classrooms AS `cr` ON summ.`crid` = cr.`id`
			LEFT JOIN {$dbo}.`05_levels` AS `l` ON cr.`level_id` = l.`id`
			LEFT JOIN {$dbo}.`05_sections` AS `sec` ON cr.`section_id` = sec.`id`
		WHERE 
			c.`id` 	= '$scid' 
		LIMIT 1;		
	";	
	// pr($q);
	$sth = $this->db->querysoc($q);
	return $sth->fetch();	


}	/* fxn */




public function getQuarterMonths($dbg=PDBG){
	$q = " select * from {$dbo}.`05_months_quarters` ";
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */




/* getlevelstudents */
public function gls($level_id,$limit=500,$dbg=PDBG){	

$q = "SELECT
		c.id,c.account,c.name
	FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_students AS s on s.contact_id = c.id
		INNER JOIN {$dbg}.05_classrooms AS cr on s.crid = cr.id
	WHERE cr.level_id = '$level_id' LIMIT $limit;
";

$sth = $this->db->querysoc($q);
return $sth->fetchAll();

} 	/* fxn */





public function getClassroomAdviser($crid,$dbg=PDBG){
	$q = " SELECT acid AS acid FROM {$dbg}.05_classrooms AS cr WHERE `id` = '$crid' LIMIT 1; ";
	$sth = $this->db->querysoc($q);
	$row = $sth->fetch();
	return $row['acid'];
}	/* fxn */



public function levelyear($dbg,$sy,$lvlid,$male=2,$order="c.name",$fields=NULL,$filter=NULL,$limits=NULL,$active=0){
	$dbo=PDBO;
	$condactive = ($active==1)? " AND c.is_active =  1 ":NULL; 
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$limited = (is_null($limits))? '' : "LIMIT $limits";

	$q = "
		SELECT $fields  sum.*,sum.`id` AS sumid,sx.*,cr.`acid` AS acid,cr.`name` AS classroom,
			c.`is_male`,c.`id` AS scid,c.`code` AS student_code,c.`name` AS student,
			sum.`crid` AS crid,sum.`prevcrid` AS prevcrid,c.`sy` AS sy	
		FROM {$dbg}.`05_summaries` AS sum
			INNER JOIN {$dbg}.`05_summext` AS sx ON sum.scid = sx.scid
			INNER JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON sum.scid = p.contact_id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
		WHERE cr.level_id = '$lvlid' $condactive $is_male $filter ORDER BY $order $limited ;	";
	debug($q,"levelyear");		
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */




/*  trash below */



} 	/* RegistrarModel */



