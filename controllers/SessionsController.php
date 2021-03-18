<?php

Class SessionsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	$data['rows']=$keys=array_keys($_SESSION);
	$data['count']=count($keys);
	$data['sessions']=$_SESSION;
	
	$this->view->render($data,"sessions/indexSessions");
	

}	/* fxn */



public function unsetter2($params=NULL){
$dbo=PDBO;
	$key=isset($_POST['key'])? $_POST['key']:false;
	$key=($key=="user")? false:$key;
	if(isset($_POST['submit'])){ $_SESSION[$key]=NULL;unset($_SESSION[$key]); flashRedirect('sessions/unsetter',"Unset $key");	}

}	/* fxn */


public function unsetter($params=NULL){ 
	$var=isset($params[0])? $params[0]:false;if($var){ unset($_SESSION[$var]); $data['message']="$var unset."; }
	$data=isset($data)? $data:NULL; $this->view->render($data,"sessions/unsetterSessions");
}	/* fxn */


public function setter($params=NULL){
	if(!isset($params[0]) && !isset($params[1])){ pr("Param0-key and param1-value are required."); exit; }
	$key=$params[0];
	$value=$params[1];
	$_SESSION['settings'][$key]=$value;
	
	if(isset($_SERVER['HTTP_REFERER'])){
		$url=$_SERVER['HTTP_REFERER'];redirectUrl($url);		
	} else { redirect('index'); }
	
}	/* fxn */


}	/* BlankController */
