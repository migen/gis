<?php

Class ComboController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index($params=NULL){
$db=&$this->model->db;
$dbg=PDBG;
$dbo=PDBO;
$scid=isset($params[0])? $params[0]:333;

$q="SELECT code FROM {$dbo}.`00_contacts` WHERE id='$scid' LIMIT 1;  ";
pr($q);
$sth=$db->querysoc($q);
$row1=$sth->fetch();
pr($row1);

$q="SELECT name FROM {$dbo}.`00_contacts` WHERE id='$scid' LIMIT 1;  ";
pr($q);
$sth=$db->querysoc($q);
$row2=$sth->fetch();
pr($row2);

$row=array_merge($row1,$row2);

pr($row);

}	/* fxn */



}	/* BlankController */
