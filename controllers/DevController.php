<?php

Class DevController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$data="DEV";$this->view->render($data,'abc/defaultAbc');
	
}	/* fxn */


public function whole(){
	reqFxn('devFxn');	
	$data[0]=getDummyRcardData('Anna');
	$data[1]=getDummyRcardData('Bella');
	$data['num_students']=1;
	$data['months']=getMonths();	
	$this->view->render($data,"dev/wholeDev");
	
}

public function half(){
	reqFxn('devFxn');	
	$data[0]=getDummyRcardData('Pable, Carl Angelo');
	$data['num_students']=1;

	$data[0]=getDummyRcardData('Anna');
	$data[1]=getDummyRcardData('Bella');
	$data['num_students']=2;
	
	$data['months']=getMonths();	
	$this->view->render($data,"dev/halfDev");
	
}







}	/* BlankController */
