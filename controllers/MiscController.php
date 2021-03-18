<?php
Class MiscController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	/* $acl = array(array(5,0),array(4,0)); */	
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				
	
}	/* fxn */



public function grid($params=NULL){
	$dbo=PDBO;
	$db =& $this->model->db;
	$data['home']=$home=$_SESSION['home'];	
	include_once(SITE.'views/elements/params_sq.php');
	$data['qtr']=$_SESSION['qtr'];		
	$data['classrooms']=$_SESSION['classrooms'];
	$data['months']=$_SESSION['months'];	
	$data['levels']=$_SESSION['levels'];	
	$data['subjects']=$_SESSION['subjects'];	
	$data['departments']=$_SESSION['departments'];	
	$data['roles']=$_SESSION['roles'];	
	$data['teachers']=$_SESSION['teachers'];	  
	$this->view->render($data,'mis/gridMis');

}	/* fxn */



public function registrar(){
	$dbo=PDBO;
	$home	= $_SESSION['home'];		
	$data['user']	= $_SESSION['user'];	
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
	$data['sy']		= $sy	= isset($params[0])? $params[0] : $ssy;
	$data['qtr']	= $qtr	= isset($params[1])? $params[1] : $sqtr;
	$dbyr 	= $sy.US;
	$data['home']	= $home;	
	$data['roles'] 		= $_SESSION['roles'];		
	$data['classrooms']	= $_SESSION['classrooms'];	
	$data['levels'] 	= $_SESSION['levels'];	
	
	$this->view->render($data,'misc/registrar');
}	/* fxn */

public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'misc/indexMisc');
}	/* fxn */




public function clsDir($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$data['levels'] 	= $this->model->fetchRows("{$dbo}.`05_levels`","*","id");
	$data['num_levels'] = count($data['levels']);
	$this->view->render($data,'mis/clsDir');

}	 /* fxn */


public function componentsDir($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$data['levels'] 	= $this->model->fetchRows("{$dbo}.`05_levels`","*","id");
	$data['num_levels'] = count($data['levels']);
	$this->view->render($data,'mis/componentsDir');

}	/* fxn */


public function classrooms($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;

	$lvlid			= 	isset($params[0])? $params[0] : 1;
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sy']		= $sy	= isset($params[1])? $params[1] : $ssy;
	$data['qtr']	= $qtr	= isset($params[2])? $params[2] : $_SESSION['qtr'];

	$_SESSION['url'] = "mis/classrooms/$lvlid/$sy/$qtr"; 
		
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$data['level_id'] 		= $level_id = $lvlid;
	$_SESSION['classrooms']['level_id'] = $level_id;
	$data['level']			= getLevelDetails($db,$level_id,$dbg);	
	$cond = isset($_GET['all'])? NULL:" AND cr.level_id = '$level_id'";	
	$q = "SELECT cr.*,sec.name AS section,sec.code AS section_code,l.code AS level,a.name AS adviser,cr.id AS crid
			FROM {$dbg}.05_classrooms AS cr 
				INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
				INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
				LEFT JOIN {$dbo}.`00_contacts` AS a ON cr.acid = a.id
			WHERE 1=1 $cond ORDER BY l.id,sec.name LIMIT 100";
			// pr($q);
	$sth = $this->model->db->querysoc($q);		
	$data['classrooms'] = $sth->fetchAll();	
	$data['sections']		= $this->model->fetchRows("{$dbo}.`05_sections`","*","code");	
	$data['levels']			= $this->model->fetchRows("{$dbo}.`05_levels`","id,code,name","id");		
	$data['num_classrooms'] = count($data['classrooms']);
	$data['teachers']		= $this->model->getContacts(RTEAC);	
	$data['coordinators'] 	= $this->model->getContacts(RACAD);	

	$data['crid'] = $crid = $this->model->lastID("{$dbg}.05_classrooms");
		
	if(isset($_POST['add'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts AS $post){
			$crname = $post['classroom'];
			$crname = ($post['is_sped']==1)? $crname."-S":$crname;
			$q.= "INSERT IGNORE INTO {$dbg}.05_classrooms(`id`,`level_id`,`section_id`,`name`,`label`,`num`) VALUES 
					('".$post['crid']."','".$post['level_id']."','".$post['section_id']."','".$crname."',
						'".$crname."','".$post['num']."'); ";
			$q.="INSERT IGNORE INTO {$dbg}.05_advisers_quarters(`crid`) VALUES('".$post['crid']."'); ";
			$q.="INSERT IGNORE INTO {$dbg}.05_promotions(`crid`) VALUES('".$post['crid']."'); ";
		}
		$this->model->db->query($q);
		$get = isset($_GET['all'])? '?all':NULL;
		$url = "mis/classrooms/$level_id".$get;
		flashRedirect($url,'Classrooms added.');
		exit;	
	}	/* post */
		
	
	$this->view->render($data,'mis/classrooms');

}	/* fxn */



public function xeditCrig($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$crid = $_POST['crid'];
	$q = " UPDATE {$dbg}.05_classrooms SET `is_init_grades` = '0'
		WHERE `id` = '$crid' LIMIT 1;  ";
	$this->model->db->query($q);
	$_SESSION['q'] = $q;
	
}	/* fxn */





public function xeditUnit($params){
	$dbo=PDBO;
	$contact_id = $params[0];

	$data['ssy']			= $ssy	= $_SESSION['sy'];
	$data['sy']				= $sy	= isset($params[1])? $params[1] : $ssy;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;

	$row = $_POST;
	$this->updateUnit($row);	
}	/* fxn */


public function xenableClassroom($params=null){
	$dbo=PDBO;
	$crid 					= $_POST['crid'];
	include_once(SITE.'views/elements/params_sq.php');

	$q = " UPDATE {$dbg}.05_classrooms SET `is_active` = '1' 
		WHERE `id` = '$crid' LIMIT 1;  ";
	$this->model->db->query($q);	
}	/* fxn */


public function xdisableClassroom($params=null){
	$dbo=PDBO;
	$crid = $_POST['crid'];
	include_once(SITE.'views/elements/params_sq.php');
	
	$q = " UPDATE {$dbg}.05_classrooms SET `is_active` = '0' 
		WHERE `id` = '$crid' LIMIT 1;  ";
	$this->model->db->query($q);	
}	/* fxn */

public function xeditSubject($params){
	$dbo=PDBO;
	$subid = $params[0];
	
	$data['ssy']			= $ssy	= $_SESSION['sy'];
	$data['sy']				= $sy	= isset($params[1])? $params[1] : $ssy;

	// $dbyr	= ($sy==$ssy)? '' : $sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$q = " UPDATE {$dbo}.`05_subjects` SET 
			`is_active` 	 = '".$_POST['actv']."',`is_num` 	 = '".$_POST['num']."',
			`with_scores` 	 = '".$_POST['ws']."',`is_kpup` = '".$_POST['kpup']."',
			`parent_id` = '".$_POST['prnt']."',`weight` = '".$_POST['wt']."',
			`in_genave` = '".$_POST['iga']."',`affects_ranking` = '".$_POST['ar']."',
			`indent` = '".$_POST['indt']."',`is_aggregate` = '".$_POST['aggre']."',
			`is_transmuted` = '".$_POST['trans']."',`is_active` = '".$_POST['actv']."',
			`name` = '".$_POST['name']."',`code` = '".$_POST['code']."',
			`position` = '".$_POST['pos']."',
			`crstype_id` = '".$_POST['cty']."'
		WHERE `id` = '$subid' LIMIT 1;  ";
	$this->model->db->query($q);
	
}	/* fxn */





public function subjects($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
		
	if(isset($_POST['save'])){
		// pr($_POST);
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
				WHERE `id` = '".$row['subject_id']."' LIMIT 1;
			";
		}
		// pr($q);exit;
		$this->model->db->query($q);
		$url = "mis/subjects/$sy";
		flashRedirect($url,'Subjects updated.');
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
		$q = rtrim($q,",");
		$q .= ";";
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/subjects/$sy";
		redirect($url);
		
		exit;
	}	/* post */

	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid,id AS subject_id','name');	

	$data['num_subjects'] 	= count($data['subjects']);
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");		
	$this->view->render($data,'mis/subjects');

}	/* fxn */



public function subcourses($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;

	$data['subject_id']	= $subject_id 		= $params[0];
	$data['home']	= $_SESSION['home'];
	$_SESSION['subcourses']['subject_id'] = $subject_id;	
	$ssy	= $_SESSION['sy'];
	$sy 	= isset($params[1])? $params[1]: $ssy;

	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;

	if(isset($_POST['save'])){
		// pr($_POST);
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
		// $url = "mis/subcourses/".$subject_id;
		$url = 'syncs/syncCQ/mis';
		redirect($url);
		exit;		
	
	}	/* save */
		

if(isset($_POST['add'])){
		// echo "add";
		// pr($_POST);
		$subcode		 = $_POST['subcode'];
		$supsubject_id	 = $_POST['supsubject_id'];
		$course_weight	 = $_POST['course_weight'];
		$subject_id		 = $_POST['subject_id'];
		$label			 = $_POST['label'];
		$is_aggregate	 = $_POST['is_aggregate'];
		$year			 = date('Y'); 
		$rows			 = $_POST['subcourses'];
		$crstype_id  = $_POST['crstype_id'];		
		

		// insert into {$dbg}.abc (`code`,`name`) values ('mla','manila'),('qc','quezon city');		
		$q = " 
			INSERT INTO {$dbg}.05_courses (`code`,`name`,`label`,`subject_id`,`crid`,
				`tcid`,`supsubject_id`,`course_weight`,
				`crstype_id`,`year`,`position`
			) VALUES
		";
		
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
		$url = "mis/subcourses/".$subject_id;
		redirect($url);
		exit;
		
		
}	/* post-add */
	
	$data['subject']	= getSubjectDetails($db,$subject_id);
	$data['subcourses'] = $this->model->subcourses($subject_id);
	$data['num_subcourses'] = count($data['subcourses']);
	$data['teachers'] 	= $this->model->getContacts(RTEAC);	
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");	
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
	$this->view->render($data,'mis/subcourses');
}	/* fxn */


public function getLevelSection($params=NULL){
	$dbo=PDBO;
	$ssy	= $_SESSION['sy'];
	$sy 	= isset($params[0])? $params[0]: $ssy;

	// $dbyr	= ($sy==$ssy)?'':$sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$crid = $_POST['crid'];
	$q = " 
		SELECT 
			l.code AS lvlcode,sec.code AS sxncode
		FROM {$dbg}.05_classrooms AS cr
			INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		WHERE cr.id = '$crid' LIMIT 1;	
	";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	
}	/* fxn */


public function getEmployee($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
		
	$ecode = $_POST['ecode'];
	$q = " SELECT id AS ecid,name FROM {$dbo}.`00_contacts` WHERE `role_id` != '1' AND (id=parent_id) AND `code` = '$ecode' LIMIT 1;	";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
}	/* fxn */


public function getPrivilege($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	$prid = $_POST['prid'];
	
	$q = " SELECT role_id,privilege_id FROM {$dbo}.`00_titles` WHERE `id` = '$prid' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
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

public function editSubject($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;

	$subject_id = $params[0];
	$ssy	= $_SESSION['sy'];
	$data['sy']	= $sy 	= isset($params[1])? $params[1]: $ssy;

	// $dbyr	= ($sy==$ssy)?'':$sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	

	if(isset($_POST['submit'])){
		// pr($_POST);		
		$q = "
			UPDATE {$dbo}.`05_subjects` SET 
				`name` = '".$_POST['subject']['name']."',
				`code` = '".$_POST['subject']['code']."',
				`crstype_id` = '".$_POST['subject']['crstype_id']."'
			WHERE `id` = '".$_POST['subject']['subid']."'
		";
		// pr($q);
		$this->model->db->query($q);
		
		redirect("mis/subjects");
		exit;
	}	/* post-submit edit */

	$data['subject']		= getSubjectDetails($db,$subject_id,$dbg);	
	if($sy >= $data['subject']['year']){ $this->flashRedirect("mis/subjects"); }
	
	$data['areas'] 			= $this->model->areas($dbg);		
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");			
	$this->view->render($data,'mis/editSubject');

}	/* fxn */




/* ======================== criteria ========================================================= */


public function deleteCriteria($params){
	$dbo=PDBO;
	$dbg = PDBG;
	$criteria_id = $params[0];
	$q = " DELETE FROM {$dbo}.`05_criteria` WHERE `id` = '$criteria_id' LIMIT 1; ";
	$this->model->db->query($q);
	$url = 'mis/criteria';
	flashRedirect($url,'Criteria Deleted!');
} 	/* fxn */


public function xdeleteCourse($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$course_id = $_POST['crsid'];
	$q = " DELETE FROM {$dbg}.05_courses WHERE `id` = '$course_id' LIMIT 1; ";
	$this->model->db->query($q);
}	/* fxn */



public function employees($params=NULL){
$dbo=PDBO;$db=&$this->model->db;
include_once(SITE.'views/elements/params_sq.php');
		
if(isset($_POST['add'])){
	// pr($_POST);
	$year 		   = date('Y');
	$pass		   = MD5('pass');	
	$rows 		   = $_POST['contacts'];
	
	$q = " SELECT max(id) AS cid FROM {$dbo}.`00_contacts`;";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	$cid = $row['cid'];
	
	$q = "";
 	foreach($rows AS $row){
		$cid++;
		$fullname = $row['last'].','.$row['first'].' '.$row['middle'];
		
		/* 1-contacts_tbl */
		$q .= " INSERT INTO {$dbo}.`00_contacts` (`id`,`parent_id`,`name`,`code`,
			`account`,`pass`,`is_active`,`title_id`,`role_id`,`privilege_id`,`sy`,`is_male`) VALUES 
			('$cid','$cid','$fullname','".$row['code']."',
			'".$row['code']."','$pass','1','".$row['title_id']."','".$row['role_id']."','".$row['privilege_id']."','$year','".$row['is_male']."'); ";
		
		/* 1b - ctp */
		$q .= " INSERT INTO {$dbo}.`00_ctp` (`contact_id`,`ctp`) VALUES ('".$cid."','pass'); ";
		
		/* 2-profiles_tbl */
		$q .= "
			INSERT INTO {$dbo}.`00_profiles` (`contact_id`,`first_name`,
			`middle_name`,`last_name`) VALUES			
			('$cid','".$row['first']."','".$row['middle']."',
			'".$row['last']."');
		";
		
		/* 3 - employees & attendance_employees - synclist employees */
					
	}	/* foreach */
	
	$db->query($q);
	redirect('mis');
	
}	/* post-add */

	$data['titles']		= $_SESSION['titles'];
	$this->view->render($data,'mis/employees');

}	/* fxn */



public function editCriteria($params){
	$dbo=PDBO;
	require_once(SITE."functions/classifications.php");	
	$ssy	= $_SESSION['sy'];
	$dbg	= PDBG;

	if(isset($_POST['edit'])){		
		$row = $_POST['criteria'];
		// pr($row);
		$sqlCrsType = classifyCourseType($row['crstype_id']);
		$q = " UPDATE {$dbo}.`05_criteria` SET `name` = '".$row['name']."',
			`crstype_id`= '".$row['crstype_id']."',
			`code` 			= '".$row['code']."',
			`position` 		= '".$row['position']."',
			`is_active`     = '".$row['is_active']."',
			`is_raw`     	= '".$row['is_raw']."',
			`is_kpup`       = '".$row['is_kpup']."',
			`is_kpup_list`  = '".$row['is_kpup_list']."',			
		";

		$crstype_id = $row['crstype_id'];
		
		// $department_id = $row['department_id'];
		$department_id = 5;
		$sqlDept = classifyDepartmentForEdit($department_id,'');
		$q .= $sqlDept;
		
		$q .= " WHERE `id` = '".$row['id']."';  ";
		// pr($q);
		// exit;
		$this->model->db->query($q);
		redirect('mis/criteria');
		exit;
	
	}	/* post-edit */

	$criteria_id = $params[0];
	$data['criteria'] = $this->model->getCriteriaDetails($criteria_id);
	$data['crstypes'] = $this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['departments']  = $this->model->fetchRows("".PDBO.".`05_departments`");	
	
	$this->view->render($data,'mis/editCriteria');


}	/* fxn */


public function employee($params){
	$dbo=PDBO;
	$ecid = $params[0];
	$ssy	= $_SESSION['sy'];
	$sy 	= isset($params[1])? $params[1]: $ssy;

	// $dbyr	= ($sy==$ssy)?'':$sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$q = "
		SELECT 
			c.*,c.name AS employee,c.id AS ecid,
			p.*,
			e.*,
			t.name AS title,
			ctp.ctp 
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN {$dbg}.06_employees AS e ON e.contact_id = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
			LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		WHERE c.id = '$ecid' LIMIT 1;
	";
	$sth = $this->model->db->querysoc($q);
	$data['employee'] = $sth->fetch();
	$this->view->render($data,'mis/employee');
	

}	/* fxn */



public function acl($params = null){
	$cond = isset($params[0])? " WHERE a.module_id = ".$params[0]." " : null; 
	$data['acl'] = $this->model->acl($cond);
	$this->view->render($data,'mis/acl');

}	/* fxn */



public function addAcl($params=NULL){
$dbo=PDBO;
$ssy	= $_SESSION['sy'];
$sy 	= isset($params[0])? $params[0]: $ssy;

// $dbyr	= ($sy==$ssy)?'':$sy.US;
$dbyr 	= $sy.US;
$dbg	= VCPREFIX.$dbyr.DBG;

	if(isset($_POST['submit'])){
		$rows = $_POST['acl'];
		$q = " INSERT INTO {$dbg}.acl (`module_id`,`role_id`) VALUES ";
		foreach($rows AS $row){
			$module_id = $row['module_id'];
			$role_id = $row['role_id'];
			$q .= " ($module_id,$role_id),";	
		}
		$q = rtrim($q,",");
		// pr($q); exit;
		$r = $this->Admin->db->query($q);
		if(!$r){ pr($q); die('Query failed.');  }		
		else { Session::set('message','Add Success'); }		
		redirect('mis/acl');
	}


	$data['selects'] = $this->model->selectsAcl($dbg);
	$this->view->render($data,'mis/addAcl');

}	/* fxn */


public function editAcl($ids){
$dbo=PDBO;
$ssy	= $_SESSION['sy'];
$sy 	= isset($params[0])? $params[0]: $ssy;

// $dbyr	= ($sy==$ssy)?'':$sy.US;
$dbyr 	= $sy.US;
$dbg	= VCPREFIX.$dbyr.DBG;

if(isset($_POST['submit'])){
	// pr($_POST);
	$rows = $_POST['acl'];
	
	$q = "";
	foreach($rows AS $row){
		$id = $row['id'];
		$module_id  = $row['module_id'];
		$role_id 	= $row['role_id'];
		$q .= " UPDATE {$dbg}.acl 
			SET `module_id` = $module_id,`role_id` = '$role_id'
			WHERE `id` = '$id' LIMIT 1;
		";
	}
	pr($q); 
	exit;
	
}	/* post-submit */

$data['acl'] = array();
foreach($ids AS $id){
	$q = " SELECT a.*,m.name AS module,r.name AS role
			FROM {$dbg}.acl AS a
				INNER JOIN {$dbo}.modules AS m ON m.id = a.module_id
				INNER JOIN {$dbo}.`00_roles`  AS r ON r.id = a.role_id
			WHERE a.id = $id ";
	$sth = $this->Admin->db->querysoc($q);
	$row = $sth->fetch();
	$data['acl'][] = $row;
}

$data['selects'] = $this->selectsAcl();
$this->view->render($data,'mis/editAcl');

}	/* fxn */


public function deleteAcl($ids){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$q = "";
	foreach($ids AS $id){
		$q .= " DELETE FROM {$dbg}.acl WHERE id = $id; ";	
	}
	pr($q); exit;
	$this->model->db->query($q);
	redirect('mis/acl');

}	/* fxn */

/* ------------------------------------------------------------------------------------------------------ */


public function roles($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	# for batch edits
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$url = 'mis/editRoles/'.$ids;
		redirect($url);		
	}

	$data['roles'] 		= $this->model->fetchRows("".PDBO.".`00_roles`","id,name","id");
	$data['num_roles']	= count($data['roles']);
	
	$this->view->render($data,'mis/roles');

}	/* fxn */

public function editRoles($ids){
	$dbo=PDBO;
   	if(is_null($ids)){ redirect('mis'); }		
	if(isset($_POST['submit'])){
		$rows = $_POST['roles'];
		foreach($rows as $row){			
			$rp_id 	 = $row['rp_id'];
			$user_id = $row['user_id'];
			
			$q = "
				UPDATE {$dbo}.`00_contacts` AS c
					INNER JOIN {$dbo}.`00_titles` AS p ON p.id = $rp_id
				SET c.role_id = p.role_id,c.privilege_id = p.privilege_id
				WHERE c.id = $user_id
			";
						
			pr($q); exit;			
			$this->model->db->query($q);
			
		} /* foreach */
		$url = 'mis/roles';
		redirect($url);
	}	/* post-submit */
	
	$numrows = count($ids);
	for($i=0;$i<$numrows;$i++){
		$id = $ids[$i];
		$data['roles'][$i] = $this->model->readRole($id);
	}	
	

	$q = " SELECT id,name FROM {$dbo}.`00_titles` ";
	$sth = $this->model->db->querysoc($q);
	$data['selectsRoles'] = $sth->fetchAll();
	
	$data = isset($data)? $data : null;		
	$this->view->render($data,'mis/editRoles');		
}	/* fxn */



public function titles($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$data['titles']		= $this->model->titlesDetails($dbg);		
	$data['num_titles']		= count($data['titles']);
	$this->view->render($data,'mis/titles');		


}	/* fxn */





// mis/classrooms/level_id
public function xeditClsAdmin($params){	
	$dbo=PDBO;
	$crid 	= $params[0];
	$sy		= $params[1];
	$ssy	= $_SESSION['sy'];
	// $dbyr 	= ($sy==$ssy)? '': $sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$q = " UPDATE {$dbg}.05_classrooms SET 				
				`is_modified_acid` = '1',
				`num` = '".$_POST['num']."',
				`name` = '".$_POST['name']."',
				`label` = '".$_POST['label']."',
				`acid` = '".$_POST['advi']."',
				`hcid` = '".$_POST['coor']."' 
			WHERE `id` = '".$crid."' LIMIT 1;
	";
	$_SESSION['q'] = $q;
	$this->model->db->query($q);
}	/* fxn */



public function xeditSettingGis($params){	
	$dbo=PDBO;
	$sgid 	= $params[0];
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])? $params[1]:$ssy;

	// $dbyr 	= ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$q = " UPDATE {$dbo}.`00_settings` SET 
				`label` = '".$_POST['sgl']."', 
				`value` = '".$_POST['sgv']."' 
			WHERE `id` = '".$sgid."' LIMIT 1;
	";
	$this->model->db->query($q);
}	/* fxn */


public function disableCourse($params=NULL){	
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$q = " UPDATE {$dbg}.05_courses SET 
				`is_active` = '0' 
			WHERE `id` = '".$_POST['crsid']."' LIMIT 1;
	";
	$this->model->db->query($q);
}	/* fxn */

public function enableCourse($params=NULL){		/* mis-courses */
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	$q = " UPDATE {$dbg}.05_courses SET 
				`is_active` = '1' 
			WHERE `id` = '".$_POST['crsid']."' LIMIT 1;
	";
	$_SESSION['q'] = $q;
	$this->model->db->query($q);
}	/* fxn */


