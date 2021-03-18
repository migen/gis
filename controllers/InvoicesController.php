
<?php

/* 	
	gisreferences
	$_SESSION['contacts'] = isset($_SESSION['contacts'])? $_SESSION['contacts']:$this->model->fetchRows(PDBO.".`00_contacts`",'id,parent_id,name');
	$data['contacts'] = $_SESSION['contacts']; 
*/


Class InvoicesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


/* use ledgers/payments as reference */
public function index(){ 
	$dbo=PDBO;
	$db=&$this->model->db;
	require_once(SITE."functions/orno.php");
	$data['home']	= $_SESSION['home'];	
		
if(isset($_GET['filter'])){
	$post = $_GET;
	$cond = NULL;
	$cond .= "";	
	if (!empty($post['dateone'])){ $cond .= " AND i.date >= '".$post['dateone']."'"; }				
	if (!empty($post['datetwo'])){ $cond .= " AND i.date <= '".$post['datetwo']."'"; }				
	if (!empty($post['feetype_id'])){ $cond .= " AND i.feetype_id = '".$post['feetype_id']."'"; }				
	if (!empty($post['payortype_id'])){ $cond .= " AND i.payortype_id = '".$post['payortype_id']."'"; }				
	if (!empty($post['scid'])){ $cond .= " AND i.scid = '".$post['scid']."'"; }				
		
	$dateone = $post['dateone'];
	$datetwo = $post['datetwo'];
	$limits = $post['limits'];
	$offset = ($post['page']-1)*$limits;
	$sort   = (isset($post['sort']))?$post['sort']:'i.date';
	$order  = (isset($post['order']))?$post['order']:'DESC';
		
	$sy = $post['sy'];
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$q = "SELECT i.*,if(i.scid=0,i.guest,c.name) AS customer,e.name AS employee,f.name AS feetype,i.id AS invid,por.code AS porcode
		FROM {$dbg}.invoices AS i
			LEFT JOIN {$dbo}.`00_contacts` AS c ON i.scid = c.id	
			LEFT JOIN {$dbo}.`00_contacts` AS e ON i.ecid = e.id	
			LEFT JOIN {$dbo}.`03_feetypes` AS f ON i.feetype_id = f.id 
			LEFT JOIN {$dbg}.tpayortypes AS por ON i.payortype_id = por.id ";	
		$q .= " WHERE 	1=1 $cond  ORDER BY $sort $order LIMIT $limits OFFSET $offset ; ";			
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
		
} /* get */

	$dbg = PDBG;
	$data['payortypes'] = $this->model->fetchRows("{$dbg}.tpayortypes","*","name");
	$data['feetypes'] = $this->model->fetchRows("{$dbo}.`03_feetypes`","*","name");
	$data['paytypes'] = $_SESSION['paytypes'];	
	$data['last_orno'] = lastOrno($db,$_SESSION['pcid'],$dbg);
	
	$this->view->render($data,'invoices/index');
	

}	/* fxn */





public function orno($params=NULL){
$dbo=PDBO;	
$ssy = $_SESSION['sy'];
$ecid = $_SESSION['ucid'];
$data['ecid'] = $ecid = isset($params[0])? $params[0]:$ecid;
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
$dbg = VCPREFIX.$sy.US.DBG;

if(isset($_POST['submit'])){
	$orno=trim($_POST['orno']);
	$q = " UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '$ecid' LIMIT 1;";
	$this->model->db->query($q);
	$_SESSION['orno'] = $orno;	
	$url = "invoices/orno/$ecid";	
	flashRedirect($url,'Last OR Number updated.');
}	/* post */

if(isset($_POST['find'])){
	pr($_POST);

}	/* find */


$data['empl'] = $this->model->fetchRow(PDBO.'.`00_contacts`',$ecid);
$data['fullname'] = $data['empl']['name'];

require_once(SITE."functions/orno.php");
$db =& $this->model->db;
$data['orno'] = lastOrno($db,$_SESSION['pcid'],$dbg);

$data1 = maxOrno($db,$dbg);
$data = array_merge($data,$data1);

$this->view->render($data,'invoices/orno');

}	/* fxn */



