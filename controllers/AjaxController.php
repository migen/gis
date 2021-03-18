<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

Class AjaxController extends Controller{

public function __construct(){
	parent::__construct();
	parent::beforeFilter();	
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	 
	
	/* $this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','accounts/js/parent.js');	 */
	
}


public function beforeFilter(){}
public function index(){ }	/* fxn */


public function add($params=NULL){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbtable=isset($params[0])? $params[0]:"{$dbo}.`00_roles`";
	$data['dbtable']=$dbtable;
	$data['rows']=fetchRows($db,$dbtable,"id,code,name","id DESC");
	$this->view->render($data,"ajax/addAjax");
	
}	/* fxn */


public function keyup(){	
	$data=NULL;
	$this->view->render($data,"ajax/keyupAjax");
	
}	/* fxn */


public function sajax(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	
	if(!isset($_SESSION['contacts'])){
		$_SESSION['contacts']=fetchRows($db,"{$dbo}.`00_contacts`",$fields='id,code,name');
	}
	
	$data=NULL;
	$vfile="ajax/sajaxAjax";vfile($vfile);$data=NULL;
	$this->view->render($data,$vfile);

	
}	/* fxn */


public function student($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	if(isset($_POST['submit'])){
		pr($_POST);
		exit;
	}	/* post */
		
	$vfile="ajaxlab/studentAjax";vfile($vfile);$data=NULL;
	$this->view->render($data,$vfile);
}	/* fxn */




public function roles(){ 

$db=&$this->baseModel->db;$dbo=PDBO;
if(!isset($_SESSION['roles'])){
	pr("Roles var not set, setting it now.");
	$q="SELECT * FROM {$dbo}.`00_roles` ORDER BY name;";
	$sth=$db->querysoc($q);
	$_SESSION['roles']=$sth->fetchAll();		
} 

$data['roles']=$_SESSION['roles'];

$this->view->render($data,"ajax/rolesAjax");

}	/* fxn */







public function json(){ 

	$q="SELECT * FROM {$dbo}.`00_contacts` WHERE `role_id`=7 LIMIT 3; ";
	$sth=$this->model->db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	// echo json_encode($row);
	$data=isset($data)? $data:NULL;	
	$this->view->render($data,'ajax/jsonAjaxtry');
	 

}




public function xgetContact(){
	$ucid = isset($_POST['ucid'])? $_POST['ucid']:1;
	$q = " SELECT * FROM {$dbo}.`00_contacts` WHERE `id` = '$ucid' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	$_SESSION['q'] = $q;
	echo json_encode($row);

}	/* fxn */


public function xupdateSubmitted($params){
	$crsid = $params[0];
	$date = $_POST['date'];
	$qtr  = $_POST['qtr'];
	$q = "UPDATE {$dbg}.05_courses_quarters SET `finalized_date_q$qtr` = '$date' WHERE `course_id` = '$crsid' LIMIT 1; ";
	$this->baseModel->db->query($q);
	$_SESSION['q'] = $q; 

}

public function xgetStudentCrid($params){
	$scid = $params[0];
	$q = " SELECT `crid` AS `crid` FROM {$dbg}.05_students WHERE `contact_id` = '$scid' LIMIT 1; ";
	$sth = $this->baseModel->db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
}	/* fxn */




public function xcrid($params=NULL){	
	include_once(SITE.'views/elements/params_sq.php');
	$crid = $_POST['crid'];	
	$q = " 
		SELECT 
			l.id AS lvlid,l.code AS lvlcode,l.department_id AS deptid,
			cr.acid AS acid
		FROM {$dbg}.05_classrooms AS cr
			INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		WHERE cr.id = '$crid' LIMIT 1;	
	";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
}	/* fxn */












}	/* AjaxController */