<?php

Class SummarizersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');	
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */




public function genave($params){	/* crid */
$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js','js/vegas_tables.js');
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/logs.php");
	
	$_SESSION['q']="";
	$data['crid']=$crid=$params[0];
	$data['ssy']=$ssy=$_SESSION['sy'];
	$data['sy']=$sy=isset($params[1])? $params[1] : $ssy;	
	$data['sqtr']=$sqtr=$_SESSION['qtr'];
	$data['qtr']=$qtr=isset($params[2])? $params[2] : $sqtr;	
	$data['iqtr']=$iqtr=($qtr>4)? 4:$qtr;
	$data['srid']=$srid=$_SESSION['srid']; 		
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	/* controller - teachers or else */
	$data['home']=$home=$_SESSION['home'];
	$data['classroom']=$classroom=getClassroomDetails($db,$crid,$dbg);			
	$data['cr']=$classroom;
	$data['is_k12']=$is_k12=$classroom['is_k12'];
	
	if(!isset($_GET['sem'])){ $sem=0;
	} else { $sem=$_GET['sem']; }
	
	$data['sem']=$sem;
	$data['intfqtr']=$intfqtr=($sem==2)? 6:5;
	$data['fqtr']=$fqtr='q'.$intfqtr;
	$data['qodd']=$qodd=($qtr%2)? true:false;				
	
	if($sem){ $data['idiv']=($qodd)? 1:2;
	} else { $data['idiv']=$iqtr; }
			
	$_SESSION['summarizer']="summarizers/genave/$crid/$sy/$qtr";
	$data['user']=$_SESSION['user'];
	
	$allowed = array(RMIS,RREG,RACAD);
	$data['srid'] = $srid = $_SESSION['srid'];
	$home = $_SESSION['home'];
	$data['admin'] = $admin	= true;
	
	
/* -------------------------- */	
/* dont move this */
$order = $_SESSION['settings']['classlist_order'];
if(isset($_GET['alpha'])){ $order="c.name"; }
$data['students'] 	= $students = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields=null); 

$q=$_SESSION['q'];

