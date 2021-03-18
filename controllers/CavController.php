<?php

Class CavController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;	
	$data['qtr']=$_SESSION['qtr'];
	$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,name","id");
	$this->view->render($data,'cav/indexCav');
	

}	/* fxn */



public function student($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/sessionize_classroom.php");
	require_once(SITE."functions/sessionize_ratings.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/classifications.php");
	
	$data['course_id']=$course_id=$params[0];
	$data['scid']=$scid=$params[1];

	$data['ssy']=$ssy=DBYR;	
	$data['sy']=$sy=isset($params[2])? $params[2]:DBYR;
	$data['qtr']=$qtr=isset($params[3])? $params[3]:$_SESSION['qtr'];	
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

	/* controller - teachers or else */
	$data['home']	= $home	= $_SESSION['home'];	
	$course=getCourseDetails($db,$course_id,$dbg);	
	$data['course']=$course;	
	$is_trait = ($course['is_trait'])? 1 : 0;
	$data['is_trait']	= $is_trait;	
	$data['crid'] = $crid = $data['course']['crid'];	
	
	if(!isset($_SESSION['ratings'])){ sessionizeRatings($db,$course); }	
	if(isset($_GET['reset'])){ sessionizeRatings($db,$course); }	
	
	$data['ratings']=$ratings=$_SESSION['ratings'];
	$data['ctype']=$_SESSION['ctype'];
	$data['dept_id']=$_SESSION['dept_id'];
	
	
if($_SESSION['srid']==RTEAC){ 
	if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  flashRedirect('teachers'); } 
}
		
	if(isset($_SESSION['crid'])){ if($_SESSION['crid']!=$crid) sessionizeCridStudents($db,$dbg,$crid);	
	} else { $_SESSION['crid'] = $crid;sessionizeCridStudents($db,$dbg,$crid);	}
		
	$data['boys']  = $_SESSION['boys'];
	$data['girls'] = $_SESSION['girls'];
		
	$data['flrgr'] = $flrgr = getConductFloorGrade($course,$_SESSION['settings']);	
	$dgonly=isset($_GET['dgonly'])? 'dgonly':false;
	
	// pr($ratings);
	
if(isset($_POST['save'])){		
	// pr($_POST);exit;

	$scid=$_POST['scid'];
	$rows = $_POST['grades'];		
	$q = "";
	foreach($rows AS $row){ 
		$gid=$row['gid'];
		$grade = $row['grade'];			
		$dg = rating($grade,$ratings); 				
		$q .= " UPDATE {$dbg}.50_grades SET `q$qtr` = '".$grade."',`dg$qtr` = '$dg'				
			WHERE `id` = '$gid' LIMIT 1; "; 				
	}
	$dg=rating($_POST['post']['final'],$ratings);
	$q .="UPDATE {$dbg}.05_summaries SET `conduct_q{$qtr}`='".$_POST['post']['final']."',
		`conduct_dg{$qtr}`='".$dg."' WHERE `scid`='$scid' LIMIT 1; "; 			
	$db->query($q);			
		
	if($qtr>3){
		$q="";
		foreach($rows AS $row){ 
			$q1="SELECT ((q1+q2+q3+q4)/4) AS avetr FROM {$dbg}.50_grades WHERE id='".$row['gid']."' LIMIT 1; ";
			$sth=$db->querysoc($q1);
			$trow=$sth->fetch();
			$fg=$trow['avetr'];
			$fdg = rating($fg,$ratings); 							
			$q .= " UPDATE {$dbg}.50_grades SET `q5` = '$fg',`dg5` = '$fdg'				
				WHERE `id` = '".$row['gid']."' LIMIT 1; "; 		
		}
		/* summ-conducts-genave */
		$q2="SELECT ((conduct_q1+conduct_q2+conduct_q3+conduct_q4)/4) AS avetr FROM {$dbg}.05_summaries 
			WHERE scid='$scid' LIMIT 1; ";
		$sth=$db->querysoc($q2);
		$trow=$sth->fetch();
		$fg=$trow['avetr'];
		$fdg = rating($fg,$ratings); 							
		$q .= " UPDATE {$dbg}.05_summaries SET `conduct_q5` = '$fg',`conduct_dg5` = '$fdg'				
			WHERE `scid` = '$scid' LIMIT 1; "; 		
		$db->query($q);						
	}	/* qtr over 3 */

	// pr($q);exit;		
		
	/* 5-redirect */
	$url = "cav/student/$course_id/$scid/$sy/$qtr?$dgonly";
	// pr($q);exit;
	redirect($url);		
	exit;
				
}	/* post-edit */ 

	
/* -------- data -------- */
	$data['course_id'] = $course_id;
	$data['scid'] = $scid;
	$data['sy']	= $sy;
	$data['qtr'] = $qtr;
	$data['student'] = student($db,$dbg,$sy,$scid);		
	$data['is_locked'] = $data['course']['is_finalized_q'.$qtr];
	$data['grades'] = editStudentTraitsDG($db,$dbg,$course_id,$scid,$sy,$qtr);

	$data['criteria'] = getTraitsCriteria($db,$course_id,$dbg);	
	$data['num_grades']			= count($data['grades']);
	
	$this->view->render($data,'cav/studentCav');

}	/* fxn */



