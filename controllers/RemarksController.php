<?php

Class RemarksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	// $data['home']	= $_SESSION['home'];
	// $this->view->render($data,'remarks/index');
	echo "remarks index";

}	/* fxn */



public function classroom($params=NULL){
$dbo=PDBO;
$data['crid']=$crid=isset($params[0])? $params[0]:false;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
require_once(SITE."functions/details.php");
require_once(SITE."functions/classrooms.php");

$home=$_SESSION['home'];
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;

$srid = $_SESSION['srid'];
$admin = ($srid==RTEAC)? false:true; 
$teac = !$admin;

if($teac){	
	$allowed = in_array($crid,$_SESSION['teacher']['advisory_ids'])? true:false;
	if(!$allowed){ flashRedirect($home,'Only admin or adviser allowed.'); }
}	/* teac */

$classroom = getClassroomDetails($db,$crid);
$data['in_rl'] = $in_rl = in_remarksLevel($classroom);
if(!$in_rl){ flashRedirect($home,'Level not in settings remarks levels.'); }


if(isset($_POST['submit'])){
	$posts = $_POST['posts'];	
	foreach($posts AS $post){
		$scid=$post['scid'];unset($post['scid']);
		$db->update("{$dbg}.50_remarks",$post,"scid='$scid'");
	}
	$url = "remarks/classroom/$crid";
	flashRedirect($url,'Remarks updated.');		
	exit;

}	/* post */

if($crid){
$order=$_SESSION['settings']['classlist_order'];
$limit=isset($_GET['limit'])? $_GET['limit']:NULL;
$condlimit=isset($limit)? " LIMIT $limit ":NULL;
$q=" SELECT summ.scid AS sumscid,r.scid AS rscid,r.*,c.name AS student
	FROM {$dbg}.05_summaries AS summ
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id = summ.scid
		LEFT JOIN {$dbg}.50_remarks AS r ON r.scid = summ.scid
	WHERE summ.crid='$crid' AND c.is_active='1' ORDER BY $order $condlimit; ";
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=count($rows);

  

}	/* crid */

$data = isset($data)? $data:null;
$one="remarks";$two="remarks/remarksClassroom";
$vfile=cview($one,$two,$sch=VCFOLDER);	vfile($vfile);

$this->view->render($data,$vfile);

}	/* fxn */






























}	/* RemarksController */
