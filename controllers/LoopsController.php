<?php

Class LoopsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	// echo "Loops";
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$dbg=PDBG;
	$lvl=isset($_GET['lvl'])? $_GET['lvl']:4;
	$q="SELECT 
		c.id AS scid,c.code AS studcode,c.name AS student,summ.ave_q1 AS genave
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE cr.level_id='$lvl' ORDER BY genave DESC LIMIT 100; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	
	$this->view->render($data,'loops/indexLoops');
}	/* fxn */


}	/* BlankController */
