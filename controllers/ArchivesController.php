<?php

/* archives for removed controller functions */



/* ------------ module  -------------------  */
/* ------------ module  -------------------  */
/* ------------ module  -------------------  */
/* ------------ module  -------------------  */
/* ------------ module  -------------------  */


public function booklistEditable($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['year'];
	$data['srid']=$srid=$_SESSION['srid'];
	if($srid==RSTUD){ $data['scid']=$scid=$_SESSION['ucid']; }
	$dbg=VCPREFIX.$sy.US.DBG;

	if(isset($_POST['submit'])){
		$q="UPDATE {$dbg}.05_summaries SET booklist_finalized=1 WHERE scid=$scid LIMIT 1; ";
		$db->query($q);
		flashRedirect("students/booklist/$scid","Finalized.");		
	}	/* post */

	if(isset($_POST['unlock'])){
		$q="UPDATE {$dbg}.05_summaries SET booklist_finalized=0 WHERE scid=$scid LIMIT 1; ";
		$db->query($q);
		flashRedirect("students/booklist/$scid","Opened.");		
	}	/* post */


if($scid){
	/* data-1 */	
	$q="SELECT summ.scid,c.code,c.name,summ.booklist_finalized,cr.name AS classroom,l.name AS level,cr.num 
		FROM {$dbo}.00_contacts AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE summ.scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['student']=$sth->fetch();
	$num=$data['student']['num'];
	

	/* data-2 */
	$q="SELECT sb.*,sb.id AS pkid,b.name AS book,b.*,s.name AS subjname
		FROM {$dbg}.50_students_books AS sb 
		INNER JOIN {$dbg}.05_books AS b ON sb.book_id=b.id
		LEFT JOIN {$dbo}.05_subjects AS s ON b.subject_id=s.id
		WHERE sb.scid=$scid ORDER BY b.name;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
}	/* scid */

	$this->view->render($data,"students/booklistStudent");

	
}	/* fxn */



/* ------------ iframe wrapper -------------------  */
public function iframe(){	
	$data['url']=URL."srcards/scid/1001/2019/2/1?show&both=0&deciave=0";	
	$this->view->render($data,"abc/iframe","iframe");
}


/* ------------ StudentsController datasheet -------------------  */


public function datasheet($params=NULL){
	require_once(SITE."functions/dbtools.php");
	$dbo=PDBO;$db=&$this->baseModel->db;	
	$data['params']=$params;
	$data['sy']=$sy=date('Y');$data['prevsy']=($sy-1);
	$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.($sy-1).US.DBG;

	$data['srid']=$srid=$_SESSION['srid'];
	$scid=isset($params[0])? $params[0]:$_SESSION['ucid'];
	if($srid==RSTUD){ $scid=$_SESSION['ucid']; }
	$data['scid']=$scid;

	/* 2 */
	if(isset($_POST['submit'])){
		$post=$_POST['profiles'];
		$tbl="{$dbo}.`00_profiles`";
		$id=$post['id'];
		unset($post['id']);unset($post['contact_id']); 
		$db->update("{$tbl}",$post,"id=$id");
		flashRedirect("students/datasheet/$scid","Updated profile.");	
		exit;
	}	/* post */
	
	if(isset($_POST['submit_student'])){
		$student=$_POST['student'];
		$name=$student['name'];
		$is_new=$student['is_new'];
		$paymode_id=$student['paymode_id'];
		$info_siblings=$student['info_siblings'];		
		$crid=$student['crid'];		
		$q="UPDATE {$dbo}.00_contacts AS c 
			INNER JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=$scid)
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id=c.id
			SET c.name = '$name',en.is_new=$is_new,en.paymode_id=$paymode_id,s.info_siblings='$info_siblings',en.crid=$crid
			WHERE c.id=$scid; ";
		$sth=$db->query($q);
		/* 2 */
		$q="UPDATE {$pdbg}.05_summaries AS psum 
			LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=psum.scid)
			LEFT JOIN {$dbg}.05_classrooms AS cr ON en.crid=cr.id
			SET psum.promlvl=cr.level_id 
			WHERE psum.scid=$scid; ";
			$sth=$db->query($q);
			// pr($q);
			// echo ($sth)? "Success":"Fail";			
		flashRedirect("students/datasheet/$scid","Updated enrollment.");			
		exit;		
	}

	/* 3 - sync */
	/* 3a */
	$q="SELECT scid AS enscid FROM {$dbo}.05_enrollments WHERE sy=$sy AND scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if(empty($row)){ $q="INSERT INTO {$dbo}.05_enrollments(sy,scid)VALUES($sy,$scid);";$db->query($q); }
	/* 3b */
	$q="SELECT scid FROM {$dbg}.05_summaries WHERE scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if(empty($row)){ $q="INSERT INTO {$dbg}.05_summaries(scid)VALUES($scid);";$db->query($q); }	
	/* 3c */
	$q="SELECT contact_id AS studscid FROM {$dbg}.05_students WHERE contact_id=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if(empty($row)){ $q="INSERT INTO {$dbg}.05_students(contact_id)VALUES($scid);";$db->query($q); }
	
	/* 4a - get data - profile */
	$dr=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except="'null'");
	$data['profiles_cols']=$dr['field_array'];		
	$data['profiles_count']=count($data['profiles_cols']);			
	$data['profile']=fetchRecord($db,"{$dbo}.`00_profiles`","contact_id=$scid");		
	
	/* 4b - data student enrollment */	
	$q="SELECT c.name,en.is_new,en.paymode_id,s.info_siblings,
			psum.promlvl,pl.name AS prevlevel			
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=$scid)		
		INNER JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id
		INNER JOIN {$dbo}.05_levels AS pl ON psum.currlvl=pl.id
		INNER JOIN {$dbg}.05_students AS s ON s.contact_id=c.id
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
	// debug($data['tmp_classrooms']);
	
	/* 4 */
	$sch=VCFOLDER;
	$one="datasheet_{$sch}";$two="students/datasheet";
	if(is_readable(SITE."views/customs/{$sch}/{$one}.php")){ $vfile="customs/{$sch}/{$one}";
	} else { $vfile=$two; } vfile($vfile);

	$this->view->render($data,$vfile);
		
}	/* fxn */




