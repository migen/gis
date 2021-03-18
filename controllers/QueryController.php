<?php

Class QueryController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index(){	
	$data="Query";
	$this->view->render($data,"query/indexQuery");
	
}	/* fxn */

public function bdayPass(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="UPDATE {$dbo}.00_contacts AS c 
		INNER JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		SET c.pass=MD5(p.birthdate)
		WHERE c.role_id=1;";			

	$q.="UPDATE {$dbo}.00_contacts AS c 
		INNER JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		INNER JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id
		SET ctp.ctp=p.birthdate
		WHERE c.role_id=1;";					
	pr($q);
	pr("&exe");
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
		
	}
	
}	/* fxn */





}	/* BlankController */
