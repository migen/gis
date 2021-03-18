<?php

Class AveragesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	parent::beforeFilter();			
}


public function index(){ 

	$this->view->render($data=NULL,'averages/indexAverages');

}	/* fxn */




public function course($params){	/* averages */
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/sessionize.php");	
	require_once(SITE."functions/sessionize_teacher.php");	
	require_once(SITE."functions/aggregates.php");	
	require_once(SITE."functions/classifications.php");	
	$db=&$this->model->db;$dbo=PDBO;	
	$data['with_chinese'] = $with_chinese = $_SESSION['settings']['with_chinese'];

	$data['home']		= $home		= $_SESSION['home'];
	$data['course_id']	= $course_id	= $params[0];
	$data['ssy']		= $ssy		= $_SESSION['sy'];
	$data['sqtr']		= $sqtr		= $_SESSION['qtr'];
	$data['sy'] 		= $sy 		=  	isset($params[1])? $params[1]:$ssy;
	$data['qtr']		= $qtr 		= 	isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['decicard']	= $decicard = isset($_GET['deci'])? $_GET['deci']:$_SESSION['settings']['decicard'];
	
	$data['curr_sy']	= $curr_sy 	= 	$_SESSION['sy'];
	$data['course'] 	= $course		=	getCourseDetails($db,$course_id);	
	$data['subject_id']	= $course['subject_id'];
	
	$data['sem']  		= $sem 	= isset($_GET['sem'])? $_GET['sem']:0;			
	$data['qf']  = $qf  = ($sem==2)? 'q6':'q5';
	$data['dgf'] = $dgf = ($sem==2)? 'dg6':'dg5';
	
	$ctype_id = $course['crstype_id'];
	
	$data['crid']		= $crid 		= 	$course['crid'];	
	$data['is_k12']		= $is_k12		= $course['is_k12'];	
	
	/* acl */
	$data['srid']	= $srid	= $_SESSION['srid'];
	$allowed = array(RMIS,RREG,RACAD);
	$data['admin'] = $admin = (in_array($srid,$allowed))? true:false;	
	$data['mine']	= $mine		= ($course['tcid']==$_SESSION['user']['ucid'])? true:false;	
	$data['adviser']= $adviser	= (!$admin && in_array($crid,$_SESSION['teacher']['advisory_ids']))? true:false;
	if(!$admin && !$mine && !$adviser) { $this->flashRedirect($home); }	
	
/* --------------------- */	
$data['ssy']	= $ssy	= $_SESSION['sy'];

$dbg = VCPREFIX.$sy.US.DBG;

	// $fields = ($with_chinese==1)? ",c.chinese_name":NULL;
	$fields=NULL;
	$sort=NULL;
	$order=$_SESSION['settings']['classlist_order'];
	
	$sort=(isset($_GET['sort']))? $_GET['sort']:$sort;		
	$data['grades'] = $grades = courseGrades($db,$dbg,$crid,$course_id,$sy,$sort,$order,$fields);		
	$data['num_grades']	= count($data['grades']);
		
	$condsort= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$condsort.= "c.`is_male` DESC,c.`name`";
	
	$data['students']=$students=classyear($db,$dbg,$sy,$crid,$male=2,$condsort);	
	$data['num_students']=$num_students=count($students);
	
	
	$crsClass = classifyCourse($course);
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
	$data['ratings'] = getRatings($db,$ctype,$dept_id);		
	$_SESSION['url']	= "averages/course/$course_id/$sy/$qtr&ctype=$ctype&dept=$dept_id";
	$data['stats']	    = $stats		= getStatsByCourse($db,$dbg,$sy,$course_id);
	
	$data['num_ratings'] = $num_ratings = count($data['ratings']);
	$data['num_stats'] 	 = $num_stats 	= count($data['stats']);
	$data['has_stats']	= $has_stats	= ($num_ratings==$num_stats)?true:false;
	
	if(isset($_GET['parameters'])){
		$get=sages($_GET);
		$get=str_replace('parameters=','',$get);
		$url="averages/course/$course_id/$sy/$qtr$get";
		flashRedirect($url,'Parameters set.');
		exit;
	}
	
	if(isset($_POST['add_stats'])){
		$stats = $_POST['stats'];	
		$q  = "DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$course_id'; ";
		$q .= "INSERT INTO {$dbg}.50_stats (`quarter`,`course_id`,`dgid`,`count`) VALUES ";
		foreach($stats AS $k => $v){
			$q.=" ('$qtr','$course_id','$k','$v'),";			
		}
		$q = rtrim($q,',');$q .= "; ";		
		$db->query($q);
		$url = "averages/course/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id";
		redirect($url);					
	}	/* add_stats */
	
	if(isset($_POST['submit'])){	/* 1- dbg.stats.count, 2-dbg.50_grades.fg */		
		// $rows=isset($_POST['grades'])? $_POST['grades']:array();		
		$rows=isset($_POST['grades'])? $_POST['grades']:[];		
		$stats = $_POST['stats'];				
		if(!$has_stats){
			$q  = "DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$course_id'; ";
			$q .= "INSERT INTO {$dbg}.50_stats (`quarter`,`course_id`,`dgid`,`count`) VALUES ";
			foreach($stats AS $k => $v){
				$q .= " ('$qtr','$course_id','$k','$v'), ";			
			}
			$q = rtrim($q,', ');
			$q .= "; ";
		} else {
			$q = "";
			foreach($stats AS $k => $v){			
				$q .= " UPDATE {$dbg}.50_stats SET `quarter` = '$qtr',`count` = '$v' WHERE `course_id` = '$course_id' AND `dgid` = '$k' LIMIT 1; ";
			}
		}
		$db->query($q);

// $course['is_num']=0;


$q = "";
if($course['is_num']==0){
	foreach($rows AS $row){ 
		$exists = empty($row['gid'])? false:true;
		if($exists){
			$q .= " UPDATE {$dbg}.50_grades SET `{$qf}` = '".$row['fg']."',`{$dgf}` = '".$row['dg']."'  
					WHERE `id` = '".$row['gid']."' LIMIT 1; ";		
		} else {
			$q .= " INSERT INTO {$dbg}.50_grades (`course_id`,`crstype_id`,`scid`,`{$qf}`,`{$dgf}`) VALUES 
				('$course_id','$ctype_id','".$row['scid']."','".$row['fg']."','".$row['dg']."'); ";
		}									
	}	
} else {
	foreach($rows AS $row){ 
		// pr($row);
		$exists = empty($row['gid'])? false:true;
		if($exists){
			$q .= " UPDATE {$dbg}.50_grades SET `{$qf}` = '".$row['fg']."' WHERE `id` = '".$row['gid']."' LIMIT 1; ";	
		} else {
			$q .= " INSERT INTO {$dbg}.50_grades (`course_id`,`crstype_id`,`scid`,`{$qf}`) VALUES 
				('$course_id','$ctype_id','".$row['scid']."','".$row['fg']."'); ";
		}							
	}	
}	/* is_num */

// prx($q);
		
$db->query($q);		

	// lockCourse($db,$course_id,$qtr,$dbg);
	// sessionizeTeacher($db,$dbg);		
	$url=$home;				
	flashRedirect($url,'Averages processed.');	
	
	}	/* post */
	
/* -------------------- */	
	$_SESSION['course'] 			 = $course;
	$_SESSION['course']['course_id'] = $course_id;				

	$sch=(isset($_GET['sch']))? $_GET['sch']:VCFOLDER;
	
	$vpath = SITE."views/customs/{$sch}/courseAveragesNum.php";		

	
	if(is_readable($vpath)){ 
		$vfile=($course['is_num']==0)?"/customs/{$sch}/courseAveragesDG":"/customs/{$sch}/courseAveragesNum";	
	} else { 
		$vfile=($course['is_num']==0)? "averages/courseAveragesDG":"averages/courseAveragesNum";

		if($sem && $course['is_num']==1){
			$vfile="averages/courseAveragesNum_sem";
		}		
	}
	
	
	$data['qtr']=$qtr=($qtr>4)? 4:$qtr;
	$data['is_locked'] 	= $course['is_finalized_q'.$qtr];	
	debug($vfile);	
	
	
	
	if(isset($_GET['vfile'])){ pr($vfile); }
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function courseRanks($params){
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/ranks_course.php");
	$db =& $this->model->db;$dbo=PDBO;

	$course_id 		= $params[0];			
	$data['ssy']	= $ssy	 = $_SESSION['sy'];
	$data['sy']  	= $sy	 = isset($params[1])? $params[1]:$ssy;
	$data['sqtr']	= $sqtr	 = $_SESSION['qtr'];	
	$data['qtr']	= $qtr	 = isset($params[2])? $params[2]  : $sqtr;	
	$dbg = VCPREFIX.$sy.US.DBG;
	
	$data['course'] = $course	= getCourseDetails($db,$course_id,$dbg);	
	$data['crid']   = $crid		= $course['crid'];	
	$data['intfqtr']	= $intfqtr	= ($course['is_sem'] && $sqtr>2)? '6':'5';
	
if($_SESSION['srid']==RTEAC){
	if(!in_array($course_id,$_SESSION['teacher']['course_ids'])){  $this->flashRedirect('teachers'); }		
}
		
	$data['is_locked']  =  $course['is_finalized_q'.$qtr]; 
	$data['qf']	= "q{$qtr}";
	
	$data['ranks'] 		= getCourseRanks($db,$dbg,$crid,$course_id,$sy,$data['qf']);	
	$data['num_rows'] 	= count($data['ranks']);
		
	$this->view->render($data,'averages/courseRanks');

} 	/* fxn */



public function sortCourseRanks($params){
$dbo=PDBO;
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_teacher.php");
	require_once(SITE."functions/ranks_course.php");
		
	$data['continuous']	  = $continuous	= isset($_GET['continuous'])? true:false;	
	$data['course_id'] 	= $course_id 		= $params[0];			
	$data['ssy']	= $ssy	 = $_SESSION['sy'];
	$data['sy']  	= $sy	 = isset($params[1])? $params[1]:$ssy;
	$data['sqtr']	= $sqtr	 = $_SESSION['qtr'];	
	$data['qtr']	= $qtr	 = isset($params[2])? $params[2]  : $sqtr;
	$current=($sy==DBYR)? true:false;
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
		
if($_SESSION['srid']==RTEAC){
	if(!in_array($course_id,$_SESSION['teacher']['course_ids'])){  flashRedirect('teachers'); }		
}	
	$data['course']=$course=getCourseDetails($db,$course_id,$dbg);			
	$data['sem']=$sem=$course['semester'];
	$data['intfqtr']=$intfqtr=($sem==2)? '6':'5';
	$data['fqtr']=$fqtr='q'.$intfqtr;
	
	$data['crid']  		= $crid 	= $course['crid'];		
	$data['qf'] 		= $qf		= 'q'.$qtr;		
	$data['is_locked']  = $course['is_finalized_q'.$qtr]; 		
			
/* ------------------------------------------------------------------------------------------------- */

	if(isset($_POST['submit'])){		
		/* 1- process ranks */
		$rows = $_POST['data'];
		$q = "";
foreach($rows AS $row){ $q .= " UPDATE {$dbg}.50_grades SET `rank_q$qtr` = '".$row['qqtr']."' WHERE `id` = '".$row['gid']."' LIMIT 1;  "; }
		$db->query($q);
		
		/* 2 - lock course,then reset session */
		if($qtr<4){ lockCourse($db,$course_id,$qtr,$dbg);								
		} elseif($qtr==4){
			$url = "averages/sortCourseRanks/$course_id/$sy/$intfqtr";
			flashRedirect($url,'Qtr 4 Ranking Done. <br /><span class="b u">SORT</span> Q1 - Q4 Final Average Ranks.');	
		} else {
			lockCourse($db,$course_id,4,$dbg);				
			lockCourse($db,$course_id,$intfqtr,$dbg);										
		}
		sessionizeTeacher($db,$dbg);		

		/* 3 - redirect to view ranks */
		$url = "averages/courseRanks/$course_id/$sy/$qtr";
		redirect($url);
	} 	/* post */
	
/* ---------- process ---------- */

	$data['ranks'] 		= getCourseRanks($db,$dbg,$crid,$course_id,$sy,$qf);  	
	$data['num_rows'] 	= count($data['ranks']);		

	$vfile="averages/sortCourseRanks123";
	vfile($vfile);
	$this->view->render($data,$vfile);

} 	/* fxn */


public function courseStats($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$data['course_id']	= $course_id = $params[0];
	$data['ssy'] = $ssy = $_SESSION['sy'];
	$data['sy'] = $sy = $params[1];
	$data['qtr'] = $qtr = $params[2];
	$db=&$this->model->db;$dbg = VCPREFIX.$sy.US.DBG;
	$data['course'] = $course = getCourseDetails($db,$course_id,$dbg);
	$q = "SELECT s.*,dg.* FROM {$dbg}.50_stats AS s
			INNER JOIN {$dbg}.05_descriptions AS dg ON dg.id = s.dgid
		WHERE s.course_id 	= '$course_id'; ";
	$sth = $db->querysoc($q);
	$data['stats'] = $stats = $sth->fetchAll();
	$data['num_stats'] = count($stats); 
	$this->view->render($data,'averages/courseStats');

}	/* fxn */


public function reave($params){
$dbo=PDBO;
$crid=$params[0];
$sy=$params[1];
$qtr=$params[2];

$deciave=isset($_GET['deciave'])? $_GET['deciave']:$_SESSION['settings']['deciave'];
echo "<p>&deciave=$deciave</p>";
$db=&$this->model->db;$dbg=PDBG;

$q=" SELECT cr.name AS classroom,l.name AS level,l.is_sem
	FROM {$dbg}.05_classrooms AS cr INNER JOIN {$dbo}.`05_levels` AS l ON l.id=cr.level_id 
	WHERE cr.id='$crid' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();

$is_sem=$row['is_sem'];
$odd=($qtr%2)? 1:0;
$db=&$this->model->db;

$q="";

$case=0;
if($is_sem){
	echo "Sem Not Even Qtr<br />";
	if(!$odd){
		echo "Sem - Even Qtr<br />";
		$q = "UPDATE {$dbg}.50_grades AS a
			INNER JOIN (
				select * FROM {$dbg}.05_courses WHERE `semester` = '1' AND `crid`='$crid'
			) AS b ON b.id = a.course_id
			SET a.q5 = round(((a.q1+a.q2)/2),$deciave); ";
		$q .= "UPDATE {$dbg}.50_grades AS a
			INNER JOIN (
				select * FROM {$dbg}.05_courses WHERE `semester` = '1' AND `crid`='$crid'
			) AS b ON b.id = a.course_id
			SET a.q6 = round(((a.q3+a.q4)/2),$deciave); ";			
	}

} else {
	echo "NOT Sem<br />";
	$expr = "a.q1";
	for($i=2;$i<=$qtr;$i++){ $expr .= "+a.q$i"; }		
	$q="
		UPDATE {$dbg}.50_grades AS a
		INNER JOIN (
			select * FROM {$dbg}.05_courses WHERE `crid` = '$crid' AND `crstype_id`=1
		) AS b ON b.id = a.course_id
		SET a.q5 = round((($expr)/$qtr),$deciave); 
	";
	
}

pr($q);
$db->query($q);
echo "Query exec.";


}	/* fxn */


public function bed(){
$dbo=PDBO;
	$dbg=PDBG;$db=&$this->baseModel->db;
	// $data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
	$data=NULL;	
	if(isset($_POST['submit'])){
		$decicard=$_POST['decicard'];
		$deciave=$_POST['deciave'];		
		$expr="round(a.q1,$decicard)";
		$qtr=4;
		for($i=2;$i<=$qtr;$i++){ $expr .= "+round(a.q$i,$decicard)"; }			
		$q="UPDATE {$dbg}.50_grades AS a 
			INNER JOIN {$dbg}.05_courses AS crs ON a.course_id=crs.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
			SET a.q5=round((($expr)/$qtr),$deciave) WHERE cr.level_id<14;";
		pr($q);
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";		
		exit;
				
	}	/* post */
	
	$this->view->render($data,'averages/bedAverages');	
}	/* fxn */


/* UPDATE 2018_dbgis_sjam.50_grades AS a 
INNER JOIN ( SELECT * FROM 2018_dbgis_sjam.05_courses WHERE `semester`=1 ) AS b ON b.id = a.course_id
SET a.q5=round(((round(a.q1,0)+round(a.q2,0))/2),3); 
UPDATE 2018_dbgis_sjam.50_grades AS a
INNER JOIN ( SELECT * FROM 2018_dbgis_sjam.05_courses WHERE `semester`=2 ) AS b ON b.id = a.course_id
SET a.`q5`=0; 
UPDATE 2018_dbgis_sjam.50_grades AS a
INNER JOIN ( SELECT * FROM 2018_dbgis_sjam.05_courses WHERE `semester`=2) AS b ON b.id = a.course_id
SET a.`q6`=round(((round(a.q3,0)+round(a.q4,0))/2),3);  */

public function shs(){
$dbo=PDBO;
	$dbg=PDBG;$db=&$this->baseModel->db;
	// $data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
	$data=NULL;	
	if(isset($_POST['submit'])){
		// $levels=$_POST['levels'];
		$decicard=$_POST['decicard'];
		$deciave=$_POST['deciave'];		
		$expr="round(a.q1,$decicard)";
		$qtr=4;
		$q="";
		for($i=2;$i<=$qtr;$i++){ $expr .= "+round(a.q$i,$decicard)"; }			
		$q.="UPDATE {$dbg}.50_grades AS a 
			INNER JOIN {$dbg}.05_courses AS crs ON a.course_id=crs.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
			SET a.q5=round(((round(a.q1,$decicard)+round(a.q2,$decicard))/2),$deciave) 
			WHERE cr.level_id>13 AND crs.semester=1;";
		$q.="UPDATE {$dbg}.50_grades AS a 
			INNER JOIN {$dbg}.05_courses AS crs ON a.course_id=crs.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
			SET a.q6=round(((round(a.q3,$decicard)+round(a.q4,$decicard))/2),$deciave) 
			WHERE cr.level_id>13 AND crs.semester=2;";
		$q.="UPDATE {$dbg}.50_grades AS a 
			INNER JOIN {$dbg}.05_courses AS crs ON a.course_id=crs.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
			SET a.q5=round(((round(a.q1,$decicard)+round(a.q2,$decicard)
				+round(a.q3,$decicard)+round(a.q4,$decicard))/4),$deciave) 
			WHERE cr.level_id>13 AND crs.semester=0;";						
		// pr($q);
		$sth=$db->query($q);
		// echo ($sth)? "Success":"Fail";		
		$url=$_SESSION['home'];
		flashRedirect($url,"Averages done.");
		exit;
				
	}	/* post */
	$this->view->render($data,'averages/shsAverages');	
}	/* fxn */




}	/* AveragesController */
