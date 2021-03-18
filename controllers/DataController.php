<?php

Class DataController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}

/*
1) gis - studentsByLevel, teachers-load, coursesByLevel, componentsByLevel, employees

*/


public function index(){
	// include_once(SITE.'views/elements/params_sq.php');	
	$data=NULL;
	$this->view->render($data,'data/indexData');
}	/* fxn */


public function indexLinks($params=NULL){
	// $data['levels']=$_SESSION['levels'];$data['user']=$_SESSION['user'];
	// $this->view->render($data,'data/index');
	ob_start();
	echo "<h3>Data | ";shovel('links_data');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");
}	/* fxn */



public function levels($params=NULL){
	$dbo=PDBO;
	$data['ssy']			= $ssy	= $_SESSION['sy'];
	$data['sy']				= $sy	= isset($params[0])? $params[0] : $ssy;	
	$dbg	= VCPREFIX.$sy.US.DBG;
	$data['levels'] 	= $this->baseModel->fetchRows("{$dbo}.`05_levels`","*","id");
	$data['num_levels'] = count($data['levels']);
	$vfile='data/levelsData';vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


public function teachers($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/dataFxn.php');
$data['ssy'] = $ssy = $_SESSION['sy'];
$data['sy']  = $sy  = isset($params[0])? $params[0] : $ssy;
$db=&$this->model->db;
$data['teachers'] = $teachers = getAllTeachers($db);
$data['numrows']  = count($teachers);

$this->view->render($data,'data/teachers');

}	/* fxn */



public function classrooms($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/dataFxn.php');
	$data['ssy'] = $ssy = $_SESSION['sy'];
	$data['sy']	 = $sy	= isset($params[0])? $params[0]:$ssy;
	$dbg	= VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
	$data['classrooms'] = getAllClassrooms($db,$dbg);
	$data['numrows']    = count($data['classrooms']);
	$vfile="data/classroomsData";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */



public function studentsOK($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'functions/dataFxn.php');
	$data['lid'] = $lid = isset($params[0])? $params[0] : 4;
	$data['sy'] = $sy 	= isset($params[1])? $params[1] : DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

	$q   = " SELECT * FROM {$dbo}.`05_levels` WHERE `id` = '$lid' LIMIT 1; ";
	$sth = $this->baseModel->db->querysoc($q); 
	$data['level']	= $level = $sth->fetch();

	$wherecond=isset($_GET['all'])? NULL:" AND section_id>2";
	$q   = " SELECT id AS `crid`, name FROM {$dbg}.05_classrooms WHERE `level_id` = '$lid' $wherecond ORDER BY `section_id` DESC ; ";
	debug($q);
	$sth = $this->baseModel->db->querysoc($q);
	$data['classrooms']=$classrooms=$sth->fetchAll();
	$data['numrows']=$numrows=count($classrooms);
	for($i=0;$i<$numrows;$i++){
		$crid = $classrooms[$i]['crid'];
		$students[] = getClassroomStudents($db,$dbg,$crid);
	}
	$data['students']=&$students;

	$sch=VCFOLDER;
	$one="students_{$sch}";$two="data/studentsData";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	pr($vfile);
	
	$this->view->render($data,$vfile);

}	/* fxn */



public function students1($params=NULL){
	$dbo=PDBO;$dbg=PDBG;
	require_once(SITE.'functions/dataFxn.php');
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
		
	
	if(isset($_SESSION['students'])){
		$data['rows']=$_SESSION['students'];
		$data['count']=$_SESSION['num_students'];	
	} else {
		$q="SELECT c.id AS scid,c.code AS studcode,c.name AS student,c.is_male,cr.name AS classroom
			FROM {$dbo}.00_contacts AS c
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE c.role_id=".RSTUD." AND cr.section_id>2
			ORDER BY cr.level_id,cr.section_id,c.is_male,c.name ; ";
		debug($q);
		$_SESSION['message']="List of students sessionized.";
		pr("sessioned students");
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		$count=$sth->rowCount();
		$_SESSION['students']=&$rows;
		$_SESSION['num_students']=&$count;
		$data['rows']=&$rows;
		$data['count']=&$count;			
	}	/* session-students */
	

	$sch=VCFOLDER;
	$one="students_{$sch}";$two="data/studentsData";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	// pr($vfile);
	
	$this->view->render($data,$vfile);

}	/* fxn */




public function students($params=NULL){
	$dbo=PDBO;$dbg=PDBG;
	require_once(SITE.'functions/dataFxn.php');
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;

	$q="SELECT c.id AS scid,c.code AS studcode,c.name AS studname,c.is_male,c.is_active,
			cr.name AS classroom,summ.crid,l.code AS lvlcode,p.birthdate
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE c.role_id=".RSTUD." 
		ORDER BY cr.level_id,cr.section_id,c.is_male,c.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();
	$data['rows']=&$rows;
	$data['count']=&$count;			
	

	$sch=VCFOLDER;
	$one="students_{$sch}";$two="data/studentsData";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	// pr($vfile);
	
	$this->view->render($data,$vfile);

}	/* fxn */




public function classroom($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/reports.php");
	$db =& $this->model->db;

	$crid 	= $params[0];
	$dbg	= PDBG;
	$q   	= " SELECT cr.id AS `crid`, cr.name ,sxn.code AS section_code,sxn.name AS section
		FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`05_sections` AS sxn ON sxn.id = cr.section_id
		WHERE cr.`id` = '$crid' ; ";
	$sth = $this->baseModel->db->querysoc($q);	
	$data['classroom'] 	= $sth->fetch();
	
	$order = "crs.crstype_id,crs.name,crs.id";	
	$data['courses'] = cridCourses($db,$dbg,$crid,$ctype=NULL,$agg=1,$filter=NULL,$elecs=NULL,$limit=NULL,$active=0,$order);	
	
	$this->view->render($data,'data/classroom');

}	/* fxn */



public function loading($params=NULL){
$dbo=PDBO;
$dbg=PDBG;
$db = $this->model->db;
$where="WHERE `role_id`='".RTEAC."' ";
$data['teachers'] = $teachers = $this->model->fetchRows("{$dbo}.`00_contacts`",'id,parent_id,name,id AS tcid','name',$where);

$loads = array();
$counts = array();
$i=0;
foreach($teachers AS $row){
	$q="
		SELECT crs.id AS crsid,crs.name AS course,crs.label AS subject,crs.tcid AS tcid
		FROM {$dbg}.05_courses AS crs WHERE crs.tcid = '".$row['tcid']."';
	";
	$sth=$db->querysoc($q);
	$loads[$i]=$sth->fetchAll();	
	$counts[$i] = count($loads[$i]);	
	$i++;
}	/* fxn */

$data['counts'] = $counts;
$data['loads'] = $loads;

$data['numteacs'] = count($teachers);
$data['subjects'] = $this->model->fetchRows("{$dbo}.`05_subjects`",'id,code,name','name');
$data['numsubs'] = count($data['subjects']);

$this->view->render($data,'data/loading');

}	/* fxn */




public function trsTeachers($params=NULL){
require_once(SITE.'functions/trs.php');
$dbo = PDBO;
$dbg = PDBG;
$db = $this->model->db;

$sort = "level_id,section_id";
$where="WHERE `section_id`<>'1' ";

$q="
	SELECT cr.id AS crid,cr.name AS classroom,crs.id AS trsid,crs.name AS trs,cr.acid AS acid
	FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN (
			SELECT id,name,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."'			
		) AS crs ON crs.crid = cr.id		
	WHERE cr.section_id <> '1'
	ORDER BY cr.level_id,section_id
;";
// pr($q);
$sth = $db->querysoc($q);
$data['classrooms'] = $classrooms = $sth->fetchAll();
$data['numcr'] = $numcr = count($classrooms);

// pr($classrooms); exit;

$trsadvi = $_SESSION['settings']['trs_adviser'];	
$tcid = $_SESSION['ucid'];
$teacs = array();
$counts = array();
$i=0;
$red=null;
for($i=0;$i<$numcr;$i++){	
	$crid = $classrooms[$i]['crid'];
	$teacs[$i] = getTeachersByCrid($db,$crid,$tcid,$trsadvi,$dbo=DBO,$dbg=PDBG);			
	$counts[$i] = count($teacs[$i]);	
}	/* fxn */

$data['counts'] = $counts;
$data['teacs'] = $teacs;
// pr($data); exit;
$this->view->render($data,'data/trsTeachers');

}	/* fxn */



public function rships(){
$dbo=PDBO;
if(isset($_POST['submit'])){
	pr($_POST);
	$one = $_POST['one'];
	$many = $_POST['many'];
	$val = $_POST['val'];
	$oneid = $_POST['oneid'];
	$manyid = $_POST['manyid'];	
	$q = " SELECT 
			b.*
		FROM $one AS a
			LEFT JOIN $many AS b ON a.{$oneid} = b.{$manyid}
		WHERE a.id = $val ;";
	pr($q);
	$sth = $this->model->db->querysoc($q);
	$results = $sth->fetchAll();
	
	// exit;
	
}	/* post */



// $data=NULL;
// $results = array('fdfsd','fdserewr');
$data['results'] = isset($results)? $results:false;
$this->view->render($data,'data/rships');

}	/* fxn */



public function contacts($params=NULL){
	$dbo=PDBO;
	reqFxn('paginationFxn');
	$data['currPage']=$currPage=isset($params[0])? $params[0]:1;
	$data['perPage']=$perPage=1000;
	$db=&$this->baseModel->db;$dbg=PDBG;

	$d=pagination($db,"{$dbo}.`00_contacts`",$perPage,$currPage);
	$data['offset']=$offset=$d['offset'];
	$data['totalCount']=$d['totalCount'];
	$data['totalPages']=$d['totalPages'];
	$data['record_start']=$d['record_start'];
	$data['record_end']=$d['record_end'];

	/* 3 */	
	$q="SELECT c.id,c.code,c.name,c.role_id,summ.crid FROM {$dbo}.`00_contacts` AS c 
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id ORDER BY c.name LIMIT $perPage OFFSET $offset; ";
	$sth=$db->querysoc($q);debug($q);
	$data['rows']=$sth->fetchAll();$data['count']=$sth->rowCount();
	
	$this->view->render($data,"data/contactsData");
	
}	/* fxn */



public function duplicates($params=NULL){ 
$sch=VCFOLDER;$sy=DBYR;
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$q="SELECT scid,count(*) AS numrows
	FROM {$dbg}.{$sch}_ar_{$sy}
	GROUP BY scid HAVING COUNT(numrows) > 1; ";
debug($q); 

pr("&get - dbtable, field, ");

if((!isset($_GET['dbtable']) || (!isset($_GET['field'])))){ pr("Get params required."); exit; }

$field=$_GET['field'];
$dbtable=$_GET['dbtable'];

$q="SELECT $field,count(*) AS numrows
	FROM {$dbtable} GROUP BY $field
	HAVING COUNT(numrows) > 1; ";
pr($q);
$sth = $db->querysoc($q);
$data['duplicates'] = $sth->fetchAll();
$data['count'] = count($data['duplicates']);

pr($data);

echo '<a href="'.URL.'mis/query" >MIS Query</a>';

// $this->view->render($data,'mis/atte_duplicates');


}	/* fxn */


public function nocrid(){
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.($sy-1).US.DBG;
	$q="SELECT
			summ.id AS summscid,c.id AS scid,c.code AS studcode,c.name AS studname,cr.name AS classroom,pcr.name AS pcrname,
			cr.level_id AS currlvl,pcr.level_id AS prevlvl,
			cr.id AS currcrid,pcr.id AS prevcrid			
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$pdbg}.05_classrooms AS pcr ON psum.crid=pcr.id		
		WHERE c.role_id=1 AND summ.crid IS NULL AND psum.crid <> ''; ";
	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	$q="SELECT id,code,name FROM {$dbg}.05_classrooms WHERE level_id=16 AND section_id=1; ";
	$sth=$db->querysoc($q);
	$c1=$sth->fetch();
	$c1_tmp=$c1['id'];

	/* process - g12 prevsy to college - for ledger 20200624 */
	$q="UPDATE {$dbg}.05_summaries AS summ 
		INNER JOIN {$pdbg}.05_summaries AS psum ON summ.scid=psum.scid
		INNER JOIN {$pdbg}.05_classrooms AS pcr ON psum.crid=pcr.id
		SET summ.crid=$c1_tmp WHERE pcr.level_id=15; ";
	pr("&exe");
	pr("Promote G12 to C01");
	pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
	}
		
	$this->view->render($data,"data/nocrid");
	
}	/* fxn */


public function traits($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['lvl']=$lvl=isset($params[0])? $params[0]: 4;
	$data['sy']=$sy=isset($params[1])? $params[1]: DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;
	$order=isset($_GET['order'])? $_GET['order']:'ct.id,cri.name';
	$crstype_id=isset($_GET['crstype_id'])? $_GET['crstype_id']:CTYPETRAIT;
	
	
	$q="SELECT
			comp.id AS pkid,comp.subject_id,sub.name AS subject,cri.position,
			comp.weight,comp.id AS compid,cri.name AS criteria,comp.criteria_id,cri.critype_id,
			ct.name AS critype
		FROM {$dbg}.05_components AS comp
		INNER JOIN {$dbo}.05_criteria AS cri ON cri.id=comp.criteria_id
		INNER JOIN {$dbo}.05_subjects AS sub ON comp.subject_id=sub.id
		LEFT JOIN {$dbo}.05_critypes AS ct ON cri.critype_id=ct.id
		WHERE cri.crstype_id=$crstype_id AND comp.level_id=$lvl
		ORDER BY $order;		
	";
	// pr($q);
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	$data['levels']=$_SESSION['levels'];
	
	
	$this->view->render($data,"data/traitsByLevelData");
}




}	/* DataController */
