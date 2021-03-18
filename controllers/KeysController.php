<?php

Class KeysController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	// $this->view->css=array('style_long.css');
	// $this->view->js = array('js/jquery.js','js/vegas.js');
	sudo();	
	parent::beforeFilter();
	

}


public function index(){	
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	require_once(SITE."functions/keysFxn.php");
	$string="testkey";
	pr("string: $string ");
	
	$action="encrypt";
	$enc=encrypt_decrypt($action, $string);
	pr("enc: $enc ");
	
	$string=$enc;
	$action="decrypt";
	$dec=encrypt_decrypt($action, $string);
	pr("dec: $dec ");
	

}	/* fxn */



public function encrypt($params){	
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	require_once(SITE."functions/keysFxn.php");
	$string=$params[0];
	$action="encrypt";
	$enc=encrypt_decrypt($action, $string);
	pr($enc);
	
}	/* fxn */


public function decrypt($params){	
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	require_once(SITE."functions/keysFxn.php");
	$string=$params[0];
	$action="decrypt";
	$enc=encrypt_decrypt($action, $string);
	pr($enc);
	
}	/* fxn */


public function ctp(){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	// 1
	$q="UPDATE {$dbo}.00_contacts AS c
	INNER JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id
	SET c.pass=ctp.ctp WHERE c.role_id<>1; ";
	pr($q);
	if(isset($_GET['exe'])){ $sth=$db->query($q);echo ($sth)? "Success":"Fail";		
	} else { pr("&exe to process."); }
	
	// 2
	$q="UPDATE {$dbo}.00_contacts AS c
	INNER JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
	SET c.pass=p.birthdate WHERE c.role_id=1; ";
	pr($q);
	if(isset($_GET['bday'])){ $sth=$db->query($q); echo ($sth)? "Success":"Fail";		
	} else { pr("&bday to process."); }
	
	
}	/* fxn */


public function convert(){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	require_once(SITE."functions/keysFxn.php");
	$action="encrypt";	
	$q="SELECT id,pass FROM {$dbo}.00_contacts ORDER BY id; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($q);
	
	$q="";
	foreach($rows AS $row){
		$id=$row['id'];
		$pass=$row['pass'];		
		$mdpass=encrypt_decrypt($action,$pass);
		$q.="UPDATE {$dbo}.00_contacts SET pass='$mdpass' WHERE id=$id LIMIT 1;  ";
	}	/* foreach */
	
	if(isset($_GET['exe'])){ $sth=$db->query($q); echo ($sth)? "Success":"Fail";		
	} else { pr("&exe to process."); }

	
}	/* fxn */




}	/* BlankController */
