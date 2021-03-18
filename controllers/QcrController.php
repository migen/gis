<?php

Class QcrController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */



public function qcrdomino($params){	/* crid */
$dbo=PDBO;
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/sessionize.php");
	
	$data['crid']=$crid=$params[0];	
	$data['ssy']=$ssy=$_SESSION['sy'];
	$data['sqtr']=$sqtr=$_SESSION['qtr'];
	$data['sy']= $sy=isset($params[1])? $params[1] : DBYR;	
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $sqtr;		
	$_SESSION['url'] = "qcr/qcrdomino/$crid/$sy/$qtr";	
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;		
	$classroom=getClassroomDetails($db,$crid,$dbg);			
	$cr=$data['cr']=$data['classroom']=$classroom;
	$data['is_locked']=$is_locked=$classroom['is_finalized_q'.$qtr];	
	$data['sem']= $sem=isset($params[3])? $params[3]: $classroom['is_sem'];		
	$data['iqtr']=$iqtr=($qtr>4)? 4:$qtr;
	$data['intfqtr']=$intfqtr	= ($sem==2)? 6:5;
	$data['qf']=$qf="q$qtr";
	$data['by_rank']=$by_rank=isset($_GET['gender'])? false:true;
	$order=($by_rank)?" sum.`ave_q$qtr` DESC ":" c.is_male DESC,c.name ";
						
	/* controller - teachers or else */	
	$data['home']=$home=$_SESSION['home']; 			
	$data['srid']= $srid=$_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD);
	$data['admin']=$admin=in_array($srid,$adroles)? true:false;
	$adviser = ($cr['acid']==$_SESSION['user']['ucid'])? true:false;	
	if($admin || $adviser){} else { flashRedirect($home); }	
	
/* ------------------------------------------------------------------------------------------------- */				
		
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); }  } 

	$_SESSION['url']="qcr/qcrdomino/$crid/$sy/$qtr/$sem";	
	$q = "SELECT $crid AS crid,$crid AS crid,sum.*,c.id AS scid,c.code AS studcode,c.name AS student,c.`sy`,			
			sum.id AS sumid,sum.scid AS sumscid
			,sx.rank_classroom_q{$qtr}
			,sx.is_qualified_q{$qtr}
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		INNER JOIN {$dbg}.05_summext AS sx ON sum.scid = sx.scid
		WHERE sum.crid 	= '$crid' ORDER BY $order ; ";		
	$sth=$db->querysoc($q);
	$data['students']=$sth->fetchAll();
	
	/* rank */
	if(isset($_POST['submit'])){
		/* 1 - rank */		
		$rows = $_POST['rank'];		
		$q = "";
		foreach($rows AS $row){ 
			$val=trim($row['val'],' ');
			$val=($val=='')? '0' : $row['val'];
			$q.="UPDATE {$dbg}.05_summext SET `rank_classroom_$qf`='$val' WHERE `scid`='".$row['scid']."' LIMIT 1;"; 
			
		}	/* foreach */	
		// pr($q); exit;		
		$db->query($q);				

			
		/* 2 - locking,then reset session */
		if($qtr==4){
			lockClassroom($db,$crid,4,$dbg);					
			$url = "qcr/qcrdomino/$crid/$sy/$intfqtr{$str_split}";
			flashRedirect($url,'Qtr 4 Ranking Done. <br />Please <span class="b underline">SORT</span> Final Average Ranking.');		
		} else {	
			$url="qcr/qcrdomino/$crid/$sy/$qtr{$str_split}";
			lockClassroom($db,$crid,$qtr,$dbg);			
		}
		
		if($_SESSION['srid']==RTEAC){ sessionizeTeacher($db,$dbg); }
				
		/* 3 - redirect */
		redirect($url);	
		exit;					
	}	/* post-rank */	

/* ------------------------------------------------------------------------------------------ */
	
	$data['num_students'] 	= count($data['students']);				
	$cfilter 	 = " AND (crs.affects_ranking = '1') "; 	
	$cfilter 	.= ($sem)? " AND (crs.semester = 0 || crs.semester = $sem) ":NULL;	
	
	
	$electives 	= NULL;
	$data['subjects'] 		= cridCourses($db,$dbg,$crid,$acad=1,$agg=1,$cfilter,$electives);	
	$data['num_subjects'] 	= count($data['subjects']);
						
	$data['grades'] = array();	
	$electives = NULL;	
	foreach($data['students'] AS $row){ $data['grades'][] = mcr($db,$dbg,$row['scid'],$sy,$cfilter,$electives); }
	$vfile="qcr/qcr123";
	// pr($vfile);
	$this->view->render($data,$vfile);		

}	/* fxn */

