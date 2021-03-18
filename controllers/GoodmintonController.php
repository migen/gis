<?php

Class GoodmintonController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */


public function players(){
	$db=&$this->baseModel->db;$dbg=PDBG;
	$order=isset($_GET['order'])? $_GET['order']:"c.name";
	$q="SELECT * FROM {$dbg}.09_players ORDER BY $order;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	

	$this->view->render($data,'players/indexPlayers');



}	/* fxn */




}	/* BlankController */
