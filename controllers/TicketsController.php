<?php

Class TicketsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
$dbo=PDBO;
	$data['home']	= $_SESSION['home'];
	$is_mis = ($_SESSION['srid']==RMIS)? true:false;
	$ssy = $_SESSION['sy'];
	$sy = isset($_GET['sy'])? $_GET['sy']:$ssy;
	$dbo = PDBO;	
	$dbg = ($is_mis)? VCPREFIX.$sy.US.DBG:PDBG;
	$dbg = 	($is_mis)? VCPREFIX.$sy.US.DBG:PDBG;

if(isset($_GET['filter'])){
	$sort = (isset($_GET['sort']))? $_GET['sort']:'t.created';
	$order = (isset($_GET['order']))? $_GET['order']:'DESC';
	$page = (isset($_GET['page']))? $_GET['page']:1;
	$limits = (isset($_GET['limits']))? $_GET['limits']:20;
	$offset = ($page-1)*$limits;
	$cond = "";
	$cond .= ((isset($_GET['is_done'])) && ($_GET['is_done']<2))? "AND t.is_done = '".$_GET['is_done']."' ":NULL;
	if (!empty($_GET['ecid'])){ $cond .= " AND t.ecid = '".$_GET['ecid']."'"; }				
	$q = "
		SELECT
			c.name AS employee,s.name AS student,
			t.*,a.name AS action,t.id AS tid,
			cq.is_finalized_q1 AS crs_fq1,cq.is_finalized_q2 AS crs_fq2,cq.is_finalized_q3 AS crs_fq3,
			cq.is_finalized_q4 AS crs_fq4,cq.is_finalized_q5 AS crs_fq5,cq.is_finalized_q6 AS crs_fq6,
			aq.is_finalized_q1 AS adv_fq1,aq.is_finalized_q2 AS adv_fq2,aq.is_finalized_q3 AS adv_fq3,
			aq.is_finalized_q4 AS adv_fq4,aq.is_finalized_q5 AS adv_fq5,aq.is_finalized_q6 AS adv_fq6,
			cr.name AS classroom,crs.name AS course
		FROM {$dbg}.tickets AS t
			LEFT JOIN {$dbo}.`00_actions` AS a ON t.action_id = a.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON t.ecid = c.id
			LEFT JOIN {$dbo}.`00_contacts` AS s ON t.scid = s.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON t.crid = cr.id
			LEFT JOIN {$dbg}.05_courses AS crs ON t.crsid = crs.id
			LEFT JOIN {$dbg}.05_courses_quarters AS cq ON t.crsid = cq.course_id
			LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON t.crid = aq.crid				
		WHERE 1=1 $cond
	";
	
	$admins = array(RMIS,RACAD);
	$srid = $_SESSION['srid'];
	if(!in_array($srid,$admins)){
		$ucid = $_SESSION['ucid'];
		$q .= " AND t.ecid = '$ucid'; ";	
	}	
	
	$q .= "ORDER BY $sort $order LIMIT $limits; ";
	// pr($q);
	
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $rows = $sth->fetchAll();
	$data['count'] = count($rows);
	
	
} 	/* filter */
	
	$this->view->render($data,'tickets/index');

}	/* fxn */


public function add($params=NULL){
$dbo=PDBO;
$ecid = isset($params[0])? $params[0]:$_SESSION['ucid'];
if($_SESSION['srid']!=RMIS){ $ecid = $_SESSION['ucid']; }
$data['ecid'] = $ecid;
$dbg = PDBG;

if(isset($_POST['submit'])){
	$post = $_POST;
	$scid = isset($post['scid'])? $post['scid']:'';
	$crsid = isset($post['course'])? $post['course']:'';
	$crid = isset($post['classroom'])? $post['classroom']:'';
	$axn = isset($post['action'])? $post['action']:'';
	$memo = isset($post['memo'])? $post['memo']:'';
	$qtr = isset($post['qtr'])? $post['qtr']:$_SESSION['qtr'];
	$created = date('Y-m-d H:i:s');

	if($axn>0){
		$q = "INSERT INTO {$dbg}.tickets(`created`,`ecid`,`scid`,`crid`,`crsid`,`action_id`,`qtr`,`memo`) VALUES
			('$created','$ecid','$scid','$crid','$crsid','$axn','$qtr','$memo');";
		$this->model->db->query($q);	
	}
	// pr($q); exit;
	$url = $_SESSION['home'];
	flashRedirect($url,'Ticket added.');

}	/* post */


	$data['axn'] = $_SESSION['axn'];	
if($_SESSION['srid']==RTEAC){
	$data['advisories'] = $_SESSION['teacher']['advisories'];
	$data['courses'] = $_SESSION['teacher']['submitted'];
} else {
	$data['advisories'] = $this->model->fetchRows("{$dbg}.05_classrooms",'id AS crid,name AS classroom','level_id');
	$data['courses'] = $this->model->fetchRows("{$dbg}.05_courses",'id AS course_id,name AS course','name');	
}	/* if teacher */


$data['limits'] = $_SESSION['settings']['limits'];
$this->view->render($data,'tickets/add');

}	/* fxn */



























}	/* TicketsController */
