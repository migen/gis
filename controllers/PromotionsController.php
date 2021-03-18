<?php


class PromotionsController extends Controller{	
/* for all roles  */
	
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js'); 
	parent::beforeFilter();		
	
}	/* fxn */


public function index(){
	$this->model->index();
}	/* fxn */



	
/* used by adviteachers & registrars */
public function k12($params){
$dbo=PDBO;

require_once(SITE."functions/prep.php");
require_once(SITE."functions/details.php");
require_once(SITE."functions/enrollment.php");
require_once(SITE."functions/equivs.php");
$db =& $this->model->db;

$data['crid']	= $crid = $params[0]; 
$data['ssy']	= $ssy	= $_SESSION['sy'];
$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy; 
$data['qtr']	= $qtr 	= isset($params[2])? $params[2] : $_SESSION['qtr']; 
$data['nsy']	= $nsy	= $sy + 1;		/* next_year or next_sy */

$data['dbg'] = $dbg = VCPREFIX.$sy.US.DBG;

/* ctlr - either registrars or teachers */
$data['home'] = $home = $_SESSION['home'];
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ flashRedirect('teachers'); } }

$prep = $this->model->getPrep($dbg,$crid,$sy);	/* report from DBM.promotions  */
$is_locked = $prep['is_finalized'];
$finalized_date = $prep['finalized_date'];


/* --------------------- data  --------------------- */
$data['crid'] 		= $crid;

$data['classroom'] 		= getClassroomDetails($db,$crid,$dbg);
$data['currlvl']=$currlvl=$data['classroom']['level_id'];
$data['prep']			= $prep;
$data['is_locked']		= $prep['is_finalized'];
$data['finalized_date'] = $prep['finalized_date'];
$data['is_prom']		= true;		/* necessary since using shovel-prom by both teachers and registrars */

$fields = " c.is_male,p.birthdate,p.age,MONTH(p.birthdate) AS birthmonth,YEAR(p.birthdate) AS birthyear,";
$fields .= " c.is_active,c.is_cleared, ";  /* classlistSummaries */

$data['boys'] 	= $boys		= classPromotion($db,$dbg,$sy,$crid,$male=1,$order="c.`name`",$fields);	
$data['girls'] 	= $girls	= classPromotion($db,$dbg,$sy,$crid,$male=0,$order="c.`name`",$fields);	

$data['num_boys'] = count($data['boys']);
$data['num_girls'] = count($data['girls']);
$data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","*","level_id");

$data['yis'] = $data['classroom']['level_id'];			/* students.years_in_school */
$data['ntc'] = $ntc = $this->model->ntc($crid,$dbg);		/* nextLevel tmp classrooms */
$data['ctc'] = $ctc = $this->model->ctc($crid,$dbg);		/* currLevel tmp classrooms */
$data['currlvl'] = $ctc['lvl'];
$data['promlvl'] = $ntc['lvl'];
$data['currcrid'] = $crid;


/* --------------------- process ---------------------  */
	if(isset($_POST['update'])){
		/* 1 - promote */
		if(isset($_POST['data']['promotions'])){ $prom 	= $_POST['data']['promotions']; }
		if(isset($prom)) { updateProm($db,$dbg,$prom,$currlvl,$crid,$nsy); }
		
		/* 2 - report @ DBM.promotions */
		$prep 	= $_POST['data']['report'];
		updatePrep($db,$dbg,$prep,$crid,$sy);
		$url = "promotions/k12/$crid/$sy";
		flashRedirect($url,'K12 Promotions updated.');		

	}	/* post-prom */
	
	if(isset($_POST['finalize'])){
		/* 1 - promote */
		if(isset($_POST['data']['promotions'])){ $prom 	= $_POST['data']['promotions']; }
		if(isset($prom)) { updateProm($db,$dbg,$prom,$currlvl,$crid,$nsy); }
		
		/* 2 - report @ DBM.promotions */
		$prep 	= $_POST['data']['report'];
		updatePrep($db,$dbg,$prep,$crid,$sy);	
		
		/* 3 - lock promotions */
		$this->model->lockPromotion($crid,$sy);

		$url = "promotions/k12/$crid/$sy";
		flashRedirect($url,'K12 Promotions finalized.');				
		
	}	/* post-finalize */
		
// pr($_SESSION['q']);
$vfile="promotions/promotionsk12";vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */


