<?php

Class ChequesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "Cheques index";

}	/* fxn */



public function hello(){
	$data = "abc hello data";
	$this->view->render($data,'abc/hello');
}	/* fxn */





public function posedit($params){
$dbo=PDBO;
$data['posid']=$posid=$params[0];
$sy=isset($params[1])? $params[1]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;
$data['url']=$_SERVER['HTTP_REFERER'];

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$url=$_POST['url'];
	$db->update("{$dbo}.`30_pos`",$post,"id='$posid'");	
	redirectUrl($url);
	exit;
		
}	/* post */

// pr($_SESSION['banks']);
$data['banks']=$_SESSION['banks'];
$q="SELECT * FROM {$dbo}.`30_pos` WHERE id='$posid' LIMIT 1;";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();

$this->view->render($data,'cheques/posedit');

}	/* fxn */



















}	/* ChequesController */
