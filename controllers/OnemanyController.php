<?php

Class OnemanyController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	
	// $data="Onemany";	
	// dbo.00_onemany - id,scid,major_id
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$q="
		SELECT c.name AS student,om.*,m.name AS major
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbo}.00_onemany AS om ON om.scid=c.id 
		INNER JOIN {$dbo}.00_majors AS m ON om.major_id=m.id 
		GROUP BY om.scid
	";
	
	$q="
		SELECT c.name AS student,om.*,m.name AS major,count(om.id) AS `count`
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbo}.00_onemany AS om ON om.scid=c.id 
		INNER JOIN {$dbo}.00_majors AS m ON om.major_id=m.id 
		GROUP BY om.scid ORDER BY om.scid
	";	
	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	$this->view->render($data,'onemany/indexOnemany');
	
}	/* fxn */












}	/* BlankController */
