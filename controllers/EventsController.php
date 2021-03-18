<?php

/* crscfg, */
Class EventsController extends Controller{ 

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();		
	
}

public function index($params=NULL){

// pr($_SESSION);
$moid	= isset($params[0])? $params[0]:$_SESSION['moid'];	
$year	= isset($params[1])? $params[1]:$_SESSION['year'];	
$today = $_SESSION['today'];
$data['srid']	= $srid = $_SESSION['srid'];
$data['admin'] 	= ($srid==RMIS || $srid==RREG || $srid==RACAD)? true:false;

$future 	= " AND e.`date` > '$today' ";
$cond_month = " AND MONTH(e.`date`) 	= '$moid'";


$cond 	= isset($_GET['all'])? NULL:$cond_month;	
$future = isset($_GET['future'])? $future:NULL;	

$db = $this->model->db;
$dbg = PDBG;
$q = "
	SELECT 
		e.id,e.date,e.event,c.name AS contact	
	FROM {$dbg}.events AS e
		LEFT JOIN {$dbo}.`00_contacts` AS c ON e.ucid = c.id
	WHERE 1=1				
		$cond
		$future
	ORDER BY date
;";
	
// pr($q);	

$sth = $db->querysoc($q);
$data['events'] = $sth->fetchAll();
$data['count']	= count($data['events']);
	
$data['news'] = $this->news();

$view = isset($_GET['window'])? 'window':'table';	
// $this->view->render($data,'events/index');	
$this->view->render($data,"events/$view");	
	

}	/* fxn */


private function news($date=NULL){
	$dbg 	= PDBG;
	$today 	= isset($date)? $date:$_SESSION['today']; 
	$q = " SELECT * FROM {$dbg}.events WHERE `date` = '$today' LIMIT 1; ";	
	$sth = $this->model->db->querysoc($q);
	return $sth->fetch();
}	/* fxn */



public function view($params){
$data['eid'] = $eid	= $params[0];
$dbg = PDBG;

$q = "SELECT * FROM {$dbg}.events WHERE `id` = '$eid' LIMIT 1; ";
$sth = $this->model->db->querysoc($q);
$data['event'] = $sth->fetch();

$this->view->render($data,'events/view');

}	/* fxn */


public function edit($params){
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
