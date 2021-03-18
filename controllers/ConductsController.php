<?php

Class ConductsController extends Controller{	
public $layout="full";

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */




public function fg($params){	
	$dbo=PDBO;
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/classifications.php");	
	require_once(SITE."functions/conduct_grades.php");	
	$db =& $this->model->db;
	
	$data['with_chinese'] = $with_chinese = $_SESSION['settings']['with_chinese'];

	$data['home']		= $home		= $_SESSION['home'];
	$data['course_id']	= $course_id	= $params[0];
	$data['ssy']		= $ssy		= $_SESSION['sy'];
	$data['sy'] 		= $sy 		=  	isset($params[1])? $params[1]:$ssy;
	$data['qtr']		= $qtr 		= 	isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['decicard']	= $decicard = isset($_GET['deci'])? $_GET['deci']:$_SESSION['settings']['decicard'];
	$data['dgonly'] = isset($_GET['dgonly'])? true:false;
	$order=$_SESSION['settings']['classlist_order'];	
	$order=isset($_GET['order'])? $_GET['order']:$order;
	$data['sortcond'] = $sortcond = isset($_GET['order'])? '&order='.$_GET['order']:NULL;
	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	
	$data['sem']  		= $sem 	= isset($_GET['sem'])? $_GET['sem']:0;			
	$data['qf']  = ($sem==2)? 'q6':'q5';
	$data['dgf'] = ($sem==2)? 'dg6':'dg5';
	
	$data['ssy']		= $ssy	= 	$_SESSION['sy'];
	$data['sqtr']		= $sqtr = 	$_SESSION['qtr'];
	$data['course'] 	= $course		=	getCourseDetails($db,$course_id,$dbg);	
	$data['subject_id']	= $course['subject_id'];
	
	$data['intfqtr']	= $intfqtr			= ($sem==2)? '6':'5';
	$data['fqtr']		= $fqtr				= 'q'.$intfqtr;
	$ctype_id = $course['crstype_id'];
	$data['is_locked'] 	= $course['is_finalized_q'.$qtr];	
	$data['crid']		= $crid 		= 	$course['crid'];	

	$data['is_k12']		= $is_k12		= $course['is_k12'];	

	$_SESSION['url']	= "conducts/fg/$course_id/$sy/$qtr";
	
	/* acl */
	$data['srid']	= $srid	= $_SESSION['srid'];
	$data['admin']	= $admin	= (($srid==RMIS) || ($srid==RREG) || ($srid==RACAD))? true:false;
	$data['mine']	= $mine		= ($course['tcid']==$_SESSION['user']['ucid'])? true:false;	
	$data['adviser']= $adviser	= (!$admin && in_array($crid,$_SESSION['teacher']['advisory_ids']))? true:false;
	if(!$admin && !$mine && !$adviser) { $this->flashRedirect($home); }	
	
/* ----------------------------------------------------------------------------------------- */	

	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$crsClass	= classifyCourse($course);	
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];
	$data['ratings'] = $ratings = getRatings($db,$ctype,$dept_id);		
	
	
	$fields = ($with_chinese==1)? ",c.chinese_name":NULL;
	$data['grades'] = getConductGrades($db,$dbg,$crid,$course_id,$sy,$qtr,$order);	
	$data['num_grades']	= count($data['grades']);
	
	$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order);	
	$data['num_students'] = $num_students	= count($students);
	
	$crsClass		  = classifyCourse($course);
	$data['ratings']  = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);				
	$data['stats']	    = $stats		= getStatsByCourse($db,$dbg,$sy,$course_id);
	$data['num_ratings'] = $num_ratings = count($data['ratings']);
	$data['num_stats'] 	 = $num_stats 	= count($data['stats']);
	$data['has_stats']	= $has_stats	= ($num_ratings==$num_stats)?true:false;
	
	if(isset($_POST['add_stats'])){
		$stats = $_POST['stats'];	
		$q  = "DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$course_id'; ";
		$q .= "INSERT INTO {$dbg}.50_stats (`quarter`,`course_id`,`dgid`,`count`) VALUES ";
		foreach($stats AS $k => $v){
			$q .= " ('$qtr','$course_id','$k','$v'), ";			
		}
		$q = rtrim($q,', ');
		$q .= "; ";		
		$db->query($q);
		$url = "averages/course/".$course_id.DS.$sy.DS.$qtr;
		redirect($url);					
	}
	
	if(isset($_POST['submit'])){	/* 1- dbg.stats.count, 2-dbg.50_grades.fg */
		$rows  = $_POST['grades'];
		$stats = $_POST['stats'];
				
		if(!$has_stats){
			$q  = "DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$course_id'; ";
			$q .= "INSERT INTO {$dbg}.50_stats (`quarter`,`course_id`,`dgid`,`count`) VALUES ";
			foreach($stats AS $k => $v){ $q .= " ('$qtr','$course_id','$k','$v'), "; }
			$q = rtrim($q,', ');$q .= "; ";
		} else {
			$q = "";
			foreach($stats AS $k => $v){
				$q .= " UPDATE {$dbg}.50_stats SET `quarter` = '$qtr',`count` = '$v' WHERE `course_id` = '$course_id' AND `dgid` = '$k' LIMIT 1; ";
			}
		}
		// pr($q);
		$db->query($q);				
		
$q = "";		
if($course['crstype_id']==CTYPETRAIT){
	foreach($rows AS $row){ 		
		$fg=$row['fg'];
		$dg=rating($fg,$ratings);
		$q .= " UPDATE {$dbg}.05_summaries SET `conduct_q$intfqtr` = '$fg',`conduct_dg$intfqtr` = '$dg'  
				WHERE `scid` = '".$row['scid']."' LIMIT 1; ";						
	}	
} else {
	foreach($rows AS $row){ 
		$exists = empty($row['sumid'])? false:true;
		if($exists){
			// pr($row);exit;
			$q .= "UPDATE {$dbg}.50_grades SET `q$intfqtr` = '".$row['fg']."',`dg$intfqtr` = '".$row['dg']."'  
					WHERE `scid` = '".$row['scid']."' AND `course_id` = '$course_id' LIMIT 1;";
			$q .= " UPDATE {$dbg}.05_summaries SET `conduct_q$intfqtr` = '".$row['fg']."',`conduct_dg$intfqtr` = '".$row['dg']."'  
					WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
		}	/* exists */
	}	/* foreach */

}	/* if traits */
		// pr($q);exit;
		$db->query($q);		
		// lockCourse($db,$course_id,$qtr,$dbg);
		$url="conducts/fg/$course_id/$sy/$qtr";		
		redirect($url);	
	
	}	/* post */
	
