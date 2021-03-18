<?php

Class SubjectsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	$acl = array(array(5,0));
	$this->permit($acl);				
}	/* fxn */



public function indexDynamic($params=NULL){
	ob_start();
	echo "<h3>Subjects / Set | ";shovel('links_gset');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");
}	/* fxn */


public function index(){
	$this->view->render($data=NULL,"subjects/indexSubjects");
}	/* fxn */




public function view($params=NULL){
$dbo=PDBO;
$sub=isset($params[0])? $params[0]:1;
$q="SELECT * FROM {$dbo}.`05_subjects` WHERE id='$sub' LIMIT 1; ";
$sth=$this->model->db->querysoc($q);
$data['row']=$row=$sth->fetch();

$data=isset($data)? $data:NULL;
$this->view->render($data,'subjects/view');

}	/* fxn */




public function courses($params){
$dbo=PDBO;
	require_once(SITE."functions/contactsFxn.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/subjects.php");
	$db =& $this->model->db;

	$data['subject_id']	= $subject_id 		= $params[0];
	$data['home']	= $_SESSION['home'];
	$sy 	= isset($params[1])? $params[1]: DBYR;
	$dbg	= VCPREFIX.$sy.US.DBG;

	if(isset($_POST['save'])){
		$rows = $_POST['subcourses'];
		$q = ""; 
		foreach($rows AS $row){
			$q .= "UPDATE {$dbg}.05_courses SET 
				`tcid` = '".$row['tcid']."',
				`subject_id`	= '".$row['subject_id']."',
				`supsubject_id` = '".$row['supsubject_id']."',
				`code` 	   	= '".$row['code']."',
				`name` 	= '".$row['name']."',
				`label` 	= '".$row['label']."',
				`is_active` 	= '".$row['is_active']."',
				`with_scores` 	= '".$row['with_scores']."',
				`is_kpup` 	= '".$row['is_kpup']."',
				`course_weight` 	= '".$row['course_weight']."',
				`is_displayed` 	= '".$row['is_displayed']."',
				`in_genave` 	= '".$row['in_genave']."',
				`affects_ranking` 	= '".$row['affects_ranking']."',
				`is_aggregate` 	= '".$row['is_aggregate']."',
				`is_transmuted` 	= '".$row['is_transmuted']."',
				`indent` 	= '".$row['indent']."',
				`semester` 	= '".$row['semester']."',
				`is_num` 	= '".$row['is_num']."',
				`crstype_id` 	= '".$row['crstype_id']."',
				`position` 	= '".$row['position']."',
				`indent` = '".$row['indent']."'
				WHERE `id` = '".$row['course_id']."' LIMIT 1;
			";
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$_SESSION['message'] = "Changes saved!";
		// $url = 'syncs/syncCQ/mis';
		$url = "subjects/courses/$subject_id";
		flashRedirect($url,"Courses updated.");
		exit;		
	
	}	/* save */
		

if(isset($_POST['add'])){
		$subcode= $_POST['subcode'];$supsubject_id= $_POST['supsubject_id'];
		$course_weight=$_POST['course_weight'];
		$subject_id=$_POST['subject_id'];
		$label=$_POST['label'];
		$is_aggregate=$_POST['is_aggregate'];
		$year=$_SESSION['year']; 
		$rows=$_POST['subcourses'];
		$crstype_id=$_POST['crstype_id'];				
		$q = " INSERT INTO {$dbg}.05_courses (`code`,`name`,`label`,`subject_id`,`crid`,
				`tcid`,`supsubject_id`,`course_weight`,`crstype_id`,`year`,`position`) VALUES ";
		
		foreach($rows AS $row){			
			$crid	= $row['crid'];
			if($crid>0){
				$lvlcode	= $row['lvlcode'];
				$sxncode	= $row['sxncode'];
				$subject = $lvlcode.'-'.$sxncode.'-'.$subcode;
				
				$q .= "
					('$subject','$subject','$label','$subject_id','$crid',
					  '".$row['tcid']."','$supsubject_id','$course_weight',
					  '$crstype_id','$year','".$row['position']."' ";
				$q .= "),";
			
			}
			
					
		}	/* foreach */
		
		$q = rtrim($q,",");
		$q .= ";";
		$this->model->db->query($q);
		$url = "subjects/courses/".$subject_id;
		redirect($url);
		exit;
		
		
}	/* post-add */
	
	$data['subject']	= getSubjectDetails($db,$subject_id);
	$data['subcourses'] = subcourses($db,$subject_id);
	$data['num_subcourses'] = count($data['subcourses']);
	$data['teachers'] 	= getContacts($db,RTEAC);	
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");	
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
	$this->view->render($data,'subjects/courses');
}	/* fxn */




public function subcode($params=NULL){	
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	$subid = $_POST['subid'];
	$q = " SELECT name,code FROM {$dbo}.`05_subjects` WHERE `id` = '$subid' LIMIT 1;	";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	
}	/* fxn */


public function edit($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");	
	$subject_id=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]: DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	if(isset($_POST['submit'])){		
		$post=$_POST['subject'];
		unset($post['id']);
		$db->update("{$dbo}.05_subjects",$post,"id=$subject_id");		
		flashRedirect("subjects/view/$subject_id","Updated.");
		exit;
	}	/* post-submit edit */

	$q="SELECT * FROM {$dbo}.05_subjects WHERE id=$subject_id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$data['subject']=$data['row'];

	$field_array=array_keys($data['row']);
	$field_array=array_diff($field_array,array('id','code','crstype_id'));	
	$data['field_array']=$field_array;
	
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");			
	$this->view->render($data,'subjects/edit');

}	/* fxn */




