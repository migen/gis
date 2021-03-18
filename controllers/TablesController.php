<?php

Class TablesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index($params=NULL){
require_once(SITE.'views/elements/incs_reflection.php');pr($data);

$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$limit=isset($_GET['limit'])? $_GET['limit']:10;
/* 1 */
$q="SELECT * FROM {$dbo}.00_contacts WHERE `id`=`parent_id` LIMIT $limit; ";
pr($q);
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$data['rows']=&$rows;
$data['count']=count($rows);
$this->view->render($data,'tables/indexTables');

}	/* fxn */


public function layout(){ 
	$data=NULL;
	$this->view->render($data,"tables/layoutTables","empty");

 }	/* fxn */
 
 



} 	/* Controller */