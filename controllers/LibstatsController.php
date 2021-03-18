<?php

Class LibstatsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	// echo "libstats index";
	$data=NULL;
	$this->view->render($data,'libstats/index');
	

}	/* fxn */


public function sync(){
	$dbo=PDBO;	
	require_once(SITE."functions/libstats.php");
	$db=&$this->model->db;
	syncLibstatsRows($db);
	flashRedirect('libstats/index','Patron Lib Stats synced.');
	
}	/* fxn */

public function month($params=NULL){
	// echo "libstats month "; 
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
		
	$data['dif']=$dif=isset($params[0])? $params[0]:2;
	$moid=isset($params[1])? $params[1]:$_SESSION['moid'];
	$q="SELECT code FROM {$dbo}.88_ip_subdepts WHERE subdepartment_id='$dif' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$data['dcf']=$dcf=$row['code'];
	
	$moid=str_pad($moid,2,'0',STR_PAD_LEFT);
	
	$q="SELECT * FROM {$dbo}.months WHERE `index`='$moid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$data['morow']=$row;
	
	$stripmoid=ltrim($moid,'0');
	$q="
		SELECT ps.*,l.name AS level
		FROM {$dbg}.70_patronstats AS ps 
			INNER JOIN {$dbo}.`05_levels` AS l ON ps.lvl = l.id
		WHERE ps.subdepartment_id='$dif' AND moid='$stripmoid'
		ORDER BY ps.lvl ASC
	";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$data['year']=($moid<$_SESSION['settings']['month_start'])? DBYR+1:DBYR;
	$data['moid']=$moid;
	
	$this->view->render($data,'libstats/month');	
	
	
	

}	/* fxn */

public function tallyMonth($params=NULL){
$moid=isset($params[0])? $params[0]:$_SESSION['moid'];
require_once(SITE."functions/libstats.php");
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$dbp=DBP;

/* 1 patronstats row add row if not exists */
// syncLibstatsRows($db);

/* 2 tally patrons */
$x=array();
for($i=1;$i<32;$i++){ $x[]=$i; }	
foreach($x AS $xe){
	$this->tally($xe,$moid);
}

tallyMonthTotal($db,$moid);

flashRedirect('librarians','Tallied month library patrons stats.');

}	/* fxn */


public function tally($params=NULL){
$day=isset($params[0])? $params[0]:$_SESSION['day'];
$moid=isset($params[1])? $params[1]:$_SESSION['moid'];
require_once(SITE."functions/libstats.php");
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;$dbp=DBP;

$sy=($moid<$_SESSION['settings']['month_start'])? $_SESSION['sy']+1:$_SESSION['sy'];

$moid=str_pad($moid,2,'0',STR_PAD_LEFT);
$day=str_pad($day,2,'0',STR_PAD_LEFT);
$date=$sy.'-'.$moid.'-'.$day;

tallyDay($db,$date);
flashRedirect('librarians',"Tallied library patrons stats for $date.");


}	/* fxn */


public function aaa(){
	$db=$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;	

	
	
}


}	/* BlankController */
