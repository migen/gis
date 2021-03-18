<?php
Class UniregisterController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();	

}




public function index(){
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
	$data=NULL;	
	$this->view->render($data,"students/indexStudent");
	
}	/* fxn */



public function student($params=NULL){
	reqFxn('uniregisterFxn');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;	
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
	$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
	$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
	$data['current']=($sy==DBYR)? true:false;
	$db=&$this->baseModel->db;

	include_once(SITE.'views/elements/dbsch.php');
		
	if($scid){
		if(isset($_POST['update'])){
			$post=$_POST['post'];
			$sth=$db->update("{$dbg}.01_summaries",$post,"scid='$scid'");
			$msg=($sth)? "Update succeeded.":"Update failed.";
			flashRedirect("uniregister/student/$scid",$msg);
			exit;
			
		}	/* update */
		
		/* 2 */
		$data['row']=$row=getStudentForCollegeRegistration($db,$scid,$dbg);	
		$data['role_id']=$role_id=$data['row']['role_id'];
		if(($role_id==8) && (empty($row['summscid']))){ initUnistudent($db,$scid); }

		if(!isset($_SESSION['uniclassrooms'])){ require_once(SITE.'functions/uniclassroomsFxn.php');sessionizeUniclassrooms($db,$dbg); }
		$data['uniclassrooms']=$_SESSION['uniclassrooms'];
		
	}	/* scid */
	
	$vfile="uniregister/studentUniregister";	
	$this->view->render($data,$vfile);
}	/* fxn */


public function summscid($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ pr("Student parameter NOT set."); exit; }
	$scid=$params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$q="INSERT INTO {$dbg}.01_summaries(`scid`) VALUES ('$scid'); ";
	$sth=$db->query($q);
	$msg=($sth)? "Init student summary done.":"Init student summary failed.";
	pr($msg);
	
}	/* fxn */


public function add($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$data=NULL;
	
	if(isset($_POST['submit'])){
		$profile=$_POST['profile'];
		$contact=$_POST['contact'];
		$fullname=$profile['last_name'].', '.$profile['first_name'].' '.$profile['middle_name'];
		$contact['name']=$fullname;
		$contact['pass']=MD5('pass');
		$last_ucid=maxId($db,"{$dbo}.`00_contacts`");	
		$scid=$last_ucid+1;		
		$contact['id']=$contact['parent_id']=$scid;
		$contact['role_id']=RCOLL;$contact['privilege_id']=1;
		$contact['created']=$_SESSION['today'];
		$contact['sy']=$_SESSION['year'];
		$summary['scid']=$scid;
		$ctp['contact_id']=$scid;
		$profile['contact_id']=$scid;
		
		/* tables - contacts,profiles,summaries,!attd(crs),  */
		$db->add("{$dbo}.`00_contacts`",$contact);
		$db->add("{$dbo}.`00_ctp`",$ctp);
		$db->add("{$dbo}.`00_profiles`",$profile);
		$db->add("{$dbg}.01_summaries",$summary);
		$msg="$fullname - college student registered.";	
		flashRedirect("uniregister/student/$scid",$msg);
		
		exit;
	}	/* post */
	
	$this->view->render($data,"uniregister/addUniregister");
	
}	/* fxn */



} /* StudentsController */
