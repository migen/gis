<?php
Class AdminsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::loginRedirect();
	
	/* 	http://localhost/gis/mis/classrooms/1 */
	$acl = array(array(4,0),array(5,0));
	/* 2nd param is strict,default is false	 */
	$this->permit($acl,0);		
	
}	/* fxn */



public function course($id){	
	/* if(Session::get('status') != 1){ redirect('teachers'); } */
	$dbo=PDBO;
	/* batch edits */
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$url = 'admins/editGrades/'.$ids;
		redirect($url);		
	}
	
	
	/* list students */
	$id = isset($id)? array_shift($id):1;	
	$id = (int)$id;
	Session::set('course_id',$id);
	
	# batch edits
	if(isset($_POST['delete'])){
		$q = "DELETE FROM {$dbg}.50_grades WHERE course_id = $id LIMIT 50";
		// pr($q);
			$r = $this->Admin->db->query($q);
			if(!$r){ pr($q); die('Query failed.');  }		
			else { Session::set('message','Delete Success'); }		
						
			$url = 'admins/course/'.Session::get('course_id');
			redirect($url);					
	}

		
	if($id){
		Session::set('course_id',$id);			
		$data = $this->Admin->course($id);	
		
		$q = "";
		if(isset($_POST['init'])){		
			unset($_POST['init']);	
			// $sy = date('Y',time());
			$sy = $this->Admin->getSettingsValue('sy');
			$q = "INSERT INTO {$dbg}.50_grades (student_id,student_code,course_id,sy) VALUES ";
			foreach($data['students'] AS $row){
				$q .= " ('".$row['student_id']."','".$row['student_code']."','".$_SESSION['course_id']."',$sy),";
			}
			$q = rtrim($q,',');
			$r = $this->Admin->db->query($q);
			if(!$r){ pr($q); die('Query failed.');  }		
			else { Session::set('message','Init Success'); }		
			
			$url = 'admins/course/'.Session::get('course_id');
			redirect($url);					
		} 
				
		$this->view->render($data,'admins/course',$this->layout);
	} else {
		redirect('admins/home');
	}		
}	/* fxn */


public function teacher($code){				/* teacher_id,view classes or courses */
	$dbo=PDBO;
	$code = array_shift($code);	
	if(empty($code)){ redirect('admins/home'); };
	$data = $this->Admin->teacher($code);
	if(!$data){ redirect('admins/home'); }  
	$this->view->render($data,'admins/teacher',$this->layout);
}


public function listTeachers($pid=null){
	$dbo=PDBO;
	/* for batch edits */
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);
		if($_POST['batch'] == 'Edit'){
			$url = 'admins/editTeachers/'.$ids;		
		} else {
			$url = 'admins/editTeacherPasses/'.$ids;		
		}
		redirect($url);		
	}
	
	/* list-pagination */
	$pid = isset($pid)? array_shift($pid):1;	
	$pid = (int)$pid;
	if($pid){
		$data = $this->Admin->listTeachers($pid);
		$this->view->render($data,'admins/listTeachers',$this->layout);
	} else {
		redirect('admins/home');
	}	
}	/* fxn */

public function xeditTeacher($id){
	$id = array_shift($id);
	$this->Admin->xeditTeacher($id); 	
}

public function editTeachers($ids){				
	$dbo=PDBO;
   	if(is_null($ids)){ redirect('admins/index'); }		
	if(isset($_POST['submit'])){
		$rows = $_POST['data']['Teacher'];
		$q = "";
		foreach($rows as $row){			
			$id = $row['id'];	
			// $pass = MD5($row['pass']);
			$q .= " 
				UPDATE {$dbo}.`00_contacts` AS c 
					INNER JOIN {$dbo}.`00_ctp` AS cp ON cp.contact_id = c.id
				SET c.pass = MD5('".$row['pass']."'),c.is_active = '".$row['status']."',
					cp.`ctp` = '".$row['pass']."' 
				WHERE c.id = $id	
			";			
		
		} 
				
		$r = $this->Admin->db->query($q);		
		if(!$r){ pr($q); die('Query failed.');  }		
		else { Session::set('message','Update Success'); }		
		
				
		redirect('admins/listTeachers');				

	} /* submit */
	
	$i = 0;
	foreach($ids as $id){
		$data['Teacher'][$i] = $this->Admin->readTeacher($id);
		$i++;
	}			
	$data = isset($data)? $data : null;		
	$this->view->render($data,'admins/editTeachers',$this->layout);		
}	/* fxn */


