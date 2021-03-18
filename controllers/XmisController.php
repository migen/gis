<?php

Class XmisController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->layout="expired";

	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
}	/* fxn */


public function index(){
	$data=NULL;
	$this->view->render($data,'xmis/indexXmis');
	
}



}	/* CirController */
