<?php

Class UnipromoterController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	


	$data="ABC";$this->view->render($data,'abc/defaultAbc');
	
	
}	/* fxn */




public function scid($params=NULL){
	
	
}	/* fxn */



public function shs(){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="SELECT c.id,c.code,c.name,c.is_active,c.is_male,c.role_id,summ.crid 
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		WHERE c.role_id=1 AND cr.level_id=15 ORDER BY c.name;		
	";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	
}	/* fxn */


public function college(){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q="SELECT c.id,c.code,c.name,c.is_active,c.is_male,c.role_id,summ.crid 
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.01_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		WHERE c.role_id=8 AND summ.level_id=1 ORDER BY c.name;		
	";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	
}	/* fxn */


}	/* BlankController */