public function editTeacherPasses($ids){				
	$dbo=PDBO;
   	if(is_null($ids)){ redirect('admins/index'); }		
	if(isset($_POST['submit'])){
		$rows = $_POST['data']['Teacher'];
		$q = "";
		foreach($rows as $row){			
			$id = $row['id'];	
			if($row['pass'] == $row['confirm_pass']){
				$pass = MD5($row['pass']);
				// $q .= "UPDATE {$dbg}.06_employees SET pass = '".$pass."' WHERE id = $id LIMIT 1;";			

				$q .= " UPDATE {$dbg}.06_employees AS t 
						INNER JOIN {$dbg}.users AS u ON u.person_id = t.person_id
						SET u.pass = '".$pass."' 
						WHERE t.id = $id ;";				
					
				}
			
		} 
		$r = $this->Admin->db->query($q);		
		if(!$r){ pr($q); die('Query failed.');  }		
		else { Session::set('message','Update Success'); }		
		redirect('admins/listTeachers');				

	} /* submit */
	
	$i = 0;
	foreach($ids as $id){
		$data['Teacher'][$i] = $this->Admin->readTeacher($id);
		$i++;
	}			
	$data = isset($data)? $data : null;		
	$this->view->render($data,'admins/editTeacherPasses',$this->layout);		
}		


public function session(){
	$data = $_SESSION;
	$data['sid'] = session_id();
	$this->view->render($data);
}

/* list all {$dbg}.06_employees like index with pagination */
public function listStudents($pid=null){
	$dbo=PDBO;
	# for batch edits
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$url = 'admins/editStudents/'.$ids;
		redirect($url);		
	}
	# list-pagination
	$pid = isset($pid)? array_shift($pid):1;	
	$pid = (int)$pid;
	if($pid){
		// $this->view->js = array('js/jquery.js','js/vegas.js','admins/js/parent.js');	
		$data = $this->Admin->listStudents($pid);
		if(!$data){ redirect('admins/home'); }  	
		$this->view->render($data,'admins/listStudents',$this->layout);
	} else {
		redirect('admins/home');
	}
}


/* choose level of courses */
public function courses(){				
	$dbo=PDBO;
	$this->view->render(null,'admins/courses',$this->layout);		
}

/* choose {$dbg}.05_students  by level-section,link to classes/$id */
public function classrooms(){
	$dbo=PDBO;
	$dbg = PDBG;
	if(isset($_POST['submit'])){
		// pr($_POST);
		$crid = $_POST['data']['Classroom']['crid'];		

		$row = $this->Admin->getLevelSectionByClassroomId($crid);
		$level_id 	= $row['level_id'];
		$section_id = $row['section_id'];
		
		// for redirect
		Session::set('crid',$crid);
		Session::set('level_id',$level_id);
		Session::set('section_id',$section_id);
				
		$url = 'admins/classroom/'.$level_id.'/'.$section_id;
		redirect($url);
	}
	
				
	$data['selects']['classrooms'] = $this->Admin->fetchRows("{$dbg}.05_classrooms","*","level_id");
	$this->view->render($data,'admins/classrooms',$this->layout);		
}


/* different from baseModel jasmin */
public function jasmin(){	/* for autoSuggest */
	$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js','admins/js/parent.js');	

	$keys = $_POST['part'];
	$keys = str_replace('"',"",$keys);
	$keys = str_replace("'","",$keys);
	
	$fields = array('id','name','code');

	/* where */
	$where  = " where ( name like '%".$keys."%' ) ";
		
	$jas = array('id','name');
		
	$data = $this->Admin->jasmin($fields,'students',$where);
	echo '<table class="jasmin">';
	foreach($data as $row){
		echo '<tr>';
		foreach($jas as $j){
			if($j == 'name'){
				echo '<td class="ezfound">'.substr($row[$j],0,30).'</td>';			
			} else {
				echo '<td>'.$row[$j].'</td>';			
			}
		}		
		echo '</tr>';
	}
	echo '</table>';		
}

