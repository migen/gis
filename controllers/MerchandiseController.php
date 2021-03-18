<?php

Class MerchandiseController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	 echo "merchandise";

	
}	/* fxn */


public function items($params=NULL){
$dbo=PDBO;
	$id=isset($params[0])? $params[0]:1;
	$db=$this->baseModel->db;$dbg=PDBO;
	include_once(SITE.'functions/merchandiseFxn.php');
	$data=getMerchandiseByType($db,$dbg,$id);
	$q="SELECT * FROM {$dbg}.00_prodtypes WHERE id=$id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$data['prodtype_id']=$row['id'];
	$data['prodtype']=$row['name'];
	
	$this->view->render($data,"merchandise/itemsMerchandise");
	
	
	
}	/* fxn */







}	/* BlankController */
