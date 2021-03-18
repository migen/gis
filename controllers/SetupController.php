 <?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

 /* from MyController */
Class SetupController extends Controller{
/*
1) ac (code=account)
2) cricode (code=name)

*/


public function __construct(){
	parent::__construct();
	parent::beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');		
	$acl = array(array(5,0));
	$this->permit($acl);					
	
}	/* fxn */


public function index(){
	$data = NULL;
	$this->view->render($data,'setup/indexSetup');
	
}	/* fxn */


 

public function resetAP(){
	$dbo=PDBO;
	echo "1 - rename tools/enye <br />";
	echo "2 - rosters/batch enyes to crid 99 <br />";
	echo "3 - setup/xcridAP/99 (delete crid aux payments) of crid99 <br />";
	echo "4 - ledgerSetup/99 <br />";
	echo "5 - setup/prevcrid99 - problem here why <br />";
}	/* fxn */




private function setupTraits($lvl,$prq=true,$exe=false){
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;

/* 1 */
$q = "SELECT cri.id AS cri,cri.name AS criteria
	FROM {$dbg}.05_components AS comp
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON comp.criteria_id = cri.id
	WHERE cri.crstype_id = '".CTYPETRAIT."'
		AND comp.level_id = $lvl ";
$sth = $db->querysoc($q);
$criteria = $sth->fetchAll();
$cris = buildArray($criteria,'cri');

/* 2 */
$q = "SELECT cr.id AS crid,cr.name AS classroom FROM {$dbg}.05_classrooms AS cr 
WHERE cr.level_id = '$lvl' AND cr.section_id <> '1' AND cr.section_id <> '2'; ";
$sth = $db->querysoc($q);
$classrooms = $sth->fetchAll();
$crids = buildArray($classrooms,'crid');

$qry="INSERT INTO {$dbg}.50_grades(`scid`,`course_id`,`criteria_id`) VALUES ";
foreach($crids AS $crid){
	/* 3 */
	$q = " SELECT crs.id AS trid,crs.name AS trait
	FROM {$dbg}.05_courses AS crs 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
	WHERE crs.crid = '$crid'
	AND crs.crstype_id = '".CTYPETRAIT."';";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$trid = $row['trid'];
	
	/* 4 */
	$q = "SELECT id AS scid FROM {$dbo}.`00_contacts` WHERE crid = '$crid' AND is_active='1' ORDER BY id; ";
	$sth = $db->querysoc($q);
	$students = $sth->fetchAll();
	$scids = buildArray($students,'scid');
	
	foreach($scids AS $scid){
		foreach($cris AS $cri){			
			$q = "SELECT id FROM {$dbg}.50_grades WHERE `scid` ='$scid' AND `course_id` = '$trid' 
				AND `criteria_id` = '$cri' LIMIT 1; ";
			$sth = $db->query($q);
			$row = $sth->fetch();
			if(!$row){ $qry.="('$scid','$trid','$cri'),"; }						
		}
	}	/* foreach scids */
	

}	/* foreach crids */

	$qry = rtrim($qry ,",");
	$qry .= ";";
	if($prq){ pr($qry); }
	if($exe){ $db->query($qry); }	
	echo "<h3 class='brown'>Traits setup done.</h3>";


}	/* fxn */


public function traits(){
$dbo=PDBO;
$lvl = isset($_GET['lvl'])? $_GET['lvl']:false;
$exe = isset($_GET['exe'])? $_GET['exe']:false;
$prq = isset($_GET['prq'])? $_GET['prq']:false;

if(isset($_GET['submit'])){
	$prq=isset($_GET['prq'])? 1:0;
	$exe=isset($_GET['exe'])? 1:0;
	$this->setupTraits($_GET['lvl'],$prq,$exe);
	exit;
}	/* post */

$data['levels'] = $_SESSION['levels'];
$this->view->render($data,'setup/traits');

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
			`q5_days_total` = '".$row['total']."',`year_days_total` = '".$row['total']."'
			WHERE `id` = '".$row['amid']."' LIMIT 1; 
		";
	}
	$this->model->db->query($q);
	redirect('setup/attmonths/'.$sy);

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

$this->view->render($data,'setup/attmonths','full');


}	/* fxn */



