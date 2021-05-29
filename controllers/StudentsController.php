<?php

Class StudentsController extends Controller{	


public function __construct(){
	parent::__construct();
	$this->beforeFilter();	
	// if(!$this->only(array('register'))){ $this->beforeFilter(); }	
	if(!$this->only(array('register','index'))){ 	
		$acl=array(array(5,0),array(2,0),array(4,0),array(9,0),array(1,0));
		// $acl=array(array(5,0),array(2,0),array(4,0),array(9,0));
		$this->permit($acl);				
	}	
	
	if($this->only(['datasheet','paymode','assessment','booklist','tuitions'])){
		if($_SESSION['srid']==RSTUD){ require_once(SITE."functions/schedulesFxn.php"); }
	}
	
	
}	/* fxn */



public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	
}



public function dashboard(){	
	$data = null;		
	$this->view->render($data,'students/dashboard');
}	/* fxn */


public function abc($params=NULL){
	$scid=isset($params[0])? $params[0]:false;
	require_once(SITE.'functions/abcFxn.php');
	$db=&$this->baseModel->db;$sy=DBYR;
	
	$data=syScidAccess($db,$scid);


	$this->view->render($data,'students/abcStudent');
	
}	/* fxn */



public function index(){
	
	
	
	// $data['sy']=$sy=DBYR;
	$data['sy']=$sy=$_SESSION['settings']['sy_grading'];
	$data['prevsy']=$prevsy=($sy-1);
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;$pdbg=VCPREFIX.$prevsy.US.DBG;
	$data['qtr']=$_SESSION['qtr'];	

	$data['srid']=$srid=$_SESSION['srid'];	
	$data['user_is_student']=$user_is_student=($srid==RSTUD)? true:false; 		
	$user=$_SESSION['user'];	
	require_once(SITE."functions/sessionize_student.php");

	$scid=false;


	
	if($user_is_student){
		$scid=$_SESSION['ucid'];
		$student=getStudinfo($db,$sy,$scid);					
		$user=array_merge($user,$student);				
	} else {
		$scid=isset($_GET['scid'])? $_GET['scid']:false;
		if($scid){
			$student=getStudinfo($db,$sy,$scid);			
		}		
	}

	if($scid){
		$data['dept_id']=$student['department_id'];
		$data['level_id']=$student['level_id'];
		$data['scid']=&$scid;
		$data['student']=&$student;
	}	/* scid */

	
	$data['scid']=&$scid;
	$data['user']=&$user;
	$data['db']=&$db;
	$sch=(isset($_GET['sch']))? $_GET['sch']:VCFOLDER;
	$one="homeStudent_{$sch}";$two="students/homeStudent";
	$vfile=cview($one,$two,$sch);vfile($vfile);		
	$data['flash_message']=isset($_SESSION['message'])? $_SESSION['message']:false;

	/* syScidAccess */
	require_once(SITE.'functions/enrollmentFxn.php');
	$data_syScid=syScidAccess($db,$scid);
	$data=array_merge($data_syScid,$data);
	// prx($data);
	
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function filter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data=null;
	$this->view->render($data,'students/filter');
}	/* fxn */



public function links($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
	$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
	$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
	$data['current']=($sy==DBYR)? true:false;

	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0));
	$this->permit($acl);				
	include_once(SITE.'views/elements/dbsch.php');
	
	if($scid){
		$q="SELECT c.id,c.code,c.name,summ.crid,c.`sy` AS csy,cr.name AS classroom,cr.level_id 
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
			WHERE c.`id`='$scid' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row1=$sth->fetch();
		$row2=array();
		$row=array_merge($row1,$row2);
		$data['row']=&$row;		
		
	}
	
	$vfile=isset($_GET['sch'])? "students/linksSch":"students/linksStudents";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */



public function encrid($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['srid']=$srid=$_SESSION['srid'];
	
	if($srid==RSTUD){ $data['scid']=$scid=$_SESSION['ucid']; }
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		// pr($post);exit;		
		$encrid=$post['encrid'];$summcrid=$post['summcrid'];		
		$enid=$post['enid'];$summid=$post['summid'];
	
		$q="UPDATE {$dbo}.05_enrollments SET crid=$encrid WHERE id=$enid LIMIT 1; ";
		$q.="UPDATE {$dbg}.05_summaries SET crid=$summcrid WHERE id=$summid LIMIT 1; ";
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Fail";
		flashRedirect("students/encrid/$scid/$sy",$msg);
		
	}	/* post */
	
if($scid){
	$q="SELECT
			en.id AS enid,summ.id AS summid,c.name AS studname,c.id AS scid,
			en.crid AS encrid,summ.crid AS summcrid,cr.name AS classroom,cr.level_id,cr.num			
		FROM {$dbo}.00_contacts AS c 
		LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=c.id)
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE c.id=$scid LIMIT 1;
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
		
}	/* scid */


	$this->view->render($data,"students/encridStudent");
	
}	/* fxn */



public function edit($params=NULL){
$this->view->js = array('js/jquery.js','js/vegas.js');
$data['scid']=$scid=isset($params[0])? $params[0]:1;
$db=&$this->baseModel->db;$dbo=PDBO;
$q="SELECT *,`sy` AS `csy` FROM {$dbo}.`00_contacts` WHERE id='$scid' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'students/editStudents');

}	/* fxn */



public function enrollment($params=NULL){
	require_once(SITE."functions/dbtools.php");
	$dbo=PDBO;$db=&$this->baseModel->db;	
	$data['params']=$params;
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$data['prevsy']=($sy-1);
	$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.($sy-1).US.DBG;

	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0));
	$this->permit($acl);				

	$data['srid']=$srid=$_SESSION['srid'];
	$scid=isset($params[0])? $params[0]:$_SESSION['ucid'];
	if($srid==RSTUD){ $scid=$_SESSION['ucid']; }
	$data['scid']=$scid;

	/* 2 */	
	if(isset($_POST['submit_student'])){
		$student=$_POST['student'];
		$crid=$student['crid'];				
		$q="SELECT id AS crid,level_id FROM {$pdbg}.05_classrooms WHERE id=$crid LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$promcrid=$row['crid'];
		$promlvl=$row['level_id'];
		
			
		$q="UPDATE {$pdbg}.05_summaries SET promlvl=$promlvl,promcrid=$promcrid WHERE scid=$scid LIMIT 1; ";
		$sth=$db->query($q);
		$q="UPDATE {$dbo}.05_enrollments SET crid=$promcrid WHERE sy=$sy AND scid=$scid LIMIT 1; ";
		$sth=$db->query($q);		
		flashRedirect("students/leveler/$scid","Updated leveler.");					
		exit;		
	}

