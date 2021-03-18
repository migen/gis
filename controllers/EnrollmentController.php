<?php

Class EnrollmentController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function indexOK(){ 
	ob_start();
	echo "<h3>Enrollment ";shovel('links_enrollment');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");
}	/* fxn */


public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'enrollment/indexEnrollment');
}	/* fxn */



public function manager($params=NULL){
$dbo=PDBO;
require_once(SITE."functions/details.php");
require_once(SITE."functions/rosters.php");
$data['crid']=$crid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;

$data['classroom']=$classroom=getClassroomDetails($db,$crid,$dbg);


if($crid){
	$data['rows']=rosterSummaries($db,$sy,$crid);
	$data['count']=count($data['rows']);
}


if(isset($_POST['batch'])){
	// pr($_POST);
	$posts=isset($_POST['posts'])? $_POST['posts']:NULL;
	$axn=$_POST['batch'];
	$cridto=isset($_POST['cridto'])? $_POST['cridto']:$crid;	
	$q="";	
	if($axn=='Delete'){
		foreach($posts AS $post){
			if(isset($post['is_selected'])){
				// $q.="DELETE FROM {$dbg}.05_summaries WHERE scid='".$post['scid']."' LIMIT 1; ";		
				$q.="UPDATE {$dbg}.05_summaries SET `crid`=0 WHERE `scid`='".$post['scid']."' LIMIT 1; ";
			}
		}		
	}elseif($axn=='Section'){		
		foreach($posts AS $post){
			if(isset($post['is_selected'])){					
				$q.="UPDATE {$dbg}.05_summaries SET `crid`='$cridto' WHERE `scid`='".$post['scid']."' LIMIT 1; ";
			}
		}								
	}elseif($axn=='Init'){
		$nxtdbg=VCPREFIX.($sy+1).US.DBG;
		$q.="INSERT INTO {$nxtdbg}.05_summaries(`scid`,`crid`) VALUES ";
		foreach($posts AS $post){
			if(isset($post['is_selected'])){			
				$q1="SELECT id FROM {$nxtdbg}.05_summaries WHERE `scid`='".$post['scid']."' LIMIT 1; ";
				$sth=$db->query($q1);
				$exists=$sth->fetch();
				if(!$exists){ $q.="('".$post['scid']."','$crid'),"; }
			}
		}
		$q=rtrim($q,",");$q.=";";		
	}elseif($axn=='Update'){
		foreach($posts AS $post){
			if(isset($post['is_selected'])){					
				$q.="UPDATE {$dbo}.`00_contacts` SET `prevcrid`=prevcrid,`crid`=$crid,`name`='".$post['name']."',
				`sy`='".$post['sy']."',`code`='".$post['code']."',`account`='".$post['code']."',
				`is_active`='".$post['is_active']."' WHERE `id`='".$post['scid']."' LIMIT 1; ";
				$q.="UPDATE {$dbo}.05_enrollments SET `crid`='$crid' WHERE `id`='".$post['enid']."' LIMIT 1; ";	
			}
		}			
	}	

	// pr($q);exit;	
	$db->query($q);
	$url="enrollment/manager/$crid/$sy";
	flashRedirect($url,"Batch $axn executed.");
	exit;

}	/* batch */

if(!isset($_SESSION['classrooms'])){
	$cr_fields="id,name,acid,level_id,section_id";$cr_order="level_id,section_id";
	$_SESSION['classrooms']	= fetchRows($db,"{$dbg}.05_classrooms",$cr_fields,$cr_order);		
}
$data['classrooms']=$_SESSION['classrooms'];
$vfile='enrollment/managerEnrollment';vfile($vfile);
$this->view->render($data,$vfile);

}	/* fxn */


public function process($params=NULL){
	$dbo=PDBO;
	require_once(SITE.'views/customs/'.VCFOLDER.'/customs_axis.php');
	$db=&$this->model->db;
	$dbyr=isset($params[0])? $params[0]:DBYR;
	updateIsEnrolled($db,$dbyr);
}	/* fxn */



