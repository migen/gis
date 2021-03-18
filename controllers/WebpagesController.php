<?php

/**
 * @copyright MIDASGEN
 */

Class WebpagesController extends Controller{
	
public function __construct(){
	parent::__construct();
	/* 	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	 */	
}
public function beforeFilter(){}public function index(){	echo "<h3>Webpages</h3>";	}

public function indexOrig($params=array(1)){	$dbo=PDBO;	require_once(SITE."library/Pagination.php");	require_once(SITE."functions/contactsFxn.php");	$db =& $this->model->db;
	$page = isset($_GET['page'])? $_GET['page'] : $params[0];	$data			 	= $this->Webpage->index($page);
	$data['num_wp'] 	= count($data['wp']);		$data['user']		= sesuser();
	$this->view->render($data,'webpages/index');
}	/* fxn */


public function add(){		
$dbo=PDBO;	if(isset($_POST['submit'])){
		$row = $_POST['wp'];		
		$this->Webpage->add($row);
		redirect('webpages');
	} 
	$this->view->render(null, 'webpages/add','editor');
}	/* fxn */


public function read($alias){			$dbo=PDBO;	// pr($alias);	$data['suid'] 	= $suid = isset($_SESSION['user']['ucid'])? $_SESSION['user']['ucid'] : '0';			$data['urid'] 	= $urid = isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : '0';					$data['wp']		=	$wp 	= $this->Webpage->read($alias);	$data['is_hidden'] = $is_hidden = ($wp['is_hidden']==1)? true:false;	$_SESSION['show'] = true;	if($is_hidden){ 		$this->view->js = array('js/jquery.js','js/vegas.js');			if(isset($_POST['submit'])){			if($_POST['hdpass']!=$wp['hdpass']){				$wp=array('Not allowed.');											$_SESSION['show'] = false;			} 		} else {				$wp=array('Not allowed.');													$_SESSION['show'] = false;				}				} else { /* is_hidden */		if(!$wp){  redirect('webpages'); 	} 						$allowed = (($urid!=RMIS) && ($wp['contact_id']!=$suid))? false:true;			if(!$wp['is_public'] && !$allowed){ $this->flashRedirect('webpages'); } 											} /* is_hidden */	$data['alias'] = $alias;		$this->view->render($data,'webpages/read');}	/* fxn */
public function edit($params){				
$dbo=PDBO;	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	$alias = $params[0];
	$data['suid'] 	= $suid = isset($_SESSION['user']['ucid'])? $_SESSION['user']['ucid'] : '0';		
	$data['urid'] 	= $urid = isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : '0';		
	if(isset($_POST['submit'])){
		$row 	= $_POST['wp'];		
		$ruid 	= isset($row['contact_id'])? $row['contact_id']:null;
		if(($ruid == $suid) || ($urid==RMIS)){
			$this->Webpage->updateWebpage($row, $row['id']);				
		} 
		redirect($alias);	} 	
/* --------------- process ---------------------	 */
	$data['wp']		  =	$wp 	= $this->Webpage->read($alias);		
	$ruid = $wp['contact_id'];
	if(($ruid != $suid) && ($urid!=RMIS)){	$this->flashRedirect('webpages'); }		
	$this->view->render($data,'webpages/edit','editor');		
}	/* fxn */


public function delete($params){$dbo=PDBO;
	$id 			= $params[0];
	$data['suid'] 	= $suid = isset($_SESSION['user']['ucid'])? $_SESSION['user']['ucid'] : '0';		
	$data['urid'] 	= $urid = isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : '0';		
	$data['wp']		=	$wp 	= $this->Webpage->readById($id);	/* coz alias not unique in database */
	$ruid 			= $wp['contact_id'];
	if(($ruid == $suid) || ($urid==RMIS)){	
		$q = "DELETE FROM {$dbo}.`00_webpages` WHERE `id` = '$id' LIMIT 1;  ";
		$this->Webpage->db->query($q);	}	$this->flashRedirect('webpages','Deleted!');	

}	/* fxn */


} 	/* WebpagesCtlr */

