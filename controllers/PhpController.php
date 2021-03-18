<?php

Class PhpController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	// $data=phpinfo();
	$data=NULL;
	$this->view->render($data,"php/indexPhp");
}	/* fxn */

public function info(){	
	$data=phpinfo();
}	/* fxn */


public function keywords(){
	$data=NULL;
	$this->view->render($data,"php/keywordsPhp");
	
}	/* fxn */


public function ajax(){	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"php/ajaxPhp");

}	/* fxn */


public function js(){	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"php/jsPhp");

}	/* fxn */







}	/* BlankController */