/* ------------ StudentsController -------------------  */

public function beforeFilte(){	// removed 20200529
	if(!$this->only(array('login','logout'))){ 
		parent::beforeFilter();					
		$role=$_SESSION['user']['role_id'];		
		$child=isset($_SESSION['user']['child'])? true : false;
		$student	= ($role == RSTUD)? true : false;		
		if(!$student){ redirect(UNAUTH); }
		if($child){
			$children = array('dashboard','editContact','xeditProfile','reset','index','myTeachers','evaluation','ucis');
			if(!$this->only($children)){ 
				redirect(UNAUTH);
			} 		
		}					
	} /* if-only */	

}	/* fxn */


/* ------------ 20200527 enrollment datasheet -------------------  */

public function datasheet($params=NULL){	// with enrollment
	require_once(SITE."functions/dbtools.php");
	$dbo=PDBO;$db=&$this->baseModel->db;	
	$data['params']=$params;
	$data['sy']=$sy=date('Y');$data['prevsy']=($sy-1);
	$dbg=VCPREFIX.$sy.US.DBG;
	$pdbg=VCPREFIX.($sy-1).US.DBG;

	$data['srid']=$srid=$_SESSION['srid'];
	$scid=isset($params[0])? $params[0]:$_SESSION['ucid'];
	if($srid==RSTUD){ $scid=$_SESSION['ucid']; }
	$data['scid']=$scid;

	/* 2 */
	if(isset($_POST['submit'])){
		$post=$_POST['profiles'];
		$tbl="{$dbo}.`00_profiles`";
		$id=$post['id'];
		unset($post['id']);unset($post['contact_id']); 
		$db->update("{$tbl}",$post,"id=$id");
		flashRedirect("students/datasheet/$scid","Updated profile.");	
		exit;
	}	/* post */
	
	if(isset($_POST['submit_student'])){
		$student=$_POST['student'];
		$name=$student['name'];
		$is_new=$student['is_new'];
		$paymode_id=$student['paymode_id'];
		$info_siblings=$student['info_siblings'];		
		$crid=$student['crid'];		
		$q="UPDATE {$dbo}.00_contacts AS c 
			INNER JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=$scid)
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id=c.id
			SET c.name = '$name',en.is_new=$is_new,en.paymode_id=$paymode_id,s.info_siblings='$info_siblings',en.crid=$crid
			WHERE c.id=$scid; ";
		$sth=$db->query($q);
		/* 2 */
		$q="UPDATE {$pdbg}.05_summaries AS psum 
			LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=psum.scid)
			LEFT JOIN {$dbg}.05_classrooms AS cr ON en.crid=cr.id
			SET psum.promlvl=cr.level_id 
			WHERE psum.scid=$scid; ";
			$sth=$db->query($q);
			// pr($q);
			// echo ($sth)? "Success":"Fail";			
		flashRedirect("students/datasheet/$scid","Updated enrollment.");			
		exit;		
	}

	/* 3 - sync */
	/* 3a */
	$q="SELECT scid AS enscid FROM {$dbo}.05_enrollments WHERE sy=$sy AND scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if(empty($row)){ $q="INSERT INTO {$dbo}.05_enrollments(sy,scid)VALUES($sy,$scid);";$db->query($q); }
	/* 3b */
	$q="SELECT scid FROM {$dbg}.05_summaries WHERE scid=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if(empty($row)){ $q="INSERT INTO {$dbg}.05_summaries(scid)VALUES($scid);";$db->query($q); }	
	/* 3c */
	$q="SELECT contact_id AS studscid FROM {$dbg}.05_students WHERE contact_id=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
	if(empty($row)){ $q="INSERT INTO {$dbg}.05_students(contact_id)VALUES($scid);";$db->query($q); }
	
	/* 4a - get data - profile */
	$dr=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except="'null'");
	$data['profiles_cols']=$dr['field_array'];		
	$data['profiles_count']=count($data['profiles_cols']);			
	$data['profile']=fetchRecord($db,"{$dbo}.`00_profiles`","contact_id=$scid");		
	
	/* 4b - data student enrollment */	
	$q="SELECT c.name,en.is_new,en.paymode_id,s.info_siblings,
			psum.promlvl,pl.name AS prevlevel			
		FROM {$dbo}.00_contacts AS c
		INNER JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=$scid)		
		INNER JOIN {$pdbg}.05_summaries AS psum ON psum.scid=c.id
		INNER JOIN {$dbo}.05_levels AS pl ON psum.currlvl=pl.id
		INNER JOIN {$dbg}.05_students AS s ON s.contact_id=c.id
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
	// debug($data['tmp_classrooms']);
	
	/* 4 */
	$sch=VCFOLDER;
	$one="datasheet_{$sch}";$two="students/datasheet";
	if(is_readable(SITE."views/customs/{$sch}/{$one}.php")){ $vfile="customs/{$sch}/{$one}";
	} else { $vfile=$two; } vfile($vfile);

	$this->view->render($data,$vfile);
		
}	/* fxn */