public function delete($params){
$dbo=PDBO;
$id = $params[0];
$dbg = PDBG;
$q = "DELETE FROM {$dbo}.`05_subjects` WHERE `id` = '$id' LIMIT 1;  ";
$this->model->db->query($q);
$url = "subjects";
flashRedirect($url,'Subject deleted.');

}	/* fxn */



public function level($params=NULL){

require_once(SITE."functions/details.php");
$dbo=PDBO;
$db =& $this->model->db;
$dbg = PDBG;

$data['lvlid']	= $lvlid = isset($params[0])? $params[0]:4;
$data['level'] = getLevelDetails($db,$lvlid,$dbg);


if(isset($_POST['propagate'])){
	$crs = $_POST['crs'];

	$q = "";
	foreach($crs AS $c){
		$q .= "
			UPDATE {$dbg}.05_courses AS a
				INNER JOIN (
					SELECT id AS crid FROM {$dbg}.05_classrooms WHERE level_id = '$lvlid'		
				) AS b ON a.crid = b.crid
			SET 
				a.crstype_id = '".$c['crstype_id']."',
				a.supsubject_id 	= '".$c['supsubject_id']."',
				a.label 	= '".$c['label']."',
				a.position 	= '".$c['position']."',
				a.course_weight = '".$c['course_weight']."',
				a.indent 	= '".$c['indent']."',
				a.semester 	= '".$c['semester']."',
				a.is_kpup 	= '".$c['is_kpup']."',
				a.with_scores 	= '".$c['with_scores']."',
				a.in_genave 	= '".$c['in_genave']."',
				a.affects_ranking 	= '".$c['affects_ranking']."',
				a.with_scores 	= '".$c['with_scores']."'
			WHERE a.subject_id 	= '".$c['subject_id']."'
		;";

	}
	// pr($q);exit;
	$db->query($q);
	$_SESSION['message'] = "Changes made!";
	$url = "mis/lvlsub/$lvlid";
	redirect($url);
	exit;


}	/* post */


$q = "
	SELECT
		sub.id AS subject_id,sub.name AS subject,
		cr.name AS classroom,
		crs.*
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id	
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id	
	WHERE 
			cr.level_id = '$lvlid'
	GROUP BY sub.id
	ORDER BY sub.position
;";
// pr($q);
$sth = $db->querysoc($q);
$data['sub'] = $sth->fetchAll();
$data['count'] = count($data['sub']);


$data['levels']   = $this->model->fetchRows("{$dbo}.`05_levels`",'id,code,name','id');

$this->view->render($data,'subjects/level');


}	/* fxn */



