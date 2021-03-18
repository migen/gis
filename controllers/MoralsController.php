<?php

Class MoralsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}



public function index(){
	echo "morals";
	
	$this->view->render($data,'morals/indexMorals');
	
}	/* fxn */

public function syncAwardeesAll(){
$dbo=PDBO;
	require_once(SITE.'functions/moralsFxn.php');
	$db=&$this->model->db;
	syncAwardeesAll($db);
}	/* fxn */


public function crid($params){
$dbo=PDBO;
require_once(SITE.'functions/moralsFxn.php');
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;


$q="SELECT summ.scid,c.name AS student,summ.conduct_q{$qtr} AS grade
	FROM {$dbo}.`00_contacts` AS c 
	INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
	INNER JOIN {$dbg}.05_awardees AS a ON summ.scid=a.scid
	WHERE summ.crid='$crid' AND a.is_conduct_awardee_q{$qtr}=1; ";

pr($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$this->view->render($data,'morals/cridMorals');


}	/* fxn */








}	/* BlankController */
