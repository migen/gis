<?php

/**
 * @copyright MIDASGEN
 */

Class WebpagesController extends Controller{
	
public function __construct(){
	parent::__construct();
	/* 	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	 */
}
public function beforeFilter(){}

public function indexOrig($params=array(1)){	
	$page = isset($_GET['page'])? $_GET['page'] : $params[0];
	$data['num_wp'] 	= count($data['wp']);	
	$this->view->render($data,'webpages/index');
}	/* fxn */


public function add(){		
$dbo=PDBO;
		$row = $_POST['wp'];		
		$this->Webpage->add($row);
		redirect('webpages');
	} 
	$this->view->render(null, 'webpages/add','editor');
}	/* fxn */


public function read($alias){			
public function edit($params){				
$dbo=PDBO;
	$data['suid'] 	= $suid = isset($_SESSION['user']['ucid'])? $_SESSION['user']['ucid'] : '0';		
	$data['urid'] 	= $urid = isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : '0';		
	if(isset($_POST['submit'])){
		$row 	= $_POST['wp'];		
		$ruid 	= isset($row['contact_id'])? $row['contact_id']:null;
		if(($ruid == $suid) || ($urid==RMIS)){
			$this->Webpage->updateWebpage($row, $row['id']);				
		} 
		redirect($alias);
/* --------------- process ---------------------	 */
	$data['wp']		  =	$wp 	= $this->Webpage->read($alias);		
	$ruid = $wp['contact_id'];
	if(($ruid != $suid) && ($urid!=RMIS)){	$this->flashRedirect('webpages'); }		
	$this->view->render($data,'webpages/edit','editor');		
}	/* fxn */


public function delete($params){
	$id 			= $params[0];
	$data['suid'] 	= $suid = isset($_SESSION['user']['ucid'])? $_SESSION['user']['ucid'] : '0';		
	$data['urid'] 	= $urid = isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : '0';		
	$data['wp']		=	$wp 	= $this->Webpage->readById($id);	/* coz alias not unique in database */
	$ruid 			= $wp['contact_id'];
	if(($ruid == $suid) || ($urid==RMIS)){	
		$q = "DELETE FROM {$dbo}.`00_webpages` WHERE `id` = '$id' LIMIT 1;  ";
		$this->Webpage->db->query($q);

}	/* fxn */


} 	/* WebpagesCtlr */
