<?php

Class OgController extends Controller{	/* GISController from bootstrap */


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->css=array('etc.css','style_long.css');
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/crypto.js');	
	parent::beforeFilter();		
	
}


/* IMPT: for 3T */
public function scores($params){	
$dbo=PDBO;
	// $this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','js/vegas_tables.js');	
	$data['sch']=$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$_SESSION['q']="";

$sq="";	/* session query */ 
	if($_SESSION['settings']['custom_equiv']==1){
		require_once(SITE."views/customs/{$sch}/equivs_{$sch}.php");	
	} else {
		require_once(SITE."functions/equivs.php");	
	}
	if((!isset($_SESSION['scores_fields'])) || (!isset($_SESSION['scores_singularity']))){ 
		$custfile = SITE."views/customs/".VCFOLDER."/customs.php"; 
		if(is_readable($custfile)){ require_once($custfile); } 
		$_SESSION['scores_fields']=isset($_SESSION['scores_fields'])? $_SESSION['scores_fields']:"cri.id";  
		/* 2 */
		$_SESSION['scores_singularity']=isset($_SESSION['scores_singularity'])? $_SESSION['scores_singularity']:"";  
	}	/* custfile session_scores */
	
	$scores_fields=$_SESSION['scores_fields'];
	$scores_fields="cri.id";
	if(isset($_GET['vfile'])){ pr($vfile); echo "Layout: $layout <br />"; }			

	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/sessionize.php");	
	require_once(SITE."functions/sessionize_teacher.php");	
	require_once(SITE."functions/scores.php");
	require_once(SITE."functions/transmutation.php");
	require_once(SITE."functions/counts.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/classifications.php");
	
	$data['home']=$home=$_SESSION['home']; 			
	$data['course_id']=$course_id =$params[0];
	$data['scid']=$scid=$params[1];
	$data['sy']=$sy=isset($params[2])? $params[2]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[3])? $params[3]:$_SESSION['qtr'];
	$data['user']=$user=$_SESSION['user'];
	$data['teacher']=$teacher=($user['role_id']==RTEAC)? true:false;
	$data['srid']=$srid=$_SESSION['srid'];
	$data['admin']=(($srid==RMIS) || ($srid==RREG))? true:false;

	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;	
	
	$data['dbg']=&$dbg;$data['dbo']=PDBO;$data['db']=&$db;	
	
	$_SESSION['url']="teachers/scores/$course_id/$sy/$qtr";
	$data['course']=$course=getCourseDetails($db,$course_id,$dbg);
	$_SESSION['course']=$course;
	$course_name=$course['name'];
	$subdepartment_id=$course['subdepartment_id'];	
	$data['sem']=$sem =$course['semester'];
	$data['qf']=$qf=($sem==2)? 'q6':'q5';
	$data['dgf']=$dgf=($sem==2)? 'dg6':'dg5';	
	$data['is_transmuted']=$is_transmuted=($course['is_transmuted']==1)? true:false;	
	$data['crid']=$crid=$course['crid'];	
	
