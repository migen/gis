<?php

class SyncsController extends Controller{	
/* Syncs and Counts for - admins,registrars,and mis,guidance controllers  */
	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	parent::beforeFilter();		
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	$acl = array(array(5,0));
	$this->permit($acl);				
	
}	/* fxn */

public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'syncs/indexSyncs');
}	/* fxn */



public function syncProfiles($params=NULL){		
$dbo=PDBO;
	$this->model->syncProfiles();
	if(isset($params[0])){ $url = $_SESSION['home'].DS.$params[0]; $this->flashRedirect($url,'Contacts Profiles Synced');  }
}	/* fxn */




public function syncAttendanceMonths($params){
	$dbo=PDBO;
$new_sy = $params[0];
	$this->model->syncAttendanceMonths($new_sy);
	if(isset($params[1])){ $url = $_SESSION['home'].DS.$params[1]; $this->flashRedirect($url,'Attendance Months Synced');  }

}	/* fxn */
	
	
public function syncSummext(){		
$dbo=PDBO;
	require_once(SITE.'functions/syncSummaries.php');
	$db=&$this->model->db;$dbg=PDBG;
	syncSummext($db,$dbg);	
}	/* fxn */


public function trimSS($params=NULL){		
$dbo=PDBO;
	$ssy = $_SESSION['sy'];
	$this->model->trimSummaries(PDBG,PDBG,$ssy);
	if(isset($params[0])){ $url = $_SESSION['home'].DS.$params[0]; $this->flashRedirect($url,'Summaries Trimmed');  }			
}	/* fxn */


public function syncCStudents($params=NULL){		
$dbo=PDBO;
	$ssy = $_SESSION['sy'];
	$this->model->syncCStudents(PDBG,PDBG,$ssy);
	
	if(isset($params[0])){ $url = $_SESSION['home'].DS.$params[0]; $this->flashRedirect($url,'Contacts Students Synced');  }		
			
}	/* fxn */


public function trimCS($params=NULL){		
$dbo=PDBO;
	$ssy = $_SESSION['sy'];
	$this->model->trimCStudents(PDBG,PDBG,$ssy);
	if(isset($params[0])){ $url = $_SESSION['home'].DS.$params[0]; $this->flashRedirect($url,'Summaries Trimmed');  }			
}	/* fxn */





public function syncAttemps($params){		
$dbo=PDBO;
	$this->model->syncAttendanceEmployees(PDBG,PDBG,DBYR);		
}	/* fxn */
    

public function syncCQ($params=null){
	$this->model->syncCrsQtrs();				
			
}	/* fxn */
	

public function syncPhotos($params=NULL){		
	$this->model->syncPhotos();
		
}	/* fxn */
  

public function syncCtp($params=NULL){
	$this->model->syncCtp();

}	/* fxn   */





public function syncAQ($params=NULL){
	$this->model->syncAdvQtrs();
}	/* fxn */
 

public function syncAttTimes($params=NULL){
	$this->model->syncAttTimes();
}	/* fxn   */
  

public function syncTuitionSummaries($params=NULL){	
	$dbo=PDBO;
	require_once(SITE.'functions/syncer.php');
	$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	syncTuitionSummaries($db,$dbg);
	echo "Synced Tsum SY$sy";
}	/* fxn */


public function syncSACS($params){
	$dept_id = $params[0];
	$this->model->syncSubjectsCoordinators($dept_id);
}	/* fxn */


  
public function tuitions($params=NULL){
	$sy = isset($params[0])? $params[0]:DBYR;
	$level_id = isset($params[1])? $params[1]:4;
	$num = isset($_GET['num'])? $_GET['num']:1;
	$dbg=VCPREFIX.$sy.US.DBG;
	$q = "INSERT INTO {$dbo}.`03_tuitions`(`level_id`,`num`) VALUES ('$level_id','$num');";
	$this->model->db->query($q);
}	/* fxn */
 


