<?php

Class PayrollController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;		
	initSession($db,'hr');	
	
	if(isset($_GET['filter'])){

	
	}	/* get */
	
	$data['payperiod_id']=isset($_GET['payperiod_id'])? $_GET['payperiod_id']:false;
	$this->view->render($data,'payroll/indexPayroll');
	

}	/* fxn */




public function report($params=NULL){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;		
	$payperiod_id=isset($params[0])? $params[0]:false;
	$data['payperiod_id']=&$payperiod_id;
	
if($payperiod_id){
	$q="SELECT p.*,c.name AS employee,c.code AS emplcode,m.*
		FROM {$dbg}.60_payrolls AS p 
			INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=p.ecid
			LEFT JOIN {$dbg}.06_paymaster AS m ON c.id=m.ecid
		WHERE p.payperiod_id='$payperiod_id'
		ORDER BY c.name ASC;";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);

}	/* payperiod_id */
		

	$this->view->render($data,'payroll/reportPayroll');
	



}	/* fxn */




public function processDtr($params=NULL){
$payperiod_id=isset($params[0])? $params[0]:false;
$data['payperiod_id']=&$payperiod_id;
$db=&$this->model->db;
$dbg=PDBG;

$q="SELECT * FROM {$dbg}.06_payperiods WHERE id='$payperiod_id' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$begdate=$row['begdate'];
$enddate=$row['enddate'];



$q="
	SELECT 
		pcid,
		sum(hours_overtime) AS hours_overtime_regular,
		sum(hours_tardy) AS hours_tardy		
	FROM {$dbg}.60_dtr_emps 
	WHERE 
		`date`>='$begdate' AND
		`date`<='$enddate' AND
		`paydaytype_id`=1
	GROUP BY pcid;
		
";

pr($q);

$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
pr($rows);

echo "<hr />";

/* 
update 2016_dbmaster_abc.03_tuitions AS a
INNER JOIN (
	select * FROM 2016_dbmaster_abc.levels
) AS b ON b.id = a.level_id
SET a.label = b.name
 */


$q="


	UPDATE {$dbg}.60_payrolls AS a	
	INNER JOIN (
		SELECT 
			pcid,sum(hours_overtime) AS hours_overtime_regular
		FROM {$dbg}.60_dtr_emps 
		WHERE 
			`date`>='$begdate' AND `date`<='$enddate' AND `paydaytype_id`=1
		GROUP BY pcid	
	) AS b ON b.pcid=a.pcid
	SET a.hours_overtime_regular = b.hours_overtime_regular
	WHERE a.`payperiod_id`='$payperiod_id' ;

";
pr($q);

$sth=$db->query($q);
echo ($sth)? "Success":"Fail";





}	/* fxn */


public function employees(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$cond=(isset($_GET['all']))? NULL:" AND m.paygroup_id>0 "; 
	$order=isset($_GET['order'])? $_GET['order']:"c.name";
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
foreach($posts AS $post){  $q.="UPDATE {$dbg}.06_paymaster SET paygroup_id='".$post['pgid']."' WHERE ecid='".$post['ecid']."' LIMIT 1; "; }
		$db->query($q);
		flashRedirect("payroll/employees","Saved.");
		exit;
	}	/* post */
	$q="SELECT c.id AS ecid,c.is_active,c.code AS emplcode,c.name AS employee,m.paygroup_id
	FROM {$dbo}.`00_contacts` AS c
	INNER JOIN {$dbg}.06_paymaster AS m ON c.id=m.ecid
	WHERE c.role_id>'".RSTUD."' AND c.role_id<>'".RSUPP."' $cond ORDER BY $order;";
	debug($q,"payrollCtrl: employees");
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'payroll/employeesPayroll');

}	/* fxn */





}	/* PayrollController */