public function dgStudent($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/sessionize_classroom.php");
	require_once(SITE."functions/sessionize_ratings.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/classifications.php");

	$course_id		= $params[0];
	$scid			= $params[1];

	$data['ssy']=$ssy=DBYR;	
	$data['sy']=$sy=isset($params[2])? $params[2]:DBYR;
	$data['qtr']=$qtr=isset($params[3])? $params[3]:$_SESSION['qtr'];	
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

	/* controller - teachers or else */
	$data['home']	= $home	= $_SESSION['home'];	
	$course=getCourseDetails($db,$course_id,$dbg);	
	$data['course'] 	= $course;	
	$is_trait = ($course['is_trait'])? 1 : 0;
	$data['is_trait']	= $is_trait;	
	$data['crid'] = $crid = $data['course']['crid'];	
	
	if(!isset($_SESSION['ratings'])){ sessionizeRatings($db,$course); }	
	if(isset($_GET['reset'])){ sessionizeRatings($db,$course); }	
	
	$data['ratings']=$ratings=$_SESSION['ratings'];
	$data['ctype']=$_SESSION['ctype'];
	$data['dept_id']=$_SESSION['dept_id'];
	
	
if($_SESSION['srid']==RTEAC){ 
	if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  flashRedirect('teachers'); } 
}
		
	if(isset($_SESSION['crid'])){ if($_SESSION['crid']!=$crid) sessionizeCridStudents($db,$dbg,$crid);	
	} else { $_SESSION['crid'] = $crid;sessionizeCridStudents($db,$dbg,$crid);	}
		
	$data['boys']  = $_SESSION['boys'];
	$data['girls'] = $_SESSION['girls'];
		
	$data['flrgr'] = $flrgr = getConductFloorGrade($course,$_SESSION['settings']);	
	$dgonly=isset($_GET['dgonly'])? 'dgonly':false;
	
	
if(isset($_POST['save'])){		
	// pr($_POST);exit;

	$scid=$_POST['scid'];
	$rows = $_POST['grades'];		
	$q = "";
	foreach($rows AS $row){ 
		$gid=$row['gid'];
		$dg = $row['dg'];			
		$q .= " UPDATE {$dbg}.50_grades SET `dg$qtr` = '$dg' WHERE `id` = '$gid' LIMIT 1; "; 				
	}
	$dgf=$_POST['post']['dgfinal'];
	$q .="UPDATE {$dbg}.05_summaries SET `conduct_dg{$qtr}`='".$dgf."' WHERE `scid`='$scid' LIMIT 1; "; 			
	$db->query($q);			
		
	/* 5-redirect */
	$url = "cav/dgStudent/$course_id/$scid/$sy/$qtr?$dgonly";
	redirect($url);		
	exit;
				
}	/* post-edit */ 

	
/* -------- data -------- */
	$data['course_id'] = $course_id;
	$data['scid'] = $scid;
	$data['sy']	= $sy;
	$data['qtr'] = $qtr;
	$data['student'] = student($db,$dbg,$sy,$scid);		
	$data['is_locked'] = $data['course']['is_finalized_q'.$qtr];
	$data['grades'] = editStudentTraitsDG($db,$dbg,$course_id,$scid,$sy,$qtr);

	$data['criteria'] = getTraitsCriteria($db,$course_id,$dbg);	
	$data['num_grades']			= count($data['grades']);
	
	$this->view->render($data,'cav/dgStudentCav');

}	/* fxn */



public function genave($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;$dbg=PDBG;
	$data['course_id'] = $course_id = $params[0];
	$sy = isset($params[1])? $params[1]:$_SESSION['sy'];
	$data['qtr'] = $qtr = isset($params[2])? $params[2]:$_SESSION['qtr'];
	
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$data['crid'] = $crid	= $course['crid'];
	$data['crid'] = $crid;
	
	$order= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$order.="c.grp,c.is_male DESC,c.name";


	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.05_summaries SET 
				`conduct_q{$qtr}`='".$post['grade']."',`conduct_dg{$qtr}`='".$post['dg']."'
				WHERE `scid`='".$post['scid']."' LIMIT 1;";		
		}
		$db->query($q);
		$url="cav/genave/$course_id";
		flashRedirect($url,'Conducts Genave Updated.');
		exit;
	}	/* fxn */
	

	$q="
		SELECT summ.conduct_q{$qtr} AS grade,summ.conduct_dg{$qtr} AS dg,c.name AS student,c.code,c.id AS scid 
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		WHERE summ.crid='$crid' ORDER BY c.is_male DESC,c.name;
	";
	$sth=$db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = $count = count($data['rows']);
	
	$this->view->render($data,'cav/genave');


}	/* fxn */


