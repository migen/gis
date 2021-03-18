<?php

Class IdController extends Controller{	

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
	echo "ID Controller";
	$this->view->render($data=NULL,"id/indexID");

}	/* fxn */



public function tracer(){
require_once(SITE."functions/id.php");
$db=&$this->model->db;
$dbo=PDBO;
$dbtable="{$dbo}.`00_contacts`";

$rows=array();
if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	foreach($posts AS $code){
		$rows[] = getIdByCode($db,$dbtable,$code);
	}
	
}	/* fxn */

$data['count'] = count($rows);
$data['rows'] = $rows;
$this->view->render($data,'id/tracer');

}	/* fxn */


public function finder(){
	$dbo=PDBO;		
	$db=&$this->baseModel->db;$dbg=PDBG;
	$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
	$data['row']['level_id']=4;
	$this->view->render($data,"id/finderID");
	
}	/* fxn */




















}	/* IDController */
