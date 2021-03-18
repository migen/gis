<?php

Class ChineseController extends Controller{	

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
$data['sy']=$_SESSION['sy'];
$data['qtr']=$_SESSION['qtr'];
$db =& $this->model->db;$dbg=PDBG;
$data['crid']=$crid=isset($_GET['crid'])? $_GET['crid']:false;
if($crid){
	require_once(SITE."functions/chinese.php");	
	$data['row'] = getChineseCourse($db,$crid); 
	$srid=$_SESSION['srid'];
	if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  flashRedirect('teachers'); } }
		
	
} 

$this->view->render($data,"chinese/index");

}	/* fxn */


public function test($params){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$id=isset($params[0])? $params[0]:1;
	$dbo="00_lab";
	$q="SELECT * FROM {$dbo}.`00_contacts` WHERE id=$id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['q']=$q;
	$data['row']=$sth->fetch();
	
	$this->view->render($data,"chinese/testChinese");
	
	
	
}









}	/* ChineseController */
