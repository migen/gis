<?php

Class PupilsController extends Controller{	

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
$dbo=PDBO;
	$vfile="pupils/indexPupils";vfile($vfile);
	$data="ABC";$this->view->render($data,$vfile);

}	/* fxn */





public function add(){
$dbo=PDBO;
	require_once(SITE.'functions/dbtools.php');
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data=NULL;

/* 	$except="'id','father','father_occupation','mother','mother_occupation','guardian','guardian_relationship'";
	$dr2=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except);
	$data['columns_profiles']=&$dr2['field_array'];
	
 */
 
	/* 2 */
	initSession($db,'brid');	/* branch_id */

	
	/* 4 post */
	if(isset($_POST['submit'])){
		// pr($_POST);

		$last_contact_id=lastId($db,"{$dbo}.`00_contacts`");
		$id=$last_contact_id+1;
		$in_record=in_record($db,"{$dbo}.`00_profiles`","contact_id",$id);
		
		// $id=lastId($db,"{$dbo}.`00_contacts`");
		$contact=$_POST['contact'];
		$contact['id']=$id;
		$contact['parent_id']=$id;
		$contact['branch_id']=$_SESSION['brid'];
		$contact['role_id']=RSTUD;
		$contact['privilege_id']=1;
		$contact['title_id']=1;

		$profile=$_POST['profile'];
		$contact['name']=$profile['last_name'].', '.$profile['first_name'].' '.$profile['middle_name'];
		$profile['contact_id']=$id;
		unset($profile['last_name']);
		unset($profile['first_name']);
		unset($profile['middle_name']);
		// pr($contact); pr($profile);

		$db->add("{$dbo}.00_contacts",$contact);
		if($in_record){
			$db->update("{$dbo}.00_profiles",$profile,"contact_id=$id");
		} else {
			$db->add("{$dbo}.00_profiles",$profile);
		}
		$msg="Registered NEW student.";
		$url="pupils/add";
		flashRedirect($url,$msg);
		exit;
		
	}	/* post */

	
	// $row['last_name']="Go";
	$data['row']=isset($row)? $row:false;
	/* 6 */
	include_once('includes/pupils_addEditView.php');
	$this->view->render($data,$vfile);
	
}	/* fxn */



public function edit($params){
$dbo=PDBO;
	require_once(SITE.'functions/dbtools.php');
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['id']=$id=$params[0];
	
	
	
	$q="SELECT c.*,p.*
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`00_profiles`AS p ON p.contact_id=c.id 
		WHERE c.id=$id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();
	
	// $data=NULL;

/* 	$except="'id','father','father_occupation','mother','mother_occupation','guardian','guardian_relationship'";
	$dr2=getDbtableColumnsByArray($db,$dbo,"00_profiles",$except);
	$data['columns_profiles']=&$dr2['field_array'];
	
 */
 
	/* 2 */
	initSession($db,'brid');	/* branch_id */

	
	/* 4 post */
	if(isset($_POST['submit'])){
		// pr($_POST);

		$last_contact_id=lastId($db,"{$dbo}.`00_contacts`");
		$id=$last_contact_id+1;
		$in_record=in_record($db,"{$dbo}.`00_profiles`","contact_id",$id);
		
		// $id=lastId($db,"{$dbo}.`00_contacts`");
		$contact=$_POST['contact'];
		$contact['id']=$id;
		$contact['parent_id']=$id;
		$contact['branch_id']=$_SESSION['brid'];
		$contact['role_id']=RSTUD;
		$contact['privilege_id']=1;
		$contact['title_id']=1;

		$profile=$_POST['profile'];
		$contact['name']=$profile['last_name'].', '.$profile['first_name'].' '.$profile['middle_name'];
		$profile['contact_id']=$id;
		unset($profile['last_name']);
		unset($profile['first_name']);
		unset($profile['middle_name']);
		// pr($contact); pr($profile);

		$db->add("{$dbo}.00_contacts",$contact);
		if($in_record){
			$db->update("{$dbo}.00_profiles",$profile,"contact_id=$id");
		} else {
			$db->add("{$dbo}.00_profiles",$profile);
		}
		$msg="Registered NEW student.";
		$url="pupils/add";
		flashRedirect($url,$msg);
		exit;
		
	}	/* post */

	
	// $row['last_name']="Go";
	$data['row']=isset($row)? $row:false;
	/* 6 */
	include_once('includes/pupils_addEditView.php');
	$this->view->render($data,$vfile);
	
}	/* fxn */




public function register($params=NULL){
	
	
	
}	/* fxn */


public function enroll($params=NULL){
	
	
}	/* fxn */


public function rfid($params=NULL){
	
	$data=NULL;
	$this->view->render($data,"pupils/rfidPupils");
	
}	/* fxn */



}	/* BlankController */
