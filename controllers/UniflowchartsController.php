<?php

Class UniflowchartsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$data="Uniflowcharts";	
	$this->view->render($data,'uniflowcharts/indexUniflowcharts');
}	/* fxn */



public function major($params=NULL){	
$dbo=PDBO;
	if(!isset($params[0])){ pr("Major ID parameter NOT set."); exit; }
	require_once(SITE.'functions/uniflowchartsFxn.php');
	$data['major_id']=$major_id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;	

	
	/* 2 */
	$data['major']=$major=fetchRow($db,"{$dbg}.`05_majors`",$major_id);	 
	$data['majors']=fetchRows($db,"{$dbg}.`05_majors`","*");
	$q="SELECT cr.`id` AS `crid`,sxn.code AS sxncode FROM {$dbg}.01_classrooms AS cr 
		INNER JOIN {$dbg}.01_sections AS sxn ON cr.section_id=sxn.id WHERE cr.`major_id`='$major_id'; ";
	$sth=$db->querysoc($q);
	$data['crids_array']=$sth->fetchAll();
	$data['crids']=buildArray($data['crids_array'],"crid");
	
	// pr($data);
	$data['years']=$years=$major['years'];
	for($i=1;$i<=$years;$i++){
		for($j=1;$j<3;$j++){
			$rows[$i][$j]=getFlowchartCourses($db,$dbg,$major_id,$i,$j);			
		}		
	}
	$data['rows']=$rows;
	
	
	$this->view->render($data,"uniflowcharts/majorUniflowcharts");
	
}	/* fxn */





public function sync($params=NULL){		/* syncCourses */
$dbo=PDBO;
	require_once(SITE.'functions/unicoursesFxn.php');
	$data['major_id']=$major_id=isset($params[0])? $params[0]:1;
	if(!$major_id){ pr("Major ID NOT set."); exit; }
	/* 1 */
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="SELECT * FROM {$dbg}.01_flowcharts WHERE major_id='$major_id' ORDER BY level_id,semester,subject_id; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	
	/* 3 */
	$ca=getCridArray($db,$dbg,$major_id);
		
	/* 4b */
	$q="";
	foreach($ca AS $crid){
		foreach($rows AS $row){
			$level_id=$row['level_id'];$semester=$row['semester'];$subject_id=$row['subject_id'];$units=$row['units'];
			$q1="SELECT id FROM {$dbg}.01_courses WHERE `level_id`='$level_id' AND `subject_id`='$subject_id' AND `crid`='$crid' LIMIT 1;";
			$sth=$db->query($q1);
			$rec=$sth->fetch();
			if(!$rec){
				$q.="INSERT INTO {$dbg}.01_courses(`level_id`,`subject_id`,`crid`,`semester`,`units`)VALUES
					('$level_id','$subject_id','$crid','$semester','$units');";				
				
			}	/* !$rec */
				
			/* 4d */
		}		
	}	/* crid loop */
	pr($q);
	
	/* 5 */
	if(!empty($q)){
		$sth=$db->query($q);
		$msg=($sth)? "Sync Success":"Sync Failed";				
		upnameCourses($db,$dbg);		
		echo $msg;				
	}
	echo "Courses Synced from Flowchart.";
	/* 6 */
		
}	/* fxn */


public function loopSync(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;	
	$q="SELECT id,code FROM {$dbg}.`05_majors` ORDER BY id; ";
	$sth=$db->querysoc($q);
	$majors=$sth->fetchAll();
	foreach($majors AS $major){
		// pr($major);
		$id=$major['id'];
		$this->sync($id);
	}
	
	
}	/* fxn */



public function batch($params=NULL){
$dbo=PDBO;
	$data['major_id']=$major_id=isset($params[0])? $params[0]:0;
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$dbtable="{$dbg}.01_flowcharts";
		foreach($posts AS $post){
			if(!empty($post['major_id']) && !empty($post['subject_id'])){
				$db->createIfNotExists($dbtable,$post);							
			}
		}	/* foreach */	
		unset($_SESSION['uniflowcharts']);
		flashRedirect("uniflowcharts","Batch added.");		
		exit;				
	}	/* post */
	
	if(!isset($_SESSION['majors'])){ $_SESSION['majors'] = fetchRows($db,"{$dbg}.`05_majors`","*"); } 
	$data['majors']=$_SESSION['majors'];	
	if(!isset($_SESSION['unisubjects'])){ $_SESSION['unisubjects'] = fetchRows($db,"{$dbo}.`05_subjects`","id,code,name"); } 
	$data['unisubjects']=$_SESSION['unisubjects'];	
	$this->view->render($data,"uniflowcharts/batchUniflowcharts");
	
}	/* fxn */


public function reset(){
	unset($_SESSION['uniflowcharts']);
	flashRedirect("uniflowcharts","Flowcharts reset.");
	
}




}	/* BlankController */