/* mis-contacts */
public function disableContact($params=NULL){	
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$q = " UPDATE {$dbo}.`00_contacts` SET 
				`is_active` = '0' 
			WHERE `id` = '".$_POST['cid']."' LIMIT 1;
	";
	$this->model->db->query($q);
}	/* fxn */


/* mis-contacts */
public function enableContact($params=NULL){	
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$q = " UPDATE {$dbo}.`00_contacts` SET 
				`is_active` = '1' 
			WHERE `id` = '".$_POST['cid']."' LIMIT 1;
	";
	$this->model->db->query($q);
}	/* fxn */









public function setup($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	$data['sqtr']	= $qtr;
	
	$q = " SELECT count(ss.scid) AS numrows FROM {$dbo}.sy_scid AS ss 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON ss.scid = c.id
		WHERE 	c.is_active = 1 AND ss.sy = '$sy'; ";
	$sth 	= $this->model->db->querysoc($q);
	$row	= $sth->fetch(); 
	$data['num_syscid']	= $row['numrows'];
	
	$q = " SELECT count(sum.scid) AS numrows FROM {$dbg}.05_summaries AS sum 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
		WHERE 	c.is_active = 1; ";
	$sth 	= $this->model->db->querysoc($q);
	$row	= $sth->fetch(); 
	$data['num_students']	= $row['numrows'];	
	
	$data['months']		= $this->model->fetchRows("".PDBO.".months","*","id");	
	$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");
	$data['teachers']	= $this->model->getContacts(RTEAC);
	
	$this->view->render($data,'mis/setup');
	
}	/* fxn */


public function sections($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	if(isset($_POST['add'])){
		$year = date('Y');
		$q = "INSERT INTO {$dbo}.`05_sections` (`code`,`name`,`position`) VALUES ";

		$rows = $_POST['sections'];
		foreach($rows AS $row){			
		  $q .= " ('".$row['code']."','".$row['name']."','".$row['position']."'),";					
		}			
		$q = rtrim($q,",");
		$q .= ";";
		// pr($q);exit;		
		$this->model->db->query($q);
		$url = "mis/sections";
		flashRedirect($url,'Sections added.');		
		exit;
	}	/* post-add */


	$sort = isset($_GET['sort'])? $_GET['sort']:'name';
	$data['sections'] 		= $this->model->fetchRows("{$dbo}.`05_sections`","*",$sort);
	$data['num_sections'] 	= count($data['sections']);
	
	
	$this->view->render($data,'misc/sections');

}	/* fxn */



public function xeditSection($params){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$q = " UPDATE {$dbo}.`05_sections` SET `code` = '".$_POST['code']."',`name` = '".$_POST['name']."',`position` = '".$_POST['position']."' 
			WHERE `id` = '".$_POST['id']."' LIMIT 1; ";
	return $this->model->db->query($q);

}	/* fxn */


public function departments($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$data['departments'] 	  = $this->model->fetchRows("".PDBO.".`05_departments`","*");
	$data['num_departments']  = count($data['departments']);
	$this->view->render($data,'mis/departments');

}	/* fxn */

public function descriptions($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$data['descriptions'] 	  = $this->model->descriptions($dbg);
	$data['num_descriptions']  = count($data['descriptions']);
	$this->view->render($data,'mis/descriptions');

}	/* fxn */


public function mcaDir($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	$data['levels'] 	= $this->model->fetchRows("{$dbo}.`05_levels`","*","id");	
	$data['num_levels']	= count($data['levels']);
	$this->view->render($data,'mis/mcaDir','full');

}	/* fxn */



public function reset($params=NULL){
	$dbo=PDBO;
	$ctlr 	= $params[0];
	$home	= $_SESSION['home'];
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])? $params[1] : $ssy;
	$dbyr 	= $sy.US;
	$dbg = VCPREFIX.$dbyr.DBG;
	$this->model->sessionizeMIS($dbg);		/* ARM-MODEL */
	redirect($home);
} 	/* fxn */




public function xgetLevelCourses($params=null){
$dbo=PDBO;
$lid = $_POST['lid'];
include_once(SITE.'views/elements/params_sq.php');

$q = "
	SELECT 
		crs.id,crs.name
	FROM {$dbg}.05_courses AS crs
		INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id	
	WHERE cr.level_id = '".$lid."'	
 ";

$sth = $this->model->db->querysoc($q);
// $_SESSION['q'] = $q;
$row = $sth->fetchAll();
echo json_encode($row);


}	/* fxn */






public function xgetClassroomCourses($params=null){
$dbo=PDBO;
$crid 	= $_POST['crid'];
include_once(SITE.'views/elements/params_sq.php');

$q = "
	SELECT 
		id,name,label
	FROM {$dbg}.05_courses 
	WHERE `crid` = '".$crid."'	
 ";

$sth = $this->model->db->querysoc($q);
$row = $sth->fetchAll();
echo json_encode($row);


}	/* fxn */


public function msg(){	/* move student grades tsg2 */
	$dbo=PDBO;
	$data['home'] = 'mis';
	$this->view->render($data,'mis/msg');

}	/* fxn */



public function deluser($params){
$dbo=PDBO;
$ucid = $params[0];

$q = "DELETE FROM {$dbo}.`00_contacts` 		
	WHERE (id<>parent_id) AND `id` = '$ucid' LIMIT 1; ";
pr($q);
$sth=$this->model->db->query($q);
echo ($sth)? "Success":"Fail";

// $url = "mgt/users/".$_SESSION['users']['pcid'];
// pr($url); exit;
// redirect($url);

}	/* fxn */




private function plistClassrooms($dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT cr.*,
			ac.account AS alogin,ac.name AS adviser,
			cac.chinese_name,
			cac.id AS chinese_acid,cac.name AS chinese_adviser,
			hc.account AS hlogin,ap.`ctp` AS apass 
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`00_contacts` AS ac ON cr.acid = ac.id
		LEFT JOIN {$dbo}.`00_contacts` AS cac ON cr.chinese_acid = cac.id
		LEFT JOIN {$dbo}.`00_profiles` AS cap ON cr.chinese_acid  = cap.contact_id
		LEFT JOIN {$dbo}.`00_ctp` AS ap ON cr.acid = ap.contact_id
		LEFT JOIN {$dbo}.`00_contacts` AS hc ON cr.hcid = hc.id
	";
	$sth = $this->model->db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


public function listClassrooms($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	$data['rows'] 		= $this->plistClassrooms($dbg);
	$data['num_rows'] 	= count($data['rows']);
	$this->view->render($data,'mis/listClassrooms');

}	/* fxn */


public function syncAM($params){	/* attmonths */
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');
$data['current']	= $current		= ($sy==$ssy)?  true:false;

$levels 	= $_SESSION['settings']['graduate_level'];	// if 14 - 13 levels incl 3 ps

// 1 - levels
$q = "SELECT *, id AS lid FROM {$dbo}.`05_levels` WHERE `id` < '$levels' ;  ";
$sth = $this->model->db->querysoc($q);
$data['levels']  	= $sth->fetchAll();
$ar 	= buildArray($data['levels'],'lid');
// pr($ar);


// 2 - am
$q = "	SELECT am.*,l.id AS lid,l.name AS level,am.id AS amid 
		FROM {$dbo}.`05_levels` AS l		
			LEFT JOIN {$dbg}.05_attendance_months AS am ON am.level_id = l.id; ";
$sth = $this->model->db->querysoc($q);
$data['am']  		= $sth->fetchAll();
$data['num_months'] = count($data['am']);

$br = buildArray($data['am'],'lid');
// pr($br);


$ix = array_diff($ar,$br);
pr($ix);

$q = " INSERT INTO {$dbg}.05_attendance_months (`level_id`) VALUES ";
foreach($ix AS $lid){ $q .= " ('$lid'),"; }
$q = rtrim($q,",");	
$q .= ";";

// pr($q); exit;

$this->model->db->query($q);
redirect('mis/attmonths/'.$sy);


}	/* fxn */


public function attmonths($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');
$data['num_levels']	= $_SESSION['settings']['graduate_level']-1;

if(isset($_POST['submit'])){
$rows = $_POST['am'];

	$q = "";
	foreach($rows AS $row){
		$q .= " UPDATE {$dbg}.05_attendance_months SET  
			`jun_days_total` = '".$row['jun']."',`jul_days_total` = '".$row['jul']."',`aug_days_total` = '".$row['aug']."',
			`sep_days_total` = '".$row['sep']."',`oct_days_total` = '".$row['oct']."',`nov_days_total` = '".$row['nov']."',
			`dec_days_total` = '".$row['dec']."',`jan_days_total` = '".$row['jan']."',`feb_days_total` = '".$row['feb']."',
			`mar_days_total` = '".$row['mar']."',`apr_days_total` = '".$row['apr']."',`may_days_total` = '".$row['may']."',
			`q1_days_total` = '".$row['q1']."',`q2_days_total` = '".$row['q2']."',
			`q3_days_total` = '".$row['q3']."',`q4_days_total` = '".$row['q4']."',
			`year_days_total` = '".$row['total']."'
			WHERE `id` = '".$row['amid']."' LIMIT 1; 
		";
	}
	$this->model->db->query($q);
	redirect('mis/attmonths/'.$sy);

}	/* post */

/* ---------------- process ------------------------------------------------------ */

// am
$q = "	SELECT am.*,l.id AS lid,l.name AS level,am.id AS amid 
		FROM {$dbo}.`05_levels` AS l		
			LEFT JOIN {$dbg}.05_attendance_months AS am ON am.level_id = l.id
		ORDER BY l.id; ";
$sth = $this->model->db->querysoc($q);
$data['am']  		= $sth->fetchAll();
$data['num_am_levels'] = count($data['am']);




$this->view->render($data,'mis/attmonths','full');


}	/* fxn */


public function dropAttendance($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	if(isset($_POST['submit'])){
		$rows = $_POST['da'];	
		$q = ""; 
		foreach($rows AS $row){ 
			$q .= " DELETE FROM {$dbg}.05_attendance_logs WHERE `date` = '".$row['date']."';  "; 
		}
		$this->model->db->query($q);
		// pr($q); exit;
		Session::set('message','Dropped date '.$row['date']);
		redirect('mis/dropAttendance');
	}	/* post */


$data['months']	=	$this->model->fetchRows("".PDBO.".months");
$this->view->render($data,'mis/dropAttendance');


}	/* fxn */



public function editMonthsQuarters($params=NULL){
$dbo=PDBO;
	
include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['submit'])){
	$rows = $_POST['data']['MQ'];
	$q = "";
	foreach($rows AS $row){ 
		$q .= "UPDATE {$dbo}.`05_months_quarters` SET 
			`index` = '".$row['index']."', 
			`quarter` = '".$row['qtr']."' 
			WHERE `id` = '".$row['row_id']."' LIMIT 1; "; }
		
	// pr($q); exit;
	$this->model->db->query($q);	
	$_SESSION['message'] = "Changes Saved!";
	$url = 'mis/editMonthsQuarters/'.$sy;	
	redirect($url);
	
}	/* post */

	$data['rows'] = $this->model->fetchRows("{$dbo}.`05_months_quarters`",'*');
	$data['numrows'] = count($data['rows']);
	
	$this->view->render($data,'mis/editMonthsQuarters');
}	/* fxn */


public function ctp(){
	$dbo=PDBO;

$q = "
	SELECT c.id,c.id AS ucid,c.parent_id AS pcid,pc.name,c.code,c.account,ctp.*,t.name AS title,r.name AS role
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
		LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id = r.id
	WHERE c.role_id <> 1
	ORDER BY pc.name
";
$sth = $this->model->db->querysoc($q);
$data['ctp'] = $sth->fetchAll();
// pr($data);

$data['num_ctp'] = count($data['ctp']);

$this->view->render($data,'mis/ctp');


} /* fxn */


public function syncCdept($cid,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT `contact_id` FROM {$dbo}.`88_contacts_departments` WHERE `contact_id` = '$cid' LIMIT 1;  ";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
		
	if(empty($row)){ 
		$q = "INSERT INTO {$dbo}.`88_contacts_departments` (`contact_id`) VALUES ('$cid');  ";
		$_SESSION['q'] = $q;
		$this->model->db->query($q);	
	} 
	
}	/* fxn */

public function dept($params){
$dbo=PDBO;
$ecid = $params[0];
$dbg = PDBG;

if(isset($_POST['submit'])){
	$this->syncCdept($ecid);
	
	$ps = isset($_POST['ps'])? '1' : '0';
	$gs = isset($_POST['gs'])? '1' : '0';
	$hs = isset($_POST['hs'])? '1' : '0';
	
	$q = " UPDATE {$dbo}.`88_contacts_departments` SET 
		`is_ps` = '$ps', 
		`is_gs` = '$gs', 
		`is_hs` = '$hs'  
		WHERE `contact_id` = '$ecid' LIMIT 1;	
	";
	$this->model->db->query($q);	

	// $url = 'mis/dept/'.$ecid;
	$url = 'mis/multiusers';
	redirect($url);	
	exit;

}	// post

// -----------------------------------------------------------------
$q = "
	SELECT 
		c.*,cd.*
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`88_contacts_departments` AS cd ON cd.contact_id = c.id
	WHERE c.`id` = '$ecid' LIMIT 1;	
";
$sth = $this->model->db->querysoc($q);
$data['contact'] = $contact = $sth->fetch();
// pr($q);
$role_id = $contact['role_id'];
if($role_id==1){ Session::set('message','Students Not Allowed'); redirect(); }

$this->view->render($data,'mis/dept');


}	/* fxn */


public function announcements($params=NULL){
	$dbo=PDBO;
	$page		= isset($params[0])? $params[0]:1;
	$ssy		= $_SESSION['sy'];
	$data['sy']	= $sy			= isset($_GET['sy'])? $_GET['sy'] : $ssy;
	
	$dbyr 		= $sy.US;
	$dbg		= VCPREFIX.$dbyr.DBG;
		
	$perPage 	= 5;
	$page 		= $params[0];
	$offset 	= ($page - 1)*$perPage;
	$totalCount	= $this->model->totalCount("{$dbg}.announcements");
	
	$getsy = isset($_GET['sy'])? 'sy='.$_GET['sy'] : NULL;
	$_SESSION['announcements_url'] = "mis/announcements/".$params[0].'?'.$getsy;

	$q = " SELECT * FROM {$dbg}.announcements 
			ORDER BY position LIMIT $perPage OFFSET $offset; ";
	$sth = $this->model->db->querysoc($q);
	// pr($q);
	$data['announcements'] = $sth->fetchAll();
		
	$pagination = new Pagination($page,$perPage,$totalCount);	
	$data['pages'] = $pagination->pageNav('mis','announcements');	
	$data['num_pages']	= count($data['pages']);
		
	$this->view->render($data,'mis/announcements');


}	/* fxn */

public function announcementAdd($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');


if(isset($_POST['submit'])){
	$created = date('Y-m-d H:i:s');
	$q  = " INSERT INTO {$dbg}.announcements(`announcement`,`announcement_by`,`position`,`is_active`,`created`) VALUES ";
	$q .= " ('".$_POST['announcement']."','".$_POST['announcement_by']."','".$_POST['position']."','".$_POST['is_active']."','".$created."'); ";
	
	$this->model->db->querysoc($q);
	$url = isset($_SESSION['announcements_url'])? $_SESSION['announcements_url'] : 'mis/announcements';
	redirect($url);

}

	$this->view->render($data=NULL,'mis/announcementAdd');

}	/* fxn */


public function announcementEdit($params){
$dbo=PDBO;
$id  = $params[0];
$ssy = $_SESSION['sy'];
$sy  = isset($params[1])? $params[1]:$ssy;
$current = ($sy==$ssy)? true:false;
$dbg = ($current)? PDBG:VCPREFIX.$sy.US.DBG;

if(isset($_POST['edit'])){
	$created = date('Y-m-d H:i:s');
	$q  = " UPDATE {$dbg}.announcements SET ";
	$q .= " `announcement` 	= '".$_POST['announcement']."',`announcement_by` = '".$_POST['announcement_by']."',
		`position` = '".$_POST['position']."',`is_active` = '".$_POST['is_active']."',`created` = '".$created."' 
		WHERE `id` = '$id' LIMIT 1; ";
	
	$this->model->db->querysoc($q);
	$url = isset($_SESSION['announcements_url'])? $_SESSION['announcements_url'] : 'mis/announcements/1?sy='.$sy;
	redirect($url);

}

/*  ------- process */
$q = " SELECT * FROM {$dbg}.announcements WHERE `id` = '$id' LIMIT 1;  ";
$sth = $this->model->db->querysoc($q);
$data['announcement'] = $sth->fetch();

$this->view->render($data,'mis/announcementEdit');

}	/* fxn */



public function upload(){
$dbo=PDBO;
if(isset($_POST['submit'])) {
	$tmp_file = $_FILES['file_upload']['tmp_name'];
	$target_file = basename($_FILES['file_upload']['name']);	
	/* $upload_dir = SITE.'public/images'; */		
	$upload_dir = ROOT.'/assets';		

	$filename = stripslashes(trim($_POST['filename']));
	$target_file = (isNullOrEmpty($filename))?  $target_file : $filename;
			
	$upfile = $upload_dir.'/'.$target_file;
	if(move_uploaded_file($tmp_file,$upfile)) {
		Session::set('message','File uploaded successfully.');
	} else {
		$error = $_FILES['file_upload']['error'];
		Session::set('message','Upload failed.');
	}			
	redirect('mis');
		
}	/* post */
	
$this->view->render(null,'mis/upload');

} /* fxn */




public function attemps($params=NULL){	/* role */
	$dbo=PDBO;
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/attendance.php");
	require_once(SITE."functions/employees.php");	
	$db =& $this->model->db;

	$role_id	= $data['role_id'] = isset($params[0])? $params[0] : 0; 
	$ssy 		= $data['ssy'] = $_SESSION['sy'];
	$sy 	 	= $data['sy'] 	= isset($params[1])? $params[1] : $ssy;	
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$emp		= isset($params[3])? $params[3]:true;
	$att 		= ($emp)? 'attendance_employees_logs':'attendance_logs';
	
	// $dbyr		= ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;

	$role	= $this->model->fetchRow("".PDBO.".`00_roles`",$role_id);
	
/* ---------------------- process ----------------------------------------------------------------	 */


	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = employees($db,$dbg,$fields=NULL,$filter);
	$data['num_emps'] = count($data['emps']);		
	$data['numrows'] = $numrows = $data['num_emps'];
	if($numrows==0){ $this->flashRedirect("mis/attemps/0/$sy","No record found for ".$role['name']); }
		
	$months = $data['months'] = gisMonthsQuarters($db,$qtr,$dbg);
	$data['attendance_months'] 	= employeesAttendanceMonths($db,$sy,$dbg);	 	 
	$data['roles'] = $this->model->fetchRows("".PDBO.".`00_roles`");
	
	foreach($data['emps'] AS $row){ $data['attendance'][] = getEmployeeAttendance($db,$dbg,$sy,$row['ecid']); }	

	$data['today']		= $_SESSION['today'];	
	$data['home'] = 'mis';
	$_SESSION['attendance_url'] = URL.'mis/attEmps/'.$role_id.DS.$sy.DS.$qtr;
	
	$this->view->render($data,'mis/attemps');

		 
 
}	/* fxn */



public function attendanceEmployees($params=NULL){		/* role */
	$dbo=PDBO;
	require_once(SITE."functions/times.php");
	require_once(SITE."functions/attendance.php");
	require_once(SITE."functions/employees.php");
	$db =& $this->model->db;
	$dbg = PDBG;
	
	$role_id	= $data['role_id'] = isset($params[0])? $params[0] : 0; 
	$sy 		= $data['sy'] = $_SESSION['sy'];
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	


	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = $this->model->employees($db,$dbg,$fields=NULL,$filter);
	$data['num_emps'] = count($data['emps']);		
		
	$months = $data['months'] 	= gisMonthsQuarters($db,$qtr);
	$data['attendance_months'] 	= employeesAttendanceMonths($db,$sy,$dbg);	 	 
	$data['roles'] = $this->model->fetchRows("".PDBO.".`00_roles`");
		
	foreach($data['emps'] AS $row){ $data['attendance'][] = getEmployeeAttendance($db,$dbg,$sy,$row['ecid']); }
		
	$data['today']	= $_SESSION['today'];	
	$data['home'] 	= $_SESSION['home'];
	$_SESSION['attendance_url'] = URL."mis/attEmps/$role_id/$sy/$qtr";
	
	$this->view->render($data,'mis/attendanceEmployees');

		
 
 
}	/* fxn */



public function talAttemps($params){	/* tally attendance logs */
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');
require_once(SITE."functions/codes.php");
require_once(SITE."functions/attendance.php");
require_once(SITE."functions/employees.php");
$db =& $this->model->db;


$month_id 	= $params[2];
$role_id 	= $params[3];

$mc			= getMonthCode($db,$month_id);
$mc			= strtolower($mc);

$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
$fields = " ats.*,";
$data['emps'] 	  = employees($db,$dbg,$fields,$filter);

$data['attendances'] = array();
$i=0;

if($month_id < $_SESSION['settings']['month_start']){ $year = $sy+1; }

foreach($data['emps'] AS $row){

	$data['attendances'][$i]['ecid'] 	= $row['ecid'];	
	$data['attendances'][$i][$mc.'_days_present'] = talpre($db,$dbg,$row['ecid'],$year,$month_id,$emps=true);	
	$data['attendances'][$i][$mc.'_days_tardy']   = taltar($db,$dbg,$row['ecid'],$year,$month_id,$row['timein'],$row['timeout']);	
	$data['attendances'][$i][$mc.'_minutes_tardy']   = talmin($db,$dbg,$row['ecid'],$year,$month_id,$row['timein'],$row['timeout']);	

	$i++;	
}	/* fxn */


$q = "";
foreach($data['attendances'] AS $row){
	$q .= " UPDATE {$dbg}.06_attendance_employees SET `".$mc."_days_present` = '".$row[$mc.'_days_present']."',
			`".$mc."_days_tardy` = '".$row[$mc.'_days_tardy']."',
			`".$mc."_minutes_tardy` = '".$row[$mc.'_minutes_tardy']."'
			WHERE `ecid` = '".$row['ecid']."' LIMIT 1; ";
			
}

// pr($q); exit;

	$this->model->db->query($q);
	
	$url = "mis/attemps/$role_id/$sy/$qtr";
	// pr($q); pr($url); exit;
	
	redirect($url);

}	/* fxn */


public function dailyAttemps($params){
	$dbo=PDBO;
	$role_id		= $params[0];	
	$date			= $params[1];	
	$sy	= $data['sy'] = $_SESSION['sy'];
	$data['role_id'] = $role_id;
	$dbg = PDBG;
	
/* --------------------------------------------------------------------------	 */	
	$role = ($role_id>0)? "c.`role_id` = '$role_id'" : ' c.`role_id` <> 1 ';

	$q = "
		SELECT			
			c.id AS cid,c.code,c.name AS employee,al.timein,al.timeout
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN (
				SELECT * FROM {$dbg}.06_attendance_employees_logs WHERE `date` = '$date'			
			) AS al	ON al.contact_id = c.id		
		WHERE 	
				$role
			AND  c.`is_active` 	 	= '1'				
			AND  c.`id` 	 	= c.parent_id							
			AND  c.`id` 	 		<> '1'							
		GROUP BY c.`id`
		ORDER BY c.`name` 		
	"; 
 
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['attendances'] 		= $sth->fetchAll();
	$data['num_attendances']	= count($data['attendances']);
	$data['date']				= $date;
	
	$this->view->render($data,'mis/dailyAttemps');
	
}



