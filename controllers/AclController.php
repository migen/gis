<?php

Class AclController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			

	if(!$this->only(array('reset'))){ 
		$db=&$this->baseModel->db;
		$url_id=1;	
		$ucid=$_SESSION['ucid'];
		checkAcl($db,$url_id);
	}
	
}	/* fxn */


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'acl/indexAcl');

}	/* fxn */



public function url(){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	$q="SELECT * FROM {$dbo}.url; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);

	$this->view->render($data,'acl/urlIndex');

}	/* fxn */



public function two(){
	$dbo=PDBO;$dbg=PDBG;
	$db=&$this->baseModel->db;
	$q="SELECT * FROM {$dbo}.url; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);

	$this->view->render($data,'acl/urlIndex');

}	/* fxn */


public function reset(){
	$db=&$this->baseModel->db;
	$ucid=$_SESSION['ucid'];
	include_once(SITE.'functions/sessionize_acl.php');sessionizeAcl($db,$ucid); 	
	
}	/* fxn */




}	/* BlankController */