public function syncClasslist($params){	/* for sectioning only */
$dbo=PDBO;
$ssy	= $_SESSION['sy'];
$crid	= $params[0];
$sy		= isset($params[1])? $params[1]:$ssy;
$data['home'] = $home	= $_SESSION['home'];
$dbg=VCPREFIX.$sy.US.DBG;

$q = " SELECT c.`id` AS `scid` FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
WHERE summ.`crid` = '$crid';";
$sth = $this->model->db->querysoc($q);
$a = $sth->fetchAll();
$ar = buildArray($a,'scid');

$q = " SELECT sum.`scid` AS `scid` FROM {$dbg}.05_summaries AS sum WHERE sum.`crid` = '$crid';";
$sth = $this->model->db->querysoc($q);
$b = $sth->fetchAll();
$br = buildArray($b,'scid');

$ix = array_diff($ar,$br);

$q = "";
foreach($ix AS $scid){
	$q.=" INSERT INTO {$dbg}.05_summaries(`scid`,`crid`,`acid`)
			SELECT 
				'$scid',cr.id,cr.acid
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			WHERE c.id = '$scid';
	";
}

$sth=$this->model->db->query($q);		
echo ($sth)? "Synced":"Failed";

}	/* fxn */



public function photo($params=NULL){
	$pcid = $params[0];$dbo = PDBO;
	$q = "INSERT INTO ".PDBP.".photos(`contact_id`) VALUES ('$pcid');  ";
	$this->model->db->query($q);
	$_SESSION['message'] = 'Photo id synced.';

}	/* fxn */



/* ------------   -------------------------- */




public function patronStats(){
$dbo=PDBO;
$db=&$this->model->db;$dbg=PDBG;$dbg=PDBG;
$levels=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
$months=array(1,2,3,4,5,6,7,8,9,10,11,12);

$q1="";
foreach($levels AS $level){
	foreach($months AS $month){
		$q="SELECT id FROM {$dbg}.70_patronstats WHERE moid='$month' AND lvl='$level' LIMIT 1;";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		if(empty($row)){
			$q1.="INSERT INTO {$dbg}.70_patronstats(`lvl`,`moid`)VALUES('$level','$month'); ";
		}
	}
}	
$db->query($q1);

echo "Done synced.";

}	/* fxn */



/* 
update 2016_dbmaster_abc.03_tuitions AS a
INNER JOIN (
	select * FROM 2016_dbmaster_abc.levels
) AS b ON b.id = a.level_id
SET a.label = b.name
 */
public function ctypes(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$q="UPDATE {$dbg}.50_grades AS a INNER JOIN {$dbg}.05_courses AS b ON b.id=a.course_id SET a.crstype_id=b.crstype_id; ";
	pr($q);
	echo "Add exe.";
	if(isset($_GET['exe'])){ $db->query($q); }

}	/* fxn */



public function syncSS($params=NULL){		
$dbo=PDBO;
	require_once(SITE."functions/syncFxn.php");
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->baseModel->db;

	syncSummaries($db,$dbg);
	
	/* 2 */
	require_once(SITE.'functions/syncSummaries.php');
	syncSummext($db,$dbg);
	
	if(isset($params[0])){ $url = $_SESSION['home'].DS.$params[0]; $this->flashRedirect($url,'Summaries Synced');  }
}	/* fxn */


public function syncAttendance($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/syncFxn.php');
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->baseModel->db;
	
	syncAttendance($db,$dbg);

}	/* fxn */



public function syncAll($params=null){
$dbo=PDBO;
	
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->baseModel->db;
	if(isset($_GET['exe'])){
		require_once(SITE."functions/syncFxn.php");
		require_once(SITE.'functions/syncSummaries.php');
		
		/* syncs */
		syncSummaries($db,$dbg);
		syncSummext($db,$dbg);
		syncAttendance($db,$dbg);		
		
				
	}	/* exe */
	
	$data['sy']=$sy;
	$this->view->render($data,"abc/defaultAbc");
	
}	/* fxn */



