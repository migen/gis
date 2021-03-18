<?php

Class ProfilesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']=$_SESSION['home'];
	$this->view->render($data,'profiles/scidProfile');

}	/* fxn */


public function custom($params=NULL){
$dbo=PDBO;
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
$crid=$contact['crid'];
if(!$profile){ $q1=" INSERT INTO {$dbo}.`00_profiles` (`contact_id`) VALUES ('$scid'); "; pr($q1); $q.=$q1; exit; $sync=($sync)?$sync.=",Profile":"Profile"; }
if(!$student){$q .= " INSERT INTO {$dbg}.05_students (`contact_id`) VALUES ('$scid'); ";$sync=($sync)?$sync.=",Student":"Student";}
if($contact['role_id']==RSTUD && !$summary){$q1="INSERT INTO {$dbg}.05_summaries (`scid`,`crid`,`acid`) 
	VALUES ('$scid','$crid','acid');"; $q.=$q1; pr($q1); $sync=($sync)?$sync.=",Summary":"Summary";}

if($sync){
	$this->model->db->query($q);
	$url = "profiles/student/$scid/$sy";
	echo "<h3><a href='".URL.$url."' >Refresh</a></h3>";
	exit;	
	// flashRedirect($url,$sync." synced.");
}	/* fxn */

/* 3 */
if(isset($_POST['submit'])){
	// pr($_POST); exit;
	$postcontact = $_POST['contact'];
	$poststudent = $_POST['student'];
	$postprofile = $_POST['profile'];
	$postcontact['name'] = $postprofile['last_name'].', '.$postprofile['first_name'];
	
	$this->model->db->update("{$dbo}.`00_contacts`",$postcontact,"id='$scid'");
	$this->model->db->update("{$dbo}.`00_profiles`",$postprofile,"contact_id='$scid'");
	$this->model->db->update("{$dbg}.05_students",$poststudent,"contact_id='$scid'");
	$url = "profiles/student/$scid/$sy";
	flashRedirect($url,"Profile updated.");	
	
}	/* fxn */

$data['contacts'] = NULL;
$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`","id,name","id");
$data['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","id,name","level_id");

$vfile='profiles/studentProfiles';vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */



/* affects 1) p.fname */
public function classroom($params = null){
$dbo=PDBO;
	$this->view->css=array('style_long.css');
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/profiling.php");
	$db=&$this->model->db;

	$data['crid'] = $crid = $params[0];			
	$data['sy'] = $sy = isset($params[1])? $params[1] : $_SESSION['sy'];
	$_SESSION['classroom']['crid']	= $crid;
	$with_chinese = $_SESSION['settings']['with_chinese'];
	$data['home'] = $home 	= $_SESSION['home'];
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;
	$db=&$this->model->db;
	
if(isset($_POST['save'])){
	$q="";$posts = $_POST['profiles'];	
	// pr($_POST);exit;
	foreach($posts AS $post){
		$fullname = addslashes($post['fullname']);	
		$code = preg_replace("([^A-Za-z0-9-/])", "", $post['code']);		
		$birthdate=$post['birthdate'];$mdpass=MD5($birthdate);
		$q.="UPDATE {$dbo}.`00_contacts` SET `name`='$fullname',`code` = '$code',`pass` = '$mdpass',
			`account` = '$code',`lrn`='".$post['lrn']."',`position`='".$post['position']."',`is_male`='".$post['is_male']."'			
			WHERE `id` = '".$post['cid']."' LIMIT 1; ";
		$q.="UPDATE {$dbo}.`00_profiles` SET `birthdate`='".$post['birthdate']."',`address`='".$post['address']."' 
			WHERE `contact_id` = '".$post['cid']."' LIMIT 1;";
	}
	// pr($q);exit;
	$db->query($q);
	$url="profiles/classroom/$crid/$sy";
	flashRedirect($url,'Updated.');
	exit;
}	/* post */
	
/* --------------------- process data ------------------------------------------ */

if($_SESSION['srid']==RTEAC && !in_array($crid,$_SESSION['teacher']['advisory_ids'])) { flashRedirect($home); }	

	$sort= (isset($_GET['sort']))? $_GET['sort'].',':NULL;
	$sort.="c.is_male DESC,c.name";	
	// $data['profiles'] 	= profilingByClassroom($db,$dbg,$sy,$crid,$sort);
	$data['profiles'] 	= profilingByClassroom($db,$dbg,$sy,$crid,$sort);
	$data['num_profiles'] = count($data['profiles']);
	$data['classroom'] 	= getClassroomDetails($db,$crid,$dbg);		
	$data['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");		
	// $data['cities'] 	= $this->model->fetchRows("".PDBO.".cities");			

	$sch=VCFOLDER;
	$one="classroomProfiles{$sch}";	
	$two="profiles/classroomProfiles";
	$vfile=cview($one,$two);
	vfile($vfile);
	$this->view->render($data,$vfile);		
	
}	/* fxn */



public function one($params=NULL){
$dbo=PDBO;
$data['scid']=$scid=isset($params[0])? $params[0]:false;
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbo}.`00_contacts`",$post,"id='$scid'");
	flashRedirect("profiles/one/$scid","Profile updated.");
}	/* post */

$data['row']=fetchRow($db,"{$dbo}.`00_contacts`","$scid");
$this->view->render($data,"profiles/oneProfiles");

}	/* fxn */


public function scid($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/profilesFxn.php");
	require_once(SITE."functions/dbtools.php");
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$db=&$this->baseModel->db;$dbo=PDBO;
	
	sessionizeColumnsOfDbtable($db,$dbo,"00_profiles","profiles",$except="'id','contact_id'");
	$data['cols']=$_SESSION['cols']['profiles'];
	$data['field_str']=$field_str=$_SESSION['cols']['profiles_field_str'];
	$data['count']=$_SESSION['cols']['profiles_count'];

	
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbo}.`00_profiles`",$post,"contact_id=$scid");
	flashRedirect("profiles/scid/$scid","Saved.");
	exit;
	
	
}	/* post */


if($scid){
	$q="SELECT $field_str FROM {$dbo}.`00_profiles` WHERE contact_id=$scid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
		
	
}	/* scid */


	/* classlists/classroomClasslists */
	// $vfile="profiles/scidProfile";vfile($vfile);
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$one="profiles/scidProfile_{$sch}";$two="profiles/scidProfile";
	$vfile=cview($one,$two,$sch);	
	if(isset($_GET['print'])){
		$sch=VCFOLDER;$one="profiles/scidProfilePrint_{$sch}";$two="profiles/scidProfilePrint";
		$vfile=cview($one,$two);vfile($vfile);
		
	}	/* print */
	$vfile=isset($_GET['custom'])? "profiles/scidProfileCustom":$vfile;vfile($vfile);
	
	
	$this->view->render($data,$vfile);
	
}	/* fxn */



public function student($params=NULL){
$dbo=PDBO;$db=&$this->baseModel->db;
$data['ucid']=$ucid=isset($params[0])? $params[0]:false;
	
sessionizeColumnsOfDbtable($db,$dbo,"00_contacts","contacts",$except="'null'");
sessionizeColumnsOfDbtable($db,$dbo,"00_profiles","profiles",$except="'null'");

$data['contacts_cols']=$_SESSION['cols']['contacts'];
$data['contacts_count']=$_SESSION['cols']['contacts_count'];
$data['profiles_cols']=$_SESSION['cols']['profiles'];
$data['profiles_count']=$_SESSION['cols']['profiles_count'];



$data['contact']=fetchRecord($db,"{$dbo}.`00_contacts`","id=$ucid");
$data['profile']=fetchRecord($db,"{$dbo}.`00_profiles`","contact_id=$ucid");

$data['text_array']=array('address','remarks');

/* vfile */
$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$one="profiles/studentProfile_{$sch}";$two="profiles/studentProfile_std";
$vfile=cview($one,$two,$sch);	
vfile($vfile);


$this->view->render($data,$vfile);

}	/* fxn */

	



}	/* ProfilesController */
