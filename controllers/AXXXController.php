<?php

Class AXXXController extends Controller{	/* GISController from bootstrap */

public function __construct(){
	parent::__construct();		

	
}

public function index(){
	$data="Contacts";
	$this->view->render($data,"contacts/indexContacts");
	
}



public function ucis($params=NULL){
$dbo=PDBO;$db=&$this->baseModel->db;
$data['ucid']=$ucid=isset($params[0])? $params[0]:false;
	


if(isset($_POST['submit'])){
	$index=strtolower($_POST['submit']);$post=$_POST[$index];$tbl="{$dbo}.`00_{$index}s`";
	$id=$post['id'];unset($post['id']); 
	$db->update("{$tbl}",$post,"id=$id");
	flashRedirect("contacts/ucis/$ucid","Updated");	
	exit;
}	/* post */
/* $q="SELECT count(*) AS numcols FROM information_schema.columns WHERE TABLE_SCHEMA='{$dbo}' AND TABLE_NAME='00_contacts'; "; */
// unset($_SESSION['cols']);
sessionizeColumnsOfDbtable($db,$dbo,"00_contacts","contacts",$except="'null'");
sessionizeColumnsOfDbtable($db,$dbo,"00_profiles","profiles",$except="'null'");

$data['contacts_cols']=$_SESSION['cols']['contacts'];
$data['contacts_count']=$_SESSION['cols']['contacts_count'];

$data['profiles_cols']=$_SESSION['cols']['profiles'];
$data['profiles_count']=$_SESSION['cols']['profiles_count'];



if($ucid){
	$data['contact']=fetchRecord($db,"{$dbo}.`00_contacts`","id=$ucid");
	$data['profile']=fetchRecord($db,"{$dbo}.`00_profiles`","contact_id=$ucid");
	

}	/* ucid */



$data['text_array']=array('address','remarks');

$vfile="contacts/ucisContact";

// pr($data);exit;
$this->view->render($data,$vfile);

}	/* fxn */


	
}	/* ContactsController */