/* -------------------------------------------------------------------------------------------------- */	

	$_SESSION['course'] = $course;
	$_SESSION['course']['course_id'] = $course_id;				
	$vfile='conducts/fgConducts';
	vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function sortRanks($params){
$dbo=PDBO; 
include_once(SITE.'views/elements/params_sq.php');
require_once(SITE."functions/conducts.php");
require_once(SITE."functions/details.php");
require_once(SITE."functions/sessionize.php");
require_once(SITE."functions/sessionize_teacher.php");
require_once(SITE."functions/locks.php");
$db =& $this->model->db;

$data['continuous']	  = $continuous		= isset($_GET['continuous'])? true:false;	
$data['ssy']	= $ssy	 = $_SESSION['sy'];
$data['sy']  	= $sy	 = isset($params[0])? $params[0]:$ssy;
$data['sqtr']	= $sqtr	 = $_SESSION['qtr'];	
$data['qtr']	= $qtr			= isset($params[1])? $params[1]  : $sqtr;

$data['crid']		=	$crid 		= $params[2];
$data['course_id']	=	$course_id 	= $params[3];

if($_SESSION['srid']==RTEAC){
	if(!in_array($course_id,$_SESSION['teacher']['course_ids'])){ $this->flashRedirect('teachers'); }		
}
$data['course']  	= $course 	= getCourseDetails($db,$course_id);		
$data['sem']		= $sem		= $course['semester'];
$data['intfqtr']	= $intfqtr	= ($sem==2)? '6':'5';
$data['fqtr']		= $fqtr		= 'q'.$intfqtr;

$data['qf'] 		= $qf		= 'q'.$qtr;		
$data['is_locked'] = $course['is_finalized_q'.$qtr]; 		

	
if(isset($_POST['submit'])){
	/* 1-update */
	$rows = $_POST['data'];
	$q = "";	
	foreach($rows AS $row){ 
		// pr($row);
		$exists = empty($row['sumid'])? false:true;
		if($exists){
			$q .= " UPDATE {$dbg}.05_summaries SET `rank_classconduct_$qf` = '".$row['rank']."' 
				WHERE `id` = '".$row['sumid']."' LIMIT 1;  "; 		
		}	/* exists */

	}	/* foreach */		
	// pr($q); exit;
	$db->query($q);
	
	/* 2 - lock course,then reset session */
	if($qtr<4){
		lockCourse($db,$course_id,$qtr,$dbg);						
	} elseif($qtr==4){
		$url = "conducts/sortRanks/$sy/$intfqtr/$crid/$course_id";
		$this->flashRedirect($url,'Qtr 4 Ranking Done. <br />Please <span class="b u">SORT</span> Final Average Ranking.');		
	} else {
		lockCourse($db,$course_id,4,$dbg);				
		lockCourse($db,$course_id,$intfqtr,$dbg);											
	}
	
	/* 3 - redirect to view ranks */
	$url = $_SESSION['home'];
	$_SESSION['message'] = 'Conduct processed.';
	redirect($url);
	

}	/* post */
	
/* --------------------------------- process ----------------------------------- */
	
	$limits = 500;
	$data['ranks'] 		= getTraitRanks($db,$dbg,$crid,$course_id,$sy,$qf,$limits);  	
	$data['num_rows'] 	= count($data['ranks']);		

	$this->view->render($data,'conducts/sortRanksConducts');



}	/* fxn */