public function report(){
$db=&$this->model->db;$dbo=PDBO;
$data['today']=$today=$_SESSION['today'];
$tfeeid=1;
$sy=isset($_GET['sy'])? $_GET['sy']:$_SESSION['settings']['sy_enrollment'];
$data['ensy']=$data['sy']=$sy;
$dbg=VCPREFIX.$sy.US.DBG;

if(isset($_GET['filter'])){
	$params=$_GET;
	$cond = "";
	if (!empty($params['lvlbeg'])){ $cond .= " AND cr.level_id >= '".$params['lvlbeg']."' "; }				
	if (!empty($params['lvlend'])){ $cond .= " AND cr.level_id <= '".$params['lvlend']."' "; }				
	if (!empty($params['mode'])){ $cond .= " AND summ.paymode_id = '".$params['mode']."' "; }				
	if (!empty($params['num'])){ $cond .= " AND cr.num = '".$params['num']."' "; }				
	$optr=($params['scope'])? "<=":"=";
	$cond .= ($params['ptr']==8)? " AND p.ptr $optr '1' ":" AND p.ptr $optr '".$params['ptr']."' ";
	
	$beg=$params['beg'];
	$end=$params['end'];
	$sort = 'cr.num,'.$params['sort'];
		
	$q="SELECT p.scid,p.date,c.name AS student,sum(p.amount) AS amount,p.orno,cr.name AS classroom,
			l.name AS level,s.name AS section,pm.name AS paymode,c.code AS studcode,c.sy ";
	if($_GET['parents']==1){ $q.=",pr.father,pr.mother "; }

	$q.=" 
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.30_payments AS p ON p.scid=c.id		
		LEFT JOIN {$dbo}.`00_profiles` AS pr ON pr.contact_id=c.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbo}.`03_paymodes` AS pm ON summ.paymode_id=pm.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id
		WHERE p.date>='$beg' AND p.date<='$end' AND p.feetype_id=1 $cond 
		GROUP BY c.name ORDER BY $sort; ";		
	$data['q']=$q;
	// pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	

}	/* get */

$data['paymodes']=fetchRows($db,"{$dbo}.`03_paymodes`");
$data['levels']=fetchRows($db,"{$dbo}.`05_levels`");

$this->view->render($data,'enrollment/reportEnrollment');

}	/* fxn */



public function links($params=NULL){
$dbo=PDBO;
$acl = array(array(5,0),array(9,0),array(7,2));
$this->permit($acl,$strict=false);				
$data['has_axis']=$has_axis=&$_SESSION['settings']['has_axis'];
require_once(SITE."functions/enrollmentFxn.php");
require_once(SITE."functions/dbyrFxn.php");

$data['scid']=$scid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$_SESSION['qtr'];
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
$data['current']=($sy==DBYR)? true:false;
include_once(SITE.'views/elements/dbsch.php');	/* get-sch */
	
	
if($scid){
	/* 5-1 */
	$scid_exists=checkContact($db,$scid); if(!$scid_exists){ exit; }	
	
	$q="SELECT c.id,c.id AS ucid,c.code,c.name,c.role_id,summ.crid,c.`sy` AS csy,cr.name AS classroom,cr.level_id 
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
		WHERE c.`id`='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
	$data['row_is_student']=$row_is_student=rowIsStudent($row); if(!$row_is_student){ exit; }
	$data['level_id']=$row['level_id'];
	
	
}	/* scid */
	
	$view=isset($_GET['sch'])? "enrollment/linksSch":"enrollment/linksEnrollment";	
	$this->view->render($data,$view);
}	/* fxn */



