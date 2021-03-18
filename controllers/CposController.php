<?php

Class CposController extends Controller{	

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
		
}	/* fxn */

public function index(){
	echo "Credit POS Index";
}

public function add($params=NULL){
	require_once(SITE."functions/cpos.php");
	$db =& $this->model->db;$dbg=PDBG;$dbo=PDBO;		
	$data['today']=$_SESSION['today'];


	$ccid=isset($params[0])? $params[0]:false;
	$data['ccid']=&$ccid;
	if($ccid){ $data['rows']= viewCpos($db,$ccid); $data['count']=count($data['rows']); }
	$data['contact']=getContactDetails($db,$ccid);
	
	
	if(isset($_POST['submit'])){
		$posts=$_POST['positems'];
		addCpos($db,$ccid,$posts);
		$url="cpos/add/$ccid";
		flashRedirect($url,"Items added.");
		exit;
	}	/* post */
	
	if(isset($_POST['checkout'])){
		$posts=$_POST['positems'];
		addCpos($db,$ccid,$posts);
		$url="cpos/checkout/$ccid";
		redirect($url);		
		exit;
	}
		
	$this->view->render($data,'cpos/addCpos');

}	/* fxn */



public function checkout($params){
require_once(SITE."functions/cpos.php");
require_once(SITE."functions/opos.php");
require_once(SITE."functions/orno.php");
require_once(SITE."functions/invis.php");
$db =& $this->model->db;$dbg = PDBG;$dbg = PDBG;		
$data = posincs($db);

$ccid=$params[0];
$data['ccid']=&$ccid;
if($ccid){ $data['rows']= viewCpos($db,$ccid); $data['count']=count($data['rows']); }
$idr=buildArray($data['rows'],'cposid');

if(isset($_POST['submit'])){
	/* 1 - addPos */
	$posts = $_POST;		
	if(!empty($posts['positems'])){
		$id = saveCpos($db,$posts);		// like opos add except for datecr
	} else {
		flashRedirect('opos','No transaction!');
	}
	
	/* 2 - deleteCposids */
	deleteCposids($db,$idr);	

	/* 3 - redirect */
	$url = "npos/view/$id";
	redirect($url);		
	exit;
}	/* cancel */


if(isset($_POST['cancel'])){
	redirect("cpos/add/$ccid");
}	/* cancel */


$this->view->render($data,'cpos/checkout');

}	/* fxn */




}	/* NposController */
