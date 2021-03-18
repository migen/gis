<?php

Class SrcardsController extends Controller{	

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



public function crid($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/frcards.php");
	$db =& $this->baseModel->db;

	$data['home'] = $home = $_SESSION['home'];
	if(is_null($params)) redirect($home);
	$data['ssy']	= $ssy	= $_SESSION['sy']; 
	$data['crid']	= $crid = $params[0];
	$data['sy']		= $sy	= isset($params[1])? $params[1]:$ssy; 
	$data['qtr']	= $qtr	= isset($params[2])? $params[2]:$_SESSION['qtr']; 
	$data['sem']	= $sem	= isset($params[3])? $params[3]:0; 
	$data['half'] 	= ($qtr<3)? 1:2;	
	$data['both']	= $both	= isset($_GET['both'])? $_GET['both']:false; 
	$data['qodd'] = $qodd = ($qtr%2);
	$data['fqtr']= $fqtr = ($sem==1)? 'q5':'q6'; 
	
	$current = ($sy==$ssy)? true:false; 	
	$data['dbg'] = $dbg	= VCPREFIX.$sy.US.DBG;
	
	$data['user'] = $user = $_SESSION['user'];
	$title_id 	= $user['title_id'];	
	$role_id 	= $user['role_id'];	

	
	$allowed = array(RMIS,RREG,RACAD);
	$data['srid'] = $srid = $_SESSION['srid'];
	if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
	
	
/* ----------------- process --------------------------------------------------------------------------- */		

$fields = ($_SESSION['settings']['with_chinese']==1)? 'c.chinese_name,':NULL;
$fields.="p.birthdate,sum.ave_q5,sum.ave_q6,p.address,cr.name AS classroom,l.name AS level,s.name AS section,cr.strand,";
$order=$_SESSION['settings']['classlist_order'];
$filter=null;$active=false;
$limits=isset($_GET['limit'])? $_GET['limit']:NULL;
$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields,$filter,$limits,$active);	

$data['num_students']	= $num_students = count($students);
$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);
$data['traits']			= $traits 		= ($classroom['conduct_ctype_id']==2)? 1:0;
	
/* 1) grades,2) attendance,3) conducts */

if(!$both){
	$data['grsem'] = $grsem=($sem==2)? 'twos':'ones';
}	/* not both */
	
for($i=0;$i<$num_students;$i++){		
	$students[$i]['summary'] = summary($db,$dbg,$sy,$crid,$students[$i]['scid']); 		

	if($both){
		$students[$i]['ones'] = grades($db,$dbg,$sy,$crid,$students[$i]['scid'],1); 		
		$students[$i]['twos'] = grades($db,$dbg,$sy,$crid,$students[$i]['scid'],2); 		
	} else {
		$students[$i][$grsem] = grades($db,$dbg,$sy,$crid,$students[$i]['scid'],$sem); 		
		$students[$i]['grades']=$students[$i][$grsem];
	}
	$students[$i]['attendance'] = attendance($db,$dbg,$sy,$students[$i]['scid']); 		
}	/* for */ 

	
if($_SESSION['settings']['with_chinese']==1){
	for($i=0;$i<$num_students;$i++){		
		$students[$i]['sumo']=sumo($db,$dbg,$sy,$crid,$students[$i]['scid']); 		
	}	/* for */ 	
}

$semvar = ($sem==2)? 2:0;	
$o12 = ($sem==2)? 2:1;	

if($classroom['conduct_ctype_id']==CTYPETRAIT){	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = traitsSem($db,$dbg,$sy,$students[$i]['scid'],$o12); } 
} else {	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = conducts($db,$dbg,$sy,$students[$i]['scid']); } 
}
	
	$data['students'] = $students;
	
/* ----------------- process --------------------------------------------------------------------------- */		
				
	$data['months'] = AttendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] = $this->baseModel->fetchRows("{$dbo}.`05_months_quarters`",'*','`index`',' WHERE quarter <> 0');	
	$data['num_months'] = count($data['month_names']);

	$data['classrooms'] 	= $this->baseModel->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	/* error proofing for printing report cards */
	$data['printable'] 		= true;	
	$data['is_finalized']=$is_finalized=$classroom['is_finalized_q'.$qtr];
	$data['is_locked'] 		= $is_locked = $classroom['is_finalized_q'.$qtr];

	$courses_locked = coursesLocked($db,$crid,$qtr,$dbg);	
	$data['courses_locked'] = $courses_locked;
	// pr("crs-locked: ".$courses_locked);


