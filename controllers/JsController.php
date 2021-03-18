<?php

Class JsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	// $this->view->css=array('style_long.css','bootstrap4.css');
	$this->view->css=array('bootstrap4.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();

	// $acl = array(array(4,0),array(5,0));
	// $this->permit($acl,false);		
	
}	/* fxn */


public function index($params=NULL){	
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['sy']=DBYR;	
	$data['dbg']=$dbg=PDBG;
	
	$this->view->render($data,"jsviews/indexJs");

}	/* fxn */

public function async(){
	$this->view->render($data=NULL,"jsviews/asyncJs");

}	/* fxn */


public function async2(){
	$this->view->render($data=NULL,"jsviews/asyncJs2");

}	/* fxn */


public function ready(){
	$this->view->render($data=NULL,"jsviews/readyJs");
}	/* fxn */


public function promises(){
	$this->view->render($data=NULL,"jsviews/promisesJs");
}	/* fxn */


public function destructuring(){
	$this->view->render($data=NULL,"jsviews/destructuringJs");
}	/* fxn */


public function fetch(){
	$this->view->render($data=NULL,"jsviews/fetchJs");
}	/* fxn */


public function axios(){
	$this->view->render($data=NULL,"jsviews/axiosJs");
}	/* fxn */


public function abc(){
	// ajax data
	header('Content-Type: application/json');	
	$res=[
		'page'=> 1,
		'data' => [
			[
				'id'=>23,
				'name'=>'MakolEngr',	
			],
			[
				'id'=>24,
				'name'=>'Barry',	
			],			
		]
	];
	
	$res1 = 
		[
			'id'=>23,
			'name'=>'MakolEngr',	
		]	
	;
	
	echo json_encode($res1);
}	/* fxn */


public function def(){
	// ajax data
	$res=[
		'id'=>23,
		'name'=>'MakolEngr',
	];
	echo $res;
}	/* fxn */






}	/* BlankController */