public function primarize($params=NULL){
$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
$ucid=$params[0];
$uc=fetchRow($db,"{$dbo}.`00_contacts`",$ucid);
$pcid=$uc['parent_id'];
$pc=fetchRow($db,"{$dbo}.`00_contacts`",$pcid);

// 1 - transfer of contacts
$q  = " UPDATE {$dbo}.`00_contacts` SET 
	`parent_id`='$ucid' WHERE `parent_id` = '$pcid'; ";

$q .= " UPDATE {$dbo}.`00_contacts` SET `is_active`=1,`name` = '".$pc['name']."',`acn` = '".$pc['acn']."'
WHERE `id` = '$ucid'; ";

// 2 - update ctpX, photo, profile
$q .= " UPDATE {$dbo}.`00_profiles` SET `contact_id` = '$ucid' WHERE `contact_id` = '$pcid' LIMIT 1;  ";
$db->query($q);

}	/* fxn */


/* view should be in teachers folder */
public function lvlcrs($params){
$dbo=PDBO;$db=&$this->baseModel->db;

require_once(SITE."functions/reports.php");
require_once(SITE."functions/details.php");


$data['lvlid']	= $lvlid = isset($params[0])? $params[0] : '1';
$data['ssy']	= $ssy 	 = $_SESSION['sy'];
$data['sy']		= $sy 	 = isset($params[1])? $params[1] : $ssy;

$_SESSION['url'] = "setup/lvlcrs/$lvlid/$sy";
$_SESSION['courses']['lvlid'] = $lvlid;	
$dbg  = VCPREFIX.$sy.US.DBG;	

$data['home']	= $home	= $_SESSION['home'];
$data['user']	= $user	= $_SESSION['user'];

	if(isset($_POST['submit'])){
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
		$db->query($q);
		$url = "mis/lvlcrs/$lvlid/$sy";
		redirect($url);		
	
	}	/* post */
	
//--------------------------- process ---------------------------

	$data['level'] = getLevelDetails($db,$lvlid,$dbg);
	$_SESSION['course']['level_id'] = $data['level']['id'];
	$q = "SELECT 
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
	$data['levels'] 		= $this->model->fetchRows("{$dbo}.`05_levels`","*","id");	
	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	$data['subjects'] 		= $this->model->fetchRows("{$dbo}.`05_subjects`",'*,id AS subid','name',' WHERE `is_active` = 1 ');	
		
	$this->view->render($data,'mis/lvlcrs');

}	/* fxn */



public function loading($params=NULL){
	$dbo=PDBO;$dbg=PDBG;$db=$this->baseModel->db;
	$level_id = isset($params[0])? $params[0]:4;
	$brid=$_SESSION['brid'];
	if(isset($_GET['all'])){ $level_id = false; }
	$data['level_id'] = $level_id;		
	
	if(isset($_POST['batch'])){
		$url="purge/delcrs/";
		foreach($_POST['rows'] AS $id){ $url.=$id.'/'; }
		redirect($url);
		exit;		
	}	/* batch */

	if(isset($_POST['save'])){
		$posts = $_POST['posts'];
		$q="";
		foreach($posts AS $post){
			if($post['tcid']>0){		
				$tcid=$post['tcid'];
				$q.="UPDATE {$dbg}.05_courses SET `tcid`= '$tcid' WHERE `id` = '".$post['crsid']."' LIMIT 1;";
			}
		}
		$db->query($q);
		$url="setup/loading/$level_id";
		flashRedirect($url,'Teachers assigned.');
		exit;
	}	/* save */
	
	$q = " SELECT crs.*,crs.id AS crsid,crs.name AS course,c.name AS teacher,
			crs.tcid AS tcid,cr.name AS classroom,crs.label AS subject 
			FROM {$dbg}.05_courses AS crs
			LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id ";
	if($level_id){ 
		$q .=" WHERE cr.level_id = '$level_id' AND cr.branch_id=$brid ";
		$data['level'] = $this->model->fetchRow("{$dbo}.`05_levels`",$level_id);
	}	
	$q .= "	ORDER BY cr.level_id,section_id; ";
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$data['levels'] = $_SESSION['levels'];
	$where="WHERE `role_id`='".RTEAC."' ";
	$data['teachers'] = fetchRows($db,"{$dbo}.`00_contacts`",'id,parent_id,name','name',$where);
	
	// $this->view->render($data,'setup/loading');
	$this->view->render($data,'setup/loadingSetup');

}	/* fxn */


public function resetCourseNames(){
$dbo=PDBO;
$db=&$this->model->db;
$dbg=PDBG;

$q="UPDATE {$dbg}.05_courses AS a
INNER JOIN (
	SELECT cr.id AS crid,cr.id,cr.acid,l.name AS level,s.name AS section,
		s.code AS sxncode,l.code AS lvlcode
	FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id		
) AS b on a.crid=b.id
INNER JOIN {$dbo}.`05_subjects` AS sub ON a.subject_id=sub.id
SET a.name=CONCAT(b.lvlcode,'-',b.sxncode,'-',sub.code);";

$db->query($q);
$msg = "Reset Course Names done.";
$url=$_SESSION['home'];
flashRedirect($url,$msg);

}	/* fxn */


