<?php

Class HrController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){

	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();		
	// $this->checkSettingsHr();
	
}

private function checkSettingsHr(){
	if(!isset($_SESSION['hr']['settings'])){ redirect('hr/reset');	 }
}	/* fxn */

public function emps(){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;

	$q="SELECT * FROM {$dbo}.`00_contacts` WHERE `id`=`parent_id` AND `role_id`<>'".RSTUD."';";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'hr/emps');

}	/* fxn */
public function empls(){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	
	$q="SELECT p.*,u.*,u.id AS id,u.person_id AS parent_id FROM {$dbg}.persons AS p 
		LEFT JOIN {$dbg}.users AS u ON p.id=u.person_id ;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'hr/emps');


}	/* fxn */

public function index(){  
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	initSession($db,'hr');	
	$data=isset($data)? $data:NULL;
	$data['payperiod_id']=isset($_GET['payperiod_id'])? $_GET['payperiod_id']:false;	
	$this->view->render($data,'hr/indexHr');
	

}	/* fxn */


public function payroll(){
	$dbo=PDBO;	
	require_once(SITE.'functions/hr.php');
	$db=&$this->model->db;$dbg=PDBG;	
	initSession($db,'hr');
	$data['sy']=DBYR;	
		
	$condrole="";
	if(isset($_GET['filter'])){		
		$r=explode(":",$_GET['payperiod']);
		$beg=$r[0];
		$end=$r[1];		
		$q="SELECT c.name AS employee,b.pcid,
				SUM(b.`hours_overtime`) AS total_hours_overtime,
				SUM(b.`hours_special`) AS hours_special			
			FROM {$dbo}.`00_contacts` AS c
				LEFT JOIN ( SELECT * FROM {$dbg}.60_dtr_emps WHERE `date` >='$beg' AND `date` <='$end' 
				) AS b ON b.pcid=c.id
			WHERE c.`id`=c.`parent_id` AND c.`role_id` > '".RSTUD."'					
			GROUP BY b.pcid; ";
		debug($q);
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		$data['rows']=&$rows;
		$data['count']=count($rows);		
	}	/* get */
		
	$this->view->render($data,'hr/payrollHr');

}	/* fxn */


public function initPayroll($params=NULL){
	$dbo=PDBO;	
	require_once(SITE.'functions/sync_hr.php');
	$payperiod_id=$params[0];
	$db=&$this->model->db;
	syncPayroll($db,$payperiod_id);
	$dbg=PDBG;	
	$q="SELECT * FROM {$dbg}.06_payperiods WHERE id='$payperiod_id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$home=$_SESSION['home'];
	flashRedirect($home,'Synced payroll for '.$row['name']);
	
}	/* fxn */

public function sessions(){ echo "<h3><a href='".URL."hr' >HR</a></h3>"; pr($_SESSION['hr']); }

public function reset(){	
	require_once(SITE.'functions/sessionize_hr.php');
	$db=&$this->model->db;
	sessionize_hr($db);
		
}	/* fxn */



public function test(){



if(isset($_GET['submit'])){
	pr($_GET);
	
}	/* get */

$data=NULL;
$this->view->render($data,'hr/test');
	

}	/* test */



}	/* HRController */
