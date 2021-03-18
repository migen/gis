<?php

Class GenaveController extends Controller{	

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




public function truval($params){	/* crid */
	$dbo=PDBO;
	require_once(SITE."functions/classifications.php");
	require_once(SITE."functions/equivs.php");
	require_once(SITE."functions/reports.php");
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/logs.php");
	$db =& $this->model->db;
	
	$_SESSION['q']	= "";

	$data['crid']	= $crid 	= $params[0];
	$data['ssy']	= $ssy  = $_SESSION['sy'];
	$data['sy']		= $sy 	= isset($params[1])? $params[1] : $ssy;	
	$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
	$data['qtr']	= $qtr 	= isset($params[2])? $params[2] : $sqtr;	
	$data['iqtr']	= $iqtr	= ($qtr>4)? 4:$qtr;
	$data['srid']	= $srid = $_SESSION['srid']; 
		
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	/* controller - teachers or else */
	$data['home'] = $home	= $_SESSION['home'];
	$data['classroom']		= $classroom	= getClassroomDetails($db,$crid,$dbg);			
	$data['cr']				= $classroom;
	$data['is_k12']			= $is_k12		= $classroom['is_k12'];
	
	if(!isset($_GET['sem'])){
		$sem=0;
	} else {
		$sem=$_GET['sem'];
	}
	
	$data['sem'] = $sem;
	$data['intfqtr']	= $intfqtr			= ($sem==2)? 6:5;
	$data['fqtr']		= $fqtr				= 'q'.$intfqtr;
	$data['qodd']		= $qodd = ($qtr%2)? true:false;				
	
	if($sem){
		$data['idiv'] = ($qodd)? 1:2;
	} else {
		$data['idiv']		= $iqtr;	
	}
	
		
	$_SESSION['summarizer'] = "summarizers/genave/$crid/$sy/$qtr";
	$data['user']			= $_SESSION['user'];
	
	$allowed = array(RMIS,RREG,RACAD);
	$data['srid'] = $srid = $_SESSION['srid'];
	$home = $_SESSION['home'];
	$data['admin'] = $admin	= true;
	// $data['admin'] = $admin	= (!in_array($srid,$allowed))? true:false;
	

	
	
/* -------------------------- */	
/* dont move this */
// $order = ($qtr>4)? " sum.rank_classroom_q$intfqtr ASC " : " sum.ave_q$qtr DESC "; 	
$order = $_SESSION['settings']['classlist_order']; 	
if(isset($_GET['alpha'])){ $order="c.name"; }
$data['students'] 	= $students = classyear($db,$dbg,$sy,$crid,$male=2,$order,$fields=null); 
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
			// exit;
						
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
			
			// pr($q); exit;
			$this->model->db->query($q);
					
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
	
	$vpath = SITE.'views/customs/'.VCFOLDER.'/truval.php';		
	if(is_readable($vpath)){ $vfile="/customs/".VCFOLDER."/truval";	
	} else { $vfile="genave/truval"; }

	$this->view->render($data,$vfile);
		
	
}	/* fxn */



public function student($params){		/* from after edit student grades/ */
	$dbo=PDBO;
	$fr = array('students','classifications','reports','equivs','details');
	$db =& $this->model->db;
	reqr($fr);

	$data['scid']	= $scid	= $params[0];	
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['sqtr']	= $sqtr	= $_SESSION['qtr'];
	$data['sy']		= $sy	= isset($params[1])? $params[1] : $ssy;
	$data['qtr']	= $qtr	= isset($params[2])? $params[2] : $sqtr;
		
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	/* controller - teachers or else */
	$data['home']	= $home = $_SESSION['home']; 			

	$allowed = array(RMIS,RREG,RTEAC); /* 5-mis,9-registrars */	
	$srid = $_SESSION['user']['role_id']; 
	if(!in_array($srid,$allowed)){ flashRedirect($home); } 
			
	$data['user'] = $_SESSION['user'];
	 
/* ------------------------------------------------------------------------------------------------- */		
/* dont move this,classyear for registrars; while classlistSummaries for teacher */
$order = " sum.ave_q$qtr DESC "; 	
/* ------------------------------------------------------------------------------------------------- */	
	
	$fields = " ,sum.ave_q1,sum.ave_q2,sum.ave_q3,sum.ave_q4,sum.ave_q5 
		,sum.ave_dg1,sum.ave_dg2,sum.ave_dg3,sum.ave_dg4,sum.ave_dg5 ";
	
	$data['student'] = $student = student($db,$dbg,$sy,$scid);					
	$data['crid'] = $crid = $student['crid'];
	
	$data['classroom']  = $classroom	= getClassroomDetails($db,$crid,$dbg);				
	$data['cr']			= $classroom;	
	$data['is_locked'] 	= $classroom['is_finalized_q'.$qtr];
	$data['is_k12'] 	= $is_k12		= $classroom['is_k12'];
	$data['sem']		= $sem	= isset($params[4])? $params[4] : $classroom['is_sem'];
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
	$this->view->render($data,'summarizers/student');		
	
	
}	/* summarizer */




	public function ranks($params=NULL){
		require_once(SITE.'functions/genaveFxn.php');
		require_once(SITE.'functions/ranksFxn.php');
		$db=&$this->baseModel->db;
		$data['db']=&$db;$dbo=PDBO;

		$data['crid']=$crid=isset($params[0])? $params[0]:FALSE;
		$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
		$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
		$dbg=VCPREFIX.$sy.US.DBG;

		/* ------------- access control --------------------------------------------------------------------- */	
		$srid = $_SESSION['srid'];
		if($srid==RTEAC){ if((!in_array($crid,$_SESSION['teacher']['advisory_ids']))) { flashRedirect('teachers'); } }	
		/* -------------------------------------------------------------------------------------------------- */


		if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$rank=$post['rank'];$sumxid=$post['sumxid'];
			$q.="UPDATE {$dbg}.05_summext SET rank_classroom_q{$qtr} = $rank WHERE id=$sumxid LIMIT 1;";		
		}
		$db->query($q);
		flashRedirect("sir/classroom/$crid/$sy/$qtr","Updated.");
		exit;
		
	}	/* post */


	$field=isset($_GET['field'])? $_GET['field']:"ave_q{$qtr}";
	$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;

	$data['classroom']=fetchRow($db,"{$dbg}.05_classrooms",$crid);
	$limitcond=isset($_GET['limit'])? "LIMIT ".$_GET['limit']:NULL;
	$data['rows']=getGenaveRanks($db,$dbg,$crid,$qtr,$dbo,$limitcond);
	$data['count']=count($data['rows']);


	$vfile="genave/ranksGenave";
	debug($vfile);
	$this->view->render($data,$vfile);

}	/* fxn */




