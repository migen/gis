<?php

Class SetaxisController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
	$acl = array(array(5,0));
	$this->permit($acl);					
}


public function lockAllPaymodes($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;
	$db=&$this->baseModel->db;
	$q="UPDATE {$dbg}.05_summaries SET paymode_finalized=1;";
	echo "<br> append \"&exe\" to url to execute.";
	pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo "<br >";
		echo $sth? "Success":"Fail";
	}
	
	
}	/* fxn */


public function openAllPaymodes($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;
	$db=&$this->baseModel->db;
	$q="UPDATE {$dbg}.05_summaries SET paymode_finalized=0;";
	echo "<br> append \"&exe\" to url to execute.";
	pr($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo "<br >";
		echo $sth? "Success":"Fail";
	}
	
	
}	/* fxn */



public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */



public function auxes(){
require_once(SITE."functions/enrol.php");
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$q="INSERT IGNORE INTO {$dbg}.`20_auxes`(`scid`,`feetype_id`,`num`,`amount`) VALUES ";
	foreach($posts AS $post){
		if($post['scid']>0){
			$scid=$post['scid'];
			$ftid=$post['ftid'];
			$num=$post['num'];
			$amount = str_replace(",","",$post['amount']);			
			$scid = preg_replace("([^0-9/])", "", $scid);
			$ftid = preg_replace("([^0-9/])", "", $ftid);
			$num = preg_replace("([^0-9/])", "", $num);
			$q.="('$scid','$ftid','$num','$amount'),";
		}	
	}
	$q=rtrim($q,","); $q.=";";
	// echo "Query: <hr />"; pr($q);
	$db->query($q);
	flashRedirect($url,'Done');
	
	exit;
	
}	/* fxn */

$data=NULL;

$this->view->render($data,'setaxis/auxes');

}	/* fxn */



public function payments(){
// require_once(SITE."functions/enrol.php");
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$q="INSERT IGNORE INTO {$dbg}.`30_payments`(`ecid`,`scid`,`feetype_id`,`pointer`,`amount`,`date`,`orno`) VALUES ";
	foreach($posts AS $post){
		if($post['scid']>0){			
			$ecid = preg_replace("([^0-9/])", "", $post['ecid']);
			$scid = preg_replace("([^0-9/])", "", $post['scid']);
			$ftid = preg_replace("([^0-9/])", "", $post['ftid']);
			$ptr = preg_replace("([^0-9/])", "", $post['ptr']);		
			$amount = str_replace(",","",$post['amount']);			
			$date = preg_replace("([^0-9-/])", "", $post['date']);												
			$orno = preg_replace("([^0-9-/])", "", $post['orno']);															
			$q.="('$ecid','$scid','$ftid','$ptr','$amount','$date','$orno'),";
		}	
	}
	$q=rtrim($q,","); $q.=";";
	// echo "Query: <hr />"; pr($q);
	$db->query($q);
	flashRedirect($url,'Done');	
	exit;
	
}	/* fxn */

$data=NULL;
$this->view->render($data,'setaxis/payments');

}	/* fxn */


