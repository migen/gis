<?php

Class CashiersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	echo "cashiers index";
	// $this->view->render($data,'tests/index');

}	/* fxn */


public function add(){
	
	
	$data=NULL;
	$this->view->render($data,'cashiers/add');
}	/* fxn */



public function pay(){
	$dbo=PDBO;
	$db=&$this->model->db;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		pr($_POST);
		exit;
	}	/* fxn */
	
	$data['feetypes'] = (isset($_SESSION['feetypes']))? $_SESSION['feetypes']:fetchRows($db,"{$dbo}.`03_feetypes`","*","name");
	$this->view->render($data,'cashiers/pay');

}	/* fxn */




























}	/* CashiersController */