/* 1 - used by adviteachers & registrars,2 - old report on promotions,to remove in the future */
public function sfold($params){
$dbo=PDBO;
require_once(SITE."functions/prep.php");
require_once(SITE."functions/details.php");
require_once(SITE."functions/equivs.php");
require_once(SITE."functions/reports.php");
require_once(SITE."functions/enrollment.php");
require_once(SITE."functions/classifications.php");


$data['crid']=$crid=$params[0]; 
$ssy=$_SESSION['sy'];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR; 
$data['qtr']=$qtr=isset($params[2])?$params[2]:$_SESSION['qtr']; 
$data['nsy']=$nsy=$sy+1;

$db =& $this->model->db;$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;$data['dbm']=$dbg=VCPREFIX.$sy.US.DBG;

/* ctlr - either registrars or teachers */
$data['home']	= $home = $_SESSION['home'];
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ flashRedirect('teachers'); } }

$prep=$this->model->getPrep($dbg,$crid,$sy);	/* report from promotions table */
$is_locked= $prep['is_finalized'];
$finalized_date=$prep['finalized_date'];
/* $url = $home.'/preport/'.$crid.DS.$curr_sy;
if($is_locked) redirect($url); */

/* data */
$data['crid']=&$crid;
$data['classroom']=$classroom=getClassroomDetails($db,$crid,$dbg);
$data['prep']=$prep;
$data['is_locked']=$prep['is_finalized'];
$data['finalized_date']=$prep['finalized_date'];
$data['is_prom']=true;		/* necessary since using shovel-prom by both teachers and registrars */

$crClass		 	= classifyClass($classroom);
$data['ratings'] 	= getRatings($db,1,$crClass['dept_id'],$dbg);		

$fields = " s.years_in_school,c.is_male,p.birthdate,p.age,MONTH(p.birthdate) AS birthmonth,YEAR(p.birthdate) AS birthyear,";
$fields .= " c.is_active,c.is_cleared,s.is_sectioned,s.is_enrolled, "; 

$data['boys'] 	= $boys		= classPromotionOld($db,$dbg,$sy,$crid,$male=1,$order="c.`name`",$fields);	
$data['girls'] 	= $girls	= classPromotionOld($db,$dbg,$sy,$crid,$male=0,$order="c.`name`",$fields);	

$data['num_boys'] 		= count($data['boys']);
$data['num_girls'] 		= count($data['girls']);
$data['selectsClassrooms'] = fetchRows($db,"{$dbg}.05_classrooms","*","level_id");

$data['yis']=$data['classroom']['level_id'];	/* students.years_in_school */
$data['ntc']=$this->model->ntc($crid,$dbg);		/* nextLevel tmp classrooms */
$data['ctc']=$this->model->ctc($crid,$dbg);		/* currLevel tmp classrooms */

if(isset($_POST['update'])){		
	// pr($_POST); exit;
	if(isset($_POST['data']['promotions'])){ $prom 	= $_POST['data']['promotions']; }
	/* 1 - students,summaries,and promotions */
	if(isset($prom)) { 
		// $this->model->updatePromOld($dbg,$prom,$crid,$nsy);
		updatePromOld($db,$dbg,$prom,$crid,$next_year);		
	}		
			
	/* 2 - preport */
	$prep 	= $_POST['data']['report'];		
	// $this->model->updatePrepOld($dbg,$prep,$crid,$sy);
	updatePrepOld($db,$dbg,$prep,$crid,$sy);	
	$url = "promotions/sfold/$crid/$sy";				
	flashRedirect($url,'Promotions updated.');

}	/* post-prom */

if(isset($_POST['finalize'])){
	/* 1 - promote */
	if(isset($_POST['data']['promotions'])){ $prom 	= $_POST['data']['promotions']; }		
	if(isset($prom)) { updatePromOld($db,$dbg,$prom,$crid,$next_year); }
	
	/* 2 - preport */
	$prep 	= $_POST['data']['report'];		
	// $this->model->updatePrepOld($dbg,$prep,$crid,$curr_sy);
	updatePrepOld($db,$dbg,$prep,$crid,$sy);	

	/* 3 - lock promotions */
	$this->model->lockPromotion($crid,$sy);		
	$url = "promotions/sfold/$crid/$sy";						
	flashRedirect($url,'Promotions finalized.');
	
}	/* post-finalize */
	
$this->view->render($data,'promotions/promotionsSF');

}	/* fxn */

	

public function addPrep($params){
$dbo=PDBO;
	$crid 	 		= $params[0];
	$ssy			= $_SESSION['sy'];
	$sy	 			= $params[1];
	$dbg  = PDBG;	
	$dbg=&$dbg;
	$q  = " INSERT INTO {$dbg}.05_promotions (`crid`) VALUES ('$crid'); ";
	$this->model->db->query($q);
	redirect('index');

}	/* fxn */



