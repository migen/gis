<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN

 */

Class CustomsController extends Controller{

public function __construct(){
	parent::__construct();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','accounts/js/parent.js');	 
	
}


public function beforeFilter(){}


public function index(){
	
	$data=NULL;
	$cus="customs/".VCFOLDER."/test/indexCustomsTree";
	$def="customs/indexCustoms";	
	$data['vfile']=$vfile=view($cus,$def,VCFOLDER);	
	
	$this->view->render($data,$vfile);
	
	
	
}



// TODO
function getCandidatesForHonors($tcid,$crid,$sy,$qtr,$fields,$cond,$order) {

    $q = "
		SELECT 
			c.id AS 'scid',c.code AS student_code,c.name AS student,
			s.crid AS crid,
			sum.id AS sumid,sum.rank_classroom_q1,sum.rank_classroom_q2,sum.rank_classroom_q3,sum.rank_classroom_q4,
			sum.ave_q5,sum.cocurr_q5,sum.honor_q5,sum.honor_rank_q5
		FROM {$dbg}.05_classrooms AS cr 
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.crid = cr.id 		
			INNER JOIN {$dbo}.`00_contacts` as c on sum.scid = c.id 			
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id 
			INNER JOIN {$dbo}.`00_profiles` as p on p.contact_id = c.id 
		WHERE 
				cr.acid = '$tcid' 
			AND	cr.id 			= '$crid'				
			AND c.is_active 	= '1' 
			$cond
		ORDER BY 
			sum.honor_q5 DESC,c.is_male DESC,c.name ASC; 		
	";
	// pr($q);
	$sth = $this->baseModel->db->querysoc($q);
	return $sth->fetchAll();
					 

}	/* fxn */


public function honors($params){
require_once(SITE."functions/details.php");
$db=&$this->model->db;

$crid 	=	$data['crid'] 	= $params[0];
$sy		=	$data['sy']		= $params[1];
$qtr	=	$data['qtr']	= 4;

if($_SESSION['qtr'] != 4) { Session::set('message','Not yet yearend.'); redirect('teachers'); }


if(isset($_POST['submit'])){
	// pr($_POST);
	$rows = $_POST['sum'];
	$q = "";
	foreach($rows AS $row){
		$q .= " UPDATE {$dbg}.05_summaries SET `honor_rank_q5` = '".$row['hrf']."' WHERE `id` = '".$row['sumid']."' LIMIT 1;   ";
	}
	// pr($q); 
	// exit;	
	$this->baseModel->db->query($q);
	
	$q = " UPDATE {$dbg}.05_classrooms SET `is_finalized_honors` = '1' WHERE `id` = '$crid' LIMIT 1; ";				
	// pr($q);
	// exit;
	$this->baseModel->db->query($q);					
	
	$url = "customs/honors/$crid/$sy/$qtr";
	redirect($url);
	
}	/* post-submit */

 
 
	$cr 		= $data['classroom'] = getClassroomDetails($db,$data['crid']);
	$is_locked	= $data['is_locked'] = $cr['is_finalized_q4'];					

	$fields = "";
	$cond = "";
	for($i=1;$i<=$qtr;$i++){ $cond .= " AND sum.rank_classroom_q$i != '0' "; }	
	$order = " sum.honor_q5 DESC,c.is_male DESC,c.name ASC "; 	
	$candidates	= $data['candidates'] 			= $this->getCandidatesForHonors($cr['acid'],$crid,$sy,$qtr,$fields,$cond,$order);
	$data['num_candidates'] = count($candidates);
  
	$this->view->render($data,'teachers/honors');


}	/* fxn */



public function cocurrs0($params){
	require_once(SITE."functions/details.php");
	$db=&$this->model->db;
	$crid		=	$data['crid'] 	= $params[0];
	$sy			=	$data['sy']		= $params[1];
	$qtr		=	$data['qtr']	= 4;

	if($_SESSION['qtr']!=4){ Session::set('message','Not yet yearend.'); redirect('teachers'); }
	
	if(isset($_POST['tally'])){
		// pr($_POST);
		$fcc = $_SESSION['settings']['factor_cocurrs'];
		
		$rows = $_POST['sum'];
		$q = "";
		foreach($rows AS $row){
			$cc_prod = $row['cocurr_q5'] * $fcc;
			$hf		 = $row['ga_prod'] + $cc_prod;			
			$q .= " UPDATE {$dbg}.05_summaries SET 
				`cocurr_q5`  = '".$row['cocurr_q5']."', 
				`honor_q5` 	= '".$hf."'			
				WHERE `id` = '".$row['sumid']."' LIMIT 1; ";			
		}
		// pr($q); exit;
		$this->baseModel->db->query($q);
		
		$url	= "customs/".HONORS."/$crid/$sy/$qtr";
		redirect($url);
	
	}
	

	$cr 		= $data['classroom'] = getClassroomDetails($db,$data['crid']);
	$is_locked	= $data['is_locked'] = $cr['is_finalized_q4'];					

	$fields = "";
	$cond = "";
	for($i=1;$i<=$qtr;$i++){ $cond .= " AND sum.rank_classroom_q$i != '0' "; }	
	$order = " sum.honor_q5 DESC,c.is_male DESC,c.name ASC "; 	
	$candidates	= $data['candidates'] 			= $this->getCandidatesForHonors($cr['acid'],$crid,$sy,$qtr,$fields,$cond,$order);
	$data['num_candidates'] = count($candidates);
	
	$this->view->render($data,'teachers/cocurrs');

	
}	



public function cocurrs($params){

require_once(SITE."functions/details.php");
$db =& $this->model->db;

$data['level_id']	 = $level_id		= $params[0];
$data['sy'] = $sy		= $_SESSION['sy'];
$data['quarter']	 = $quarter			= 4;

$allowed = array(RMIS,RREG);
$user 	 = $_SESSION['user'];
if(!in_array($user['role_id'],$allowed)){ echo "NOT Allowed."; }

if($_SESSION['qtr']!='4') { echo "kickout,session message Not Q4 error!"; }

$sort 	= (isset($_GET['sort']))? $_GET['sort'] : "sum.`ave_q5`"; 
$order 	= (isset($_GET['order']))? $_GET['order'] : "DESC"; 

$q = "
	SELECT 
		c.`id`,c.`account`,c.`name`,sec.`name` AS `section`,
		sum.*,sum.id AS sumid		
	FROM {$dbo}.`00_contacts` AS `c`
		INNER JOIN {$dbg}.05_students AS `s` on s.`contact_id` = c.`id`
		INNER JOIN {$dbg}.`05_summaries` AS `summ` on summ.`scid` = c.`id`
		INNER JOIN {$dbg}.05_classrooms AS `cr` on summ.`crid` = cr.`id`
		INNER JOIN {$dbo}.`05_sections` AS `sec` on cr.`section_id` = sec.`id`
		INNER JOIN {$dbg}.`05_summaries` AS `sum` ON sum.`scid` = s.`contact_id`
	WHERE 	
			cr.`level_id` 	= '$level_id' 
		AND	c.`is_active` 	= '1' 
	ORDER BY $sort $order

";
// pr($q);
$sth = $this->baseModel->db->querysoc($q);
$data['students'] = $sth->fetchAll();
$data['num_students'] = count($data['students']);
// pr($data);

$data['level'] = getLevelDetails($db,$level_id);

$this->view->render($data,'customs/'.VCFOLDER.'/cocurrs');



}









} /* CustomsController */
