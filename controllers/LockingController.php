<?php

Class LockingController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$acl = array(array(9,0),array(5,0),array(6,0));
	$this->permit($acl,$strict=false);		
	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */




public function controls($params=NULL){
	$dbo=PDBO;
	$_SESSION['url']='locking/controls';
	$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
	$vfile='locking/controls';vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


public function openAQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$today  = $_SESSION['today'];
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q$qtr` = 0,`finalized_date_q$qtr` = '$today'; ";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "Advisory classes for Qtr $qtr opened!";
	redirect($url);

}	/* fxn */


public function closeAQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;

include_once(SITE.'views/elements/params_qs.php');
$today  = $_SESSION['today'];
$q = " UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q$qtr` = 1,`finalized_date_q$qtr` = '$today'; ";
$this->model->db->query($q);
$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
$_SESSION['message'] = "Advisory classes for Qtr $qtr locked!";
redirect($url);

}	/* fxn */


public function openCQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}` = '0',`finalized_date_q{$qtr}` = '0000-00-00';";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	flashRedirect($url,"Qtr $qtr courses opened.");

}	/* fxn */


public function closeCQ($params=null){		/* set all courses-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$today = $_SESSION['today'];
	$qtr = $params[0];
	$q = " UPDATE {$dbg}.05_courses_quarters SET `is_finalized_q{$qtr}` = '1',`finalized_date_q{$qtr}` = '$today';";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	flashRedirect($url,"Qtr $qtr courses closed.");

}	/* fxn */


public function openAttd($params=null){		/* set all attd-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = 0; ";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "Students Attendance for Qtr $qtr opened!";
	redirect($url);
}	/* fxn */


public function closeAttd($params=null){		/* set all attd-qtrs to 0 */
$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_advisers_quarters SET `attendance_q$qtr` = 1; ";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "Students Attendance for Qtr $qtr closed!";
	redirect($url);
}	/* fxn */


// ------------------------

public function openClubs($params=null){		/* set all attd-qtrs to 0 */
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_clubs SET `is_finalized_q$qtr` = 0; ";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "All Clubs for Qtr $qtr opened!";
	redirect($url);
}	/* fxn */

public function closeClubs($params=null){		/* set all attd-qtrs to 0 */
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_qs.php');
	$q = " UPDATE {$dbg}.05_clubs SET `is_finalized_q$qtr` = 1; ";
	$this->model->db->query($q);
	$url = (isset($_SESSION['url']))? $_SESSION['url']:$_SESSION['home'];
	$_SESSION['message'] = "All Clubs for Qtr $qtr closed!";
	redirect($url);
}	/* fxn */






}	/* LockingController */