public function traits($params){	
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/tpgfxn.php");
	

	$data['course_id']= $course_id=$params[0];
	$data['ssy']=$ssy= $_SESSION['sy'];			
	$data['sy']=$sy= isset($params[1])? $params[1]:$ssy;
	$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['qtr']=$qtr=($qtr>5)?5:$qtr;
	$data['dgonly']= isset($_GET['dgonly'])? true:false;
	$data['sortcond']= $sortcond = isset($_GET['sort'])? '&sort='.$_GET['sort']:NULL;
	$dgcond=isset($_GET['dgonly'])? '&dgonly':NULL;
		
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$data['home']	=	$home = $_SESSION['home']; 				
	/* --------------------- PROCESS1 --------------------- */
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$crid	= $course['crid'];
	$data['crid'] = $crid;
	$_SESSION['course'] = $data['course'];		
	$data['ctype']=$ctype=isset($_GET['ctype'])? $_GET['ctype']:$course['crstype_id'];
	$data['dept_id']=$dept=isset($_GET['dept'])? $_GET['dept']:$course['department_id'];

	
	/* --------------------- POST --------------------- */
	if(isset($_POST['save'])){
		$rows = $_POST['rows'];
		$q = "";
		foreach($rows AS $row){
			$q .= "UPDATE {$dbg}.05_summaries SET `conduct_q{$qtr}` = '".$row['ave']."',
				`conduct_dg{$qtr}` = '".$row['dg']."' 
				WHERE `id` = '".$row['sumid']."' LIMIT 1;
			";		
		}	/* foreach */
		$db->query($q);		
		/* 2 */
		
		// pr($data['course']);
/* 		
		if($qtr>3){
			$q="UPDATE {$dbg}.50_grades AS a
					INNER JOIN {$dbg}.05_courses AS b ON a.course_id=b.id
					SET a.q5=((a.q1+a.q2+a.q3+a.q4)/4)
				WHERE b.crstype_id='".CTYPETRAIT."' AND b.crid='$crid';	 ";
			$db->query($q);		
		}	
 */
 		
		$url = "cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept".$dgcond;
		flashRedirect($url,'Conducts saved!');
	}
	
	/* --- lock ---  */
	if(isset($_POST['lock'])){		
		$url = "teachers/reset/teachers";
		redirect($url);						
	}	

	/* --- PROCESS2 --- */	
	$crsClass	= classifyCourse($course);
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
	$data['sort'] = $sort = isset($_GET['sort'])? $_GET['sort'] : NULL;	
	$data['ratings'] = getRatings($db,$ctype,$dept_id);		
	$_SESSION['url'] = "cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id";		
	$data['is_locked'] = $course['is_finalized_q'.$qtr];
	$data['criteria'] = getTraitsCriteria($db,$course_id,$dbg);
	$data['num_criteria'] = count($data['criteria']);
	
	$order= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$order=$_SESSION['settings']['classlist_order'];
	
$fields=" sum.conduct_q1 AS cq1,sum.conduct_q2 AS cq2,sum.conduct_q3 AS cq3,sum.conduct_q4 AS cq4,sum.conduct_q5 AS cfg,";	
$data['students']=$students=classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);		
$data['num_students']=$num_students=count($data['students']);

$q="";
$q.="<br />getStudentTraitsByCourse: <br />";
$gf = " g.q1,g.q2,g.q3,g.q4,g.q5,g.q6,";	
$q .= "
	debug copy only: SELECT 
		comp.weight,g.id AS gid,g.scid AS scid,g.course_id,g.criteria_id,$gf g.q5,g.dg1,g.dg2,g.dg3,g.dg4,g.dg5,g.dg6			
	FROM {$dbg}.`50_grades` AS g
		INNER JOIN {$dbo}.`00_contacts` AS `c`  ON g.`scid` = c.`id`
		INNER JOIN {$dbg}.`05_summaries` AS `summ`  ON summ.`scid` = c.`id`
		INNER JOIN {$dbg}.05_classrooms AS `cr`  ON summ.`crid` = cr.`id`			
		INNER JOIN {$dbg}.05_courses AS `crs`  ON g.`course_id` = crs.`id`
		INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
		INNER JOIN {$dbg}.05_components AS `comp` ON (comp.`criteria_id` = cri.`id` AND comp.level_id = cr.level_id) 
	WHERE crs.`id` = '$course_id' AND	g.`scid` 	= 'scid' 
	ORDER BY cri.position,cri.id; ";
$data['q']=$q;

for($i=0;$i<$num_students;$i++){ $data['scores'][$i]= getStudentTraitsByCourse($db,$dbg,$sy,$students[$i]['scid'],$course_id); } 

	$data['ix'] = tpgfxn($db,$dbg,$course['level_id'],$course['crid'],$course['course_id'],$sy,$qtr);				
	$vfile="cav/traitsCav";vfile($vfile);
	$_SESSION['q']=$q;
	$this->view->render($data,$vfile);				
	
}	/* fxn */