if($srid==RTEAC){ if((!in_array($course_id,$_SESSION['teacher']['course_ids']))) { flashRedirect('teachers'); } }	
		
	if(isset($_POST['finalize'])){
		$qqtr='q'.$qtr;
		$dgr=isset($_POST['data']['dgr'])? $_POST['data']['dgr'] : null;		
		$q="";
		$rows = $_POST['data']['Grade'];	
		if($qtr==4){
			foreach($rows AS $row){				
				$bonus=empty($row['bonus'])? 0:$row['bonus']; 			
				$grade = $row['qqtr']+$bonus;
				$q .= " UPDATE {$dbg}.50_grades set `$qqtr` = '$grade',`r{$qqtr}` = '".$row['raw']."', ";			
				$q .= " `dg{$qtr}` = '".$row['dg']."',`bonus_q{$qtr}` = '$bonus', "; 		
				$q .= " `$qf` = '".$row['ave']."',`$dgf` = '".$row['dgave']."' WHERE `id` = '".$row['gid']."' LIMIT 1; ";
			}				
		} else {
			foreach($rows AS $row){
				$bonus=empty($row['bonus'])? 0:$row['bonus']; 							
				$grade = $row['qqtr']+$bonus;
				$q .= " UPDATE {$dbg}.50_grades set `$qqtr` = '$grade',`r{$qqtr}` = '".$row['raw']."', ";			
				$q .= " `dg{$qtr}` = '".$row['dg']."',`bonus_q{$qtr}` = '$bonus' "; 		
				$q .= " WHERE `id` = '".$row['gid']."' LIMIT 1; ";
			}				
		}		
		$db->query($q);
		$url="grades/scid/$scid/$sy/$qtr";
		flashRedirect($url,"Updated student record - {$course_name}.");				
	}	/* finalize */	
		
	/* from model scores */
	$data['curr_qtr']=$_SESSION['qtr'];
	$data['is_locked']=$course['is_finalized_q'.$qtr];
	$data['course_id']=$course_id;
	$data['qtr']=$qtr;
	
	$crsClass=classifyCourse($course);
	$data['ctype']=$ctype=isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id']=$dept_id=isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
	$deptrow=getDepartmentArray($dept_id);
	$data['deptcode']=$deptcode=strtolower($deptrow['dept_code']);
	
	$data['ratings']=getRatings($db,$ctype,$dept_id);		
	$data['equivs']=$equivs=getEquivs($db,$ctype,$dept_id);		
	
	
	$crid = $course['crid'];	
	$data['with_score_ranks'] = $_SESSION['settings']['with_score_ranks'];
	$data['dr']=getDepartmentArray($course['department_id']);
	
if($data['is_locked'] && $data['with_score_ranks']){ $order = " g.`q$qtr` DESC ";		
} else {  $order = $_SESSION['settings']['classlist_order']; }

$order=(isset($_GET['sort']))? $_GET['sort']:$order;
// $data['students']=classyearGrades($db,$dbg,$sy,$crid,$course_id,$male=2,$order,$fields=",c.is_male");		
$data['students']=studentGrades($db,$dbg,$sy,$scid,$course_id,$fields=NULL,$filter=NULL);		


$data['num_scores']=count($data['students']);
$data['num_students']=count($data['students']);
			
$data['kpup']=$kpup=$course['is_kpup']; 
$data['tier']=$tier=$_SESSION['settings']['tier_adapter']; 


$data['activities'] = getActivities($db,$dbg,$course_id,$qtr,$scores_fields);	
foreach($data['students'] AS $student){ $data['scores'][] = 
	getScores($db,$dbg,$course_id,$student['scid'],$qtr,$scores_fields); }		


	$sq.=$_SESSION['q'];		
	$data['num_activities'] = count($data['activities']);

/* ------------ finalize button control ----------------------------------------------------- */
	/* for components */
	$level_id=$course['level_id'];
	$subject_id=$course['subject_id'];
	$data['subject_id']=&$subject_id;
	$data['level_id']=&$level_id;

	/* course components */
	$q="SELECT count(comp.id) AS ct FROM {$dbg}.05_components AS comp
		WHERE comp.level_id = '$level_id' AND comp.subject_id = '$subject_id'; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$data['num_crs_components']=$row['ct'];

	/* activities components */
	$q = "SELECT act.id,act.component_id,act.name FROM {$dbg}.50_activities AS act
		INNER JOIN {$dbg}.05_courses AS crs ON act.course_id = crs.id
		WHERE act.course_id = '$course_id' AND act.quarter = '$qtr' 
		GROUP BY act.component_id;";		
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();		
	$data['num_acts_components'] = count($rows);
	
	$data['editable']=(!$data['is_locked']);
	$data['locked_with_ranks']=(!$data['is_locked'] && $data['with_score_ranks']);
	$data['selects']=selectsCourseCriteria($db,$course_id);	
	
	$vpath = SITE."views/customs/{$sch}/scores3T.php";		
	if(is_readable($vpath)){ $vfile="/customs/{$sch}/scores3T";	
	} else { $vfile="teachers/scores3T"; }		
	$data['algo']=(isset($_GET['algo']))? $_GET['algo']:$_SESSION['settings']['algo'];
	$data['with_dg']=($course['is_num']==1)?0:1;
	debug($sq);	
		
	$vfile.=$_SESSION['scores_singularity'];					
	if(isset($_GET['multiple'])){ $vfile.="_multiple"; }	
	if(isset($_GET['sch'])){ pr($vfile); }	
	$this->view->render($data,$vfile);			
	
}	/* fxn */






} 	/* TeachersController */
