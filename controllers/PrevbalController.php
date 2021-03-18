<?php

Class PrevbalController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){
	echo "prevbal";
	
}	/* fxn */

public function level($params=NULL){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$db=$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$q="
		SELECT 
			c.name AS studname,c.code AS studcode,		
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE cr.level_id=$lvl 		
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"prevbal/levelPrevbal");
	
	
}	/* fxn */




}	/* BlankController */
