<?php

Class FeetypesController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	$acl = array(array(5,0),array(2,0),array(9,0));
	$this->permit($acl);					
}	/* fxn */

public function index(){
	pr("feetypes");
	
}	/* fxn */



public function table($params=NULL){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$order=isset($_GET['order'])? $_GET['order']:"f.parent_id,f.position,f.name";
	$q="SELECT f.*,f.id AS feetype_id,f.name AS feetype,pf.name AS supfeetype,f.id AS pkid
		FROM {$dbo}.03_feetypes AS f 
		LEFT JOIN {$dbo}.03_feetypes AS pf ON f.parent_id=pf.id
		ORDER BY $order;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"feetypes/tableFeetypes");
	

}	/* fxn */






}	/* BlankController */