public function jasminTeachers(){	/* for autoSuggest */
	$dbo=PDBO;
	// $this->view->js = array('js/jquery.js','js/vegas.js','admins/js/parent.js');	

	$keys = $_POST['part'];
	$keys = str_replace('"',"",$keys);
	$keys = str_replace("'","",$keys);
	
	$fields = array('id','name','code');

	/* where */
	$where  = " where ( name like '%".$keys."%' AND is_admin != 1 ) ";

	$jas = array('id','name');
		
	$data = $this->Admin->jasmin($fields,'teachers',$where);
	echo '<table class="jasmin">';
	foreach($data as $row){
		echo '<tr>';
		foreach($jas as $j){
			if($j == 'name'){
				echo '<td class="ezfound">'.substr($row[$j],0,30).'</td>';			
			} else {
				echo '<td>'.$row[$j].'</td>';			
			}
		}		
		echo '</tr>';
	}
	echo '</table>';		
}	/* fxn */


public function topSubject($id){
	$dbo=PDBO;
	$id = array_shift($id);	
	if(empty($id)){ redirect('admins/home'); };
	$data = $this->Admin->topSubject($id);
	$this->view->render($data,'admins/topSubject','full');
}	/* fxn */


public function importGrades(){
$dbo=PDBO;
if(isset($_POST['submit'])){
$data['course_id'] = $_POST['data']['course_id'];

$q = "";		
if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
	$ext = substr($name,-3);
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];

	$data['File'] 			= array();
	$data['File']['name'] 	= $name;
	$data['File']['ext'] 	= $ext;
	$data['File']['type'] 	= $type;
	$data['File']['tmpName']= $tmpName;
	
    // check the file is a csv
    if($ext === 'csv'){
        if(($handle = fopen($tmpName,'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $line = 0;

			$data['Grades'] = array();
            while(($record = fgetcsv($handle,1000,',')) !== FALSE) {
                // number of fields in the csv
                $num = count($record);

                // get the values from the csv
                $data['Grades'][$line]['student_code'] = $record[0];
                $data['Grades'][$line]['student'] = $record[1];
                $data['Grades'][$line]['q1'] = isset($record[2])? $record[2] : null;
                $data['Grades'][$line]['q2'] = isset($record[3])? $record[3] : null;
                $data['Grades'][$line]['q3'] = isset($record[4])? $record[4] : null;
                $data['Grades'][$line]['q4'] = isset($record[5])? $record[5] : null;
                $data['Grades'][$line]['fg'] = isset($record[6])? $record[6] : null;
				
				$q1  = " UPDATE {$dbg}.50_grades SET `q1` = '".$data['Grades'][$line]['q1']."',";
				$q1 .= " `q2` = '".$data['Grades'][$line]['q2']."',";
				$q1 .= " `q3` = '".$data['Grades'][$line]['q3']."',";
				$q1 .= " `q4` = '".$data['Grades'][$line]['q4']."',";
				$q1 .= " `fg` = '".$data['Grades'][$line]['fg']."' ";
				$q1 .= " WHERE `course_id` = '".$data['course_id']."' AND " ;
				$q1 .= " `student_code` = '".$data['Grades'][$line]['student_code']."' ;";
				
				$q .= $q1;                
                $line++;	// increment the line
            } // end while loop
            fclose($handle);
			// echo $q;		
			$r = $this->Admin->db->query($q);
			if(!$r){ pr($q); die('Query failed.');  }		
			else { Session::set('message','Import Success'); }		
			
			$url = 'admins/course/'.$data['course_id'];			
			redirect($url);	
			
        } // if file handle OK
    } // if csv file 
}	// if no csv error
		
			
} // if post-submit


	$data = $this->Admin->selectCourses();
	$data = isset($data)? $data : null;
	$this->view->render($data,'admins/importGrades',$this->layout);
	

}


public function subcomp($x){
	$dbo=PDBO;
	$stypeId = $x[0];
	$rows = $this->Admin->subcomp($stypeId);
	echo json_encode($rows);
}