public function editColumn($params){
	
	require_once(SITE."functions/cav.php");	
	require_once(SITE."functions/details.php");	
	require_once(SITE."functions/equivs.php");	
	require_once(SITE."functions/reports.php");	
	require_once(SITE."functions/classifications.php");	

	$data['course_id']	 = $course_id  	 = $params[0];
	$data['criteria_id'] = $criteria_id	 = $params[1];
	$data['dgonly'] = isset($_GET['dgonly'])? true:false;
		
	$data['ssy']=$ssy=$_SESSION['sy'];			
	$data['sy']=$sy=$params[2];
	$data['qtr']=$qtr=$params[3];
	$qqtr="q".$qtr;	
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	
	$data['home']	=	$home = $_SESSION['home']; 				
	$_SESSION['url'] = "cav/traits/$course_id/$sy/$qtr";	
	
	/* --------------------- PROCESS1 --------------------- */
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$deptcode=($course['department_id']==3)? 'hs':'gs';
	$data['imax'] = isset($_GET['imax'])? $_GET['imax']:$_SESSION['settings']['trs_max_'.$deptcode];
	
	$crsClass=classifyCourse($course);	
	$data['ctype']=$ctype=isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id']=$dept_id=isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];
	$data['sortcond']=$sortcond=isset($_GET['sort'])? '&sort='.$_GET['sort']:NULL;
	$data['ratings']=$ratings=getRatings($db,$ctype,$dept_id);		
	
	$crid	= $course['crid'];
	$data['crid'] = $crid;
	$_SESSION['course'] = $data['course'];		
	$data['admin']	= (($_SESSION['srid']==RMIS) || ($_SESSION['srid']==RREG))? true:false;


	if(isset($_POST['submit'])){
		$rows = $_POST['rows'];		
		$q = "";
		foreach($rows AS $row){
			$grade=$row['grade'];
			$dg=rating($grade,$ratings);
			$q .= " UPDATE {$dbg}.50_grades SET `q{$qtr}` = '$grade',`dg{$qtr}` = '$dg'
				WHERE id = '".$row['gid']."' LIMIT 1; ";
		}
		if($qtr>3){
			foreach($rows AS $row){
				$q1="SELECT ((q1+q2+q3+q4)/4) AS avetr FROM {$dbg}.50_grades WHERE id='".$row['gid']."' LIMIT 1; ";
				$sth=$db->querysoc($q1);
				$trow=$sth->fetch();
				$fg=$trow['avetr'];
				$fdg = rating($fg,$ratings); 							
				$q .= " UPDATE {$dbg}.50_grades SET `q5` = '$fg',`dg5` = '$fdg'				
					WHERE `id` = '".$row['gid']."' LIMIT 1; "; 
			
			}			
		}	/* qtr>3 */		
		// pr($q);exit;
		$db->query($q);		
		// $url = "cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id{$sortcond}";
		$url = "cav/editColumn/$course_id/$criteria_id/$sy/$qtr";
		flashRedirect($url,"Saved.");
		exit;
	}

	/* process */	
	$sort=isset($_GET['sort'])? $_GET['sort'].',':NULL;
	// $sort.="c.is_male DESC,c.name ASC";
	$sort.=$_SESSION['settings']['classlist_order'];
	
	$data['traits']  = getTraitsByColumn($db,$dbg,$qtr,$crid,$course_id,$criteria_id,$sort);
	$data['numrows'] = count($data['traits']); 

	$q = " SELECT c.* FROM {$dbo}.`05_criteria` AS c WHERE c.`id` = '$criteria_id'; ";
	$sth = $this->model->db->querysoc($q);
	$data['criteria']  = $sth->fetch();	
	$data['critype_id']=$data['criteria']['critype_id'];
	$this->view->render($data,'cav/editColumn');


}	/* fxn */


public function dg($params){	
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/tpgfxn.php");
	
	$data['course_id']	= $course_id  	 = $params[0];
	$data['ssy']	 = $ssy		= $_SESSION['sy'];			
	$data['sy'] 	 = $sy		= isset($params[1])? $params[1]:$ssy;
	$data['qtr'] 	 = $qtr		= isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['dgonly'] = isset($_GET['dgonly'])? true:false;
	$data['sortcond'] = $sortcond = isset($_GET['sort'])? '&sort='.$_GET['sort']:NULL;
	$dgcond=NULL;		
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$data['home']	=	$home = $_SESSION['home']; 				
	
	/* --------------------- POST --------------------- */
	if(isset($_POST['save'])){
		$rows = $_POST['rows'];
		$q = "";
		foreach($rows AS $row){
			$q .= "UPDATE {$dbg}.05_summaries SET `conduct_dg{$qtr}` = '".$row['dg']."' 
				WHERE `id` = '".$row['sumid']."' LIMIT 1;
			";		
		}	/* foreach */
		$db->query($q);
		$url = "cav/dg/$course_id/$sy/$qtr?".$dgcond;
		flashRedirect($url,'Conducts saved!');
	}
	
	/* --------------------- PROCESS1 --------------------- */
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$crid	= $course['crid'];
	$data['crid'] = $crid;
	$_SESSION['course'] = $data['course'];		

	/* --------------------- lock --------------------- */
	if(isset($_POST['lock'])){		
		$url = "teachers/reset/teachers";
		redirect($url);						
	}	

	/* --------------------- PROCESS2 --------------------- */
	
	$_SESSION['url'] = "cav/dg/$course_id/$sy/$qtr";		
	$data['is_locked'] = $course['is_finalized_q'.$qtr];
	$data['criteria'] = getTraitsCriteria($db,$course_id,$dbg);
	$data['num_criteria'] = count($data['criteria']);
	
	$order= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$order.="c.grp,c.is_male DESC,c.name";
	
$fields = " sum.conduct_q1 AS cq1,sum.conduct_q2 AS cq2,sum.conduct_q3 AS cq3,sum.conduct_q4 AS cq4,sum.conduct_q5 AS cfg,";	
$data['students'] = $students	=  classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);		
$data['num_students']	=	$num_students = count($data['students']);