public function getDeptConducts($dbg,$dept,$sy,$limit,$offset){
$dbo=PDBO;
$q = "
		SELECT 
			crs.id AS course_id,crs.name AS course,
			c.id AS scid,c.code AS student_code,c.name AS student,		
			g.id AS gid,g.q1,g.q2,g.q3,g.q4,g.q5,			
			g.dg1,g.dg2,g.dg3,g.dg4,g.dg5,
			sum.id AS sumid,sum.conduct_q1,sum.conduct_q2,sum.conduct_q3,sum.conduct_q4,sum.conduct_q5,
			sum.conduct_dg1,sum.conduct_dg2,sum.conduct_dg3,sum.conduct_dg4,sum.conduct_dg5 						
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON s.crid = cr.id
			INNER JOIN {$dbg}.05_courses AS crs ON (
					crs.crid 	= cr.id
				AND	g.course_id 		= crs.id				
			)
			INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id						
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid  = g.scid						
		WHERE 
				l.department_id 	= '$dept'
			AND crs.crstype_id 	= '5'
		ORDER BY c.name
		LIMIT $limit OFFSET $offset
";

	// pr($q);
	$sth = $this->model->db->querysoc($q);
	return $sth->fetchAll();
}


public function dgconductsForm(){
$dbo=PDBO;
if(isset($_POST['submit'])){
	$url = 'mis/dgconducts/'.$_POST['dept'].DS.$_POST['sy'].DS.$_POST['qtr'].DS.$_POST['limit'].DS.$_POST['offset'];
	// pr($url);
	redirect($url);
}

$data['sy'] 	= $_SESSION['sy'];
$data['qtr'] 	= $_SESSION['qtr'];

$this->view->render($data,'mis/dgconductsForm');

}	/* fxn */



public function dgacadForm(){
$dbo=PDBO;
$dbg = PDBG;

if(isset($_POST['submit'])){
	$url = 'mis/dgacad/'.$_POST['dept'].DS.$_POST['sy'].DS.$_POST['qtr'].DS.$_POST['limit'].DS.$_POST['offset'].DS.$_POST['subjid'];
	// pr($url);
	redirect($url);
}

$data['sy'] 	= $_SESSION['sy'];
$data['qtr'] 	= $_SESSION['qtr'];
$data['subjects']	= $this->model->fetchRows("{$dbo}.`05_subjects`");


$this->view->render($data,'mis/dgacadForm');

}	/* fxn */




public function dgtraitsForm($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['submit'])){
	$url = 'mis/dgtraits/'.$_POST['sy'].DS.$_POST['qtr'].DS.$_POST['is_trait'].DS.$_POST['crid'];
	// pr($url);
	redirect($url);
}

$data['sy'] 	= $_SESSION['sy'];
$data['qtr'] 	= $_SESSION['qtr'];
$data['classrooms']		= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");

$this->view->render($data,'mis/dgtraitsForm');

}	/* fxn */



private function getCourseByClassroom($dbg,$crid,$ctype){
$dbo=PDBO;
$q = " 
	SELECT 
		crs.id AS course_id,crs.name AS course,crs.*,
		cty.is_acad,cty.is_trait,cty.is_club,cty.is_psmapeh,cty.is_conduct,cty.is_cocurr,cty.is_elective,
		sub.id AS subject_id,sub.code AS subject_code,sub.name AS subject,
		tc.id AS tcid,tc.code AS teacher_code,tc.name AS teacher,
		sub.id AS subject_id,sub.code AS subject_code,sub.name AS subject,
		supsub.name AS subsubject,
		cr.level_id,cr.section_id,l.name AS level,sec.name AS section,
		l.department_id,l.is_k12,l.is_ps,l.is_gs,l.is_hs,l.with_conduct_dg,
		cq.is_finalized_q1,cq.is_finalized_q2,cq.is_finalized_q3,cq.is_finalized_q4  			
	FROM {$dbg}.05_courses AS crs 
		LEFT JOIN  {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
		LEFT JOIN {$dbo}.`05_subjects` AS supsub ON crs.supsubject_id = supsub.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id
		LEFT JOIN {$dbo}.`00_contacts` AS tc ON crs.tcid = tc.id
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id = crs.id
		LEFT JOIN {$dbo}.`05_crstypes` AS cty ON crs.crstype_id = cty.id	
	WHERE 
			crs.`crid` 	 = '$crid' 
		AND	crs.`crstype_id` = '$ctype'
	LIMIT 1;
";

$sth = $this->model->db->querysoc($q);
return $sth->fetch();

}	/* fxn */


/* direct to grades with criteria_id,no more activities nor scores */
public function dgtraits($params){	
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	include_once(SITE.'views/elements/params_sq.php');
	require_once(SITE."functions/criteria.php");
	require_once(SITE."functions/tpgfxn.php");
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/grades.php");
	require_once(SITE."functions/traits.php");
	require_once(SITE."functions/classifications.php");
	$db =& $this->model->db;

	$data['is_trait'] 	= $is_trait 	= $params[2];
	$data['crid']		= $crid			= $params[3];
		
	$ctype = ($is_trait)? '2' : '4';	/* traits or psmapeh */
	$course 		 = $data['course'] = $this->getCourseByClassroom($dbg,$crid,$ctype);	
	$data['course_id']	 = $course_id			= $course['course_id'];
			
	/* controller - teachers or else */
	$data['home']	=	$home = $_SESSION['home']; 			
		
	/* ==================== PROCESS1==================== */
	$course = $data['course'] = getCourseDetails($db,$course_id,$dbg);
	// pr($course); exit;
	$_SESSION['course'] = $data['course'];		
	
	
	/* summaries.quarter & grades */
	if(isset($_POST['tally'])){		
		
		$students	= $_POST['students'];
		$grades 	= $_POST['grades'];		
		$numcri		= $_POST['data']['numcri'];		
		$qtr 		= $_POST['data']['qtr'];				
		$qqtr 		= $_POST['data']['qqtr'];		
		$dgqtr 		= isset($_POST['data']['dgqtr'])? $_POST['data']['dgqtr'] : null;		
		$course_id  = $_POST['data']['course_id'];				
		$flrgr 		= $_POST['data']['flrgr'];		

		/* 1 - for grades - qtr grade */
		$q = "";
		foreach($grades AS $grade){		
			foreach($grade AS $row){
				if($row['grd'] < $flrgr) {  $row['grd'] = $flrgr; }			
				$q .= " UPDATE {$dbg}.50_grades set `$qqtr` = '".$row['grd']."'  ";			
				$q .= " WHERE `id` = '".$row['gid']."' LIMIT 1; ";			
			}
		}		
		// pr($q); exit;
		$this->model->db->query($q);				
		// pr($q); 
				
		/* 2 - update grades final or fg  */
		$expr = 'q1';
		for($i=2;$i<=$qtr;$i++){ $expr .= "+q$i"; }		
		$q = "";		
		foreach($grades AS $grade){		
			foreach($grade AS $row){						
				$q .= "
					UPDATE {$dbg}.50_grades AS a
						INNER JOIN (
							SELECT `id`,SUM($expr)/$qtr AS `fg` FROM {$dbg}.50_grades where id = '".$row['gid']."' 	
						) AS b ON b.id = a.id
					SET a.final = b.fg
					WHERE a.id = '".$row['gid']."';			
				";
			}
		}		
		$this->model->db->query($q);				
		// pr($q);
		
if($course['is_trait']==1):		
		/* 3 - summaries cq */
		$q = "";
		$i = 0;
		foreach($grades AS $grade){		
			$total = 0;
			foreach($grade AS $row){
				if($row['grd'] < $flrgr) {  $row['grd'] = $flrgr; }						
				$total += $row['grd'];
			}
			$fg = $total/$numcri;
			$q .= " UPDATE {$dbg}.05_summaries SET `conduct_$qqtr` = '$fg' WHERE `scid` = '".$students[$i]['scid']."' LIMIT 1; ";
			$i++;
		}		
		$this->model->db->query($q);				
		// pr($q);
		
		// 4 - summaries cfg
		$expr = 'conduct_q1';
		for($i=2;$i<=$qtr;$i++){ $expr .= "+conduct_q$i"; }		
		$q = "";		
		foreach($students AS $row){		
			$q .= "
				UPDATE {$dbg}.05_summaries AS a
					INNER JOIN (
						SELECT `id`,SUM($expr)/$qtr AS `fg` FROM {$dbg}.05_summaries where id = '".$row['sumid']."' 	
					) AS b ON b.id = a.id
				SET a.conduct_q5 = b.fg
				WHERE a.id = '".$row['sumid']."';			
			";
			// echo "<br />";
		}		
		$this->model->db->query($q);				
		// pr($q); exit;
endif;	/* if course-is_traits */ 	


		$url 		= "mis/dgtraits/$sy/$qtr/$is_trait/$crid";		
		redirect($url);				
	}	/* post-update/refresh */ 

/* ----------------------------------------------------------------------------------------------------------------- */

	
	/* for grades dg and summaries.dg */
	if(isset($_POST['finalize'])){				
		$qtr 		= $_POST['data']['qtr'];				
		$qqtr 		= $_POST['data']['qqtr'];		
		$dgqtr 		= isset($_POST['data']['dgqtr'])? $_POST['data']['dgqtr'] : null;		
		$course_id  = $_POST['data']['course_id'];	

		// 5,6 - for grades dg  AND dgf
		$q = "";
		$grades 	= $_POST['grades'];
		foreach($grades AS $grade){
			foreach($grade AS $row){
				$q .= " UPDATE {$dbg}.50_grades set `$dgqtr` = '".$row['dg']."',`dg5` = '".$row['dgf']."'   ";			
				$q .= " WHERE `id` = '".$row['gid']."' LIMIT 1; ";
			}	
		}
		$this->model->db->query($q);				

if($course['is_trait']==1):		
		/* 7,8 - for summaries cdg and cdgf   */
		$q = "";
		$rows = $_POST['data']['Summary'];
		foreach($rows AS $row){
			$q .= " UPDATE {$dbg}.05_summaries set `conduct_$dgqtr` = '".$row['c'.$dgqtr]."',`conduct_dg5` = '".$row['dgf']."' ";			
			$q .= " WHERE `id` = '".$row['sumid']."' LIMIT 1; ";
		}		
		$this->model->db->query($q);				
		// pr($q); exit;
endif;		
		/* finalize */
		$url = 'mis/dgtraits/'.$sy.DS.$qtr.DS.$is_trait.DS.$crid;		
		
		// pr($url); exit;
		redirect($url);						
	}	 /* post-finalize */

/* ---------------------------------------------------------------- */	
	if(isset($_POST['lock'])){
		lockCourse($db,$course_id,$qtr,$dbg);
		$url 		= 'mis/dgtraits/'.$sy.DS.$qtr.DS.$is_trait.DS.$crid;				
		redirect($url);						
	}
	
	
	/* ==================== PROCESS2==================== */
	
	$crsClass	= classifyCourse($course);
	$data['ratings'] = getRatings($db,$crsClass['type_id'],$crsClass['dept_id']);		
						
	$data['is_locked'] = $course['is_finalized_q'.$qtr];
	$data['criteria'] = getTraitsCriteria($db,$course_id);
	$data['num_criteria'] = count($data['criteria']);
	
	
	$fields = " sum.conduct_q1 AS cq1,sum.conduct_q2 AS cq2,sum.conduct_q3 AS cq3,sum.conduct_q4 AS cq4,sum.conduct_q5 AS cfg,";	
	$data['students'] = $students	=  classyear($db,$dbg,$sy,$crid,$male=2,$order="c.`is_male` DESC,c.`name`",$fields);		
	$data['num_students']	=	count($data['students']);
	
if($course['is_trait']){
	for($i=0;$i<$data['num_students'];$i++){ $data['scores'][$i] = getStudentTraits($db,$dbg,$sy,$students[$i]['scid']); }		
} else {
	for($i=0;$i<$data['num_students'];$i++){ $data['scores'][$i] = getStudentPsmapehs($db,$dbg,$sy,$students[$i]['scid']); }			
}
				
$data['ix'] = tpgfxn($db,$dbg,$course['level_id'],$course['crid'],$course['course_id'],$sy,$qtr);		
$this->view->render($data,'mis/dgtraits');				
	
}	/* fxn - dgtraits */


/* direct to grades with criteria_id,no more activities nor scores */
public function dgconducts($params){	
	$dbo=PDBO;
	require_once(SITE."functions/locks.php");
	require_once(SITE."functions/reports.php");
	$db =& $this->model->db;

	$data['ssy']	= $ssy			= $_SESSION['sy'];
	$data['dept']	= $dept			= $params[0];
	$data['sy']		= $sy			= $params[1];
	$data['qtr'] 	= $qtr 			= $params[2];
	$data['limit'] 	= $limit 		= $params[3];
	$data['offset'] = $offset 		= $params[4];

	// $dbyr	= ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	/* refresh */
	if(isset($_POST['update'])){
		// pr($_POST);	 
		// exit;	
		$kpup		= isset($_POST['is_kpup'])? 1 : 0;
		$qqtr 		= $_POST['data']['qqtr'];				
		$rows 		= $_POST['data']['summary'];		
		$flrgr 		= $_POST['data']['flrgr'];		
		// pr($flrgr);
		// update summaries for each classroom student
		$q = "";
		foreach($rows AS $row){
			if($row['q'.$qtr] < $flrgr) {  $row['q'.$qtr] = $flrgr; }
			
			// update grades final or fg 
			$total = $row['q1'];
			for($i=2;$i<=$qtr;$i++){ $total += $row['q'.$i]; }		
			$fg = $total/$qtr;
		
			
			$q .= " 
				UPDATE {$dbg}.50_grades SET 
						`q$qtr` = '".$row['q'.$qtr]."',
						`q5` 	 = '".$fg."' 
				WHERE `id` = '".$row['gid']."' LIMIT 1; ";

				
			$q .= " UPDATE {$dbg}.05_summaries SET 
					`conduct_q$qtr` = '".$row['q'.$qtr]."',
					`conduct_q5` = '".$fg."'
				WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
		}
		
		
		$this->model->db->query($q);				
		// pr($q); exit;		
		$url = 'mis/dgconducts/'.$dept.DS.$sy.DS.$qtr.DS.$limit.DS.$offset;		
		redirect($url);				
	}	/* refresh */

	/* finalize */
	if(isset($_POST['finalize'])){
		// pr($_POST);		
		$kpup		= isset($_POST['is_kpup'])? 1 : 0;		
		$qqtr 		= $_POST['data']['qqtr'];				
		$rows 		= $_POST['data']['summary'];		
		$flrgr 		= $_POST['data']['flrgr'];		
		
		/* update summaries for each classroom student */
		$q = "";
		foreach($rows AS $row){
			if(!$kpup) { $row['dg'.$qtr] = 'F'; $row['dgf'] = 'F'; }		
			if($row['q'.$qtr] < $flrgr) {  $row['q'.$qtr] = $flrgr; }
			
			$q .= " 
				UPDATE {$dbg}.50_grades SET 
					`dg$qtr` = '".$row['dg'.$qtr]."',
					`crstype_id` = '5',					
					`dg5` 	 = '".$row['dgf']."' 
				WHERE `id` = '".$row['gid']."' LIMIT 1; ";
			
			$q .= " UPDATE {$dbg}.05_summaries SET 
					`conduct_dg$qtr` = '".$row['dg'.$qtr]."',
					`conduct_dg5`   = '".$row['dgf']."' 
				WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
		}
		
		$this->model->db->query($q);						
		// pr($q); exit;		
		
		$url = 'mis/dgconducts/'.$dept.DS.$sy.DS.$qtr.DS.$limit.DS.$offset;		
		redirect($url);				
	}	/* finalize */
	

	/* finalize */
	if(isset($_POST['lock'])){
		lockCourse($db,$course_id,$qtr,$dbg);			
		$url = 'teachers/conducts/'.$course_id.DS.$sy.DS.$qtr;		
		redirect($url);						
	}	/* post-lock */
	
/*  --------------------------------- process---------------------------------- */

	$data['ratings'] = getRatings($db,'5',$dept);			
	$data['conducts'] 	= $this->getDeptConducts($dbg,$dept,$sy,$limit,$offset);		/* limit 10 offset 10 */	
	$data['num_conducts'] = count($data['conducts']);		
	
	$this->view->render($data,'mis/dgconducts');
			

}	/* fxn - conduct */




public function dgacad($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/reports.php");
	$db =& $this->model->db;

	$data['ssy']	= $ssy			= $_SESSION['sy'];
	$data['dept']	= $dept			= $params[0];
	$data['sy']		= $sy			= $params[1];
	$data['qtr'] 	= $qtr 			= $params[2];
	$data['limit'] 	= $limit 		= $params[3];
	$data['offset'] = $offset 		= $params[4];
	$data['subjid']	= $subjid		= $params[5];

	// $dbyr	= ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;

if(isset($_POST['tally'])){	
	
	$rows = $_POST['grades'];
	$q = "";
	foreach($rows AS $row){
		$q .= " UPDATE {$dbg}.50_grades SET 
					`q1` = '".$row['q1']."',  
					`q2` = '".$row['q2']."',  
					`q3` = '".$row['q3']."',  
					`q4` = '".$row['q4']."',  
					`q5` = '".$row['q5']."' 
				WHERE `id` = '".$row['gid']."' LIMIT 1;								
			";
	}
	
	pr($q); exit;
	$this->model->db->query($q);
	
	$url = "mis/dgacad/$dept/$sy/$qtr/$limit/$offset/$subjid";
	redirect($url);	
	exit;
	
}


if(isset($_POST['submit'])){	// dg
	// pr($_POST);
	// exit;
	
	$rows = $_POST['grades'];
	$q = "";
	foreach($rows AS $row){
		$q .= " UPDATE {$dbg}.50_grades SET 
					`dg1` = '".$row['dg1']."',  
					`dg2` = '".$row['dg2']."',  
					`dg3` = '".$row['dg3']."',  
					`dg4` = '".$row['dg4']."',  
					`dg5` = '".$row['dgf']."'
				WHERE `id` = '".$row['gid']."' LIMIT 1;								
			";
	}
	
	// pr($q);
	$this->model->db->query($q);
	
	$url = "mis/dgacad/$dept/$sy/$qtr/$limit/$offset/$subjid";
	redirect($url);	
	exit;
	
}

$q = " 
		SELECT 
			crs.id AS course_id,crs.name AS course,
			c.id AS scid,c.code AS student_code,c.name AS student,		
			g.id AS gid,
			g.*
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON s.crid = cr.id
			INNER JOIN {$dbg}.05_courses AS crs ON (
					crs.crid 	= cr.id
				AND	g.course_id 		= crs.id				
			)
			INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id						
		WHERE 
				l.`department_id` 	= '$dept'
			AND crs.`subject_id` 	= '$subjid'
		ORDER BY c.name
		LIMIT $limit OFFSET $offset	

";	
$sth = $this->model->db->querysoc($q);

$data['grades'] =  $sth->fetchAll();
$data['num_grades'] = count($data['grades']);
$data['subject'] = getSubjectDetails($db,$subjid,$dbg);
$data['crstype'] = $crstype = $data['subject']['crstype_id'];


$data['department'] = $this->model->getDepartmentDetails($dept,$dbg);

$data['ratings'] = getRatings($db,$crstype,$dept,$dbg);			

$this->view->render($data,'mis/dgacad');


}	/* fxn */



public function xgetCountConductsByDept($params){
$dbo=PDBO;
$dept = $params[0];

$q = "
		SELECT 
			count(g.id) AS count
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON s.crid = cr.id
			INNER JOIN {$dbg}.05_courses AS crs ON (
					crs.crid 	= cr.id
				AND	g.course_id 		= crs.id				
			)
			INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id						
		WHERE 
				l.department_id 	= '$dept'
			AND crs.crstype_id 	= '5' ";

$sth = $this->model->db->querysoc($q);
// $_SESSION['q'] = $q;
$row = $sth->fetch();
echo json_encode($row);


}	/* fxn */



public function xgetCountCourseGradesByDept($params){
$dbo=PDBO;
$dept 	= $params[0];
$subjid = $params[1];
$ssy	= $_SESSION['sy'];
$sy 	= $params[2];

// $dbyr	= ($sy==$ssy)?'':$sy.US;
$dbyr 	= $sy.US;
$dbg	= VCPREFIX.$dbyr.DBG;

$q = "
		SELECT 
			count(g.id) AS count
		FROM {$dbg}.50_grades AS g
			INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON s.crid = cr.id
			INNER JOIN {$dbg}.05_courses AS crs ON (
					crs.crid 	= cr.id
				AND	g.course_id 		= crs.id				
			)
			INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id						
		WHERE 
				l.`department_id` 	= '$dept'
			AND crs.`subject_id` 	= '$subjid'
						
";

$sth = $this->model->db->querysoc($q);
// $_SESSION['q'] = $q;
$row = $sth->fetch();
echo json_encode($row);


}	/* fxn */


public function editStudentGradesForm(){
	$dbo=PDBO;
	if(isset($_POST['submit'])){
		pr($_POST);
		$crid = $_POST['crid'];
		$scid = $_POST['scid'];
		$sy = $_POST['sy']; 
		$qtr = $_POST['qtr'];
		$url = "mis/editStudentGrades/$crid/$scid/$sy/$qtr";
		pr($url); 
	
	}

	$this->view->render(NULL,'mis/editStudentGradesForm');
}

public function changePass($params){
	$dbo=PDBO;
	$login 	= $params[0];
	$ucid 	= $params[1];
	$srid = $_SESSION['user']['role_id'];
	if($srid != 5) { Session::set('message','Not Allowed.'); }
	if(isset($_POST['submit'])){
		$row = $_POST['data'];
		if($row['newpass'] === $row['newpass2']){
			$login    = strtoupper($row['login']);	
			$oldpass  = $row['oldpass'];	
			$newpass  = $row['newpass'];				
			$mdold	  = MD5($oldpass);
			$mdnew	  = MD5($newpass);						
			
			$q  = " UPDATE {$dbo}.`00_contacts` SET `pass` = '$mdnew',`account` = '$login' WHERE `id` = '$ucid' LIMIT 1; ";
			$q .= " UPDATE {$dbo}.`00_ctp` SET `ctp` = '$newpass' WHERE `contact_id` = '$ucid' LIMIT 1; ";
												
			$this->model->db->query($q);										
		} 
		redirect('mis');
		
	}	// post-submit

	$data['login'] =  $login;
	$this->view->render($data,'users/securePassword');


}


public function purge($params){		/* eradicate */
$dbo=PDBO;
require_once('functions/purge.php');
$scid 	=$params[0];
$sy=isset($params[1])? $params[1]:DBYR;
$db =& $this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

purge($db,$dbg,$scid);	
$url = 'purge';
flashRedirect($url,'New Purged '.$scid.' '.$user['name']);

}		/* fxn */


public function initGIS(){		
	// make this sync instead of delete-init
	$dbo=PDBO;
	$dbg = PDBG;
		
	if(isset($_POST['init'])){
		$data['message'] = "";
		
		$sy = $_POST['sy'];
		$q = " SELECT c.id,s.crid AS crid,cr.acid 
			FROM {$dbo}.`00_contacts` AS c
				INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
				INNER JOIN {$dbg}.05_classrooms AS cr ON s.crid = cr.id
				INNER JOIN {$dbo}.`00_contacts` AS advi ON cr.acid = advi.id; ";
		$sth = $this->model->db->querysoc($q);
		$rows = $sth->fetchAll();
		
		// pr($rows);
			
		// 1
		$q = " INSERT INTO {$dbg}.05_attendance (`scid`) VALUES ";
		foreach($rows AS $row){ $q .= " ('".$row['id']."'),"; }
		$q = rtrim($q,",");
		$q .= "; ";		
		pr($q);
		exit;
		
		// $r = $this->model->db->query($q);		
		// $data['message'] .= ($r)? "Att init success" : "Att init failure";
		// $data['message'] .= "<br />";

		
		// 2 - summaries
		$q = " INSERT INTO {$dbg}.05_summaries (`scid`,`crid`,`acid`) VALUES ";
		foreach($rows AS $row){ $q .= " ('".$row['id']."','".$row['crid']."','".$row['acid']."'),"; }
		$q = rtrim($q,",");
		$q .= "; ";		
		// pr($q);
		
		// $r = $this->model->db->query($q);		
		// $data['message'] .= ($r)? "Summaries init success" : "Summaries init failure";
		// $data['message'] .= "<br />";
		
		// 3 - promotions
		$q = " SELECT id FROM {$dbg}.05_classrooms ORDER BY id LIMIT 5;  ";
		$sth = $this->model->db->querysoc($q);
		$classrooms = $sth->fetchAll();
		
		$q = " DELETE FROM {$dbg}.05_promotions WHERE sy = '$sy'; ";
		
		$q .= " INSERT INTO {$dbg}.05_promotions (`crid`) VALUES ";
		foreach($classrooms AS $row){ $q .= " ('".$row['id']."'),"; }
		$q = rtrim($q,",");
		$q .= "; ";		
		
		// pr($q);
		// $r = $this->model->db->query($q);		
		$data['message'] .= ($r)? "Promotions init success" : "Promotions init  failure";
		$data['message'] .= "<br />";
		$_SESSION['message'] = $data['message'];
		
		exit;
		redirect('mis/setup');
	
	}	/* post-init */

	$this->view->render(null,'mis/initGIS');

}	/* fxn */




public function itypes($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['add'])){
	$year = date('Y');
	$q = "INSERT INTO {$dbg}.itypes (`code`,`name`) VALUES ";

	$rows = $_POST['itypes'];
	foreach($rows AS $row){			
	  $q .= " ('".$row['code']."','".$row['name']."'),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
	
	// pr($q); exit;
	
	$this->model->db->query($q);
	$url = "mis/itypes";
	redirect($url);		
	exit;
}	/* post-add */

$q = " SELECT * FROM {$dbg}.itypes;";
$sth = $this->model->db->querysoc($q);
$data['itypes'] = $sth->fetchAll();
$data['num_itypes']	= count($data['itypes']);

$this->view->render($data,'mis/itypes');

}	/* fxn */

