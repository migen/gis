<?php

Class SirController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'sir/index');

}	/* fxn */




public function level($params=false){
$dbo=PDBO;
require_once(SITE.'functions/feesFxn.php');
require_once(SITE.'functions/ranksFxn.php');
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;

$data['free']=$free=isset($_GET['free'])? $_GET['free']:0;		
$data['level']=fetchRow($db,"{$dbo}.`05_levels`",$lvl);
$data['rows']=getLevelRanks($db,$dbg,$lvl,$qtr);
$data['count']=count($data['rows']);

// pr($data['rows'][0]);

// $one="levelRanks";$two="ranks/levelRanks";
$one="levelRanks";$two="sir/lvlSir";
$vfile=cview($one,$two);vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



public function classroom($params=NULL){
require_once(SITE.'functions/genaveFxn.php');
require_once(SITE.'functions/ranksFxn.php');
$db=&$this->baseModel->db;
$data['db']=&$db;$dbo=PDBO;

$data['crid']=$crid=isset($params[0])? $params[0]:FALSE;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$dbg=VCPREFIX.$sy.US.DBG;

/* ------------- access control --------------------------------------------------------------------- */	
$srid = $_SESSION['srid'];
if($srid==RTEAC){ if((!in_array($crid,$_SESSION['teacher']['advisory_ids']))) { flashRedirect('teachers'); } }	
/* -------------------------------------------------------------------------------------------------- */


if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$rank=$post['rank'];$sumxid=$post['sumxid'];
		$q.="UPDATE {$dbg}.05_summext SET rank_classroom_q{$qtr} = $rank WHERE id=$sumxid LIMIT 1;";		
	}
	$db->query($q);
	flashRedirect("sir/classroom/$crid/$sy/$qtr","Updated.");
	exit;
	
}	/* post */


$field=isset($_GET['field'])? $_GET['field']:"ave_q{$qtr}";
$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;

$data['classroom']=fetchRow($db,"{$dbg}.05_classrooms",$crid);
$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;
$data['rows']=getGenaveRanks($db,$dbg,$crid,$qtr,$dbo,$limitcond);
$data['count']=count($data['rows']);


// $vfile="sir/classroomGenave";
$vfile="sir/cridSir";
debug($vfile);
$this->view->render($data,$vfile);

}	/* fxn */






}	/* SirController */