for($i=0;$i<$num_students;$i++){ $data['scores'][$i] = getStudentTraitsByCourse($db,$dbg,$sy,$students[$i]['scid'],$course_id); } 

	$data['ix'] = tpgfxn($db,$dbg,$course['level_id'],$course['crid'],$course['course_id'],$sy,$qtr);			
	$this->view->render($data,'cav/dgCav');				
	
}	/* fxn */


public function editColumnDG($params){
	require_once(SITE."functions/cav.php");	
	require_once(SITE."functions/details.php");	
	require_once(SITE."functions/reports.php");	
	$data['course_id']	 = $course_id  	 = $params[0];
	$data['criteria_id'] = $criteria_id	 = $params[1];
	$data['dgonly'] = isset($_GET['dgonly'])? true:false;
		
	$data['ssy']=$ssy=$_SESSION['sy'];			
	$data['sy']=$sy=$params[2];
	$data['qtr']=$qtr=$params[3];
	$qqtr	= "q".$qtr;
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$data['home']	=	$home = $_SESSION['home']; 				
	$_SESSION['url'] = "cav/traits/$course_id/$sy/$qtr";	
	
	/* --------------------- PROCESS1 --------------------- */
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$deptcode=($course['department_id']==3)? 'hs':'gs';	
	$data['sortcond'] = $sortcond = isset($_GET['sort'])? '&sort='.$_GET['sort']:NULL;	
	$crid	= $course['crid'];
	$data['crid'] = $crid;
	$_SESSION['course'] = $data['course'];		
	$data['admin']	= (($_SESSION['srid']==RMIS) || ($_SESSION['srid']==RREG))? true:false;


	if(isset($_POST['submit'])){
		$rows = $_POST['rows'];		
		$q = "";
		foreach($rows AS $row){
			$q .= "UPDATE {$dbg}.50_grades SET dg{$qtr} = '".$row['dg']."' WHERE id = '".$row['gid']."' LIMIT 1;";
		}
		$db->query($q);		
		// $url = "cav/dg/$course_id/$sy/$qtr?{$sortcond}";
		$url = "cav/editColumnDG/$course_id/$criteria_id/$sy/$qtr";		
		flashRedirect($url,"Saved.");
		exit;
	}
		

	/* process */	
	$sort=isset($_GET['sort'])? $_GET['sort'].',':NULL;
	// $sort.="c.is_male DESC,c.name ASC";
	$sort=$_SESSION['settings']['classlist_order'];
		
	$data['traits']  = getTraitsByColumn($db,$dbg,$qtr,$crid,$course_id,$criteria_id,$sort);
	$data['numrows'] = count($data['traits']); 

	$q = " SELECT c.* FROM {$dbo}.`05_criteria` AS c WHERE c.`id` = '$criteria_id'; ";
	$sth = $this->model->db->querysoc($q);
	$data['criteria']  = $sth->fetch();	
	
	$this->view->render($data,'cav/editColumnDG');


}	/* fxn */


public function go($params=NULL){
if(empty($params)){ flashRedirect('students/links','Scid parameter required.'); }
$scid=$params[0];
$sy=$_SESSION['sy'];$qtr=$_SESSION['qtr'];
$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;

$q="SELECT summ.crid,crs.id AS crs,summ.scid 
	FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		LEFT JOIN (
			SELECT id,crid FROM {$dbg}.05_courses WHERE crstype_id = '".CTYPETRAIT."' AND is_active = '1'
		) AS crs ON crs.crid = cr.id
	WHERE summ.scid='$scid';
";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$crs=$row['crs'];
$url="cav/student/$crs/$scid/$sy/$qtr";
exit;
redirect($url);

}	/* fxn */


public function edit($params){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/sessionize_classroom.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/courses.php");
	require_once(SITE."functions/reports.php");
	

	$course_id=$params[0];
	$scid=$params[1];

	$data['ssy']=$ssy=DBYR;	
	$data['sy']=$sy=isset($params[2])? $params[2]:DBYR;
	$data['qtr']=$qtr=isset($params[3])? $params[3]:$_SESSION['qtr'];	
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	/* controller - teachers or else */
	$data['home']=$home=$_SESSION['home'];
	
	$course = getCourseDetails($db,$course_id,$dbg);	
	$data['course'] 	= $course;	

	$is_trait = ($course['is_trait'])? 1 : 0;
	$data['is_trait']	= $is_trait;	
	$data['crid'] = $crid = $data['course']['crid'];	
	
	
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  $this->flashRedirect('teachers'); } }
	
	$crsClass	= classifyCourse($data['course']);
	$ratings = $data['ratings'] = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);		
	
	if(isset($_SESSION['crid'])){
		if($_SESSION['crid']!=$crid) sessionizeCridStudents($db,$dbg,$crid);	
	} else {
		$_SESSION['crid'] = $crid;
		sessionizeCridStudents($db,$dbg,$crid);	
	}
		
	$data['boys']  = $_SESSION['boys'];
	$data['girls'] = $_SESSION['girls'];
		
	$data['flrgr'] = $flrgr = getConductFloorGrade($course,$_SESSION['settings']);	
	$dgonly=isset($_GET['dgonly'])? 'dgonly':false;
	
