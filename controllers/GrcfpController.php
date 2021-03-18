w<?php

Class GrcfpController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */




public function sifprcard($params){		/* single student front page */
require_once(SITE."functions/details.php");
require_once(SITE."functions/remarks.php");
$data['scid'] = $scid = $params[0];
$db=&$this->model->db;
$dbo=PDBO;
$ssy=$_SESSION['sy'];
$sqtr=$_SESSION['qtr'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$sqtr;
$dbg = VCPREFIX.$sy.US.DBG;

$data['sch'] = $sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
$data['tpl'] = $tpl=isset($_GET['tpl'])? $_GET['tpl']:2;


$q="
	SELECT c.id AS scid,c.code AS studcode,c.name AS student,r.*,summ.crid 
	FROM {$dbg}.05_summaries AS summ 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
		LEFT JOIN {$dbg}.remarks AS r ON summ.scid = r.scid
	WHERE 	summ.scid = '$scid'
	ORDER BY c.is_male DESC,c.name;
";
$sth=$db->querysoc($q);
$data['students'] = $students = $sth->fetchAll();
$data['num_students'] = $num_students = count($students);

$data['crid']=$crid=$students[0]['crid'];
$data['classroom'] = getClassroomDetails($db,$crid);

$ds='_ps';	
$vfile = "customs/{$sch}/fprcard{$ds}";		
$this->view->render($data,$vfile);

}	/* fxn */









}	/* BlankController */
