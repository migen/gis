<?php

Class CssController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	$this->view->render($data=NULL,'css/indexCss');
}	/* fxn */


public function tabs(){
	// $data=array('car','house');
	$data=NULL;
	$this->view->render($data,'css/tabsCss');
}	/* fxn */


public function menu(){
$data=NULL;
$this->view->render($data,"css/menuCss");
	
}	/* fxn */



public function menu2(){
	$this->view->render($data=NULL,"css/menuCss2");	
}	/* fxn */


public function accordion(){
	$this->view->render($data=NULL,"css/accordionCss");	
}	/* fxn */


public function center(){
	$this->view->render($data=NULL,"css/centerCss");	
}


public function box(){
	
	$this->view->render($data=NULL,"css/boxCss");	
	
}	/* fxn */



}	/* BlankController */
