<?php

Class DeliveryController extends Controller{	

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
	echo "dlvry ctlr";
	$this->view->render($data,'tests/index');

}	/* fxn */


public function view($params=NULL){
$data['poid']=$poid=isset($params[0])? $params[0]:false;
$data['date']=$date=isset($params[1])? $params[1]:false;
if(!$poid){ echo "PO id required."; exit; }
$db=&$this->model->db;$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;
$cond=($date)? "AND px.rxdate='$date' ":NULL;

require_once(SITE."functions/deliveryFxn.php");
require_once(SITE."functions/poFxn.php");
// if(isset($_GET['debug'])){
	$data['drrows']=poDelivery($db,$poid,$cond,$dbg);
	$data['drcount']=count($data['drrows']);
// }	/* debug */

$data1=getPO($db,$dbg,$poid);
$data=array_merge($data,$data1);

$dr=array();
foreach($data['rows'] AS $row){
	$prid=$row['product_id'];
	$q="SELECT * FROM {$dbo}.30_po_rx WHERE po_id='$poid' AND `product_id`='$prid' ORDER BY rxdate DESC; ";
	$sth=$db->querysoc($q);
	$dr[]=$sth->fetchAll();
}
$data['dr']=&$dr;
$data['count']=count($data['rows']);

// pr($data);exit;

$this->view->render($data,'delivery/viewDelivery');


}	/* fxn */


public function edit($params){
$db=&$this->baseModel->db;$dbo=PDBO;
$pxid=$params[0];
$q="SELECT *,px.id AS pxid FROM {$dbo}.30_po_rx AS px WHERE px.id='$pxid' LIMIT 1; ";
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbo}.30_po_rx",$post,"id='$pxid'");
}	/* post */
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'delivery/editDelivery');


}	/* fxn */





}	/* DeliveryController */
