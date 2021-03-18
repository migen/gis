<?php

Class CodesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	echo "Codes index";
	
	$data=isset($data)? $data:NULL;
	// $this->view->render($data,'abc/index');
	

}	/* fxn */


public function edit($params=NULL){
$db=&$this->model->db;$dbo=PDBO; 
$ucid=$params[0];
if(isset($_POST['submit'])){
	$row=$_POST['post'];	
	$db->update("{$dbo}.`00_contacts`",$row,"`id`='$ucid'");
	flashRedirect("codes/edit/$ucid","Updated.");	
	exit;
}

$columns="`id`,`code`,`account`,`name`,`parent_id` AS `pcid`,`role_id`,`is_active`";
$q="SELECT $columns FROM {$dbo}.`00_contacts` WHERE id='$ucid' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$data['row']=&$row;

$this->view->render($data,'codes/edit');

}	/* fxn */




}	/* BlankController */
