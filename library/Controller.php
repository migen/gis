<?php

class Controller{
	public $layout=LAYOUT;	
	
	
public function __construct(){ 
	$this->init(); 
	// $this->view->css=array('bootstrap.min.css');

}

public function beforeFilter(){ 
	$this->loginRedirect(); 

}

public function init(){
	$this->view=new View();$this->view->js=array();$this->baseModel=new Model();		
	Session::logout();Session::init();	
}



public function loginRedirect(){	
	$row=$this->params();$rurl=$row['url'];	
	if(!loggedin()){ $_SESSION['rurl'] = $rurl; flashRedirect('users/login','Login Redirect'); } 
}


public function isLoggedin(){
	return (isset($_SESSION['user']['loggedin']) && $_SESSION['user']['loggedin'])? true : false; 
}


public function permit($acl=array(),$strict=false){
    $role=isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : false;
    $priv=isset($_SESSION['user']['privilege_id'])? $_SESSION['user']['privilege_id'] : false;	
    $c=count($acl);
    if(!$role && !$priv){ flashRedirect(UNAUTH,'Permission denied.'); }
    if(!$strict){
        for($i=0;$i<$c;$i++){
                $row = $acl[$i];
                if($role==$row[0] && $priv>=$row[1]){ return true; }
        }                        
    } else {
        for($i=0;$i<$c;$i++){
                $row = $acl[$i];
                if($role == $row[0] && $priv == $row[1]){ return true; }
        }                
    }
    flashRedirect(UNAUTH,'Permission denied.');
}	/* fxn */


public function loadModel($mfile,$model){
	if(is_readable($mfile)){ include_once($mfile);if(class_exists($model)){ return new $model();} else { return false; }
	} else { return false; }
}	/* fxn */

	
public function params(){
	$params=array();if(!empty($_REQUEST)){	$params = array_merge($params,$_REQUEST); return $params; }
}	/* fxn */

public function axn(){
	$params=$this->params();
	if(isset($params['url'])){
		$url=$params['url'];$params=explode('/',$url);$controller="";$action="";$controller=isset($params[0])?$params[0]:"index";
		$action=isset($params[1])?$params[1]:"index";return $action;
	} 		
}	/* fxn */


public function only($actions=array()){ $axn=$this->axn();if(in_array($axn,$actions)){ return true; }return false; } /* fxn */

public function flashRedirect($url="index",$message="Not allowed."){ $_SESSION['message']=$message;$u=URL.$url; header("Location: $u"); exit;}

public function methods($params=NULL){
	require_once(SITE."functions/reflections.php");$db=&$this->model->db;$data['class']=$class=get_called_class();	
	$data=reflectMethods($class);$data['rows']=&$data['methods'];		
	$vfile="controllers/methodsControllers";vfile($vfile);
	$class_name=$data['class'];$controller_name=str_replace("Controller","",$class_name);$controller_name=strtolower($controller_name);
	$data['controller_name']=$controller_name;$this->view->render($data,$vfile);	/* tools-index */
}	/* fxn */


public function all(){ // $cls=get_called_class();	
	$dbtable=$this->dbtable;$db=$this->baseModel->db;
	$field_str=isset($_GET['fields'])? $_GET['fields']:"id,name";if(isset($_GET['full'])){ $field_str="*"; }
	$q="SELECT $field_str FROM $dbtable; ";
	$sth=$db->querysoc($q);$data['rows']=$sth->fetchAll();pr($data);		
}	/* fxn */

public function id($params){ 	
	$dbtable=$this->dbtable;$db=$this->baseModel->db;$id=$params[0];
	$q="SELECT * FROM $dbtable WHERE id=$id LIMIT 1; ";$sth=$db->querysoc($q);$data['row']=$sth->fetch();pr($data);		
}	/* fxn */


} 	/* Controller */