public function icategories($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['add'])){
	$q = "INSERT INTO {$dbg}.icategories(`code`,`name`) VALUES ";

	$rows = $_POST['icategories'];
	foreach($rows AS $row){			
	  $q .= " ('".$row['code']."','".$row['name']."'),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
	
	// pr($q); exit;
	
	$this->model->db->query($q);
	$url = "mis/icategories";
	redirect($url);		
	exit;
}	/* post-add */

$q = " SELECT * FROM {$dbg}.icategories;";
$sth = $this->model->db->querysoc($q);
$data['icategories'] 	  = $sth->fetchAll();
$data['num_icategories']  = count($data['icategories']);

$this->view->render($data,'mis/icategories');

}	/* fxn */


public function icriteria($params=NULL){
$dbo=PDBO;
$data['icategory_id'] = $icategory_id = isset($params[0])? $params[0] : 0;

$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

$data['home']	= $home			= $_SESSION['home'];
// $dbyr	= ($sy==$ssy)? '':$sy.US;
$dbyr 	= $sy.US;
$dbg = VCPREFIX.$dbyr.DBG; 
$dbg = VCPREFIX.$dbyr.DBG; 


if(isset($_POST['add'])){
	$q = "INSERT INTO {$dbg}.icriteria(`icategory_id`,`name`) VALUES ";

	$rows = $_POST['icriteria'];
	foreach($rows AS $row){			
	  $q .= " ('".$icategory_id."','".$row['name']."'),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
		
	$this->model->db->query($q);
	$url = "mis/icriteria/".$icategory_id.DS.$sy;
	redirect($url);		
	exit;
}	/* post-add */

/*--------------------------- process ------------------------------------------------------------------*/
$q = " SELECT icat.name AS icategory,icri.* 
	FROM {$dbg}.`icriteria` AS `icri`
		LEFT JOIN {$dbg}.icategories AS icat ON icri.icategory_id = icat.id
";
if($icategory_id != 0){ $q .= " WHERE icri.`icategory_id` = '$icategory_id'; "; }
$q .= " ORDER BY icat.`name`  ";
// pr($q);
$sth = $this->model->db->querysoc($q);
$data['icriteria'] 	  	 = $sth->fetchAll();
$data['num_icriteria'] 	 = count($data['icriteria']);

$this->view->render($data,'mis/icriteria');

}	/* fxn */




public function icomponents($params){
$dbo=PDBO;
$data['itype_id'] = $itype_id	= $params[0];

$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

$data['home']	= $home			= $_SESSION['home'];
// $dbyr	= ($sy==$ssy)? '':$sy.US;
$dbyr 	= $sy.US;
$dbg = VCPREFIX.$dbyr.DBG; 
$dbg = VCPREFIX.$dbyr.DBG; 

if(isset($_POST['add'])){
	$q = "INSERT INTO {$dbg}.icomponents(`is_active`,`itype_id`,`icriteria_id`,`max`,`weight`) VALUES ";

	$rows = $_POST['icomponents'];
	foreach($rows AS $row){			
	  $q .= " ('1','".$itype_id."','".$row['icriteria_id']."','".$row['max']."','".$row['weight']."' ),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
	
	// pr($q); exit;
	
	$this->model->db->query($q);
	$url = "mis/icomponents/".$itype_id;
	redirect($url);		
	exit;
}	/* post-add */


if(isset($_POST['saveit'])){
	$row = $_POST['itype'];
	$this->model->db->update("{$dbg}.itypes",$row," `id` = '$itype_id'  ");
	$url = "mis/icomponents/".$itype_id;
	redirect($url);		
	exit;
}	/* post */

/* 1 - itype or sales */
$q = " SELECT * FROM {$dbg}.`itypes` WHERE `id` = '$itype_id' LIMIT 1; ";
$sth = $this->model->db->querysoc($q);
$data['itype'] = $sth->fetch();

/* 2 - icomponents or items */
$q = " SELECT 
			icri.name AS icriteria,
			icat.code AS icategory_code,icat.name AS icategory,
			icomp.*
		FROM {$dbg}.icomponents AS icomp
			LEFT JOIN {$dbg}.icriteria AS icri ON icomp.icriteria_id = icri.id
			LEFT JOIN {$dbg}.icategories AS icat ON icri.icategory_id = icat.id
		WHERE icomp.`itype_id` = '$itype_id'
";

// pr($q);
$sth = $this->model->db->querysoc($q);
$data['icomponents'] 	  = $sth->fetchAll();
$data['num_icomponents']  = count($data['icomponents']);

$data['icriterias'] = $this->model->fetchRows("{$dbg}.icriteria");

$this->view->render($data,'mis/icomponents');


}	/* fxn */



public function editIcomponent($params){
$dbo=PDBO;
$icompid = $params[0];
$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

$data['home']	= $home			= $_SESSION['home'];
// $dbyr	= ($sy==$ssy)? '':$sy.US;
$dbyr 	= $sy.US;
$dbg = VCPREFIX.$dbyr.DBG; 
$dbg = VCPREFIX.$dbyr.DBG; 

$data['icomponent'] = $icomponent = $this->model->fetchRow("{$dbg}.icomponents",$icompid);

if(isset($_POST['submit'])){
	$row = $_POST['icomp'];   
	$this->model->db->update("{$dbg}.icomponents",$row," `id` = '$icompid' ");  
	$url = "mis/icomponents/".$icomponent['itype_id'];
	redirect($url);

	// $this->model->db->update("{$dbg}.itypes",$row," `id` = '$itype_id' ");  

}	/* post */


$data['icriteria']  = $this->model->fetchRows("{$dbg}.icriteria");


$this->view->render($data,'mis/editIcomponent');


}	/* fxn */




/* for mis-dbpanel */
public function xgetLastID(){
$dbo=PDBO;
$dbtbl = $_POST['dbtbl'];

$q = " SELECT  max(id) AS `numrows` FROM $dbtbl ;";
$sth = $this->model->db->querysoc($q);
$_SESSION['q'] = $q;
$row = $sth->fetch();
echo json_encode($row);


}	/* fxn */

/* for mis-dbpanel */
public function xcount(){
$dbo=PDBO;
$dbtbl = $_POST['dbtbl'];

$q = " SELECT  count(id) AS `numrows` FROM $dbtbl ;";
$sth = $this->model->db->querysoc($q);
$_SESSION['q'] = $q;
$row = $sth->fetch();
echo json_encode($row);


}	/* fxn */


/* for dbpanel & dbsetup  */
public function dbselects(){
	$dbo=PDBO;
	$q		= "SHOW DATABASES; ";
	$sth	= $this->model->db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */




public function tableBackup($params){
$dbo=PDBO;
$dbone = $params[0];	/* from */
$dbtwo = $params[1];	/* to */
$table = $params[2];

$user = $_SESSION['user'];
$urid = $user['role_id'];
$upid = $user['privilege_id'];

// pr($user);

if($urid!=RMIS){ $this->flashRedirect('index','MIS Only.'); }

$q = " INSERT ".$dbtwo.".`".$table."` SELECT * FROM ".$dbone.".`".$table."` ;";
$this->model->db->query($q);


$_SESSION['mis'][$dbtwo]['counts'][$table] = $this->tableCount("$dbtwo.$table");

$url = $_SERVER['HTTP_REFERER'];
redirectUrl($url);


}	/* fxn */


public function dbswitch($params=NULL){
$dbo=PDBO;
$file = SITE."config/Paths.php";

$data['paths'] = file_get_contents($file);

$this->view->render($data,"mis/dbswitch");

}	/* fxn */


public function fileder(){


$data = NULL;

$this->view->render($data,"mis/fileder");


}




public function syncToSummaries($params){
$dbo=PDBO;
$scid 	= $params[0];
$sy 	= $params[1];
echo 'exit';
exit;
$q = " INSERT INTO aaa.05_summaries (`scid`) VALUES ('$scid'); ";
$this->model->db->querysoc($q);
$url = "mis/tab";
redirect($url);

}	/* fxn */



public function tab($params=NULL){
$dbo=PDBO;
$crid = isset($params[0])? $params[0] : '1';
/* 
aaa.students - id,crid,name
aaa.05_summaries - id,crid,scid,sy
 */

$data['ssy'] = $_SESSION['sy'];

$q = "
	select c.*,s.*,p.*,sum.*,sum.id AS sumid,s.id AS scid,s.crid,sum.scid AS sumscid,p.scid AS pscid 
	from aaa.`00_contacts` AS c
		left join aaa.students AS s ON c.id = s.scid
		left join aaa.photos AS p ON c.id 	= p.scid
		left join aaa.05_summaries AS sum ON c.id = sum.scid
	where s.crid = $crid;
";

$sth = $this->model->db->querysoc($q);
$data['students'] 		= $students = $sth->fetchAll();
$data['num_students'] 	= count($students);

// pr($students);

foreach($students AS $row){
	// if(isset($row['sy']))

}

// exit;

$q = " select id AS scid FROM aaa.students where crid = $crid;";
$sth = $this->model->db->querysoc($q);
$a = $sth->fetchAll();
pr($a);
$ar = buildArray($a,'scid');
pr($ar);

echo '<hr />';

$q = " select scid FROM aaa.05_summaries where crid = $crid;";
$sth = $this->model->db->querysoc($q);
$b = $sth->fetchAll();
pr($b);
$br = buildArray($b,'scid');
pr($br);

echo "<hr />";
$xr = array_diff($ar,$br);
pr($xr);

// exit;


$this->view->render($data,'mis/tab');

}


/* backup db at year-end */
public function dbpanel($params=NULL){
$dbo=PDBO;
$data['db']		= $db 	= isset($params[0])? $params[0] : "dbgis_".VCFOLDER;
$data['home'] 	= $home = $_SESSION['home'];
$data['sy']		= $sy	= $_SESSION['sy'];

if(isset($_POST['submit'])){
// pr($_POST);
$counts = $_POST['counts'];
$lasts  = $_POST['lasts'];

foreach($lasts  AS $k => $v){ $_SESSION['mis'][$db]['lasts'][$k] = $v; }
foreach($counts AS $k => $v){ $_SESSION['mis'][$db]['counts'][$k] = $v; }
$_SESSION['mis'][$db]['sessionized'] = true; 

$url = "mis/dbpanel/$db";
redirect($url);


}	/* post */



$q = " SHOW tables FROM $db; ";
$sth = $this->model->db->query($q);
if(!$sth){ redirect('mis/dbsetup'); }
$sth->setFetchMode(PDO::FETCH_ASSOC);
$rows = $sth->fetchAll();
$data['num_tables'] = $num_tables	= count($rows);

for($i=0;$i<$num_tables;$i++){ $data['tables'][$i]['table'] = $rows[$i]['Tables_in_'.$db];  }

$databases				= $this->dbselects();
$data['num_databases']	= $num_databases	= count($databases);
for($i=0;$i<$num_databases;$i++){ $data['databases'][$i] = $databases[$i]['Database'];  }


$this->view->render($data,'mis/dbpanel');


}	/* fxn */



public function dbx($params=NULL){ 	/* dbschema */
$dbo=PDBO;
$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['x']		= $x	= isset($params[0])? $params[0]:'m';
$data['dbtype'] = $dbtype = ($x=='m')? 'dbmaster':'dbgis';
$data['sy'] 	= $sy 	  = isset($params[1])? $params[1]:$ssy;
$data['current'] = $current = ($sy==$ssy)? true:false;

// $dbyr = ($current)? '':$sy.US;
$dbyr 	= $sy.US;
$data['db'] = $db = $dbyr.$dbtype.US.VCFOLDER;
// pr($db);


$q = " SHOW tables FROM $db; ";
$sth = $this->model->db->query($q);
if(!$sth){ redirect('mis/dbsetup'); }
$sth->setFetchMode(PDO::FETCH_ASSOC);
$rows = $sth->fetchAll();
$data['num_tables'] = $num_tables	= count($rows);

for($i=0;$i<$num_tables;$i++){ $data['tables'][$i]['table'] = $rows[$i]['Tables_in_'.$db];  }

$databases				= $this->dbselects();
$data['num_databases']	= $num_databases	= count($databases);
for($i=0;$i<$num_databases;$i++){ $data['databases'][$i] = $databases[$i]['Database'];  }


$this->view->render($data,'mis/dbpanel');


}



public function syncSyScid($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');

	/* 1 */
	$q = " SELECT sum.`scid` AS `scid` 
			FROM  {$dbg}.05_summaries AS sum
				LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
			WHERE c.`is_active` = '1'
			ORDER BY c.id;								
	";
	// pr($q);
	$sth	= $this->model->db->querysoc($q);
	$a		= $sth->fetchAll();
	$ar 	= buildArray($a,'scid');
		
	/* 2 */
	$q = " 
		SELECT ss.scid		
		FROM {$dbo}.sy_scid AS ss 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON ss.scid = c.id
		WHERE 	c.is_active = '1'
			AND ss.sy = '$sy' 
		ORDER BY c.id; ";

	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'scid');

	/* 3 */
	$ix = array_diff($ar,$br);
	
	/* 1 - insert summaries - scid,sy */
	$q = " INSERT INTO {$dbo}.sy_scid(`sy`,`scid`) VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$sy','$scid'),"; }
	$q = rtrim($q,",");
	$q .= "; ";	
	
	// pr($q);
	$this->model->db->query($q);
	redirect('mis/setup/'.$sy);
	
	
}



public function editClassroom($params){
$dbo=PDBO;
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['crid']	= $crid	= $params[0];
$data['sy'] 	= $sy	= isset($params[1])? $params[1]:$ssy;

// $dbyr	= ($sy==$ssy)? '':$sy.US;
$dbyr 	= $sy.US;
$dbg	= VCPREFIX.$dbyr.DBG;
$dbg	= VCPREFIX.$dbyr.DBG;

$data['classroom']	= $classroom	= getClassroomDetails($db,$crid,$dbg);

if(isset($_POST['submit'])){
	// pr($_POST);exit;
	unset($_POST['submit']);
	$row = $_POST;
	$this->model->db->update("{$dbg}.05_classrooms",$row," `id` = '$crid'  ");
	$url	= "mis/classrooms/".$classroom['level_id'].DS.$sy;
	redirect($url);
}	/* post */


$data['is_active']		= $classroom['is_active'];
$data['levels']			= $this->model->fetchRows("{$dbo}.`05_levels`","*","id");
$data['sections']		= $this->model->fetchRows("{$dbo}.`05_sections`","*","code");
$data['departments']	= $this->model->fetchRows("".PDBO.".`05_departments`");	

$this->view->render($data,'classrooms/edit');


}	/* fxn */



public function syncCalendar($params=NULL){
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');
$dbg=PDBG;

$ar 	= $this->model->getCalendarDays($sy);
$br		= $this->model->getCalendarDaysDB($dbg);
$ix 	= array_diff($ar,$br);
  
$this->model->cleanCalendar($dbg,$ar,$br);

$q = "INSERT INTO {$dbg}.05_calendar(`date`) VALUES ";
foreach($ix AS $date){
	$q .= "('$date'),";
}
$q = rtrim($q,",");
$q .= ";";
// pr($q);
$this->model->db->query($q);
$url = "mis/calendar/$sy/";
flashRedirect($url,'Calendar initialized.');

}	/* fxn */


public function calendar($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/times.php");
$db =& $this->model->db;

$data['ssy']	= $ssy		= $_SESSION['sy'];
$data['sy']		= $sy		= isset($params[0])? $params[0]:$ssy;
$data['moid']	= $moid		= isset($params[1])? $params[1]:$ssy;
$data['dbm']	= $dbg	= ($sy==$ssy)? PDBG:VCPREFIX.$sy.US.DBG;

$data['month']	= $month	= getMonth($db,$moid,$code=false,$dbg);

if(isset($_POST['submit'])){
	$pdays = $_POST['days'];
	$q = "";
	foreach($pdays AS $row){
		$q .= " 
			UPDATE {$dbg}.05_calendar SET 
				`is_included` 			= '".$row['is_included']."',
				`is_included_employees` = '".$row['is_included_employees']."'
			WHERE `id` = '".$row['id']."' LIMIT 1;			
		";
	}
	$this->model->db->query($q);
	$url = "mis/calendar/$sy/$moid";
	flashRedirect($url,'Calendar days updated.');
		
}	/* post */


$q 		= " SELECT * FROM {$dbg}.05_calendar WHERE month(`date`) = '$moid' ORDER BY `date`; ";
$sth	= $this->model->db->querysoc($q);
$data['days'] 		= $sth->fetchAll();
$data['num_days']	= count($data['days']);

$data['months']	= $this->model->fetchRows("".PDBO.".months","*","id");

$this->view->render($data,'misc/calendar');

}	/* fxn */


public function initClassrooms($params=NULL){
$dbo=PDBO;
$ssy = $_SESSION['sy'];
$dbg = PDBG;
$q = " UPDATE {$dbg}.05_classrooms SET `is_init_grades` = '0', `init_grades_sy` = '$ssy'; ";
$this->model->db->query($q);
redirect('mis/setup/'.$ssy);

}	/* fxn */


public function editCode($params=NULL){
$dbo=PDBO;
$data['home']	= $home	= $_SESSION['home'];
$user = $_SESSION['user'];
$suid = $_SESSION['suid'];
$data['ucid']	= $ucid = isset($params[0])? $params[0]:$suid;

$q   = " 
	SELECT c.*,ctp.ctp,ctp.ctpb,pc.name AS parent
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
	WHERE c.`id` = '$ucid' LIMIT 1; 	
";
$sth = $this->model->db->query($q);
$data['contact'] = $sth->fetch(); 

if(isset($_POST['submit'])){
	$post = $_POST['contact'];
	$code = $post['code'];
	
	$q = " SELECT id FROM {$dbo}.`00_contacts` WHERE `code` = '$code' OR `account` = '$code' LIMIT 1 ; ";
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	$duplicate = (empty($row))? false:true;
	
	if($duplicate){
		$_SESSION['message'] = 'Update Failed! ID Number already taken.';			
	} else {
		$q = " 
			UPDATE {$dbo}.`00_contacts` SET 
				`code`		= '".$post['code']."',
				`account`	= '".$post['code']."',
				`name`		= '".$post['name']."'
			WHERE `id` = '".$post['id']."' LIMIT 1;
		";
		$this->model->db->query($q);
		$_SESSION['message'] = 'Update Success!';		
	}

	$url = "contacts/ucis/$ucid";
	redirect($url);
	 
 exit;

}	/* post */


$this->view->render($data,'mis/editCode');



}	/* fxn */


public function xverify($params){
$dbo=PDBO;
$dbtable = $params[0];
$field 	 = $params[1];
$value 	 = $params[2];

// $q = " SELECT `$field` FROM $dbtable WHERE `$field` = '$value' LIMIT 1; ";
$q = " SELECT * FROM $dbtable WHERE `$field` = '$value' LIMIT 1; ";
$s = $this->model->db->querysoc($q);
$row = $s->fetch();



$_SESSION['q'] = $q;
echo json_encode($row);

}	/* fxn */


public function deleteCourse($params){
	$dbo=PDBO;
	$course_id = $params[0];
	require_once(SITE."functions/setup.php");
	$db =& $this->model->db;
	delcrs($db,$course_id);
	$url = $_SESSION['url'];
	redirect($url);
	exit;

}	/* fxn */


public function editCourse($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$data['course_id']	= $course_id 	 = $params[0];
	$data['ssy']			= $ssy	= $_SESSION['sy'];
	$data['sy']				= $sy	= isset($params[1])? $params[1] : $ssy;	
	// $dbyr	= ($sy==$ssy)? '' : $sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
		
	if(isset($_POST['submit'])){
		$row = $_POST['course'];
				
		$q = "
			UPDATE {$dbg}.05_courses SET 			
			`name` = '".$row['name']."',
			`code` = '".$row['code']."',
			`label` = '".$row['label']."',
			`is_transmuted`  = '".$row['is_transmuted']."',
			`is_displayed` 	 = '".$row['is_displayed']."',
			`in_genave` 	 = '".$row['in_genave']."',
			`affects_ranking` = '".$row['affects_ranking']."',
			`with_scores` 	 = '".$row['with_scores']."',
			`is_kpup` 	 	 = '".$row['is_kpup']."',
			`is_active` 	 = '".$row['is_active']."',
			`is_aggregate` 	 = '".$row['is_aggregate']."',
			`crstype_id` = '".$row['crstype_id']."',
			`subject_id` 	 = '".$row['subject_id']."',
			`crid`   = '".$row['crid']."',
			`supsubject_id`  = '".$row['supsubject_id']."',
			`course_weight`  = '".$row['course_weight']."',
			`tcid` = '".$row['tcid']."',
			`position` 		 = '".$row['position']."',
			`semester` 		 = '".$row['semester']."',
			`is_num` 		 = '".$row['is_num']."',
			`schedule` 		 = '".$row['schedule']."'
		";
				
		$q .= " WHERE `id` = '".$row['course_id']."' LIMIT 1;  ";		
		
		// pr($q); exit;
				
		$this->model->db->query($q);
		$url = isset($_SESSION['url'])? $_SESSION['url']:'mis';
		redirect($url);
		exit;
	}	/* post */

/* ------------------------ process ---------------------------------------- */

	$data['course']		= getCourseDetails($db,$course_id,$dbg);	
	$data['teachers'] 	= $this->model->getContacts(RTEAC);	
	$data['coordinators'] 	= $this->model->getContacts(RACAD);	
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`",'id,name','name');	
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms",'id,name','level_id');	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`");	
	$_SESSION['url']		= "gset/courses/".$data['course']['level_id'];

	$this->view->render($data,'mis/editCourse');

}	/* fxn */



public function editLevel($params){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	$db =& $this->model->db;

	$data['level_id']		= $level_id	  = $params[0];
	$data['ssy']			= $ssy		  = $_SESSION['sy'];
	$data['sy']				= $sy		  = isset($params[1])? $params[1] : $ssy;	
	// $dbyr	= ($sy==$ssy)? '' : $sy.US;
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
		
	if(isset($_POST['submit'])){
		$row = $_POST['level'];
		$this->model->db->update("{$dbo}.`05_levels`",$row," `id` = '".$row['id']."' ");	
		// pr($row); exit;
				
		$this->model->db->query($q);
		$url = "mis/levels/$sy";
		redirect($url);
		exit;		
	} /* post */
	
/* ------------------------ process ---------------------------------------- */

	$data['level']		 = $level	= getLevelDetails($db,$level_id,$dbg);	
	$data['departments'] = $this->model->fetchRows(DBO.".`05_departments`",'*','id');	
	$data['ctypes'] 	 = $this->model->fetchRows("{$dbo}.`05_crstypes`",'*','id'," WHERE `id` = ".CTYPECONDUCT." OR `id` = ".CTYPETRAIT." " );	
	
	$this->view->render($data,'mis/editLevel');

}

public function ipconfig(){
	echo '<p><a href="index" >HOME</a></p>';
	$ip  = getHostByName(getHostName());
	$mac =false;
	$mac_string = shell_exec("ipconfig /all");
	$mac_array = explode(" ",$mac_string);
	$mac = $mac_array[3];
	echo("IP: ".$ip);	
	echo "<hr />"; 
	pr($mac_string);	
}	/* fxn */


public function terminals(){
$dbo=PDBO;
$q  	= " SELECT * FROM {$dbo}.terminals ORDER BY `group` ; ";
$sth 	= $this->model->db->querysoc($q);
$data['terminals'] = $sth->fetchAll();
$data['numrows'] = count($data['terminals']);

$this->view->render($data,'mis/terminals');


}


public function editTerminal($params=NULL){
$dbo=PDBO;
$tid = $params[0];

	if(isset($_POST['submit'])){
		$row = $_POST['terminal'];
		$this->model->db->update(DBO.".`terminals`",$row," `id` = '".$row['id']."' ");	
		// pr($row); exit;
				
		$this->model->db->query($q);
		$url = "mis/terminals";
		redirect($url);
		exit;		
	} /* post */


$q   = "SELECT * FROM {$dbo}.terminals WHERE `id` = '$tid'  LIMIT 1; ";
$sth = $this->model->db->querysoc($q); 
$data['terminal'] = $sth->fetch();


$this->view->render($data,'mis/editTerminal');

}



public function duplicates(){
$dbo=PDBO;
$data['duplicates'] = true;

$ssy = $_SESSION['sy'];
$sy  = isset($params[0])? $params[0]:$ssy;
$data['home']	= $_SESSION['home'];

if(isset($_POST['submit'])){
	// pr($_POST);
	
	$db 	= $_POST['db'];
	$table 	= $_POST['table'];
	$fields = $_POST['fields'];
	$group  = $_POST['group'];
	$order  = $_POST['order'];
	
	$q = " 
		SELECT $fields
		FROM {$db}.{$table}
		GROUP BY {$group}
		HAVING count({$group}) > 1	
		ORDER BY $order		
		;	
	";
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$rows = $sth->fetchAll(); 
	// pr($rows);
	// exit;
	$data['rows'] = $rows;
	$data['numrows'] = count($rows);

	$data['fields'] = $fields;
	$data['rfields'] = explode(',',$fields);
	$data['numfields'] = count($data['rfields']); 
	
	// pr($data);

}



$this->view->render($data,'mis/duplicates');

}	/* fxn */


public function dupliusers(){
	$dbo=PDBO;
	$data['duplicates'] = false;
	$fields = "id,code,name";
	$q = "
		SELECT $fields
		FROM {$dbo}.`00_contacts`
		WHERE (id=parent_id)
		GROUP BY code
		HAVING count(code) > 1	
		ORDER BY id		
		;	
	";
	// pr($q);

	$sth = $this->model->db->querysoc($q);
	$rows = $sth->fetchAll(); 
	// pr($rows);
	// exit;
	$data['rows'] = $rows;
	$data['numrows'] = count($rows);

	$data['fields'] = $fields;
	$data['rfields'] = explode(',',$fields);
	$data['numfields'] = count($data['rfields']); 

	$this->view->render($data,'mis/duplicates');


}	/* fxn */


public function usercon($params=NULL){
$dbo=PDBO;
$data['role_id'] = $role_id = isset($params[0])? $params[0]:RTEAC;

$q = "SELECT * FROM {$dbo}.`00_roles` WHERE `id` = $role_id LIMIT 1; ";
$s = $this->model->db->querysoc($q);
$data['role']	= $role = $s->fetch();


$q = " SELECT * FROM {$dbo}.`00_titles`; ";
$s = $this->model->db->querysoc($q);
$data['titles']	= $role = $s->fetchAll();




pr($data);

}	/* fxn */



 
public function editContacts($ids){
$dbg=PDBG;$dbo=PDBO;$db=&$this->baseModel->db;
require_once(SITE."functions/dbFxn.php");
if(isset($_POST['submit'])){
	$contacts 	= $_POST['contacts'];
	$profiles 	= $_POST['profiles'];
	$q = "";
	$i = 0;
	foreach($contacts AS $row){
		$row['account'] = $row['code'];
		$has_profile  = rowExists($db,"{$dbo}.`00_profiles`",$key="contact_id",$value=$row['id'],"id");

		if($has_profile){ $db->update("{$dbo}.`00_profiles`",$profiles[$i]," `contact_id` = '".$row['id']."' ");	
		} else { $profile['contact_id'] = $row['id']; $this->model->db->add("".PDBO.".`00_profiles`",$profiles[$i]); }

		$db->update("{$dbo}.`00_contacts`",$row," `id` = '".$row['id']."' ");	
		
		$i++;
	}
	// pr($q); exit;
	$this->model->db->query($q);
	$params = implode("/",$ids);
	$url = "mis/editContacts/$params";
	// pr($url);
	redirect($url);
	exit;
	
}	/* post-submit */


foreach($ids as $id){ $data['contacts'][] = $this->model->readContact($id); }			
$data['num_contacts']	= count($data['contacts']);
$data['departments']	= $this->model->fetchRows("".PDBO.".`05_departments`");
$data['titles']			= $this->model->fetchRows(DBO.".`00_titles`");


$this->view->render($data,'mis/editContacts');

} 	/* fxn */




public function membersByBatch($params=NULL){
$dbo=PDBO;
$circle_id = $params[0];

$q = " SELECT * FROM {$dbo}.rooms WHERE `id` = '$circle_id' LIMIT 1; ";
$sth = $this->model->db->querysoc($q);
$data['circle']	= $circle = $sth->fetch();


$this->view->render($data,'mis/membersByBatch');


}	/* fxn */



public function trunker($params=NULL){
$dbo=PDBO;
if(isset($_POST['submit'])){
	if($_POST['password']==HDPASS){
		$dbtable = $_POST['dbtable'];
		$q = " TRUNCATE TABLE $dbtable "; 
		$this->model->db->query($q);
		Session::set('message','Truncated '.$dbtable.'!');
	} else {
		Session::set('message','Password error!');
	}
	redirect('mis/trunker');
	exit;

}	/* post */

$data = NULL;
$this->view->render($data,'mis/trunker');


}	/* fxn */

/* 
switch($role_id){
	case 7:	$url = 'teachers'; 	 break;
	case 9: $url = 'registrars'; break;
 */

public function eraser($params=NULL){
	$dbo=PDBO;
	// pr($params);
	switch($params[0]){
		case 'dbm': $dbr = 'dbmaster'; break;
		case 'dbo': $dbr = 'dbone'; break;
		default: $dbr = 'dbgis'; break;		
	}
	$table  = $params[1];
	$id 	= $params[2];

	$ssy 	= $_SESSION['sy'];
	$sy	 	= isset($params[3])? $params[3]:$ssy;
	
	// $dbyr 	= ($sy==$ssy)? '':$sy.US;
	$dbyr 	= $sy.US;
	$db 	= VCPREFIX.$dbyr.$dbr.US.VCFOLDER;
	
	$q = " DELETE FROM {$db}.{$table} WHERE id = $id LIMIT 1; ";	
	$this->model->db->query($q);
	$_SESSION['q'] = $q;
	Session::set('message','Deleted successfully!');
	$url = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:URL.'mis';
	redirectUrl($url);


}	/* fxn */




public function settings($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	
	if(isset($_POST['submit'])){
		$row['name'] = $_POST['name'];
		$dbtable = $dbg.'.settings';
		$this->model->db->add($dbtable,$row);
		Session::set('message','Setting Added.');
		redirect('mis/settingsGis');
	}
	
	$data['settings'] = $this->model->settings($dbg);
	$this->view->render($data,'mis/settings');
}	/* fxn */




public function deleteRoom($params=NULL){
$dbo=PDBO;
$room_id = isset($params[0])? $params[0]:false;
if(!$room_id){ $this->flashRedirect('rooms','No room selected'); }
$q  = " DELETE FROM {$dbo}.rooms_contacts WHERE `room_id` = '$room_id'; ";
$q .= " DELETE FROM {$dbo}.rooms WHERE `id` = '$room_id' LIMIT 1; ";


$this->model->db->query($q);
$this->flashRedirect('rooms','Room & Members Deleted!');

}	/* fxn */



public function primarize($params=NULL){
$dbo=PDBO;
$ucid 	= $params[0];
$uc 	= $this->model->fetchRow(PDBO.'.`00_contacts`',$ucid);
$pcid	= $uc['parent_id'];
$pc 	= $this->model->fetchRow(PDBO.'.`00_contacts`',$pcid);

$dbg	= PDBG;

// 1 - transfer of contacts
$q  = " UPDATE {$dbo}.`00_contacts` SET 
	`parent_id`='$ucid'
WHERE `parent_id` = '$pcid'; ";

$q .= " UPDATE {$dbo}.`00_contacts` SET 
	`is_active`='1',
	`name` = '".$pc['name']."',
	`acn` = '".$pc['acn']."'
WHERE `id` = '$ucid'; ";

// 2 - update ctpX, photo, profile
$q .= " UPDATE ".PDBP.".photos SET `contact_id` = '$ucid' WHERE `contact_id` = '$pcid' LIMIT 1;  ";
$q .= " UPDATE {$dbo}.`00_profiles` SET `contact_id` = '$ucid' WHERE `contact_id` = '$pcid' LIMIT 1;  ";
// $q .= " UPDATE {$dbo}.fathers SET `ucid` = '$ucid' WHERE `ucid` = '$pcid' LIMIT 1;  ";
// $q .= " UPDATE {$dbo}.mothers SET `ucid` = '$ucid' WHERE `ucid` = '$pcid' LIMIT 1;  ";
// $q .= " UPDATE {$dbo}.guardians SET `ucid` = '$ucid' WHERE `ucid` = '$pcid' LIMIT 1;  ";
// $q .= " UPDATE {$dbo}.balances SET `contact_id` = '$ucid' WHERE `contact_id` = '$pcid' LIMIT 1;  ";
// $q .= " UPDATE {$dbo}.rooms_contacts SET `contact_id` = '$ucid' WHERE `contact_id` = '$pcid' ;  ";
// $q .= " UPDATE {$dbo}.siblings SET `scid` = '$ucid' WHERE `scid` = '$pcid' ;  ";


// pr($q);
$this->model->db->query($q);
$url = "misc/users/$ucid";
redirect($url);

}	/* fxn */


public function multiusers(){
	$dbo=PDBO;
	require_once(SITE.'functions/multiusersFxn.php');
	$db=&$this->model->db;
	$data['users']  		= getMultiUsers($db);
	$data['num_multiusers'] = count($data['users']);

	$this->view->render($data,'mis/multiusers');


}	/* fxn */



public function users($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/registration.php");
$db =& $this->model->db;
$data['ucid']	  = $ucid 	 = $params[0];
$uc	= $this->model->fetchRow(PDBO.'.`00_contacts`',$ucid);
$data['pcid']	  = $pcid 	 = $uc['parent_id'];
$data['ssy']	  = $ssy	 = $_SESSION['sy'];
$data['sy']		  = $sy		 = isset($params[1])? $params[1]:$ssy;
$data['current']  = $current = ($sy==$ssy)? true:false;

$_SESSION['users']['pcid'] = $pcid;
$dbyr 	= $sy.US;
$dbg  = VCPREFIX.$dbyr.DBG; 

if(isset($_POST['pcdept'])){
	$pcid = $_POST['parent']['cid'];
	$this->syncCdept($pcid,$dbg);

	$ps = isset($_POST['parent']['ps'])? '1' : '0';
	$gs = isset($_POST['parent']['gs'])? '1' : '0';
	$hs = isset($_POST['parent']['hs'])? '1' : '0';
	
	$q = " UPDATE {$dbo}.`88_contacts_departments` SET 
		`is_ps` = '$ps', 
		`is_gs` = '$gs', 
		`is_hs` = '$hs'  
		WHERE `contact_id` = '$pcid' LIMIT 1;	
	";
	$this->model->db->query($q);	
	$url = 'misc/users/'.$pcid;
	redirect($url);	
	exit;

}	/* post */


if(isset($_POST['submit'])){	
	$pcid = $_POST['pcid'];
	$fullname = $_POST['fullname'];
	$code = $_POST['code'];
	$active = $_POST['active'];
	$clear  = $_POST['clear'];
	$year	= date('Y');
	$rows = $_POST['users'];
	$mdpass = MD5('pass');
	$ucid = lastContactId($db,$dbg);
	// pr($rows);
	// pr($_POST);
	// pr($data['parent']['name']);
	$q = "";
	foreach($rows AS $row){	
		$code = $row['login'];
		$exists = validateCode($db,$code,$dbg);
		if(!$exists){	
			$ucid++;
			/* 1-contacts */
			$q .= " INSERT IGNORE INTO {$dbo}.`00_contacts` (
				`id`,`name`,`parent_id`,`code`,`account`,`is_active`,`is_cleared`,
				`title_id`,`role_id`,`privilege_id`,
				`pass`,`sy`) VALUES (			
				'$ucid','$fullname','$pcid','".$row['login']."','".$row['login']."','$active','$clear',
				'".$row['title']."','".$row['role']."','".$row['priv']."',
				'".$mdpass."','$year'); ";
							
			/* 2-ctp,photos; NO profiles,attendance, photos */	
			$q .= " INSERT IGNORE INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`,`ctpb`) VALUES ('$ucid','pass','pass'); ";			
			
		} /* exists */
	}
	// pr($q);exit;
	$this->model->db->query($q);											
	/* 3-redirect */
	$url = "misc/users/$pcid/$sy";
	redirect($url);
	exit;	

}	/* post-submit */


$data['parent'] = $this->model->getParentDetails($pcid,$dbg);
$data['pcid']	= $pcid;
$data['users']  = $this->model->getUsers($pcid,$dbg);
$data['num_users']   = count($data['users']);
$data['titles'] 	 = $this->model->fetchRows("".PDBO.".`00_titles`");
$data['departments'] = $this->model->fetchRows("".PDBO.".`05_departments`");	

$data['lastnum'] 		= lastContactNumber($db,$sy);
$data['laststud'] 		= lastContact($db,$sy,$stud=1);
$data['lastempl'] 		= lastContact($db,$sy,$stud=0);
$data['prefix']			= $_SESSION['settings']['code_prefix'];
$data['delimeter']		= $_SESSION['settings']['code_delimeter'];

// pr($data);
$vfile="mis/users";vfile($vfile);
$this->view->render($data,$vfile);


}	/* fxn */