/* 3 - sync */
/* 3a - check if subject is student */
$q="SELECT c.role_id,c.id AS scid,c.code,c.name,p.birthdate,
	summ.scid AS summscid,en.scid AS enscid,p.contact_id AS profscid,s.contact_id AS studscid
 FROM {$dbo}.00_contacts AS c
LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND c.id=en.scid) 
LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id 
LEFT JOIN {$dbg}.05_students AS s ON c.id=s.contact_id 
WHERE c.id=$scid LIMIT 1;";
$sth=$db->querysoc($q);
$data['studrow']=$row=$sth->fetch();
$subject_is_student=($row['role_id']==RSTUD)? true:false;
$data['subject_is_student']=&$subject_is_student;
if($subject_is_student){
	$q="";
	if(!isset($row['enscid'])){ $q.="INSERT INTO {$dbo}.05_enrollments(sy,scid)VALUES($sy,$scid);"; }
	if(!isset($row['summscid'])){ $q.="INSERT INTO {$dbg}.05_summaries(scid)VALUES($scid);"; }	
	if(!isset($row['profscid'])){ $q="INSERT INTO {$dbo}.00_profiles(contact_id)VALUES($scid);"; }
	if(!isset($row['studscid'])){ $q="INSERT INTO {$dbg}.05_students(contact_id)VALUES($scid);"; }		
	if(!empty($q)){ $sth=$db->query($q); if(!$sth){ pr("Query failed. ".$q); exit; } else { pr("Synced - $q."); } } 
	
	/* 4b - data student enrollment */	
	$q="SELECT c.code,c.name,psum.promlvl,pl.name AS prevlevel			
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=$scid)		
		INNER JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id
		INNER JOIN {$dbo}.05_levels AS pl ON psum.currlvl=pl.id
		WHERE c.id=$scid LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['student']=$sth->fetch();
	debug($data['student']);

	/* 3b */
	$data['text_array']=array('address','remarks','info_siblings');	
	$q="SELECT cr.id AS crid,cr.name AS classroom,cr.level_id AS lvl,l.name AS level
		FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE cr.section_id=1 ORDER BY cr.level_id;";
	$sth=$db->querysoc($q);
	$data['tmp_classrooms']=$sth->fetchAll();
	debug($data['student']);
	// pr($data['student']);
	
}	/* subject_is_student */
	
	if(!isset($_SESSION['paymodes'])){ $_SESSION['paymodes']=fetchRows($db,"{$dbo}.03_paymodes","*","position"); }
	$data['paymodes']=$_SESSION['paymodes'];
	
	/* 4 */
	$sch=VCFOLDER;
	$one="xxxenrollment_{$sch}";$two="students/enrollmentStudent";
	if(is_readable(SITE."views/customs/{$sch}/{$one}.php")){ $vfile="customs/{$sch}/{$one}";
	} else { $vfile=$two; } vfile($vfile);

	$this->view->render($data,$vfile);
		
}	/* fxn */


public function ensumm($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$data['is_admin']=$is_admin=($_SESSION['srid']==RSTUD)? false:true;	
	$data['is_student']=$is_student=($_SESSION['srid']==RSTUD)? true:false;	
	$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	if($is_student){ $scid=$_SESSION['ucid']; }
	$data['scid']=$scid;	
	$url="students/ensumm/$scid";	
	$scid=($is_admin)? $params[0]:$_SESSION['student']['scid'];
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$post['scid']=$scid;
		$sth=$db->add("{$dbo}.05_enrollments",$post);
		$message=($sth)? "Added":"Not added.";
		flashRedirect("students/ensumm/$scid",$message);		
	}	/* fxn */

if($scid){
	$q="SELECT c.id AS scid,c.code AS studcode,c.name AS studname,p.birthdate
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id 
		WHERE c.id=$scid LIMIT 1;";
	debug($q);
	$sth=$db->query($q);
	$data['student']=$sth->fetch();
	$limit=isset($_GET['limit'])? $_GET['limit']:10;if(isset($_GET['all'])){ $limit=100; }

	// 1
	$q="
		SELECT p.sy,p.amount AS balance,cr.name AS classroom,summ.id AS pkid
		FROM {$dbo}.30_payables AS p
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.scid
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE p.scid=$scid ORDER BY sy DESC LIMIT $limit; ";		
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	// 2
	$q="SELECT en.*,cr.name AS classroom,en.id AS enid
		FROM {$dbo}.05_enrollments AS en
		LEFT JOIN {$dbg}.05_classrooms AS cr ON en.crid=cr.id
		WHERE en.scid=$scid ORDER BY sy DESC LIMIT $limit; ";		
	debug($q);
	$sth=$db->querysoc($q);
	$data['ensumm']=$sth->fetchAll();
	$data['ensumm_count']=$sth->rowCount();



		
}	/* scid */
		
	$vfile="students/ensummStudent";
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function editEnrollment($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	require_once(SITE."functions/sessionize_student.php");
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$url="students/editEnrollment/$scid";
	// $q="";
	$url="";
	$data['is_admin']=$is_admin=($_SESSION['srid']==RSTUD)? false:true;
	$scid=($is_admin)? $params[0]:$_SESSION['student']['scid'];

	$data['student']=sessionizeStudinfo($db,$scid);

	if(!isset($_SESSION['classrooms_all'])){
		$q="SELECT id,code,name,acid FROM {$dbg}.05_classrooms ORDER BY level_id; ";
		$sth=$db->querysoc($q);
		$_SESSION['classrooms_all']=$sth->fetchAll();
		
		$q="SELECT id,code,name,acid FROM {$dbg}.05_classrooms WHERE section_id=1 ORDER BY level_id; ";
		$sth=$db->querysoc($q);
		$_SESSION['classrooms_tmp']=$sth->fetchAll();		
	}
	
	$data['classrooms']=(isset($_GET['all']))? $_SESSION['classrooms_all']:$_SESSION['classrooms_tmp'];
	$vfile="students/editEnrollmentStudents";
	$this->view->render($data,$vfile);
	
	
}	/* fxn */


