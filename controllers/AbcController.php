<?php

Class AbcController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	// parent::beforeFilter();

	// $acl = array(array(4,0),array(5,0));
	// $this->permit($acl,false);		
	
}	/* fxn */


public function lab($params=NULL){
	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$scid=2233;
	
	$q="UPDATE {$dbo}.05_steps SET `finalized_s1`=null WHERE id=1; ";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "success":"fail";	
	exit;
	
	$post['finalized_s1']='2021-04-04';
	$sth=$db->update("{$dbo}.05_steps",$post,"scid=$scid AND type='grading'");
	echo ($sth)? "ok":"fail";

	// $this->view->render(null,'abc/lab');	
	
}	/* fxn */



public function index($params=NULL){	

	// 4 - assessment
	$data['axn']=$axn=$this->axn();
	$axn='paymode';	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
	if(is_readable($incfile)){ require_once($incfile); } 	


	
	$data['content']=isset($content)? $content:null;
	$this->view->render($data,"abc/index");

}	/* fxn */


public function axn1(){
	echo "abc/axnOne";
}

public function axn2(){
	echo "abc/axnTwo";
}

public function axn3(){
	echo "abc/axnThree";
}

public function axn4(){
	echo "abc/axnFour";
}


public function passdiv(){
		
	$data=NULL;
	$this->view->render($data,"abc/passdiv");
}


public function css($params=NULL){	
	$db=&$this->baseModel->db;
	$data=NULL;	
	$this->view->render($data,"abc/css");

}	/* fxn */









public function scripts(){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=DBYR;
	
	$dbg=PDBG;
	// replaceComponentsCriteriaId	
	$q1="
		UPDATE {$dbg}.05_components 
		SET criteria_id=81 WHERE criteria_id=2;
	";	
	pr($q);


	// updateComponentsWeightByCriteriaId
	$q2="
		UPDATE {$dbg}.05_components 
		SET weight=20 WHERE criteria_id=4;
	";	
	pr($q2);

	
	
	$this->view->render($data,"abc/test");
}	/* fxn */



public function jsEvent(){
	$data=NULL;
	$this->view->render($data,"abc/jsEvent","basic");
	
	
}












}	/* BlankController */
