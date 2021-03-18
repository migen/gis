<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

Class AxjsController extends Controller{

public function __construct(){
	parent::__construct();
	parent::beforeFilter();	
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	 
	
	/* $this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','accounts/js/parent.js');	 */
	
}


public function beforeFilter(){}
public function index(){ }	/* fxn */


public function promise($params=null){
	$data=NULL;
	$num=isset($params[0])? $params[0]:null;
	
	$this->view->render($data,"ajax/promise{$num}Ajax");
}





}	/* AjaxController */