<?php

Class SuppliersController extends Controller{	

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
	$this->view->render($data,'suppliers/index');

}	/* fxn */



public function reset($params){
$dbo=PDBO;
	require_once(SITE."functions/sessionize.php");
	$db	=&	$this->model->db;

	$ctlr 	= $params[0];
	$dbg	= PDBG;
		
	sessionizeSupplier($db,$dbg);
	$_SESSION['home']	= $_SESSION['user']['home'];
	redirect($ctlr);
} 	/* fxn */



public function edit($params){
$dbo=PDBO;
$db=&$this->model->db;
$data['suppid']=$suppid=$params[0];
$dbo=PDBO;$dbg=PDBG;
$q="SELECT c.name AS fullname,c.*,s.*,s.id AS suppucid FROM {$dbo}.`00_contacts` AS c
LEFT JOIN {$dbo}.suppliers AS s ON s.contact_id=c.id WHERE c.`id`='$suppid' LIMIT 1;";
$sth=$db->querysoc($q);
$data['row']=$row=$sth->fetch();

if(empty($row['suppucid'])){ $q="INSERT INTO {$dbo}.suppliers(`contact_id`)VALUES('$suppid');"; $db->query($q); }

if(isset($_POST['submit'])){
	// pr($_POST);
	$fullname=$_POST['contact']['fullname'];
	$codeaccount=$_POST['contact']['code'];
	$q="UPDATE {$dbo}.`00_contacts` SET `name`='$fullname',`code`='$codeaccount',`account`='$codeaccount' 
		WHERE `id`='$suppid' LIMIT 1; ";
	$db->query($q);
	$post=$_POST['post'];
	$db->update("{$dbo}.`suppliers`",$post,"`contact_id`='$suppid'");
	flashRedirect("suppliers/view/$suppid",'Supplier info edited.');
	exit;

}	/* fxn */

$this->view->render($data,'suppliers/edit');

}	/* fxn */



public function view($params){
$db=&$this->model->db;
$data['suppid']=$suppid=$params[0];
$dbo=PDBO;$dbg=PDBG;
$q="SELECT c.name AS fullname,c.*,s.*,s.id AS suppucid FROM {$dbo}.`00_contacts` AS c
LEFT JOIN {$dbo}.suppliers AS s ON s.contact_id=c.id WHERE c.`id`='$suppid' LIMIT 1;";
$sth=$db->querysoc($q);
$data['row']=$row=$sth->fetch();

if(empty($row['suppucid'])){ $q="INSERT INTO {$dbo}.suppliers(`contact_id`)VALUES('$suppid');"; $db->query($q); }
$this->view->render($data,'suppliers/view');

}	/* fxn */



public function add(){

include_once(SITE.'views/elements/params_sq.php');
require_once(SITE."functions/contactsFxn.php");
$db =& $this->model->db;
$dbo=PDBO;
$today = $_SESSION['today'];
$data['pcid'] = $pcid = lastContactId($db);


if(isset($_POST['submit'])){
	$row = $_POST;
	$fullname = trim($row['fullname']);		
	
	$q="SELECT id,name FROM {$dbo}.`00_contacts` WHERE `name` LIKE '%$fullname%' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$exists=(empty($row))? false:true;
	

	if(!$exists){
		$pcid++;	
		/* 1-contacts */
		$q = " INSERT IGNORE INTO {$dbo}.`00_contacts` (`id`,`parent_id`,
			`name`,`title_id`,`role_id`,`privilege_id`,`sy`,
			`created_date`) VALUES ('$pcid','$pcid','$fullname',99,'".RSUPP."','1','$sy','$today'); ";
					
		/* 3-ctp,photos,profiles,attendance */		
		$q .= " INSERT IGNORE INTO {$dbg}.06_employees (`contact_id`) VALUES ('$pcid'); ";
		$q .= " INSERT IGNORE INTO {$dbg}.06_attendance_employees (`ecid`) VALUES ('$pcid'); ";
		$q .= " INSERT IGNORE INTO ".PDBP.".photos(`contact_id`) VALUES ('$pcid'); ";
		$q .= " INSERT IGNORE INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`,`ctpb`) VALUES ('$pcid','pass','pass'); ";
		
	} else {
		$url="suppliers/edit/".$row['id'];
		flashRedirect($url,'Similar supplier exists.');
	}
	/* has fullname */ 	

	// pr($q); exit;	
	$this->model->db->query($q);
	$url="suppliers/edit/$pcid";
	flashRedirect($url,'Supplier added, please add info.');

	
}	/* post */
	

$this->view->render($data,'suppliers/add');

}	/* fxn */




public function payments(){
$dbo=PDBO;

if(isset($_GET['filter'])){
	$get = $_GET;
	$cond = NULL;
	$cond .= "";
	if (!empty($get['supplier'])){ $cond .= " AND c.id = '".$get['supplier']."'"; }				
	if (!empty($get['dateone'])){ $cond .= " AND p.date >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND p.date <= '".$get['datetwo']."'"; }				
	
	$limits = $get['limits'];
	$offset = ($get['page']-1)*$limits;
	$sort   = (isset($get['sort']))?$get['sort']:'c.name';
	$order  = (isset($get['order']))?$get['order']:'DESC';
		
	$data['sy']=$sy = isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;
	$q = "SELECT po.*,c.name AS supplier,po.id AS poid,SUM(p.amount) AS payments
		FROM {$dbo}.`30_po_payments` AS p
			INNER JOIN {$dbo}.`30_po` AS po ON p.po_id = po.id 	
			INNER JOIN {$dbo}.`00_contacts` AS c ON po.suppid = c.id ";	
		$q .= " WHERE 	1=1 $cond  GROUP BY c.id ORDER BY $sort $order LIMIT $limits OFFSET $offset ; ";
	$data['q']=$q;
			
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

} else {
	$where = "WHERE role_id = '".RSUPP."'";
	$data['suppliers']	= $this->model->fetchRows(DBO.".`00_contacts`",'id,parent_id,`name`','name',$where);			

}	

$data['today']=$_SESSION['today'];
$this->view->render($data,'suppliers/payments');


}	/* fxn */


public function payDetails($params=NULL){
$data['suppid']=$suppid=$params[0];
$data['dateone']=$dateone=isset($params[1])? $params[1]:DBYR.'-01-01';
$data['datetwo']=$datetwo=isset($params[2])? $params[2]:DBYR.'-12-31';
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

$q="SELECT p.*,po.invoice,po.total 
FROM {$dbo}.`30_po_payments` AS p
INNER JOIN {$dbo}.`30_po` AS po ON po.id=p.po_id
WHERE po.suppid='$suppid' AND p.date>='$dateone' AND p.date<='$datetwo' ORDER BY p.date DESC;

";
// pr($q);
$sth=$db->querysoc($q);

$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$q="SELECT c.name AS supplier FROM {$dbo}.`00_contacts` AS c WHERE c.id='$suppid' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['supp']=$supp=$sth->fetch();

$data['page']="Supplier Payment Details - ".$supp['supplier'];

// pr($data);
$this->view->render($data,'suppliers/payDetails');


}	/* fxn */












}	/* SuppliersController */
