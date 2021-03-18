<?php

Class BoxController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$data['count']=isset($_GET['count'])? $_GET['count']:10;
	$this->view->render($data,'box/indexBox');
	
}	/* fxn */

public function aaa(){
	
	
}


public function bbb(){}
public function ccc(){}






}	/* BlankController */