public function multis(){
	$dbo=PDBO;
	require_once(SITE.'functions/multiusersFxn.php');
	$db=&$this->model->db;
	// $multis  		= dbgetMultiUsers();
	$multis  		= getMultiUsers($db);
	$data['num_multiusers'] = count($multis);
	
	$users = array();
	foreach($multis AS $row){
		$rows  = getMultis($db,$row['pcid'],PDBG);
		foreach($rows AS $user){
			$users[] = $user;
		}
	}
	
	$data['users'] = $users;	
	$data['num_multiusers'] = count($data['users']);
	$this->view->render($data,'mis/multiusers');


}	/* fxn */



public function delcrs($params=NULL){
	$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;
$q = "";
foreach($params AS $crsid){
	$q .= " DELETE FROM {$dbg}.05_courses WHERE `id` = '$crsid' LIMIT 1; ";
	$q .= " DELETE FROM {$dbg}.05_courses_quarters WHERE `course_id` = '$crsid' LIMIT 1; ";
	$q .= " DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_activities WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_scores WHERE `course_id` = '$crsid'; ";
	
}


pr($q);
echo "<br />";
// $phpurl = URL.'mis/query';
// echo '<a href="'.$phpurl.'">'.$phpurl.'</a>';

}	/* fxn */



public function courses($params){
	$dbo=PDBO;

require_once(SITE."functions/details.php");
require_once(SITE."functions/reports.php");
$db =& $this->model->db;

$data['crid']	= $crid 	= $params[0];
$data['ssy']	= $ssy 	= $_SESSION['sy'];
$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;
$data['home']	= $home	= 'mis';

$_SESSION['url'] = "mis/courses/$crid/$sy";

$_SESSION['courses']['crid'] = $crid;
	
// $dbyr = ($sy==$ssy)? '':$sy.US;
$dbyr = $sy.US;
$dbg  = VCPREFIX.$dbyr.DBG;	
$dbg  = VCPREFIX.$dbyr.DBG;	
	
	
if(isset($_POST['add'])){
	// pr($_POST); exit;
	$is_active		= "1";
	$year		 	= $_POST['year'];
	$lvlcode 		= $_POST['lvlcode'];
	$sxncode 		= $_POST['sxncode'];

/* 1 - courses	 */
$q = " 
INSERT INTO {$dbg}.05_courses (`code`,`name`,`label`,`subject_id`,`crid`,`with_scores`,`is_kpup`,
	`tcid`,`is_aggregate`,`supsubject_id`,`course_weight`,
	`crstype_id`,`year`,`position`,`is_active`
) VALUES
";

$rows = $_POST['courses'];
foreach($rows AS $row){

	$subject = $lvlcode.'-'.$sxncode.'-'.$row['subcode'];		
	$label = ($row['label']=='')? $row['subject'] : $row['label'];

	$q .= "
		('".$row['subcode']."','$subject','$label','".$row['subject_id']."','$crid','".$row['with_scores']."','".$row['is_kpup']."',
		  '".$row['tcid']."','".$row['is_aggregate']."',
		  '".$row['supsubject_id']."','".$row['weight']."',
		  '".$row['crstype_id']."','$year','".$row['position']."','$is_active' ";
	$q .= "),";
		
}	/* foreach */

$q = rtrim($q,",");
$q .= ";";

// pr($q); exit;


$this->model->db->query($q);

/* 2 - Sync courses_quarters then redirect back to mis/courses/crid */
redirect('syncs/syncCQ/'.$crid);
exit;


			
}	/* post-submit */
	

// cridCourses($dbg,$crid,$ctype=1,$agg=1,$filter=NULL,$electives=NULL,$limit=NULL,$is_active=1){
	
/* =============== process ================================================= */
	$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
	$_SESSION['course']['level_id'] = $data['classroom']['level_id'];
	$order = "crs.semester,crs.crstype_id,crs.position,crs.id";
	$data['courses'] = cridCourses($db,$dbg,$crid,$ctype=NULL,$agg=1,$filter=NULL,$elecs=NULL,$limit=NULL,$active=0,$order);	
	$data['num_courses'] = count($data['courses']);
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['teachers'] 		= $this->model->getContacts(RTEAC);
	$data['coordinators'] 	= $this->model->getContacts(RACAD);
	$_SESSION['courses']['crid'] = $crid;
	// pr($_SESSION['courses']['crid']);
	
	$this->view->render($data,'mis/courses');		

}	/* fxn */



public function xgetClassroomAcid($params=null){	/* by mis-tsg */
		$dbo=PDBO;
/* $crid = $params[0];	 */	
	include_once(SITE.'views/elements/params_sq.php');
	
	$crid = $_POST['crid'];
	$q = " SELECT acid FROM {$dbg}.05_classrooms WHERE `id` = '$crid' LIMIT 1; ";	
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();

	// $_SESSION['q'] = $q;
	echo json_encode($row);

}	/* fxn */





public function ajax(){
	$data = NULL;
	$this->view->render($data,'mis/ajax');
}	/* fxn */







public function report(){

echo "mis report not reserved key word";
}



public function lastID($params){
		$dbo=PDBO;
$table 		= $params[0];
	$dbstrpos 	= strpos($table,'.'); 
	if($dbstrpos){
		$db = substr($table,0,$dbstrpos);	
		$dbtable = $table;
	} else {
		$db = PDBG; 
		$dbtable = $db.'.'.$table;	
	}
	$last_id = $this->baseModel->lastID($dbtable);
	echo $last_id;
}	/* fxn */




public function delsac($params){
	$dbo=PDBO;
$dept_id = $params[0];
$sacid 	 = $params[1];

$ssy	= $_SESSION['sy'];
$sy 	= isset($params[2])? $params[2]:$ssy;
$current = ($sy==$ssy)? true:false;

$dbg = ($current)? DBM:$sy.US.DBG;

$q = " DELETE FROM {$dbo}.`05_subjects`_coordinators WHERE `id` = '$sacid' LIMIT 1;  ";
$this->model->db->query($q);
redirect('mis/sacs/'.$dept_id.DS.$sy);


}	/* fxn */



public function emplist($params){
		$dbo=PDBO;
require_once(SITE."functions/employees.php");
	$db =& $this->model->db;

	$data['role_id'] 	= $role_id	=  isset($params[0])? $params[0] : 0; 
	$data['ssy']		= $ssy		= $_SESSION['sy'];
	$data['sy']			= $sy		= isset($params[1])? $params[1]:$ssy;

	// $dbyr				= ($sy==$ssy)? '':$sy.US;	
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$fields = "ctp.ctp,ats.id AS attschema_id,ats.name AS attschema,";
	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = employees($db,$dbg,$fields,$filter);
	$data['num_emps'] = count($data['emps']);		
	$_SESSION['photo_url'] = "mis/emplist/".$role_id;
	
	if(isset($_POST['submit'])){
		$rows = $_POST['c'];
		// pr($rows);
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbo}.`00_contacts` SET 
				`is_male` 		= '".$row['is_male']."',  
				`is_active` 	= '".$row['is_active']."',  
				`attschema_id` 	= '".$row['attschema_id']."'  
				WHERE `id` = '".$row['cid']."' LIMIT 1; ";
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/emplist/$role_id";
		redirect($url);
		// exit;
		
	}
	
	$fields = "*";
	$data['attschemas'] = $this->model->fetchRows("{$dbg}.05_attendance_schemas",$fields);	
	$data['num_attschemas'] = count($data['attschemas']);
	
	$this->view->render($data,'mis/emplist');


}	/* fxn */



