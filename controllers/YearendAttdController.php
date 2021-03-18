<?php

Class YearendAttdController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	echo "Yearend attenance tally total";
	// echo "<a href='' >Monthly</a>";
	// $data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */



public function monthly($params=NULL){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="
		UPDATE {$dbg}.05_attendance SET
		total_days_present=(jun_days_present+jul_days_present+aug_days_present+sep_days_present+oct_days_present+
			nov_days_present+dec_days_present+jan_days_present+feb_days_present+mar_days_present+apr_days_present
			+may_days_present),total_days_tardy=(jun_days_tardy+jul_days_tardy+aug_days_tardy+sep_days_tardy+oct_days_tardy+
			nov_days_tardy+dec_days_tardy+jan_days_tardy+feb_days_tardy+mar_days_tardy+apr_days_tardy+may_days_tardy);	
	";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "Query Success":"Query Failed.";
	echo "<hr />";
	$q="UPDATE {$dbg}.05_attendance SET `q5_days_present`=`total_days_present`,`q5_days_tardy`=`total_days_tardy`;";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "Query Success":"Query Failed.";
	
}	/* fxn */

public function quarterly($params=NULL){
$dbo=PDBO;
$dbg=PDBG;$db=&$this->baseModel->db;
$q=" UPDATE {$dbg}.05_attendance SET total_days_present=(q1_days_present+q2_days_present+q3_days_present+q4_days_present),
		total_days_tardy=(q1_days_tardy+q2_days_tardy+q3_days_tardy+q4_days_tardy);";
pr($q);
$sth=$db->query($q);
echo ($sth)? "Query Success":"Query Failed.";

	
}	/* fxn */




}	/* BlankController */
