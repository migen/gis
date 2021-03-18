<?php

Class TransitionsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
	$acl = array(array(5,0));
	$this->permit($acl);					
}




public function index(){ 
	$data['home']	= $_SESSION['home'];
	
	$this->view->render($data,'transitions/index');

}	/* fxn */

public function notes(){

	$data['home']	= $_SESSION['home'];
	
	
	
	$this->view->render($data,'transitions/notesTransitions');



}	/* fxn */



public function promcrid($params=NULL){
$sy=isset($params[0])? $params[0]:DBYR;
$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;

/* 
update 2016_dbmaster_abc.03_tuitions AS a
INNER JOIN (
	select * FROM 2016_dbmaster_abc.levels
) AS b ON b.id = a.level_id
SET a.label = b.name
 */


$q="";
$q.="Update tsummaries crid <br />";
$q.="
	UPDATE {$dbg}.03_tsummaries AS a
	INNER JOIN {$dbg}.05_summaries AS b ON b.scid=a.scid
	SET a.crid=b.promcrid;	
";

$q.="<hr /> Update summaries crid <br />";

$q.=" UPDATE {$dbg}.05_summaries AS a SET a.crid=a.promcrid;";

$q.="<hr /> Update contacts crid <br />";


$q.="
	UPDATE {$dbo}.`00_contacts` AS a
	INNER JOIN {$dbg}.05_summaries AS b ON b.scid=a.id
	SET a.prevcrid=a.crid,a.crid=b.promcrid;	
";


$data['q']=$q;
pr($q);

// $this->view->render($data,'mis/query');

}	/* fxn */







}	/* TransitionController */
