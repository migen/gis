<?php

Class SchemaController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}


public function beforeFilter(){
	parent::loginRedirect();
	$acl = array(array(5,0));
	$this->permit($acl);				
}	/* fxn */


public function index(){ 
	pr('<h1>Schema for MIS only - Home</h1> | Seeders');
	pr("dropRecordsBySY/dbtable/sy");




}	/* fxn */



public function dropRecordsBySY($params=NULL){
	if((!isset($params[0])) || (!isset($params[1]))){ 
		prx("param-table and param-sy required."); }
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$dbtable=$params[0];
	$sy=$params[1];

	// $url = "tuitions/table/$nextsy";

	pr("Target");
	$q="DELETE FROM {$dbtable} WHERE sy=$sy; ";
	pr($q);

	
	if(!isset($_GET['exe'])){
		pr("<h1>&exe</h1>");
	} else {
		$sth = $db->query($q);
		echo $sth? "Success":"Fail";
	}


	
}	/* fxn */




}	/* TuitionsController */
