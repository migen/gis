<?php

Class SprController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "SPR students permanent records filter here ";

}	/* fxn */


public function begsy(){
	$dbo=PDBO;$db=&$this->model->db;
	
	$q="UPDATE {$dbo}.`00_contacts` SET begsy=sy,endsy='".DBYR."'; ";
	pr($q);
	// $sth=$db->query($q);
	// echo ($sth)? "success":"failed";

}

public function transcript($params=NULL){
$dbo=PDBO;
// echo "transcript";
require_once('functions/spr.php');
$data['scid']=$scid=isset($params[0])? $params[0]:false;
$db=&$this->model->db;
$data['student']=$student=($scid)? getStudentDetails($db,$scid):false; 
echo "begsy: ".$student['begsy']."<br />";
echo "endsy: ".$student['endsy']."<br />";



}	/* fxn */





}	/* BlankController */
