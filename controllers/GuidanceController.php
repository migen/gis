<?php
Class GuidanceController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	parent::beforeFilter();		
	
}	/* fxn */


public function index($params=NULL){	
	$dbo=PDBO;
	$home = $_SESSION['home'];		
	$data['ssy']	= $ssy		= $_SESSION['sy'];
	$data['sy']		= $sy		= isset($params[0])? $params[0]:$ssy;
	$data['qtr']	= $_SESSION['qtr'];
	$data['period']	= $_SESSION['settings']['period'];
	
	$dbg	= VCPREFIX.$sy.US.DBG;

	if(!isset($_SESSION['guidance'])){ $this->Guidance->sessionizeGuidance($sy,$dbg); } 
	$data['classrooms']	= $_SESSION['guidance'][$sy]['classrooms'];
	$this->view->render($data,'guidance/index');

}




public function igrades($params){
$dbo=PDBO;
$data['ssy']		=	$ssy   	= $params[0];
$data['sy']			=	$sy   	= isset($params[0])? $params[0]:$ssy;
$data['period']		=	$period = $params[1];
$data['itype_id']	=	$itype_id 	= $params[2];
$data['tcid']		=	$tcid 	= $params[3];
$data['home'] = $home = $_SESSION['home'];

$dbg	= VCPREFIX.$sy.US.DBG;

/* 4 - students */
$data['igrades'] 	  = $this->model->igrades($dbg,$sy,$period,$itype_id,$tcid);
$data['num_igrades']  = count($data['igrades']);

$data['students'] 	   = $this->model->getIstudents($dbg,$tcid);
$data['num_students']  = count($data['students']);


$this->view->render($data,'guidance/igrades');


}	/* fxn */


public function iteachers($params=NULL){
$dbo=PDBO;
$data['ssy']	= $ssy	= $_SESSION['sy'];
$data['sy']		= $sy	= isset($params[0])? $params[0]:$ssy;
$data['qtr']	= $_SESSION['qtr'];
$data['period']	= $_SESSION['settings']['period'];
$data['home'] 	= $home = $_SESSION['home'];

$data['dbg']	= $dbg	= VCPREFIX.$sy.US.DBG;

if(isset($_POST['submit'])){
	// pr($_POST);
	$q = "";
	foreach($_POST['iteachers'] AS $row){
		$q .= " UPDATE {$dbg}.iteachers SET `num_asors` = '".$row['num_asors']."' WHERE `asee_cid` = '".$row['asee_cid']."' LIMIT 1; ";
	}

	$this->model->db->query($q);
	$url = "guidance/iteachers/$sy";
	redirect($url);
}	/* post */



$q = "SELECT c.*,c.`id` AS tcid,it.* 
	FROM {$dbg}.iteachers AS it
		LEFT JOIN {$dbo}.`00_contacts` AS c ON it.`asee_cid` = c.id	
	ORDER BY c.`name`; ;";
$sth = $this->model->db->querysoc($q);
$data['iteachers'] = $sth->fetchAll();

$data['num_iteachers'] = count($data['iteachers']);
if($data['num_iteachers']==0){ $this->flashRedirect("$home","Sync Iteachers List first at Guidance Dashboard."); }
$this->view->render($data,'guidance/iteachers');

}	/* fxn */