/* 1) s.crid,s.is_sectioned 2) sum.crid,sum.acid,c.am  */ 
public function sectioner($params=NULL){
$dbo=PDBO;
/* 1 */
$acl = array(array(5,0),array(9,0),array(7,2));
$this->permit($acl,$strict=false);				
$has_axis=&$_SESSION['settings']['has_axis'];
require_once(SITE."functions/enrollmentFxn.php");
require_once(SITE."functions/logs.php");
require_once(SITE."functions/dbyrFxn.php");
$data['scid']=$scid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['year'];
$data['home']=$home=$_SESSION['home'];
$data['brid']=$brid=$_SESSION['brid'];
$data['srid']=$srid=$_SESSION['srid'];
$data['ecid']=$ecid=$_SESSION['ucid'];
$data['today']=$today=$_SESSION['today'];
$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->model->db;

/* 2 */
if(isset($_POST['submit'])){
	$post_crid=$_POST['crid'];
	enrollStudent($db,$sy,$scid,$post_crid);
}	/* post */

/* 3 */
if(!isset($_SESSION['level_classrooms'])){ require_once(SITE.'functions/sessionize_classroom.php');sessionizeLevelClassrooms($db); }
/* 4 */
$dbyr_exists=checkDbyr($db,$sy); if(!$dbyr_exists){ exit; }


/* 5 */
if($scid){ 	/* has user */
	/* 5-1 */
	$scid_exists=checkContact($db,$scid); if(!$scid_exists){ exit; }	
	
	/* 5-2 */
	$data['row']=$row=sectioningStudent($db,$sy,$scid); 
	$data['row_is_student']=$row_is_student=rowIsStudent($row); if(!$row_is_student){ exit; }
	
	/* 5-3 */
	$sync_needed=syncEnrollmentSummaryByStudentNeeded($db,$sy,$scid,$row);

	if($sync_needed){ $url="students/sectioner/$scid/$sy";flashRedirect($url,"Synced."); }	
	/* 5-4 */
	$all = (isset($_GET['all']))? true:false;	
/* 	
	if($has_axis){
		if($row['total']!=$row['assessed']){ 
			require_once(SITE."functions/sync_tuitions.php");syncAllAssessed($db,$sy); 
		}	
	}
 */	
	/* 5-5 */
	$classrooms=($all)? $_SESSION['classrooms']:closeRangeFromLevelClassrooms($db,$row['currlvl']);
	$data['classrooms']=$classrooms;
	
}	/* has user */

$url="students/sectioner/$scid/$sy";
$vfile="students/sectionerEnrollment";vfile($vfile);

$this->view->render($data,$vfile);

}	/* fxn */



public function filter($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['year'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$data['sy']=$_SESSION['year'];
	require_once(SITE."functions/stringFxn.php");
	// require_once(SITE."functions/dbtoolsFxn.php");
	$data['levels']=$_SESSION['levels'];
	
	if(isset($_GET['submit'])){
		$cond=(isset($_GET['all']))? " 1=1 ":" c.role_id=1 ";
		$cond=((isset($_GET['name'])) AND (!empty($_GET['name'])))? $cond." AND c.name LIKE '%".$_GET['name']."%' ":$cond;
		$cond=((isset($_GET['lvl'])) AND (!empty($_GET['lvl'])))? $cond." AND cr.level_id=".$_GET['name']:$cond;
		$order=(isset($_GET['order']))? $_GET['order']:" c.name ";
		$limit=(isset($_GET['limit']))? $_GET['limit']:10;
		$q="SELECT 
				c.id AS scid,c.name,cr.name AS classroom,c.sy,c.is_active,
				summ.scid AS summscid,summ.crid AS summcrid,				
				en.scid AS enscid,en.crid AS encrid
			FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=c.id)
			WHERE $cond			
			ORDER BY $order LIMIT $limit;			
		";
		// 1
		$data['q']=$q;
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();
		// 2
		$q=strtolower($q);
		$field_str=betweenString($q,"select","from");
		$field_str=trim($field_str);
		$data['columns']=$columns=explode(",",$field_str);
		$data['num_columns']=count($columns);		
		foreach($columns AS $i=>$col){ $columns[$i]=cleanColname($col); }
		$data['columns']=$columns;		
		
		// exit;
		
	}	/* get */
	
	
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"enrollment/filterEnrollment");
}	/* fxn */


