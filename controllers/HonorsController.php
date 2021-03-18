<?php

Class HonorsController extends Controller{	

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




public function records($params){

require_once(SITE."functions/details.php");
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['sy'];
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['classroom']=getClassroomDetails($db,$crid,$dbg);

$order=$_SESSION['settings']['classlist_order'];
$order = isset($_GET['order'])? $_GET['order']:$order;

$q = "
	SELECT
		c.id AS scid,c.name AS student,summ.*,sx.*,summ.`ave_q{$qtr}` AS genave,sx.`honor_q{$qtr}` AS honor
	FROM {$dbg}.05_summaries AS summ
		INNER JOIN {$dbg}.05_summext AS sx ON summ.scid = sx.scid
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
	WHERE summ.crid = '$crid' ORDER BY $order ; ";
debug($q,'Honors-records');
$sth = $this->model->db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

if(isset($_POST['submit'])){
	// pr($_POST);
	$posts = $_POST['post'];

	$q = "";
	foreach($posts AS $post){
		$q.=" UPDATE {$dbg}.05_summext SET `cocurr_q{$qtr}` = '".$post['cocurr']."', 
				`honor_q{$qtr}` = '".$post['honor']."',`honor_rank_q{$qtr}` = '".$post['rank']."' 
			WHERE `scid` = '".$post['scid']."' LIMIT 1; ";						
			
	}	/* foreach */
	
	$this->model->db->query($q);
	$url = "honors/records/$crid/$sy/$qtr";
	flashRedirect($url,'Updated honors.');	
	exit;
	
}	/* post */

$vfile='honors/recordsHonors';
$this->view->render($data,$vfile);

}	/* fxn */



public function certificatesByClassroom($params){
require_once(SITE.'functions/details.php');
require_once(SITE."functions/numberFxn.php");

$crid=isset($params[0])? $params[0]:12;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['date']=isset($_GET['date'])? $_GET['date']:$_SESSION['today'];

$data['cr']=getClassroomDetails($db,$crid);

$q="SELECT c.id,c.code,c.name AS student,summ.ave_q{$qtr} AS genave,sx.honor_q{$qtr} AS honor FROM {$dbo}.`00_contacts` AS c
LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
LEFT JOIN {$dbg}.05_summext AS sx ON c.id=sx.scid
WHERE summ.crid='$crid' AND sx.honor_q{$qtr} > 0 ;";
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$no_honors="<h1 style='color:brown;font-size:2rem;'>No honors.</h1>";
$no_honors.="<br /><h2>You may <a href='".URL."honors/process/".$crid."' >Process</a> again to be sure.</h2>";
if(empty($data['rows'])){ prx($no_honors); }
debug($data['rows'][0]);
// prx($data['rows'][0]);


$sch=VCFOLDER;
$data['subdepartment_id']=$subdept_id=$data['cr']['subdepartment_id'];

$suffix='';
$subdept_id=isset($_GET['subdept_id'])? $_GET['subdept_id']:$subdept_id;
switch($subdept_id){
	case 1:
		$suffix='ps';break;
	case 3:
		$suffix='jhs';break;		
	case 4:
		$suffix='shs';break;
	default:
		$suffix='gs';break;
		
}

$num=$data['cr']['num'];
$num_suffix=($num>1)? "_N{$num}":NULL;


$qor=getOrdinalArray($qtr);
$data['qtr_num']=$qor['num'];
$data['qtr_word']=$qor['word'];

$vfile="customs/{$sch}/honors/certificatesByClassroomHonors_{$suffix}{$num_suffix}";
debug($vfile);vfile($vfile);

// prx($vfile);

$this->view->render($data,$vfile,'empty');

}	/* fxn */


public function process($params){	/* process() */
require_once(SITE.'functions/details.php');
require_once(SITE.'functions/classifications.php');
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];
$data['db']=$db=&$this->model->db;$data['dbo']=$dbo=PDBO;$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
$data['sem']=isset($_GET['sem'])? $_GET['sem']:0;
$data['cr']=getClassroomDetails($db,$crid);
$data['dept']=$dept=$data['cr']['department_id'];
$deptrow=getDepartmentArray($dept);
$data['deptcode']=$deptcode=strtolower($deptrow['dept_code']);

if(isset($_POST['submit'])){
	// $posts=(!empty($_POST['posts']))? $_POST['posts']:false;	
	$posts=(!empty($_POST['posts']))? $_POST['posts']:false;	
	// prx($posts);
	
	$q="";			
	$q.="UPDATE {$dbg}.05_summext AS sx 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=sx.scid 	
		SET `is_qualified_q{$qtr}`=0,`honor_q{$qtr}`=0, 
		`honor_dg{$qtr}`='' 
		WHERE summ.crid=$crid; "; 
	$db->query($q);
	
	$q="";		
	if($posts){
		foreach($posts AS $post){ 
			$q.="UPDATE {$dbg}.05_summext SET 
			`is_qualified_q{$qtr}`='".$post['is_qualified']."',
			`honor_q{$qtr}`='".$post['honor']."', 
			`honor_dg{$qtr}`='".$post['honor_dg']."' 
			WHERE `scid`='".$post['scid']."' LIMIT 1; "; 
		}
		// pr($q);exit;
		$db->query($q);		
	}

	// pr($posts);
	// prx($q);
	$url="honors/process/$crid";
	flashRedirect($url,"Honors processed.");
	
}	/* post */

/* vfile */
$one="honors/processHonors";
$two="honors/processHonors";
$vfile=cview($one,$two,$sch=VCFOLDER);
if(isset($_GET['vfile'])){ pr($vfile); }
$this->view->render($data,$vfile);

}	/* fxn */