public function classroomQave($params=NULL){
	require_once(SITE.'functions/mathFxn.php');
	$db=&$this->baseModel->db;
	$data['db']=&$db;$dbo=PDBO;

	$data['crid']=$crid=isset($params[0])? $params[0]:FALSE;	
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;

	$a=isset($params[1])? $params[1]:5;
	$b=isset($params[2])? $params[2]:6;
	$c=isset($params[3])? $params[3]:7;

	$data['qa']=$qa="q{$a}";
	$data['qb']=$qb="q{$b}";
	$data['qc']=$qc="q{$c}";

	if(isset($_POST['submit'])){
		$posts = $_POST['posts'];
		$q="";
		foreach($posts AS $post){		
			$q.="UPDATE {$dbg}.05_summaries SET `ave_{$qc}`='".$post['ave']."' WHERE scid=".$post['scid']." LIMIT 1; ";
		}
		// prx($q);
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Fail";
		$url="genave/classroomQave/$crid/$a/$b/$c";
		flashRedirect($url,$msg);
	}	/* post */

	// data
		// data1
	$q="SELECT name AS crname,level_id AS lvl FROM {$dbg}.05_classrooms WHERE id=$crid LIMIT 1; ";		
	$sth=$db->querysoc($q);
	$data['classroom']=$sth->fetch();

		// data2
	$order=(isset($_GET['order']))? $_GET['order'] : $_SESSION['settings']['classlist_order'];
	$q="SELECT 
			c.id AS scid,c.code AS studcode,c.name AS studname,
			summ.ave_{$qa} AS first,
			summ.ave_{$qb} AS second,
			summ.ave_{$qc} AS ave
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
		WHERE summ.crid=$crid
		ORDER BY $order; ";

	$sth = $db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();

	$vfile = "genave/classroomQaveGenave";
	$this->view->render($data,$vfile);


}	/* fxn */



public function levelQave($params=NULL){
	require_once(SITE.'functions/mathFxn.php');
	$db=&$this->baseModel->db;
	$data['db']=&$db;$dbo=PDBO;

	$data['lvl']=$lvl=isset($params[0])? $params[0]:FALSE;	
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;

	$a=isset($params[1])? $params[1]:5;
	$b=isset($params[2])? $params[2]:6;
	$c=isset($params[3])? $params[3]:7;

	$data['qa']=$qa="q{$a}";
	$data['qb']=$qb="q{$b}";
	$data['qc']=$qc="q{$c}";

	if(isset($_POST['submit'])){
		$posts = $_POST['posts'];
		$q="";
		foreach($posts AS $post){		
			$q.="UPDATE {$dbg}.05_summaries SET `ave_{$qc}`='".$post['ave']."' WHERE scid=".$post['scid']." LIMIT 1; ";
		}
		// prx($q);
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Fail";
		$url="genave/levelQave/$lvl/$a/$b/$c";
		flashRedirect($url,$msg);
	}	/* post */

	// data
		// data1
	$q="SELECT name AS `lvlname`,`id` AS lvl FROM {$dbo}.05_levels WHERE id=$lvl LIMIT 1; ";		
	$sth=$db->querysoc($q);
	$data['level']=$sth->fetch();

		// data2
	// $order=(isset($_GET['order']))? $_GET['order'] : $_SESSION['settings']['classlist_order'];
	$classlist_order=$_SESSION['settings']['classlist_order'];
	$order="cr.name,$classlist_order";
	$q="SELECT 
			c.id AS scid,c.code AS studcode,c.name AS studname,
			cr.name AS classroom,
			summ.ave_{$qa} AS first,
			summ.ave_{$qb} AS second,
			summ.ave_{$qc} AS ave
		FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE cr.level_id=$lvl AND cr.section_id > 2
		ORDER BY $order; ";
	debug($q);
	$sth = $db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();

	$vfile = "genave/levelQaveGenave";
	$this->view->render($data,$vfile);


}	/* fxn */



public function shsLevels(){

    if(!isset($_SESSION['levels'])){ 	
        $_SESSION['levels']=$this->model->fetchRows("{$dbo}.`05_levels`","id,name,department_id AS deptid","id"); 
	}
	$data['levels']=$_SESSION['levels'];	


	$vfile="genave/shsLevelsGenave";
	$this->view->render($data,$vfile);

}	/* fxn */
















}	/* GenaveController */
