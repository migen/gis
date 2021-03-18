<?php

Class ConsoController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "Conso index";

}	/* fxn */


public function traits($params){	
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/tpgfxn.php");
	$db =& $this->model->db;

	$data['course_id']= $course_id=$params[0];
	$data['ssy']=$ssy= $_SESSION['sy'];			
	$data['sy']=$sy= isset($params[1])? $params[1]:$ssy;
	$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$data['qtr']=$qtr=($qtr>5)?5:$qtr;
	$data['dgonly']= isset($_GET['dgonly'])? true:false;
	$data['sortcond']= $sortcond = isset($_GET['sort'])? '&sort='.$_GET['sort']:NULL;
	$dgcond=isset($_GET['dgonly'])? '&dgonly':NULL;
		
	$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;	
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
		// pr($q);exit;
		$db->query($q);		
		/* 2 */
		if($qtr>3){
			$q="UPDATE {$dbg}.50_grades AS a
					INNER JOIN {$dbg}.05_courses AS b ON a.course_id=b.id
					SET a.q5=((a.q1+a.q2+a.q3+a.q4)/4)
				WHERE b.crstype_id='".CTYPETRAIT."' AND b.crid='$crid';	 ";
			$db->query($q);		
		}	/* fave */

		
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
$q.=$_SESSION['q']."<br />getStudentTraitsByCourse: <br />";
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
	$this->view->render($data,'conso/traits');				
	
}	/* fxn */





}	/* BlankController */