private function getCustomerStudent($scid){
	$db=&$this->model->db;
	$dbg=PDBG;
	$dbo=PDBO;	
	$q = "
		SELECT 
			c.id AS scid,c.name AS name,c.name AS customer,c.code,c.code AS custcode,
			cr.name AS classroom,l.name AS level,sxn.name AS section
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON c.id = summ.scid
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
		WHERE c.id = '$scid' LIMIT 1;
	";
	// pr($q);
	
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */

private function getCustomerOther($orno){
	$db=&$this->model->db;
	$dbo=PDBO;
	$dbg=PDBG;	
	$q=" SELECT *,NULL AS code,NULL AS custcode,payer AS customer,NULL AS level,NULL AS section 
		FROM {$dbo}.30_payments_bills WHERE `orno` = '$orno' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


public function edit($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/orno.php");

$ssy = $_SESSION['sy'];
$data['invid'] = $invid = isset($params[0])? $params[0]:0;
$db=&$this->model->db;
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;

if(isset($_POST['update'])){
	unset($_POST['update']);
	$post = $_POST;
	// pr($post); exit;
	$db->update("{$dbg}.invoices",$post,"`id` = '$invid'");
	$url = "invoices/edit/$invid";
	flashRedirect($url,'Invoice updated.');
	exit;		

}	/* post */


$data['paytypes'] = $_SESSION['paytypes'];
$data['feetypes'] = $_SESSION['feetypes'];

/* 1 payments */
$q="SELECT p.*,b.name AS bank,pt.name AS paytype,p.id AS payid
FROM {$dbo}.30_payments AS p 
	LEFT JOIN {$dbo}.`03_banks` AS b ON p.bank_id = b.id
	LEFT JOIN {$dbo}.`03_paytypes` AS pt ON p.paytype_id = pt.id
WHERE p.`invoice_id` = '$invid';
";
$sth = $db->querysoc($q);
$data['pays'] = $sth->fetchAll();
$data['count'] = count($data['pays']);
$data['last_orno'] = lastOrno($db,$_SESSION['ucid'],$dbg);
if(!isset($_SESSION['banks'])){ $_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","*","name"); } 
$data['banks'] = $_SESSION['banks'];	


/* 2 update invoice */
$q = "
UPDATE {$dbg}.invoices AS x 
LEFT JOIN (
	SELECT p.invoice_id,p.scid,SUM(p.amount) AS paid FROM {$dbo}.30_payments AS p WHERE p.`invoice_id` = '$invid'
) AS y ON x.id = y.invoice_id
SET x.paid=y.paid,x.balance=x.amount-y.paid
WHERE x.id = '$invid'
;
";
// pr($q);
$db->query($q);

/* 3 get invoice */
$q = " SELECT i.*,if(i.scid=0,i.guest,c.name) AS customer,e.name AS employee
FROM  {$dbg}.invoices AS i 
	LEFT JOIN {$dbo}.`00_contacts` AS c ON i.scid = c.id
	LEFT JOIN {$dbo}.`00_contacts` AS e ON i.ecid = e.id
WHERE i.`id` = '$invid' LIMIT 1; ";
$sth = $db->querysoc($q);
$data['row'] = $sth->fetch();

$this->view->render($data,'invoices/edit'); 

}	/* fxn */



public function delete($params){
	$dbo=PDBO;
	require_once(SITE."functions/logs.php");
	$db	=&	$this->model->db;

	$id = $params[0];
	$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;

	$q = "SELECT * FROM {$dbg}.`invoices` WHERE `id` = '$id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$scid = $row['scid'];

	$q="DELETE FROM {$dbg}.invoices WHERE id = '$id' LIMIT 1; ";
	$db->query($q);

	$q="DELETE FROM {$dbo}.30_payments WHERE `invoice_id` = '$id'; ";
	$db->query($q);	
	
	/* 2 logs */
	$ucid = $_SESSION['ucid'];
	$axn = $_SESSION['axn']['delete_payment'];
	$details = "Invoice Date: ".$row['date'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $row['scid'];
	$more['orno'] = $row['orno'];
	$more['feeid'] = $row['feetype_id'];
	$more['amount'] = $row['amount'];
	logThis($db,$ucid,$axn,$details,$more);	
		
	$home=$_SESSION['home'];
	flashRedirect($home,'Invoice deleted.');


}	/* fxn */


public function orbooklets(){
$db=&$this->model->db;
$dbo=PDBO;
$q="SELECT c.name AS employee,o.*
FROM {$dbo}.`03_orbooklets` AS o 
	LEFT JOIN {$dbo}.`00_contacts` AS c ON o.ecid=c.id
ORDER BY c.name;
";
$sth=$db->query($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);
$this->view->render($data,'invoices/orbooklets');

}	/* fxn */



public function printorno($params=NULL){
$dbo=PDBO;	
$url = $_SESSION['home'];
$db=&$this->model->db;

if(isset($_GET['orno'])){
	$orno = trim($_GET['orno']);
} else {
	$orno = trim($params[0]);
}
// $orno = preg_replace("([^0-9-/])","",$orno);
$data['orno'] = $orno;

$ssy = $_SESSION['sy'];
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;

$tr=array(
	array('ptable'=>'30_payments','ortype'=>'Enroll','ortype_id'=>1),
	array('ptable'=>'30_payments_bills','ortype'=>'Bill','ortype_id'=>2)
);

foreach($tr AS $row){
	$ptable=$row['ptable'];$ortype=$row['ortype'];$ortype_id=$row['ortype_id'];
	$q = " SELECT 
			$sy AS vsy,p.*,f.name AS feetype,t.name AS paytype,c.name AS employee,		
			'$ptable' AS ptable,'$ortype' AS ortype,'$ortype_id' AS ortype_id,p.id AS payid 
		FROM  {$dbg}.{$ptable} AS p
			LEFT JOIN {$dbo}.`03_feetypes` AS f ON p.feetype_id = f.id
			LEFT JOIN {$dbo}.`03_paytypes` AS t ON p.paytype_id = t.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ecid = c.id		
		WHERE `orno` = '$orno'; ";
	// pr($q);
	$sth = $db->querysoc($q);
	${'t'.$ortype_id} = $sth->fetchAll();

}	/* fxn */

$rows=array_merge($t1,$t2);
$data['rows'] = $rows; 

$data['scid'] = $scid = (isset($rows[0]['scid']) && ($rows[0]['scid']>0))? $rows[0]['scid']:false;

/* 2 */

if($scid){
	$data['customer'] = $this->getCustomerStudent($scid);
} else {
	$data['customer'] = $this->getCustomerOther($orno);
}

$ortotal=0;
foreach($rows AS $row){
	$ortotal+=$row['amount'];
}
$data['ortotal'] = $ortotal;

$vfile = 'invoices/printorno';
$this->view->render($data,$vfile);

}	/* fxn */




public function cancelPayBill($params=NULL){
$dbo=PDBO;
$db=&$this->model->db;
$dbg=PDBG;
$payid=$params[0];
$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;

/* 2 */
$q="UPDATE {$dbo}.30_payments_bills SET `amount`='0' WHERE `id`='$payid' LIMIT 1; ";
$sth=$db->query($q);
$msg=($sth)? 'Cancelled Bill payment.':"Cancel bill payment $payid failed.";

$url=$_SESSION['home'];
flashRedirect($url,$msg);

}	/* fxn */


public function cancelPayLedger($params=NULL){
$db=&$this->model->db;
$dbg=PDBG;
$payid=$params[0];
$data['sy'] = $sy = isset($params[1])? $params[1]:DBYR;
$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;

/* 2 */
$q="UPDATE {$dbo}.30_payments SET `amount`='0' WHERE `id`='$payid' LIMIT 1; ";
$sth=$db->query($q);
$msg=($sth)? 'Cancelled Ledger payment.':"Cancel ledger payment $payid failed.";

$url=$_SESSION['home'];
flashRedirect($url,$msg);

}	/* fxn */


public function editOrnoBill($params=NULL){
	$db=&$this->model->db;
	$orno=$params[0];
	$payid=$params[1];
	$data['sy'] = $sy = isset($params[2])? $params[2]:DBYR;
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$post['amount'] = str_replace(",","",$post['amount']);						
		$db->update("{$dbg}.`30_payments_bills`",$post,"`id`='$payid'");
		$url="invoices/printorno/$orno/$sy";
		flashRedirect($url,'Edited orno.');
	}	/* fxn */

	$q="SELECT c.name AS student,p.* FROM {$dbo}.30_payments_bills AS p
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid=c.id WHERE p.`id`='$payid' LIMIT 1; ";	
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$data['ortype']="Bill";
	$data['banks']=$_SESSION['banks'];
	$data['paytypes']=$_SESSION['paytypes'];
	$data['feetypes']=$_SESSION['feetypes'];
	$this->view->render($data,'invoices/editorno');
	
}	/* fxn */



public function editOrnoLedger($params=NULL){
	$dbo=PDBO;
	$db=&$this->model->db;
	$orno=$params[0];
	$payid=$params[1];
	$data['sy'] = $sy = isset($params[2])? $params[2]:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;	
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$post['amount'] = str_replace(",","",$post['amount']);			
		$db->update("{$dbg}.`30_payments`",$post,"`id`='$payid'");
		$url="invoices/printorno/$orno/$sy";
		flashRedirect($url,'Edited orno.');
	}	/* fxn */

	$q="SELECT c.name AS student,p.* FROM {$dbo}.30_payments AS p
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.scid=c.id WHERE p.`id`='$payid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$data['ortype']="Ledger";
	$data['banks']=$_SESSION['banks'];
	$data['paytypes']=$_SESSION['paytypes'];	
	$data['feetypes']=$_SESSION['feetypes'];
	$data['view']=$view='invoices/editorno';
	$this->view->render($data,$view);
	
}




}	/* InvoicesController */
