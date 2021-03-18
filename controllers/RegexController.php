<?php

Class RegexController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index(){	
	ob_start();
	echo "<h3>Regex | ";shovel('links_lab');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");	

}	/* fxn */

public function replace(){	
	$a="your Suzie is fine";
	$b="Kat";
	
	pr($a);
	echo preg_replace("Suzie","Kat",$a,1);
	
	
	

}	/* fxn */








}	/* BlankController */