// level-then sections for classRecords,editClassrooms
public function subsections($x){
	$dbo=PDBO;
	$stypeId = $x[0];
	$rows = $this->Admin->subsections($stypeId);
	echo json_encode($rows);
}



public function doMd5(){ $this->view->render(null,'admins/doMd5'); }


public function classRecords(){ 
	$dbo=PDBO;
	$dbg = PDBG;
	if(isset($_POST['submit'])){
		// pr($_POST);
		$crid = $_POST['data']['Classroom']['crid'];		

		$row = $this->Admin->getLevelSectionByClassroomId($crid);
		$level_id 	= $row['level_id'];
		$section_id = $row['section_id'];
		
		// for redirect
		Session::set('crid',$crid);
		Session::set('level_id',$level_id);
		Session::set('section_id',$section_id);
				
		$url = 'admins/mcr/'.$level_id.'/'.$section_id;
		redirect($url);
		
	}
	$data['selects']['classrooms'] = $this->Admin->fetchRows("{$dbg}.05_classrooms","*","level_id");
				
	$data = isset($data)? $data : null;			
	$this->view->render($data,'admins/classRecords',$this->layout);		

}






// ------------------------------------------------------------------------------------------------------

public function scheduler($params=null){	// teacher,level,classroom,day
$dbo=PDBO;
if(!empty($params)){
	$tcid 			= $params[0];
	$level_id 		= $params[1];
	$day_id 		= $params[2];
}

$data = isset($data)? $data : null;

$this->view->render($data,'admins/scheduler','full');


}	// scheduler





public function xeditCq($params=NULL){
	$dbo=PDBO;
	$crid 		= $_POST['crid'];
	$crsid 		= $_POST['crsid'];
	$supsubjid 	= $_POST['supsubjid'];
	
	// pr($params); exit;
	$ssy 	= $_SESSION['sy'];
	// $qtr 	= $_SESSION['qtr'];
	$qtr 	= $_POST['qtr'];
	$dbg	=	PDBG;
	$dbg	=	PDBG;
	
	$row 	= $_POST;
	
	/* 1 - crid */
	$q = " UPDATE {$dbg}.05_advisers_quarters SET 
				`is_finalized_q$qtr` = '0'
			WHERE `crid` = '".$crid."' LIMIT 1;
	";
	
	/* 2 - this course */
	$q .= " UPDATE {$dbg}.05_courses_quarters SET 
				`is_finalized_q$qtr` = '".$_POST['cq'.$qtr]."'
			WHERE `course_id` = '".$crsid."' LIMIT 1;
	";

	if($supsubjid){
		/* 3 - parent course if exists */
		// $q .= "
			// UPDATE {$dbg}.05_courses_quarters AS a
				// INNER JOIN (
					// SELECT  crs.id AS crsid
					// FROM {$dbg}.05_courses AS crs
					// WHERE 
							// crs.subject_id = '$supsubjid'
						// AND crs.crid = '$crid'	
				// ) AS b ON a.course_id = b.crsid
			// SET 	a.is_finalized_q$qtr = '0';		
		// ";
	
	}
 	
	
	$_SESSION['q'] = $q;
	
	$this->Admin->db->query($q);

}	/* fxn */


public function xeditAq($params=NULL){
	$dbo=PDBO;

	$crid 	= $_POST['crid'];
	$row 	= $_POST;
	$qtr 	= $_POST['qtr'];
	$dbg	= PDBG;
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET 
				`is_finalized_q{$qtr}` = '".$row['aq'.$qtr]."'
			WHERE `crid` = '".$crid."' LIMIT 1;
	";

	$q .= " UPDATE {$dbg}.05_classrooms SET 
				`is_finalized_honors` = '0'
			WHERE id = '".$crid."' LIMIT 1;
	";
	
	
	$_SESSION['q'] = $q;
	$this->Admin->db->query($q);

}	/* fxn */


public function xeditAttq($params=NULL){
$dbo=PDBO;

	$crid 	= $_POST['crid'];
	$row 	= $_POST;
	$qtr 	= $_POST['qtr'];
	
	$dbg	= PDBG;
	
	$q = " UPDATE {$dbg}.05_advisers_quarters SET 
				`attendance_q$qtr` = '".$row['attq'.$qtr]."'
			WHERE `crid` = '".$crid."' LIMIT 1;
	";

	$q .= " UPDATE {$dbg}.05_classrooms SET 
				`is_finalized_honors` = '0'
			WHERE id = '".$crid."' LIMIT 1;
	";
	
	
	$_SESSION['q'] = $q;
	$this->Admin->db->query($q);

}	/* fxn */



