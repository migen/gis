<?php

Class ShsController extends Controller{	

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
	require_once(SITE."functions/shsFxn.php");	
	$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
	$data['qtr']=$qtr=isset($params[1])?$params[1]:$_SESSION['qtr'];
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$crids=buildArray($posts,'crid');
		$ids = stringify($crids);	
		$sy=$_POST['sy'];
		$url="shs/genaveCombo/".$ids.'?sy='.$sy;
		redirect($url);
		exit;
	}	/* post */
	
	$allowed=array(RMIS,RREG,RACAD,RADMIN);$data['srid']=$srid=$_SESSION['srid'];
	if(!in_array($srid,$allowed)){ $this->flashRedirect(UNAUTH); }
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$data['rows']=sessionizeShsList($db,$dbg);
	$data['count'] = count($data['rows']);
	$this->view->render($data,'shs/indexShs');

}	/* fxn */

public function resetShsList($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/shsFxn.php");	
	$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;	
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$cond = " WHERE cr.`section_id`>2 AND cr.`level_id`>13 ";				
	$_SESSION['shslist']=getShsList($db,$dbg,$cond);	
	// unset($_SESSION['shslist']);
	
}	/* fxn */


public function levels($params=NULL){
$dbo=PDBO;
	require_once(SITE."functions/shsFxn.php");	
	$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
	$data['qtr']=$qtr=isset($params[1])?$params[1]:$_SESSION['qtr'];
	$allowed=array(RMIS,RREG,RACAD,RADMIN);$data['srid']=$srid=$_SESSION['srid'];
	if(!in_array($srid,$allowed)){ $this->flashRedirect(UNAUTH); }
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$data['rows']=sessionizeShsLevels($db,$dbg);
	$data['count'] = count($data['rows']);
	$this->view->render($data,'shs/levelsShs');

}	/* fxn */



public function genaveQ7($params=NULL){
$dbo=PDBO;
$lvl=isset($params[0])? $params[0]:false;
$sy=isset($params[1])? $params[1]:DBYR;
if(!$lvl){ echo "No level selected"; exit; } else {
	$db=&$this->model->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$deciave=$_SESSION['settings']['decigenave'];	
	$q=" UPDATE {$dbg}.05_summaries AS summ
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		SET summ.ave_q7=((round(summ.ave_q5,".$deciave.")+round(summ.ave_q6,".$deciave.")))/2						
		WHERE cr.level_id='$lvl';	";
	pr($q);	
	$url="shs/genaveQ7/$lvl/$sy?exe";
	if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
	} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		
		
}	/* lvl */


}	/* fxn */


public function genaveSummary($params){
$dbo=PDBO;
require_once(SITE."functions/details.php");	
require_once(SITE."functions/shsFxn.php");	
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
// $data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
// $fields="summ.id",$cond=NULL,$order="c.name"
$data['rows']=getGenaveSummary($db,$dbg,$crid);
$data['count']=count($data['rows']);
$data['cr']=getClassroomDetails($db,$crid,$dbg);
$this->view->render($data,'shs/genaveSummaryShs');

}	/* fxn */


public function genaveCombo($params){
require_once(SITE."functions/shsFxn.php");	
$crids=$params;
$data['sy']=$sy=isset($_GET['sy'])? $_GET['sy']:DBYR;
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
$classrooms=array();
foreach($crids AS $crid){
	$classrooms[]=getClassroomName($db,$dbg,$crid);
}
$data['classrooms']=&$classrooms;
$data['rows']=getGenaveCombo($db,$dbg,$crids);
$data['count']=count($data['rows']);
$this->view->render($data,'shs/genaveComboShs');

}	/* fxn */





public function aasumm(){
require_once(SITE.'functions/tablesFxn.php');
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
// $deciave=$_SESSION['settings']['decigenave'];
$deciave=1;

$q="SELECT * FROM {$dbg}.aasumm; ";
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
pr($rows);

$q="UPDATE {$dbg}.aasumm AS summ SET summ.ave_q7=((round(summ.ave_q5,".$deciave.")+round(summ.ave_q6,".$deciave.")))/2 
	WHERE summ.`scid`='1001' LIMIT 1; ";
pr($q);


$url="shs/aasumm?exe";
if(!isset($_GET['exe'])){ echo "<a href='".URL.$url."' >Exe</a>";	
} else { $sth=$db->query($q);echo ($sth)? "Success":"Failure";	}		




	

}	/* fxn */





}	/* BlankController */
