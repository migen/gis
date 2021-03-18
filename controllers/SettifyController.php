<?php

Class SettifyController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index($params=NULL){
$dbo=PDBO;
	require_once(SITE.'functions/cir.php');
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$data['qtr']=$qtr=isset($params[1])? $params[1]:$_SESSION['qtr'];
	$allowed=array(RMIS,RREG,RACAD,RADMIN);
	$data['srid']=$srid=$_SESSION['srid'];
	if(!in_array($srid,$allowed)){ flashRedirect(UNAUTH); }
	$data['all']=$all=isset($_GET['all'])? true:false;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$data['rows']=getCirList($db,$dbg,$cond=NULL);
	$data['count'] = count($data['rows']);
	$this->view->render($data,"settify/indexSettify");
}	/* fxn */


function crid($params){
	$db=$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$crid=$params[0];$val=$_GET['value'];$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	/* 1 grades */
	$q="UPDATE {$dbg}.`50_grades` AS a INNER JOIN {$dbg}.05_courses AS b ON a.course_id=b.id	
		SET a.`q{$qtr}`='$val' WHERE b.crid='$crid'; ";
	/* 2 summaries */	
	$q.="UPDATE {$dbg}.05_summaries SET `ave_q{$qtr}`='$val',`conduct_q{$qtr}`='$val' WHERE `crid`='$crid'; ";	
	pr($q);
	
	$url="settify/crid/$crid?value=$val&qtr=$qtr&exe";	
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		
	
	

}	/* fxn */


public function initSummaries($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/dbtools.php");
	$db=&$this->baseModel->db;$dbg=PDBG;
	$dbtable=isset($params[0])? $params[0]:"{$dbg}.`05_summaries`";
	echo "<h3 style='color:brown;' >WARNING! START of SY only, will ERASE all Summaries DATA!</h3>";
	$arr=showColumns($db,$dbtable);
	$arr = array_diff($arr, array("id","scid","crid","clubcourse_id","promlvl","promcrid"));
	$q="UPDATE {$dbtable} SET ";
	foreach($arr AS $k){ $q.="$k = '',"; }
	$q=rtrim($q,",");$q.=";";
	pr($q);

	$url="settify/initSummaries&exe";	
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		
	

}	/* fxn */




}	/* BlankController */
