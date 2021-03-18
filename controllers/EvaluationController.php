<?php

Class EvaluationController extends Controller{	


public function index(){
	echo "evaluation controller";
}	/* fxn */





private function updateEvaluation($rows,$dbg){ 
	$q = "";
	foreach($rows AS $row){
		$q .= " UPDATE {$dbg}.iscores SET `rate` = '".$row['rate']."' ,`score` = '".$row['score']."' WHERE `id` = '".$row['iscid']."' LIMIT 1; ";
	}
	$this->baseModel->db->query($q);
}

public function finalizeEval($params){
$data['home']	= $home		= $_SESSION['home'];
$data['ssy']	= $ssy		= $_SESSION['sy'];
$data['igid']	= $igid		= $params[0];
$data['sy']		= $sy 		= $params[1];
$data['period']	= $period 	= $params[2];
$data['tcid']	= $tcid 	= $params[3];
$data['scid']	= $scid 	= $params[4];

$dbg	= VCPREFIX.$sy.US.DBG;
	
$q = " UPDATE {$dbg}.`igrades` SET `is_finalized` = '1' WHERE `id` = '$igid' LIMIT 1; ";	
$this->baseModel->db->query($q);
$url = "guidance/evaluation/$sy/$period/$tcid/$scid";
redirect($url);
	
}

public function evaluation($params){	/* from igrades */
// $this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
$data['home']	= $home		= $_SESSION['home'];
$data['ssy']	= $ssy		= $_SESSION['sy'];
$data['sy']		= $sy 		= $params[0];
$data['period']	= $period 	= $params[1];
$data['tcid']	= $tcid 	= $params[2];
$data['scid']	= $scid 	= isset($params[3])? $params[3]: 0;
$data['itype_id']	=	$itype_id 	= ITYPESF;

$dbg	= VCPREFIX.$sy.US.DBG;

$data['user']	=	$user = $_SESSION['user'];
if($user['role_id']==RSTUD){ $data['scid']	=	$scid 	= $_SESSION['user']['ucid']; }


if(isset($_POST['save'])){
	$rows = $_POST['iscores'];
	$this->updateEvaluation($rows,$dbg);
	$url = "guidance/evaluation/$sy/$period/$tcid/$scid";
	redirect($url);		
}	/* post */


if(isset($_POST['update'])){
	$rows = $_POST['iscores'];
	$this->updateEvaluation($rows,$dbg);
	
	/* 2 - init igrades */
	$q  = " INSERT INTO {$dbg}.`igrades` (`period`,`itype_id`,`asor_cid`,`asee_cid`) VALUES  ";
	$q .= " ('$period','$itype_id','$scid','$tcid'); "; 
	$this->baseModel->db->query($q);	
	$url = "guidance/evaluation/$sy/$period/$tcid/$scid";
	redirect($url);		
}	/* post */





/* process */

$data['iscores'] 	 = $this->baseModel->getStudentIscores($dbg,$scid,$tcid,$sy,$period);					/* at GSModel */

// pr($data); exit;

$data['num_iscores'] = $num_iscores		= count($data['iscores']);
$data['student'] = $this->baseModel->fetchRow("".PDBO.".`00_contacts`",$scid);
$data['teacher'] = $this->baseModel->fetchRow("".PDBO.".`00_contacts`",$tcid);

$data['itype'] 			  = $this->baseModel->getItypeDetails($itype_id,$dbg);							/* at GSModel */
$data['icomponents'] 	  =	$icomponents		= $this->baseModel->getIcomponents($itype_id,$dbg);		/* at GSModel */
$data['num_icomponents']  = $num_icomponents	= count($data['icomponents']);

$q 	 = " SELECT ig.*, ig.id AS igid FROM {$dbg}.`igrades` AS ig
		WHERE `period` = '$period' AND `asee_cid` = '$tcid' AND `asor_cid` = '$scid' LIMIT 1; ";
$sth = $this->baseModel->db->querysoc($q);
$data['evaluation']		  = $sth->fetch();

$this->view->render($data,'students/evaluation');


}	/* fxn */




public function myTeachers($params=NULL){
	$data['ssy']	= $ssy	= $_SESSION['sy'];
	$data['user']	= $user	= $_SESSION['user'];

	$scid 			= isset($params[0])? $params[0] : $user['ucid'];
	if($user['role_id']==RSTUD) $scid = $user['ucid'];
	$data['scid']	=	$scid;

	$data['sy']		= $sy	= isset($params[1])? $params[1] : $ssy;
	$data['qtr']	= $_SESSION['qtr'];
	$data['period']	= $_SESSION['settings']['period'];

	$dbg	= VCPREFIX.$sy.US.DBG;

	$q = "SELECT
			DISTINCT(tc.`id`) AS `tcid`,tc.`name` AS `teacher`
		FROM {$dbo}.`00_contacts` AS tc 
			INNER JOIN {$dbg}.05_courses AS crs ON crs.tcid = tc.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.crid = cr.id
		WHERE tc.is_active 		= '1' AND sum.scid 	= '$scid'; ";
	$sth = $this->baseModel->db->querysoc($q);
	$data['teachers'] = $sth->fetchAll();
	$data['num_teachers'] = count($data['teachers']);
	$this->view->render($data,'students/myteachers');
	

}	/* fxn */















}	/* EvaluationController */
