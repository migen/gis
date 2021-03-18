<?php

Class AxnController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	


	$data="Axn";$this->view->render($data,'abc/defaultAbc');
	
	
}	/* fxn */

public function session($params=NULL){
	$x=isset($params[0])? $params[0]:'q';	
	pr($_SESSION[$x]);
	
}	/* fxn */





}	/* BlankController */
