<?php

Class FrontcardsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_orig.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */




public function crid($params){	/* front page fprcard */
$dbo=PDBO;
require_once(SITE."functions/frcards.php");
$db=&$this->baseModel->db;
$data['crid'] = $crid = $params[0];

$ssy=$_SESSION['sy'];
$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$sqtr;

	$current=($sy==DBYR)? true:false; 	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['db']=&$db;$data['dbo']=&$dbo;$data['dbg']=&$dbg;	


$data['sch'] = $sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$data['tpl'] = $tpl=isset($_GET['tpl'])? $_GET['tpl']:1;

$data['classroom'] = getClassroomDetails($db,$crid);
$order=$_SESSION['settings']['classlist_order'];

$fields="p.birthdate,summ.ave_q5,summ.ave_q6,p.address";
$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;

$q="SELECT c.is_male,c.code AS studcode,c.name AS student,r.*,$fields,c.id AS scid
	FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON summ.scid = p.contact_id
		LEFT JOIN {$dbg}.50_remarks AS r ON summ.scid = r.scid
	WHERE summ.crid='$crid' ORDER BY $order $limitcond;";
$sth=$db->querysoc($q);
$students = $sth->fetchAll();
$data['num_students'] = $num_students = count($students);
$data['count']=$num_students;


for($i=0;$i<$num_students;$i++){		
	$scid=$students[$i]['scid'];
	$students[$i]['attendance'] = attendance($db,$dbg,$sy,$scid); 		
}	/* for */ 


$data['students']=$students;
$data['months']=AttendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
$data['month_names']=$this->baseModel->fetchRows("{$dbo}.`05_months_quarters`",'*','`index`',' WHERE quarter <> 0');	
$data['num_months']=count($data['month_names']);
$data['classroom']=$classroom=getClassroomDetails($db,$crid,$dbg);

$data['classrooms']=$this->baseModel->fetchRows("{$dbg}.05_classrooms","*","level_id");	
/* error proofing for printing report cards */
$data['printable']=true;	
$data['is_locked']=$is_locked = $classroom['is_finalized_q'.$qtr];


switch($tpl){
	case 1: $ds = '_ps'; break;
	default: $ds = '_ps'; break;
}
	
$vfile = "customs/{$sch}/fprcard{$ds}";			

if(!isset($_SESSION['rcard_layout'])){ $custfile = SITE."views/customs/".VCFOLDER."/customs.php"; 
	if(is_readable($custfile)){ require_once($custfile); } }		
$layout=isset($_SESSION['rcard_layout'])? $_SESSION['rcard_layout']:'full';
if(isset($_GET['vfile'])){ pr($vfile); echo "Layout: $layout <br />"; }		


$this->view->render($data,$vfile,$layout);

}	/* fxn */




public function scid($params){	/* front page fprcard */
$dbo=PDBO;$sch=VCFOLDER;
require_once(SITE."functions/frcards.php");
$db=&$this->baseModel->db;
$data['scid'] = $scid = $params[0];

$ssy=$_SESSION['sy'];
$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$sqtr;

	$current=($sy==DBYR)? true:false; 	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['db']=&$db;$data['dbo']=&$dbo;$data['dbg']=&$dbg;	


$data['sch'] = $sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$data['tpl'] = $tpl=isset($_GET['tpl'])? $_GET['tpl']:1;


$fields="p.birthdate,summ.ave_q5,summ.ave_q6,p.address";

$q="SELECT c.is_male,c.code AS studcode,c.name AS student,r.*,$fields,c.id AS scid,summ.crid
	FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
		LEFT JOIN {$dbo}.`00_profiles` AS p ON summ.scid = p.contact_id
		LEFT JOIN {$dbg}.50_remarks AS r ON summ.scid = r.scid
	WHERE summ.scid='$scid' LIMIT 1;";
$sth=$db->querysoc($q);
$students = $sth->fetchAll();
$data['num_students'] = $num_students = 1;
$data['count']=1;


$crid=$students[0]['crid'];
$data['classroom']=$classroom=getClassroomDetails($db,$crid);

for($i=0;$i<$num_students;$i++){		
	$scid=$students[$i]['scid'];
	$students[$i]['attendance'] = attendance($db,$dbg,$sy,$scid); 		
}	/* for */ 



$data['students']=$students;
$data['months']=AttendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
$data['month_names']=$this->baseModel->fetchRows("{$dbo}.`05_months_quarters`",'*','`index`',' WHERE quarter <> 0');	
$data['num_months']=count($data['month_names']);


// $data['classrooms']=$this->baseModel->fetchRows("{$dbg}.05_classrooms","*","level_id");	
/* error proofing for printing report cards */
$data['printable']=true;	
$data['is_locked']=$is_locked = $classroom['is_finalized_q'.$qtr];


switch($tpl){
	case 1: $ds = '_ps'; break;
	default: $ds = '_ps'; break;
}
	
$vfile = "customs/{$sch}/fprcard{$ds}";			

// if(!isset($_SESSION['rcard_layout'])){ $custfile = SITE."views/customs/".VCFOLDER."/customs.php"; 
if(!isset($_SESSION['rcard_layout'])){ $custfile = SITE."views/customs/{$sch}/customs.php"; 
	if(is_readable($custfile)){ require_once($custfile); } }		
$layout=isset($_SESSION['rcard_layout'])? $_SESSION['rcard_layout']:'full';
if(isset($_GET['vfile'])){ pr($vfile); echo "Layout: $layout <br />"; }		


$this->view->render($data,$vfile,$layout);

}	/* fxn */






}	/* RcardsController */
