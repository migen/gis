<?php

Class PosalesController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */



public function rx(){
	echo "return exchange of pos";
	
	if(isset($_POST['submit'])){
		pr($_POST);
		exit;
		
	}	/* post */
	
	$data['home']=$_SESSION['home'];
	$this->view->render($data,'posales/rx');	
}	/* fxn */







}	/* PosalesController */