// pr($courses_locked);
	$data['printable']	= true;
	if(DBYR == $sy){ if(!$courses_locked){ $data['printable'] = false; } }
	$data['is_locked'] = $courses_locked;

	$conduct_ctype = $classroom['conduct_ctype_id'];
	$data['legendcrs'] 	= legends($db,$dbg,$ctype=1,$classroom['department_id']);
	$data['legendctr'] 	= legends($db,$dbg,$ctype=$conduct_ctype,$classroom['department_id']);
	$data['legendetc'] 	= legends($db,$dbg,$ctype=CTYPEELECTIVE,$classroom['department_id']);
	$data['num_legendetc'] = count($data['legendetc']);
	$data['num_legendctr'] = count($data['legendctr']);	

	$data['numacad'] = countCridCourses($db,$crid,$dbg,$sem);	
	$data['hidegenave'] = (isset($_GET['hidegenave']))? true:false;	
	$data['sch'] = $sch = isset($_GET['sch'])? $_GET['sch']:VCFOLDER;		
	$vfile = "customs/{$sch}/srcard";	

	$data['levelnow'] = $classroom['level'];
	$lvlidnxt = ($classroom['level_id']+1);
	// $row = $this->baseModel->fetchRow("{$dbo}.`05_levels`",$lvlidnxt);
	$row = fetchRow($db,"{$dbo}.`05_levels`",$lvlidnxt);
	$data['levelnxt'] = $row['name'];
		
	$data['numtraits'] = $numtraits=($classroom['conduct_ctype_id']==2)? numtraits($db,$classroom['crid']):1;	
	$data['rcpage']=4;	/* 1-sircard, 2-rcard 3-sirscard 4-srcard */		
	$data['tplval']=4;
	
	if($sem>0){
		$data['sq1'] = ($sem==1)? 'q1':'q3';
		$data['sq2'] = ($sem==1)? 'q2':'q4';
		$data['dsq1'] = ($sem==1)? '1':'3';
		$data['dsq2'] = ($sem==1)? '2':'4';		
	}
	
	vfile($vfile);	
if($classroom['level_id']>13){ $data['is_locked']=$classroom['is_finalized_q'.$qtr]; }	
	
	$this->view->render($data,$vfile);
	
}	/* fxn */



public function scid($params=NULL){
	$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');
	require_once(SITE."functions/frcards.php");
	$db =& $this->baseModel->db;

	$data['home'] = $home = $_SESSION['home'];
	$data['ssy']	= $ssy	= $_SESSION['sy']; 
	$data['sqtr']	= $sqtr	= $_SESSION['qtr']; 
	

	$data['scid'] 	= $scid = ($_SESSION['srid']==RSTUD)? $_SESSION['ucid']:$params[0];	
	$data['sy']		= $sy	= isset($params[1])? $params[1]:$ssy; 
	$data['qtr']	= $qtr	= isset($params[2])? $params[2]:$sqtr; 
	$data['sem']	= $sem	= isset($params[3])? $params[3]:1; 
	$data['half'] 	= ($qtr<3)? 1:2;
	$data['both']	= $both	= isset($_GET['both'])? $_GET['both']:false; 
	$data['qodd'] = $qodd = ($qtr%2);
	$data['fqtr']= $fqtr = ($sem==1)? 'q5':'q6'; 
	
	$current		= ($sy==$ssy)? true:false; 	
	$data['dbg']	= $dbg	= VCPREFIX.$sy.US.DBG;
	$data['dbm']	= $dbg	= VCPREFIX.$sy.US.DBG;
	
	$data['srid']	= $srid	= $_SESSION['srid'];
	
	$data['user']	= $user		= $_SESSION['user'];
	$title_id 	= $user['title_id'];	
	$role_id 	= $user['role_id'];	

	if($srid==RSTUD){
		$allowed = checkRcardSchedule($db,$scid);
		if(!$allowed){ flashRedirect('/','Schedule Closed.'); }		
	}


$fields = ($_SESSION['settings']['with_chinese']==1)? 'c.chinese_name,':NULL;
$students[] = student($db,$dbg,$sy,$scid,$fields=NULL);

if($_SESSION['settings']['has_axis']==1){
	if(!isset($_SESSION['student']['balance'])){
		require_once(SITE.'functions/sessionize_student.php');
		getTotalPreviousBalance($db,$scid);	
	}	/* balance */
	$balance=$_SESSION['student']['balance'];
	$balance_cutoff=isset($_SESSION['settings']['balance_cutoff'])? $_SESSION['settings']['balance_cutoff']:100;
	$has_balance=($balance>$balance_cutoff)? true:false;
	if($srid==RSTUD && $has_balance){ pr("<h1 class='brown'>Has balance of P".number_format($balance,2).". Please contact the accounting office.</h1>");exit; }
}


$data['crid']			= $crid	= $students[0]['crid'];	
if($_SESSION['srid']==RTEAC){ if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){  $this->flashRedirect('teachers'); } }
	
	$data['num_students']	= $num_students = '1';
	$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);
	$data['traits']			= $traits 		= ($classroom['conduct_ctype_id']==CTYPETRAIT)? 1:0;
	
	/* 1) grades,2) attendance,3) conducts,4) if applicable-psmapehs */
	
