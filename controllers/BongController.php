<?php

Class BongController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	
	$cond="";
	if(isset($_GET['who'])){ $cond=" AND who='".$_GET['who']."'"; }
	$q=" SELECT * FROM {$dbg}.`80_dreams` WHERE 1=1 $cond; ";
	if(isset($_GET['debug'])){ pr($q); }
	$sth=$db->query($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);

	
	$this->view->render($data,'bong/indexBong');
	

}	/* fxn */


public function dbinit($params=NULL){
require_once(SITE.'functions/dbinit_axis.php');
$db=&$this->model->db;
if(isset($params[0])){
	dbinit_axis($db);
}



}	/* fxn */




}	/* BlankController */
