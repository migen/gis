<?php

Class UnidataController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="ABC";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */



public function professors(){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="SELECT crs.tcid,c.name AS professor,c.name AS course,count(crs.id) AS numcrs
		FROM {$dbg}.01_courses AS crs 
		INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
		GROUP BY c.id ORDER BY c.name;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	$this->view->render($data,"unidata/professorsUnidata");
	
	
}	/* fxn */


public function students($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$lvlcond=isset($params[0])? " AND summ.level_id=".$params[0]:NULL;
	$order=(isset($_GET['order']) && $_GET['order']=='lvl')? "summ.level_id,c.name":"c.name";
	$q="SELECT c.id AS scid,c.name AS student,c.code AS studcode,summ.level_id AS lvl,summ.crid
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.01_summaries AS summ ON summ.scid=c.id
		WHERE c.role_id=8 $lvlcond ORDER BY $order; "; debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	$this->view->render($data,"unidata/studentsUnidata");
	
}	/* fxn */









}	/* BlankController */
