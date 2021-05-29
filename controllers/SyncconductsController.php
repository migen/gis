<?php

class SyncconductsController extends Controller{	
/* Syncs and Counts for - admins,registrars,and mis,guidance controllers  */
	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	parent::beforeFilter();		
	$this->view->js = array('js/jquery.js','js/vegas.js');
	
	$acl = array(array(5,0),array(7,0),array(9,0));
	$this->permit($acl);				
	
}	/* fxn */



public function toSummariesByLevel($params){	
	if(!isset($params[0])){ pr("Needs parameter level_id."); exit; }
	require_once(SITE.'functions/syncConducts.php');
	$db=&$this->baseModel->db;	
	$data=syncLevelConducts($db,$params);
	if($_SESSION['srid']==RMIS){
		pr('test - syncconducts/setSummariesByLevel/lvl/sy/qtr/value');
	}
	if(isset($_GET['debug'])){
				
		// $this->view->render($data,"syncs/levelConductsToSummariesSyncs");			
	}
	
}	/* fxn */




public function setSummariesByLevel($params=NULL){
	$acl = array(array(5,0),array(7,0),array(9,0));
	$this->permit($acl);				

	pr('process - syncconducts/toSummariesByLevel/lvl/sy/qtr/value');
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$qtr=$_SESSION['qtr'];
	$lvl=isset($params[0])? $params[0]:15;
	$sy=isset($params[1])? $params[1]:DBYR;
	$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$value=isset($params[3])? $params[3]:70;
	$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="
		UPDATE {$dbg}.05_summaries AS a 
		INNER JOIN (
			SELECT
				summ.id AS summid,cr.name AS classroom,c.id AS scid,c.code AS studcode,c.name AS student,g.q{$qtr} AS grade,
				summ.conduct_q{$qtr} AS summgrade
			FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbg}.50_grades AS g ON g.scid=c.id
			WHERE g.crstype_id=5 AND cr.level_id=$lvl	
		) AS b ON a.id = b.summid
		SET a.conduct_q{$qtr}=$value;		
	";
	
	pr($q);
	
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";		
	} else {
		pr('&exe');
	}
	
}	/* fxn */






}	/* SyncsController */