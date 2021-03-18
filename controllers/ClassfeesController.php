<?php

Class ClassfeesController extends Controller{	

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



public function level($params=NULL){	
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="
		SELECT cf.*,cf.id AS pkid,t.name AS feetype
		FROM {$dbo}.03_classfees AS cf
		INNER JOIN {$dbo}.03_feetypes AS t ON cf.feetype_id=t.id 
		WHERE cf.level_id=$lvl AND cf.sy=$sy;	
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	if(!isset($_SESSION['levels'])){ $_SESSION['levels']=fetchRows($db,"{$dbo}.05_levels","id,code,name,department_id,subdepartment_id","id"); }
	$data['levels']=$_SESSION['levels'];
	$data['level']=fetchRow($db,"{$dbo}.05_levels",$lvl,"id,code,name");

	$this->view->render($data,"classfees/levelClassfees");
}	/* fxn */


public function index(){	
	pr("classfees index");

}

public function add($params){
	if(!isset($params[0])){ pr("Param[0] - SY is required."); exit; }
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;	
	$data['sy']=$sy=$params[0];
	
	$this->view->render($data,"classfees/addClassfees");
	
}	/* fxn */


}	/* BlankController */
