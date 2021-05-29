<?php

Class SchedulesController extends Controller{	

protected $limits = SNUMROWS;


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index($par=NULL){ 
$dbo=PDBO;
	$data['home']	= $_SESSION['home'];
	$limits = isset($_GET['limits'])? $_GET['limits']:$this->limits;

	prx('<h1>Schedules</h1>');

	if(ONEDB){
		$dbg = PDBG;
	} else {
		$ssy  = $_SESSION['sy'];
		$sy   = (isset($par[0]))? $par[0]:$_SESSION['sy'];			
		$dbg	= VCPREFIX.$sy.US.DBG;	
	}
	
	if(isset($_POST['cancel'])){
		unset($_POST);
		redirect('schedules/index');
	}	/* cancel */
	
	if(isset($_POST['save'])){
		$q = "";
		foreach($_POST['posts'] AS $post){
		// pr($post);
			if($_SESSION['pcid']==$post['owner_pcid']){
				$q .= "UPDATE {$dbg}.schedules SET `date` = '".$post['date']."',`event` = '".$post['event']."',
					`is_active` = '".$post['is_active']."',`is_impt` = '".$post['is_impt']."',`is_recursive` = '".$post['is_recursive']."'
					WHERE `id` = '".$post['id']."' LIMIT 1; ";				
			}
		}	/* foreach */
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "schedules/index";
		redirect($url);
		exit;
	}

/* --------- conditions --------- */	
	
	$params = isset($_POST)? $_POST:array();
	$cond = NULL;
	$cond .= "";

	if (!empty($params['start'])){ $cond .= " AND s.date >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND s.date <= '".$params['end']."'"; }				
	if (!empty($params['event'])){ $cond .= " AND s.event LIKE '%".$params['event']."%'"; }				
	if(isset($params['is_active'])){
		switch($params['is_active']){
			case 0: $cond .= " AND s.`is_active` = '0'"; break;
			case 1: $cond .= " AND s.`is_active` = '1'"; break;
			default: break;
		}
	} 
	if(isset($params['is_impt'])){
		switch($params['is_impt']){
			case 0: $cond .= " AND s.`is_impt` = '0'"; break;
			case 1: $cond .= " AND s.`is_impt` = '1'"; break;
			default: break;
		}
	} 
	if(isset($params['is_recursive'])){
		switch($params['is_recursive']){
			case 0: $cond .= " AND s.`is_recursive` = '0'"; break;
			case 1: $cond .= " AND s.`is_recursive` = '1'"; break;
			default: break;
		}
	} 
		
	if (!empty($params['room_id'])){ $share = " OR s.room_id = '".$params['room_id']."'"; } else {
		$share = " ";
		foreach($_SESSION['urooms'] AS $row){ $share .= " OR s.room_id = '".$row['room_id']."'"; }		
	}				

	$offset = isset($params['page'])? ($params['page']-1)*$params['limits']:0;
	$limits = isset($params['limits'])? $params['limits']:LIMITS;
	$sort   = (isset($params['sort']))?$params['sort']:'s.date';
	$order  = (isset($params['order']))?$params['order']:'DESC';
	
/* --------- conditions --------- */	

	$q = "
		SELECT 
			s.*,c.name AS owner,r.name AS room,s.id AS id
		FROM {$dbg}.schedules AS s 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON s.owner_pcid = c.id
			LEFT JOIN {$dbo}.rooms AS r ON s.room_id = r.id
		WHERE 
				(s.owner_pcid = '".$_SESSION['pcid']."' $share) $cond				
		ORDER BY $sort $order LIMIT ".$limits." OFFSET $offset 				
	";
	// pr($q);
	
	$data['is_admin'] = (($_SESSION['user']['role_id']==RMIS))? true:false;
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

	$this->view->render($data,'schedules/index');

}	/* fxn */



public function add(){
$dbo=PDBO;

	if(isset($_POST['submit'])){

	unset($_POST['submit']);
		// pr($_POST);
		$this->model->db->add("{$dbg}.schedules",$_POST);		
		flashRedirect('schedules/add','Event Added!');
		exit;
		
	}	/* post */

	
	
	$data = isset($data)? $data:NULL;
	$this->view->render($data,'schedules/add');



}	/* fxn */



public function edit($params){
$dbo=PDBO;

$id = $params[0];
if(ONEDB){
	$dbg = PDBG;
} else {
	$ssy  = $_SESSION['sy'];
	$sy   = (isset($par[0]))? $par[0]:$_SESSION['sy'];			
	$dbg	= VCPREFIX.$sy.US.DBG;	
}

if(isset($_POST['submit'])){
	// pr($_POST); 
	$post = $_POST;
	$q = "UPDATE {$dbg}.schedules SET `date` = '".$post['date']."',`event` = '".$post['event']."',`room_id`='".$post['room_id']."',
		`is_active` = '".$post['is_active']."',`is_impt` = '".$post['is_impt']."',`is_recursive` = '".$post['is_recursive']."'
		WHERE `id` = '".$post['id']."' LIMIT 1; ";				
	// pr($q);
	$this->model->db->query($q);
	$url = 'schedules/view/'.$id;
	redirect($url);	
	exit;
	
}	/* post */

$q = "SELECT  *,id AS id  FROM {$dbg}.schedules WHERE `id` = '$id' LIMIT 1;";
$sth = $this->model->db->querysoc($q);
$data['row'] = $sth->fetch();

$this->view->render($data,'schedules/edit');


}	/* fxn */


public function delete($params){
$dbo=PDBO;
$id = $params[0];
if(ONEDB){
	$dbg = PDBG;
} else {
	$ssy  = $_SESSION['sy'];
	$sy   = (isset($par[0]))? $par[0]:$_SESSION['sy'];			
	$dbg	= VCPREFIX.$sy.US.DBG;	
}

$q = "DELETE FROM {$dbg}.schedules WHERE `id` = '$id' LIMIT 1; ";
$this->model->db->query($q);
redirect('schedules/index');


}	/* fxn */





public function view($params){
$dbo=PDBO;

$id = $params[0];
if(ONEDB){
	$dbg = PDBG;
} else {
	$ssy  = $_SESSION['sy'];
	$sy   = (isset($par[0]))? $par[0]:$_SESSION['sy'];			
	$dbyr 	= $sy.US;	
	$dbg	= VCPREFIX.$dbyr.DBG;	
}


$q = "SELECT  *,id AS id  FROM {$dbg}.schedules WHERE `id` = '$id' LIMIT 1;";
$sth = $this->model->db->querysoc($q);
$data['row'] = $sth->fetch();

$this->view->render($data,'schedules/view');


}	/* fxn */



public function bulk(){
$dbo=PDBO;
	$dbg = PDBG;
	if(isset($_POST['submit'])){
		$pcid = $_SESSION['pcid'];
		$posts = $_POST['posts'];
		$q = "INSERT INTO {$dbg}.schedules(`owner_pcid`,`date`,`event`) VALUES  ";
		foreach($posts AS $post){
			$q .= "('$pcid','".$post['date']."','".$post['event']."'),";
		}
		$q = rtrim($q,',');
		$q .= ";";
		$this->model->db->query($q);
		flashRedirect('schedules','Buld Events Added!');				
		exit;
		
	}	/* post */
		
	$data = isset($data)? $data:NULL;
	$this->view->render($data,'schedules/bulk');

}	/* fxn */



public function rcards($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$acl = array([4,0],[5,0],[9,0],[2,0]);
	$this->permit($acl,false);
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$data['dbtable']="{$dbo}.05_rcards_schedules";
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			$db->update("{$dbo}.05_rcards_schedules",$post,"id=".$post['id']);
		}
		flashRedirect('schedules/rcards');
	}	/* post */

	$cond=isset($_GET['lvl'])? " AND cr.level_id=".$_GET['lvl']:null;

	// getData
	$q="SELECT rs.id AS pkid,cr.id AS crid,rs.crid AS rscrid,rs.is_open,cr.name,cr.id,cr.num,cr.section_id,
			l.name AS level,l.code AS lvlcode,l.id AS lvl
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.05_rcards_schedules AS rs ON rs.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE cr.section_id<>2 $cond
		ORDER BY cr.level_id,cr.num,cr.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	
	
	// sync
	if(isset($_GET['sync'])){
		$q="INSERT INTO {$dbo}.05_rcards_schedules(crid) VALUES";
		foreach($rows AS $row){
			if(!$row['rscrid']){ $q.="(".$row['crid']."),"; }
		}
		$q=rtrim($q,',');$q.=";";
		$sth=$db->query($q);
		$msg = ($sth)? "Success":"Fail";
		flashRedirect('schedules/rcards',$msg);
	}	/* sync */
	
	
	$data['levels']=isset($_SESSION['levels'])? $_SESSION['levels']:fetchRows($db,"{$dbo}.05_levels","id,code,name","id");
	
	$this->view->render($data,"schedules/rcardsSchedules");
	
}	/* fxn */



