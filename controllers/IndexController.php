<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

Class IndexController extends Controller{

public function __construct(){
	parent::__construct();
	
}



/* NO parent::beforeFilter->checkAuth to AVOID indirect loop.. index = Landing Page for UNAUTH USER */
public function beforeFilter(){}



public function unauth(){
	$this->view->render(null,'index/unauth');
}



public function wpContacts($wpid){	/* for read */
	$dbo=PDBO;	
	$q = " SELECT contact_id AS cid FROM {$dbo}.wp_contacts WHERE `webpage_id` = '$wpid' ; ";
	$sth = $this->Index->db->querysoc($q);
	$rows = $sth->fetchAll();
	$ar = buildArray($rows,'cid');

	return $ar;

}	/* fxn */



public function blank(){ $this->view->render(NULL,'index/blankIndex'); }

public function indexOK(){
	$url=(loggedin())? $_SESSION['home']:"users/login";
	redirect($url);	
}	/* fxn */

public function index($params=null){
	$dbo=PDBO;	
	if(!is_null($params)){
		$alias=$_GET['page'];
		$data['suid']=$suid=isset($_SESSION['user']['ucid'])? $_SESSION['user']['ucid'] : '0';		
		$data['urid']=$urid=isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : '0';		
		$data['wp']=$wp=$this->Index->read($alias);
		if(!$wp){  redirect('webpages'); 	} 	
		if(!$wp['is_public'] && ($urid!=RMIS)){
			$cids = $this->wpContacts($wp['id']);
			if(!in_array($suid, $cids)){ $this->flashRedirect('webpages'); }		
		} 									
		$this->view->render($data,'webpages/read');
	}			
	if(isset($_SESSION['user'])){ $home = $_SESSION['home']; redirect($home); } 
	$this->view->render(null,'index/indexIndex');		
	exit;		
} 	/* fxn */



public function sessionASC(){ Session::set('order','ASC'); }
public function sessionDESC(){ Session::set('order','DESC'); }




} /* IndexController */

