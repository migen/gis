<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

Class LogsController extends Controller{

public function __construct(){
	parent::__construct();
	parent::beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	 

	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	/* 2nd param is strict,default is false */	
	$this->permit($acl);					
	// $this->permit($acl,true);					
	
	
}


public function beforeFilter(){}


function logger(){
$dbo=PDBO;
	require_once(SITE.'functions/loggerFxn.php');
	$date = isset($_SESSION['date'])? $_SESSION['date'] : date('Y-m-d');
	$time = date('H:i:s');
	$ucid = isset($_SESSION['user']['ucid'])? $_SESSION['user']['ucid'] : '0';
	$url  = $this->url();
	$text = $_SERVER['REMOTE_ADDR'];
	$q = " INSERT INTO {$dbg}.50_logs (`date`,`time`,`contact_id`,`url`,`text`) VALUES 
		('$date','$time','$ucid','$url','$text'); ";
	$this->baseModel->db->query($q);
}


public function index(){
// $data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$dbo = PDBO;
// $dbg = VCPREFIX.$sy.US.DBG;
$data['count']=0;
if(isset($_GET['filter'])){
	$get = $_GET;	
	$sy=$get['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$cond=NULL;
	$cond.="";
	// pr($get);
	// pr($cond);
	// exit;
	if(!empty($_GET['details'])){  $cond .= " AND l.details LIKE '%".$_GET['details']."%'";  }
	// $offset = ($get['page']-1)*$get['limits'];
	$limit=isset($get['limit'])? $get['limit']:10;
	$sort=(isset($get['sort']))?$get['sort']:'l.datetime';
	$order=(isset($get['order']))?$get['order']:'DESC';
	if (!empty($get['dateone'])){ $cond .= " AND DATE(l.datetime) >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND DATE(l.datetime) <= '".$get['datetwo']."'"; }				
		
	$q = " SELECT l.*,c.name AS username FROM {$dbg}.50_logs AS l
			LEFT JOIN {$dbo}.00_contacts AS c ON l.ucid=c.id ";			
	$q .= "	WHERE 1=1 $cond ORDER BY $sort $order LIMIT $limit; ";
	debug($q);
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$data['empty'] = (isset($_GET['filter']))? false:true;	

} 

	$data['sy']=isset($sy)? $sy:DBYR;
	$vfile="logs/indexLogs";vfile($vfile);
	$data=isset($data)? $data:NULL;
	$this->view->render($data,$vfile);
}	/* fxn */




public function simple(){
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$dbo = PDBO;
$dbg = VCPREFIX.$sy.US.DBG;
if(isset($_GET['filter'])){
	$get = $_GET;	
	$cond=NULL;
	$cond.="";
	if(!empty($_GET['details'])){  $cond .= " AND l.details LIKE '%".$_GET['details']."%'";  }
	// $offset = ($get['page']-1)*$get['limits'];
	$limit=isset($get['limit'])? $get['limit']:10;
	$sort=(isset($get['sort']))?$get['sort']:'l.datetime';
	$order=(isset($get['order']))?$get['order']:'DESC';
		
	$q = " SELECT l.* FROM {$dbg}.50_logs AS l ";			
	$q .= "	WHERE 1=1 $cond ORDER BY $sort $order LIMIT $limit; ";
	debug($q);
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$data['empty'] = (isset($_GET['filter']))? false:true;	
} 
	
	$vfile="logs/simpleLogs";vfile($vfile);
	$data=isset($data)? $data:NULL;
	$this->view->render($data,$vfile);
}	/* fxn */






public function complex(){
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$dbo = PDBO;
$dbg = VCPREFIX.$sy.US.DBG;

if(isset($_GET['filter'])){
	$get = $_GET;
	
	$cond = NULL;
	$cond .= "";
	if(!empty($_GET['ucid'])){  $cond .= " AND l.ucid = '".$_GET['ucid']."'";  }
	if(!empty($_GET['ecid'])){  $cond .= " AND l.ecid = '".$_GET['ecid']."'";  }
	if(!empty($_GET['scid'])){  $cond .= " AND l.scid = '".$_GET['scid']."'";  }
	if(!empty($_GET['module'])){  $cond .= " AND m.id = '".$_GET['module']."'";  }
	if(!empty($_GET['action'])){  $cond .= " AND a.id = '".$_GET['action']."'";  }
	if(!empty($_GET['crid'])){  $cond .= " AND l.crid = '".$_GET['crid']."'";  }
	if(!empty($_GET['crsid'])){  $cond .= " AND l.crsid = '".$_GET['crsid']."'";  }

	if(!empty($_GET['orno'])){  $cond .= " AND l.orno = '".$_GET['orno']."'";  }
	if(!empty($_GET['details'])){  $cond .= " AND l.details LIKE '%".$_GET['details']."%'";  }

	if (!empty($get['dateone'])){ $cond .= " AND DATE(l.datetime) >= '".$get['dateone']."'"; }				
	if (!empty($get['datetwo'])){ $cond .= " AND DATE(l.datetime) <= '".$get['datetwo']."'"; }				

	$offset = ($get['page']-1)*$get['limits'];
	$sort   = (isset($get['sort']))?$get['sort']:'p.datetime';
	$order  = (isset($get['order']))?$get['order']:'DESC';
		
	$q = "
  		SELECT 
			l.*,c.name AS user,a.name AS action,m.name AS module,e.name AS employee
		FROM {$dbg}.50_logs AS l
			LEFT JOIN {$dbo}.`00_contacts` AS c ON l.ucid = c.id
			LEFT JOIN {$dbo}.`00_contacts` AS e ON l.ecid = e.id
			LEFT JOIN {$dbo}.`00_actions` AS a ON l.action_id = a.id
			LEFT JOIN {$dbo}.modules AS m ON a.module_id = m.id
	";			
	$q .= "	WHERE 1=1 $cond ORDER BY $sort $order LIMIT ".$get['limits']." OFFSET $offset ; ";
	debug($q);
	$_SESSION['q'] = $q;
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$data['empty'] = (isset($_GET['filter']))? false:true;	
} else {
	$data['modules'] = $this->model->fetchRows("{$dbo}.`modules`","id,name");	
	$data['axn'] = $_SESSION['axn'];
	$data['courses'] = $this->model->fetchRows("{$dbg}.05_courses","id,name","crid");	
	$data['classrooms'] = $this->model->fetchRows("{$dbg}.05_classrooms","id,name","level_id");	
	

}	/* filter */

	/* for batch edits */
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$url = 'logs/delete/'.$ids;
		redirect($url);		
	}




$this->view->render($data,'logs/complexLogs');


}	/* fxn */


 
public function logdetails($params){
$logid = $params[0];
$dbg = PDBG;
$dbg = PDBG;
$dbo=PDBO;

$q = "
  		SELECT 			
			l.id AS logid,l.*,c.name AS user,a.name AS action,m.name AS module,
			f.name AS fee,s.name AS student,e.name AS employee,crs.name AS course,cr.name AS classroom			
		FROM {$dbg}.50_logs AS l
			LEFT JOIN {$dbo}.`00_contacts` AS c ON l.ucid = c.id
			LEFT JOIN {$dbo}.`00_contacts` AS s ON l.scid = s.id
			LEFT JOIN {$dbo}.`00_contacts` AS e ON l.ecid = e.id
			LEFT JOIN {$dbo}.`00_actions` AS a ON l.action_id = a.id
			LEFT JOIN {$dbo}.modules AS m ON a.module_id = m.id
			LEFT JOIN {$dbo}.`03_feetypes` AS f ON l.feeid = f.id
			LEFT JOIN {$dbg}.05_courses AS crs ON l.crsid = crs.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON l.crid = cr.id
		WHERE l.`id` = '$logid' LIMIT 1;
";
// pr($q);
$sth = $this->model->db->querysoc($q);
$data['row'] = $sth->fetch();

$this->view->render($data,'logs/logdetails');

}	/* fxn */





public function scores($params=NULL){
$dept=isset($params[0])? $params[0]:2;
$limits=isset($_GET['limits'])? $_GET['limits']:300;

$db=&$this->model->db;
$dbo=PDBO;
$dbg=PDBG;
$dbg=PDBG;

$q="
	SELECT 
		crs.id AS crsid,crs.name AS course,cr.name AS classroom,a.*,a.name AS activity,cr.id AS crid,
		sub.name AS subject,t.name AS teacher
	FROM {$dbg}.50_scores AS s
		LEFT JOIN {$dbg}.05_courses AS crs ON s.course_id=crs.id
		LEFT JOIN {$dbo}.`00_contacts` AS t ON crs.tcid=t.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbg}.50_activities AS a ON s.activity_id=a.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id		
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id		
	WHERE l.department_id = '$dept' GROUP BY crs.id 
	ORDER BY cr.level_id,sub.name,a.date
	LIMIT $limits ;
		
";
// pr($q);

$sth=$db->query($q);
$rows=$sth->fetchAll();
$data['rows']=$rows;
$data['count']=count($rows);
$this->view->render($data,'logs/scores');
// echo ($sth)? "Succeeded":"Failed"; 
 
} 	/* fxn */




