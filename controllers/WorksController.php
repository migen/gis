<?php

/* crscfg, */
Class WorksController extends Controller{ 

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();		
	
}

public function index($params=NULL){
$dbo=PDBO;

// pr($_SESSION);
$today = $_SESSION['today'];
$data['srid']	= $srid = $_SESSION['srid'];
$data['admin'] 	= ($srid==RMIS || $srid==RREG || $srid==RACAD)? true:false;

$cond_all = " AND w.`is_active` 	= '1'";

$cond 	= isset($_GET['all'])? NULL:$cond_all;	
$ssy 	= $_SESSION['sy'];
$data['sy']	= $sy		= isset($params[0])? $params[0]:$ssy;
$dbg	= VCPREFIX.$sy.US.DBG;$db = $this->model->db;
$q = "SELECT w.*,c.name AS contact	
	FROM {$dbg}.works AS w
		LEFT JOIN {$dbo}.`00_contacts` AS c ON w.ucid = c.id
	WHERE 1=1 $cond ORDER BY w.date DESC;";	
$sth = $db->querysoc($q);
$data['works'] = $sth->fetchAll();
$data['count']	= count($data['works']);
	

// $view = isset($_GET['window'])? 'window':'table';	
// $this->view->render($data,'events/index');	
$this->view->render($data,"works/index");	
	

}	/* fxn */


private function news($date=NULL){
$dbo=PDBO;
	$dbg 	= PDBG;
	$today 	= isset($date)? $date:$_SESSION['today']; 
	$q = " SELECT * FROM {$dbg}.events WHERE `date` = '$today' LIMIT 1; ";	
	$sth = $this->model->db->querysoc($q);
	return $sth->fetch();
}	/* fxn */



public function view($params){
$dbo=PDBO;
$data['eid'] = $eid	= $params[0];
$dbg = PDBG;

$q = "SELECT * FROM {$dbg}.events WHERE `id` = '$eid' LIMIT 1; ";
$sth = $this->model->db->querysoc($q);
$data['event'] = $sth->fetch();

$this->view->render($data,'events/view');

}	/* fxn */


public function edit($params){
$dbo=PDBO;
$data['eid'] = $eid	= $params[0];
$dbg = PDBG;

if(isset($_POST['submit'])){
	$date  	= $_POST['date'];
	$event 	= $_POST['event'];
	$ucid  = $_SESSION['user']['ucid'];
	$q = "UPDATE {$dbg}.events SET `ucid`='$ucid',`date` = '$date',`event` = '$event' WHERE `id` = '$eid' LIMIT 1; ";	
	$r = $this->model->db->query($q);
	$_SESSION['message'] = ($r)? "Event updated!":"Event date already exists!";

	$url = "events";
	redirect($url);	
}	/* post */

$q = "SELECT * FROM {$dbg}.events WHERE `id` = '$eid' LIMIT 1; ";
$sth = $this->model->db->querysoc($q);
$data['event'] = $sth->fetch();

$this->view->render($data,'events/edit','editor');

}	/* fxn */


public function add(){
$dbo=PDBO;
$dbg = PDBG;
if(isset($_POST['submit'])){
$date  = $_POST['date'];
$news  = $this->news($date);
$event = $_POST['event'];
$ucid  = $_SESSION['user']['ucid'];

if($date==$news['date']){
	$_SESSION['message']='Day event already exists!';
} else {
	$q = "INSERT INTO {$dbg}.events(`ucid`,`date`,`event`) VALUES('$ucid','$date','$event'); ";	
	$this->model->db->query($q);
	$_SESSION['message'] = "New event added!";
}
$url = URL.'events';
redirectUrl($url);


}	/* post */


$data['date'] = $_SESSION['today'];
$this->view->render($data,'events/add','editor');

}


public function delete($params){
$eid = $params[0];
$dbg = PDBG;
$q = " DELETE FROM {$dbg}.events WHERE `id` = '$eid' LIMIT 1; ";
$this->model->db->query($q);
$_SESSION['message'] = 'Event Deleted!';
$url = (isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER']:URL.'events';
// pr($url);
redirectUrl($url);

}	/* fxn */




} 	/* AdvisersController */
