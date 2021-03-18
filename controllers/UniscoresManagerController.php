<?php

Class UniscoresManagerController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="UniscoresEditController";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function editScid($params=NULL){
	if(!isset($params[0]) && !isset($params[1])){ pr("Crs and Scid missing."); exit; }
	$data['crs']=$crs=$params[0];
	$data['scid']=$scid=$params[1];
	$data['sy']=$sy=DBYR;
	$data['sem']=$sem=$_SESSION['settings']['semester'];	
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
		
	$q=" SELECT sc.*,sc.id AS sid,a.*,a.id AS aid,a.name AS activity
		FROM {$dbg}.10_scores AS sc 
			LEFT JOIN {$dbg}.10_activities AS a ON sc.activity_id=a.id
		WHERE sc.scid='$scid' AND sc.course_id='$crs' AND sc.semester='$sem'; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	$q="SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE `id`='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['student']=$sth->fetch();
	
	
	$this->view->render($data,"uniscoresManager/editScidUniscoresManager");
	
}	/* fxn */


public function edit($params=NULL){
	if(!isset($params[0])){ pr("Activity ID missing."); exit; }
	require_once(SITE.'functions/uniclasslistsFxn.php');
	require_once(SITE.'functions/unidetailsFxn.php');
	require_once(SITE.'functions/uniscoresFxn.php');	
	$data['aid']=$aid=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	
	/* 0 */
	if(isset($_POST['submit'])){
		// pr($_POST);exit;
		$activity=$_POST['activity'];
		$db->update("{$dbg}.10_activities",$activity,"`id`=$aid");
		$crs=$_POST['crs'];
		$scores=$_POST['scores'];
		$q="";
		foreach($scores AS $post){
			$id=$post['id'];$is_valid=$post['is_valid'];$score=($is_valid)? (int)$post['score']:0;
			$q.="UPDATE {$dbg}.10_scores SET `score`=$score,`is_valid`=$is_valid WHERE `id`=$id LIMIT 1; ";				
		}
		// pr($q);exit;
		$db->query($q);
		flashRedirect("uniscoresManager/edit/$aid","Saved.");
		// flashRedirect("uniscores/crs/$crs",$msg);		
		exit;
	}	/* post */
	
	/* 1 */
	$q="SELECT a.*,a.id AS aid,cri.name AS criteria,comp.* 
		FROM {$dbg}.10_activities AS a 
		INNER JOIN {$dbg}.01_components AS comp ON a.component_id=comp.id
		INNER JOIN {$dbg}.01_criteria AS cri ON comp.criteria_id=cri.id
		WHERE a.id='$aid' LIMIT 1; ";
	$sth=$db->querysoc($q);	
	$data['activity']=$activity=$sth->fetch();
	$data['crs']=$crs=$activity['course_id'];
	
	/* 2 */
	$data['course']=getUnicourseDetails($db,$crs,$dbg);
	$subject_id=$data['course']['subject_id'];	
	$d=getUnicriteria($db,$dbg,$subject_id);
	$data['criteria']=$d['rows'];
	$data['num_criteria']=$d['count'];
	
	/* 3 */
	$order=$_SESSION['settings']['classlist_order'];
	$q="SELECT sc.*,sc.id AS score_id,sc.id AS sid,c.code AS student_code,c.name AS student
		FROM {$dbg}.10_scores AS sc 
		INNER JOIN {$dbo}.`00_contacts` AS c ON sc.scid=c.id		
		INNER JOIN {$dbg}.10_activities AS a ON sc.activity_id=a.id		
		WHERE a.id='$aid' ORDER BY $order; ";
	$sth=$db->querysoc($q);	
	$data['scores']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	$this->view->render($data,"uniscoresManager/editUniscoresManager");
	
}	/* fxn */




public function delete($params){
$dbo=PDBO;
	// require_once(SITE."functions/unidetails.php");
	require_once(SITE."functions/uniscoresManagerFxn.php");
	$db=&$this->baseModel->db;$dbg=PDBG;
	$activity_id = $params[0];	
	// if($_SESSION['srid']==RTEAC){ if(!in_array($course_id,$_SESSION['teacher']['course_ids'])){ flashRedirect('teachers'); } }	
	
	if($activity_id){
		deleteUniscores($db,$dbg,$activity_id);			
	} 
	echo "Blank no redirect.";
		
} 	/* fxn */




}	/* BlankController */