/* like grades but finalizes fg and dgf,no need for course to do so */
public function records($params){	
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/conducts.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/classifications.php");
	$db =& $this->model->db;

	$data['home']	= $home	= $_SESSION['home'];
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
	$data['course_id']	= $course_id  	= $params[0];
	$data['sy'] 		= $sy 			= isset($params[1])? $params[1] : $ssy;
	$data['qtr'] 		= $qtr 			= isset($params[2])? $params[2] : $sqtr;
	$data['qqtr'] 		= $qqtr 		= 'q'.$qtr;

	$_SESSION['url']="conducts/records/$course_id/$sy/$qtr";	
	$dbg  = VCPREFIX.$sy.US.DBG;
	$data['home']	=	$home 			= $_SESSION['home']; 				
	$_SESSION['conduct']['url'] = "conducts/records/$course_id/$sy/$qtr";	
	
	/* ------------------ process ---------------  */
	$data['course'] = $course 	= getCourseDetails($db,$course_id,$dbg);
	$data['flrgr'] 	= $flrgr 	= getCourseFloorGrade($course,$_SESSION['settings']);		
	$data['crid']	= $crid		= $course['crid'];
	$_SESSION['course']=$course;		
	
		
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } }
	
	$crsClass		 = classifyCourse($course);
	$with_dg=$course['with_conduct_dg'];
	$data['with_dg']=&$with_dg;
	$data['ctype']=$course['crstype_id'];
	$data['dept']=$data['dept_id']=$course['department_id'];
	$data['ratings']=$ratings=getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);				
	$data['is_locked']  = $course['is_finalized_q'.$qtr];	
	$order=$_SESSION['settings']['classlist_order'];	
	$order=isset($_GET['order'])? $_GET['order']:$order;
	$data['conducts'] 	= getClassroomConducts($db,$dbg,$crid,$course_id,$sy,$qtr,$order);		
	$data['num_conducts'] = count($data['conducts']);		
	
$data['students'] = classyear($db,$dbg,$sy,$crid,$male=2,$order,$flds=NULL,$fltrs=NULL,$lmt=NULL,$active=1);
$data['num_students'] = count($data['students']);	

