<?php

Class ScoresController extends Controller{	

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
	echo "scores index";
	$this->view->render($data,'tests/index');

}	/* fxn */


/* editScores3T */
public function edit($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");	
	require_once(SITE."functions/scores.php");	
	$db=&$this->model->db;	

	$course_id=$params[0];	
	$activity_id=$params[1];	
	$sy=isset($params[2])? $params[2]:DBYR;
	$qtr=isset($params[3])? $params[3] : $_SESSION['qtr'];		
	$tier=$_SESSION['settings']['tier_adapter'];
	$dbg=VCPREFIX.$sy.US.DBG;
	
if($_SESSION['srid']==RTEAC){
if(!in_array($course_id,$_SESSION['teacher']['course_ids'])){ flashRedirect('teachers'); } }	
	
	$course = getCourseDetails($db,$course_id,$dbg);
	$_SESSION['course'] = $course; 	
	$data['crid']	= $crid	=	$course['crid'];
	
$is_locked = $course['is_finalized_q'.$qtr];
if($is_locked) { $url = 'teachers/scores/'.$course_id.DS.$sy.DS.$qtr; flashRedirect($url,'Already locked!'); }

	if(isset($_POST['submit'])){
		$activity = $_POST['data']['Activity'];
		$q  = " UPDATE {$dbg}.50_activities SET ";
		$q .= " `name` = '".$activity['name']."'"; 
		$q .= ",`component_id` = '".$activity['component_id']."'"; 
		if(isset($_POST['data']['Activity']['subcomponent_id'])){
			$q .= ",`subcomponent_id` = '".$activity['subcomponent_id']."'"; 		
		}	
		$q .= ",`max_score` = '".$activity['max_score']."'"; 
		$q .= ",`date` = '".$activity['date']."'"; 
		$q .= " WHERE `id` = '".$activity['activity_id']."' LIMIT 1; ";
		$db->query($q);			
		
		$q = "";
		$max_score	= $activity['max_score'];
		$rows = $_POST['data']['Score'];		
		foreach($rows as $row){			
			$id = $row['id'];	
			$score = ($row['score'] <= $max_score)? $row['score'] : $max_score;						
			$is_valid = 1; if(isset($row['is_valid']) && (!$row['is_valid'])) { $is_valid = 0; $score = 0; }  													
			$q .= " UPDATE {$dbg}.50_scores SET `score` = '$score',`is_valid` = '$is_valid'  WHERE `id` = '$id' LIMIT 1; ";						
		} 		
		
		$db->query($q);
		$url = scoresRedirect($course,$qtr);		
		redirect($url);
		
	} 	/* post-submit */

	$kpup = $course['is_kpup'];
		
	/* check if valid course id belonging to the loggedin teacher */
	// $data = $this->model->editScores($dbg,$course_id,$activity_id,$sy,$crid,$tier,$kpup,$dbg);	
	
	$data = editScores($db,$dbg,$course_id,$activity_id,$sy,$crid,$tier,$kpup,$dbg);	
	// pr($data);exit;
	$data['kpup'] = $kpup;
	$data['course'] 	 = $course;	
	$data['qtr'] 	 = $qtr;
	$data['activity_id'] = $activity_id;
	
	$data['selects']	 = selectsCourseCriteria($db,$course_id);
	$data['tier']		 = $tier;	
	$data = isset($data)? $data : null;		
	$data['sy']=$sy;$data['qtr']=$qtr;$data['dbg']=$dbg;
	
	$this->view->render($data,'scores/edit');			
		
} /* fxn */


