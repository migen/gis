<?php

Class EnrollmentsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();	
}	/* fxn */

public function beforeFilter(){
	// $this->view->css = array('style_long.css');
	// $this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
}	/* fxn */

public function index(){
	$data=("Enrollments controller");$this->view->render($data,'data/indexData');
}	/* fxn */


protected function processSync($sy){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	/* 1 */
	syncEnrollment($db,$dbg,$sy);
	/* 2 */
	$num_summ=numrows($db,"{$dbg}.05_summaries");
	echo "<br />num_summ: $num_summ <br />";
	$num_enrollments=getNumEnrollments($db,$sy);
	echo "num_enrollments: $num_enrollments <br />";
	/* 3 */
	purgeEnrollment($db,$dbg,$sy);
	/* 4 */
	$num_enrollments=getNumEnrollments($db,$sy);
	echo "num_enrollments: $num_enrollments <br />";	
	
}

public function sync($params=NULL){
	reqFxn('enrollmentSyncPurgeFxn');
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$this->processSync($sy);
	pr("$sy sync enrollment - done");
	
}	/* fxn */




public function abc($params){
	// echo "abc-".$params[0]."<br />";
	echo $params."<br />";
	
	
}	/* fxn */

public function loopsync($params=NULL){
	reqFxn('enrollmentSyncPurgeFxn');
	$start=isset($params[0])? $params[0]:DBYR;
	$end=isset($params[1])? $params[1]:DBYR;

	pr("param1 - sy_start");
	pr("param2 - sy_end");
	pr("&exe");
	for($sy=$start;$sy<=$end;$sy++){
		pr($sy);
		if(isset($_GET['exe'])){
			$this->processSync($sy);				
		}
	}		
	
}	/* fxn */






}	/* BlankController */
