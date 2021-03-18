<?php

Class XgradesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->layout="expired";

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){
	$data=NULL;
	$this->view->render($data,'xgrades/indexXgrades');
}


public function cir($params=NULL){

require_once(SITE."functions/cir.php");	
$data['ssy']=$ssy=DBYR;
$data['sqtr']=$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[0])? $params[0]:$ssy;
$data['qtr']=$qtr=isset($params[1])? $params[1]:$sqtr;

$allowed = array(RMIS,RREG,RACAD,RADMIN);

$data['srid'] = $srid = $_SESSION['srid'];
$home = $_SESSION['home'];
if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
$data['all'] = $all = isset($_GET['all'])? true:false;
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;


if(isset($_GET['sch']) || isset($params[0])){
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$dbo=VCPREFIX."dbone_{$sch}";$dbg=VCPREFIX.$sy."_dbgis_{$sch}";
	$data['classrooms'] = getCirList($db,$dbg,$cond=NULL);
} else {
	$data['classrooms'] = sessionizeCirList($_GET,$db,$dbg);
}
$data['count'] = count($data['classrooms']);
$view=isset($_GET['sch'])? "cir/indexCirSch":"cir/indexCir";
$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$ucfsch=ucfirst($sch);
$one="xgrades/{$sch}/cirXgrades{$ucfsch}";
$two="xgrades/cirXgrades";
$vfile=view($one,$two,$sch);

vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



public function classlist($params){
	require_once(SITE.'functions/details.php');
	require_once(SITE.'functions/classlists.php');
	require_once(SITE.'functions/classrooms.php');
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])? $params[1] : DBYR;
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$cr = $data['cr'] = getClassroomDetails($db,$crid,$dbg,$ctp=true);				
	$acid=$cr['acid'];
	if(!canViewClasslist($db,$acid,$crid)){ flashRedirect(UNAUTH); }
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts']; $q="";
		foreach($posts AS $post){
			$q.="UPDATE {$dbo}.`00_contacts` SET `is_male`='".$post['is_male']."', 
				`code`='".$post['code']."',`lrn`='".$post['lrn']."', 
				`position`='".$post['position']."',`name`='".$post['name']."' 
				WHERE `id`='".$post['scid']."' LIMIT 1;";
		}
		$db->query($q);
		$url="classlists/classroom/$crid/$sy";		
		flashRedirect($url,"Classlist students edited.");
		exit;		
	}	/* post */
	
	$order=$_SESSION['settings']['classlist_order'];
	$order=isset($_GET['order'])? $_GET['order']:$order;
	debug($order,"Order: ");
	$rows=getClasslist($db,$dbg,$crid,$order);
	$data['count']=count($rows);
	$data['rows']=&$rows;
	
	
	
	// $vfile="expired/grades/classlistExpired";

	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$ucfsch=ucfirst($sch);
	$one="xgrades/{$sch}/xgradesClasslist{$ucfsch}";
	$two="xgrades/xgradesClasslist";
	$vfile=view($one,$two,$sch);	
	vfile($vfile);
	
	// $data['classrooms']=$_SESSION['cirlist'];
	
	$this->view->render($data,$vfile);	

}	/* fxn */