/* update or ranking */
if(isset($_POST['submit'])){
	$rows=$_POST['data']['summary'];		
	/* update summaries for each classroom student */
	$q = "";
	foreach($rows AS $row){
		if($row['q'.$qtr] < $flrgr) {  $row['q'.$qtr] = $flrgr; }			
		/* update grades final or fg  */
		$total = $row['q1'];
		for($i=2;$i<=$qtr;$i++){ $total += $row['q'.$i]; }		
		$fg  = $total/$qtr;
		if($with_dg){
			$dg=rating($row['q'.$qtr],$ratings);$dgf=rating($fg,$ratings);										
		} else { $dg="";$dgf=""; }
		
		$q .= " 
			UPDATE {$dbg}.50_grades SET `q$qtr`='".$row['q'.$qtr]."',`q5`= '".$fg."' ";						
		$q .= " ,`dg$qtr`='".$dg."',`dg5`	= '".$dgf."'  "; 
		$q .= " WHERE `id`='".$row['gid']."' LIMIT 1; ";			
		$q .= " UPDATE {$dbg}.05_summaries SET 
				`conduct_q$qtr`='".$row['q'.$qtr]."',`conduct_q5`='".$fg."'  ";
		$q .= " ,`conduct_dg$qtr`='".$dg."',`conduct_dg5`='".$dgf."'  "; 														
		$q .= " WHERE `scid`='".$row['scid']."' LIMIT 1; ";
	}	/* foreach */
			
	// pr($q); exit;
	$db->query($q);				

	/* if finalize */
	if($_POST['submit']=='Finalize'){
		require_once(SITE."functions/locks.php");
		lockCourse($db,$course_id,$qtr,$dbg);
	} 
			
	
	$url = "conducts/records/$course_id/$sy/$qtr";		
	redirect($url);				
}	/* post */
	$vfile='conducts/recordsConducts';vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */


public function edit($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/classifications.php");
	$db =& $this->model->db;
	
	$sy				= $params[0];
	$qtr			= $params[1];	
	$course_id		= $params[2];
	$scid			= $params[3];

	$dbg  = VCPREFIX.$sy.US.DBG;
	
	/* controller - teachers or else */
	$data['home']	= $home	= $_SESSION['home'];

	$course	 			= getCourseDetails($db,$course_id,$dbg);	
	$data['course'] 	= $course;		
	$data['crid'] 		= $crid 	= $course['crid'];	
	$data['is_locked']  = $course['is_finalized_q'.$qtr];
	$data['is_k12']		= $is_k12		= $course['is_k12'];
	$data['with_dg']	= $with_dg		= $course['with_conduct_dg'];
	
	if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  flashRedirect('teachers'); } }
	
	$crsClass	= classifyCourse($data['course']);
	$ratings = $data['ratings'] = getRatings($db,CTYPECONDUCT,$crsClass['dept_id']);		
	
	$data['boys']  = isset($_SESSION['boys'])? $_SESSION['boys'] : classyear($db,$dbg,$sy,$crid,$male=1,$order="c.`name`");
	$data['girls'] = isset($_SESSION['girls'])? $_SESSION['girls'] : classyear($db,$dbg,$sy,$crid,$male=0,$order="c.`name`");
	if(!isset($_SESSION['boys'])){ $_SESSION['boys'] 	= $data['boys']; } 	
	if(!isset($_SESSION['girls'])){ $_SESSION['girls'] 	= $data['girls']; } 	

	$data['flrgr'] = $flrgr = getCourseFloorGrade($course,$_SESSION['settings']);	
	
	if(isset($_POST['save'])){
		$row = $_POST;

$cg = ($row['q'.$qtr] < $flrgr)? $flrgr : $row['q'.$qtr];
$cgave = ($row['cgave'] < $flrgr)? $flrgr : $row['cgave'];

$dg 	= rating($cg,$ratings);
$dgf 	= rating($cgave,$ratings);
			
			/* update grades final or fg  */
					
			$q  = " 
				UPDATE {$dbg}.50_grades SET 
						`q$qtr` = '".$cg."',`q5` 	 = '".$cgave."' ";						
			$q .= " ,`dg$qtr` 	= '".$dg."',`dg5`	= '".$dgf."'  "; 
			$q .= " WHERE `id` = '".$row['gid']."' LIMIT 1; ";
				
			$q .= " UPDATE {$dbg}.05_summaries SET 
					`conduct_q$qtr` = '".$cg."',`conduct_q5` = '".$cgave."'  ";
			$q .= " ,`conduct_dg$qtr` 	= '".$dg."',`conduct_dg5`	= '".$dgf."'  "; 														
			$q .= " WHERE `id` = '".$row['sumid']."' LIMIT 1; ";		
			
		// pr($q); exit;
		$db->query($q);
		$url = "conducts/edit/$sy/$qtr/$course_id/$scid";
		redirect($url);
		
	}	/* post-save */ 

	
	/* ------------- data -------------------------------------------- */
	$data['course_id']		= $course_id;
	$data['scid']			= $scid;
	$data['sy']				= $sy;
	$data['qtr']			= $qtr;
	$data['student'] 		= student($db,$dbg,$sy,$scid,$fields=NULL);
	$data['is_locked']  	= $data['course']['is_finalized_q'.$qtr];
		
	$data['conduct'] 		= getStudentConduct($db,$sy,$scid,$dbg);		
	$this->view->render($data,'conducts/edit');

}	/* fxn */


