<?php

Class FposController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	$acl = array(array(RMIS,0),array(RINVIS,0),array(RADMIN,0));
	$this->permit($acl,0);				
	
}	/* fxn */

public function index(){


	$data=NULL;$this->view->render($data,'fpos/indexFpos');
}	/* fxn */


public function student($params=NULL){
	$dbo=PDBO;	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$order=isset($_GET['order'])? $_GET['order']:"p.id DESC";
	$q="SELECT p.*,c.name AS student
		FROM {$dbo}.`30_pos` AS p 
		INNER JOIN {$dbo}.`00_contacts` AS c ON p.ccid=c.id
		WHERE p.ccid='$scid' ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);

	$this->view->render($data,'fpos/studentFpos');



}	/* fxn */




}	/* BlankController */
