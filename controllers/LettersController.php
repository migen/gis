<?php

Class LettersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
		
	$data['qtr']=$_SESSION['qtr'];
	$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,name","id");
	// $data=isset($data)? $data:NULL;
	$this->view->render($data,'letters/indexLetters');
	

}	/* fxn */



public function traitsByLevel($params=NULL){
require_once(SITE."functions/equivs.php");
require_once(SITE."functions/reports.php");
require_once(SITE."functions/lettersFxn.php");
$db=&$this->model->db;
$dbg=PDBG;
$dbo=PDBO;
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$q="SELECT department_id FROM {$dbo}.`05_levels` WHERE id='$lvl' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$dept_id=$row['department_id'];
$data['dept_id']=&$dept_id;
$ctype_id=2;
$data['ctype_id']=&$ctype_id;
$ratings = getRatings($db,$ctype_id,$dept_id);		
$data['ratings']=&$ratings;

$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
$fields="g.id AS gid,g.q{$qtr} AS grade";
$rows=getTraitsByLevel($db,$qtr,$dbg,$lvl,$fields);


if(isset($_POST['submit'])){
	$posts=isset($_POST['posts'])? $_POST['posts']:array();
	$q="";
	foreach($posts AS $post){
		$dg=$post['dg'];
		$gid=$post['gid'];
		$q.="UPDATE {$dbg}.50_grades SET `dg{$qtr}`='$dg' WHERE `id`='$gid' LIMIT 1; ";
	}
	$db->query($q);
	$url="letters/traitsByLevel/$lvl?qtr=$qtr";
	flashRedirect($url,"Letter grades updated.");		
	exit;
}	/* post */


$fields="g.id AS gid,c.id AS scid,c.name AS student,g.q{$qtr} AS grade,g.dg{$qtr} AS letter,cr.name AS classroom,";
$fields.="cri.code AS criteria_code";
$rows=getTraitsByLevel($db,$qtr,$dbg,$lvl,$fields);
$data['rows']=&$rows;
$data['count']=count($rows);

$this->view->render($data,'letters/traitsLetters');


}	/* fxn */
 






}	/* BlankController */
