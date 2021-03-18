<?php

Class CertificatesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$data="Certificates";$this->view->render($data,'abc/defaultAbc');
	
}	/* fxn */

public function test(){


$data['sch']=$sch=VCFOLDER;
$vfile="customs/{$sch}/certificates/test";
// $this->view->render($data,$vfile);
$this->view->render($data,$vfile,'empty');
	
	
}



public function conductsByClassroom($params){
require_once(SITE.'functions/details.php');
require_once(SITE."functions/numberFxn.php");

$crid=isset($params[0])? $params[0]:12;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['date']=isset($_GET['date'])? $_GET['date']:$_SESSION['today'];

$data['cr']=getClassroomDetails($db,$crid);

$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];
$q="SELECT c.id,c.code,c.name AS student,summ.ave_q{$qtr} AS genave,
aw.is_conduct_awardee_q{$qtr} AS is_awardee 
FROM {$dbo}.`00_contacts` AS c
LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
LEFT JOIN {$dbg}.05_awardees AS aw ON c.id=aw.scid
WHERE summ.crid='$crid' AND aw.is_conduct_awardee_q{$qtr} > 0  
ORDER BY $order;";
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$no_rows="<h1 style='color:brown;font-size:2rem;'>No Conduct Awardees.</h1>";
$no_rows.="<br /><h2>You may <a href='".URL."conducts/process/".$crid."' >Process</a> again to be sure.</h2>";
if(empty($data['rows'])){ prx($no_rows); }


$sch=VCFOLDER;
$data['subdepartment_id']=$subdept_id=$data['cr']['subdepartment_id'];

$suffix='';
$subdept_id=isset($_GET['subdept_id'])? $_GET['subdept_id']:$subdept_id;
switch($subdept_id){
	case 1:
		$suffix='ps';break;
	case 3:
		$suffix='jhs';break;		
	case 4:
		$suffix='shs';break;
	default:
		$suffix='gs';break;
		
}

$num=$data['cr']['num'];
$num_suffix=($num>1)? "_N{$num}":NULL;

$qor=getOrdinalArray($qtr);
$data['qtr_num']=$qor['num'];
$data['qtr_word']=$qor['word'];

$vfile="customs/{$sch}/certificates/certificatesByClassroomConducts_{$suffix}{$num_suffix}";
debug($vfile);vfile($vfile);


$this->view->render($data,$vfile,'empty');

}	/* fxn */



public function studentHonors($params){
require_once(SITE.'functions/details.php');
require_once(SITE."functions/numberFxn.php");

$scid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['date']=isset($_GET['date'])? $_GET['date']:$_SESSION['today'];


$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];

$q="SELECT c.id,c.code,c.name AS student,summ.crid,
	summ.ave_q{$qtr} AS genave,sx.honor_q{$qtr} AS honor 
FROM {$dbo}.`00_contacts` AS c
LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
LEFT JOIN {$dbg}.05_summext AS sx ON c.id=sx.scid
WHERE summ.scid='$scid' AND sx.honor_q{$qtr} > 0 ;";

debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();

$empty=(empty($data['rows']))? true:false;

if($empty){ 
	prx("<h1>No honors.</h1>"); 
} else {
	$data['count']=1;
}

if($scid){
	$crid=$data['rows'][0]['crid'];
	$data['cr']=getClassroomDetails($db,$crid);	
}


$sch=VCFOLDER;
$data['subdepartment_id']=$subdept_id=$data['cr']['subdepartment_id'];

$suffix='';
$subdept_id=isset($_GET['subdept_id'])? $_GET['subdept_id']:$subdept_id;
switch($subdept_id){
	case 1:
		$suffix='ps';break;
	case 3:
		$suffix='jhs';break;		
	case 4:
		$suffix='shs';break;
	default:
		$suffix='gs';break;
		
}

$num=$data['cr']['num'];
$num_suffix=($num>1)? "_N{$num}":NULL;


$qor=getOrdinalArray($qtr);
$data['qtr_num']=$qor['num'];
$data['qtr_word']=$qor['word'];

$vfile="customs/{$sch}/honors/certificatesByClassroomHonors_{$suffix}{$num_suffix}";
debug($vfile);vfile($vfile);

$this->view->render($data,$vfile,'empty');

}	/* fxn */



public function studentConductee($params){
require_once(SITE.'functions/details.php');
require_once(SITE."functions/numberFxn.php");

$scid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['date']=isset($_GET['date'])? $_GET['date']:$_SESSION['today'];


$order=isset($_GET['order'])? $_GET['order']:$_SESSION['settings']['classlist_order'];


$q="SELECT c.id,c.code,c.name AS student,summ.crid,
	summ.ave_q{$qtr} AS genave,
	aw.is_conduct_awardee_q{$qtr} AS is_awardee
FROM {$dbo}.`00_contacts` AS c
LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
LEFT JOIN {$dbg}.05_awardees AS aw ON c.id=aw.scid
WHERE summ.scid='$scid' AND aw.is_conduct_awardee_q{$qtr} > 0 ;";

debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();

$empty=(empty($data['rows']))? true:false;

if($empty){ 
	prx("<h1>Not conduct awardee.</h1>"); 
} else {
	$data['count']=1;
}

if($scid){
	$crid=$data['rows'][0]['crid'];
	$data['cr']=getClassroomDetails($db,$crid);	
}


$sch=VCFOLDER;
$data['subdepartment_id']=$subdept_id=$data['cr']['subdepartment_id'];

$suffix='';
$subdept_id=isset($_GET['subdept_id'])? $_GET['subdept_id']:$subdept_id;
switch($subdept_id){
	case 1:
		$suffix='ps';break;
	case 3:
		$suffix='jhs';break;		
	case 4:
		$suffix='shs';break;
	default:
		$suffix='gs';break;
		
}

$num=$data['cr']['num'];
$num_suffix=($num>1)? "_N{$num}":NULL;

$qor=getOrdinalArray($qtr);
$data['qtr_num']=$qor['num'];
$data['qtr_word']=$qor['word'];

$vfile="customs/{$sch}/certificates/certificatesByClassroomConducts_{$suffix}{$num_suffix}";
debug($vfile);vfile($vfile);

$this->view->render($data,$vfile,'empty');

}	/* fxn */




}	/* BlankController */
