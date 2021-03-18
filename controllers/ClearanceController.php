<?php

Class ClearanceController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index(){
	echo "Clearance";

	$this->view->shovel('homelinks');
	echo " | ";
	$crid=1;
	echo "<a href='".URL."classlists/classroom/{$crid}' >Classlist One</a>";
	
}	/* fxn */



public function one($params=NULL){
$data['scid']=$scid=isset($params[0])? $params[0]:false;
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	
	$db->update("{$dbo}.`00_contacts`",$post,"id='$scid'");
	flashRedirect("clearance/one/$scid","Status updated.");
}	/* post */

$q="SELECT c.id,c.code,c.name,c.lrn,c.is_active,cr.name AS classroom,summ.crid,summ.scid AS summscid
FROM {$dbo}.`00_contacts` AS c LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id WHERE c.id='$scid' LIMIT 1;";debug($q);
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();

$this->view->render($data,"clearance/oneClearance");

}	/* fxn */



}	/* BlankController */