/* -------------------------- */	
		
	if($srid==RTEAC){ 
		if(!in_array($crid,$_SESSION['teacher']['advisory_ids'])){ $this->flashRedirect('teachers'); } 			
		if($sy!=$_SESSION['sy']){ $this->flashRedirect($home,'Not Current SY!'); }
	} 
		
	$allowed = array(RMIS,RTEAC,RREG,RACAD,RADMIN); 
	if(!in_array($srid,$allowed)){ $this->flashRedirect($home); } else {	
		/* post */
		if(isset($_POST['summarize'])){
			$rows  = $_POST['sum'];
			// pr($rows);exit;
						
			/* 1 - update summaries */			
			$q = "";
			foreach($rows AS $row){
				$expr = " `ave_q$intfqtr` = '".$row['ave']."' ";
				if($is_k12){ $expr .= " ,`ave_dg$intfqtr` = '".$row['ave_dg']."' "; }				
				if($sem==1){
					$expr .= " ,`ave_q1` = '".$row['ave_q1']."' ";		
					if($is_k12) { $expr .= " ,`ave_dg1` = '".$row['ave_dg1']."' "; }
					if(!$qodd){
						$expr .= " ,`ave_q2` = '".$row['ave_q2']."' ";		
						if($is_k12) { $expr .= " ,`ave_dg2` = '".$row['ave_dg2']."' "; }															
					} 					
				} elseif($sem==2){
					$expr .= " ,`ave_q3` = '".$row['ave_q3']."' ";		
					if($is_k12) { $expr .= " ,`ave_dg3` = '".$row['ave_dg3']."' "; }										
					if(!$qodd){
						$expr .= " ,`ave_q4` = '".$row['ave_q4']."' ";		
						if($is_k12) { $expr .= " ,`ave_dg4` = '".$row['ave_dg4']."' "; }															
					} 										
				} else {
					for($i=1;$i<=$iqtr;$i++){				
						$expr .= " ,`ave_q$i` = '".$row['ave_q'.$i]."' ";		
						if($is_k12) { $expr .= " ,`ave_dg$i` = '".$row['ave_dg'.$i]."' ";	}				
					} 				
				}				
				$q .= " UPDATE {$dbg}.05_summaries SET ";
				$q .= $expr;	
				$q .= " WHERE  `scid` = '".$row['scid']."' LIMIT 1; ";
			}	/* endforeach */		
			
			// pr($q); exit;
			$this->model->db->query($q);
			
		/* 1.5 finalized */
		$today=$_SESSION['today'];
		$q="UPDATE {$dbg}.05_advisers_quarters SET `is_finalized_q{$qtr}`=1,`finalized_date_q{$qtr}`='$today' WHERE `crid`='$crid' LIMIT 1;  ";
		$db->query($q);			
					
		/* 2 log */
		$q = "SELECT cr.acid,cr.name AS classroom,c.name AS adviser 
				FROM {$dbg}.05_classrooms AS cr
				LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id			
			WHERE cr.id = '$crid' LIMIT 1; ";
		$sth = $db->querysoc($q);
		$classroom = $sth->fetch();		
		
		/* 3 */
		$axn = $_SESSION['axn']['summarize_classroom'];
		$details = "Q{$qtr} - ".$classroom['classroom']." - ".$classroom['adviser'];
		$ucid = $_SESSION['user']['ucid'];
		$more['qtr'] = $qtr;
		$more['crid'] = $crid;
		$more['ecid'] = $classroom['acid'];			
		logThis($db,$ucid,$axn,$details,$more);		
				
			/* 3 - redirect to mcr */
			$url = "qcr/qcr/$crid/$sy/$qtr";
			redirect($url);	
		}	/* post-submit post-summarize */
	
	} 
				
	$data['num_students'] 	= count($data['students']);		
	$cfilter = " AND (crs.in_genave = '1') "; 
	$cfilter .= " AND (crs.semester = 0 ";
	if($sem){
		$cfilter .=" || crs.semester = $sem ";
	}	
	$cfilter .= ") ";	
	$data['subjects'] 		= cridCourses($db,$dbg,$crid,$acad=1,$agg=2,$cfilter);	
	$q.=$_SESSION['q'];
	
	$data['num_subjects'] 	= count($data['subjects']);
	
	$units_array			= buildArray($data['subjects'],'units');
	$data['total_units'] 	= array_sum($units_array);

	foreach($students AS $row){ 
		$data['grades'][] = summarizer($db,$dbg,$sy,$row['scid'],$crid,1,2,$cfilter,NULL,NULL); 
	}
	
	$data['is_locked'] 	= $classroom['is_finalized_q'.$qtr]; 							
	$data['qf'] 		= $qf	=	'q'.$qtr;					
	
	$crClass		 	= classifyClass($classroom);
	$data['ratings'] 	= getRatings($db,$ctype=1,$crClass['dept_id']);				
	
	$vpath = SITE.'views/customs/'.VCFOLDER.'/summarizerSummarizers.php';		
	if(is_readable($vpath)){ $vfile="/customs/".VCFOLDER."/summarizer";	
	} else { $vfile="summarizers/genaveSummarizers"; }
	
	
	
	$q.="<br />";
	
	if(isset($_GET['debug'])){
		$electives=$filter=$scid=NULL;
		$cond 	= ($ctype)? " AND ( crs.crstype_id = '$ctype' $electives )  " : null;
		$cond  .= ($agg)? " " : " AND (crs.is_aggregate = 0) ";

		$q .= "
			SELECT 
				g.`course_id` AS `course_id`,crs.`label` AS `course`,crs.`supsubject_id`,crs.`units`,
				c.`id` AS `contact_id`,c.`id` AS `student_id`,c.`name` AS `student`,c.`code` AS `student_code`,
				sub.`name` AS `subject`,
				g.`id` AS `gid`,
				g.*,
				sum.`ave_q1`,sum.`ave_q2`,sum.`ave_q3`,sum.`ave_q4`,sum.`ave_q5`
			FROM {$dbg}.`50_grades` AS `g`
				INNER JOIN {$dbo}.`00_contacts` AS c ON g.scid = c.id
				INNER JOIN {$dbg}.05_courses AS crs ON g.course_id = crs.id
				INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id = sub.id
				INNER JOIN {$dbg}.`05_summaries` AS sum ON sum.`scid`  = g.`scid` 
			WHERE 
					g.`scid` 	= '$scid' 
				AND crs.`crid` 	= '$crid' 	
				AND crs.`is_active` = 1 	
				$cond $filter
			ORDER BY crs.`position`,crs.`id`";

	}

	$data['q']=$q;
	// pr($vfile);

	$this->view->render($data,$vfile);
		
	
}	/* fxn */



public function crid($params){
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	if(isset($_POST['submit'])){
		pr($_POST);
		exit;
		
	}
	
	$order=$_SESSION['settings']['classlist_order'];
	$order=isset($_GET['order'])? $_GET['order']:$order;	
	$q="SELECT
			summ.*,c.name AS student,c.code AS studcode
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		WHERE summ.crid='$crid' AND c.is_active=1
		ORDER BY $order;		
	";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
		
	$this->view->render($data,"summarizers/cridSummarizer");
}	/* fxn */