public function delete($params){
$dbo=PDBO;
	// require_once(SITE.'functions/crudFxn.php');
	$db=&$this->model->db;$dbg=PDBG;$q="";
	foreach($params AS $id){ $q.="DELETE FROM {$dbg}.50_logs WHERE id='$id' LIMIT 1; "; }
	$db->query($q);
	flashRedirect('logs','Logs batch delete.');


}	/* fxn */



public function v2(){
	$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
	$dbo = PDBO;
	$dbg = VCPREFIX.$sy.US.DBG;
$data['count']=0;
if(isset($_GET['filter'])){
	$get = $_GET;	
	$cond=NULL;
	$cond.="";
	if(!empty($_GET['details'])){  $cond .= " AND l.details LIKE '%".$_GET['details']."%'";  }
	// $offset = ($get['page']-1)*$get['limits'];
	$limit=isset($get['limit'])? $get['limit']:10;
	$sort=(isset($get['sort']))?$get['sort']:'l.datetime';
	$order=(isset($get['order']))?$get['order']:'DESC';
		
	$q = " SELECT l.* FROM {$dbo}.logs AS l ";			
	$q .= "	WHERE 1=1 $cond ORDER BY $sort $order LIMIT $limit; ";
	pr($q);
	debug($q);
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$data['empty'] = (isset($_GET['filter']))? false:true;	
} 
	
	$vfile="logs/v2Logs";vfile($vfile);
	$data=isset($data)? $data:NULL;
	$this->view->render($data,$vfile);	
	

	
	
}	/* fxn */




}	/* LogsController */