public function emplistManager($params){
		$dbo=PDBO;
require_once(SITE."functions/employees.php");
	$db =& $this->model->db;

	$data['role_id'] 	= $role_id	=  isset($params[0])? $params[0] : 0; 
	$data['ssy']		= $ssy		= $_SESSION['sy'];
	$data['sy']			= $sy		= isset($params[1])? $params[1]:$ssy;

	// $dbyr				= ($sy==$ssy)? '':$sy.US;	
	$dbyr 	= $sy.US;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$fields = "c.parent_id,c.`sy`,c.created_date,ctp.ctp,ats.id AS attschema_id,ats.name AS attschema,";
	$filter = ($role_id==0)? NULL : ' AND c.`role_id` = '.$role_id;
	$data['emps'] 	  = employees($db,$dbg,$fields,$filter);
	$data['num_emps'] = count($data['emps']);		
	$_SESSION['url'] = "mis/emplist/".$role_id;
	
	/* for batch edits */
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$q = $this->deleteEmployees($ids);
		$this->model->db->query($q);
		Session::set('message','Purged Employees Successfully!');
		$url = "mis/emplistManager/$role_id/$sy";
		redirect($url);		
		exit;
	}
	
	if(isset($_POST['save'])){
		// pr($_POST);
		$rows = $_POST['contact'];
		$q = "";
		foreach($rows AS $row){
			$mdpass = MD5($row['pass']);
			$q .= "UPDATE {$dbo}.`00_contacts` SET 
					`is_active` = '".$row['is_active']."',`sy`='".$row['year']."', 
					`code` = '".$row['code']."',`account`='".$row['code']."', 
					`pass` = '".$mdpass."',`name`='".$row['name']."' 
				WHERE `id`='".$row['id']."'; ";
			$q .= "UPDATE {$dbo}.`00_ctp` SET `ctp` = '".$row['pass']."' WHERE `contact_id` = '".$row['id']."'; ";
		}
		$this->model->db->query($q);
		$_SESSION['message'] = 'Changes saved.';
		$url = "mis/emplistManager/$role_id/$sy";
		redirect($url);	
		exit;
	
	}
	
	$this->view->render($data,'mis/emplistManager');


}	/* fxn */


/* c.id,p.contact_id,attempl.ecid,photos.contact_id,ctp.contact_id */
public function deleteEmployees($ids){
	$dbo=PDBO;
$q = "";
$params = explode('/',$ids);

$num_params = count($params);
for($i=0;$i<$num_params;$i++){
	$q .= "DELETE FROM ".PDBG.".attendance_employees WHERE `ecid` = '".$params[$i]."';  ";
	$q .= "DELETE FROM {$dbo}.`00_contacts` WHERE `id` = '".$params[$i]."' LIMIT 1;  ";
	$q .= "DELETE FROM {$dbo}.`00_profiles` WHERE `contact_id` = '".$params[$i]."' LIMIT 1;  ";
	$q .= "DELETE FROM ".DBP.".photos WHERE `contact_id` = '".$params[$i]."' LIMIT 1;  ";
	$q .= "DELETE FROM {$dbo}.`00_ctp` WHERE `contact_id` = '".$params[$i]."' LIMIT 1;  ";
}		

return $q;

}	/* fxn */





public function dbCleanPage(){
		$dbo=PDBO;
if(isset($_POST['submit'])){
		// pr($_POST);
		$dbone	= $_POST['dbone'];
		$dbtwo	= $_POST['dbtwo'];
		$main	= $_POST['main'];
		$rship	= $_POST['rship'];
		$key	= $_POST['key'];
		
		$url = "mis/dbClean/$dbone/$dbtwo/$main/$rship/$key";
		redirect($url);
		exit;
	}
	$data = NULL;
	$this->view->render($data,'mis/dbCleanPage');

}	/* fxn */


public function dbClean($params){
	$dbo=PDBO;

	$dbone	= $params[0];
	$dbtwo	= $params[1];
	$main	= $params[2];
	$rship	= $params[3];
	$key	= $params[4];

	/* 1 - select strays */
	$q = "
		SELECT
			{$main}.*,{$rship}.*
		FROM {$dbtwo}.{$rship} AS {$rship}
			LEFT JOIN {$dbone}.{$main} AS {$main} ON {$rship}.{$key} = {$main}.id
		WHERE {$main}.id is NULL		
	";
	pr($q);
	$sth = $this->model->db->querysoc($q);
	$rows = $sth->fetchAll();
	// pr($rows);
		
	/* 2 - strays */
	$strays = buildArray($rows,$key);
	pr($strays);
		
	/* 3 - delete strays */
	$q = "";
	foreach($strays AS $id){
		$q .= "DELETE FROM {$dbtwo}.{$rship} WHERE {$key} = '".$id."' LIMIT 1; ";
	}

	pr($q);
	// $this->model->db->query($q);
		


}	/* fxn */




