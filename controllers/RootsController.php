<?php
Class RootsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();

	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl,1);				
	
}	/* fxn */


public function index(){
	echo "root controller";

}



public function myip(){		// causes error in router
	echo "Public IP: ".$_SERVER['REMOTE_ADDR'];

/* 
$externalContent = file_get_contents('http://checkip.dyndns.com/');
preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
$externalIp = $m[1];
pr($externalIp);
	 */
	
}



 
} 	/* RootsController */
