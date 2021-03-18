<?php

class SyncgradesController extends Controller{	
/* Syncs and Counts for - admins,registrars,and mis,guidance controllers  */
	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	parent::beforeFilter();		
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	$acl = array(array(5,0));
	$this->permit($acl);				
	
}	/* fxn */

public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'syncs/indexSyncs');
}	/* fxn */


public function scid($params=NULL){
	require_once(SITE."functions/syncgradesFxn.php");
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$data['scid_from']=$scid_from=isset($params[1])? $params[1]:false;
	$data['scid_to']=$scid_to=isset($params[2])? $params[2]:false;
	
	pr("params - sy / scid_from / scid_to ");
	pr("&exe");
	if(isset($_GET['exe'])){
		mergeDuplicates($db,$sy,$scid_from,$scid_to); 				
	}
	
	
	
	
}	/* fxn */



public function scids($params=NULL){
	require_once(SITE."functions/syncgradesFxn.php");
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$data['scid_from']=$scid_from=isset($params[1])? $params[1]:false;
	$data['scid_to']=$scid_to=isset($params[2])? $params[2]:false;
	
	pr("&exe");
	pr("goto code to set Array");
	$duplicates=array(
		array('scid_from'=>3797,'scid_to'=>3290),
		array('scid_from'=>3872,'scid_to'=>3224),
		array('scid_from'=>3633,'scid_to'=>1329),	
		array('scid_from'=>3589,'scid_to'=>2806)	
	);
	pr($duplicates);
	pr("&confirm");
	
	if(isset($_GET['confirm'])){
		if(isset($_GET['exe'])){
			foreach($duplicates AS $row){ mergeDuplicates($db,$sy,$row['scid_from'],$row['scid_to']); }
			pr("All done");					
		}			
	}	/* confirm */
	
}	/* fxn */





}	/* SyncsController */