if(isset($_POST['save'])){		
	// pr($_POST);exit;
	if(!$dgonly){
		$scid 		= $_POST['scid'];
		$grs=buildArray($_POST['grades'],'grade');		
		$sumgrade=(array_sum($grs)/count($grs));
		$is_qualified	= ($sumgrade < $flrgr)? '0':'1';				
		$rows 		= $_POST['grades'];
		/* 1-grades - ok */
		$q = "";
		foreach($rows AS $row){ 
			$grade = ($row['grade'] > 100)? '0' : $row['grade'];
			if($_SESSION['settings']['lrdomino']=='1'){
				if($grade < $flrgr) { $is_qualified = '0'; }			
			}
			$dg = rating($grade,$ratings);		
			
			$q .= " UPDATE {$dbg}.50_grades SET `q$qtr` = '".$grade."', 
				`dg$qtr` = '".$dg."'				
			WHERE `id` = '".$row['gid']."' LIMIT 1; "; 
		}
		
		// pr($q); exit;
		$this->model->db->query($q);	

		/* 2-grades fg	-  */
		$expr = 'q1';
		for($i=2;$i<=$qtr;$i++){ $expr .= "+q$i"; }		
		$q = "";
		foreach($rows AS $row){
		
			$p = " SELECT `id`,SUM($expr)/$qtr AS `fg` FROM {$dbg}.50_grades where id = '".$row['gid']."' ";
			$sth 	= $this->model->db->querysoc($p);
			$grade  = $sth->fetch();
			$fg  	= $grade['fg'];
			$dgf 	= rating($fg,$ratings);	
			// pr($p);
			
			$q .= " UPDATE {$dbg}.50_grades SET `q5` = '$fg',`dg5` = '$dgf' 
					WHERE `id` = '".$row['gid']."' LIMIT 1;   ";
								
		}	/* foreach */
		// pr($q);
		$this->model->db->query($q);	
		
	if($crsClass['type_id'] == 2){
		/* 3-summaries */		
		$dgsumgrade = rating($sumgrade,$ratings);	
		$q = " UPDATE {$dbg}.05_summaries SET `conduct_q$qtr` = '$sumgrade',
			`conduct_dg$qtr` = '$dgsumgrade',`is_qualified_q$qtr` = '$is_qualified' WHERE `scid` = '$scid' LIMIT 1; ";
		$this->model->db->query($q);	
		
		/* 4-summaries fg */
		$expr = 'conduct_q1';
		for($i=2;$i<=$qtr;$i++){ $expr .= "+conduct_q$i"; }		
		$p = " SELECT `id`,SUM($expr)/$qtr AS `fg` FROM {$dbg}.05_summaries 
			WHERE `scid` = '".$scid."' LIMIT 1; ";
		$sth 	= $this->model->db->querysoc($p);
		$sum  = $sth->fetch();
		$fg  	= $sum['fg'];
		$dgf 	= rating($fg,$ratings);	
		
		$q = " UPDATE {$dbg}.05_summaries SET `conduct_q5` = '$fg',`conduct_dg5` = '$dgf' 
			WHERE `scid` = '".$scid."' LIMIT 1; ";								
		$this->model->db->query($q);	
	
	}	/* for traits only affecting summaries conduct,not for psmapeh */

			
	} else {	/* dgonly below */
		$scid=$_POST['scid'];
		$rows = $_POST['grades'];		
		$q = "";
		foreach($rows AS $row){ 
			$grade = $row['grade'];			
			$dg = $row['dg'];			
			$q .= " UPDATE {$dbg}.50_grades SET `q$qtr` = '".$grade."', 
				`dg$qtr` = '$dg'				
			WHERE `id` = '".$row['gid']."' LIMIT 1; "; 
		}
		$q .="UPDATE {$dbg}.05_summaries SET `conduct_q{$qtr}`='".$_POST['post']['final']."',
			`conduct_dg{$qtr}`='".$_POST['post']['dgfinal']."' WHERE `scid`='$scid' LIMIT 1; "; 
				
		// pr($q); exit;
		$this->model->db->query($q);	
		
		
	}	/* dgonly save */
		
		/* 5-redirect */
		$url = "cav/edit/$course_id/$scid/$sy/$qtr?$dgonly";
		redirect($url);
		
		exit;
		
		
		
}	/* post-edit */ 

	
/* ------------- data -------------------------------------------- */
	$data['course_id']		= $course_id;
	$data['scid']			= $scid;
	$data['sy']	= $sy;
	$data['qtr']		= $qtr;
	$data['student'] 	= student($db,$dbg,$sy,$scid);		
	$data['is_locked']  = $data['course']['is_finalized_q'.$qtr];
if($dgonly){
	$data['grades'] = editStudentTraitsDG($db,$dbg,$course_id,$scid,$sy,$qtr);
} else {
	$data['grades'] = editStudentTraits($db,$dbg,$course_id,$scid,$sy,$qtr);
}
	$data['criteria'] = getTraitsCriteria($db,$course_id,$dbg);
	
	$data['num_grades']			= count($data['grades']);

	
	$this->view->render($data,'cav/edit');

}	/* fxn */


