<?php

Class HelpController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	// parent::beforeFilter();

	// $acl = array(array(4,0),array(5,0));
	// $this->permit($acl,false);		
	
}	/* fxn */


public function index(){
	
	pr("<h1>HELP</h1>");	
	pr('<h3>files/read/help - wyswyg editor</h3>');
	
}	/* fxn */


}	/* BlankController */
