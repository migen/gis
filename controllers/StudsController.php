<?php
Class StudsController extends Controller{	


public function __construct(){
	parent::__construct();		
	if($_SESSION['settings']['studlogin']!=1){  redirect('users/logout'); } 
	
}

public function beforeFilter(){
	if($this->only(array())){ $this->view->js = array('js/jquery.js','js/vegas.js'); } 
	parent::beforeFilter();					
	
	
}	/* fxn */


public function index(){
	// pr("studs");
	$data=NULL;
	$this->view->render($data,"studs/indexStud");
	
}


public function classes($params){
	// require_once(SITE."functions/studsFxn.php");
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="SELECT summ.crid
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
		WHERE summ.scid='$scid' LIMIT 1;	
	";
	// pr($q);
	$sth=$db->querysoc($q);
	$student=$sth->fetch();
	$data['crid']=$crid=$student['crid'];
	
	
	$q="SELECT
			c.id AS crs,c.name AS course,c.label,c.crstype_id AS ctype_id,
			ct.name AS ctype,c.with_scores,c.is_aggregate
		FROM {$dbg}.05_courses AS c
		INNER JOIN {$dbo}.`05_crstypes` AS ct ON c.crstype_id=ct.id
		WHERE c.crid='$crid';		
	";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"studs/classesStud");
		
	
}	/* fxn */


public function reqts($params){
$dbo=PDBO;
	$data['scid']=$scid=$params[0];
	$data['crs']=$crs=$params[1];
	$db=&$this->baseModel->db;$dbg=PDBG;	
	$sy=isset($params[2])? $params[2]:$_SESSION['sy'];
	$qtr=isset($params[3])? $params[3]:$_SESSION['qtr'];
	
	$q="SELECT c.name AS course,c.label,cr.name AS classroom
		FROM {$dbg}.05_courses AS c
		INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=c.crid
		WHERE c.id='$crs' LIMIT 1;
	";
	$sth=$db->querysoc($q);
	$data['crsRow']=$sth->fetch();

	/* 2 */	
	$q = "SELECT cri.id AS criteria_id,cri.name AS criteria,cri.code AS criteria_code,
			com.weight,cri.is_raw,a.id AS activity_id,a.name AS activity,a.date AS activity_date,a.max_score,
			sc.score,sc.is_valid
		FROM {$dbg}.50_activities AS a 
		LEFT JOIN   {$dbg}.05_components AS com ON (com.id = a.component_id)
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON (cri.id = com.criteria_id)
		LEFT JOIN {$dbg}.50_scores AS sc ON (a.id = sc.activity_id)
		WHERE a.course_id = '$crs'  AND a.quarter = $qtr AND sc.scid='$scid'
		ORDER BY cri.position,cri.id,a.id; 
	";	
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();


	$this->view->render($data,"studs/reqtsStud");
	
	
}	/* fxn */






} /* StudentsController */
