<?php

Class ScidController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "Student";

}	/* fxn */


public function promoter($params=NULL){
require_once(SITE.'functions/contactsFxn.php');
$data['id']=$id=(isset($params[0]))? $params[0]:false;
$sy=isset($params[1])? $params[1]:DBYR;
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$data['ucid']=$_SESSION['ucid'];
$data['srid']=$_SESSION['srid'];
if($id){
	$q="SELECT c.id AS ucid,c.name,c.is_male,summ.is_promoted FROM {$dbo}.`00_contacts` AS c INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
		WHERE c.`id`='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];	
	$db->update("{$dbg}.`05_summaries`",$post,"`scid`='$id'"); 		
	flashRedirect("scid/promoter/$id/$sy","Saved.");
	exit;
		
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'scid/promoterScid');	/* from codename/one */
	
	
}	/* fxn */




}	/* BlankController */
