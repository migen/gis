<?php

Class MenuController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index($params=NULL){
$dbo=PDBO;
	$data['controller']="MenuController";
	require_once(SITE.'views/elements/incs_reflection.php');
	// pr($data);

	$methods=$data['methods'];
	$ctlr=str_replace("Controller","",$data['controller']);
	$ctlr=strtolower($ctlr);
	pr("Count: ".$data['num_methods']);
	foreach($methods AS $method){
		pr("<a href='".URL.$ctlr."/".$method."'>".$method."</a>");
		
	}
	
}	/* fxn */
	
	
public function index2($params=NULL){
$dbo=PDBO;
	require_once(SITE.'views/elements/incs_reflection.php');pr($data);
	
	$db=&$this->baseModel->db;
	$_SESSION['q']='';
	$data['home']=$home=$_SESSION['home'];	
	include_once(SITE.'views/elements/params_sq.php');
	$data['qtr']		= $_SESSION['qtr'];		
	if(!isset($_SESSION['classrooms'])){ 
		$brid=$_SESSION['brid'];$fields="id,code,name,acid,label,level_id,section_id,branch_id";$where="WHERE branch_id=$brid";
		$_SESSION['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order="level_id,name",$where);		
	}
	$data['classrooms']=$_SESSION['classrooms'];
	$data['months'] 	= $_SESSION['months'];	
	$data['levels'] 	= $_SESSION['levels'];	
	$data['subjects'] 	= $_SESSION['subjects'];	
	$data['departments'] = $_SESSION['departments'];	
	$data['roles'] 		= $_SESSION['roles'];	
	if(!isset($_SESSION['teachers'])){ $_SESSION['teachers']=array(); }
	$data['teachers'] 	= $_SESSION['teachers'];	
  
	$data = isset($data)? $data : null;			
	$this->view->render($data,'menu/indexMenu');

}	/* fxn */




public function three(){ 


	$data['divs']=array(
		"accounting","registrars","mis",
		"accounting","registrars","mis",
		"accounting","registrars","mis",
	);
	$items=array();
	$items[0]=array(
		"balances","tfees","products","bills","soa","ledger"
	);
	
	$items[1]=array(
		"classrooms","levels","grades","summarizers","matrix","spiral",
		"classrooms","levels","grades","summarizers","matrix","spiral",
	);
	$items[2]=array(
		"users","contacts","syncLevels","syncGrades"
	);
	
	$items[3]=$items[6]=$items[0];
	$items[4]=$items[7]=$items[1];
	$items[5]=$items[8]=$items[2];
	
	$data['items']=&$items;
	
	
	// $data['axn']=$axn=$this->axn();$vfile="menu/{$axn}Menu";
	$vfile="menu/threeMenu";
	$this->view->render($data,$vfile);


}	/* fxn */

public function one(){ require_once(SITE."views/menu/incsMenu.php"); }	/* fxn */
public function two(){ require_once(SITE."views/menu/incsMenu.php"); }	/* fxn */


public function four(){ 
	$data=NULL;
	$this->view->render($data,"menu/fourMenu");

 }	/* fxn */
 
 
public function table(){ 
	$data=NULL;
	$this->view->render($data,"menu/tableMenu","empty");

 }	/* fxn */
 
 




}	/* BlankController */