if(!$both){
	$data['grsem'] = $grsem=($sem==2)? 'twos':'ones';
}	/* not both */

	
for($i=0;$i<$num_students;$i++){		
	$students[$i]['summary'] 		= summary($db,$dbg,$sy,$crid,$students[$i]['scid']); 		
	$students[$i]['attendance'] 	= attendance($db,$dbg,$sy,$students[$i]['scid']); 		
	if($both){
		$students[$i]['ones'] = grades($db,$dbg,$sy,$crid,$students[$i]['scid'],1); 		
		$students[$i]['twos'] = grades($db,$dbg,$sy,$crid,$students[$i]['scid'],2); 		
	} else {
		$students[$i][$grsem] = grades($db,$dbg,$sy,$crid,$students[$i]['scid'],$sem); 	
		$students[$i]['grades']=$students[$i][$grsem];
	}
		
}	/* for */ 


	if($_SESSION['settings']['with_chinese']==1){
		for($i=0;$i<$num_students;$i++){		
			$students[$i]['sumo'] = sumo($db,$dbg,$sy,$crid,$students[$i]['scid']); 		
		}	/* for */ 	
	}
	
	$is_sem = $classroom['is_sem'];	
	$semvar = ($sem==2)? 2:0;	
	
	$o12 = 0;
	if($is_sem && $sem==2){
		$o12 = 2;
	} elseif($is_sem && $sem==1){
		$o12 = 1;
	} else {
		$o12 = 0;
	}
	
/* pr($classroom); */
if($classroom['conduct_ctype_id']==CTYPETRAIT){	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts']=traitsSem($db,$dbg,$sy,$students[$i]['scid'],$o12); } 	
} else {	
	for($i=0;$i<$num_students;$i++){ $students[$i]['conducts']=conducts($db,$dbg,$sy,$students[$i]['scid']);}				
}
	
$data['students'] = $students;
	
	
/* ----------------- process --------------------------------------------------------------------------- */			
			
	$data['months'] 	 	= attendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] 	= $this->baseModel->fetchRows("{$dbo}.`05_months_quarters`",'*','`index`',' WHERE quarter <> 0');		
	$data['num_months']		= count($data['month_names']);

	/* error proofing for printing report cards */
	$data['printable'] 		= true;	
	$data['is_finalized']=$is_finalized=$classroom['is_finalized_q'.$qtr];
	$data['is_locked'] 		= $is_locked = $classroom['is_finalized_q'.$qtr];


	$courses_locked = coursesLocked($db,$crid,$qtr,$dbg);	/* arm-Model */
	$data['courses_locked'] = $courses_locked;

	$data['printable']	= true;
	if($ssy == $sy){ if(!$courses_locked){ $data['printable'] = false; } }
	$data['is_locked'] = $courses_locked;
	$data['is_locked'] 		= $is_locked = $classroom['is_finalized_q'.$qtr];

	$conduct_ctype = $classroom['conduct_ctype_id'];
	
	$data['legendcrs'] 	= legends($db,$dbg,$ctype=CTYPEACAD,$classroom['department_id']);
	$data['legendctr'] 	= legends($db,$dbg,$ctype=$conduct_ctype,$classroom['department_id']);
	$data['legendetc'] 	= legends($db,$dbg,$ctype=CTYPEELECTIVE,$classroom['department_id']);
	$data['num_legendetc'] = count($data['legendetc']);
	$data['num_legendctr'] = count($data['legendctr']);

	$data['numacad1'] = ($sem<2)? count($students[0]['ones']):count($students[0]['twos']);
	if($both){ 
		$data['numacad2'] = count($students[0]['twos']); 
	} else {
		if($sem>1){ $data['numacad1'] = count($students[0]['twos']); }
	}
	$data['numacad'] = $data['numacad1'];

	if($sem>0){
		$data['sq1'] = ($sem==1)? 'q1':'q3';
		$data['sq2'] = ($sem==1)? 'q2':'q4';
		$data['dsq1'] = ($sem==1)? '1':'3';
		$data['dsq2'] = ($sem==1)? '2':'4';		
	}
	
	$data['hidegenave'] = (isset($_GET['hidegenave']))? true:false;
	$data['sch'] = $sch = isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$vfile = "customs/{$sch}/srcard";
		
		
	$data['levelnow'] = $classroom['level'];
	$lvlidnxt = ($classroom['level_id']+1);
	$row = $this->baseModel->fetchRow("{$dbo}.`05_levels`",$lvlidnxt);
	$data['levelnxt'] = $row['name'];

	
	$data['rcpage']=1;	/* 1-sircard, 2-rcard 3-shs */	
	$data['numtraits'] = $numtraits=($classroom['conduct_ctype_id']==2)? numtraits($db,$classroom['crid'],$dbg):1;
	$data['numlg'] = $numlg = numlg($db,$crid,$dbg);	/* num letter grades */		
	$data['tplval']=3;


	if(!isset($_SESSION['rcard_layout'])){ $custfile = SITE."views/customs/".VCFOLDER."/customs.php"; 
		if(is_readable($custfile)){ require_once($custfile); } }
	$layout=isset($_SESSION['rcard_layout'])? $_SESSION['rcard_layout']:'full';	
	if(isset($_GET['vfile'])){ pr($vfile); echo "Layout: $layout <br />"; }	
	
	$this->view->render($data,$vfile,$layout);
	

}	/* fxn */


public function fpage($params){	/* front page fprcard */
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






}	/* RcardsController */
