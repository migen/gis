<?php
Class FeesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	/* -- reg-9 and MIS-5,move methods to GController for other roles like teachers,i.e. clsAdvi */
	$acl = array(array(2,0),array(5,0),array(6,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);		
	
}


public function beforeFilter(){}	/* fxn */


public function index(){ $home=$_SESSION['home'];redirect($home); }	/* fxn */


public function dpr(){	/* daily payments report */
	require_once(SITE."functions/payments.php");
	$db=&$this->model->db;
	$dbo=PDBO;
	$dbg=PDBG;

	$data['today'] = $today=$_SESSION['today'];	
	$data['date'] = $date = isset($_GET['date'])? $_GET['date']:$today;
	$sort = isset($_GET['sort'])? $_GET['sort']:"p.orno";
	$order = isset($_GET['order'])? $_GET['order']:"DESC";
		
	$cond = "p.date='$date'";	
	$where=" WHERE $cond ORDER BY $sort $order ";	
	
$tr=array(
	array('ptable'=>'30_payments','ortype'=>'Enroll','ortype_id'=>1),
	array('ptable'=>'30_payments_bills','ortype'=>'Bill','ortype_id'=>2)
);
	
foreach($tr AS $row){
	$ptable=$row['ptable'];$ortype=$row['ortype'];$ortype_id=$row['ortype_id'];
	$q=" SELECT p.*,p.id AS payid,sc.name AS student,ec.name AS employee,
			ft.name AS feetype,pt.name AS paytype,cr.name AS classroom,
			'$ptable' AS ptable,'$ortype' AS ortype,'$ortype_id' AS ortype_id,
			SUM(p.amount) AS amount,SUM(p.amount) AS subtotal,count(p.id) AS numrows
		FROM {$dbg}.{$ptable} AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.scid = sc.id
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = sc.id			
			LEFT JOIN {$dbo}.`00_contacts` AS ec ON p.ecid = ec.id
			LEFT JOIN {$dbo}.`03_feetypes` AS ft ON p.feetype_id = ft.id
			LEFT JOIN {$dbo}.`03_paytypes` AS pt ON p.paytype_id = pt.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id 
		$where; ";	
	$sth = $db->querysoc($q);
	${'t'.$ortype_id} = $sth->fetchAll();

}	/* fxn */

$rows=array_merge($t1,$t2,$t3);
$data['rows'] = $rows; 				
$data['count'] = $count = count($rows);

	$ornos=array();
	for($i=0;$i<$count;$i++){
		if($rows[$i]['numrows']>1){
			$ptable=$rows[$i]['ptable'];
			$ornos[$i]=getOrnoBreakdowns($db,"{$dbg}.`$ptable`",$rows[$i]['orno']);
		}
	}
	
		
	$data['ornos']=$ornos;



	$this->view->render($data,'fees/dpr');

}	/* fxn */




} 	/* FeesController */