public function iteacher($params){
$dbo=PDBO;
$ssy				= $_SESSION['sy'];
$data['sy']			= $sy   	= $params[0];
$data['period']		= $period = $params[1];
$data['itype_id']	= $itype_id 	= $params[2];
$data['tcid']		= $tcid 	= $params[3];
$data['home'] 		= $home 	= $_SESSION['home'];
$dbg	= VCPREFIX.$sy.US.DBG; 

/* 1 - itype */
$data['itype'] = $itype = $this->model->getItypeDetails($itype_id,$dbg); 		/* at GSModel */
 
/* 2 - teacher */
 
$q = " 
	SELECT c.*,c.`id` AS `tcid`,c.`name` AS `teacher`,c.`name` AS `asee`,it.*	
	FROM {$dbo}.`00_contacts` AS `c`
		LEFT JOIN {$dbg}.iteachers AS `it` ON it.`asee_cid` = c.`id`		
	WHERE c.`id` = '$tcid' LIMIT 1
; ";
$sth = $this->model->db->querysoc($q);
$data['iteacher'] = $sth->fetch();


/* 3 - icomponents or items */
$data['icomponents'] 	  =	$icomponents		= $this->model->getIcomponents($itype_id,$dbg);	/* at GSModel */
$data['num_icomponents']  = $num_icomponents	= count($data['icomponents']);


/* 4 - students */

$data['students'] 	   = $this->model->getIstudents($dbg,$tcid);
$data['num_students']  = count($data['students']);


for($i=0;$i<$num_icomponents;$i++){
	$data['iscores'][$i] 	= $this->model->getTeacherIscores($dbg,$icomponents[$i]['icomponent_id'],$tcid,$sy,$period);
	$data['num_icomp'][$i] = count($data['iscores'][$i]);	
}


$this->view->render($data,'mis/iteacher');


}	/* fxn */


public function xcountStudentsByTeacher($params){
	$dbo=PDBO;
	$dbg   = $params[0];
	$dbg   = $params[1];
	$tcid  = $params[2];

	$students = $this->model->getIstudents($dbg,$tcid);
	$count = count($students);
	$row = array('numrows'=>"$count");
	echo json_encode($row);

}	/* fxn */



public function xcountAssessedByStudents($params){
$dbo=PDBO;
$dbg   = $params[0];
$dbg   = $params[1];
$tcid  = $params[2];

$students = $this->model->getIstudents($dbg,$tcid);

$count = count($students);
$row = array('numrows'=>"$count");

 
echo json_encode($row);


}


public function reset($params=NULL){
	$dbo=PDBO;
	$home = $_SESSION['home'];		
	$ssy	= $_SESSION['sy'];
	$sy		= isset($params[1])? $params[1]:DBYR;
	$dbg	= VCPREFIX.$sy.US.DBG;
	
	$this->Guidance->sessionizeGuidance($sy,$dbg);
	redirect($home);
} /* reset */


public function dashboard($params=NULL){
	$dbo=PDBO;
	$data['home']	= $home = $_SESSION['home'];

	$data['ssy']			= $ssy	= $_SESSION['sy'];
	$data['sy']				= $sy	= isset($params[0])? $params[0] : $ssy;
	
	// $dbyr	= ($sy==$ssy)? '' : $sy.US;
	$dbyr 	= $sy.US;	
	$dbg	= VCPREFIX.$dbyr.DBG;
	$dbg	= VCPREFIX.$dbyr.DBG;
	
	$data['qtr']	= $_SESSION['qtr'];
	$data['period']	= $_SESSION['settings']['period'];
if(isset($_SESSION['guidance'][$sy])){
	$data['classrooms']		= $_SESSION['guidance'][$sy]['classrooms'];
	$data['num_classrooms']	= $_SESSION['guidance'][$sy]['num_classrooms'];
	$data['teachers']		= $_SESSION['guidance'][$sy]['teachers'];
	$data['num_teachers']	= $_SESSION['guidance'][$sy]['num_teachers'];
	$data['num_iteachers']	= $_SESSION['guidance'][$sy]['num_iteachers'];
} else {
	$this->Guidance->sessionizeGuidance($sy,$dbg);
}
	
	$this->view->render($data,'guidance/dashboard');
	
}	/* fxn */


public function inquiry(){


	
	
	$data = isset($data)? $data : NULL;
	$this->view->render($data,'guidance/inquiry','rfid');


}	/* fxn */


public function setup(){
	$data['home']	= $_SESSION['home'];
	$data['sy']		= $_SESSION['sy'];
	$this->view->render($data,'guidance/setup');

}	/* fxn */








} /* GuidanceController */