public function profile($params=NULL){
$this->view->js = array('js/jquery.js','js/vegas.js');
$data['scid']=$scid = isset($params[0])? $params[0]:false;
$data['sy']=$sy = isset($params[1])? $params[1]:DBYR;

$has_axis=($_SESSION['settings']['has_axis']==1)? true:false;
$data['scid'] = $scid = ($_SESSION['srid']==RSTUD)? $_SESSION['pcid']:$scid;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;

include_once(SITE.'views/elements/dbsch.php');

/* 1 */
$data['contact'] = $contact = fetchRecord($db,"{$dbo}.`00_contacts`","id='$scid'");
$data['student'] = $student = fetchRecord($db,"{$dbg}.05_students","contact_id='$scid'");
$data['profile'] = $profile = fetchRecord($db,"{$dbo}.`00_profiles`","contact_id='$scid'");
$data['summary'] = $summary = fetchRecord($db,"{$dbg}.05_summaries","scid='$scid'");

if($has_axis){ 
	$data['tsum'] = $tsum = fetchRecord($db,"{$dbg}.03_tsummaries","scid='$scid'"); 

	$q=" SELECT t.*,t.total,cr.acid AS acid,l.name AS level,s.name AS section 		
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id = s.id  
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON cr.level_id = t.level_id
			WHERE c.id = '$scid'; ";	
	debug($q,'ProfilesCtrl:student');
	$sth = $db->querysoc($q);
	$data['tuition'] = $tuition = $sth->fetch();

	$q = "SELECT
			td.*,f.name AS fee,cr.acid AS acid
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t ON cr.level_id = t.level_id
			LEFT JOIN {$dbg}.03_tdetails AS td ON td.level_id = t.level_id
			LEFT JOIN {$dbo}.`03_feetypes` AS f ON td.feetype_id = f.id
		WHERE c.id = '$scid'; ";
	$sth = $db->querysoc($q);
	$data['tdetails'] = $tdetails = $sth->fetchAll();
	$data['numtdetails'] = count($tdetails);
	$acid = $tuition['acid'];
	if(!$tsum){$q .= " INSERT INTO {$dbg}.03_tsummaries (`scid`,`crid`) VALUES ('$scid','$crid'); ";$sync=($sync)?$sync.=",Tsum":"Tsum";}
			
			
} 	/* has_axis */
	

/* 2 */
$sync=false;
$q="";
$crid = $contact['crid'];
if(!$profile){$q .= " INSERT INTO {$dbo}.`00_profiles` (`contact_id`) VALUES ('$scid'); "; $sync=($sync)?$sync.=",Profile":"Profile";}
if(!$student){$q .= " INSERT INTO {$dbg}.05_students (`contact_id`) VALUES ('$scid'); ";$sync=($sync)?$sync.=",Student":"Student";}
if(!$summary){$q .= " INSERT INTO {$dbg}.05_summaries (`scid`,`crid`,`acid`) 
	VALUES ('$scid','$crid','acid'); ";$sync=($sync)?$sync.=",Summary":"Summary";}





$data['contacts'] = NULL;
$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`","id,name","id");
$data['religions'] = $this->model->fetchRows("{$dbo}.religions","id,name","name");
$data['nationalities'] = $this->model->fetchRows("{$dbo}.nationalities","id,name","name");
$data['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","id,name","level_id");

$vfile="expired/grades/profileStudent";

// $this->view->render($data,'profiles/studentProfiles');
$this->view->render($data,$vfile,$this->layout);

}	/* fxn */






public function reset(){
	if(isset($_SESSION['cirlist'])){ unset($_SESSION['cirlist']); }
	if(isset($_SESSION['cirlist_all'])){ unset($_SESSION['cirlist_all']); }
	flashRedirect('cir','CIR List reset.');	
}	/* fxn */



public function courses($params){
	$data['crid']=$crid=$params[0];
	$data['sy']=$sy=isset($params[1])?$params[1]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	// pr($dbg);
	$q="SELECT
			c.id AS crs,c.name AS course,c.label AS course_label,
			c.crstype_id,c.is_num,c.is_aggregate,c.crstype_id AS ctype_id,c.with_scores,
			ct.name AS ctype,
			t.name AS teacher
		FROM {$dbg}.05_courses AS c
		LEFT JOIN {$dbg}.05_classrooms AS cr ON c.crid=cr.id
		LEFT JOIN {$dbo}.`05_crstypes` AS ct ON c.crstype_id=ct.id
		LEFT JOIN {$dbo}.`00_contacts` AS t ON c.tcid=t.id
		WHERE c.crid='$crid';		
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	// pr($data['rows'][0]);exit;
	
	$vfile="xgrades/coursesXgrades";
	vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function averages($params){
	$data['crs']=$crs=$params[0];
	$data['sy']=$sy=isset($params[1])?$params[1]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[2])?$params[2]:$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$order=$_SESSION['settings']['classlist_order'];
	
	$q="SELECT c.crid,c.name AS course,c.label AS course_label,
			cq.is_finalized_q4,cq.is_finalized_q5,cq.is_finalized_q6,c.semester
		FROM {$dbg}.05_courses AS c
		LEFT JOIN {$dbg}.05_courses_quarters AS cq ON cq.course_id=c.id
		WHERE c.id='$crs' LIMIT 1;";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['crs_row']=$sth->fetch();
	
	
	$q="
		SELECT g.id,g.id AS gid,c.id AS scid,c.id AS contact_id,c.code AS student_code,c.name as student,c.is_male,g.* 
		FROM {$dbg}.`50_grades` AS `g` 
			INNER JOIN {$dbg}.`05_summaries` AS summ ON g.scid = summ.scid 
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id 
		WHERE g.course_id='$crs' AND summ.crid 	= '1'  ORDER BY  $order  LIMIT 100 ; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$vfile="xgrades/averagesXgrades";	
	vfile($vfile);
		
	$this->view->render($data,$vfile);
	
}	/* fxn */



}	/* CirController */
