<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN

 Apps - appraisal for guidance and hrd
 */

Class AppController extends Controller{

public function __construct(){
	parent::__construct();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}


public function beforeFilter(){}


public function index(){

	echo "App Index";
	// $this->view->render($data,'hrds/index');

}	/* fxn */



} /* AppController */

