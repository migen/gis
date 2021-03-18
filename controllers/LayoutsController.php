<?php

Class LayoutsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$dbo=PDBO;	
	$data['controller']="LayoutsController";
	require_once(SITE.'views/elements/incs_reflection.php');

	$methods=$data['methods'];
	$ctlr=str_replace("Controller","",$data['controller']);
	$ctlr=strtolower($ctlr);
	pr("Count: ".$data['num_methods']);
	foreach($methods AS $method){
		pr("<a href='".URL.$ctlr."/".$method."'>".$method."</a>");
		
	}

	// $data=NULL;$this->view->render($data,'layouts/indexLayouts');
}	/* fxn */


public function diamond(){
	$data=NULL;$this->view->render($data,'layouts/diamondLayout');
}	/* fxn */



public function responsive(){
	$data=NULL;$this->view->render($data,'layouts/responsiveLayout','empty');
}	/* fxn */


public function table(){
	$data=NULL;$this->view->render($data,'layouts/tableLayout','empty');
}	/* fxn */





}	/* BlankController */
