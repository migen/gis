<?php

Class TerminalsController extends Controller{	

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
	$q  	= " SELECT * FROM {$dbg}terminals ; ";
	$sth 	= $this->model->db->querysoc($q);
	$data['terminals'] = $sth->fetchAll();
	$data['numrows'] = count($data['terminals']);
	$this->view->render($data,'terminals/index');
}	/* fxn */


public function edit($params=NULL){
$dbo=PDBO;
	$tid = $params[0];
	if(isset($_POST['submit'])){
		$row = $_POST['terminal'];
		$this->model->db->update(DBO.".`terminals`",$row," `id` = '".$row['id']."' ");	
		$this->model->db->query($q);
		$url = "mis/terminals";
		redirect($url);
		exit;		
	} /* post */


	$q   = "SELECT * FROM {$dbo}.terminals WHERE `id` = '$tid'  LIMIT 1; ";
	$sth = $this->model->db->querysoc($q); 
	$data['terminal'] = $sth->fetch();
	$this->view->render($data,'terminals/edit');

}	/* fxn */







}	/* TerminalsController */
