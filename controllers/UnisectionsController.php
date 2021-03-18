<?php

Class UnisectionsController extends Controller{	

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
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="SELECT * FROM {$dbg}.01_sections ORDER BY name; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	$this->view->render($data,"unisections/setUnisections");
}	/* fxn */



public function edit($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ echo "Parameter section id NOT set."; exit; }
	$data['sxn']=$sxn=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbg}.01_sections",$post,"id='$sxn'");
		flashRedirect("unisections/edit/$sxn","Saved.");
	}	/* post */
	$q="SELECT * FROM {$dbg}.01_sections WHERE `id`='$sxn' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	$this->view->render($data,"unisections/editUnisection");
	
}	/* fxn */


public function add(){
$dbo=PDBO;
	$data['db']=&$this->baseModel->db;
	$this->view->render($data,"unisections/addUnisections");	
}	/* fxn */






}	/* BlankController */
