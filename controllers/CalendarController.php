<?php

Class CalendarController extends Controller{	

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
require_once(SITE."functions/times.php");
$db =& $this->model->db;

$data['ssy']	= $ssy		= $_SESSION['sy'];
$data['sy']		= $sy		= isset($params[0])? $params[0]:$ssy;
$data['moid']	= $moid		= isset($params[1])? $params[1]:$ssy;
$data['dbm']	= $dbg	= ($sy==$ssy)? PDBG:VCPREFIX.$sy.US.DBG;

$data['month']	= $month	= getMonth($db,$moid,$code=false,$dbg);

if(isset($_POST['submit'])){
	$pdays = $_POST['days'];
	$q = "";
	foreach($pdays AS $row){
		$q .= " 
			UPDATE {$dbg}.05_calendar SET 
				`is_included` 			= '".$row['is_included']."',
				`is_included_employees` = '".$row['is_included_employees']."'
			WHERE `id` = '".$row['id']."' LIMIT 1;			
		";
	}
	$this->model->db->query($q);
	$url = "mis/calendar/$sy/$moid";
	flashRedirect($url,'Calendar days updated.');
		
}	/* post */


$q 		= " SELECT * FROM {$dbg}.05_calendar WHERE month(`date`) = '$moid' ORDER BY `date`; ";
$sth	= $this->model->db->querysoc($q);
$data['days'] 		= $sth->fetchAll();
$data['num_days']	= count($data['days']);

$data['months']	= $this->model->fetchRows("".PDBO.".months","*","id");

$this->view->render($data,'calendar/index');

}	/* fxn */






}	/* CalendarController */
