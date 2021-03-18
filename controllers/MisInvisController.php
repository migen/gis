<?php
Class MisInvisController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
}	/* fxn */



public function setYear($params=NULL){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	
	$tbl=isset($_GET['tbl'])? $_GET['tbl']:'30_po';
	$dt=isset($_GET['dt'])? $_GET['dt']:'date';
	
	$q="
		UPDATE {$dbg}.{$tbl} AS a 
		INNER JOIN (
			SELECT id,IF((month($dt)<6),year($dt)-1,year($dt)) AS dbsy FROM {$dbg}.{$tbl}
		) AS b ON a.id=b.id
		SET a.dbsy=b.dbsy; ";
	// pr($q);
	$data['q']=$q;
	
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'mis/blank');
	

}	/* fxn */


public function setDateTime($params=NULL){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;	
	$tbl=isset($_GET['tbl'])? $_GET['tbl']:'30_po';
	$dt='datetime';
	
	$q="
		UPDATE {$dbg}.{$tbl} AS a 
		INNER JOIN (
			SELECT id,date(datetime) AS date,time(datetime) AS time FROM {$dbg}.{$tbl}
		) AS b ON a.id=b.id
		SET a.date=b.date,a.time=b.time ; ";
	// pr($q);
	$data['q']=$q;
	
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'mis/blank');
	

}	/* fxn */





 
} 	/* MisController */

