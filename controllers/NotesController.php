<?php

class NotesController extends Controller{	
/* Syncs and Counts for - admins,registrars,and mis,guidance controllers  */
	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	parent::beforeFilter();		
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	$acl = array(array(5,0));
	$this->permit($acl);				
	
}	/* fxn */

public function index(){
	$this->view->render($data=NULL,'notes/indexNotes');
}	/* fxn */




}	/* SyncsController */