public function add(){

	// $acl = array(array(5,0),array(2,0),array(4,0),array(9,0)); 
	$acl = array(array(5,0)); 
	$this->permit($acl);					
	$data=NULL;
	$vfile="students/addStudent";
	$this->view->render($data,$vfile);
	
}	/* fxn */
	
	
public function reps($params=NULL){
	$acl=array(array(5,0));$this->permit($acl);					
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$data['qtr']=$qtr=isset($params[1])? $params[1]:$_SESSION['qtr'];
	require_once(SITE."functions/dataFxn.php");
	$dataget=getStudentReps($db,$sy);
	$data=array_merge($data,$dataget);
	$this->view->render($data,"students/repsStudents");	
}	/* fxn */


public function ucfstr($a){
	$b=explode(" ",trim($a));
	$x='';
	foreach($b AS $c){
		$c=strtolower($c);
		$x.=ucfirst($c)." ";
		
	}
	$x=rtrim($x," ");
	return $x;	
}



public function register(){
	$acl = array(array(5,0),array(9,0));
	$this->permit($acl);				
		
	require_once(SITE."functions/registration.php");
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=$sy=date('Y');
		
	$data['last_student']=$last_student=getLastStudentRegistered($db);
	$data['last_studcode']=$last_studcode=$last_student['code'];
	
	
	if(isset($_POST['submit'])){
		$profile=$_POST['profile'];
		$contact=$_POST['contact'];
		$extract=extract($profile);
		// $profile['first_name']=$first_name=ucfirst(strtolower($first_name));
		$profile['first_name']=$first_name=$this->ucfstr($first_name);	
		
		$profile['middle_name']=$middle_name=ucfirst(strtolower($middle_name));
		$profile['last_name']=$last_name=ucfirst(strtolower($last_name));
		$contact['name']=$fullname=$last_name.', '.$first_name.' '.$middle_name;

		$contact['pass']=MD5($birthdate);
		$contact['branch_id']=$_SESSION['brid'];
		$contact['account']=$contact['code'];
		$ctp['ctp']=$birthdate;
		$contact['sy']=$sy;
		$contact['title_id']=$contact['role_id']=$contact['privilege_id']=1;
		
		$dbcontacts="{$dbo}.00_contacts";

		$last_ucid=lastId($db,$dbcontacts);
		$new_ucid=$last_ucid+1;
		$contact['id']=$contact['parent_id']=$ctp['contact_id']=$profile['contact_id']=$new_ucid;
		
		// pr($contact);pr($ctp);pr($profile);exit;
		// prx($contact);
		/* dbadd */
		$s1=$db->add("{$dbo}.00_contacts",$contact);
		$s2=$db->add("{$dbo}.00_ctp",$ctp);
		$s3=$db->add("{$dbo}.00_profiles",$profile);
		flashRedirect("students/leveler/$new_ucid","$fullname student registered.");
		exit;
		
	}	/* post */
	
	$this->view->render($data,"students/registerStudent");
	
}	/* fxn */



public function leveler($params=NULL){
	require_once(SITE."functions/dbtools.php");
	$dbo=PDBO;$db=&$this->baseModel->db;	
	$data['params']=$params;
	// $data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$data['prevsy']=($sy-1);
	$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.($sy-1).US.DBG;

	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0));
	$this->permit($acl);				

	$data['srid']=$srid=$_SESSION['srid'];
	$scid=isset($params[0])? $params[0]:$_SESSION['ucid'];
	if($srid==RSTUD){ $scid=$_SESSION['ucid']; }
	$data['scid']=$scid;
	debug($data);

	/* 2 */	
	if(isset($_POST['submit_student'])){
		$student=$_POST['student'];
		extract($student);			
		$q="UPDATE {$dbg}.05_summaries SET crid=$crid WHERE scid=$scid LIMIT 1; ";
		// pr($q);exit;
		$sth=$db->query($q);
		$q="UPDATE {$dbo}.05_enrollments SET crid=$promcrid WHERE sy=$sy AND scid=$scid LIMIT 1; ";
		$sth=$db->query($q);		
		flashRedirect("students/leveler/$scid/$sy","Updated leveler.");					
		exit;		
	}

/* 3 - sync */
/* 3a - check if subject is student */
$q="SELECT c.role_id,c.id AS scid,c.code,c.name,p.birthdate,
	summ.scid AS summscid,en.scid AS enscid,p.contact_id AS profscid,s.contact_id AS studscid,
	pcr.level_id AS prevlvl,(pcr.`level_id`+1) AS promlvl,pcr.name AS prevclassroom,
	cr.level_id AS currlvl
 FROM {$dbo}.00_contacts AS c
LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND c.id=en.scid) 
LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id 
LEFT JOIN {$dbg}.05_students AS s ON c.id=s.contact_id 
LEFT JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id 
LEFT JOIN {$pdbg}.05_classrooms AS pcr ON psum.crid=pcr.id 
WHERE c.id=$scid LIMIT 1;";
$sth=$db->querysoc($q);
$data['student']=$row=$sth->fetch();
$subject_is_student=($row['role_id']==RSTUD)? true:false;
$data['subject_is_student']=&$subject_is_student;
if($subject_is_student){
	$q="";
	if(!isset($row['enscid'])){ $q.="INSERT INTO {$dbo}.05_enrollments(sy,scid)VALUES($sy,$scid);"; }
	if(!isset($row['summscid'])){ $q.="INSERT INTO {$dbg}.05_summaries(scid)VALUES($scid);"; }	
	if(!isset($row['profscid'])){ $q.="INSERT INTO {$dbo}.00_profiles(contact_id)VALUES($scid);"; }
	if(!isset($row['studscid'])){ $q.="INSERT INTO {$dbg}.05_students(contact_id)VALUES($scid);"; }		
	if(!empty($q)){ $sth=$db->query($q); if(!$sth){ pr("Query failed. ".$q); exit; } else { pr("Synced - $q."); } } 
	
	/* 3b */
	// $data['text_array']=array('address','remarks','info_siblings');	
	$q="SELECT cr.id AS crid,cr.name AS classroom,cr.level_id AS lvl,l.name AS level,cr.num
		FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE cr.section_id=1 ORDER BY cr.level_id;";
	$sth=$db->querysoc($q);
	$data['tmp_classrooms']=$sth->fetchAll();
	debug($data['student']);
	
}	/* subject_is_student */

	/* 4 */
	$sch=VCFOLDER;
	$one="xxxenrollment_{$sch}";$two="students/levelerStudent";
	if(is_readable(SITE."views/customs/{$sch}/{$one}.php")){ $vfile="customs/{$sch}/{$one}";
	} else { $vfile=$two; } vfile($vfile);

	$this->view->render($data,$vfile);
		
}	/* fxn */



