<?php

Class SamplesController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	pr("Samples");
	
}


public function datasheet($params=NULL){	

	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	if(!$scid){ pr("Scid parameter required."); exit; }	
	// $layout=isset($_GET[])
		
	$q="SELECT c.id AS scid,c.code AS studcode,c.name AS studname,cr.level_id,cr.name AS classroom,
			p.birthdate,
			summ.ave_q1,summ.ave_q2,summ.ave_q3,summ.ave_q4
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		WHERE c.id = $scid LIMIT 1;	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['student']=$row=$sth->fetch();
	
	$level_id=$row['level_id'];
	$q="SELECT id,code,name FROM {$dbg}.05_classrooms WHERE level_id=$level_id; ";
	$sth=$db->querysoc($q);
	$data['classrooms']=$sth->fetchAll();
	$data['num_classrooms']=$sth->rowCount();

	if(isset($_GET['data'])){ pr($data); }
	$this->view->render($data,"samples/datasheetSamples");
	

}	/* fxn */



}	/* BlankController */
