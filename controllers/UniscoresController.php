<?php

Class UniscoresController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css = array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Uniscores";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function crs($params=NULL){	/* uniscores */
	$data['crs']=$crs=isset($params[0])? $params[0]:false;
	if(!$crs){ pr("Course ID not set."); exit; }
	require_once(SITE.'functions/unidetailsFxn.php');
	require_once(SITE.'functions/unigradesFxn.php');
	require_once(SITE.'functions/uniscoresFxn.php');
	require_once(SITE.'functions/uniratingsFxn.php');	
	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['sem']=$sem=isset($params[2])? $params[2]:$_SESSION['settings']['semester'];
	$data['sch']=$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$dbg=VCPREFIX.$sy.US.DBG;
	
	if((isset($_POST['submit'])) || isset($_POST['finalize'])){
		// pr($_POST);exit;
		$posts=$_POST['grades'];$q="";
		foreach($posts AS $post){
			$gid=$post['gid'];$raw=$post['raw'];$grade=$post['grade'];$bonus=(int)$post['bonus'];$dg=$post['dg'];
			$q.="UPDATE {$dbg}.10_grades SET `raw`=$raw,`grade`='$grade',bonus='$bonus',dg='$dg' WHERE `id`=$gid LIMIT 1;";			
		}
		// pr($q);exit;
		$db->query($q);
		if(isset($_POST['finalize'])){ require_once(SITE.'functions/unilocksFxn.php');lockUnicourse($db,$dbg,$crs,$sem); }				
		flashRedirect("uniscores/crs/$crs","Saved.");
		exit;		
	}	/* post */	
	/* 1 */
	$data['course']=$course=getUnicourseDetails($db,$crs,$dbg);	
	$data['is_numeric']=$is_numeric=$course['is_numeric'];
	// $data['is_numeric']=$is_numeric=false;
	/* 2 */
	if(!$is_numeric){ $data['ratings']=getUniratings($db,$dbg); }	
	$data['equivs']=getUniequivs($db,$dbg); 
	// pr($data['equivs']);
	
	/* 3 */
	$order=(isset($_GET['order']))? $_GET['order']:$_SESSION['settings']['classlist_order'];	
	$d=getCourseUnigrades($db,$crs,$sem,$dbg,$order);
	$students=&$d['rows'];$data['students']=&$students;
	$num_students=&$d['count'];$data['num_students']=&$num_students;
	/* 4 activiteis and scores */	
	$data['activities']=getUniactivities($db,$dbg,$crs,$sem);	
	$data['num_activities']=count($data['activities']);
	foreach($students AS $student){ $scores[]=getUniscores($db,$dbg,$crs,$student['scid'],$sem); }		
	$data['scores']=&$scores;
	$data['algo']=(isset($_GET['algo']))? $_GET['algo']:$_SESSION['settings']['algo'];
	$data['subject_id']=$subject_id=$course['subject_id'];
	/* 5 */ 
	$d=getUnicourseComponents($db,$dbg,$subject_id,$crs,$sem);
	$data['crs_num_components']=&$d['crs_num_components'];
	$data['acty_num_components']=&$d['acty_num_components'];
	$data['is_locked']=($course['is_finalized']==1)? 1:0;	
	/* 6 */
	$cfile=SITE."views/customs/{$sch}/college/{$sch}Uniscores.php";		
	$one="/customs/{$sch}/college/{$sch}Uniscores";$two="uniscores/crsUniscores";
	$vfile=(is_readable($cfile))? $one:$two;
	if(isset($_GET['tpl'])){ $tpl=$_GET['tpl'];$vfile="uniscores/{$tpl}Uniscores"; } vfile($vfile);
	// pr($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */



public function add($params=NULL){
	if(!isset($params)){ pr("Crs NOT set."); exit; }
	require_once(SITE.'functions/uniclasslistsFxn.php');
	require_once(SITE.'functions/unidetailsFxn.php');
	require_once(SITE.'functions/uniscoresFxn.php');
	$data['crs']=$crs=$params[0];	
	$data['cri']=$cri=isset($params[1])? $params[1]:0;	
	$data['sy']=$sy=DBYR;	
	$data['sem']=$sem=$_SESSION['settings']['semester'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	/* 1 */
	if(isset($_POST['submit'])){
		$activity=$_POST['activity'];
		$activity['course_id']=$crs;$activity['semester']=$sem;
		$activity['id']=maxId($db,"{$dbg}.10_activities")+1;
		$db->add("{$dbg}.10_activities",$activity);
		$aid=$db->lastInsertId();

		$max_score=$activity['max_score'];						
		$scores=$_POST['scores'];
		$q=" INSERT INTO {$dbg}.10_scores(`scid`,`course_id`,`activity_id`,`semester`,`is_valid`,`score`) VALUES ";
		foreach($scores as $post){			
			$scid=$post['scid'];
			$score=($post['score']<=$max_score)? $post['score']:0;				
			$q.="($scid,$crs,$aid,$sem,";
			$is_valid=1; if(isset($post['is_valid']) && (!$post['is_valid'])) { $is_valid=0; $score = 0; }
			$q.="$is_valid,$score),";
		} 
		$q=rtrim($q,",");$q.=";";						
		$db->query($q);								
		flashRedirect("uniscores/crs/$crs","Scores added.");

		
	}	/* post */

	/* 2 */
	$d=getUnicourselist($db,$crs,$sem,$dbg);
	$data['rows']=$d['rows'];$data['count']=$d['count'];
	
	/* 3 */
	$data['course']=getUnicourseDetails($db,$crs,$dbg);
	$subject_id=$data['course']['subject_id'];
	
	$d=getUnicriteria($db,$dbg,$subject_id);
	$data['criteria']=$d['rows'];
	$data['num_criteria']=$d['count'];

	$this->view->render($data,"uniscores/addUniscores");
	
}	/* fxn */








}	/* BlankController */