public function process($params){
	$dbo=PDBO;
	require_once(SITE.'functions/cdtFxn.php');
	$db=&$this->model->db;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbtable=$dbg.'.50_conducts_'.$sch;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['dbg']=&$dbg;$data['dbo']=PDBO;$data['db']=&$db;	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$q.=updateConduct($db,$post,$qtr);			
		}
		$db->query($q);
		$url="conducts/process/$crid/$sy/$qtr";
		flashRedirect($url,"Saved.");
		exit;		
	}	/* post */	
	$data['course']=$course=getConductDetails($db,$dbg,$crid);		

		
	$data['crs']=$crs=$course['course_id'];
	$data['lvl']=$lvl=$course['level_id'];	
	/* 1.5-acl */
	$srid=$_SESSION['srid'];
	$admin_roles=array(RMIS,RACAD,RREG);
	$data['is_admin']=$is_admin=in_array($srid,$admin_roles);
	$ucid=$_SESSION['ucid'];
	$acid=$data['course']['acid'];
	$is_adviser=($acid==$ucid)? true:false;
	$is_allowed=($is_admin || $is_adviser)? true:false;
	if(!$is_allowed){ flashRedirect(UNAUTH); }		
	/* 2 sync awardees */
	syncAwardees($db,$crid);		
	/* 3-attmos */
	$data['attmo']=fetchRecord($db,"{$dbg}.05_attendance_months",$where="`level_id`='$lvl'");	
	
	$data['is_locked']=$is_locked=($course['conduct_q'.$qtr]==1)? true:false;
	if($is_locked && !$is_admin && isset($_GET['edit'])){		
		flashRedirect("conducts/process/$crid/$sy/$qtr","Locked - cannot edit");
	} 
	
	
	$one="processConducts";
	$two="conducts/processConducts";
	$vfile=cview($one,$two,$sch=VCFOLDER);			
	if(isset($_GET['vfile'])){ pr($vfile); }	
	
	
	// prx($data);
	
	$this->view->render($data,$vfile,$this->layout);	

}	/* fxn */


 
public function sync($params){
$dbo=PDBO;
$data['crid']=$crid=$params[0];
$db=&$this->model->db;$dbg=PDBG;
$ctype_id=CTYPECONDUCT;
$q=" SELECT id AS condcrs FROM {$dbg}.05_courses WHERE crstype_id='".CTYPECONDUCT."' AND crid='$crid' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$condcrs=$row['condcrs'];

$q="SELECT scid FROM {$dbg}.05_summaries WHERE crid='$crid';";
$sth=$db->querysoc($q);
$a=$sth->fetchAll();
$ar=buildArray($a,'scid');	
$q="SELECT scid FROM {$dbg}.50_grades WHERE course_id='$condcrs'; ";
$sth=$db->querysoc($q);
$b=$sth->fetchAll();
$br=buildArray($b,'scid');

$ix=array_diff($ar,$br);		
$q=" INSERT INTO {$dbg}.50_grades(`scid`,`course_id`,`crstype_id`) VALUES  ";
foreach($ix AS $scid){ $q .= " ('$scid','$condcrs',$ctype_id),"; }
$q = rtrim($q,",");$q .= "; ";		
$sth=$db->query($q);	
echo ($sth)? "Success":"Empty";

}	/* fxn */