public function paymodes(){
require_once(SITE."functions/enrol.php");
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$q="";
	foreach($posts AS $post){
		if($post['scid']>0){
			$scid=$post['scid'];
			$pmid=$post['pmid'];
			$scid = preg_replace("([^0-9/])", "", $scid);
			$pmid = preg_replace("([^0-9/])", "", $pmid);
			$q.= updateStudenpaymodeQuery($scid,$pmid,$dbg);
		}	
	}
	// echo "Query: <hr />"; pr($q);
	$db->query($q);
	flashRedirect($url,'Done');
	exit;
	
}	/* fxn */
$data=NULL;
$this->view->render($data,'setaxis/paymodes');

}	/* fxn */



	
public function initialize($params=NULL){

$home = $_SESSION['home'];
$data['locked'] = ($_SESSION['settings']['ledger_setup']==1)? true:false;
require_once(SITE."functions/fees.php");	
require_once(SITE."functions/logs.php");	
$db =& $this->model->db;
$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;
$today = $_SESSION['today'];

$data['lvlid'] = $lvlid = isset($params[0])? $params[0]:4;
$ssy = $_SESSION['sy'];
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
$data['is_transitioned'] = $is_transitioned = (DBYR==$_SESSION['sy'])? true:false;
$data['ecid'] = $ecid = $_SESSION['ucid'];
if(!$is_transitioned) {	$_SESSION['message'] = "SY Not Transitioned Yet!"; }	

$_SESSION['tfeeid'] = isset($_SESSION['tfeeid'])? $_SESSION['tfeeid'] : feecode_id($db,'tfee');
$data['tfeeid'] = $tfeeid = $_SESSION['tfeeid']; 		

/* 1 - level tuition */	
$data1 = levelTuition($db,$lvlid,$num=1);
$data = array_merge($data,$data1);

/* 2 records */		
$data2=levelBalances($db,$lvlid,$dbo,$dbg);
$data = array_merge($data,$data2);
$rows = $data['rows'];
	
/* 3 - sync level tsum and summaries */	
$url="setaxis/initialize/$lvlid";
syncLevelTsumSumm($db,$rows,$url,$dbg);

/* 4 */
updateLevelBalances($db,$lvlid);


/* 5 submit */	
	if(isset($_POST['update'])){
		$q = " SELECT max(id) AS auxid FROM {$dbg}.`20_auxes`;";
		$sth = $db->querysoc($q);
		$row = $sth->fetch();
		$auxid = $row['auxid'];
		
		$ecid = $_SESSION['pcid'];		
		$today = $_SESSION['today'];		
		$q="";
		$posts = $_POST['posts'];
		$ucid = $_SESSION['ucid'];
		$details = "";
		$more['qtr'] = $_SESSION['qtr'];
		$axn = $_SESSION['axn']['ledger_setup_payment'];
		$more['crid'] = $crid;
		
		foreach($posts AS $post){
			$auxid+=1;
			$amount = str_replace(",","",$post['tpay']);
			
			$q.= "UPDATE {$dbg}.03_tsummaries SET 
				`paymode_id` = '".$post['paymode_id']."', 
				`balance` = '".$post['balance']."', 
				`tpaid` = '".$amount."', 
				`remarks` = '".$post['remarks']."'
				WHERE `scid` = '".$post['scid']."' LIMIT 1;";
			$payfee_id = $post['payfee_id'];						
			if(($amount>0) && ($payfee_id>0)){					
				$date = $post['date'];
				$date = preg_replace("([^0-9-/])", "", $date);												
				$orno = preg_replace("([^0-9-/])", "", $post['orno']);												
				$details = $post['details'];				
				$q.= "INSERT INTO {$dbo}.30_payments(`scid`,`ecid`,`feetype_id`,`date`,`amount`,`orno`,`pointer`,`details`) 
					VALUES ('".$post['scid']."','$ecid','$payfee_id','$date','".$amount."','".$orno."','1','$details'); ";

				/* 2 */
				$more['scid'] = $post['scid'];				
				$more['amount'] = $amount;				
				$more['feeid'] = $post['payfee_id'];				
				$q.=logQuery($ucid,$axn,$details,$more);	
				
					
			} 	/* resfee */
			

		$auxfee_id = $post['feetype_id'];			
		$adamt = str_replace(",","",$post['amount']);				
		if(($adamt>0) && ($auxfee_id>0)){		
			$q.= "INSERT IGNORE INTO {$dbg}.`30_auxes`(`id`,`due`,`ecid`,`scid`,`feetype_id`,`amount`,`num`) VALUES 
				('$auxid','$today','$ecid','".$post['scid']."','$auxfee_id','".$adamt."','".$post['num']."'); ";
		}	/* xv */
				
		}	/* foreach */
		
		// pr($q); exit;
		
		$db->query($q);
				
		$url = "setaxis/initialize/$lvlid";
		flashRedirect($url,'Level Ledgers Updated.');
		exit;
	}	/* post */
	


/* 3 - secrets */	
	$key = 'ledgers';
	sessionizeSecret($db,$key);
	$data['hdpass'] = $_SESSION['hdpass_'.$key];

/* 4 - view */	
	$dbg = isset($dbg)? $dbg:PDBG;
	$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id"); 	
		
	$data['feetypes'] = $this->model->fetchRows("{$dbo}.`03_feetypes`","id,name","name");
	$this->view->render($data,"setaxis/initialize");


}	/* fxn */






}	/* SetaxisController */