public function ledger($params=NULL){	// tuition assessment and other fees
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$year_start_enrollment=$_SESSION['settings']['year_start_enrollment'];	
	$data['ucid']=$_SESSION['ucid'];
	$sy=isset($params[1])? $params[1]:DBYR;
	$sy=isset($_GET['sy'])? $_GET['sy']:$sy;	
	if($sy<$year_start_enrollment){ flashRedirect("enrollment/ledger/$scid/$year_start_enrollment","Previous year's records DO NOT exist."); }
	$data['sy']=$sy;$sch=VCFOLDER;
	$data['today']=$_SESSION['today'];
	$data['db']=$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
		
	$acl = array(array(5,0),array(2,0),array(4,0),array(9,0));
	$this->permit($acl);				
	include_once(SITE.'views/elements/dbsch.php');

	
	if($scid){
		include_once(SITE.'functions/ornoFxn.php');		
		include_once(SITE.'functions/syncFxn.php');		
		include_once(SITE.'functions/enrollmentFxn.php');		
		
		$star=scidAssessment($db,$sy,$scid,$fields=NULL);			
		$data['student']=$star['student'];
		$data['payables']=$star['payables'];
		$data['payments']=$star['payments'];
			
		// prx($star);
		
		$paydates_array=getTfeeDuedates($db,$sy,$data['student']['paymode_id']);
		$data['tfee_duedates']=$paydates_array['duedates'];		
		$data['num_periods']=$data['duedates_count']=$paydates_array['count'];
		$data['tfee_duedates_arr']=explode(",",$data['tfee_duedates']);
		$data['tfeePayables']=getTfeesFromPayables($db,$sy,$scid);
		
		// prevaccts		
		$data['prevaccts']=checkPreviousAccounts($db,$sy,$scid);
		
		
	}	/* scid */
	
	
	
	
	$data['feetypes']=$_SESSION['feetypes'];
	$data['paytypes']=$_SESSION['paytypes'];
	$data['lvl']=($scid)? $data['student']['level_id']:4;

	$vfile=($_SESSION['settings']['filter_dropdown']==0)? "enrollment/ledgerEnrollmentFilter":"enrollment/ledgerEnrollment";	
	vfile($vfile);
	

	
	$this->view->render($data,$vfile);	
	
}	/* fxn */




public function paydates($params=NULL){	
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['year'];
	$q="SELECT *,id AS pkid FROM {$dbo}.03_paydates WHERE sy=$sy ORDER BY position;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"enrollment/paydatesEnrollment");
	

}	/* fxn */



public function level($params=NULL){
	
	$data['lvl']=$lvl=isset($params[0])? $params[0]:false;
	$data['ensy']=$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	if(!isset($params)){ pr("Level ID parameter required."); }
	$data['is_conso']=false;
	$data['balance_cutoff']=$balance_cutoff=isset($_GET['balance'])? $_GET['balance']:$_SESSION['settings']['balance_cutoff'];
	
	if($lvl){
		$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
		$cond=isset($_GET['all'])? NULL:"tsum.enrolled_balance<=$balance_cutoff";
		$data['num']=$num=isset($_GET['num'])? $_GET['num']:1;			
			
		$q="SELECT summ.scid,c.sy,c.code,c.name,m.name AS paymode,tsum.*,cr.name AS classroom
				,t.total AS total_fees,t.tuition_amount
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			LEFT JOIN {$dbg}.03_tsummaries AS tsum ON tsum.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.03_paymodes AS m ON summ.paymode_id=m.id			
			LEFT JOIN {$dbo}.03_tuitions AS t ON (cr.level_id=t.level_id && t.num=cr.num)
			WHERE cr.level_id=$lvl AND t.sy=$sy AND (($cond) OR (c.is_employee_child=1))
			ORDER BY cr.num,c.name;";						
			
		debug($q);
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=$sth->rowCount();

		/* data-2 */
		$q="SELECT t.tuition_amount,t.total AS total_amount,l.name AS level FROM {$dbo}.03_tuitions AS t 
			INNER JOIN {$dbo}.05_levels AS l ON t.level_id=l.id 
			WHERE t.sy=$sy AND t.level_id=$lvl AND t.num=$num LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['tuition']=$sth->fetch();			
	}	/* lvl */
	$data['levels']=$_SESSION['levels'];
	
	$this->view->render($data,"enrollment/levelEnrollment");
	
}	/* fxn */