public function ensteps($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$acl = array([4,0],[5,0],[9,0],[2,0]);
	$this->permit($acl,false);
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$data['dbtable']="{$dbo}.05_rcards_schedules";
	$data['num_ensteps']=$_SESSION['settings']['num_ensteps'];
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			$db->update("{$dbo}.05_rcards_schedules",$post,"id=".$post['id']);
		}
		flashRedirect('schedules/rcards');
	}	/* post */

	$cond=isset($_GET['lvl'])? " AND cr.level_id=".$_GET['lvl']:null;

	// getData
	$q="SELECT rs.id AS pkid,cr.id AS crid,rs.crid AS rscrid,rs.enstep,cr.name,cr.id,cr.num,
			l.name AS level,l.code AS lvlcode,l.id AS lvl
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.05_rcards_schedules AS rs ON rs.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE cr.section_id<>2 $cond
		ORDER BY cr.level_id,cr.num,cr.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	
	
	// sync
	if(isset($_GET['sync'])){
		$q="INSERT INTO {$dbo}.05_rcards_schedules(crid) VALUES";
		foreach($rows AS $row){
			if(!$row['rscrid']){ $q.="(".$row['crid']."),"; }
		}
		$q=rtrim($q,',');$q.=";";
		$sth=$db->query($q);
		$msg = ($sth)? "Success":"Fail";
		flashRedirect('schedules/rcards',$msg);
	}	/* sync */
		
	$data['levels']=isset($_SESSION['levels'])? $_SESSION['levels']:fetchRows($db,"{$dbo}.05_levels","id,code,name","id");
	
	$this->view->render($data,"schedules/enstepsSchedules");
	
}	/* fxn */



