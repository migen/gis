<?php

Class BootstrapController extends Controller{	

public $x="some var";


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
}
 
public function beforeFilter(){
	$this->view->layout="empty";
	
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index(){	
	$db=&$this->baseModel->db;$data=NULL;
	$this->view->render($data,"bootstrap/indexBootstrap","full");	

}	/* fxn */


public function all(){	
	$db=&$this->baseModel->db;$data=NULL;
	$this->view->render($data,"bootstrap/allBootstrap");
	

}	/* fxn */

public function jumbotron(){	
	$db=&$this->baseModel->db;$data=NULL;
	$this->view->render($data,"bootstrap/jumbotronBootstrap");
}	/* fxn */

public function html(){	
	$db=&$this->baseModel->db;$data=NULL;
	$this->view->render($data,"bootstrap/htmlBootstrap");
}	/* fxn */




}	/* BlankController */