public function xeditHonorLocking($params){
$dbo=PDBO;

	$crid 	= $params[0];
	$ifh	= $_POST['ifh'];
	$dbg	= PDBG;
	
	$q = " UPDATE {$dbg}.05_classrooms SET 
				`is_finalized_honors` = '$ifh'
			WHERE id = '".$crid."' LIMIT 1;
	";
	
	$_SESSION['q'] = $q;
	$this->Admin->db->query($q);

}	/* fxn */





private function getLevelsByDepartment($dept_id){
$dbo=PDBO;
	$dbg	= PDBG;
	$q = " SELECT * FROM {$dbo}.`05_levels` WHERE `department_id` = '$dept_id' ";
	// pr($q);
	$sth = $this->Admin->db->querysoc($q);
	return $sth->fetchAll();
}




public function index0($params=NULL){
$dbo=PDBO;
	$data['user'] 	= $user	=	$_SESSION['user'];
	$data['home']	= $home = $_SESSION['home'];
	if($_SESSION['srid']!=RACAD){ $this->flashRedirect($home,'Redirect from admins!'); }
		
	$ssy				= $_SESSION['sy'];
	$data['sy']			= $sy	= isset($params[0])? $params[0]:$ssy;

	
/* --------------- RACAD=4 acad admins or coors ------------------------------------------- */
	if($user['role_id']==RACAD){
		$data['cq'] 	  	= $this->model->cqByAdmin($user['ucid']);
		$data['aq'] 	  	= $this->model->aqByAdmin($user['ucid']);		
	}
			
	$this->view->render($data,'admins/index0');
}	/* fxn */


public function reset($params){
	$ctlr 	= $params[0];
	$this->Admin->sessionizeAdmin();
	redirect($ctlr);
} 	/* fxn */




public function dashboard(){
	$dbo=PDBO;
	$data['sy']		=	$sy 	= $_SESSION['sy'];
	$data['qtr']	=	$qtr 	= $_SESSION['qtr'];
	
	
	



}	/* fxn */



public function index(){
	$dbo=PDBO;
	$user = $_SESSION['user'];
	$data['principal'] = ($user['role_id']==RACAD && $user['privilege_id']==0)? true:false;
	$this->view->render($data,'admins/index');

}	/* fxn */


public function suco(){
$dbo=PDBO;
$data['ucid']	= $ucid = $_SESSION['user']['ucid'];
$data['sy']		= $_SESSION['sy'];
$data['qtr']	= $_SESSION['qtr'];
$dbg = PDBG;

$q = "
	SELECT 
		crs.*,crs.id AS course_id,
		cr.name AS classroom,
		sub.name AS subject
	FROM {$dbo}.`05_subjects`_coordinators AS sac 
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON sac.subject_id = sub.id
		LEFT JOIN {$dbg}.05_courses AS crs ON crs.subject_id = sub.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
	WHERE 
			sac.hcid = '$ucid'	
";
// pr($q);
$sth = $this->model->db->querysoc($q);

$data['courses'] = $courses = $sth->fetchAll();
$data['count'] 	 = count($courses); 

$this->view->render($data,'admins/suco');

}	/* fxn */



public function clsco(){
$dbo=PDBO;
$data['ucid']	= $ucid = $_SESSION['user']['ucid'];
$data['sy']		= $_SESSION['sy'];
$data['qtr']	= $_SESSION['qtr'];
$dbg = PDBG;

$q = "
	SELECT 
		cr.*,cr.id AS crid,cr.name AS classroom
	FROM {$dbg}.05_classrooms AS cr
	WHERE 
			cr.hcid = '$ucid'	
";
// pr($q);
$sth = $this->model->db->querysoc($q);

$data['classrooms'] = $classrooms = $sth->fetchAll();
$data['count'] 	 = count($classrooms); 

$this->view->render($data,'admins/clsco');



}	/* fxn */




} 	/* AdminsController */