public function lockPromotion($params){
$dbo=PDBO;
$crid 	= $params[0];
$sy 	= isset($params[1])? $params[1]:$_SESSION['sy'];;
$today  = $_SESSION['today']; 
$dbg=PDBG;
$q = " UPDATE {$dbg}.05_promotions SET `is_finalized` = '1',`finalized_date` = '$today' WHERE `crid` = '$crid' LIMIT 1;   ";
$this->model->db->query($q);

$url = "teachers";
redirect($url);

}	/* fxn */


public function unlockPromotion($params){
$dbo=PDBO;
$crid 	= $params[0];
$sy 	= isset($params[1])? $params[1]:$_SESSION['sy'];;
$dbg=PDBG;
$q = " UPDATE {$dbg}.05_promotions SET `is_finalized` = '0' WHERE `crid` = '$crid' LIMIT 1;   ";
$this->model->db->query($q);

$url = "teachers";
redirect($url);

}	/* fxn */



private function rpt($params){
$dbo=PDBO;
if(!isset($params[0])){ echo "<h1>No section parameter!</h1>"; exit; }

require_once(SITE."functions/arrays.php");
require_once(SITE."functions/enrollment.php");	/* replaced reports-classyear */
require_once(SITE."functions/bonuses.php");
require_once(SITE."functions/details.php");

$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;

/* controller - teachers or else */
$data['home']=$home=$_SESSION['home']; 			
$data['srid']=$srid=$_SESSION['srid']; 			
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
$data['classroom']=$classroom=getClassroomDetails($db,$crid,$dbg);			

$order = " c.is_male DESC,c.name "; 
$fields = "p.address,p.age,summ.num_days_present,";
$data['students'] = summaryPreport($db,$dbg,$sy,$crid,$male=2,$order,$fields);			
$data['numstud']		= count($data['students']);

$sem = false;
$cfilter = ($sem)? " AND (crs.semester = 0 || crs.semester = $sem) ":NULL;	
$cfilter .= " AND crs.supsubject_id < 1 ";
$data['subjects']=matrixSubjects($db,$dbg,$crid,$fields=NULL,$cfilter);	
$q=$_SESSION['q'];
$data['numsub']		= count($data['subjects']);
foreach($data['students'] AS $row){ $data['grades'][] = $grades[] = matrixGrades($db,$dbg,$row['scid'],$cfilter); }	
$data['prep'] = $prep	= $this->model->getPrep($dbg,$crid,$sy);	/* report from promotions table */
$data['q']=$q;
return $data;

}	/* fxn */


public function report($params=NULL){
$dbo=PDBO;
	$data = $this->rpt($params);
	$vpath = SITE.'views/customs/'.VCFOLDER.'/promotions/preport.php';

	if(isset($_GET['default'])){
		$vfile="promotions/preport";	
	} else {
		if(is_readable($vpath)){ $vfile="/customs/".VCFOLDER."/promotions/preport";	
		} else { $vfile="promotions/preport"; }	
	}

	vfile($vfile);

	$this->view->render($data,$vfile);

}	/* fxn */


public function reportBack($params=NULL){
$dbo=PDBO;
	$data = $this->rpt($params);
	$vfile = "promotions/preportBack";	
	$this->view->render($data,$vfile);

}	/* fxn */



public function student($params=NULL){
$scid=isset($params[0])? $params[0]:false;
if(empty($scid)){ echo "No param-0 for scid. "; }
$dbo=PDBO;
$dbg=PDBG;
$db=&$this->model->db;

$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE c.id = '$scid' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['student']=$student=$sth->fetch();


$year_start=$_SESSION['settings']['year_start'];
$begsy=($student['begsy']>=$year_start)?$student['begsy']:$year_start;
$endsy=DBYR;

$rows=array();
for($i=$begsy;$i<=$endsy;$i++){
	$dbg=VCPREFIX.$i.US.DBG;
	$q="
		SELECT 
			cr.id AS crid,cr.name AS classroom,'$i' AS year,l.name AS level,s.name AS section
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=summ.scid
		WHERE summ.scid='$scid' LIMIT 1;
	";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$rows[]=$row;
}

$data['rows']=&$rows;
$data['count']=count($rows);

$this->view->render($data,'promotions/studentPromotions');



}






} 	/* PromotionsController */