public function syncLevelTsumDetails($params=NULL){
	$sch=VCFOLDER;
	require_once(SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php");
	$data['lvl']=$lvl=isset($params[0])? $params[0]:false; 
	if(!isset($params)){ pr("Parameter level ID required."); exit; }
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
		
	require_once(SITE.'functions/syncFxn.php');
	syncTsum($db,$sy,$exe=true); 
		
	// $num=isset($_GET['num'])? $_GET['num']:1;	
	$q="SELECT id,code,name,num_count FROM {$dbo}.05_levels WHERE id=$lvl LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$num_count=$row['num_count'];
	
	for($num=1;$num<=$num_count;$num++){
	
		/* data-1 */
		$q="SELECT l.code,l.name,t.tuition_amount,t.total FROM {$dbo}.05_levels AS l
			LEFT JOIN {$dbo}.03_tuitions AS t ON t.level_id=l.id
			WHERE t.sy=$sy AND t.level_id=$lvl AND t.num=$num LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['level']=$level=$sth->fetch();
		$total=$level['total'];

		/* getLevelScids */
		$q="SELECT summ.scid 
			FROM {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE cr.level_id=$lvl AND cr.num=$num;";
		$sth=$db->querysoc($q);
		$scids=$sth->fetchAll();
		$scid_arr=buildArray($scids,"scid");

		pr("<a href='".URL."/balances/enrolled/".$lvl."' >Report</a>");
	
		foreach($scid_arr AS $scid){
			// $scid=2233;
			$q="SELECT $total AS total,summ.paymode_id,
					SUM(pm.amount) AS tfee_paid
				FROM {$dbg}.05_summaries AS summ
				LEFT JOIN {$dbg}.03_tsummaries AS tsum ON tsum.scid=summ.scid
				LEFT JOIN {$dbo}.30_payments AS pm ON pm.scid=summ.scid		
				WHERE pm.sy=$sy AND pm.scid=$scid AND (pm.feetype_id=1 OR pm.feetype_id=2); ";
			$sth=$db->querysoc($q);
			$one=$sth->fetch();
			
			/* discounts */
			$q="SELECT SUM(pa.amount) AS total_discount
					FROM {$dbo}.30_payables AS pa 
					INNER JOIN {$dbo}.03_feetypes AS ft ON pa.feetype_id=ft.id
					WHERE pa.sy=$sy AND pa.scid=$scid AND ft.is_discount=1;";
			$sth=$db->querysoc($q);
			$two=$sth->fetch();
			$student=array_merge($one,$two);
			
			/* arp */
			$arp=adjustPayablesSjam($student);	
			$studarp=array_merge($student,$arp);	
			extract($studarp);

			$tfee_paid=(empty($tfee_paid))? 0:$tfee_paid;
			$total_discount=(empty($total_discount))? 0:$total_discount;
			$balance=$adjusted_periodic-$tfee_paid;
			
			$q="UPDATE {$dbg}.03_tsummaries SET enrolled_amount='$adjusted_periodic',tfee_paid='$tfee_paid',enrolled_balance='$balance' WHERE scid=$scid LIMIT 1;";
			$sth=$db->querysoc($q);
			
		}	/* foreach */
	}	/* num_count */
		
	// pr($q);	
		
	flashRedirect("enrollment/level/$lvl","Updated.");
	
	
}	/* fxn */







}	/* EnrollmentController */
