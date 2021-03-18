<?php

/**
 * @copyright MIDASGEN | PCMED-MIGEN 
 */

Class UsersController extends Controller{


public function __construct(){	
	if($this->only(array('login','logout','index'))){ $this->init();
	// $this->view->css=array('bootstrap.min.css');
	} else { parent::__construct(); }	
}	/* fxn */

public function beforeFilter(){}


public function login($params=NULL){
$dbo=PDBO;
	$rurl = isset($_SESSION['rurl'])? $_SESSION['rurl'] : HOMEPAGE;	/* controller-loginRedirect */				
	if(loggedin()){ 
		redirect($rurl); 
	}
    if(isset($_POST['submit'])){						
		$db=&$this->model->db;
		require_once(SITE.'functions/loginFxn.php');
		$authenticated=authenticate($db,PDBO);				
		if($authenticated) { redirect($rurl); }
    }			
	$sch=VCFOLDER;$one="login_{$sch}";$two="users/login";
	$vfile=cview($one,$two,$sch);vfile($vfile);		
	$this->view->render(null,$vfile);		
}	/* fxn */


public function logout(){
$dbo=PDBO;
	require_once(SITE.'functions/loginFxn.php');
	logout(); redirect('users/login');
}

public function index(){ 
$dbo=PDBO;

	pr('users/index');
}

public function prefix(){
$dbo=PDBO;
	$this->view->render(null,'users/prefix');		
}	/* fxn */


public function mdfive(){
$dbo=PDBO;
	$data['clear'] = (isset($_GET['clear']))? $_GET['clear']:NULL;
	$this->view->render($data,'users/mdfive');
}	/* fxn */

public function session(){ pr($_SESSION); }


public function reset(){
	$dbo=PDBO;
	$db=&$this->baseModel->db;
	$role=$_SESSION['home'];$ucid=$_SESSION['ucid'];
	require_once(SITE."functions/sessionize.php");	
	require_once(SITE."functions/sessionize_role.php");	
	resessionizeUser($db,$ucid);		// 1 - sessionize user
	$fxn="sessionize_$role";$fxn($db);	// 2 - sessionize role			
	redirect($role);		
}


} /* UsersController */