public function annual($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");

	$data['crid'] = $crid 		= $params[0];	
	$ssy		= $_SESSION['sy'];	
	$sy 	 	= $data['sy'] 	= isset($params[1])? $params[1] : $ssy;	
	$home 		= $data['home']	= $_SESSION['home'];
	$current	= $data['current']	= ($sy==$ssy)? true:false;
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

	$data['srid']=$srid=$_SESSION['srid'];
	$allowed = array(RMIS,RREG,RACAD,RADMIN,RTEAC);
	
	$data['cr'] = $cr = getClassroomDetails($db,$crid,$dbg);		
	$acid=$cr['acid'];
	$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];
	
	$q="SELECT crs.id AS crs,crs.name AS course
		FROM {$dbg}.05_courses AS crs
		INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		WHERE cr.id='$crid' AND crs.crstype_id='".CTYPECONDUCT."';";
	$sth=$db->querysoc($q);
	$data['conduct']=$sth->fetch();
	
	$q="
		SELECT 
			c.id AS scid,c.name AS student,c.code,c.position,
			summ.conduct_q1,summ.conduct_q2,summ.conduct_q3,summ.conduct_q4,summ.conduct_q5,
			summ.conduct_dg1,summ.conduct_dg2,summ.conduct_dg3,summ.conduct_dg4,summ.conduct_dg5
		FROM {$dbg}.05_summaries AS summ  
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		WHERE summ.crid='$crid' ORDER BY $order LIMIT 100;
	";
	// pr($q);
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();

		
	$this->view->render($data,'conducts/annualConducts');
	
}	/* fxn */


public function locking($params=NULL){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT aq.*,aq.id AS pkid,cr.name AS classroom 
		FROM {$dbg}.05_advisers_quarters AS aq
		INNER JOIN {$dbg}.05_classrooms AS cr ON aq.crid=cr.id
		WHERE cr.level_id=$lvl; ";
		debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$data['levels']=$_SESSION['levels'];
	$data['level']=fetchRow($db,"{$dbo}.05_levels",$lvl);
	
	$this->view->render($data,"conducts/lockingConducts");	
	
}	/* fxn */



public function editConductProcessByStudent($params=NULL){
	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['settings']['quarter'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['db']=&$db;
	$data['dbo']=&$dbo;
	$data['dbg']=&$dbg;
	
	$q="SELECT summ.scid,summ.crid,c.code AS studcode,c.name AS studname,
			aw.`is_conduct_awardee_q{$qtr}` AS `is_awardee`,
			aw.scid AS awscid
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbg}.`05_summaries` AS summ ON summ.scid=c.id		
		LEFT JOIN {$dbg}.`05_awardees` AS aw ON aw.scid=c.id		
		WHERE c.id=$scid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['student']=$student=$sth->fetch();
		
	if(!isset($student['awscid'])){
		$q="INSERT INTO {$dbg}.05_awardees(scid)VALUES($scid); ";
		$sth=$db->query($q);	
		pr($q);
		echo ($sth)? "sync awardee success":"sync awardee fail";
	}
	
	
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$vfile="customs/{$sch}/editConductProcessByStudent_{$sch}";
	vfile($vfile);
		
	$this->view->render($data,$vfile);
	
	
}	/* fxn */



public function editOne($params=NULL){
	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['settings']['quarter'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['db']=&$db;
	$data['dbo']=&$dbo;
	$data['dbg']=&$dbg;
	
	if($scid){
		$q="SELECT summ.crid,summ.scid,summ.crid,c.code AS studcode,c.name AS studname		
			FROM {$dbo}.00_contacts AS c
			INNER JOIN {$dbg}.`05_summaries` AS summ ON summ.scid=c.id		
			WHERE c.id=$scid LIMIT 1; ";
		$sth=$db->querysoc($q);
		$data['student']=$student=$sth->fetch();		
	}	/* scid */		
	$vfile="conducts/editOneConduct";
	vfile($vfile);
	$this->view->render($data,$vfile);	
	
}	/* fxn */






}	/* ConductsController */