public function booklists($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$acl = array([4,0],[5,0],[9,0],[2,0]);
	$this->permit($acl,false);
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$data['dbtable']="{$dbo}.05_rcards_schedules";
	// $data['num_ensteps']=$_SESSION['settings']['num_ensteps'];
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			$db->update("{$dbo}.05_rcards_schedules",$post,"id=".$post['id']);
		}
		flashRedirect('schedules/booklists');
	}	/* post */

	$cond=isset($_GET['lvl'])? " AND cr.level_id=".$_GET['lvl']:null;

	// getData
	$q="SELECT rs.id AS pkid,cr.id AS crid,rs.crid AS rscrid,rs.booklist,cr.name,cr.id,cr.num,
			l.name AS level,l.code AS lvlcode,l.id AS lvl
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.05_rcards_schedules AS rs ON rs.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE cr.section_id<>2 $cond
		ORDER BY cr.level_id,cr.num,cr.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	
	
	// sync
	if(isset($_GET['sync'])){
		$q="INSERT INTO {$dbo}.05_rcards_schedules(crid) VALUES";
		foreach($rows AS $row){
			if(!$row['rscrid']){ $q.="(".$row['crid']."),"; }
		}
		$q=rtrim($q,',');$q.=";";
		$sth=$db->query($q);
		$msg = ($sth)? "Success":"Fail";
		flashRedirect('schedules/rcards',$msg);
	}	/* sync */
		
	$data['levels']=isset($_SESSION['levels'])? $_SESSION['levels']:fetchRows($db,"{$dbo}.05_levels","id,code,name","id");
	
	$this->view->render($data,"schedules/booklistsSchedules");
	
}	/* fxn */



public function tuitions($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$acl = array([4,0],[5,0],[9,0],[2,0]);
	$this->permit($acl,false);
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$data['dbtable']="{$dbo}.05_rcards_schedules";
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			$db->update("{$dbo}.05_rcards_schedules",$post,"id=".$post['id']);
		}
		flashRedirect('schedules/tuitions');
	}	/* post */

	$cond=isset($_GET['lvl'])? " AND cr.level_id=".$_GET['lvl']:null;

	// getData
	$q="SELECT rs.id AS pkid,cr.id AS crid,rs.crid AS rscrid,rs.tuition,cr.name,cr.id,cr.num,
			l.name AS level,l.code AS lvlcode,l.id AS lvl
		FROM {$dbg}.05_classrooms AS cr 
		LEFT JOIN {$dbo}.05_rcards_schedules AS rs ON rs.crid=cr.id
		LEFT JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		WHERE cr.section_id<>2 $cond
		ORDER BY cr.level_id,cr.num,cr.name; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	
	
	// sync
	if(isset($_GET['sync'])){
		$q="INSERT INTO {$dbo}.05_rcards_schedules(crid) VALUES";
		foreach($rows AS $row){
			if(!$row['rscrid']){ $q.="(".$row['crid']."),"; }
		}
		$q=rtrim($q,',');$q.=";";
		$sth=$db->query($q);
		$msg = ($sth)? "Success":"Fail";
		flashRedirect('schedules/rcards',$msg);
	}	/* sync */
		
	$data['levels']=isset($_SESSION['levels'])? $_SESSION['levels']:fetchRows($db,"{$dbo}.05_levels","id,code,name","id");
	
	$this->view->render($data,"schedules/tuitionsSchedules");
	
}	/* fxn */


public function classroom($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['sy_enrollment']=$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;

	$data['cr']=NULL;
	$data['lvl']=4;
	if($crid){
		$data['cr']=fetchRow($db,"{$dbg}.05_classrooms",$crid,"id AS crid,code AS crcode,name AS crname,level_id AS lvl");
	}

	$this->view->render($data,"schedules/classroomSchedules");
	
	
}	/* fxn */




}	/* SchedulesController */
