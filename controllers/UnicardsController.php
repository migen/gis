<?php

Class UnicardsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Unicards";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function crid($params=NULL){
$dbo=PDBO;
	reqFxn("unicardsFxn");
	if(!isset($params[1])){ pr("Params crid and level NOT set."); exit; }
	$data['crid']=$crid=$params[0];
	$data['lvl']=$lvl=$params[1];
	$data['sem']=$sem=isset($params[2])? $params[2]:$_SESSION['settings']['semester'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$limit=NULL;
	if(isset($_GET['debug'])){ $limit=1; }
	if(isset($_GET['limit'])){ $limit=$_GET['limit']; } 
	$data1=getData($db,$dbg,$crid,$lvl,$sem,$limit);
	$data=array_merge($data,$data1);
	
	


	$sch=VCFOLDER;$vfile="customs/{$sch}/rcard_uni";vfile($vfile);
	$this->view->render($data,$vfile);
	
	
	
}	/* fxn */











}	/* BlankController */