/* IMPT: 3T */
public function add($params){ 
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/scores.php");
	require_once(SITE."functions/reports.php");		
	$data['ssy']=$ssy=DBYR;	
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;	
	$data['course_id']=$course_id=$params[0];		
	$data['qtr']=$qtr=$params[1];		
	$cri_id=isset($params[2])? $params[2]:null;	
	$subcri_id=isset($params[3])? $params[3]:null;		
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	$data['course'] = $course = getCourseDetails($db,$course_id,$dbg);				
	$is_locked = $course['is_finalized_q'.$qtr];
	if($is_locked) { 
		$url=scoresRedirect($course,$qtr);	
		Session::set('message','Class record editing period is closed.');
		redirect($url); 
	}
		
	if(isset($_POST['submit'])){		
		// pr($_POST);exit;
		
		$max_score = $_POST['data']['Activity']['max_score'];				
		$act = $_POST['data']['Activity'];
		$q  = " INSERT INTO {$dbg}.50_activities (`date`,`component_id`,`name`,`max_score`,`course_id`,`quarter`";
			if(isset($act['subcomponent_id'])) { $q .= ",`subcomponent_id` "; }						
		$q .= " ) VALUES ";
		$q .= " ('".$act['date']."','".$act['component_id']."','".$act['name']."','".$act['max_score']."','".$course_id."','".$qtr."'";
			if(isset($act['subcomponent_id'])) { $q .= ",'".$act['subcomponent_id']."' "; }
		$q .= " );";		
		$db->query($q);
		
		$activity_id = $db->lastInsertId();											
		$rows = $_POST['data']['Score'];
		
		$q  = " INSERT INTO {$dbg}.50_scores ( `scid`,`course_id`,`activity_id`,`quarter`,`is_valid`,`score`) VALUES ";
		foreach($rows as $row){			
			$score = ($row['score'] <= $max_score)? $row['score'] : 0;	
			$q .= " ('".$row['scid']."','".$course_id."','".$activity_id."','".$qtr."' ";
			// default is_valid = 1,if invalid,then set score to zero				
			$is_valid = 1; if(isset($row['is_valid']) && (!$row['is_valid'])) { $is_valid = 0; $score = 0; }
			$q .= ",'".$is_valid."','".$score."'),";
		} 
		$q = rtrim($q,",");
		$q .= ";";						
		$db->query($q);						
		$url = scoresRedirect($course,$qtr);
		redirect($url);
		
	} 	/* post-submit */

	$crid = $course['crid'];	
	$order="c.`is_male` DESC,c.`name`";
	$order=(isset($_GET['sort']))? $_GET['sort']:$order;	
	$limit=isset($_GET['limit'])? $_GET['limit']:NULL;
	$data['students'] 	= $students	= classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields=NULL,$filter=NULL,$limit);	
	
	$data['course_id'] = $course_id;
	$data['qtr'] 	    = $qtr;
	$data['sy']	= $_SESSION['sy'];
	$data['criteria_id']    = $cri_id;
	$data['subcriteria_id'] = $subcri_id;
	$data['selects'] 		= selectsCourseCriteria($db,$course_id);						
					
	$data = isset($data)? $data : null;		
	$data['tier']	= $tier	= $_SESSION['settings']['tier_adapter'];
	$data['kpup']	= $kpup	= $course['is_kpup'];
	
	if($kpup){
		$this->view->render($data,'scores/add3T',$this->layout);			
	} else {
		$ucfsch=ucfirst(VCFOLDER);$one="scoresAdd{$ucfsch}";$two="scores/add2T";
		$vfile=cview($one,$two,$sch=VCFOLDER);		
		vfile($vfile);
		$this->view->render($data,$vfile,$this->layout);				
	}
	
		
} 	/* fxn */


public function delete($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/scores.php");
	$db =& $this->model->db;
	$course_id = $params[0];	
	$activity_id = $params[1];	
	$sy = isset($params[2])? $params[2] : DBYR;
	$qtr = isset($params[3])? $params[3] : $_SESSION['qtr'];	
	$dbg = VCPREFIX.$sy.US.DBG;
if($_SESSION['srid']==RTEAC){ if(!in_array($course_id,$_SESSION['teacher']['course_ids'])){ flashRedirect('teachers'); } }	
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	$is_locked = $course['is_finalized_q'.$qtr];
	if($is_locked) { $url = $this->scoresRedirect($course,$qtr); $this->flashRedirect($url,'Closed'); }	
	
	if($course_id && $activity_id){
		deleteScores($db,$dbg,$course_id,$activity_id);			
	} 
	if(!isset($_GET['blank'])){
		$url = 'teachers/scores/'.$course_id.DS.$sy.DS.$qtr;
		redirect($url);   			
	}
	echo "Blank no redirect.";
		
} 	/* fxn */


