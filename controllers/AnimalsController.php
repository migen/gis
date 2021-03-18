<?php
Class AnimalsController extends Controller{	


public function __construct(){
	parent::__construct();		
	
}

public function beforeFilter(){
	if($this->only(array())){ $this->view->js = array('js/jquery.js','js/vegas.js'); } 
	

}	/* fxn */




public function index($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['id']=$id=isset($params[0])? $params[0]:false;
	$dbo=PDBO;$db=&$this->baseModel->db;	
	
	if($id){
		$q="SELECT * FROM {$dbo}.animals WHERE `id`='$id' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$data['row']=&$row;	
	}
	$data['q']="SELECT * FROM {$dbo}.animals;";
	$data['rows']=fetchRows($db,"{$dbo}.animals","*",$order='name');
	$view="animals/indexAnimals";	
	$this->view->render($data,$view);
}	/* fxn */




public function reset($params){
	$ctlr 	= $params[0];
	$this->Student->reset($dbg=PDBG);
	redirect($ctlr);
} /* reset */


public function filter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data=null;
	$this->view->render($data,'students/filter');
}	/* fxn */



public function links($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$dbo=PDBO;$db=&$this->baseModel->db;	
	
	if($scid){
		$q="SELECT c.id,c.code,c.name FROM {$dbo}.`00_contacts` AS c
			WHERE c.`id`='$scid' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$data['row']=&$row;				
	}
	
	$view="students/linksStudents";	
	$this->view->render($data,$view);
}	/* fxn */





} /* StudentsController */