public function byLevels(){
$dbo=PDBO;$dbg=PDBG;
$db=$this->baseModel->db;

$q = " SELECT sub.*,sub.id AS subject_id FROM {$dbo}.`05_subjects` AS sub;";
$sth = $db->querysoc($q);
$data['subjects'] = $subjects = $sth->fetchAll();
$data['brid']=$brid=isset($_GET['all'])? false:$_SESSION['brid'];
$cond_brid=($brid)? " AND cr.branch_id=$brid ":NULL; 

$levels=array();
foreach($subjects AS $row){
	$q=" SELECT crs.label,l.id AS level_id,l.name AS level
		FROM {$dbg}.05_courses AS crs
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id	
		WHERE crs.subject_id = '".$row['subject_id']."'
			AND crs.is_active = 1 $cond_brid
		GROUP BY l.id ORDER BY l.id; ";
	$sth = $db->querysoc($q);
	$levels[] = $sth->fetchAll();
}
debug($q);
$data['levels'] = $levels;

$this->view->render($data,'subjects/byLevels');


}	/* fxn */


public function set($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	$db=&$this->model->db;
	
	if(isset($_POST['save'])){
		$rows = $_POST['sub'];
		$q = "";
		foreach($rows AS $row){
			$q .= "
				UPDATE {$dbo}.`05_subjects` SET
				`is_active` = '".$row['is_active']."',`is_num` 	 = '".$row['is_num']."',
				`with_scores` 	 = '".$row['with_scores']."',`is_kpup` = '".$row['is_kpup']."',
				`parent_id` = '".$row['parent_id']."',`weight` = '".$row['weight']."',
				`in_genave` = '".$row['in_genave']."',`affects_ranking` = '".$row['affects_ranking']."',
				`indent` = '".$row['indent']."',`is_aggregate` = '".$row['is_aggregate']."',
				`is_transmuted` = '".$row['is_transmuted']."',`is_active` = '".$row['is_active']."',
				`name` = '".$row['subject']."',`code` = '".$row['subject_code']."',
				`position` = '".$row['position']."',`crstype_id` = '".$row['crstype_id']."'
				WHERE `id` = '".$row['subject_id']."' LIMIT 1; ";
		}
		$db->query($q);
		flashRedirect("subjects",'Subjects updated.');
		exit;	
	}

	$year = $_SESSION['year'];	
	if(isset($_POST['add'])){
		$q = "INSERT INTO {$dbo}.`05_subjects` (`name`,`code`,`crstype_id`,`is_active`,`year`) VALUES ";
		$rows = $_POST['subjects'];
		foreach($rows AS $row){			
			if(!empty($row['name'])){
				$q .= " ('".$row['name']."','".$row['code']."','".$row['crstype_id']."','1','$year'),";								
			}
		}	/* foreach */
		$q = rtrim($q,",");$q .= ";";
		$db->query($q);
		flashRedirect("subjects","Subjects added.");		
		exit;
	}	/* post */
	
	$data['subjects']=fetchRows($db,"{$dbo}.05_subjects","*,id AS subject_id","name");
	$data['subject_count']=count($data['subjects']);	
	if(!isset($_SESSION['crstypes'])){ $_SESSION['crstypes']=fetchRows($db,"{$dbo}.05_crstypes","id,code,name"); }
	$data['crstypes']=$_SESSION['crstypes'];		
	$vfile=(isset($_GET['edit']))? "subjects/editSubjects":"subjects/setSubjects";
	$this->view->render($data,$vfile);
	
}	/* fxn */








}	/* SubjectsController */
