<?php

Class SummaryController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');		
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'tests/index');

}	/* fxn */



public function edit($params=NULL){
$dbo=PDBO;

// require_once(SITE."functions/summary.php");
$db =& $this->model->db;
$data['scid']=$scid=(isset($params[0]))? $params[0]:false;
$ssy=$_SESSION['sy'];
$data['sy']=$sy=isset($params[1])? $params[1]:$ssy;
$dbo=PDBO;
$dbg=VCPREFIX.$sy.US.DBG;
$url="summary/edit/$scid";

if($scid){
	$q="SELECT summ.*,sx.* FROM {$dbg}.05_summaries AS summ LEFT JOIN {$dbg}.05_summext AS sx ON summ.scid=sx.scid
		WHERE summ.scid='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['summary']=$summary=$sth->fetch();

	$q="SELECT c.id,c.code,c.name,cr.name AS classroom FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
		WHERE c.id='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['contact']=$contact=$sth->fetch();
	
			
}	/* scid */

if(isset($_POST['submit'])){
	$row=$_POST['summ'];
	$sxrow=$_POST['sx'];
	$db->update("{$dbg}.`05_summaries`",$row,"`scid`='$scid' ");
	$db->update("{$dbg}.`05_summext`",$sxrow,"`scid`='$scid' ");
	$url="summary/edit/$scid";
	flashRedirect($url,'Student summary updated.');

}	/* post */

$data['classrooms']=fetchRows($db,"{$dbg}.05_classrooms","id,name","level_id","WHERE section_id='1'");
$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,name","id");
$data=isset($data)? $data:null;

$this->view->render($data,'summary/editSummary');

}	/* fxn */
























}	/* SummaryController */