/* ------------ module  -------------------  */


/* enrollment */
public function popt($params){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$date_enrolled=date('Y-m-d');
	$sy=isset($params[0])? $params[0]:DBYR;	
	$scid=isset($params[1])? $params[1]:11;		
	pr("sy: $sy | scid: $scid");
	pr("Test huge data - performance");
/* 	$q="INSERT INTO {$dbo}.05_enrollments(`sy`,`scid`,`date_enrolled`) VALUES ";
	for($i=10;$i<30000;$i++){
		$scid=$i;
		$q.="($sy,$scid,'$date_enrolled'),";
		
	}
	$q=rtrim($q,",");
	$q.=";";
	$sth=$db->query($q);
	pr($sy);
	echo ($sth)? "success":"fail";
	
 */	
 
$starttime = microtime(true);
	//Do your query and stuff here
	$q="select * from {$dbo}.05_enrollments WHERE sy=$sy and scid=$scid LIMIT 1; ";
	pr($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
$endtime = microtime(true);
	$duration = $endtime - $starttime; //calculates total time taken	
	pr(($duration*1000)." ms");
	$id=lastId($db,"{$dbo}.05_enrollments");
	pr(number_format($id));

}	/* fxn */





/* records */

public function xxxcbatch($params=NULL){	/* custom batch fields */
	require_once(SITE.'functions/dbtools.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";

	/* 1 */
	/* 2 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;
	$except=isset($_GET['except'])? $_GET['except']:"'id'";

	$field_string="id,name";
	$field_string.=isset($_GET['fields'])? ",".$_GET['fields']:NULL;
	$data['columns']=$columns=explode(",",$field_string);	
	$data['num_columns']=count($data['columns']);
	
	// pr($field_string);pr($data);exit;
	
	$data['last_id']=lastId($db,$dbtable);

	/* 2 */
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="INSERT INTO $dbtable(";
		foreach($columns AS $col){
			$q.="`".$col."`,";
		}
		$q=rtrim($q,",");$q.=")VALUES(";
		foreach($posts AS $post){
			foreach($columns AS $col){
				$q.="'".$post[$col]."',";
			}
			$q=rtrim($q,",");$q.="),(";
			
		}
		$q=rtrim($q,",(");$q.=";";
		$sth=$db->query($q);
		if(isset($_GET['debug'])){ echo ($sth)? "Success":"Fail";pr($q); }
		flashRedirect("records/set/$dbtable","Batch add successful.");
		exit;
		
	}	/* post */
	
	$vfile="records/batchRecords";vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */



public function cset($params=NULL){		/* custom set */
	require_once(SITE.'functions/dbtools.php');
	require_once(SITE.'functions/paginationFxn.php');
	$dbo=PDBO;$db=&$this->baseModel->db;
	$dbtable=isset($_GET['dbtable'])? $_GET['dbtable']:"{$dbo}.00_contacts";
	$data['dbtable']=$dbtable=isset($params[0])? $params[0]:"{$dbo}.00_contacts";
	$data['cond']=$cond=isset($_GET['cond'])? $_GET['cond']:"1=1";


	/* 2 */
	$parts=explode(".",$dbtable);$schema=$parts[0];$table=$parts[1];	
	$data['schema']=&$schema;$data['table']=&$table;	

	$field_string="id,name";
	$field_string.=isset($_GET['fields'])? ",".$_GET['fields']:NULL;
	$data['columns']=$columns=explode(",",$field_string);	
	$data['num_columns']=count($data['columns']);
		
	/* 3 */
	$data['limit']=$limit=isset($_GET['limit'])? $_GET['limit']:30;
	$order=in_array("name",$columns)? "name":"id";	
	$data['order']=$order=isset($_GET['order'])? $_GET['order']:$order;
	$q="SELECT * FROM $dbtable WHERE $cond ORDER BY $order ";
	$sth=$db->querysoc($q);$totalCount=$data['totalCount']=$sth->rowCount();
	$data['currPage']=$currPage=isset($_GET['page'])? $_GET['page']:1;
	$data['pagesPerSet']=$pagesPerSet=isset($_GET['perset'])? $_GET['perset']:10;	/* numpages per set */	
	$offset=($currPage-1)*$limit;
	$url="records/set/$dbtable";	
	$data['pagenav']=pagenav($url,$totalCount,$offset,$limit,$currPage,$pagesPerSet);		
	$q.="LIMIT $limit OFFSET $offset; ";	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();	
	$data['count']=$sth->rowCount();	
	debug($q);$data['q']=$q;
	
	$vfile="records/setRecords";vfile($vfile);$this->view->render($data,$vfile);	
}	/* fxn */


/* library/controllers */
public function xxxacl(){
	$_SESSION['surl'] = $this->url(); 
	$tmp = explode('/',$_SESSION['surl']);
	$ctlr = $tmp[0];
	$axn  = isset($tmp[1])? $tmp[1]:'index';
	$root = $_SESSION['root'] = $ctlr.'/'.$axn;
	$rows = $this->acurl($root);
	$_SESSION['acurl'] = buildArray($rows,'title_id');	
	$allowed = in_array($_SESSION['user']['title_id'],$_SESSION['acurl'])? true:false;
	echo ($allowed)? 'allowed in haystack':' NOT allowed';
	
}

private function xxxacurl($root){
	$q = " SELECT * FROM {$dbo}.acl WHERE `url` = '$root'  ";
	$sth = $this->model->db->querysoc($q);
	return $sth->fetchAll();

}


/* AdvisersController */
public function tal($params){	/* tally attendance logs,by acid or guidance */

	require_once(SITE."functions/codes.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/attendance.php");
	$db =& $this->model->db;

	$crid 		= $params[0];
	$sy 		= $data['sy'] = $params[1];
	$qtr 	 	= $data['qtr'] 	= isset($params[2])? $params[2] : $_SESSION['qtr'];	
	$home 	 	= $data['home'] = $_SESSION['home'];

	$dbg  = VCPREFIX.$sy.US.DBG;


$month_id 	= $params[3];
$mc			= getMonthCode($db,$month_id,$dbg);
$mc			= strtolower($mc);
$year		= $sy;

$data['students']=$students=classyear($db,$dbg,$sy,$crid,$male=2,$order="c.`name`");	
$data['attendances'] = array();
$i=0;
if($month_id < 6){ $year = $year+1; }

foreach($data['students'] AS $row){
	$data['attendances'][$i]['scid'] 	= $row['scid'];	
	$data['attendances'][$i][$mc.'_days_present'] = talpre($db,$dbg,$row['scid'],$year,$month_id);	
	$data['attendances'][$i][$mc.'_days_tardy']   = taltar($db,$dbg,$row['scid'],$year,$month_id,$row['timein'],$row['timeout']);	
	$i++;
}	

$q = "";
foreach($data['attendances'] AS $row){
	$q .= " UPDATE {$dbg}.05_attendance SET `".$mc."_days_present` = '".$row[$mc.'_days_present']."',
			`".$mc."_days_tardy` = '".$row[$mc.'_days_tardy']."'
			WHERE `scid` = '".$row['scid']."' LIMIT 1; ";
			
}

	$this->model->db->query($q);
	
	$url = "attendance/monthly/$crid/$sy/$qtr";	
	redirect($url);

}	/* fxn */


public function classAttendanceLogs($params){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/times.php");
	$db =& $this->model->db;

	$data['crid']	= $crid	= $params[0];	
	$data['date']	= $date	= $params[1];	
	
	$data['year']  	= $year	= date('Y',strtotime($date));
	$data['month']  = $month = date('m',strtotime($date));	

	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sy']		= $sy 	= ($month<6)? ($year-1) : $year;
	
	$dbg  = VCPREFIX.$sy.US.DBG;	

	$data['mo']  	= getMonth($db,$data['month'],$code=true,$dbg);
	
/* -------------------------------------------------------------------------- */	
	$q = "
		SELECT			
			c.id,c.code,c.name AS student,al.timein,al.timeout
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN (
				SELECT * FROM {$dbg}.05_attendance_logs WHERE `date` = '$date'			
			) AS al	ON al.contact_id = c.id		
		WHERE 	
				s.`crid` 	= '$crid'
			AND  c.`is_active` 	 	= '1'				
		GROUP BY c.`id`
		ORDER BY c.`is_male` DESC,c.`name` 		
	"; 
 
	// pr($q);
	$sth = $db->querysoc($q);
	$data['attendances'] = $sth->fetchAll();
	$data['num_attendances'] = count($data['attendances']);
	$data['crid'] = $crid;
	$data['date'] = $date;
	$data['cr'] = getClassroomDetails($db,$crid,$dbg);
	
	$this->view->render($data,'teachers/classAttendanceLogs');
	
}	/* fxn */



public function addStudentAttendance($params){
	$crid		= $params[0];
	$scid		= $params[1];
	$sy			= $params[2];
	$qtr		= $params[3];
	
	$dbg  = VCPREFIX.$sy.US.DBG;	
	
	$q = " INSERT INTO {$dbg}.05_attendance (`scid`) VALUES ('$scid'); "; 
	$this->model->db->query($q);		
	$url = "attendance/monthly/$crid/$sy/$qtr";
	redirect($url);

	exit;		
	
}	/* fxn */



public function attdes($params=NULL){

require_once(SITE."functions/classrooms.php");	
require_once(SITE."functions/details.php");
$db =& $this->model->db;

$data['crid']	= $crid	= $params[0];
$data['date']	= $date = isset($params[1])? $params[1]:$_SESSION['today'];
$dbo=PDBO;
$dbg = PDBG;
$dbg = PDBG;

$q = "
	SELECT 
		c.parent_id pcid,b.*,c.name AS contact
	FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		LEFT JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
		LEFT JOIN (
			SELECT att.* FROM {$dbg}.05_attendance_logs AS att WHERE att.date = '$date'
		) AS b ON b.contact_id = c.id
	WHERE 
			summ.crid = '$crid'	
		AND c.is_active = '1'	
	ORDER BY c.name
;";
// pr($q);

$sth = $this->model->db->querysoc($q);
$data['attd'] = $sth->fetchAll();
$data['count'] = count($data['attd']);

$data['classroom'] = getClassroomDetails($db,$crid,$dbg);
$data['classrooms'] = getClassroomsButTmp($db,$dbg);

$this->view->render($data,'registrars/attdes');

}	/* fxn */







Class BlankController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */









}	/* BlankController */
