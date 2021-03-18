<?php

Class PrerequisitesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index0(){
	
	$data="prerequisites";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function index(){	/* course prerequisites */
$dbo=PDBO;
	require_once(SITE.'functions/prerequisitesFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;	
/* 	1) courses - id,subject_id,crid,tcid,name
	2) prerequisites - id, subject_id, parent_id (many to many) */	
	
	
	$data=getPrerequisites($db,$dbg);	
	$data['subjects']=getSubjects($db,$dbg);	
		
	$vfile="prerequisites/indexPrerequisites";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */


public function edit($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ pr("Parameter 'subject_id' NOT set. "); exit; }
	$data['sub']=$sub=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$psub=$_POST['psub'];
		$q="INSERT INTO {$dbg}.01_prerequisites(subject_id,parent_id)VALUES('$sub','$psub'); ";
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Fail";
		flashRedirect("prerequisites/edit/$sub",$msg);		
	}	/* post */
	
	$q="SELECT
			pr.*,pr.id AS prid,ps.name AS prerequisite
		FROM {$dbg}.01_prerequisites AS pr 
		LEFT JOIN {$dbo}.`05_subjects` AS ps ON pr.parent_id=ps.id
		WHERE pr.subject_id = '$sub';";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$q="SELECT * FROM {$dbo}.`05_subjects` WHERE id='$sub' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['subject']=$sth->fetch();	
	
	$this->view->render($data,"prerequisites/editPrerequisite");
	
	
}	/* fxn */












}	/* BlankController */