public function batchDeleteFees(){
$db=&$this->model->db;
$dbo=PDBO;
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


public function initClassrooms($params=NULL){
$dbo=PDBO;
$ssy = $_SESSION['sy'];
$dbg = PDBG;
$q = " UPDATE {$dbg}.05_classrooms SET `is_init_grades` = '0', `init_grades_sy` = '$ssy'; ";
$this->model->db->query($q);
redirect('mis/setup/'.$ssy);

}	/* fxn */


public function syncPrevSumm($params=NULL){
$dbo=PDBO;
$db=&$this->model->db;
$sy=isset($params[0])? $params[0]:DBYR;
$pdbg=VCPREFIX.($sy-1).US.DBG;
$dbg=VCPREFIX.($sy).US.DBG;
 
$q="
	UPDATE {$dbg}.05_summaries AS c
		INNER JOIN {$pdbg}.05_summaries AS p ON c.scid=p.scid
	SET c.crid=p.crid,c.acid=p.acid;
";

pr($q);
$db->query($q);
echo "Summaries crid, acid synced from last SY. ";

}	/* fxn */



public function editMonthsQuarters($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	if(isset($_POST['submit'])){
	$db=&$this->model->db;
	$rows = $_POST['data']['MQ'];
	$q = "";
	foreach($rows AS $row){ 
		$q .= "UPDATE {$dbo}.`05_months_quarters` SET `index` = '".$row['index']."',`quarter` = '".$row['qtr']."' 
			WHERE `id` = '".$row['row_id']."' LIMIT 1; "; }		
	$db->query($q);	
	$msg = "Changes Saved!";
	$url = 'mis/editMonthsQuarters/'.$sy;	
	flashRedirect($url,$msg);	
}	/* post */

	$data['rows'] = $this->model->fetchRows("{$dbo}.`05_months_quarters`",'*');
	$data['numrows'] = count($data['rows']);	
	// $this->view->render($data,'mis/editMonthsQuarters');
	$this->view->render($data,'setup/editMonthsQuarters');
}	/* fxn */


public function gis(){
	
	$data=NULL;
	$this->view->render($data,"setup/gisSetup");
	
}	/* fxn */





public function contacts($params=null){
$dbo=PDBO;$db=$this->baseModel->db;$dbg=PDBG;
$data['sy']=$sy=DBYR;
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/registration.php");
$today=$_SESSION['today'];
$data['pcid']=$pcid=lastId($db,"{$dbo}.00_contacts");

if(isset($_POST['submit'])){
	$rows=$_POST['contacts'];
	pr($rows);
	$q="";
	$mdpass = MD5('pass');	
foreach($rows AS $row){			
	$fullname=trim($row['fullname']);		
	$code=$row['login']; 
	$exists=validateCode($db,$code,$dbg);
if(!$exists){		
	if($fullname){
		$pcid++;	
		/* 1-contacts */
		$q.="INSERT IGNORE INTO {$dbo}.`00_contacts` (`id`,`parent_id`,
			`name`,`code`,`account`,`title_id`,`role_id`,`privilege_id`,
			`pass`,`is_male`)VALUES($pcid,$pcid,'$fullname',
			'".$code."','".$code."','".$row['title']."','".$row['role']."','".$row['priv']."',
			'$mdpass',".$row['is_male']."); ";
		/* 2-profile */
		$q.="INSERT IGNORE INTO {$dbo}.`00_profiles` (`contact_id`)VALUES($pcid); ";		
	}	/* has fullname */ 	
}	/* exists */

}	/* foreach */

	$sth=$db->query($q); // echo ($sth)? "Success":"Fail";
	/* 3-redirect */
	$url = "contacts/ucis/$pcid";
	Session::set('message','Contacts Added!');	
	redirect($url);
	exit;
	
}	/* post-submit */



$data['titles']=fetchRows($db,"{$dbo}.`00_titles`","*");
$data['roles']=fetchRows($db,"{$dbo}.`00_roles`");
$data['departments']=fetchRows($db,"{$dbo}.`05_departments`");

$data['laststud']=lastContact($db,$sy,$stud=1);
$data['lastempl']=lastContact($db,$sy,$stud=0);

$data['lastnum']=lastContactNumber($db,$sy);
$data['delimeter']=$_SESSION['settings']['code_delimeter'];

$this->view->render($data,'setup/contactsSetup');


}	/* fxn */




public function students($params=NULL){	
$dbo=PDBO;
include_once(SITE.'views/elements/params_sq.php');
require_once(SITE."functions/contactsFxn.php");
require_once(SITE."functions/classrooms.php");
require_once(SITE."functions/registration.php");
require_once(SITE."functions/dbyrFxn.php");
$db=&$this->baseModel->db;
$today=$_SESSION['today'];
$_SESSION['url']="setup/students";

$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
$dbexists = checkDbyr($db,$sy);
$data['dbexists']=&$dbexists;
$dbg=VCPREFIX.$sy.US.DBG;

if(isset($_POST['add'])){
	$year = $_SESSION['year'];
	$vars['today'] = $today;
	$vars['title_id'] = "1";
	$vars['role_id'] = "1";
	$vars['privilege_id'] = "1";
	$rows = $_POST['contacts'];	
	$vars['pcid'] = $pcid = lastContactId($db,$dbg);		
	$q = "";
foreach($rows AS $row){
	$vars['pcid']++;
	$q.=qryRegister($db,$dbg,$vars,$row,$sy);		
	
}	/* foreach */	
	$sth=$db->query($q); // echo ($sth)? "Success":"Fail";	
	$url="setup/students";
	flashRedirect($url,'Students added.');
	
}	/* post-add */

$all = (isset($_GET['all']))? true:false;	
$data['classrooms']=isset($_SESSION['tmp_classrooms'])? $_SESSION['tmp_classrooms']:tmpClassrooms($db,$dbg);
if(!isset($_SESSION['tmp_classrooms'])){ $_SESSION['tmp_classrooms']=tmpClassrooms($db,$dbg); }
if($all){ $data['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms",'id,name','level_id,section_id'); }
	
	$data['lastnum']=lastContactNumber($db,$sy);
	$data['laststud']=lastContact($db,$sy,$stud=1);
	$data['prefix']=$_SESSION['settings']['code_prefix'];
	$data['delimeter']=$_SESSION['settings']['code_delimeter'];
	$vfile="setup/studentsSetup";vfile($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */



public function grading($params=NULL){
	$dbo=PDBO;$db=&$this->baseModel->db;
	require_once(SITE."functions/contactsFxn.php");	
	include_once(SITE.'views/elements/params_sq.php');
	$data['sqtr']	= $qtr;
	
	$q1 = " SELECT count(ss.scid) AS numrows FROM {$dbo}.sy_scid AS ss 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON ss.scid = c.id
		WHERE 	c.is_active = 1 AND ss.sy = '$sy'; ";
		
	$q = " SELECT count(en.scid) AS numrows FROM {$dbo}.05_enrollments AS en 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON en.scid = c.id
		WHERE 	c.is_active = 1 AND en.sy = $sy; ";		
	$sth 	= $db->querysoc($q);
	$row	= $sth->fetch(); 
	$data['num_syscid']	= $row['numrows'];
	
	$q = " SELECT count(sum.scid) AS numrows FROM {$dbg}.05_summaries AS sum 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
		WHERE 	c.is_active = 1; ";
	$sth 	= $this->model->db->querysoc($q);
	$row	= $sth->fetch(); 
	$data['num_students']	= $row['numrows'];	
	
	$data['months']		= $this->model->fetchRows("{$dbo}.00_months","*","id");	
	$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");
	$data['teachers']	= $_SESSION['teachers'];

	// $this->view->render($data,'mis/setup');
	$this->view->render($data,'setup/gradingSetup');
	
}	/* fxn */



public function conditions($params=NULL){
	$db=$this->baseModel->db;$dbo=PDBO;
	

	
	if(isset($_POST['submit'])){
		prx($_POST);
		
	}
	
	
	// 1- honors
	$data['conditions']=[
		'honors' => ['genave'],
		'conducts' => ['conduct','absence','tardy'],
		
	];
	
	// 2-levels
	$data['levels']=fetchRows($db,"{$dbo}.05_levels");
	
	// 3-conditions
	$q="SELECT ca.*,l.name AS level		
		FROM {$dbo}.05_conditions_awards AS ca 
		LEFT JOIN {$dbo}.05_levels AS l ON ca.level_id=l.id
		WHERE ca.level_id=$lvl; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	$this->view->render($data,"setup/conditionsSetup");
	
	
}	/* fxn */



} /* SetupController */
