<?php

Class CollectionsController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */




public function payments0($params=NULL){

$db=&$this->model->db;$dbo=PDBO;
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
$nsy=$sy+1;
$psy=$sy-1;
$ndbm=VCPREFIX.$nsy.US.DBG;$ndbg=VCPREFIX.$nsy.US.DBG;
$pdbm=VCPREFIX.$psy.US.DBG;$pdbg=VCPREFIX.$psy.US.DBG;
$has_pdbg=($_SESSION['settings']['sy_end']>$_SESSION['settings']['sy_beg'])? 1:0;


if(isset($_GET['filter'])){
	require_once(SITE."functions/payments.php");
	require_once(SITE."functions/nextsy.php");
	$params = $_GET;
	
	$sort = $params['sort'];
	$order = $params['order'];
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
		
	$cond = NULL;
	$cond .= "";
	if (!empty($params['start'])){ $cond .= " AND p.date >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND p.date <= '".$params['end']."'"; }				

	if (!empty($params['lvlid'])){ $cond .= " AND cr.level_id = '".$params['lvlid']."'"; }					
	if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; }						
	if (!empty($params['scid'])){ $cond .= " AND p.scid = '".$params['scid']."'"; }					
	if (!empty($params['ecid'])){ $cond .= " AND p.ecid = '".$params['ecid']."'"; }				
	
	if (!empty($params['feetype_id'])){ $cond .= " AND p.feetype_id = '".$params['feetype_id']."'"; }				
	if (!empty($params['paytype_id'])){ $cond .= " AND p.paytype_id = '".$params['paytype_id']."'"; }				
	
	$where=" WHERE 1=1 $cond GROUP BY p.orno ORDER BY $sort $order $condlimits";	
	
$tr=array();


if($has_pdbg){	/* prevsy */
	$tr1=array(
		array('vsy'=>$psy,'pdbm'=>$pdbm,'pdbg'=>$pdbg,'ptable'=>'30_payments','ortype'=>'Enroll','ortype_id'=>1),
		array('vsy'=>$psy,'pdbm'=>$pdbm,'pdbg'=>$pdbg,'ptable'=>'30_payments_bills','ortype'=>'Bill','ortype_id'=>2),
	);		
} else {
	$tr1=array();
}

	
$tr2=array(		/* currsy */
	array('vsy'=>$sy,'pdbg'=>$dbg,'pdbm'=>$dbg,'ptable'=>'30_payments','ortype'=>'Enroll','ortype_id'=>1),
	array('vsy'=>$sy,'pdbg'=>$dbg,'pdbm'=>$dbg,'ptable'=>'30_payments_bills','ortype'=>'Bill','ortype_id'=>2),
);


$has_ndbg=dbgExists($db,$nsy);
if($has_ndbg){	/* nextsy */
	$tr3=array(
		array('vsy'=>$nsy,'pdbm'=>$ndbm,'pdbg'=>$ndbg,'ptable'=>'30_payments','ortype'=>'Enroll','ortype_id'=>1),
		array('vsy'=>$nsy,'pdbm'=>$ndbm,'pdbg'=>$ndbg,'ptable'=>'30_payments_bills','ortype'=>'Bill','ortype_id'=>2),
	);		
} else {
	$tr3=array();
}



$tr=array_merge($tr1,$tr2,$tr3);
	
$i=1;	

foreach($tr AS $row){	
	$vsy=$row['vsy'];$pdbm=$row['pdbm'];
	$pdbg=$row['pdbg'];$ptable=$row['ptable'];
	$ortype=$row['ortype'];$ortype_id=$row['ortype_id'];
	$q=" SELECT $vsy AS vsy,p.*,p.id AS payid,sc.name AS student,ec.name AS employee,
			ft.name AS feetype,pt.name AS paytype,cr.name AS classroom,
			'$ptable' AS ptable,'$ortype' AS ortype,'$ortype_id' AS ortype_id,
			SUM(p.amount) AS amount,SUM(p.amount) AS subtotal,count(p.id) AS numrows
		FROM {$pdbg}.{$ptable} AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS sc ON p.scid = sc.id
			LEFT JOIN {$dbo}.`00_contacts` AS ec ON p.ecid = ec.id
			LEFT JOIN {$pdbg}.05_summaries AS summ ON summ.scid = sc.id
			LEFT JOIN {$pdbg}.03_feetypes AS ft ON p.feetype_id = ft.id
			LEFT JOIN {$pdbg}.03_paytypes AS pt ON p.paytype_id = pt.id
			LEFT JOIN {$pdbg}.05_classrooms AS cr ON summ.crid = cr.id 
		$where; ";	
	debug($q);	
	$sth = $db->querysoc($q);
	${'t'.$i} = $sth->fetchAll();	
	$i++;
}	/* foreach */


$rows=array_merge($t1,$t2,$t3,$t4);
if($has_ndbg){
	$rows=array_merge($rows,$t5,$t6);
} else {
	$rows;
}



$data['rows'] = $rows; 
	
	$data['count']=$count=count($rows);
	$ornos=array();
	for($i=0;$i<$count;$i++){
		if($rows[$i]['numrows']>1){
			$ptable=$rows[$i]['ptable'];
			$sy=$rows[$i]['vsy'];
			$dbg=VCPREFIX.$sy.US.DBG;
			$ornos[$i]=getOrnoBreakdowns($db,"{$dbg}.`$ptable`",$rows[$i]['orno']);
		}
	}
	
		
	$data['ornos']=$ornos;

} 	/* filter */




if(!isset($_SESSION['feetypes'])){ 
	$_SESSION['feetypes'] = fetchRows($db,"{$dbo}.`03_feetypes`","*","name"); 	 } 
$data['feetypes'] = $_SESSION['feetypes'];	
if(!isset($_SESSION['paytypes'])){ 
	$_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*","name"); 	 } 
$data['paytypes'] = $_SESSION['paytypes'];	
if(!isset($_SESSION['levels'])){ 
	$_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","*","id"); 	 } 
$data['levels'] = $_SESSION['levels'];	
if(!isset($_SESSION['classrooms'])){ 
	$_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id"); 	 } 
$data['classrooms'] = $_SESSION['classrooms'];	

$this->view->render($data,'collections/paymentsCollections');


}	/* fxn */








}	/* CollectionsController */