/* view should be in teachers folder */
public function clscrs($params){
	$dbo=PDBO;

require_once(SITE."functions/details.php");
require_once(SITE."functions/reports.php");
$db =& $this->model->db;

$data['crid']	= $crid 	= isset($params[0])? $params[0] : '1';
$data['ssy']	= $ssy 	= $_SESSION['sy'];
$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;

$_SESSION['url'] = "mis/clscrs/$crid/$sy";
$_SESSION['courses']['crid'] = $crid;
	
// $dbyr = ($sy==$ssy)? '':$sy.US;
$dbyr = $sy.US;
$dbg  = VCPREFIX.$dbyr.DBG;	
$dbg  = VCPREFIX.$dbyr.DBG;	

$data['home']	= $home	= $_SESSION['home'];
$data['user']	= $user	= $_SESSION['user'];

	
	if(isset($_POST['submit'])){
		// pr($_POST); 
		// exit;
		$courses = $_POST['courses'];
		$q = "";
		foreach($courses AS $row){
			$q .= " UPDATE {$dbg}.05_courses SET 
						`name`   	= '".$row['name']."',
						`code`   	= '".$row['code']."',
						`label`  	= '".$row['label']."',
						`subject_id` = '".$row['subject_id']."',
						`supsubject_id` = '".$row['supsubject_id']."',
						`tcid` = '".$row['tcid']."',
						`crstype_id` = '".$row['crstype_id']."',
						`is_active` = '".$row['is_active']."',
						`with_scores`  = '".$row['with_scores']."',
						`is_kpup` 	   = '".$row['is_kpup']."',
						`is_displayed` = '".$row['is_displayed']."',
						`in_genave`    = '".$row['in_genave']."',
						`affects_ranking` = '".$row['affects_ranking']."',
						`is_aggregate` = '".$row['is_aggregate']."',						
						`is_transmuted` = '".$row['is_transmuted']."',						
						`course_weight`  = '".$row['course_weight']."',
						`position`  = '".$row['position']."',
						`indent`  	= '".$row['indent']."',
						`semester`  = '".$row['semester']."',
						`is_num`  = '".$row['is_num']."',
						`schedule`  = '".$row['schedule']."'
					WHERE `id` = '".$row['id']."';
			";
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/clscrs/$crid/$sy";
		redirect($url);		
	
	}	/* post */
	

/* --------------------------- process --------------------------- */

	$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
	$_SESSION['course']['level_id'] = $data['classroom']['level_id'];
	$order = "crs.semester,crs.crstype_id,crs.position,crs.id";
	$data['courses'] = cridCourses($db,$dbg,$crid,$ctype=NULL,$agg=1,$filter=NULL,$elecs=NULL,$limit=NULL,$active=0,$order);	
	$data['num_courses'] = count($data['courses']);
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['teachers'] 		= $this->model->getContacts(RTEAC);
	$data['coordinators'] 	= $this->model->getContacts(RACAD);
	$_SESSION['courses']['crid'] = $crid;
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
		
	$this->view->render($data,'mis/clscrs');

}	/* fxn */



/* view should be in teachers folder */
public function lvlcrs($params){
	$dbo=PDBO;

require_once(SITE."functions/reports.php");
require_once(SITE."functions/details.php");
$db =& $this->model->db;

$data['lvlid']	= $lvlid = isset($params[0])? $params[0] : '1';
$data['ssy']	= $ssy 	 = $_SESSION['sy'];
$data['sy']		= $sy 	 = isset($params[1])? $params[1] : $ssy;

$_SESSION['url'] = "mis/lvlcrs/$lvlid/$sy";
$_SESSION['courses']['lvlid'] = $lvlid;
	
// $dbyr = ($sy==$ssy)? '':$sy.US;
$dbyr = $sy.US;
$dbg  = VCPREFIX.$dbyr.DBG;	
$dbg  = VCPREFIX.$dbyr.DBG;	

$data['home']	= $home	= $_SESSION['home'];
$data['user']	= $user	= $_SESSION['user'];

	
	if(isset($_POST['submit'])){
		// pr($_POST); 
		// exit;
		$courses = $_POST['courses'];
		$q = "";
		foreach($courses AS $row){
			$q .= " UPDATE {$dbg}.05_courses SET 
						`code`   	= '".$row['code']."',
						`label`  	= '".$row['label']."',
						`subject_id` = '".$row['subject_id']."',
						`supsubject_id` = '".$row['supsubject_id']."',
						`tcid` = '".$row['tcid']."',
						`crstype_id` = '".$row['crstype_id']."',
						`is_active` = '".$row['is_active']."',
						`with_scores`  = '".$row['with_scores']."',
						`is_kpup` 	   = '".$row['is_kpup']."',
						`is_displayed` = '".$row['is_displayed']."',
						`in_genave`    = '".$row['in_genave']."',
						`indent`       = '".$row['indent']."',
						`semester`     = '".$row['semester']."',
						`affects_ranking` = '".$row['affects_ranking']."',
						`is_aggregate` = '".$row['is_aggregate']."',						
						`is_transmuted` = '".$row['is_transmuted']."',						
						`course_weight`  = '".$row['course_weight']."',
						`position`  = '".$row['position']."',
						`schedule`  = '".$row['schedule']."'
					WHERE `id` = '".$row['id']."';
			";
		}
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/lvlcrs/$lvlid/$sy";
		redirect($url);		
	
	}	/* post */
	
//--------------------------- process ---------------------------

	$data['level'] = getLevelDetails($db,$lvlid,$dbg);
	$_SESSION['course']['level_id'] = $data['level']['id'];
	// $order = "crs.crstype_id,crs.position,crs.id";
	// $data['courses'] = levelCourses($db,$dbg,$lvlid,$ctype=NULL,$agg=1,$filter=NULL,$elecs=NULL,$limit=NULL,$active=0,$order);	
	$q = "
		SELECT 
			sxn.name AS section,	
			sub.code AS subject_code,sub.name AS subject,
			c.id AS tcid,c.name AS teacher,c.account AS tlogin,
			ctp.ctp AS tpass,
			crs.id AS crsid,crs.id AS course_id,crs.name AS course,
			crs.code AS course_code,crs.*					
		FROM {$dbg}.05_courses AS crs 
			LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id			
			LEFT JOIN {$dbo}.`00_ctp` ON crs.tcid = ctp.contact_id			
		WHERE 
				cr.level_id = '$lvlid'			
			AND	sxn.code <> 'TMP'			
		ORDER BY crs.semester,crs.position,crs.subject_id,cr.section_id
	;";
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['courses'] = $sth->fetchAll();
	$data['num_courses'] = count($data['courses']);
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');
	$data['crstypes'] 	= $this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['teachers'] 		= $this->model->getContacts(RTEAC);
	$data['coordinators'] 	= $this->model->getContacts(RACAD);
	$_SESSION['courses']['lvlid'] = $lvlid;
	// pr($_SESSION['courses']['crid']);
	$data['levels'] 		= $this->model->fetchRows("{$dbo}.`05_levels`","*","id");	
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
		
	$this->view->render($data,'mis/lvlcrs');

}	/* fxn */




public function fyi(){
	$dbo=PDBO;


	$data = NULL;
	$this->view->render($data,'mis/fyi');

}	/* fxn */


public function teachers($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/miscontacts.php");
	$db =& $this->model->db;
	include_once(SITE.'views/elements/params_sq.php');
	$sort = isset($_GET['sort'])? $_GET['sort']:'c.name';
	$order = isset($_GET['order'])? $_GET['order']:'ASC';
	$data['rows'] = getAllTeachers($db,$sort,$order);	
	$data['count']	= count($data['rows']);		
	$this->view->render($data,'misc/teachersMisc');
}	/* fxn */



public function openQualified($params=NULL){
	$dbo=PDBO;
$ssy	= $_SESSION['sy'];
$sy		= isset($params[0])? $params[0]:$ssy;
$qtr	= isset($params[1])? $params[1]:$_SESSION['qtr'];

// $dbyr 	= ($sy==$ssy)? '':$sy.US;
$dbyr 	= $sy.US;
$dbg	= VCPREFIX.$dbyr.DBG; 
$dbg	= VCPREFIX.$dbyr.DBG; 

$q = "";
$q .= " UPDATE {$dbg}.05_summaries SET `is_qualified_q{$qtr}` = '1'; ";

$this->model->db->query($q);
$_SESSION['message'] = "Summaries is_qualified - Q{$qtr} Opened!";
$home = $_SESSION['home'];
redirect($home);


}	/* fxn */



public function query(){
	$dbo=PDBO;
	
	if(isset($_POST['submit'])){
		$query = $_POST['query'];
		pr($query);
		$sth = $this->model->db->querysoc($query);
		$rows = $sth->fetchAll();
		pr($rows);
		
	}
	$data = NULL;
	$this->view->render($data,'mis/query');

}	/* fxn */



public function prq(){
	$dbo=PDBO;
	
	if(isset($_POST['submit'])){
		$q = $_POST['query'];
		pr($q);
		
	}
	$data = NULL;
	$this->view->render($data,'mis/query');

}	/* fxn */



public function qry(){
	$dbo=PDBO;

$dbg = 'dbgis_sasm';

/* summaries */
$q  = '';
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classroom_q1` = 0 WHERE `rank_classroom_q1` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classroom_q2` = 0 WHERE `rank_classroom_q2` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classroom_q3` = 0 WHERE `rank_classroom_q3` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classroom_q4` = 0 WHERE `rank_classroom_q4` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classroom_q5` = 0 WHERE `rank_classroom_q5` = 99.99; ";


$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_q1` = 0 WHERE `rank_level_q1` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_q2` = 0 WHERE `rank_level_q2` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_q3` = 0 WHERE `rank_level_q3` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_q4` = 0 WHERE `rank_level_q4` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_q5` = 0 WHERE `rank_level_q5` = 99.99; ";


$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_ave_q1` = 0 WHERE `rank_level_ave_q1` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_ave_q2` = 0 WHERE `rank_level_ave_q2` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_ave_q3` = 0 WHERE `rank_level_ave_q3` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_ave_q4` = 0 WHERE `rank_level_ave_q4` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_level_ave_q5` = 0 WHERE `rank_level_ave_q5` = 99.99; ";

$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classconduct_q1` = 0 WHERE `rank_classconduct_q1` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classconduct_q2` = 0 WHERE `rank_classconduct_q2` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classconduct_q3` = 0 WHERE `rank_classconduct_q3` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classconduct_q4` = 0 WHERE `rank_classconduct_q4` = 99.99; ";
$q .= " UPDATE {$dbg}.`05_summaries` SET `rank_classconduct_q5` = 0 WHERE `rank_classconduct_q5` = 99.99; ";


/* grades */
$q .= " UPDATE {$dbg}.`50_grades` SET `rq1` = 0 WHERE `rq1` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rq2` = 0 WHERE `rq2` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rq3` = 0 WHERE `rq3` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rq4` = 0 WHERE `rq4` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rq5` = 0 WHERE `rq5` = 99.99; ";

$q .= " UPDATE {$dbg}.`50_grades` SET `rank_q1` = 0 WHERE `rank_q1` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rank_q2` = 0 WHERE `rank_q2` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rank_q3` = 0 WHERE `rank_q3` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rank_q4` = 0 WHERE `rank_q4` = 99.99; ";
$q .= " UPDATE {$dbg}.`50_grades` SET `rank_q5` = 0 WHERE `rank_q5` = 99.99; ";


pr($q);



}	/* fxn */




public function deleteSubject($params){
	$dbo=PDBO;
$id = $params[0];
$dbg = PDBG;
$q = "DELETE FROM {$dbo}.`05_subjects` WHERE `id` = '$id' LIMIT 1;  ";
$this->model->db->query($q);
$_SESSION['message'] = "Subject deleted.";
$url = "mis/subjects";
redirect($url);

}	/* fxn */


public function ptl($params=NULL){
	
	

}


public function delgrades($params=NULL){
	$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;
$q = "";
foreach($params AS $crsid){
	$q .= " DELETE FROM {$dbg}.50_grades WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_activities WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_stats WHERE `course_id` = '$crsid'; ";
	$q .= " DELETE FROM {$dbg}.50_scores WHERE `course_id` = '$crsid'; ";	
}

echo "&nbsp;&nbsp;&nbsp;";pr($q);

}	/* fxn */


public function purgeIndex(){
	$dbo=PDBO;
$db =& $this->model->db;
$dbg = PDBG;
$dbg = PDBG;



$data['classrooms'] = $this->model->fetchRows($dbg.'.05_classrooms','id,name','level_id,section_id');
$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`",'id,name','id');

$this->view->render($data,'mis/purgeIndex');


}	/* fxn */



public function setupCourses(){
	$dbo=PDBO;

$dbg = PDBG;
$dbg = PDBG;

if(isset($_POST['submit'])){
	pr($_POST);


}	/* post */


$data['subjects'] 	= $this->model->fetchRows($dbg.'.subjects','*','position,name',$where=NULL,$limit=3);
$data['count']		= count($data['subjects']);
$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`",'id,name','id');

$this->view->render($data,'mis/setupCourses');


}	/* fxn */


public function createCourses($params=NULL){
	$dbo=PDBO;

require_once(SITE."functions/details.php");
$db =& $this->model->db;
$dbg = PDBG;

$data['level_id']   = $level_id		= $params[0];
$data['subject_id'] = $subject_id	= $params[1];
$ssy = $_SESSION['sy'];
$data['sy']			= $sy 			= isset($params[2])? $params[2]:$ssy;
$data['home']	= $home = $_SESSION['home'];
if($sy!=$ssy){ $this->flashRedirect($home); }

$data['subject'] = getSubjectDetails($db,$subject_id,$dbg);
$data['classrooms'] = $this->model->fetchRows($dbg.'.05_classrooms','id,name','section_id','WHERE level_id='.$level_id);


// pr($data);
pr($data['classrooms']);


}	/* fxn */







public function attd(){
	$dbo=PDBO;
$today 		= $_SESSION['today'];
$time		= date("H:i:s",strtotime('now'));
// pr($time);
$dbg = PDBG;

if(isset($_POST['submit'])){
	// pr($_POST);
	$ucid = $_POST['ucid'];
	
	$q = "
		SELECT c.id AS ucid,c.name AS person,
			b.contact_id AS attucid
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN (
				SELECT contact_id FROM {$dbg}.05_attendance_logs WHERE date = '$today'
			) AS b ON b.contact_id = c.id			
		WHERE 
				c.`id` = '$ucid' 
	;";
	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$row = $sth->fetch();
	// pr($row);
	
	if(isset($row['attucid'])){
		$q = "UPDATE {$dbg}.05_attendance_logs SET timeout = '$time' 
			WHERE `date` = '$today' AND `contact_id` = '$ucid'; ";
	} else {
		$q = "INSERT INTO {$dbg}.05_attendance_logs (`contact_id`,`date`,`timein`) VALUES 
				('$ucid','$today','$time');
		;";
		
	}
	// pr($q);
	$this->model->db->query($q);
	// pr($time);
	$url = "mis/attd";
	redirect($url);
	exit;

}	/* fxn */


$this->view->render(NULL,'mis/attd');


}	/* fxn */



public function user($params=NULL){
	$dbo=PDBO;
$data['ucid'] = $ucid = isset($params[0])? $params[0]:NULL;

$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;
$q = "
	SELECT
		c.id AS ucid,c.*,c.parent_id AS pcid,c.crid AS crid,pc.name AS person,ctp.ctp,p.*,
		t.name AS title,r.name AS role,cr.acid AS acid,sum.crid AS sumcrid,
		c.`sy` AS sy,c.is_male AS is_male
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
		LEFT JOIN {$dbg}.05_summaries AS sum ON sum.scid = pc.id		
		LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
		LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = pc.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.parent_id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.parent_id
		LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
		LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id = r.id
	WHERE c.id = '$ucid' LIMIT 1;
";
debug($q);
$sth = $this->model->db->querysoc($q);
$data['user'] = $user = $sth->fetch();
$data['is_student'] = $is_student = ($user['role_id']==RSTUD)? true:false;
$data['is_employee'] = !$is_student;


/* 2 - sync */
if(!empty($ucid)){	/* has ucid */
$sync=false;
$q = "";
	if(empty($user['sy'])) { 
		$q .= "UPDATE {$dbo}.`00_contacts` SET `sy` = '".DBYR."' WHERE `id` = '$ucid' LIMIT 1;"; $sync="SY"; }
	if($is_student){
		if(empty($user['sumcrid'])) { $q .= "INSERT INTO {$dbg}.05_summaries(`scid`,`crid`,`acid`) 
			VALUES ('".$user['ucid']."','".$user['crid']."','".$user['acid']."');"; $sync="Summ"; }				
	}	/* is student */

	if($sync){ 
		$url = "misc/user/$ucid";	
		$this->model->db->query($q);
		flashRedirect($url,"$sync synced."); 
	}


}	/* has ucid */


$this->view->render($data,'mis/user');

}	/* fxn */



public function merge($params=NULL){
	$dbo=PDBO;
$pcid = isset($params[0])? $params[0]:NULL;
$name = isset($_GET['name'])? $_GET['name']:NULL;
$code = isset($_GET['code'])? $_GET['code']:NULL;

$cond = ($pcid || $name || $code)? true:false;
if($cond):

	$where = " WHERE ";
	$where .= (!empty($pcid))? " c.parent_id = $pcid ":NULL;
	$where .= (!empty($name))? " pc.name LIKE '%$name%' ":NULL;
	$where .= (!empty($code))? " pc.code LIKE '%$code%' ":NULL;

	$dbo=PDBO;
	$q = "
		SELECT
			c.id AS ucid,c.parent_id AS pcid,c.*,
			pc.name AS person,
			ctp.ctp
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_contacts` AS pc ON c.parent_id = pc.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
		$where
		LIMIT 10;

	";

	// pr($q); 
	$sth = $this->model->db->querysoc($q);
	$data['users'] = $sth->fetchAll();
	$data['count'] = count($data['users']);
else:
	$data = NULL;
endif;

$this->view->render($data,'mis/merge');

}	/* fxn */


public function attend(){

}	/* fxn */


public function lvlsub($params=NULL){
	$dbo=PDBO;

require_once(SITE."functions/details.php");
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

$this->view->render($data,'mis/lvlsub');


}	/* fxn */



public function levels($params=NULL){
	$dbo=PDBO;

$db = $this->model->db;
include_once(SITE.'views/elements/params_sq.php');

$data['levels'] 	= $levels = $this->model->fetchRows("{$dbo}.`05_levels`","*","id");
foreach($levels AS $row){
	$q = "
		SELECT 
			cr.id AS crid,sxn.name AS section
		FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
		WHERE 
				cr.level_id = '".$row['id']."'
			AND sxn.code <> 'TMP'
		ORDER BY sxn.id
	";
	$sth = $db->querysoc($q);
	$sections[] = $sth->fetchAll();
}
$data['sections'] = $sections;

	
	$data['num_levels'] = count($data['levels']);
	$this->view->render($data,'mis/levels');

}	/* fxn */



public function nullsubjects(){
	$dbo=PDBO;
$dbg = PDBG;
$dbg = DBM;
$q = "

	SELECT 
		a.id AS subect_id,a.name AS subject_id	
	FROM {$dbo}.`05_subjects` AS a 
	LEFT JOIN (
			SELECT
				sub.id AS subject_id,sub.name AS subject,crs.label AS course
			FROM {$dbo}.`05_subjects` AS sub
				LEFT JOIN {$dbg}.05_courses AS crs ON crs.subject_id = sub.id
			GROUP BY sub.id	
	) AS b ON b.subject_id = a.id
	WHERE b.course IS NULL

";
pr($q);
$sth = $this->model->db->querysoc($q);
$data['subjects'] = $sth->fetchAll();
pr($data);


}	/* fxn */




public function subjectLevels(){
	$dbo=PDBO;
$db = $this->model->db;

$dbg = PDBG;
$dbg = PDBG;

$q = "
	SELECT 
		sub.*,sub.id AS subject_id
	FROM {$dbo}.`05_subjects` AS sub

;";

// pr($q);
$sth = $db->querysoc($q);
$data['subjects'] = $subjects = $sth->fetchAll();

foreach($subjects AS $row){
	$q = "
		SELECT 
			crs.label,l.id AS level_id,l.name AS level
		FROM {$dbg}.05_courses AS crs
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id	
		WHERE 
				crs.subject_id = '".$row['subject_id']."'
			AND crs.is_active = 1
		GROUP BY l.id
		ORDER BY l.id
	";
	$sth = $db->querysoc($q);
	$levels[] = $sth->fetchAll();
}
$data['levels'] = $levels;

$this->view->render($data,'mis/subjectLevels');



}	/* fxn */



public function boss(){
	$dbo=PDBO;
$db = $this->model->db;

$dbg = PDBG;
$dbg = PDBG;

$q = "
	SELECT 
		sub.*,sub.id AS subject_id
	FROM {$dbo}.`05_subjects` AS sub
	ORDER BY sub.name

;";

// pr($q);
$sth = $db->querysoc($q);
$data['subjects'] = $subjects = $sth->fetchAll();

foreach($subjects AS $row){
	$q = "
		SELECT 
			cr.id AS crid,crs.label,cr.name AS classroom,c.name AS teacher,c.id AS tcid
		FROM {$dbg}.05_courses AS crs
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id
		WHERE 
				crs.subject_id = '".$row['subject_id']."'
			AND crs.is_active = 1
		ORDER BY cr.level_id,cr.section_id
	";
	$sth = $db->querysoc($q);
	$courses[] = $sth->fetchAll();
}
$data['courses'] = $courses;

$this->view->render($data,'mis/boss');



}	/* fxn */


public function advisers($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/miscontacts.php");
	$db =& $this->model->db;
	$data['ssy'] = $ssy	= $_SESSION['sy'];
	$data['sqtr'] = $sqtr = $_SESSION['qtr'];
	$data['sy']	= $sy	= isset($params[0])? $params[0] : $ssy;	
	$data['rows'] = getAdvisers($db);
	$data['count']	= count($data['rows']);
	$this->view->render($data,'misc/advisersMisc','full');

}	/* fxn */	



public function registrars(){}	/* fxn */
public function requests(){
	$dbo=PDBO;
	$q = "select * from {$dbo}.requests ";
	$sth = $this->model->db->querysoc($q);
	$rows = $sth->fetchAll();
	pr($rows);
}	/* fxn */



public function myip(){
	$dbo=PDBO;
	echo "Public IP: ".$_SERVER['REMOTE_ADDR'];

$externalContent = file_get_contents('http://checkip.dyndns.com/');
preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
$externalIp = $m[1];
pr($externalIp);
	
	
}	/* fxn */

 
 



/* 1) s.crid,s.is_sectioned 2) sum.crid,sum.acid,c.am  */ 
public function employer($params=NULL){
	$dbo=PDBO;

require_once(SITE."functions/employees.php");
$db =& $this->model->db;

$data['ecid']	= $ecid	= isset($params[0])? $params[0]:NULL;
$data['ssy'] 	= $ssy	= $_SESSION['sy'];	
$data['sy']		= $sy 	= isset($params[1])? $params[1]:$ssy;
$data['home']	= $home	= $_SESSION['home'];

$dbyr 	= $sy.US;	
$dbg	= VCPREFIX.$dbyr.DBG;
$dbg	= VCPREFIX.$dbyr.DBG;

if(!empty($params)){ 
	$data['employee'] = $employee = employee($db,$dbg,$ecid); 
	$all = (isset($_GET['all']))? true:false;

}


if(isset($_POST['submit'])){

	$pcid = $employee['pcid'];
	$ucid = $employee['ucid'];
	
	/* 1 - contacts */		
	$q = " UPDATE {$dbo}.`00_contacts` SET 
				`is_active`  = '".$_POST['is_active']."',
				`is_cleared`  = '".$_POST['is_cleared']."',
				`is_male`  = '".$_POST['is_male']."',
				`sy`  = '".$_POST['sy']."'
			WHERE `id` = '$ecid' LIMIT 1;	";
	/* 2 - summaries for employee? */		
	
	/* echo (isset($employee['sumecid']))? 'sumecid set':'sumecid NOT set'; */
	/* 3 - init students,profiles,photos,ctp if not exists */
	if(!isset($employee['attdecid'])){ $q .= " INSERT INTO {$dbg}.06_attendance_employees (`ecid`) VALUES ('$pcid');  "; }	
	if(!isset($employee['emplecid'])){ $q .= " INSERT INTO {$dbg}.06_employees(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employee['ctpucid'])){ $q .= " INSERT INTO {$dbo}.`00_ctp` (`contact_id`) VALUES ('$ucid');  "; }	
	if(!isset($employee['profecid'])){ $q .= " INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employee['photoecid'])){ $q .= " INSERT INTO ".DBP.".photos(`contact_id`) VALUES ('$pcid');  "; }	
	
	// pr($q); exit;
	$this->model->db->query($q);
	$url = "mis/employer/$ecid";
	$this->flashRedirect($url,"Employee updated.");

}	/* post */


if(isset($_POST['purge'])){ 
	$url = "registrars/purgeContacts/".$ecid;
	redirect($url); exit; 
}	/* post */

/* ---------------------------------------------------------------------------- */

$this->view->render($data,'employees/employer');

}	/* fxn */



public function employing($params){
	$dbo=PDBO;
	require_once(SITE."functions/employees.php");
	$db =& $this->model->db;

	$data['role_id']= $role_id = isset($params[0])? $params[0]:RTEAC;	
	$data['ssy']	= $ssy 	= $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;
	$data['user']	= $user = $_SESSION['user'];
	$data['home']	= $home	= $_SESSION['home'];
	$data['srid']	= $user['role_id'];
	
	$_SESSION['url']	= "mis/employing/$role_id";		
	$data['current'] = $current = ($sy==$ssy)? true : false;
	
	$dbyr 	= $sy.US;	
	$dbg  = VCPREFIX.$dbyr.DBG;	
	$dbg  = VCPREFIX.$dbyr.DBG;	

	// $sort = "c.is_male DESC,c.name";
	$sort = (isset($_GET['sort']))? $_GET['sort']:"c.is_male DESC,c.name";
	$fields=null;
	// $filter = isset($_GET['all'])? NULL:"AND c.`sy`=$sy";
	$filter = null;
	$data['employees'] 	= $employees = employing($db,$dbg,$role_id,$male=2,$sort,$fields,$filter);	
	$data['count']		= count($data['employees']);

	
if(isset($_POST['submit'])){
// pr($_POST);
$posts = $_POST['employees'];
$q = "";
$i=0;
foreach($posts AS $row){
	$pcid = $employees[$i]['pcid'];
	$ucid = $employees[$i]['ucid'];

	/* 1 - contacts */		
	$q .= " UPDATE {$dbo}.`00_contacts` SET 
		`title_id` = '".$row['title_id']."',  
		`role_id` = '".$row['role_id']."',  
		`privilege_id` = '".$row['privilege_id']."',  		
		`is_active` = '".$row['is_active']."',  
		`is_cleared` = '".$row['is_cleared']."',  
		`is_male` 	= '".$row['is_male']."'  
		WHERE `id` = '$ucid' LIMIT 1; ";
		
	/* 2 - summaries */			
	/* echo (isset($employee['sumecid']))? 'sumecid set':'sumecid NOT set'; */
	/* 3 - init students,profiles,photos,ctp if not exists */
	if(!isset($employees[$i]['ctpucid'])){ $q .= " INSERT INTO {$dbo}.`00_ctp` (`contact_id`) VALUES ('$ucid');  "; }	
	if(!isset($employees[$i]['attdecid'])){ $q .= " INSERT INTO {$dbg}.06_attendance_employees (`ecid`) VALUES ('$pcid');  "; }	
	if(!isset($employees[$i]['emplecid'])){ $q .= " INSERT INTO {$dbg}.06_employees(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employees[$i]['profecid'])){ $q .= " INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('$pcid');  "; }	
	if(!isset($employees[$i]['photoecid'])){ $q .= " INSERT INTO ".DBP.".photos(`contact_id`) VALUES ('$pcid');  "; }	
/* 	if(empty($employees[$i]['name'])){ 
		$q .= " UPDATE {$dbo}.`00_contacts` SET `name` = '".$employees[$i]['parentname']."' WHERE `id` = '$ucid' LIMIT 1;  "; }	
 */		
	
	
	$i++;
}	/* foreach */

$_SESSION['q'] = $q;
// pr($q);exit;
$this->model->db->query($q);

$url = "mis/employing/$role_id";
$this->flashRedirect($url,'Updated employees.');

exit;

}	/* post */

	
	$data['roles'] = $_SESSION['roles'];
	$data['titles'] = $_SESSION['titles'];
	$this->view->render($data,'employees/employingMisc');	

}	/* fxn */


public function syncStudents(){
	$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;
	$q = "

		SELECT 			
			ctp.ctp,
			c.id AS ucid,c.parent_id AS pcid,			
			sum.crid AS sumcrid,sum.scid AS sumscid,sum.acid AS sumacid,		
			cr.name AS classroom,
			c.*,c.id AS scid,c.name AS student,c.`sy`,
			cr.acid,cr.acid AS acid,
			c.crid AS crid,
			t.total,l.name AS level,sxn.name AS section,
			cr.level_id,c.code AS student_code,
			s.contact_id AS studscid,p.contact_id AS profscid,ph.contact_id AS photoscid,ctp.contact_id AS ctpscid,
			tsum.scid AS tsumscid,
			attd.scid AS attdscid
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS sum on sum.scid = c.id
			LEFT JOIN {$dbg}.05_attendance AS attd on attd.scid = c.id			
			LEFT JOIN {$dbg}.05_classrooms AS cr on sum.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t on cr.level_id = t.level_id
			LEFT JOIN {$dbg}.05_students AS s on s.contact_id = c.id
			LEFT JOIN {$dbg}.03_tsummaries AS tsum on tsum.scid = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
			LEFT JOIN ".DBP.".photos AS ph on ph.contact_id = c.id					
		WHERE 
			c.role_id = '".RSTUD."';	
	";
	$sth = $this->model->db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q'] = $q;
	// pr($q);
	
	$q = "";
	foreach($rows AS $row){	
		if(!isset($row['ctpscid'])){ $q .= " INSERT INTO {$dbo}.`00_ctp`(`contact_id`) VALUES ('".$row['ucid']."');  "; }	
		if(!isset($row['attdscid'])){ $q .= " INSERT INTO {$dbg}.05_attendance(`scid`) VALUES ('".$row['pcid']."');  "; }	
		if(!isset($row['studscid'])){ $q .= " INSERT INTO {$dbg}.05_students(`contact_id`) VALUES ('".$row['pcid']."');  "; }	
		if(!isset($row['profscid'])){ $q .= " INSERT INTO {$dbo}.`00_profiles`(`contact_id`) VALUES ('".$row['pcid']."');  "; }	
		if(!isset($row['photoscid'])){ $q .= " INSERT INTO ".DBP.".photos(`contact_id`) VALUES ('".$row['pcid']."');  "; }	
if(!isset($row['sumscid'])){ $q .= " INSERT INTO {$dbg}.05_summaries(`scid`,`crid`,`acid`) 
	VALUES ('".$row['pcid']."','".$row['crid']."','".$row['acid']."');  "; }	
if(!isset($row['tsumscid'])){ $q .= " INSERT INTO {$dbg}.03_tsummaries(`scid`,`crid`) VALUES ('".$row['pcid']."','".$row['crid']."');  "; }	
	
	}	/* foreach */
	echo "<hr />";
	foreach($rows AS $row){
		if(!isset($row['sumscid'])){ echo "'".$row['student']."' - '".$row['pcid']."' <br />"; } 	
	}
	
	pr($q);
	



}	/* fxn */


public function closeAllPromotions($params=NULL){
	$dbo=PDBO;
$ssy = $_SESSION['sy'];
$sy = (isset($params[0]))? $params[0]:$ssy;

$dbyr = $sy.US;
$dbg = VCPREFIX.$dbyr.DBG;
$q = " UPDATE {$dbg}.05_promotions SET `is_finalized` = '1'; ";
pr($q);


}	/* fxn */
 
public function openAllPromotions($params=NULL){
	$dbo=PDBO;
$ssy = $_SESSION['sy'];
$sy = (isset($params[0]))? $params[0]:$ssy;

$dbyr = $sy.US;
$dbg = VCPREFIX.$dbyr.DBG;
$q = " UPDATE {$dbg}.05_promotions SET `is_finalized` = '0'; ";
pr($q);


}	/* fxn */
 
public function today(){ echo "Session: "; print($_SESSION['today']);  echo "<br>Date: "; print(date('Y-m-d')); }




public function pdf(){ $this->view->render($data=NULL,'mis/pdf'); }	/* fxn */

public function secrets(){
	$dbo = PDBO;
	$q = " SELECT * FROM {$dbo}.secrets; ";
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	
	$this->view->render($data,'mis/secrets');
	
}	/* fxn */
 
 
public function editSecret($params){
	$dbo=PDBO;
	$data['id'] = $id = $params[0];
	$q = " SELECT * FROM {$dbo}.secrets WHERE id = '$id' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$data['row'] = $sth->fetch();
	
	if(isset($_POST['submit'])){
		// pr($_POST);
		$post = $_POST;
		$clear = $post['clear'];
		$value = MD5($clear);
		$q = "UPDATE {$dbo}.secrets SET `value` = '$value',`clear` = '$clear' WHERE `id` = '$id'; ";
		$this->model->db->query($q);
		$url = "mis/secrets";
		flashRedirect($url,'Secret updated.');
		exit;
		
	} /* post */
	
	$this->view->render($data,'mis/secret');

}	/* fxn */
 
 
 
public function addSecret(){
	$dbo=PDBO;
	
	if(isset($_POST['submit'])){
		// pr($_POST);
		$post = $_POST;
		$name  = $post['name'];
		$clear = $post['clear'];
		$value = MD5($clear);
		$q = "INSERT INTO {$dbo}.secrets (`name`,`value`,`clear`) 
			VALUES('$name','$value','$clear'); ";
		$this->model->db->query($q);
		$url = "mis/secrets";
		flashRedirect($url,'Secret added.');
		exit;
		
	} /* post */
		
	$this->view->render($data=NULL,'mis/secret');

}	/* fxn */
 

public function idf(){
	$dbo=PDBO;

$db=&$this->model->db;
$dbg = PDBG; 
$dbo = PDBO; 


$data['contacts'] = (isset($_GET['contacts']))? $this->model->fetchRows(PDBO.'.`00_contacts`','id,parent_id,name','name'):array();

$data['dbtables'] = $dbtables = array('dbm.05_classrooms','dbo.`00_roles`','dbm.sections','dbm.03_feetypes','dbo.`00_titles`',
'dbm.03_prodtypes','dbm.prodsubtypes');
$tables = array();

foreach($dbtables AS $row){
	$x = explode('.',$row);
	$dbx = $x[0];
	$dbp = $$dbx;
	$table = $x[1];
	$tables[] = $table;	
	$data[$table] = $this->model->fetchRows("{$dbp}.{$table}",'id,name','name');
	

}	/* foreach */



$data['tables'] = $tables;
$this->view->render($data,'mis/idf');

} 	/* fxn */



public function editTeachers($params=NULL){
	$dbo=PDBO;

	include_once(SITE.'views/elements/params_sq.php');
	
	$sort = isset($_GET['sort'])? $_GET['sort']:'c.name';
	$order = isset($_GET['order'])? $_GET['order']:'ASC';
	
	$q = " 
		SELECT 
			cr.id,cr.id AS crid,cr.name AS classroom,cr.acid AS acid,c.is_active,is_cleared,
			c.account,c.name AS adviser,c.is_active,c.id AS ucid,c.parent_id AS pcid,
			c.is_male,
			cr.level_id,cr.section_id,
			cp.`ctp` 			
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.acid = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS cp ON cp.contact_id = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		WHERE c.role_id = '".RTEAC."'
		ORDER BY $sort $order
		
	";
	// pr($q);
	
	$sth = $this->model->db->querysoc($q);
	$data['rows'] 		= $sth->fetchAll();
	$data['num_rows']	= count($data['rows']);
	
	
	if(isset($_POST['submit'])){
		// pr($_POST);
		$posts = $_POST['posts'];
		// pr($posts);
		$q = "";
		foreach($posts AS $post){
			$ucid = trim($post['ucid']);
			$name = trim($post['name']);
			$code = trim($post['account']);
			$q .= "UPDATE {$dbo}.`00_contacts` SET 
				`name` = '$name',`code`='$code',`account`='$code', 
				`is_male` = '".$post['is_male']."',
				`is_active` = '".$post['is_active']."',
				`is_cleared` = '".$post['is_cleared']."'				
			WHERE `id` = '$ucid' LIMIT 1;";
		}
		
		// pr($q);
		// exit;
		$this->model->db->query($q);
		$_SESSION['message'] = 'Teachers profile updated.';
		$url = 'mis/teachers';
		redirect($url);
		exit;
	}	/* post */
	
		
	$this->view->render($data,'mis/editTeachers');


}	/* fxn */





public function deleteContact($params){
	$ucid = $params[0];
	$dbo=PDBO;$dbp=DBP;
	$q = "";
	$q .= "DELETE FROM {$dbo}.`00_contacts` WHERE id = '$ucid' LIMIT 1; ";
	$q .= "DELETE FROM {$dbg}.05_students WHERE contact_id = '$ucid' LIMIT 1; ";
	$q .= "DELETE FROM {$dbg}.06_employees WHERE contact_id = '$ucid' LIMIT 1; ";
	$q .= "DELETE FROM {$dbo}.`00_profiles` WHERE contact_id = '$ucid' LIMIT 1; ";
	$q .= "DELETE FROM {$dbo}.`00_ctp` WHERE contact_id = '$ucid' LIMIT 1; ";
	$q .= "DELETE FROM {$dbo}.photos WHERE contact_id = '$ucid' LIMIT 1; ";
	// pr($q);
	$data['q'] = $q;	
	$this->view->render($data,'mis/query');


}	/* fxn */


public function positionAllCourses($params=NULL){
	$dbo=PDBO;

$dbyr = isset($params[0])? $params[0].US:$_SESSION['sy'].US;
$dbg = VCPREFIX.$dbyr.DBG;
$q = "
	UPDATE {$dbg}.05_courses AS c
		LEFT JOIN {$dbo}.`05_subjects` AS s ON  c.subject_id = s.id
	SET c.position = s.position;	
";

$this->model->db->query($q);
$url = "mis/subjects";
flashRedirect($url,'Courses positioned.');


}	/* fxn */





public function propagateSubjects($params=NULL){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
if(isset($_POST['submit'])){
$post = $_POST['post'];
// pr($post); 

$set = "";
if(isset($post['ctype'])){ $set .= "c.crstype_id = s.crstype_id,"; }
if(isset($post['position'])){ $set .= "c.position = s.position,"; }
if(isset($post['name'])){ $set .= "c.label = s.name,c.name=concat(cr.`name`,'-',s.`code`),"; }
if(isset($post['with_scores'])){ $set .= "c.with_scores = s.with_scores,"; }
if(isset($post['is_kpup'])){ $set .= "c.is_kpup = s.is_kpup,"; }
if(isset($post['parent_id'])){ $set .= "c.supsubject_id = s.parent_id,"; }
if(isset($post['is_num'])){ $set .= "c.is_num = s.is_num,"; }
if(isset($post['weight'])){ $set .= "c.course_weight = s.weight,"; }
if(isset($post['in_genave'])){ $set .= "c.in_genave = s.in_genave,"; }
if(isset($post['affects_ranking'])){ $set .= "c.affects_ranking = s.affects_ranking,"; }
if(isset($post['is_aggregate'])){ $set .= "c.is_aggregate = s.is_aggregate,"; }
if(isset($post['is_displayed'])){ $set .= "c.is_displayed = s.is_displayed,"; }
if(isset($post['is_transmuted'])){ $set .= "c.is_transmuted = s.is_transmuted,"; }
if(isset($post['semester'])){ $set .= "c.semester = s.semester,"; }
$dept_id = $post['dept_id'];
$set = rtrim($set,",");

$sy = isset($params[0])? $params[0]:$_SESSION['sy'];
$dbyr = $sy.US;
$dbg = VCPREFIX.$dbyr.DBG;


$q = "
	UPDATE {$dbg}.05_courses AS c
		LEFT JOIN {$dbg}.05_classrooms AS cr ON  c.crid = cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON  cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_subjects` AS s ON  c.subject_id = s.id
	SET $set
	WHERE l.department_id = '$dept_id'
	;	
";

// $db->query($q);
// $url = "mis/subjects/$sy";
// flashRedirect($url,'Propagated courses');
pr($q);
exit;

}	/* post */


$data = NULL;
$data['depts'] = fetchRows($db,"{$dbo}.`05_departments`","id,code,name","id","WHERE id <6");
$this->view->render($data,'mis/propagateSubjects');

}	/* fxn */



public function criteria($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/criteria.php");
	$db =& $this->model->db;
	
	
	if(isset($_POST['add'])){
		// pr($_POST);
		$q = "INSERT IGNORE INTO {$dbo}.`05_criteria` (`name`,`code`,`crstype_id`) VALUES ";
		$rows = $_POST['criteria'];
		foreach($rows AS $row){
			if(!empty($row['name'])){
				$q .= " ('".$row['name']."','".$row['code']."','".$row['crstype_id']."'),";			
			}
		}	/* foreach */		
		$q = rtrim($q,",");
		$q .= ";";
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/criteria";
		redirect($url);		
		exit;
	}	/* post-add */	
	
/* -------------- edit --------------------------------------------------------------------- */

	if(isset($_POST['edit'])){
		// pr($_POST);
		$rows = $_POST['criteria'];
		$q = "";
		foreach($rows AS $row){
			$q .= " UPDATE {$dbo}.`05_criteria` SET  
					`name` 			= '".$row['name']."',
					`code` 			= '".$row['code']."',
					`position` 		= '".$row['position']."',
					`is_active` 	= '".$row['is_active']."',
					`is_kpup_list` 	= '".$row['is_kpup_list']."',
					`is_raw` 		= '".$row['is_raw']."'
				WHERE `id` = '".$row['cid']."' LIMIT 1;				
			";		
		}	/* foreach */
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "mis/criteria";
		redirect($url);
	
	
	}	/* post-editAll */

	/* for batch delete */
	if(isset($_POST['batch'])){
		$ids = $_POST['rows'];
		foreach($ids AS $id){
			deleteCriteria($db,$id);
		}
		
		$url = 'mis/criteria';
		redirect($url);		
	}
	
	
/* -------------- data --------------------------------------------------------------------- */

	$data['departments']  = $this->model->fetchRows("".PDBO.".`05_departments`");	
	$sort = isset($_GET['sort'])? $_GET['sort']:false;
	$order = isset($_GET['order'])? $_GET['order']:"DESC";
	$data['criteria'] 	  = $this->model->criteriaDetails(PDBG,$sort,$order);
	$data['crstypes'] = $this->model->fetchRows("{$dbo}.`05_crstypes`");
	$data['num_criteria'] = count($data['criteria']);
	$this->view->render($data,'mis/criteria');
}	/* fxn */


public function getComponents($params=NULL){
	$dbo=PDBO;
$sy=isset($params[0])? $params[0]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;

if(isset($_GET['filter'])){
	$params = isset($_GET)? $_GET:array();
	$cond = "";
	$sort = (isset($params['sort']))? $params['sort']:'com.level_id,subject';
	$order = (isset($params['order']))? $params['order']:'ASC';
	
	if (!empty($params['ctype'])){ $cond .= " AND cri.crstype_id = '".$params['ctype']."'"; }				
	if (!empty($params['level_id'])){ $cond .= " AND com.level_id = '".$params['level_id']."'"; }				
	if (!empty($params['criteria_id'])){ $cond .= " AND com.criteria_id = '".$params['criteria_id']."'"; }				
	if (!empty($params['subject_id'])){ $cond .= " AND com.subject_id = '".$params['subject_id']."'"; }				

	$q = "
		SELECT 
			cri.id AS criteria_id,com.id AS component_id,com.*,cri.*,sub.name AS subject,cri.name AS criteria
		FROM {$dbg}.05_components AS com
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON com.subject_id = sub.id
		WHERE 1=1 $cond
		
		ORDER BY $sort $order
	; ";

	// pr($q);
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $rows = $sth->fetchAll();
	$data['count'] = count($rows);


} 	/* get */


/* for batch edits */
if(isset($_POST['batch'])){
	$ids = stringify($_POST['rows']);		
	$url = 'mis/editComponents/'.$ids;
	redirect($url);		
}



$data['ctypes'] = $this->model->fetchRows("{$dbo}.`05_crstypes`","id,name","name");
$data['subjects'] = $this->model->fetchRows("{$dbo}.`05_subjects`","id,name","name");
$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`","id,name","id");
$data['criteria'] = $this->model->fetchRows("{$dbo}.`05_criteria`","id,name","name");

$this->view->render($data,'mis/getComponents');
// $this->view->render($data,'gset/components');


}	/* fxn */



public function promoteAll($params=NULL){
	$dbo=PDBO;
$db=&$this->model->db;	$dbo=PDBO;
$sy=isset($params[0])? $params[0]:DBYR;
$nsy=$sy+1;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
$tmpsxn=1;

echo "Set params as $sy for sy_dbgis.05_summaries <hr />";

$q = "
UPDATE {$dbg}.05_summaries AS x 
INNER JOIN (
	SELECT a.scid,a.crid,b.id AS ncrid
	FROM (select 
			summ.scid,cr.id AS crid,cr.level_id AS lvl,cr.level_id+1 AS nxtlvl
		from {$dbg}.05_summaries AS summ
			left join {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		where cr.`section_id` != '1') AS a	
	LEFT JOIN	
		(SELECT *,id AS ncrid FROM {$dbg}.05_classrooms WHERE section_id = '$tmpsxn' ) AS b
	ON b.level_id = a.nxtlvl
) AS y ON x.scid = y.scid
SET x.crid = y.ncrid;";
	
pr($q);	
	
		
}	/* fxn */
 


public function promoteAll0($params=NULL){
	$dbo=PDBO;
$ssy = $_SESSION['sy'];
$sy = isset($_GET['sy'])? $_GET['sy']:$_SESSION['sy'];
$dbyr = $sy.US;
$dbo=PDBO;
$dbg = VCPREFIX.$dbyr.DBG;
$dbg = VCPREFIX.$dbyr.DBG;

$nsy = $sy+1;
$tmpsxn = '1';

$q = "<h3 class='brown' >Promote All</h3>";
$q .= "
UPDATE {$dbo}.`00_contacts` AS x 
INNER JOIN (
	SELECT a.scid,a.student,a.crid,b.id AS ncrid,a.classroom AS oldclassroom,b.classroom AS nxtclassroom
	FROM (select 
			c.id AS scid,c.name AS student,cr.id AS crid,cr.level_id AS level,cr.level_id+1 AS nxtlvl,cr.name AS classroom
		from {$dbo}.`00_contacts` AS c
			inner join {$dbg}.05_summaries AS summ ON c.id=summ.scid
			left join {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		where c.`role_id`='".RSTUD."' AND c.`is_active` = '1') AS a	
	LEFT JOIN	
		(SELECT *,id AS ncrid,name AS classroom FROM {$dbg}.05_classrooms WHERE section_id = '$tmpsxn' ) AS b
	ON b.level_id = a.nxtlvl
) AS y ON x.id = y.scid
SET x.crid = y.ncrid,x.sy='$nsy',x.prevcrid=y.crid
;";




$q .= "<h3 class='brown' >Update Summaries</h3>";

$q .= "
UPDATE {$dbg}.05_summaries AS x 
INNER JOIN (
	SELECT summ.scid,a.crid,b.id AS ncrid
	FROM (select 
			cr.id AS crid,cr.level_id AS level,cr.level_id+1 AS nxtlvl,cr.name AS classroom
		from {$dbg}.05_summaries AS summ
			left join {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		where cr.`section_id` != '1') AS a	
	LEFT JOIN	
		(SELECT *,id AS ncrid,name AS classroom FROM {$dbg}.05_classrooms WHERE section_id = '$tmpsxn' ) AS b
	ON b.level_id = a.nxtlvl
) AS y ON x.scid = y.scid
SET x.crid = y.ncrid
;";



$q .= "<h3 class='brown' >Update Summaries</h3>";

	$dbg = PDBG;
	$dbg = PDBG;

	$q .= "<h3 class='brown' >Update Tsum</h3>";
	$q .= " 
		UPDATE {$dbg}.03_tsummaries AS a 
		INNER JOIN (
			SELECT 
				c.id AS contact_id,c.crid AS crid,
				cr.acid,t.total
			FROM {$dbo}.`00_contacts` AS c
				INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id		
				INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id		
				INNER JOIN {$dbo}.`03_tuitions` AS t ON cr.level_id 	  = t.level_id		
			WHERE c.is_active = '1'			
		) AS b ON a.scid = b.contact_id 
		SET a.crid = b.crid,a.balance = b.total;
	";		
	
	
$q .= "<h3 class='brown' >Un-Promote All</h3>";
$q .= "UPDATE {$dbo}.`00_contacts` SET crid = prevcrid,sy = '$sy' WHERE `role_id`=1 AND sy = '$nsy';";


$q.="<br /> <h3 class='brown'>Use phpmyadmin to execute query not mis query to work!</h3>";
$data['q'] = $q;
$this->view->render($data,'mis/query');

}	/* fxn */


public function phpinfo(){
	phpinfo();

} 	/* fxn */



public function defvals(){

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$dbx = $_POST['dbx'];
	$where = " WHERE 1=1 ";
	$where .= isset($_POST['where'])? " AND ".$_POST['where']:NULL;
	$tbl = $_POST['dbtable'];
	$q = " UPDATE {$dbx}.{$tbl} SET ";
	foreach($posts AS $row){
		$col = $row['col'];
		$val = $row['val'];
		$q.= "`{$col}` = '{$val}',";
	}
	$q = rtrim($q,",");
	$q .= $where.";";
	$data['q'] = $q;
	pr($q);

	exit;
}	/* post */
	

$data=null;
$this->view->render($data,'mis/defvals');

}	/* fxn */





public function purgeRange($params){
	$dbo=PDBO;
require_once('functions/purge.php');
$db =& $this->model->db;$dbg=PDBG;

$a=$params[0];$b=$params[1];

for($i=$a;$i<=$b;$i++){ purge($db,$dbg,$i);	}

$url = $_SESSION['home'];
flashRedirect($url,'Range of Contacts purged.');


}	/* fxn */





public function gt(){
	$dbo=PDBO;

$file = "C:\system files\bin/terminal.ini";
$t = file_get_contents($file);
$data['terminal'] = $t;
// pr($_SERVER);
$dbg = PDBG;
$ip = $_SERVER['REMOTE_ADDR'];
$q = "select * FROM {$dbg}.ipterminals where `ip` = '$ip' LIMIT 1; ";
pr($q);
$sth = $this->model->db->querysoc($q);
$row = $sth->fetch();
pr($row);
$t = $row['terminal'];
pr($t);



}	/* fxn */



public function zerofyTsum(){
		$dbo=PDBO;
$db=&$this->model->db;
	$dbg=PDBG;
	$q = " UPDATE {$dbg}.03_tsummaries SET `addons` = '0' WHERE `addons` IS NULL; ";
	$q .= " UPDATE {$dbg}.03_tsummaries SET `discounts` = '0' WHERE `discounts` IS NULL; ";
	$q .= " UPDATE {$dbg}.03_tsummaries SET `surcharge` = '0' WHERE `surcharge` IS NULL; ";
	$q .= " UPDATE {$dbg}.03_tsummaries SET `tpaid` = '0' WHERE `tpaid` IS NULL; ";
	$db->query($q);
	flashRedirect("mis","Zerofied Tsum!");
}	/* fxn */

	
	
public function invoicesBalancer(){
	$dbo=PDBO;
$dbg=PDBG;
$q ="
UPDATE {$dbg}.invoices AS x 
LEFT JOIN (
	SELECT p.invoice_id,p.scid,SUM(p.amount) AS paid FROM {$dbo}.30_payments AS p GROUP BY p.invoice_id
) AS y ON x.id = y.invoice_id
SET x.paid=y.paid,x.balance=x.amount-y.paid;";
pr($q);


}	/* fxn */


public function resetCourseNames(){
	$dbo=PDBO;
$db=&$this->model->db;
$dbg=PDBG;

$q="
UPDATE {$dbg}.05_courses AS a
INNER JOIN (
	SELECT cr.id AS crid,cr.id,cr.acid,l.name AS level,s.name AS section,
		s.code AS sxncode,l.code AS lvlcode
	FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id		
) AS b on a.crid=b.id
INNER JOIN {$dbo}.`05_subjects` AS sub ON a.subject_id=sub.id
SET a.name=CONCAT(b.lvlcode,'-',b.sxncode,'-',sub.code)
;";

$db->query($q);
$msg = "Reset Course Names done.";
$url=$_SESSION['home'];
flashRedirect($url,$msg);

}	/* fxn */


public function batchDeleteFees(){
$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

if(isset($_GET['submit'])){
	$params=$_GET;
	$cond="";
	if(!empty($params['crid'])){ unset($params['lvl']); }	
	if (!empty($params['lvl'])){ $cond .= " AND l.id = '".$params['lvl']."' "; }				
	if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."' "; }				
	
	if (!empty($params['feetype_id'])){ $cond .= " AND a.feetype_id = '".$params['feetype_id']."' "; }				
	if (!empty($params['num'])){ $cond .= " AND ft.num = '".$params['num']."' "; }				
	
	$lvl=$_GET['lvl'];
	
	
	
	$q="DELETE a FROM {$dbg}.`30_auxes` AS a 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON a.scid=c.id 		
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 		
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 		
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id 		
		LEFT JOIN {$dbo}.`03_feetypes` AS ft ON a.feetype_id=ft.id 		
		WHERE 1=1 $cond ;";
	pr($q);	
	echo "<a href='".URL."mis/query' >MIS Query</a>";
	exit;
	
}	/* fxn */


$data['feetypes']=fetchRows($db,"{$dbo}.`03_feetypes`","id,name","name");
$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id,section_id");
$this->view->render($data,'mis/batchDeleteFees');

}	/* fxn */

public function purger($params=NULL){
	$dbo=PDBO;
	$data['sy']=isset($params[0])? $params[0]:DBYR;
	$this->view->render($data,'mis/purger');
}	/* fxn */



public function dbsetup($params=NULL){
// $data['dbone']	= $dbone	= $_POST['dbone'];
	$dbo=PDBO;
$data['dbone']	= $dbone	= isset($params[0])? $params[0] : false;
$data['dbtwo']	= $dbtwo	= isset($params[1])? $params[1] : false;
if($dbone){
	$q = " SHOW tables FROM $dbone; ";
	$sth = $this->model->db->querysoc($q);
	$onetables 				= $sth->fetchAll();
	$data['num_onetables']  = $num_onetables		= count($onetables);
	for($i=0;$i<$num_onetables;$i++){ $data['onetables'][$i]['table'] = $onetables[$i]['Tables_in_'.$dbone];  }
	$data['dbonetables'] = buildArray($data['onetables'],'table');
	$_SESSION['mis']['dbsetup']['dbone'] = $dbone;
}	

if($dbone){
	$q = " SHOW tables FROM $dbtwo; ";
	$sth = $this->model->db->querysoc($q);
	$twotables 				= $sth->fetchAll();
	$data['num_twotables'] 	= $num_twotables		= count($twotables);
	$_SESSION['mis']['dbsetup']['dbtwo'] = $dbtwo;

	for($i=0;$i<$num_twotables;$i++){ $data['twotables'][$i]['table'] = $twotables[$i]['Tables_in_'.$dbtwo];  }
	$data['dbtwotables'] = buildArray($data['twotables'],'table');
}

$data['home']	= $home = $_SESSION['home'];

if((isset($_POST['dbone'])) && ($_POST['dbtwo']!="")){
	$url = "mis/dbsetup/".$_POST['dbone'].DS.$_POST['dbtwo'];
	redirect($url);
} 

$databases				= $this->dbselects();
$data['num_databases']	= $num_databases	= count($databases);
for($i=0;$i<$num_databases;$i++){ $data['databases'][$i] = $databases[$i]['Database'];  }


$this->view->render($data,'mis/dbsetup');


} 	/* fxn */






public function dbbackup(){
	$dbo=PDBO;
$db=&$this->model->db;
$dbr="abc aiphp";

$return_var = NULL;
$output = NULL;
// $command = "D:\\xampp/mysql/bin/mysqldump -u ".DBUSER." -h ".DBHOST." --port=".DBPORT." -p".DBPASS." --databases ".$dbr." > C:\Users\MakolEngr\Downloads\asep19c.sql";

$today=str_replace("-","",$_SESSION['today']);
$command = 'D:\\xampp/mysql/bin/mysqldump -u '.DBUSER.' -h '.DBHOST.' --port='.DBPORT.' -p'.DBPASS.' --databases '.$dbr.' > C:\Users\MakolEngr\Downloads\ai-'.$today.'-'.VCFOLDER.'.sql"';

pr($command);
exec($command, $output, $return_var);

echo "dumped sql";


}	/* fxn */


public function purgePOS($params=NULL){
$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;
$db=&$this->model->db;
$data['today']=$today=$_SESSION['today'];
$start=isset($params[0])? $params[0]:$today;
$end=isset($params[1])? $params[1]:$today;
$q="
	DELETE a,b FROM {$dbo}.`30_pos` AS a 
		INNER JOIN {$dbo}.`30_positems` AS b ON a.id=b.pos_id
	WHERE DATE(a.datetime)>='$start' AND DATE(a.datetime)<='$end';
";
$data['q']=$q;
$this->view->render($data,'mis/query');

}	/* fxn */




public function pass($params=NULL){
$data['id']	= $id = isset($params[0])? $params[0]:false;
$db=&$this->model->db;
$dbg = PDBG;
	$dbo=PDBO;

if(isset($_POST['submit'])){
	$row = $_POST['data'];
	if($row['newpass'] === $row['newpass2']){
		$newpass  = $row['newpass'];				
		$mdnew	  = MD5($newpass);				
		$q  = " UPDATE {$dbo}.`00_contacts` SET `pass` = ? WHERE `id` = ? LIMIT 1; ";
		$sth=$db->prepare($q);
		$sth->execute([$mdnew,$id]);    		
				
		$q = " UPDATE {$dbo}.`00_ctp` SET `ctp` = ? WHERE `contact_id` = ? LIMIT 1; ";
		$sth=$db->prepare($q);
		$sth->execute([$newpass,$id]);    				
	} 

}	/* post */

/* ----------------- process ------------------------- */
$q = " SELECT c.*,ctp.*
	FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
	WHERE c.id = '$id' LIMIT 1;		
";

$sth = $this->model->db->querysoc($q);
$data['contact'] = $contact = $sth->fetch();
if(empty($contact['ctp'])){
	$q="INSERT INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`)VALUES('$id','pass'); ";
	$db->query($q);
}


