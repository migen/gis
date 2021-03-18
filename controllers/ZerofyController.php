<?php

Class ZerofyController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




function allGrades($params=NULL){
	$db=$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	if($_SESSION['qtr']>1){ echo "Cannot execute after first quarter."; exit; }	
	/* 1 grades */
	$q="UPDATE {$dbg}.`50_grades` 
		SET 
			`q1`=0,`q2`=0,`q3`=0,`q4`=0,`q5`=0,`q6`=0,`bonus_q1`=0,`bonus_q2`=0,`bonus_q3`=0,`bonus_q4`=0,
			`bonus_q5`=0,`bonus_q6`=0,`dg1`='',`dg2`='',`dg3`='',`dg4`='',`dg5`='',`dg6`=''; ";
	/* 2 summaries */	
	$q.="UPDATE {$dbg}.05_summaries SET `ave_q1`=0,`ave_q2`=0,`ave_q3`=0,`ave_q4`=0,`ave_q5`=0,`ave_q6`=0,
		`conduct_q1`=0,`conduct_q2`=0,`conduct_q3`=0,`conduct_q4`=0,`conduct_q5`=0,`conduct_q6`=0; ";		
	$q.="TRUNCATE {$dbg}.50_scores;";$q.="TRUNCATE {$dbg}.50_activities;";	
	pr($q);	
	$url="zerofy/allGrades&exe";	
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}			

}	/* fxn */


function truncateClubScores($params=NULL){
	$db=$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	if($_SESSION['qtr']>1){ echo "Cannot execute after first quarter."; exit; }	
	$sch=VCFOLDER;
	/* 1 grades */
	$q="TRUNCATE {$dbg}.50_clubscores_{$sch};"; 
	pr($q);	
	$url="zerofy/truncateClubScores&exe";	
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}			
}	/* fxn */







}	/* BlankController */