public function sectioner($params=NULL){
	require_once(SITE."functions/dbtools.php");
	$dbo=PDBO;$db=&$this->baseModel->db;	
	$data['params']=$params;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];	
	$data['prevsy']=($sy-1);
	$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.($sy-1).US.DBG;

	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0),array(7,0));
	$this->permit($acl);				

	$data['srid']=$srid=$_SESSION['srid'];
	$scid=isset($params[0])? $params[0]:$_SESSION['ucid'];
	if($srid==RSTUD){ $scid=$_SESSION['ucid']; }
	$data['scid']=$scid;

	/* 2 */	
	if(isset($_POST['submit_student'])){
		$student=$_POST['student'];
		$crid=$student['crid'];		
		$q="UPDATE {$dbo}.05_enrollments SET crid=$crid WHERE sy=$sy AND scid=$scid LIMIT 1; ";
		$sth=$db->query($q);
		/* 2 */
		$q="UPDATE {$dbg}.05_summaries SET prevcrid=crid,crid=$crid WHERE scid=$scid; ";
		$sth=$db->query($q);		
				
		/* 3 */
		$q="UPDATE {$pdbg}.05_summaries SET promcrid=$crid WHERE scid=$scid; ";		
		$sth=$db->query($q);
		
		
		flashRedirect("students/sectioner/$scid/$sy","Updated sectioner.");			
		exit;		
	}

/* 3 - sync */
/* 3a - check if subject is student */
$q="SELECT c.role_id,c.id AS scid,c.code,c.name,p.birthdate,
	summ.scid AS summscid,en.scid AS enscid,p.contact_id AS profscid,s.contact_id AS studscid,
	pcr.level_id AS prevlvl,(pcr.`level_id`+1) AS promlvl,pcr.name AS prevclassroom,
	cr.level_id AS currlvl,cr.id AS currcrid
 FROM {$dbo}.00_contacts AS c
LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND c.id=en.scid) 
LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id 
LEFT JOIN {$dbg}.05_students AS s ON c.id=s.contact_id 
LEFT JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id 
LEFT JOIN {$pdbg}.05_classrooms AS pcr ON psum.crid=pcr.id 
WHERE c.id=$scid LIMIT 1;";

$sth=$db->querysoc($q);
$data['student']=$row=$sth->fetch();
$subject_is_student=($row['role_id']==RSTUD)? true:false;
$data['subject_is_student']=&$subject_is_student;
extract($row);

if($subject_is_student){
	$q="";
	if(!isset($row['enscid'])){ $q.="INSERT INTO {$dbo}.05_enrollments(sy,scid)VALUES($sy,$scid);"; }
	if(!isset($row['summscid'])){ $q.="INSERT INTO {$dbg}.05_summaries(scid)VALUES($scid);"; }	
	if(!isset($row['profscid'])){ $q="INSERT INTO {$dbo}.00_profiles(contact_id)VALUES($scid);"; }
	if(!isset($row['studscid'])){ $q="INSERT INTO {$dbg}.05_students(contact_id)VALUES($scid);"; }		
	if(!empty($q)){ $sth=$db->query($q); if(!$sth){ pr("Query failed. ".$q); exit; } else { pr("Synced - $q."); } } 
		
	$q="SELECT cr.id AS crid,cr.name AS classroom,cr.level_id AS lvl
		FROM {$dbg}.05_classrooms AS cr
		WHERE cr.level_id=$currlvl;";
	$sth=$db->querysoc($q);
	$data['curr_classrooms']=$sth->fetchAll();
	debug($data['student']);
	
}	/* subject_is_student */
			
	
	/* 4 */
	$sch=VCFOLDER;
	$one="sectionerStudent_{$sch}";$two="students/sectionerStudent";
	if(is_readable(SITE."views/customs/{$sch}/{$one}.php")){ $vfile="customs/{$sch}/{$one}";
	} else { $vfile=$two; } vfile($vfile);

	$this->view->render($data,$vfile);
		
}	/* fxn */



public function feespolicies(){
	$data=NULL;$sch=VCFOLDER;
	$vfile="customs/{$sch}/enrollment_feespolicies_{$sch}";	vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */



public function payments($params=NULL){	// tuition assessment and other fees
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['ucid']=$_SESSION['ucid'];
	$sy=isset($params[1])? $params[1]:DBYR;
	$sy=isset($_GET['sy'])? $_GET['sy']:$sy;	
	$data['sy']=$sy;$sch=VCFOLDER;
	$data['today']=$_SESSION['today'];
	$data['srid']=$srid=$_SESSION['srid'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0),array(1,0));
	$this->permit($acl);				
	include_once(SITE.'views/elements/dbsch.php');
	if($srid==RSTUD){ $data['scid']=$scid=$_SESSION['ucid']; }

	
	if($scid){
		include_once(SITE.'functions/syncFxn.php');		
		include_once(SITE.'functions/enrollmentFxn.php');
		
		// $p1=scidPayments($db,$sy,$scid,$fields=NULL);
		// $p2=scidPayments($db,($sy-1),$scid,$fields=NULL);
		// $payments=array_merge($p1,$p2);
		$payments=scidPaymentsAll($db,$sy,$scid,$fields=NULL);
		$q="SELECT c.code AS studcode,c.name AS studname
			FROM {$dbo}.00_contacts AS c 
			WHERE c.id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['student']=$sth->fetch();
		
		$data['rows']=$payments;
		$data['count']=count($payments);
		
	}	/* scid */
	

	$vfile="students/paymentsStudent";vfile($vfile);
	$this->view->render($data,$vfile);	
	
	
}	/* fxn */




