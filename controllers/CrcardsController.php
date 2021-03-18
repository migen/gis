<?php

Class CrcardsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	pr("CR Cards");
	// $data['home']	= $_SESSION['home'];
	// $this->view->render($data,'tests/index');

}	/* fxn */


public function view1($params=NULL){
	require_once(SITE."functions/frcards.php");

	$data['home'] = $home = $_SESSION['home'];
	if(is_null($params)) redirect($home);
	$data['ssy']	= $ssy	= $_SESSION['sy']; 
	$data['crid']	= $crid   	= $params[0];
	$data['sy']		= $sy	= isset($params[1])? $params[1]:$ssy; 
	$data['qtr']	= $qtr	= isset($params[2])? $params[2]:$_SESSION['qtr']; 
	$data['sem']	= $sem	= isset($params[3])? $params[3]:'0'; 
	$data['half'] 	= ($qtr<3)? 1:2;
		
	$current=($sy==DBYR)? true:false; 	
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['db']=&$db;$data['dbo']=&$dbo;$data['dbg']=&$dbg;	

	$data['user']	= $user		= $_SESSION['user'];
	$title_id 	= $user['title_id'];	
	$role_id 	= $user['role_id'];	
	
	$allowed = array(RMIS,RREG,RACAD,RADMIN);
	$data['srid'] = $srid = $_SESSION['srid'];
	if(!in_array($srid,$allowed)){ $this->flashRedirect($home); }
	
		
	/* controller - teachers or else */
	$data['home'] =	$home = $_SESSION['home']; 			

/* -------------------------------------------------------------------------------------------- */		

	$_SESSION['gradebook']['crid'] 		= $crid; 			
	if(isset($_POST['filter'])){
		/* $sy		= isset($_POST['cf']['sy'])? $_POST['sy'] : $sy; */
		$crid  		= $_POST['cf']['crid'];
		$sy			= $_POST['cf']['sy'];
		$_SESSION['gradebook']['crid'] 	= $crid; 
		$_SESSION['gradebook']['sy']  	= $sy;
		$url = $home.'/gradebook/'.$crid.DS.$sy.DS.$qtr;		
		
		redirect($url);
	}	/* post-submit */
	
	
/* ----------------- process --------------------------------------------------------------------------- */		

	$fields = ($_SESSION['settings']['with_chinese']==1)? 'c.chinese_name,':NULL;
	$fields.="p.birthdate,sum.ave_q5,sum.ave_q6,p.address,cr.name AS classroom,l.name AS level,s.name AS section,";
	$order=$_SESSION['settings']['classlist_order'];
	$filter=null;$active=false;
	$limits=isset($_GET['limit'])? $_GET['limit']:NULL;
	$data['students'] = $students = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields,$filter,$limits,$active);	

	$data['num_students']	= $num_students = count($students);
	$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);
	$data['traits']			= $traits 		= ($classroom['conduct_ctype_id']==2)? 1:0;
	
	/* 1) grades,2) attendance,3) conducts,4) if applicable-psmapehs */
	
	// pr($students); exit;
	
	for($i=0;$i<$num_students;$i++){		
		$students[$i]['info'] = $students[$i];	
		$students[$i]['summary'] = summary($db,$dbg,$sy,$crid,$students[$i]['scid']); 		/* @ library-GSModel */
		$students[$i]['grades'] = grades($db,$dbg,$sy,$crid,$students[$i]['scid'],$sem); 	/* @ library-GSModel */
		$students[$i]['attendance'] = attendance($db,$dbg,$sy,$students[$i]['scid']); 		
	}	/* for */ 
	
	if($_SESSION['settings']['with_chinese']==1){
		for($i=0;$i<$num_students;$i++){		
			$students[$i]['sumo']=sumo($db,$dbg,$sy,$crid,$students[$i]['scid']); 		
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
	if($classroom['conduct_ctype_id']==CTYPETRAIT){	
		for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = traitsSem($db,$dbg,$sy,$students[$i]['scid'],$o12); } 
	} else {	
		for($i=0;$i<$num_students;$i++){ $students[$i]['conducts'] = conducts($db,$dbg,$sy,$students[$i]['scid']); } 
	}

	
	$data['students'] = $students;
	
/* ----------------- process --------------------------------------------------------------------------- */		
	
			
	$data['months'] 	 	= AttendanceMonths($db,$data['classroom']['level_id'],$sy,$dbg); 	/* 1 row jun to may days_total  */
	$data['month_names'] 	= $this->model->fetchRows("{$dbo}.`05_months_quarters`",'*','`index`',' WHERE quarter <> 0');	
	$data['num_months']		= count($data['month_names']);

	$data['classrooms'] 	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");	
	/* error proofing for printing report cards */
	$data['printable'] 		= true;	
	$data['is_locked'] 		= $is_locked = $classroom['is_finalized_q'.$qtr];

	$courses_locked = coursesLocked($db,$crid,$qtr,$dbg);	/* arm-Model */
	$data['courses_locked'] = $courses_locked;

	$data['printable']	= true;
	if($ssy == $sy){ if(!$courses_locked){ $data['printable'] = false; } }
	$data['is_locked'] = $courses_locked;

	$conduct_ctype = $classroom['conduct_ctype_id'];
	$data['legendcrs'] 	= legends($db,$dbg,$ctype=1,$classroom['department_id']);
	$data['legendctr'] 	= legends($db,$dbg,$ctype=$conduct_ctype,$classroom['department_id']);
	$data['legendetc'] 	= legends($db,$dbg,$ctype=CTYPEELECTIVE,$classroom['department_id']);
	$data['num_legendetc'] = count($data['legendetc']);
	$data['num_legendctr'] = count($data['legendctr']);

	$data['numacad'] = countCridCourses($db,$crid,$dbg,$sem);
	$coll = ($sem!=0)? '_sem':'';

	if($sem>0){
		$data['sq1'] = ($sem==1)? 'q1':'q3';
		$data['sq2'] = ($sem==1)? 'q2':'q4';
		$data['dsq1'] = ($sem==1)? '1':'3';
		$data['dsq2'] = ($sem==1)? '2':'4';		
	}
	
	$data['hidegenave'] = (isset($_GET['hidegenave']))? true:false;
	
	$data['sch'] = $sch = isset($_GET['sch'])? $_GET['sch']:VCFOLDER;	
	
	$vfile = "customs/{$sch}/";
if(isset($_GET['tpl'])){
	switch($_GET['tpl']){		
		case 1: $vfile .= "rcard_ps"; break;
		case 3: $vfile .= "rcard_hs"; break;
		case 5: $vfile .= "rcard_p1"; break;		
		default: $vfile .= "rcard{$coll}"; break;				
	}
} else {
	$vfile .= "rcard".$coll;			
}	
	
	$data['levelnow'] = $classroom['level'];
	$lvlidnxt = ($classroom['level_id']+1);
	$row = $this->model->fetchRow("{$dbo}.`05_levels`",$lvlidnxt);
	$data['levelnxt'] = $row['name'];

	$data['rcpage']=2;	/* 1-sircard, 2-rcard 3-shs */		
	$data['numtraits'] = $numtraits=($classroom['conduct_ctype_id']==2)? numtraits($db,$classroom['crid']):1;
	$data['numlg'] = $numlg = numlg($db,$crid);	/* num letter grades */	
	$data['tplval']=isset($_GET['tpl'])? $_GET['tpl']:2;
	
	if(!isset($_SESSION['rcard_layout'])){ $custfile = SITE."views/customs/".VCFOLDER."/customs.php"; 
		if(is_readable($custfile)){ require_once($custfile); } 
		$_SESSION['rcard_layout']=isset($_SESSION['rcard_layout'])? $_SESSION['rcard_layout']:'full';  
	}		
	$layout=$_SESSION['rcard_layout'];
	if(isset($_GET['vfile'])){ pr($vfile); echo "Layout: $layout <br />"; }		
	$this->view->render($data,$vfile,$layout);

}	/* fxn */



public function view($params=NULL){
	require_once(SITE.'functions/crcardsFxn.php');
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	
	$limit=isset($_GET['limit'])? $_GET['limit']:NULL;
	$d=getClasslistCrcards($db,$dbg,$crid);
	$data['students']=$d['rows'];
	$data['num_students']=$d['count'];
	
	// pr($data);

	$vfile='customs/'.VCFOLDER.'/rcards_coll';
	
	$this->view->render($data,$vfile);
	
}	/* fxn */




}	/* RcardsController */