public function summary($params=NULL){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/tpgfxn.php");
	
	$data['course_id']= $course_id=$params[0];
	$data['ssy']=$ssy= $_SESSION['sy'];			
	$data['sy']=$sy= isset($params[1])? $params[1]:$ssy;
	$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['qtr']=$qtr=($qtr>5)?5:$qtr;
	$data['dgonly']= isset($_GET['dgonly'])? true:false;
	$data['sortcond']= $sortcond = isset($_GET['sort'])? '&sort='.$_GET['sort']:NULL;
	$dgcond=isset($_GET['dgonly'])? '&dgonly':NULL;
		
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$data['home']	=	$home = $_SESSION['home']; 				
	/* --------------------- PROCESS1 --------------------- */
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$crid	= $course['crid'];
	$data['crid'] = $crid;
	$_SESSION['course'] = $data['course'];		
	$data['ctype']=$ctype=isset($_GET['ctype'])? $_GET['ctype']:$course['crstype_id'];
	$data['dept_id']=$dept=isset($_GET['dept'])? $_GET['dept']:$course['department_id'];
	

	/* --- PROCESS2 --- */	
	$crsClass	= classifyCourse($course);
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
	$data['sort'] = $sort = isset($_GET['sort'])? $_GET['sort'] : NULL;	
	$data['ratings'] = getRatings($db,$ctype,$dept_id);		
	$_SESSION['url'] = "cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id";		
	$data['is_locked'] = $course['is_finalized_q'.$qtr];
	$data['criteria'] = getTraitsCriteria($db,$course_id,$dbg);
	$data['num_criteria'] = count($data['criteria']);
	
	$order= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$order.="c.grp,c.is_male DESC,c.name";
	
$fields=" sum.conduct_q1 AS cq1,sum.conduct_q2 AS cq2,sum.conduct_q3 AS cq3,sum.conduct_q4 AS cq4,sum.conduct_q5 AS cfg,";	
$data['students']=$students=classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);		
$data['num_students']=$num_students=count($data['students']);

for($i=0;$i<$num_students;$i++){ $data['scores'][$i]= getStudentTraitsByCourse($db,$dbg,$sy,$students[$i]['scid'],$course_id); } 

	$data['ix'] = tpgfxn($db,$dbg,$course['level_id'],$course['crid'],$course['course_id'],$sy,$qtr);			
	$this->view->render($data,'cav/summary');				
	



}	/* fxn */



public function traitsByLevel($params=NULL){	
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE.'functions/cav.php');
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;	
	$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];	
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	
	$q="SELECT id,name,department_id FROM {$dbo}.`05_levels` WHERE id='$lvl' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['level']=$row=$sth->fetch();
	$dept_id=$row['department_id'];
	$data['dept_id']=&$dept_id;
	$ctype_id=2;
	$data['ctype_id']=&$ctype_id;
	$ratings = getRatings($db,$ctype_id,$dept_id);		
	$data['ratings']=&$ratings;
	
	$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id");
	
	/* 1 */
	$rows=getCavStudentsByLevel($db,$lvl,$qtr);
	$data['rows']=&$rows;
	$data['count']=count($rows);

	/* 2 */
	$data['criterias']=getCavCriteriaByLevel($db,$lvl);
	$data['num_criteria']=count($data['criterias']);	
	
	if(isset($_POST['submit'])){		
		$posts=isset($_POST['posts'])? $_POST['posts']:array();
		$q="";
		foreach($posts AS $post){
			$ave=$post['ave'];
			$dg=$post['dg'];
			$sumid=$post['sumid'];
			$q.="UPDATE {$dbg}.05_summaries SET `conduct_q{$qtr}`='$ave',`conduct_dg{$qtr}`='$dg' WHERE `id`='$sumid' LIMIT 1; ";
		}
		$db->query($q);
		$url="cav/traitsByLevel/$lvl?qtr=$qtr";
		flashRedirect($url,"Traits averages updated.");
		exit;
		
	}	/* post */
		
	/* 3 */
	$cavs=array();
	foreach($rows AS $row){
		$scid=$row['scid'];
		$cavs[]=getCavByStudent($db,$scid,$qtr);
	}
	$data['cavs']=&$cavs;
	
	
	$this->view->render($data,'cav/traitsByLevel');				
	
}	/* fxn */


public function matrix($params){
	require_once(SITE.'functions/traits.php');
	require_once(SITE.'functions/classyear.php');
	require_once(SITE.'functions/details.php');
	$data['crid']= $crid=$params[0];
	$data['sy']=$sy= isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];	
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$row=getTraitsCrsByCrid($db,$dbg,$crid);
	$data['crs']=$crs=$row['crs'];
	$course=$data['course']=getCourseDetails($db,$crs,$dbg);	
	$data['value']=$value=isset($_GET['value'])? $_GET['value']:0;		/* 0-num,1-dg,2:alphanumeric */	

	/* --- PROCESS2 --- */	
	$data['is_locked']=$course['is_finalized_q'.$qtr];	
	$data['criteria']=getTraitsCriteria($db,$crs,$dbg);
	
	$data['num_criteria'] = count($data['criteria']);	
	$order=$_SESSION['settings']['classlist_order'];	
	$data['critypes']=$critypes=getCritypes($db,$dbg,$crs);
	
	$fields=" sum.conduct_q1 AS cq1,sum.conduct_q2 AS cq2,sum.conduct_q3 AS cq3,sum.conduct_q4 AS cq4,sum.conduct_q5 AS cfg,";	
	$data['rows']=$rows=classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);		
	$data['count']=$count=count($data['rows']);	
	for($i=0;$i<$count;$i++){ $data['cavs'][$i]=getStudentTraitsByCourse($db,$dbg,$sy,$rows[$i]['scid'],$crs); } 
	
	$one="matrixCav";$two="cav/matrixCav";
	$vfile=cview($one,$two,$sch=VCFOLDER);	
	vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */



