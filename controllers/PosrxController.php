<?php

Class PosrxController extends Controller{	

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


public function index(){
	echo "POS RX index.";
}

private function lastOrno($db,$dbg){
	$dbo=PDBO;
	require_once(SITE."functions/orno.php"); 	
	if(!isset($_SESSION['last_orno'])){ $row = maxOrno($db,$dbg); $_SESSION['last_orno'] = $row['max_orno']; }
	if(!isset($_SESSION['last_posid'])){ $_SESSION['last_posid'] = lastId($db,"{$dbo}.`30_pos`"); }
	
	$data['last_orno'] = $_SESSION['last_orno']; 
	$data['last_posid'] = $_SESSION['last_posid']; 
	return $data;
}

public function id($params){
	$dbo=PDBO;
	require_once(SITE."functions/pos.php");
	require_once(SITE."functions/posrx.php");
	$db =& $this->model->db;
	if(empty($params)){ flashRedirect('npos','No pos id.'); } 

	$posid = $params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$data = viewPosdetails($posid,$db,$dbg);	
	$key = 'pos';
	$data1 = $this->lastOrno($db,$dbg);
	$data = array_merge($data,$data1);	
	$current=($sy==DBYR)? true:false;
	if($current){
		$returns=viewPosrx($db,$posid,$dbg);	
	} else { $returns=array(); }
	$data['returns']=$returns;	
	$rids=buildArray($returns,'rx_pdid');
	$data['rids']=$rids;	
	$pos=$data['pos'];
	$data['terminal']=myTerminal($db);
	$data['orno'] = (lastOrno($db,$_SESSION['pcid'],$dbg)+1);
	
	if(isset($_POST['submit'])){
		$pds=isset($_POST['pds'])? $_POST['pds']:array();
		$prx=isset($_POST['prx'])? $_POST['prx']:array();
				
		$positems=array_merge($pds,$prx);
		$posts['pos']=$_POST['pos'];
		$posts['pos']['rxref_posid']=$posid;		
		$posts['positems']=$positems;

		$myvalue = $posts['pos']['datetime'];
		$datetime = new DateTime($myvalue);
		$posts['pos']['date'] = $datetime->format('Y-m-d');
		$posts['pos']['time'] = $datetime->format('H:i:s');		
		$posts['pos']['postype_id'] = $_SESSION['postype_sales'];		
		$posts['pos']['dbyr'] = DBYR;		
				
		$new_posid = addrx($db,$posts);		
		if($new_posid) { $msg="RX processed.";$url="npos/view/$new_posid/$sy";} else { $url="opos"; $msg=""; }
		flashRedirect($url,$msg);
		exit;
	}
	$data['sy']=$sy;	
	if(!isset($_SESSION['banks'])){ 
		$_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","id,code,name","name"); 	 } 
	$data['banks'] = $_SESSION['banks'];	
	$vfile="pos/rx";
	vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */










}	/* NposController */