public function registered($params=NULL){
	$db=&$this->model->db;$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT c.sy,c.is_active,c.id AS scid,c.code AS studcode,c.name AS studname,c.account,c.parent_id,c.created,
			summ.scid AS summscid,p.birthdate,l.name AS lvlname,l.code AS lvlcode
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		WHERE c.role_id=".RSTUD." AND c.sy=$sy; ";	
		// WHERE c.role_id=".RSTUD." AND c.sy_registered=$sy; ";	
		
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$q="INSERT INTO {$dbg}.05_summaries(scid)VALUES";
	foreach($rows AS $row){
		if(empty($row['summscid'])){
			$q.="(".$row['scid']."),";
		}
	}	/* foreach */
	$q=rtrim($q,",");$q.=";";
	$sth=$db->query($q);
	
	$vfile="students/registeredStudents";vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */



public function balances($params=NULL){
	require_once(SITE.'functions/sessionize_student.php');
	$db=&$this->model->db;$dbo=PDBO;
	$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['srid']=$srid=$_SESSION['srid'];

	if($srid==RSTUD){
		$scid=$_SESSION['ucid'];	
		$student=$_SESSION['user'];		
	} 
	
	if($scid){
		$student=getStudinfo($db,$sy,$scid);		
		getTotalPreviousBalance($db,$scid);					
		
		$pr=getPayables($db,$scid,$sy=false,$feetype_id=3);
		$data['rows']=&$pr['rows'];
		$data['count']=&$pr['count'];		
	}	/* scid */
	
	$data['scid']=$scid;
	$data['student']=&$student;
	$vfile="students/balancesStudent";vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */



public function payables($params=NULL){
	require_once(SITE.'functions/sessionize_student.php');
	$db=&$this->model->db;$dbo=PDBO;
	$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];	
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['srid']=$srid=$_SESSION['srid'];
		
	if($scid){	
		if($srid==RSTUD){
			$scid=$_SESSION['ucid'];	
			$student=$_SESSION['user'];		
		} else {
			$student=getStudinfo($db,$sy,$scid);		
			getTotalPreviousBalance($db,$scid);			
		}	

		$data['scid']=&$scid;
		$data['student']=&$student;
		
		$pr=getPayables($db,$scid,$sy=false,$feetype_id=3);
		$data['rows']=&$pr['rows'];
		$data['count']=&$pr['count'];
	}	/* scid */	
		
		
	$vfile="students/payablesStudent";vfile($vfile);
	$this->view->render($data,$vfile);


}	/* fxn */



public function bills($params=NULL){	// tuition assessment and other fees
	include_once(SITE.'functions/ornoFxn.php');		
	include_once(SITE.'functions/billsFxn.php');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['ucid']=$_SESSION['ucid'];
	$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$sy=isset($_GET['sy'])? $_GET['sy']:$sy;	
	$data['sy']=$sy;$sch=VCFOLDER;
	$data['today']=$_SESSION['today'];
	$data['srid']=$srid=$_SESSION['srid'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0),array(1,0));
	$this->permit($acl);				
	include_once(SITE.'views/elements/dbsch.php');
	if($srid==RSTUD){ $data['scid']=$scid=$_SESSION['ucid']; }

	if(isset($_POST['submit'])){
		include_once(SITE.'functions/logs.php');
		$feetype_id=$_POST['post']['feetype_id'];
		$ftRow=fetchRow($db,"{$dbo}.03_feetypes",$feetype_id,"id,code,name");
		$feetype=$ftRow['name'];
		$post=$_POST['post'];
		// pr($post);exit;
		/* process-1 */
		extract($post);
		$db->add("{$dbo}.30_payments",$post);
		/* process-2 */
		updateUserOrno($db,$orno,$ecid);		
		/* log-3 */	
		$sy=$post['sy'];
		$studname=$_POST['studname'];	
		$sydetails = ($sy!=DBYR)? " for SY".$sy:NULL;
		$details="{$studname} - bill payment add of P{$amount} for {$feetype}{$sydetails}.";
		textlog($db,$module_id=2,$details,$sy);
	
		/* redirect-4 */		
		$url="students/bills/$scid/$sy";
		flashRedirect($url,"Bill transaction added.");
		exit;
		
	}	/* post */

	
	if($scid){
		/* data-1 */
		$q="SELECT c.code AS studcode,c.name AS studname
			FROM {$dbo}.00_contacts AS c 
			WHERE c.id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['student']=$sth->fetch();

		/* data-2 */
		$bills=scidBills($db,$sy,$scid,$fields=NULL);		
		$data['rows']=&$bills;
		$data['count']=count($bills);
		
	}	/* scid */
	
	$data['feetypes']=$_SESSION['feetypes'];
	$data['paytypes']=$_SESSION['paytypes'];
	$data['nextOrno']=getOrnoNext($db);	// callback

	$vfile="students/billsStudent";vfile($vfile);
	$this->view->render($data,$vfile);	
		
}	/* fxn */



