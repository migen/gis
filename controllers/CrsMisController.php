<?php

Class CrsMisController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
	$acl = array(array(5,0),array(4,0),array(9,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}

public function index(){
	$db=&$this->baseModel->db;
	$dbg=PDBG;$dbg=&$dbg;
	$data['rows'] = fetchRows($db,"{$dbo}.`05_levels`",'id,code,name','id');
	$data['count'] = count($data['rows']);
	$this->view->render($data,'courses/index');
}	/* fxn */


public function codename(){

if(isset($_POST['submit'])){
	$field=$_POST['field'];
	$from=$_POST['from'];
	$to=$_POST['to'];
	$db=&$this->baseModel->db;
	$dbg=PDBG;
	
	$q="UPDATE {$dbo}.`05_subjects` SET `$field`='$to' WHERE `$field`='$from'; ";
	$q.="UPDATE {$dbg}.05_courses SET `$field`='$to' WHERE `$field`='$from'; ";
	$data['q']=$q;
	$sth=$db->querysoc($q);
	$msg=($sth)? "Successful":"Failed";
	flashRedirect('crsMis/codename',$msg);
	
}	/* post */

$data=isset($data)? $data:NULL;
$this->view->render($data,'mis/crsMis');

}	/* fxn */


public function config(){

$db=&$this->baseModel->db;$dbg=PDBG;

if(isset($_POST['submit'])){
	$field=$_POST['field'];
	$value=$_POST['value'];
	$lvlstr=$_POST['levels'];
	$lvlarr= explode(',',$lvlstr);		
	$sub=$_POST['sub'];
	$q="";
	foreach($lvlarr AS $lvl){
		$q.="UPDATE {$dbg}.05_courses AS crs
			INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=crs.crid
			SET crs.`$field`='$value' WHERE cr.level_id='$lvl' AND crs.subject_id='$sub';  ";		
	}
		
	// pr($q);exit;
	$sth=$db->query($q);
	$msg = ($sth)? "Success":"Failure";
	flashRedirect("crsMis/config",$msg);	
	exit;
	

}	/* fxn */

$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,name","id");
$data['subjects']=fetchRows($db,"{$dbo}.`05_subjects`","id,name","name");
$this->view->render($data,'setup/loadingConfig');

}	/* fxn */



}	/* CoursesController */