public function student($params=null){		/* from after edit student grades/ */
$dbo=PDBO;
	$fr = array('students','classifications','reports','equivs','details');
	reqr($fr);
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
	$data['scid'] = $scid	= isset($params[0])? $params[0] : false;
	$data['sy']		= $sy	= isset($params[1])? $params[1] : $ssy;
	$data['qtr']	= $qtr	= isset($params[2])? $params[2] : $sqtr;		
	$db =& $this->model->db;$dbg  = VCPREFIX.$sy.US.DBG;
	
	/* controller - teachers or else */
	$data['home']	= $home = $_SESSION['home']; 			

	$allowed = array(RMIS,RREG,RTEAC); /* 5-mis,9-registrars */	
	$srid = $_SESSION['user']['role_id']; 
	if(!in_array($srid,$allowed)){ flashRedirect($home); } 

if($scid){

	$data['user'] = $_SESSION['user'];
	 
/* ------------------------------------------------------------------------------------------------- */		
/* dont move this,classyear for registrars; while classlistSummaries for teacher */
$order = " sum.ave_q$qtr DESC "; 	
/* ------------------------------------------------------------------------------------------------- */	
	
	$fields = " 
		,sum.ave_q1,sum.ave_q2,sum.ave_q3,sum.ave_q4,sum.ave_q5 
		,sum.ave_dg1,sum.ave_dg2,sum.ave_dg3,sum.ave_dg4,sum.ave_dg5
	";
	
	$data['student'] = $student = student($db,$dbg,$sy,$scid);					
	$data['crid'] = $crid = $student['crid'];
	
	$data['classroom']  = $classroom	= getClassroomDetails($db,$crid,$dbg);				
	$data['cr']			= $classroom;	
	$data['is_locked'] 	= $classroom['is_finalized_q'.$qtr];
	$data['is_k12'] 	= $is_k12		= $classroom['is_k12'];
	// $data['sem']		= $sem	= isset($params[4])? $params[4] : $classroom['is_sem'];
	$data['sem']		= $sem	= isset($_GET['sem'])? $_GET['sem'] : $classroom['is_sem'];
	$data['intfqtr']	= $intfqtr			= ($sem==2)? 6:5;
	$data['fqtr']		= $fqtr				= 'q'.$intfqtr;
	$data['iqtr']		= $iqtr	= ($qtr>4)? 4:$qtr;
	$data['derivsem']	= ($qtr<3)? 1:2;
	$data['qodd']		= $qodd = ($qtr%2)? true:false;				
	/* post */
	if(isset($_POST['submit'])){
		$rows = $_POST['sum'];
					
		/* 1 - update summaries */
		$q = "";
		foreach($rows AS $row){
			$expr = " `ave_q$intfqtr` = '".$row['ave']."' ";
			if($is_k12){ $expr .= " ,`ave_dg$intfqtr` = '".$row['ave_dg']."' "; }				

			if($sem==1){
				$expr .= " ,`ave_q1` = '".$row['ave_q1']."' ";		
				if($is_k12) { $expr .= " ,`ave_dg1` = '".$row['ave_dg1']."' "; }
				if(!$qodd){
					$expr .= " ,`ave_q2` = '".$row['ave_q2']."' ";		
					if($is_k12) { $expr .= " ,`ave_dg2` = '".$row['ave_dg2']."' "; }															
				} 					
			} elseif($sem==2){
				$expr .= " ,`ave_q3` = '".$row['ave_q3']."' ";		
				if($is_k12) { $expr .= " ,`ave_dg3` = '".$row['ave_dg3']."' "; }										
				if(!$qodd){
					$expr .= " ,`ave_q4` = '".$row['ave_q4']."' ";		
					if($is_k12) { $expr .= " ,`ave_dg4` = '".$row['ave_dg4']."' "; }															
				} 										
			} else {
				for($i=1;$i<=$iqtr;$i++){				
					$expr .= " ,`ave_q$i` = '".$row['ave_q'.$i]."' ";		
					if($is_k12) { $expr .= " ,`ave_dg$i` = '".$row['ave_dg'.$i]."' ";	}				
				} 				
			}				
			$q .= " UPDATE {$dbg}.05_summaries SET ";
			$q .= $expr;	
			$q .= " WHERE  `id` = '".$row['sumid']."' LIMIT 1; ";						
			
		}	/* endforeach */		
		// pr($q);exit;
		$db->query($q);
				
		/* 3 - redirect to ccr */
		$url = "summarizers/student/$scid/$sy/$qtr";
		redirect($url);	
	}	/* post-submit */
	
	$data['num_students'] 	= 1;		
	$cfilter  = " AND (crs.in_genave = '1') "; 
	$cfilter .= ($sem)? " AND (crs.semester = 0 || crs.semester = $sem) ":NULL;	
	
	$data['subjects'] 		= cridCourses($db,$dbg,$crid,$acad=1,$agg=1,$cfilter);	
	$data['num_subjects'] 	= count($data['subjects']);
	
	$units_array			= buildArray($data['subjects'],'units');
	$data['total_units'] 	= array_sum($units_array);
		
	$data['grades'][] = summarizer($db,$dbg,$sy,$scid,$crid,$acad=1,$agg=2,$cfilter,$limits=NULL,$electives=NULL);
	$crClass		 	= classifyClass($classroom);
	$data['ratings'] 	= getRatings($db,1,$crClass['dept_id']);

	
}	/* scid */

	$vfile='summarizers/studentSummarizer';vfile($vfile);
	$this->view->render($data,$vfile);		
	
	
}	/* summarizer */




}	/* SummarizersController */
