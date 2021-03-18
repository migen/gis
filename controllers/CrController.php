<?php

/* college classrooms */
Class CrController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'cr/indexCr');
}	/* fxn */


public function all(){
	require_once(SITE.'functions/crFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	$d=getCrList($db,$dbg);
	$data['rows']=$d['rows'];
	$data['count']=$d['count'];
	// $data['srid']=$_SESSION['srid'];
	/* 2 */
	if(!isset($_SESSION['branches'])){  $_SESSION['branches']=fetchRows($db,"{$dbo}.`00_branches`","*","id"); }
	$data['branches']=$_SESSION['branches'];

	$this->view->render($data,'cr/allCr');
}	/* fxn */



public function edit($params){
	require_once(SITE.'functions/crFxn.php');
	require_once(SITE.'functions/dbFxn.php');
	require_once(SITE.'functions/dbtools.php');
	$data['crid']=$crid=$params[0];
	$db=&$this->baseModel->db;
	$dbg=PDBG;$dbo=PDBO;
	
	/* 1 */
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		// pr($post);
		$db->update("{$dbg}.05_classrooms",$post,"id='$crid'");
		flashRedirect("cr/view/$crid","Saved.");		
		exit;
		
	}	/* post */
	
	
	/* 2 */
	$data['row']=getClassroomData($db,$dbg,$crid);
	$vfile="cr/editCr";
	vfile($vfile);
	
	/* 3 */
	$schema=$dbg;$table="05_classrooms";	
	sessionizeColumnsOfDbtable($db,$dbg,$table,"classrooms",$except="'id'");
	$data['cols']=$_SESSION['cols']['classrooms'];
	
	$this->view->render($data,$vfile);
	
	
}	/* fxn */


public function sessionizeLSM(){
	require_once(SITE.'functions/sessionize_lsm.php');
	$db=&$this->baseModel->db;$dbo=PDBO;
	sessionizeLSM($db,PDBG);
	flashRedirect("cr","Reset LSM");
	
}	/* fxn */


public function view($params){
	require_once(SITE.'functions/crFxn.php');
	require_once(SITE.'functions/dbFxn.php');
	$data['crid']=$crid=$params[0];
	$db=&$this->baseModel->db;
	$dbg=PDBG;$dbo=PDBO;
	
	
	/* 2 */
	$data['row']=getClassroomInfo($db,$dbg,$crid);
	$vfile="cr/viewCr";
	vfile($vfile);
	
	/* 3 */
	$schema=$dbg;$table="05_classrooms";
	$data['columns']=getDbtableColumns($db,$schema,$table);
	$data['columns_array']=explode(",",$data['columns']);
	

	$this->view->render($data,$vfile);
	
	
}	/* fxn */


public function add(){
	require_once(SITE."functions/crFxn.php");
	$db=&$this->baseModel->db;
	$dbg=PDBG;$dbo=PDBO;

	if(isset($_POST['submit'])){
		$posts=$_POST['post'];
		$last_id=$_POST['last_id'];
		$table="{$dbg}.05_classrooms";
		foreach($posts AS $post){ $db->add($table,$post); }
		
		/* 2 */
		$q="UPDATE {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
			SET cr.name=CONCAT(l.`code`,'-',s.`code`),cr.label=s.`name` 
			WHERE cr.id>'$last_id';			
		";
		$db->query($q);
		flashRedirect("cr","Classrooms added.");		
		exit;
		
	}	/* post */


	/* 1.5 */
	if(!isset($_SESSION['lsm'])){
		require_once(SITE.'functions/sessionize_lsm.php');
		sessionizeLSM($db,PDBG);
				
	}	/* session */
	$data['levels']=$_SESSION['lsm']['levels'];
	$data['sections']=$_SESSION['lsm']['sections'];

	$dbtable="{$dbg}.05_classrooms";
	$data['crid']=lastId($db,$dbtable);
	
	$this->view->render($data,"cr/addCr");	
	
}	/* fxn */




public function ltd($params){
require_once(SITE."functions/details.php");
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
$data['classroom']=$classroom=getClassroomDetails($db,$crid,$dbg);

if(isset($_POST['submit'])){
	unset($_POST['submit']);$post=$_POST;
	$db->update("{$dbg}.05_classrooms",$post," `id` = '$crid'  ");
	$url="cr/view/$crid";
	flashRedirect($url,'Classroom edited.');
}	/* post */

$data['is_active']=$classroom['is_active'];
$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","*","id");
$data['sections']=fetchRows($db,"{$dbo}.`05_sections`","*","code");
$data['majors']=fetchRows($db,"{$dbo}.`05_majors`","*","code");

$this->view->render($data,'cr/ltdCr');


}	/* fxn */



public function level($params=NULL){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/contactsFxn.php");

	$lvl=isset($params[0])? $params[0] : 1;
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	
	$data['level']=getLevelDetails($db,$lvl,$dbg);	
	$cond = isset($_GET['all'])? NULL:" AND cr.level_id = '$lvl'";	
	$q = "SELECT a.name AS adviser,cr.id AS crid,cr.num,
			s.id AS sxn,s.name AS section,s.code AS scode,
			count(summ.crid) AS num_students
			FROM {$dbg}.05_classrooms AS cr 
				LEFT JOIN {$dbg}.05_summaries AS summ ON summ.crid = cr.id
				LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id = s.id
				LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
				LEFT JOIN {$dbo}.`00_contacts` AS a ON cr.acid = a.id
			WHERE 1=1 $cond GROUP BY cr.id ORDER BY l.id,s.name LIMIT 100";
			// pr($q);
	debug($q);
	$sth = $db->querysoc($q);		
	$data['rows'] = $sth->fetchAll();	
	$data['count']=$sth->rowCount();
	$data['lvl']=&$lvl;

		
	$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name",$order="id");

	$this->view->render($data,'cr/levelCr');

}	/* fxn */


public function tmps(){
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="SELECT * FROM {$dbg}.05_classrooms WHERE section_id=1 ORDER BY level_id; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	$this->view->render($data,"cr/tmpsCr");
	
}	/* fxn */


public function resetTmps(){
	require_once(SITE."functions/classrooms.php");	
	$db=&$this->baseModel->db;$dbg=PDBG;
	$_SESSION['tmp_classrooms']=tmpClassrooms($db,$dbg);	
	flashRedirect("","Reset Classroom Tmps");	
}




}	/* BlankController */
