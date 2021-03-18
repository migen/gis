<?php

Class SyncContactsController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();

	$acl = array(array(4,0),array(5,0));
	$this->permit($acl,false);		
	
}	/* fxn */




public function index($params=NULL){	
	pr("Sync Contacts");
	$this->view->render($data,"abc/index");

}	/* fxn */


public function sy($params=NULL){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	

/* 	$q="SELECT LEFT(code,4) AS sy FROM {$dbo}.00_contacts WHERE role_id=1 LIMIT 3;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	pr($q);
	pr($data);
	exit;
 */
		
	$q="UPDATE {$dbo}.00_contacts AS a 
		INNER JOIN (
			SELECT id,LEFT(code,4) AS sy FROM {$dbo}.00_contacts WHERE role_id=1
		) AS b ON a.id=b.id		
		SET a.sy=b.sy;";
		
	// $q="UPDATE {$dbo}.00_contacts 
		// SET sy= WHERE role_id=1;";		
		
	pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Failed";
	} else {
		pr('&exe');
	}
	

}	/* fxn */











}	/* BlankController */