public function editStudent($params){
$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/scores.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize_classroom.php");
	$db	=&	$this->model->db;
	$course_id = $params[0];$scid = $params[1];
	$ssy = $_SESSION['sy'];$sy	= $params[2];$qtr = $params[3];	
	$dbg = VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['save'])){
		$rows = $_POST['scores'];
		$q = "";
		foreach($rows AS $row){ 
			$score = ($row['score'] > $row['max_score'])? $row['max_score'] : $row['score'];
			$is_valid = 1; if(isset($row['is_valid']) && (!$row['is_valid'])) { $is_valid = 0; $score = 0; } 	
			$q .= " UPDATE {$dbg}.50_scores SET `score` = '".$score."',`is_valid` = '$is_valid' WHERE `id` = '".$row['scrid']."' LIMIT 1; ";
		}	/* foreach */
		$this->model->db->query($q);		
		$url = "scores/editStudent/$course_id/$scid/$sy/$qtr";
		redirect($url);
		exit;		
	}	/* post */
	
	if(isset($_POST['add'])){
		$rows = $_POST['scores'];
		$q = "INSERT INTO {$dbg}.50_scores (`scid`,`course_id`,`quarter`,`activity_id`,`score`,`is_valid`) VALUES";
		foreach($rows AS $row){ $q .= "  ('".$scid."','".$course_id."','".$qtr."','".$row['aid']."','".$row['score']."',1),"; }
		$q = rtrim($q,",");
		$q .= ";";
		$db->query($q);				
		$url = "teachers/scores/$course_id/$sy/$qtr";
		redirect($url);
		exit;		
	}	/* post-add */
	
	
	/* ------------- data -------------------------------------------- */
	$data['course_id']	= $course_id;
	$data['scid'] = $scid;
	$data['sy']	= $sy;$data['qtr'] = $qtr;
	$data['student'] 	= student($db,$dbg,$sy,$scid);
	$data['course'] 	= getCourseDetails($db,$course_id,$dbg);
	$data['is_locked'] 	= $data['course']['is_finalized_q'.$qtr];
	$data['activities'] = getActivities($db,$dbg,$course_id,$qtr);	
	$data['num_activities']	= count($data['activities']);
	$data['scores']		= editStudentScores($db,$dbg,$course_id,$scid,$qtr);

	$data['num_scores']	= count($data['scores']);
	$data['saids']		= buildArray($data['scores'],'activity_id'); 
	$data['crid'] 		= $crid = $data['course']['crid'];			
	if(isset($_SESSION['crid'])){
		if($_SESSION['crid']!=$crid) sessionizeCridStudents($db,$dbg,$crid);		/* GSModel */
	} else {
		$_SESSION['crid'] = $crid;
		sessionizeCridStudents($db,$dbg,$crid);	
	}

// if(!isset($_GET['admin'])){
	$data['boys']  = isset($_SESSION['boys'])? $_SESSION['boys']:null;
	$data['girls']  = isset($_SESSION['girls'])? $_SESSION['girls']:null;
	// $data['girls'] = $_SESSION['girls'];	
// }
	
	$this->view->render($data,'scores/editStudentScores');

}	/* fxn */



public function sync($params){
$dbo=PDBO;
require_once(SITE."functions/syncScoresFxn.php");
$crs=$params[0];$sy=isset($params[1])? $params[1]:DBYR;$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
$a=getCourseActivities($db,$dbg,$crs,$qtr);
$ar = buildArray($a,'id');	
$b=getScoresActivities($db,$dbg,$crs,$qtr);
$br = buildArray($b,'id');	
$ix = array_diff($ar,$br);		
echo "ix";pr($ix);echo "<hr />";
$q="";foreach($ix AS $id){ $q.="DELETE FROM {$dbg}.50_activities WHERE id='$id' LIMIT 1;"; } pr($q);$db->query($q);
$jx = array_diff($br,$ar);		
echo "jx";pr($jx);
$q="";foreach($jx AS $id){ $q.="DELETE FROM {$dbg}.50_scores WHERE activity_id='$id' LIMIT 1;"; } pr($q);$db->query($q);
echo "Synced scores done.";


}	/* fxn */


public function filter($params=NULL){
$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$data['qtr']=$qtr=isset($params[1])? $params[1]:$_SESSION['qtr'];
	$this->view->render($data,"scores/filterScores");	
	
}	/* fxn */



}	/* ScoresController */