public function report($params=NULL){
require_once(SITE.'functions/details.php');
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];
$data['db']=$db=&$this->model->db;$data['dbo']=$dbo=PDBO;$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
$data['sem']=isset($_GET['sem'])? $_GET['sem']:0;
$data['cr']=getClassroomDetails($db,$crid);
$data['dept']=$data['cr']['department_id'];

$q="SELECT c.name AS student,c.code AS studcode,summ.scid,summ.ave_q{$qtr} AS `genave`,sx.honor_q{$qtr} AS honor
	FROM {$dbg}.05_summaries AS summ 
	INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
	INNER JOIN {$dbg}.05_summext AS sx ON summ.scid=sx.scid
	WHERE summ.crid='$crid' AND sx.`honor_q{$qtr}`>0 ORDER BY honor,genave DESC;";
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$vfile='honors/reportHonors';vfile($vfile);
$this->view->render($data,$vfile);


}	/* fxn */


public function level($params=NULL){
require_once(SITE.'functions/honorsFxn.php');
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

$data['level']=fetchRow($db,"{$dbo}.`05_levels`","$lvl");


// 1 - order by honor
// 2 - order by sections

$num=isset($_GET['num'])? $_GET['num']:1;
if($num==2){	// by sections
	$order=" cr.section_id,honor,summ.ave_q{$qtr} DESC ";
	$vfile="honors/levelSxnsHonors";
} else {
	$order=" honor,summ.ave_q{$qtr} DESC ";
	$vfile="honors/levelMixedHonors";	
}
debug($vfile,"vfile: ");

$data['free']=$free=isset($_GET['free'])? $_GET['free']:0;		
$freecond="AND cr.is_free<>1";
if($free==1){ $freecond="AND cr.is_free=1"; 
} elseif($free==2){ $freecond=""; }
	
$q="SELECT c.code AS studcode,c.name AS student,summ.scid,summ.ave_q{$qtr} AS genave,sx.honor_q{$qtr} AS honor,
	cr.name AS classroom,cr.id AS crid
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
INNER JOIN {$dbg}.05_summext AS sx ON summ.scid=sx.scid
INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
WHERE cr.level_id='$lvl' $freecond AND c.is_active=1 AND sx.honor_q{$qtr}>0
ORDER BY $order;";
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$q="SELECT cr.id,cr.id AS crid,sxn.code,cr.name FROM {$dbg}.05_classrooms AS cr 
INNER JOIN {$dbo}.`05_sections` AS sxn ON sxn.id=cr.section_id
WHERE cr.level_id='$lvl';";
$sth=$db->querysoc($q);
$data['classrooms']=$sth->fetchAll();

vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



public function levelReport($params=NULL){
require_once(SITE.'functions/honorsFxn.php');
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

$data['level']=fetchRow($db,"{$dbo}.`05_levels`","$lvl");


// 1 - order by honor
// 2 - order by sections

$num=isset($_GET['num'])? $_GET['num']:1;
if($num==2){	// by sections
	$order=" cr.section_id,honor,summ.ave_q{$qtr} DESC ";
	$vfile="honors/levelSxnsHonors";
} else {
	$order=" honor,summ.ave_q{$qtr} DESC ";
	$vfile="honors/levelReportHonors";	
}
debug($vfile,"vfile: ");

$data['free']=$free=isset($_GET['free'])? $_GET['free']:0;		
$freecond="AND cr.is_free<>1";
if($free==1){ $freecond="AND cr.is_free=1"; 
} elseif($free==2){ $freecond=""; }
	
$q="SELECT c.code AS studcode,c.name AS student,summ.scid,summ.ave_q{$qtr} AS genave,sx.honor_q{$qtr} AS honor,
	cr.name AS classroom,cr.id AS crid
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
INNER JOIN {$dbg}.05_summext AS sx ON summ.scid=sx.scid
INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
WHERE cr.level_id='$lvl' $freecond AND c.is_active=1 AND sx.honor_q{$qtr}>0
ORDER BY $order;";
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$q="SELECT cr.id,cr.id AS crid,sxn.code,cr.name FROM {$dbg}.05_classrooms AS cr 
INNER JOIN {$dbo}.`05_sections` AS sxn ON sxn.id=cr.section_id
WHERE cr.level_id='$lvl';";
$sth=$db->querysoc($q);
$data['classrooms']=$sth->fetchAll();



$this->view->render($data,$vfile);

}	/* fxn */




public function clsmatrix($params=NULL){
require_once(SITE.'functions/honorsFxn.php');
require_once(SITE.'functions/details.php');
require_once(SITE."functions/bonuses.php");
require_once(SITE."functions/reports.php");
require_once(SITE."functions/attendance.php");
$data['crid']=$crid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

/* 1 */
$cr=$data['cr']=getClassroomDetails($db,$crid,$dbg);	
$data['is_locked']=$is_locked=$cr['is_finalized_q'.$qtr];
$data['trait']=getClassroomConductCourse($db,$dbg,$crid,CTYPETRAIT);
$data['conduct']=getClassroomConductCourse($db,$dbg,$crid,CTYPECONDUCT);


$q="SELECT c.code AS studcode,c.name AS student,summ.scid,summ.ave_q{$qtr} AS genave,sx.honor_q{$qtr} AS `honor`,
summ.id AS sumid,summ.ave_q{$qtr},summ.conduct_q{$qtr},summ.conduct_dg{$qtr},sx.rank_classroom_q{$qtr},sx.rank_level_ave_q{$qtr}
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
INNER JOIN {$dbg}.05_summext AS sx ON summ.scid=sx.scid
WHERE c.is_active=1 AND sx.honor_q{$qtr}>0 ORDER BY sx.honor_q{$qtr},summ.ave_q{$qtr} DESC;";
$sth=$db->querysoc($q);
$data['students']=$students=$sth->fetchAll();

$sem=isset($_GET['sem'])?$_GET['sem']:0;
$data['num_students']=count($data['students']);
$data['courses']=matrixSubjects($db,$dbg,$crid,$fields=NULL,$filter=NULL,$sem);	
$data['num_courses']=count($data['courses']);

$grades=array();
foreach($students AS $row){ $grades[]=matrixGrades($db,$dbg,$row['scid'],$filter=NULL,$sem); }	
$q.="<br />Bonuses Fxn: Matrix Grades<br />".$_SESSION['q'];
$data['q']=$q;
$data['grades']=&$grades;

/* attendance attd */
$data['months']=$months=attendanceMonths($db,$cr['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
$data['month_names']=$month_names=fetchRows($db,"{$dbo}.`05_months_quarters`",'*','`index`'," WHERE quarter = $qtr ");	
$data['num_months']=$num_months=count($data['month_names']);
foreach($students AS $row){ $attd[]=attendance($db,$dbg,$sy,$row['scid']); }		

$attd=isset($attd)? $attd:NULL;
$data['attd']=&$attd;	
$data['page'] = "Honors Consolidated Grading Sheet - SY".$sy." Q{$qtr}";	

$one="clsmatrix";$two="honors/clsmatrixHonors";
$vfile=cview($one,$two,$sch=VCFOLDER);	

$this->view->render($data,$vfile);

}	/* fxn */


public function aaaxxx(){
	
	
}	/* fxn */
	






}	/* HonorsController */