public function logbooks(){
$db=&$this->model->db;$dbo=PDBO;
$data['today']=$today=$_SESSION['today'];
$sy=isset($_GET['sy'])? $_GET['sy']:$_SESSION['settings']['sy_enrollment'];
$data['sy']=$sy;
$dbg=VCPREFIX.$sy.US.DBG;

if(isset($_GET['filter'])){
	$params=$_GET;
	$cond = "";
	if (!empty($params['lvlbeg'])){ $cond .= " AND cr.level_id >= '".$params['lvlbeg']."' "; }				
	if (!empty($params['lvlend'])){ $cond .= " AND cr.level_id <= '".$params['lvlend']."' "; }				
	if(isset($params['is_active']) && ($params['is_active']!='')){
		$cond .= " AND c.is_active = '".$params['is_active']."' ";	}	
	
	$beg=$params['beg'];
	$end=$params['end'];
	$sort = $params['sort'];
		
	$q="SELECT l.datetime,c.id AS scid,c.code AS usercode,c.name AS fullname,
			lvl.name AS level,c.sy,t.name AS logtype
		FROM {$dbo}.`50_logbooks` AS l 
		INNER JOIN {$dbo}.00_contacts AS c ON l.ucid=c.id
		LEFT JOIN {$dbo}.05_logtypes AS t ON l.logtype_id=t.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.`05_levels` AS lvl ON cr.level_id=lvl.id
		WHERE c.role_id=1 AND DATE(l.datetime) >= '$beg' AND DATE(l.datetime) <= '$end' $cond 
		GROUP BY c.id ORDER BY $sort; ";		
	$data['q']=$q;
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	

}	/* get */

$data['levels']=$_SESSION['levels'];

$this->view->render($data,'students/studlogs');

}	/* fxn */


public function level($params=NULL){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['level']=fetchRow($db,"{$dbo}.05_levels",$lvl);

if($lvl){
	$q="SELECT c.sy,c.is_active,c.code AS studcode,c.id AS scid,c.name AS studname,p.birthdate,sxn.code AS sxncode
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.05_sections AS sxn ON cr.section_id=sxn.id
		LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		WHERE cr.level_id=$lvl ORDER BY c.name;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	
} /* lvl */
	
	$data['levels']=$_SESSION['levels'];	
	$this->view->render($data,"students/levelStudents");
	
}	/* fxn */


public function unsetter($params=NULL){
	$dbo=PDBO;
	$key=$params[0];
	$_SESSION[$key]=NULL;	
	unset($_SESSION[$key]);
	$url=$_SESSION['home'];
	flashRedirect($url,"Unset $key.");
}	/* fxn */

public function discempl($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$lvl=isset($paramms[0])? $params[0]:4;
	$sy=isset($paramms[1])? $params[1]:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="SELECT summ.scid,c.name AS studname,ft.name AS feetype,cr.name AS classroom,p.*		
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.30_payables AS p ON p.scid=c.id
		LEFT JOIN {$dbo}.03_feetypes AS ft ON p.feetype_id=ft.id
		WHERE p.sy=$sy AND cr.level_id=$lvl AND ft.code LIKE '%DISCEMP%'
		ORDER BY c.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	$this->view->render($data,"students/discempl");
	
}	/* fxn */



public function clearance($params=NULL){
	$srid=$_SESSION['srid'];
	$scid=($srid==RSTUD)? $_SESSION['ucid']:false;
	$scid=isset($params[0])? $params[0]:$scid;
	if($srid==RSTUD){ $scid=$_SESSION['ucid']; }
	$data['scid']=&$scid;
	if(!$scid){ prx("Scid parameter required."); }
	
	$data['db']=&$this->baseModel->db;	
	$this->view->render($data,"students/clearanceStudent");
	
}	/* fxn */