$this->view->render($data,'mgt/pass');


}	/* fxn */



public function dgtl($params=NULL){		/* dgtraits by level */
	$dbo=PDBO;
require_once(SITE."functions/equivs.php");
require_once(SITE."functions/reports.php");
$db=&$this->model->db;
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['cri']=$cri=isset($params[1])? $params[1]:false;
$data['sy']=$sy=isset($params[2])? $params[2]:DBYR;
$data['qtr']=$qtr=isset($params[3])? $params[3]:$_SESSION['qtr'];
$data['levels']=$_SESSION['levels'];
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;

/* 1 */
$q="
	SELECT 
		c.id AS scid,c.name AS student,l.name AS level
	FROM {$dbg}.50_grades AS g 
		INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=g.scid
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
	WHERE cr.level_id='$lvl' AND c.is_active =1 AND cr.section_id>2 LIMIT 1;
";	/* sxns - 1 tmp 2 out */
$sth=$db->querysoc($q);
$studrow=$sth->fetch();
$scid=$studrow['scid'];
$data['level']=$studrow['level'];

/* 2 */
$q = "
	SELECT 
		cri.id AS criteria_id,cri.name AS criteria,cri.code, 
		crs.id AS course_id 
	FROM {$dbg}.50_grades AS g	
		INNER JOIN {$dbo}.`00_contacts` AS c ON g.`scid` = c.`id`
		INNER JOIN {$dbg}.05_courses AS crs ON g.`course_id` = crs.`id`
		INNER JOIN {$dbo}.`05_criteria` AS `cri` ON g.`criteria_id` = cri.`id`
		LEFT JOIN {$dbo}.`05_critypes` AS `ct` ON cri.`critype_id` = ct.`id`
	WHERE 
			crs.`crstype_id` = '".CTYPETRAIT."' 
		AND g.`scid` = '$scid' 
	ORDER BY cri.position,cri.id;
";

$sth=$db->querysoc($q);
$data['cri_array']=$cri_array=$sth->fetchAll();


if($cri){

/* 1 */
$q="select * FROM {$dbo}.`05_criteria` WHERE `id`='$cri' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['cri_row'] = $cri_row = $sth->fetch();

	
/* 2 */
$q="select * FROM {$dbo}.`05_levels` WHERE `id`='$lvl' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$dept=$row['department_id'];
$data['ratings'] = $ratings= getRatings($db,CTYPETRAIT,$dept);		

/* 3 - rows */
$q="
	SELECT 
		g.id AS gid,c.id AS scid,c.code AS studcode,c.name AS student,
		g.q{$qtr} AS grade,g.dg{$qtr} AS dg,sxn.name AS section		
	FROM {$dbg}.50_grades AS g
		INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=g.scid
		INNER JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
	WHERE cr.level_id='$lvl'
		AND crs.crstype_id='".CTYPETRAIT."'
		AND g.criteria_id='".$cri."'
	ORDER BY cr.section_id,c.name;
";	

$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=count($rows);

}	/* cri */
else {
	$data['cri_row']=false;
	$data['count']=false;
}


if(isset($_POST['submit'])){
	$posts=$_POST['posts'];
	$q="";
	foreach($posts AS $post){
		$q.="UPDATE {$dbg}.50_grades SET `dg{$qtr}`='".$post['dg']."' WHERE `id`='".$post['gid']."' LIMIT 1;";
	}
	$db->query($q);
	$url="misc/dgtl/$lvl/$cri/$sy/$qtr";
	flashRedirect($url,'DG Traits Criteria updated.');
	exit;


}	/* post */

$this->view->render($data,'misc/dgtl');	

}	/* fxn */


public function cleanScores(){
	$dbo=PDBO;
$db=&$this->model->db;
$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;
$q="DELETE FROM {$dbg}.50_scores WHERE activity_id < 1;";
pr($q);
echo (!isset($_GET['exe']))? "<a href='".URL."misc/cleanScores?exe' >Execute</a>":NULL;
if(isset($_GET['exe'])){ $db->query($q); echo "Query executed.";  }

// $db->query($q);
// flashRedirect('index','Scores cleaned of zero activities.');

}	/* fxn */




public function actions(){
$db=&$this->model->db;
$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;
$q="SELECT * FROM {$dbo}.`00_actions` ORDER BY name;";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);
$this->view->render($data,'misc/actions');	
// $this->view->render($data,'mis/actions');	

}	/* fxn */





public function duplicateAccounts(){
	$dbo=PDBO;
	$data['duplicates'] = false;
	$fields = "id,code,account,name";
	$q = "
		SELECT $fields
		FROM {$dbo}.`00_contacts`
		WHERE (id=parent_id)
		GROUP BY `account`
		HAVING count(`account`) > 1	
		ORDER BY id		
		;	
	";
	// pr($q);

	$sth = $this->model->db->querysoc($q);
	$rows = $sth->fetchAll(); 
	// pr($rows);
	// exit;
	$data['rows'] = $rows;
	$data['numrows'] = count($rows);

	$data['fields'] = $fields;
	$data['rfields'] = explode(',',$fields);
	$data['numfields'] = count($data['rfields']); 

	$this->view->render($data,'misc/duplicates');


}	/* fxn */





public function aaa(){
$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;


}	/* fxn */
 



 
 
 
 
 

 
} 	/* MisController */

