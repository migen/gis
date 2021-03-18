<?php

Class OposController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();			

	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(RMIS,0),array(RINVIS,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl,0);				
	
	
}




public function index(){	/* same with add */
$dbo=PDBO;
	require_once(SITE."functions/cpos.php");
	require_once(SITE."functions/opos.php");
	require_once(SITE."functions/orno.php"); 	
	require_once(SITE."functions/invis.php"); 	
	$db =& $this->model->db;$dbg=PDBG;$dbo=PDBO;		
	if(isset($_POST['submit'])){
		$posts = $_POST;		
		$myvalue = $posts['pos']['datetime'];
		$datetime = new DateTime($myvalue);
		$posts['pos']['date'] = $datetime->format('Y-m-d');
		$posts['pos']['time'] = $datetime->format('H:i:s');		
		$posts['pos']['postype_id'] = $_SESSION['postype_sales'];		
		$posts['pos']['dbyr'] = DBYR;				

		if(!empty($posts['positems'])){
			$id = add($db,$posts);		
		} else {
			flashRedirect('opos','No transaction!');
		}
		$url = "npos/view/$id";
		redirect($url);
	}	/* post */

	
	$trml = myTerminal($db);
	echo (!isset($trml))? "<h3 class='brown' >Terminal for Employee Not Set, Ask MIS Help.</h3>":NULL;
	$trml = isset($trml)? $trml:'1';
	$data['terminal'] = $trml;	

	
	$data['orno'] = (lastOrno($db,$_SESSION['pcid'],$dbg)+1);
	$data['limits'] = $_SESSION['settings']['limits'];

	
	if(!isset($_SESSION['banks'])){ 
		$_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","id,code,name","name"); 	 } 
	$data['banks'] = $_SESSION['banks'];		
	
	if(!isset($_SESSION['paytypes'])){ 
		$_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*","name"); 	 } 
	$data['paytypes'] = $_SESSION['paytypes'];	
	$data['npos'] = true;	
		
	$data1 = $this->lastOrno($db,$dbg);		
	$data = array_merge($data,$data1);
	$vfile="opos/indexOpos";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


private function lastOrno($db,$dbg){
	$dbo=PDBO;
	require_once(SITE."functions/orno.php"); 	
	if(!isset($_SESSION['last_orno'])){ $row = maxOrno($db,$dbg); $_SESSION['last_orno'] = $row['max_orno']; }	
	if(!isset($_SESSION['last_posid'])){ $_SESSION['last_posid'] = lastId($db,"{$dbo}.`30_pos`"); }
	
	$data['last_orno'] = $_SESSION['last_orno']; 
	$data['last_posid'] = $_SESSION['last_posid']; 
	return $data;
}


public function orno($params=NULL){
$dbo=PDBO;
$ssy = $_SESSION['sy'];
$data['orno'] = $orno = isset($params[0])? trim($params[0]):NULL;
if(empty($params[0])){ flashRedirect('npos','No OR No provided.'); }
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
$dbg = VCPREFIX.$sy.US.DBG;

$q = "SELECT id FROM {$dbo}.`30_pos` WHERE `orno` = '".$orno."' LIMIT 1; ";	
$sth = $this->model->db->querysoc($q);
$row = $sth->fetch();
$id = $row['id'];
if(empty($id)){ flashRedirect('npos','No transaction found.'); }

$url = "npos/view/$id";
redirect($url);


}	/* fxn */







}	/* NposController */