public function datasheetOK($params=NULL){	
	require_once(SITE."functions/dbtools.php");	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['srid']=$srid=$_SESSION['srid'];
	if($srid==RSTUD){ $data['scid']=$scid=$_SESSION['ucid']; }
	$sch=VCFOLDER;
	$data['db']=&$db;
	$data['dbcontacts']=$dbcontacts="{$dbo}.`00_contacts`";
	$data['dbprofiles']=$dbprofiles="{$dbo}.`00_profiles`";
	$data['dbo']=&$dbo;
	
	/* post */
	if(isset($_POST['submit'])){
		$contact=$_POST['contact'];
		$profile=$_POST['profile'];			
		$sth1=$db->update("{$dbcontacts}",$contact,"id=$scid"); // ps($sth);
		$sth2=$db->update("{$dbprofiles}",$profile,"contact_id=$scid"); // ps($sth);
		flashRedirect("students/datasheet/$scid","Updated datasheet.");							
	}	/* post */
	

	$one="datasheet_{$sch}";$two="students/datasheet";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */


public function ds($params=NULL){	
	require_once(SITE."functions/dbtools.php");	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['srid']=$srid=$_SESSION['srid'];
	if($srid==RSTUD){ $data['scid']=$scid=$_SESSION['ucid']; }
	$sch=VCFOLDER;
	$data['db']=&$db;
	$data['dbcontacts']=$dbcontacts="{$dbo}.`00_contacts`";
	$data['dbprofiles']=$dbprofiles="{$dbo}.`00_profiles`";
	$data['dbo']=&$dbo;
	
	/* ensteps */ 
	$data['axn']=$axn=$this->axn();
	$db=&$this->baseModel->db;$dbo=PDBO;
	$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
	if(is_readable($incfile)){ require_once($incfile);  } 		
	$data['controls']=isset($controls)? $controls:null;
		
	/* post */
	if(isset($_POST['submit'])){
		$contact=$_POST['contact'];
		$profile=$_POST['profile'];			
		if($_POST['submit']=='Finalize'){ $profile['profile_finalized']=1; }
		$sth1=$db->update("{$dbcontacts}",$contact,"id=$scid"); // ps($sth);
		$sth2=$db->update("{$dbprofiles}",$profile,"contact_id=$scid"); // ps($sth);
		flashRedirect("students/datasheet/$scid","Updated datasheet.");							
	}	/* post */
	

	$one="ds_{$sch}";$two="students/datasheet";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	// $this->view->render($data,$vfile,'blank');
	$this->view->render($data,$vfile);

}	/* fxn */



/* enstep-2: paymode */
public function paymode($params=NULL){	/* enstep-2 */
	// if(!isset($params)){ pr("param[0]-scid is required"); exit; }	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['srid']=$srid=$_SESSION['srid'];
	if($srid==RSTUD){ $data[$scid]=$scid=$_SESSION['ucid']; }
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['dbg']=$dbg=VCPREFIX.$sy.US.DBG;
	$data['db']=&$db;
	$dbtable="{$dbg}.05_summaries";
	$data['controls']=null;
		
	if($srid==RSTUD){ 
		$data['scid']=$scid=$_SESSION['ucid']; 
		
		/* schedule */ 	
		$data['ensched']=$ensched=getScheduleEnstep($db,$sy,$scid);
		
		/* ensteps */ 
		$data['axn']=$axn=$this->axn();
		$db=&$this->baseModel->db;$dbo=PDBO;
		$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
		if(is_readable($incfile)){ require_once($incfile); } 		
		$data['controls']=isset($controls)? $controls:null;
		
	}	/* if-student-account */
	
	/* post */
	if(isset($_POST['submit'])){
		$post=$_POST['summ'];$id=$post['id'];		
		
		if($_POST['submit']=='Finalize'){ 
			$contact=$_POST['contact'];
			$db->update("{$dbo}.00_contacts",$contact,"id=$scid"); // ps($sth);			
			
			$step=$_POST['step'];
			$db->update("{$dbo}.05_steps",$step,"scid=$scid AND type='enrollment'");			
		}	/* finalize */		

		$db->update("{$dbtable}",$post,"id=$id");
		flashRedirect("students/paymode/$scid/$sy","Saved.");
		exit;
	}
	
	if($scid){
		/* getData */
		$q="SELECT summ.scid,c.code AS studcode,c.name AS studname,pm.name AS paymode,
				summ.paymode_id,summ.id AS pkid,s.name AS section,
				cr.name AS classroom,cr.level_id,l.name AS level
			FROM {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
			INNER JOIN {$dbo}.05_sections AS s ON cr.section_id=s.id
			INNER JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
			INNER JOIN {$dbo}.03_paymodes AS pm ON summ.paymode_id=pm.id
			WHERE summ.scid=$scid LIMIT 1;
		";
		$sth=$db->querysoc($q);
		$data['row']=$sth->fetch();
		if(!isset($_SESSION['paymodes'])){ $_SESSION['paymodes']=fetchRows($db,"{$dbo}.03_paymodes","*","position"); }
		$data['paymodes']=$_SESSION['paymodes'];	
	}	/* scid */
	$sch=VCFOLDER;$one="paymode_{$sch}";$two="students/paymodeStudent";
	$vfile=cview($one,$two,$sch);vfile($vfile);	
	$this->view->render($data,$vfile);
	
}	/* fxn */




/* enstep-1: paymode */
public function datasheet($params=NULL){	
	require_once(SITE."functions/dbtools.php");	
	require_once(SITE."functions/stepFxn.php");	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$data['srid']=$srid=$_SESSION['srid'];
	$sch=VCFOLDER;
	$data['db']=&$db;
	$data['dbcontacts']=$dbcontacts="{$dbo}.`00_contacts`";
	$data['dbprofiles']=$dbprofiles="{$dbo}.`00_profiles`";
	$data['dbo']=&$dbo;
	$data['controls']=null;


	if($srid==RSTUD){ 
		$data['scid']=$scid=$_SESSION['ucid']; 

		/* schedule */ 	
		$data['ensched']=$ensched=getScheduleEnstep($db,$sy,$scid);
		
		/* ensteps */ 
		$data['axn']=$axn=$this->axn();
		$db=&$this->baseModel->db;$dbo=PDBO;
		$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
		if(is_readable($incfile)){ require_once($incfile); } 		
		$data['controls']=isset($controls)? $controls:null;
		

		
	}	/* if-student-account */
		
	

	/* post */
	if(isset($_POST['submit'])){
		$contact=$_POST['contact'];
		$profile=$_POST['profile'];			
		
		if($_POST['submit']=='Finalize'){ 
			$step=$_POST['step'];
			$db->update("{$dbo}.05_steps",$step,"scid=$scid AND type='enrollment'");			
		}	/* finalize */
		
		$sth1=$db->update("{$dbo}.00_contacts",$contact,"id=$scid"); // ps($sth);
		$sth2=$db->update("{$dbo}.00_profiles",$profile,"contact_id=$scid"); // ps($sth);		
		flashRedirect("students/datasheet/$scid","Updated datasheet.");							
	}	/* post */

	if($scid){ syncStudStep($db,$scid,$type='enrollment'); }

	$one="datasheet_{$sch}";$two="students/datasheet";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	// $this->view->render($data,$vfile,'blank');
	$this->view->render($data,$vfile);

}	/* fxn */




/* enstep-4: assessment */
public function assessment($params=NULL){	/* tuition assessment and other fees */

	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['ucid']=$_SESSION['ucid'];
	$data['srid']=$srid=$_SESSION['srid'];	
	$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$sy=isset($_GET['sy'])? $_GET['sy']:$sy;	
	$data['sy']=$sy;$sch=VCFOLDER;
	$data['today']=$_SESSION['today'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['db']=&$db;
		
	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0),array(1,0));
	$this->permit($acl);				
	include_once(SITE.'views/elements/dbsch.php');
	$data['controls']=null;


	if($srid==RSTUD){ 
		$data['scid']=$scid=$_SESSION['ucid']; 
		
		/* schedule */ 	
		$data['ensched']=$ensched=getScheduleEnstep($db,$sy,$scid);
		
		/* ensteps */ 
		$data['axn']=$axn=$this->axn();
		$db=&$this->baseModel->db;$dbo=PDBO;
		$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
		if(is_readable($incfile)){ require_once($incfile); } 		
		$data['controls']=isset($controls)? $controls:null;
		
	}	/* if-student-account */
	
	if($scid){
		include_once(SITE.'functions/syncFxn.php');		
		include_once(SITE.'functions/enrollmentFxn.php');
		$data1=getAssessmentDataForClearance($db,$sy,$scid);
		$data=array_merge($data,$data1);
		
		$data['prevaccts']=checkPreviousAccounts($db,$sy,$scid);

		
	}	/* scid */
	
	if(!isset($_SESSION['paytypes'])){ $_SESSION['paytypes']=fetchRows($db,"{$dbo}.03_paytypes","id,code,name",$order="id"); }
	$data['paytypes']=$_SESSION['paytypes'];

	$data['lvl']=($scid)? $data['student']['level_id']:4;
	$sch=VCFOLDER;$one="assessmentStudent_{$sch}";$two="students/assessmentStudent";
	$vfile=cview($one,$two,$sch);vfile($vfile);

	if(isset($_GET['data'])){ $vfile="students/assessmentRaw"; }
	$layout=($scid)? "empty":"full";
	$this->view->render($data,$vfile,$layout);	
	
}	/* fxn */




public function tuitions($params=NULL){
	$dbo=PDBO;$sch=VCFOLDER;
	$data['db']=$db=&$this->model->db;
	$data['srid']=$srid=$_SESSION['srid'];
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['controls']=null;

	if($srid==RSTUD){ 
		$data['scid']=$scid=$_SESSION['ucid']; 
	
		/* schedule */ 	
		$data['sched']=$sched=getScheduleByModule($db,$sy,$scid,'tuition');
		
		/* ensteps */ 
		$data['axn']=$axn=$this->axn();
		$db=&$this->baseModel->db;$dbo=PDBO;
		$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
		if(is_readable($incfile)){ require_once($incfile); } 		
		$data['controls']=isset($controls)? $controls:null;
		
		
	}	/* studacct */


	$schema=$dbo;
	
	if(!$scid){ pr("<h3>Parameter scid required.</h3>"); exit; }
	// 1
	$q="SELECT cr.level_id,cr.num
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
		WHERE summ.scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['student']=$student=$sth->fetch();
	$data['lvl']=$lvl=$student['level_id'];
	$num=$student['num'];
	
	// 2
	$data['num']=$num=isset($_GET['num'])? $_GET['num']:$num;
	$q="SELECT d.*,d.id AS pkid,f.name AS feetype,f.parent_id
		FROM {$dbo}.03_tfeedetails AS d
		LEFT JOIN {$dbo}.03_feetypes AS f ON d.feetype_id=f.id
		WHERE d.sy=$sy AND d.level_id=$lvl AND d.num=$num AND d.is_displayed=1 
		ORDER BY d.position;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	// $data['level']=fetchRow($db,"{$dbo}.05_levels",$lvl);
	$q="SELECT l.name,t.level_id,t.num,l.id,t.total AS amount,t.id AS pkid,t.notes,t.num,t.major
		FROM {$dbo}.05_levels AS l
		LEFT JOIN {$dbo}.`03_tuitions` AS t ON l.id=t.level_id
		WHERE t.sy=$sy AND t.level_id=$lvl AND t.num=$num;";
	$sth=$db->querysoc($q);
	$data['level']=$sth->fetch();
	$data['total']=$data['level']['amount'];
	debug($q);debug($data['level']);

	$sch=VCFOLDER;$one="tuitions_{$sch}";$two="students/tuitionsStudent";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	
	$this->view->render($data,$vfile,'blank');

}	/* fxn */


/* enstep-3: booklist */
public function booklist($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];	
	$data['srid']=$srid=$_SESSION['srid'];
	$data['db']=&$db;
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['controls']=null;


	if($srid==RSTUD){ 
		$data['scid']=$scid=$_SESSION['ucid']; 
	
		/* schedule */ 	
		$data['sched']=$sched=getScheduleByModule($db,$sy,$scid,'booklist');
		
		/* ensteps */ 
		$data['axn']=$axn=$this->axn();
		$db=&$this->baseModel->db;$dbo=PDBO;
		$incfile=SITE.'views/customs/'.VCFOLDER.'/enstepFxn_'.VCFOLDER.'.php';
		if(is_readable($incfile)){ require_once($incfile); } 		
		$data['controls']=isset($controls)? $controls:null;
		
		
	}	/* studacct */




	/* post */
	if(isset($_POST['submit'])){
		// prx($_POST);
		$contact=$_POST['contact'];		
		$step=$_POST['step'];
		$db->update("{$dbo}.00_contacts",$contact,"id=$scid"); 
		$db->update("{$dbo}.05_steps",$step,"scid=$scid AND type='enrollment'");							
		flashRedirect("students/booklist/$scid/$sy","Booklist Finalized.");		
	}	/* post */

	if(isset($_POST['unlock'])){
		$q="UPDATE {$dbg}.05_summaries SET booklist_finalized=0 WHERE scid=$scid LIMIT 1; ";
		$db->query($q);
		flashRedirect("students/booklist/$scid","Opened.");		
	}	/* post */


if($scid){
	/* data-1 */	
	$q="SELECT summ.scid,c.code,c.name,cr.name AS classroom,
			cr.level_id,l.name AS level,cr.num,s.name AS section 
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.05_sections AS s ON cr.section_id=s.id
		WHERE summ.scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['student']=$sth->fetch();
	$lvl=$data['student']['level_id'];
	$num=$data['student']['num'];
	
	
	
	$semcond='';
	if($lvl>13){
		$sem=($qtr<2)? 1:2;
		$sem=isset($_GET['sem'])? $_GET['sem']:$sem;
		$semcond=" AND (b.semester=0 OR b.semester=$sem) ";
	}
	

	/* data-2 */
	$qx="SELECT sb.*,sb.id AS pkid,b.name AS book,b.*,s.name AS subjname FROM {$dbg}.50_students_books AS sb 
		INNER JOIN {$dbg}.05_books AS b ON sb.book_id=b.id LEFT JOIN {$dbo}.05_subjects AS s ON b.subject_id=s.id
		WHERE sb.scid=$scid ORDER BY b.name;";
		
	$q="SELECT lb.*,lb.id AS pkid,b.name AS book,b.*,s.name AS subjname
		FROM {$dbg}.05_level_books AS lb 
		INNER JOIN {$dbg}.05_books AS b ON lb.book_id=b.id
		LEFT JOIN {$dbo}.05_subjects AS s ON b.subject_id=s.id
		WHERE lb.level_id=$lvl AND lb.num=$num $semcond ORDER BY b.name;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	
	
}	/* scid */
	
	// $vfile="students/booklistStudentCss";vfile($vfile);
	// $this->view->render($data,$vfile);

	$data['sem']=($data['student']['level_id']>13)? $sem:1;		
	$sch=VCFOLDER;$one="booklist_{$sch}";$two="students/booklistStudentCss";
	$vfile=cview($one,$two,$sch);vfile($vfile);
	
	$this->view->render($data,$vfile,'blank');

	
}	/* fxn */



} /* StudentsController */
