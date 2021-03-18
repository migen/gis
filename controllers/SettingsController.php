<?php

Class SettingsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;	
	// pr($_SESSION['settings']);
	$q="SELECT * FROM {$dbo}.`00_settings` ORDER BY label; ";	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$this->view->render($data,"settings/indexSettings");

}	/* fxn */


public function edit($params=NULL){ 
	if(empty($params)){ pr("No id."); exit; }
	$id=$params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbo}.`00_settings`",$post,"id=$id");		
		flashRedirect("settings/view/$id","Updated.");
	}
	
	$q="SELECT * FROM {$dbo}.`00_settings` WHERE id=$id LIMIT 1; ";	
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$this->view->render($data,"settings/editSetting");

}	/* fxn */


public function view($params=NULL){ 
	if(empty($params)){ pr("No id."); exit; }
	$data['id']=$id=$params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	
	$q="SELECT * FROM {$dbo}.`00_settings` WHERE id=$id LIMIT 1; ";	
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	$this->view->render($data,"settings/viewSetting");

}	/* fxn */	


public function delete($params=NULL){ 
	if(empty($params)){ pr("No id."); exit; }
	$data['id']=$id=$params[0];
	$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	
	$q="DELETE FROM {$dbo}.`00_settings` WHERE id=$id LIMIT 1; ";	
	$db->query($q);	
	$url="settings/indexSetting";
	flashRedirect($url,"Deleted #{$id}.");
	// $this->view->render($data,"settings/indexSetting");

}	/* fxn */	

public function add($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;	
	$last_id=lastId($db,"{$dbo}.`00_settings`");
	if(isset($_POST['submit'])){
		$post=$_POST['post']; $id=$post['id'];
		$db->add("{$dbo}.`00_settings`",$post);
		flashRedirect("settings/view/$id","Added.");		
	}	/* post */
	$data['id']=$last_id+1;
	$this->view->render($data,"settings/addSetting");

	
}



public function all($params=NULL){
	$dbo=PDBO;$db=&$this->baseModel->db;	
	require_once(SITE."functions/settings.php");
	include_once(SITE.'views/elements/params_sq.php');
	$dbg=PDBG;	
	if(isset($_POST['submit'])){
		$row['name'] = $_POST['name'];
		$dbtable = "{$dbo}.00_.settings";
		$db->add($dbtable,$row);
		Session::set('message','Setting Added.');
		redirect('settings/allSettings');
	}	/* post */	
	$data['settings'] = getSettings($db,$dbg);
	$vfile='settings/allSettings';vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */





}	/* BlankController */
