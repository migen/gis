<?php
Class PurgeController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}

public function beforeFilter(){
	parent::loginRedirect();
	sudo();

	
}	/* fxn */

public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'purge/indexPurge');
}	/* fxn */



public function cir(){
$dbo=PDBO;
	$db=&$this->model->db;$dbg=PDBG;
		
	$where=isset($_GET['all'])? NULL:" WHERE section_id>2 ";	
	$data['rows'] = fetchRows($db,$dbg.'.05_classrooms','id,name','level_id,section_id'," $where");
	$data['count']=count($data['rows']);	
	$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`",'id,name','id');
	$this->view->render($data,'purge/cirPurge');
}	/* fxn */


public function classroomCourses($params=NULL){
$dbo=PDBO;
sudo();
$crid = isset($params[0])? $params[0]:false;
if($crid){
	require_once(SITE."functions/purge.php");
	$db =& $this->model->db;
	$dbg = PDBG;$dbg = PDBG;
	$q=purgeClassroomCoursesQuery($crid);
	pr($q);

}	/* crid */


}	/* fxn */
	
public function levelCourses(){
$dbo=PDBO;
sudo();
$lvl=$_GET['lvl'];
$sub=$_GET['sub'];
$db=&$this->model->db;
$dbg=PDBG;
$dbg=PDBG;

$q="
	DELETE crs,sc,g,ax FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.50_scores AS sc ON sc.course_id = crs.id
		LEFT JOIN {$dbg}.50_activities AS ax ON ax.course_id = crs.id
		LEFT JOIN {$dbg}.50_grades AS g ON g.course_id = crs.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
	WHERE cr.level_id='$lvl' AND crs.subject_id='$sub';
";
pr($q);

}	/* fxn */

public function crSxn($params=NULL){
$dbo=PDBO;
	sudo();
	$crid=$params[0];
	require_once(SITE."functions/purge.php");
	$db=&$this->model->db;
	$q=purgeClassroomCoursesQuery($crid);
	$q.=purgeCrSxnQuery($crid);
	pr($q);

}	/* fxn */
	
public function trsTcid($params){
$dbo=PDBO;
sudo();
$dbg=PDBG;
$tcid=$params[0];
$q="DELETE FROM {$dbg}.50_trsgrades WHERE tcid='$tcid'; ";
pr($q);

}	/* fxn */

public function purger(){
$dbo=PDBO;
	sudo();
	$data=NULL;
	$vfile="mis/purger";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */

public function purgePOS($params=NULL){
$dbo=PDBO;
sudo();
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


public function one($params=NULL){		/* eradicate */
	$dbo=PDBO;
	sudo();
	require_once('functions/purge.php');	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	if($scid){ purge($db,$sy,$scid); 
		// flashRedirect('purge/contact',"Purged #{$scid}."); 
	}	
	// $this->view->render($data,'purge/contactPurge');
	$vfile="purge/onePurge";vfile($vfile);
	$this->view->render($data,$vfile);
	
}		/* fxn */


public function user($params=NULL){		/* eradicate */
$dbo=PDBO;
	sudo();
	require_once('functions/purge.php');
	$db =& $this->model->db;
	$ucid 	= isset($params[0])? $params[0]:false;
	$data['ucid']=&$ucid;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
	$sy=DBYR;
	if($ucid){ 
		purge($db,$sy,$ucid);	
		flashRedirect("purge/user",'Purged '.$ucid.' '.$user['name']);
	}	/* ucid */	
	$this->view->render($data,'purge/user');

}		/* fxn */

public function crsGrades($params){
$dbo=PDBO;
	sudo();
	$dbg=PDBG;
	$crs=$params[0];
	$q=" DELETE FROM {$dbg}.`50_grades` WHERE `course_id` = '$crs'; ";
	pr($q);	

}	/* fxn */

public function clscrs($params){
$dbo=PDBO;
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	$data['crid']=$crid=$params[0];
	$data['sy']=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$q="SELECT cr.id,cr.name,cr.acid,c.name AS adviser FROM {$dbg}.05_classrooms AS cr
		LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id WHERE cr.id='$crid' LIMIT 1; ";
	debug($q,"Classroom");
	$sth=$db->querysoc($q);
	$data['classroom']=$sth->fetch();
	
	$q=" SELECT crs.id AS crs,crs.name AS course,c.name AS teacher
		FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id		
		WHERE crs.crid='$crid'; ";
	debug($q,"Courses");
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'purge/clscrsPurge');
	

}

public function crs($params){
$dbo=PDBO;
	sudo();
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	$crs=$params[0];
	$q="DELETE FROM {$dbg}.05_courses WHERE id='$crs' LIMIT 1; "; 
	$q.="DELETE FROM {$dbg}.50_grades WHERE course_id='$crs'; "; 
	$q.="DELETE FROM {$dbg}.50_scores WHERE course_id='$crs'; "; 
	$q.="DELETE FROM {$dbg}.50_stats WHERE course_id='$crs'; "; 
	$q.="DELETE FROM {$dbg}.50_activities WHERE course_id='$crs'; ";	
	$q.="DELETE FROM {$dbg}.05_courses_quarters WHERE course_id='$crs'; ";	
	// pr($q);	
	echo "<h3>1) Courses 2) Grades 3) Scores 4) Stats 5) Activities 6) CrsQtr </h3>";
		
	$url="purge/crs/$crs";
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Failure";
		flashRedirect($url,$msg);
	}

	$this->view->shovel('homelinks');
	if(!isset($_GET['exe'])){ echo " | <a href='".URL.$url."?exe' >Exe</a>"; }
	if(!isset($_GET['debug'])){ echo " | <a href='".URL.$url."?debug' >Debug</a>"; }
	
}	/* fxn */


public function classlist($params){
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	$crid=$params[0];
	$q=" SELECT summ.scid,c.name AS student FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id WHERE summ.crid='$crid'; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	
	$this->view->render($data,'purge/classlistPurge');
	
}	/* fxn */


public function employees($params=NULL){
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	$rid=isset($params[0])? $params[0]:false;
	if(($rid) OR (isset($_GET['all']))){
		$cond=isset($_GET['all'])? " c.role_id>".RSTUD." ":" c.role_id='$rid' "; 
		$order=isset($_GET['order'])? $_GET['order']:'c.name';
		$q=" SELECT c.id AS ucid,c.name AS employee,c.role_id FROM {$dbo}.`00_contacts` AS c WHERE $cond ORDER BY $order; ";
		debug($q);
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=count($data['rows']);
	} else {
		$data['count']=0;
	}
	// $data['count']=($rid)? count($data['rows']):0;				
	$this->view->render($data,'purge/employeesPurge');

}	/* fxn */

public function activitiesScores($params){
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	$data['crs']=$crs=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$q=" DELETE FROM {$dbg}.50_activities WHERE `quarter`='$qtr' AND `course_id`='$crs';";
	$q.=" DELETE FROM {$dbg}.50_scores WHERE `quarter`='$qtr' AND `course_id`='$crs';";
	echo "<h3>Delete 1) activities 2) scores </h3>";
		
	if(!isset($_GET['exe'])){
		echo "<a href='".URL."purge/activitiesScores/$crs/$sy/$qtr?exe' >Exe</a>";	
	} else {
		$sth=$db->query($q);
		echo ($sth)? "Success":"Failure";		
	}		

}	/* fxn */


public function gis(){
	sudo();	
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;$dbp=PDBP;$sch=VCFOLDER;
	/* 1 truncate */
	$dbotables=array('contacts','ctp','profiles');
	$dbgtables=array('05_attendance','05_calendar','05_clubs','05_components','05_criteria','05_subjects','05_courses','05_courses_quarters','05_courses_traits','05_descriptions','05_equivalents','05_promotions','05_remarks','05_sections','05_classrooms','50_cdtgrades',"50_clubscores_{$sch}",'50_grades','50_logs','50_stats','50_scores','50_tickets','suppliers','05_students','employees');
	$dbptables=array('photos');
	$q="";
	foreach($dbotables AS $table){
		$q.="CREATE TABLE IF NOT EXISTS {$dbo}.{$table}(id INT(6));TRUNCATE {$dbo}.{$table}; ";
	}
	foreach($dbgtables AS $table){
		$q.="CREATE TABLE IF NOT EXISTS {$dbg}.{$table}(id INT(6));TRUNCATE {$dbg}.{$table}; ";
	}
	$q.="CREATE TABLE IF NOT EXISTS {$dbp}.`photos`(id INT(6));TRUNCATE {$dbp}.`photos`; ";	
	
	/* 2  contacts */ $mdpass=MD5('mg1023');		
	$q.="INSERT IGNORE INTO {$dbo}.`00_contacts`(`id`,`parent_id`,`code`,`account`,`name`,`role_id`,`pass`)VALUES
	(1,1,'10231976','mgmis','MakolEngr Go',5,'$mdpass'),(100,1,'10231976','mgreg','',9,'$mdpass');";
	
	/* 3 sections 1-tmp, 2-out */
	$q.="INSERT INTO {$dbo}.`05_sections`(`id`,`code`,`name`) VALUES(1,'TMP','TMP'),(2,'OUT','OUT'); ";
	
	pr($q);
	
	
	$url="purge/gis?exe";
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		

		

}	/* fxn */



public function outcastGrades($params){
$data['crid']=$crid=$params[0];
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
$q="SELECT summ.scid FROM {$dbg}.05_summaries AS summ WHERE summ.crid='$crid';";
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$count=count($rows);
$ids=buildArray($rows,'scid');
$q="";
foreach($ids AS $id){
	$q.="DELETE a FROM {$dbg}.50_grades AS a INNER JOIN {$dbg}.05_courses AS b ON a.course_id=b.id WHERE a.`scid`='$id' AND b.crid<>'$crid'; ";
}
pr($q);
$sth=$db->query($q);
echo ($sth)? "Success":"Failure";


}	/* fxn */


public function outcastCourseGrades($params=NULL){

$data['crs']=$crs=$params[0];
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
$q="SELECT crid FROM {$dbg}.05_courses WHERE id='$crs' LIMIT 1; ";
$sth=$db->querysoc($q);
$crsrow=$sth->fetch();
$crid=$crsrow['crid'];
$q="SELECT summ.scid FROM {$dbg}.05_summaries AS summ WHERE summ.crid='$crid';";
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$ar=buildArray($rows,'scid');

$q="SELECT scid FROM {$dbg}.50_grades WHERE course_id='$crs'; ";
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$br=buildArray($rows,'scid');

$ix=array_diff($br,$ar);
pr($ix);
$q="";
foreach($ix AS $id){ $q.="DELETE FROM {$dbg}.50_grades WHERE `course_id`='$crs' AND `scid`='$id'; "; }
pr($q);

echo "URL add ?exe to execute";
if(isset($_GET['exe'])){ $sth=$db->query($q); echo ($sth)? "Success":"Failure"; }



}	/* fxn */


public function unistudent($params=NULL){	// college student
	if(!isset($params[0])){ pr("Param scid NOT set"); exit; }
	$db=&$this->baseModel->db;$dbg=PDBG;
	$scid=$params[0];
	$q="DELETE FROM {$dbg}.01_summaries WHERE `scid`='$scid' LIMIT 1; ";
	$db->query($q);	
	redirect("purge/contact/$scid");
	
}	/* fxn */


public function pagi($params=NULL){
	reqFxn('paginationFxn');
	$data['currPage']=$currPage=isset($params[0])? $params[0]:1;
	$data['perPage']=$perPage=10;
	$db=&$this->baseModel->db;$dbo=PDBO;


	/* 3 */
	$d=pagination($db,"{$dbo}.`00_contacts`",$perPage,$currPage);
	$data['offset']=$offset=$d['offset'];
	$data['totalCount']=$d['totalCount'];
	$data['totalPages']=$d['totalPages'];
	$data['record_start']=$d['record_start'];
	$data['record_end']=$d['record_end'];

	$q="SELECT * FROM {$dbo}.`00_contacts` ORDER BY name LIMIT $perPage OFFSET $offset; ";
	$sth=$db->querysoc($q);
	pr($q);
	$data['rows']=$sth->fetchAll();$data['count']=$sth->rowCount();

	
	$this->view->render($data,"purge/contactsPurge");
	
	
	
}


public function contacts($params=NULL){
	sudo();
	reqFxn('paginationFxn');
	$data['currPage']=$currPage=isset($params[0])? $params[0]:1;
	$data['perPage']=$perPage=1000;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;

	$d=pagination($db,"{$dbo}.`00_contacts`",$perPage,$currPage);
	$data['offset']=$offset=$d['offset'];
	$data['totalCount']=$d['totalCount'];
	$data['totalPages']=$d['totalPages'];
	$data['record_start']=$d['record_start'];
	$data['record_end']=$d['record_end'];

	/* 3 */	
	$q="SELECT c.id,c.code,c.name,c.role_id,summ.crid FROM {$dbo}.`00_contacts` AS c 
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id ORDER BY c.name LIMIT $perPage OFFSET $offset; ";
	$sth=$db->querysoc($q);
	debug($q);
	$data['rows']=$sth->fetchAll();$data['count']=$sth->rowCount();
	
	$this->view->render($data,"purge/contactsPurge");
	
}	/* fxn */


public function delcrs($params=NULL){
	require_once(SITE."functions/purge.php");
	delcrs($params);	
}	/* fxn */


public function doRange($params=NULL){
	sudo();
	pr("params-0: ucidFrom, params-1: ucidTo ");
	$dbo=PDBO;$db=&$this->baseModel->db;$dbg=PDBG;
	require_once('functions/purge.php');
	$a=$params[0];$b=$params[1];
	$sy=DBYR;
	for($i=$a;$i<=$b;$i++){ purge($db,$sy,$i);	}
	echo "Purged done ucids #$a - #$b. ";
	
	
	// flashRedirect($url,'Range of Contacts purged.');
}	/* fxn */


public function logbooks($params=NULL){
	if(!isset($params[0])){ pr("Param Year required."); exit; }
	$data['year']=$year=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbtable="{$dbo}.50_logbooks";
	
	$q="DELETE FROM {$dbtable} WHERE YEAR(datetime) = '$year'; ";
	pr("&exe");
	pr($q);
	if(isset($_GET['exe'])){ 
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
	}


}	/* fxn */

 
} 	/* PurgeController */
