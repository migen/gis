<?php

Class BanksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	echo "banks index";
	// $this->view->render($data,'tests/index');

}	/* fxn */




public function deposits(){

$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

$q="SELECT d.*,b.name AS bank FROM {$dbg}.deposits AS d LEFT JOIN {$dbo}.`03_banks` AS b ON d.bank_id=b.id; ";
$sth=$db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count']=count($data['rows']);
$this->view->render($data,'banks/deposits');

}	/* fxn */


public function deposit(){
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
$ecid=$_SESSION['ucid'];

if(isset($_POST['submit'])){
	// pr($_POST);
	$post=$_POST['post'];
	$post['ecid']=$ecid;	
	$bank=fetchRow($db,"{$dbo}.`03_banks`",$post['bank_id']);
	$today=$_SESSION['today'];
	$reftoday=preg_replace("([^0-9/])", "", $today);	
	$post['reference'] = $reftoday."-".$bank['code'];
	$db->add("{$dbg}.deposits",$post);
	$url="banks/deposits";
	flashRedirect($url,"Added daily deposit.");
	exit;
}	/* fxn */


$data['banks'] = fetchRows($db,"{$dbo}.`03_banks`","*","name");
$this->view->render($data,'banks/deposit');

}	/* fxn */
	























}	/* BlankController */