public function qcr($params){
$dbo=PDBO;
	$data['crid']	= $crid = 	$params[0];	
	$data['ssy']	= $ssy  = $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;	
	$data['qtr']	= $qtr 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	
	
	switch($_SESSION['settings']['qcrtype']){
		case 'all': $qcrtype = "qcrall"; $suffix=NULL; break;
		case 'split': $qcrtype = "qcrall"; $suffix='?split'; break;
		case 'domino': $qcrtype = "qcrdomino"; $suffix=NULL; break;
		default: $qcrtype = "qcrall"; $suffix=NULL; break;
	}
	
	$url = "qcr/$qcrtype/$crid/$sy/$qtr{$suffix}";
	redirect($url);


}	/* fxn */


public function qcrall($params){
require_once(SITE."functions/locks.php");
require_once(SITE."functions/details.php");
require_once(SITE."functions/sessionize.php");
require_once(SITE."functions/sessionize_teacher.php");
$data['split']  = $split = isset($_GET['split'])? true:false;

$data['crid']=$crid=$params[0];
$data['ssy']=$ssy=$_SESSION['sy'];
$data['sqtr']=$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$sqtr;

$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

$cr=$data['classroom']=$data['cr']=getClassroomDetails($db,$crid,$dbg);	
$data['intfqtr'] = $intfqtr = ($data['classroom']['is_sem'] && $qtr>2)? 6:5;
$str_split 		= ($split)? "?split":NULL;
$_SESSION['url'] = "qcr/qcrall/$crid/$sy/$qtr{$str_split}";

/* controller - teachers or else */	
$data['srid']	= $srid	= $_SESSION['srid'];
$adroles=array(RADMIN,RMIS,RREG,RACAD);
$data['admin'] = $admin = in_array($srid,$adroles)? true:false;

$adviser = ($cr['acid']==$_SESSION['user']['ucid'])? true:false;	
if($admin || $adviser){} else { flashRedirect($_SESSION['home']); }	

if(isset($_POST['submit'])){
$ranks=isset($_POST['rank'])? $_POST['rank']:array();			
$q = "";	
foreach($ranks AS $row){
$exists = empty($row['scid'])? false:true;
if($exists){
	$q .= " UPDATE {$dbg}.05_summext SET `rank_classroom_q{$qtr}`='".$row['rank']."' WHERE `scid`='".$row['scid']."' LIMIT 1;"; 				
}	/* exists */
} 	/* foreach */
// pr($q);exit;
$db->query($q);
	$_SESSION['message'] = "Ranks Updated.";

	/* 2 - locking,then reset session */
	lockClassroom($db,$crid,$qtr,$dbg);			
	$url = "qcr/qcrall/$crid/$sy/$qtr{$str_split}";
	flashRedirect($url,'Qtr 4 Ranking Done.');							
	if($_SESSION['srid']==RTEAC){ sessionizeTeacher($db); }			
	/* 3 - redirect */
	flashRedirect($url,'Class ranking processed.');	
	exit;						
	
}	/* post */


/* ---------------- process below ---------------- */

// if($qtr==1){ require_once(SITE.'functions/syncSummaries.php'); syncSummextByClassroom($db,$dbg,$crid); }	/* qtr==1 */


$fields=($qtr==7)? ",summ.ave_q5,summ.ave_q6":NULL;
$q = "
	SELECT c.id AS scid,c.code AS studcode,c.name AS student,summ.id AS sumid,summ.ave_q{$qtr} AS ave,sx.rank_classroom_q{$qtr} AS rank $fields
	FROM {$dbg}.05_summaries AS summ		
	INNER JOIN {$dbg}.05_summext AS sx ON summ.scid=sx.scid
	INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
	WHERE summ.crid = '$crid' ORDER BY ave DESC; ";
debug($q);
$sth = $db->querysoc($q);
$data['grades'] = $sth->fetchAll();
$data['count']=count($data['grades']);
$data['is_locked']	= ($qtr<5)? $data['classroom']['is_finalized_q'.$qtr]:false;
$data['is_sem']	 = $data['classroom']['is_sem'];
$data['derivsem']	= ($qtr<3)? 1:2;
$vfile = ($split)? 'qcr/qcrsplit':'qcr/qcrtie';
vfile($vfile);
$this->view->render($data,$vfile);
 
}	/* fxn */



public function retallyQ7($params=NULL){
$dbo=PDBO;
	$crid=$params[0];
	$db=&$this->model->db;$dbg=PDBG;
	$q="UPDATE {$dbg}.05_summaries SET ave_q7=((ave_q5+ave_q6)/2) WHERE crid='$crid'; ";
	$db->query($q);
	$msg="Tallied OAve Q7 by averaging Sem1 and Sem2 genave.";
	$url=isset($_SESSION['url'])? $_SESSION['url']:"cir/index";
	flashRedirect($url,$msg);	

}	/* fxn */




}	/* QcrController */
