<?php

/**
 * @copyright MIDASGEN | PCMED-MIGEN 
 */

Class FyiController extends Controller{


public function __construct(){
	parent::__construct();
	
}

public function beforeFilter(){}

public function index(){
	$data['info'] = "<h2>FYI Home - Under construction!</h2>";
	$this->view->render($data,'fyi/index');
	
}	/* fxn */


public function subjects(){
$dbo=PDBO;	
$dbg = PDBG;
$data['home'] = $_SESSION['home'];
$data['subjects'] = $this->model->fetchRows($dbg.'.subjects','*','name');
$data['count']	  = count($data['subjects']);

$this->view->render($data,'fyi/subjects');


}	/* fxn */



} /* FyiController */