public function matrixByCritype($params){
	require_once(SITE.'functions/traits.php');
	require_once(SITE.'functions/classyear.php');
	require_once(SITE.'functions/details.php');
	$data['crid']= $crid=$params[0];
	$data['critype_id']= $critype_id=$params[1];
	$data['sy']=$sy= isset($params[2])? $params[2]:DBYR;
	$data['qtr']=$qtr=isset($params[3])? $params[3]:$_SESSION['qtr'];	
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$row=getTraitsCrsByCrid($db,$dbg,$crid);
	$data['crs']=$crs=$row['crs'];
	$course=$data['course']=getCourseDetails($db,$crs,$dbg);	
	$data['value']=$value=isset($_GET['value'])? $_GET['value']:0;		/* 0-num,1-dg,2:alphanumeric */	

	/* --- PROCESS2 --- */	
	$data['is_locked']=$course['is_finalized_q'.$qtr];	
	$data['criteria']=getTraitsCriteriaByCritype($db,$crs,$critype_id,$dbg);
	
	$data['num_criteria'] = count($data['criteria']);	
	$order=$_SESSION['settings']['classlist_order'];	
	$data['critypes']=$critypes=getCritype($db,$dbg,$crs,$critype_id);
	
	$fields=" sum.conduct_q1 AS cq1,sum.conduct_q2 AS cq2,sum.conduct_q3 AS cq3,sum.conduct_q4 AS cq4,sum.conduct_q5 AS cfg,";	
	$data['rows']=$rows=classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);		
	$data['count']=$count=count($data['rows']);	
	for($i=0;$i<$count;$i++){ $data['cavs'][$i]=getStudentTraitsByCourseByCritype($db,$dbg,$sy,$rows[$i]['scid'],$crs,$critype_id); } 
	$one="matrixCav";$two="cav/matrixCav";	
	$vfile=cview($one,$two,$sch=VCFOLDER);	
	vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */




public function mcr($params){
	require_once(SITE.'functions/traits.php');
	require_once(SITE.'functions/classyear.php');
	require_once(SITE.'functions/details.php');
	
	require_once(SITE.'functions/ratings.php');
	require_once(SITE."functions/classifications.php");	/*  */
	require_once(SITE."functions/equivs.php");	/* ratingForDg */
	$data['crid']= $crid=$params[0];
	$data['sy']=$sy= isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];	
	$db =& $this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;	
	$row=getTraitsCrsByCrid($db,$dbg,$crid);
	$data['crs']=$crs=$row['crs'];
	$course=$data['course']=getCourseDetails($db,$crs,$dbg);	
	$data['value']=$value=isset($_GET['value'])? $_GET['value']:0;		/* 0-num,1-dg,2:alphanumeric */	


	$crsClass	= classifyCourse($course);
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];	
	$data['ratings'] = getRatingsFromDescriptions($db,$ctype,$dept_id);		
	


	if(isset($_POST['submit'])){
		$posts=isset($_POST['posts'])? $_POST['posts']:null;
		$aveqtr=$_POST['aveqtr'];
		$q="";	
		if(!empty($posts)){
			foreach($posts AS $post){
				$q.="UPDATE {$dbg}.50_grades SET `q$aveqtr`={$post['qave']}, `dg$aveqtr`='{$post['dgave']}' 
					WHERE id={$post['gid']} LIMIT 1;";
			} 			
		}
		$sth=$db->query($q);
		$url=$_SERVER['HTTP_REFERER'];
		redirectUrl($url);		
		exit;
	}	/* post */

	/* --- PROCESS2 --- */	
	$data['is_locked']=$course['is_finalized_q'.$qtr];	
	$data['criteria']=getTraitsCriteria($db,$crs,$dbg);
	
	$data['num_criteria'] = count($data['criteria']);	
	$order=$_SESSION['settings']['classlist_order'];	
	$data['critypes']=$critypes=getCritypes($db,$dbg,$crs);
	
	$fields=" sum.conduct_q1 AS cq1,sum.conduct_q2 AS cq2,sum.conduct_q3 AS cq3,sum.conduct_q4 AS cq4,sum.conduct_q5 AS cfg,";	
	$data['rows']=$rows=classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields);		
	$data['count']=$count=count($data['rows']);	
	for($i=0;$i<$count;$i++){ $data['cavs'][$i]=getStudentTraitsByCourse($db,$dbg,$sy,$rows[$i]['scid'],$crs); } 
	
	// $one="matrixCav";$two="cav/matrixCav";
	$one="mcrCav";$two="cav/mcrCav";
	$vfile=cview($one,$two,$sch=VCFOLDER);
	vfile($vfile);
	
	
	$this->view->render($data,$vfile);
	
}	/* fxn */





}	/* CavController */
