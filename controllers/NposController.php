<?php

Class NposController extends Controller{	

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
	require_once(SITE."functions/pos.php");
	require_once(SITE."functions/orno.php"); 	
	$db =& $this->model->db;$dbg = PDBG;$dbg = PDBG;		
	if(isset($_POST['submit'])){
		$posts = $_POST;		
		$myvalue = $posts['pos']['datetime'];
		$datetime = new DateTime($myvalue);
		$posts['pos']['date'] = $datetime->format('Y-m-d');
		$posts['pos']['time'] = $datetime->format('H:i:s');		
		$posts['pos']['postype_id'] = $_SESSION['postype_sales'];		
		$posts['pos']['dbyr'] = DBYR;		
				
		if($posts['positems'][0]['io']!=0){
			
			$id = add($db,$posts);		
		} else {
			flashRedirect('npos','No transaction!');
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
		
	$this->view->render($data,'pos/add');

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


public function edit($params){ redirect('pos/edit/'.$params[0]); }


public function modify($params){
$dbo=PDBO;
	require_once(SITE."functions/pos.php");
	$db =& $this->model->db;
	if(empty($params)){ flashRedirect('npos','No pos id.'); } 

	$pos_id = $params[0];
	$dbg = PDBG;$dbg = PDBG;
	$data = viewPos($pos_id,$db);
	$key = 'pos';
	$data1 = $this->lastOrno($db,$dbg);
	$data = array_merge($data,$data1);	
	$this->view->render($data,'pos/modify');

}	/* fxn */



public function rx($params){
$dbo=PDBO;
require_once(SITE."functions/pos.php");
	require_once(SITE."functions/posrx.php");
	$db =& $this->model->db;
	if(empty($params)){ flashRedirect('npos','No pos id.'); } 

	$posid = $params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;
	
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
	
	if(isset($_POST['submit'])){
		$pds=$_POST['pds'];
		$ccid=$_POST['ccid'];
		$sth=rx($db,$pos,$pds,$ccid,$sy);		
		$msg=($sth)? "Returns done":"Returns failed.";
		$url="posrx/id/$posid/$sy";
		flashRedirect($url,$msg);
		exit;
	}
	$data['sy']=$sy;	
	$this->view->render($data,'pos/rx');

}	/* fxn */



public function view($params){
$dbo=PDBO;
	require_once(SITE."functions/pos.php");
	$db =& $this->model->db;$dbo=PDBO;
	if(empty($params)){ flashRedirect('npos','No pos id.'); } 

	$pos_id = $params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;
	
	$data = viewPos($pos_id,$db,$dbg);
	$data['has_rxref']=($data['pos']['rxref_posid']>0)? true:false;
	if($data['has_rxref']){ 
		$rxref=getPosdetails($db,$data['pos']['rxref_posid']); 
		$data['rxref']['pos']=$rxref['pos'];
		$data['rxref']['positems']=$rxref['positems'];
	}
	
	$data['has_rx']=($data['pos']['rxid']>0)? true:false;
	if($data['has_rx']){
		$rx=getPosdetails($db,$data['pos']['rxid']); 
		$data['rx']['pos']=$rx['pos'];
		$data['rx']['positems']=$rx['positems'];		
	} 
		
	$key = 'pos';
	$data['pos_id']=$pos_id;$data['sy']=$sy;

	// $this->view->render($data,'pos/printPos','posLayout');
	$this->view->render($data,'pos/printPos','blank');

}	/* fxn */






}	/* NposController */
