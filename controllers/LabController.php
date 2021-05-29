<?php

Class LabController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}

public function injection(){
	
	if(isset($_POST['submit'])){
		// elements: ctrl+u - copy hidden input, paste element
		pr('posted values');
		prx($_POST);
	}
	
	$this->view->render(null,"lab/injection",'empty');
}


public function columnHighlighting(){
	// task todo
	$db=$this->baseModel->db;
	$dbo=PDBO;
	$q="SELECT id,code,name,account,is_male FROM {$dbo}.00_contacts WHERE role_id=1 ORDER BY name LIMIT 100; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,'lab/columnHighlighting');
	
}


public function index(){ 
	pr("Lab");
	// $this->view->render($data,'tests/index');

}	/* fxn */



public function livecss(){
	
	$data=NULL;
	$this->view->render($data,"lab/livecss","empty");
}


}	/* TestsController */
