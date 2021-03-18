<?php

Class PromotersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$acl = array(array(5,0),array(9,0),array(7,2));
	$this->permit($acl,$strict=false);				
	
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'enrollment/indexEnrollment');

}	/* fxn */


	

/* 1) s.crid,s.is_sectioned 2) sum.crid,sum.acid,c.am  */ 
public function student($params=NULL){
$dbo=PDBO;
/* 1 */
$has_axis=&$_SESSION['settings']['has_axis'];
require_once(SITE."functions/enrollmentFxn.php");
require_once(SITE."functions/logs.php");
require_once(SITE."functions/dbyrFxn.php");
$data['scid']=$scid=isset($params[0])? $params[0]:false;
// $data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['year'];
$data['sy']=$sy=DBYR;
$data['home']=$home=$_SESSION['home'];
$data['brid']=$brid=$_SESSION['brid'];
$data['srid']=$srid=$_SESSION['srid'];
$data['ecid']=$ecid=$_SESSION['ucid'];
$data['today']=$today=$_SESSION['today'];
$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->baseModel->db;



/* 2 */
if(isset($_POST['submit'])){
	$post=$_POST;$promlvl=$post['promlvl'];
	promoteStudent($db,$scid,$promlvl);
	flashRedirect("promoters/student/$scid","Promoted.");
}	/* post */

/* 3 */
if(!isset($_SESSION['level_classrooms'])){ require_once(SITE.'functions/sessionize_classroom.php');sessionizeLevelClassrooms($db); }
/* 4 */
// $dbyr_exists=checkDbyr($db,$sy); if(!$dbyr_exists){ exit; }



// exit;


/* 5 */
if($scid){ 	/* has user */
	/* 5-1 */
	$scid_exists=checkContact($db,$scid); if(!$scid_exists){ exit; }		
	/* 5-2 */
	$data['row']=$row=promotingStudent($db,$sy,$scid); 
	$data['row_is_student']=$row_is_student=rowIsStudent($row); if(!$row_is_student){ exit; }
	$data['is_promoted']=$is_promoted=($row['promsy']==(DBYR+1))? true:false;
		

	
}	/* has user */

$url="promoters/student/$scid/$sy";
$vfile="promoters/studentPromoters";vfile($vfile);

$this->view->render($data,$vfile);


}	/* fxn */


public function rosterNextSY(){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbg=PDBG;$nextsy=DBYR+1;
	$ndbg=VCPREFIX.$nextsy.US.DBG;
	$q="UPDATE {$ndbg}.05_summaries AS a 
		INNER JOIN (
			SELECT summ.scid,summ.promlvl,cr.id AS promcrid,cr.name
			FROM {$dbg}.05_summaries AS summ
			LEFT JOIN {$dbo}.05_levels AS l ON summ.promlvl=l.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON (summ.promlvl=cr.level_id && cr.section_id=1)									
		) AS b ON a.scid=b.scid
		SET a.crid=b.promcrid,a.lvl=b.promlvl,a.promsy=$nextsy;
	";
	pr("&exe");
	pr($q);
	if(isset($_GET['exe'])){ $sth=$db->querysoc($q);echo ($sth)? "Success":"Fail"; }
		
}	/* fxn */



public function promoteAll($params=NULL){	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$nextsy=DBYR+1;
	
	// 1
	$q="UPDATE {$dbg}.05_summaries AS a 
		INNER JOIN (
			SELECT summ.scid,cr.level_id AS currlvl,(cr.level_id+1) AS nextlvl
			FROM {$dbg}.05_summaries AS summ
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		) AS b ON a.scid=b.scid
		SET a.promlvl=b.nextlvl,a.lvl=b.currlvl,a.promsy=$nextsy;
	";
	pr("&exe");
	pr($q);
	if(isset($_GET['exe'])){ $sth=$db->querysoc($q);echo ($sth)? "Success":"Fail"; }

	// 2	
	$this->rosterNextSY();
	
		
}	/* fxn */




}	/* EnrollmentController */