public function syncSummariesAcid(){
	$dbg=PDBG;$dbo=PDBO;$db=$this->baseModel->db;
	$q="UPDATE {$dbg}.05_summaries AS summ
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		SET summ.acid=cr.acid;";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";
		
}	/* fxn */


public function syncEnrollments($params=NULL){			
$dbo=PDBO;
	$sy=isset($params[0])?$params[0]:DBYR;
	$db=&$this->baseModel->db;
	require_once(SITE."functions/syncFxn.php");	
	syncTables($db,$sy);

}	/* fxn */

public function payables($params=NULL){			
	$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])?$params[0]:$_SESSION['year'];
	$data['lvl']=$lvl=isset($params[1])?$params[1]:4;
	$db=&$this->baseModel->db;
	require_once(SITE."functions/syncAxis.php");	
	if(isset($_GET['submit'])){
		$get=$_GET;
		extract($get);		
		syncPayables($db,$sy,$lvl);
	}
	$data['levels']=$_SESSION['levels'];
	$this->view->render($data,"syncs/payablesSyncs");

}	/* fxn */


public function tables($params=NULL){			
	$sy=isset($params[0])?$params[0]:DBYR;
	$db=&$this->baseModel->db;
	require_once(SITE."functions/syncFxn.php");	
	syncTables($db,$sy);

}	/* fxn */


public function levelConductsToSummaries($params){
	if(!isset($params[0])){ pr("Needs parameter level_id."); exit; }
	require_once(SITE.'functions/syncConducts.php');
	$db=&$this->baseModel->db;	
	$data=syncLevelConducts($db,$params);
	if(isset($_GET['debug'])){
		$this->view->render($data,"syncs/levelConductsToSummariesSyncs");			
	}
	
}	/* fxn */


public function promlvl($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$ndbg=VCPREFIX.($sy+1).US.DBG;
	$nextsy=($sy+1);
	$q1="UPDATE {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		SET summ.promlvl=(cr.level_id+1); ";	
	pr("&exe");pr($q1);
	if(isset($_GET['exe'])){ $sth=$db->query($q1);echo ($sth)? "Qry1: Success":"Qry1 Fail"; }	
	
	echo "<hr />";
	$q2="UPDATE {$dbo}.05_enrollments AS en
		LEFT JOIN {$dbg}.05_summaries AS summ ON (en.sy=$nextsy && en.scid=summ.scid)		
		LEFT JOIN {$dbg}.05_classrooms AS cr ON (cr.level_id=summ.promlvl && cr.section_id=1)
		SET en.crid=cr.id WHERE en.sy=$nextsy; ";	
	pr("&exe2");pr($q2);

	if(isset($_GET['exe2'])){ $sth=$db->query($q2);echo ($sth)? "Qry2: Success":"Qry2: Fail"; }	
}	/* fxn */

public function currlvl($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="UPDATE {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		SET summ.currlvl=(cr.level_id); ";	
	pr("&exe");pr($q);
	if(isset($_GET['exe'])){ $sth=$db->query($q);echo ($sth)? "Success":"Fail"; }	
}	/* fxn */


public function arToEnrollments($params=null){
	if(!isset($params[0])){ pr("Set params0 AS sy."); exit; }
	$sy=$params[0];$sch=VCFOLDER;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="UPDATE {$dbo}.05_enrollments AS en
		INNER JOIN {$dbg}.{$sch}_ar_{$sy} AS ar ON (ar.scid=en.scid && en.sy=$sy)
		SET en.balance=ar.balance;";
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";
	pr("Press Ctlr + W to close.");
		
}	/* fxn */


public function arCrid($params=null){
	if(!isset($params[0])){ pr("Set params0 AS sy."); exit; }
	$sy=$params[0];$sch=VCFOLDER;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$q="UPDATE {$dbg}.{$sch}_ar_{$sy} AS ar
		INNER JOIN {$dbg}.05_summaries AS summ ON ar.scid=summ.scid
		SET ar.crid=summ.crid;";
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";
	pr("Press Ctlr + W to close.");
		
}	/* fxn */






}	/* SyncsController */