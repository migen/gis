<?php

Class LibrariansController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){
	$dbo=PDBO;	
	$data=NULL;	
	// if(!isset($_SESSION['months'])){ $db=&$this->model->db;$_SESSION['months'] = fetchRows($db,"{$dbo}.`00_months`","*","`index`"); }
	$data['months']=fetchRows($db,"{$dbo}.`00_months`","*","`index`"); 
	pr($data);

	
	$this->view->render($data,'librarians/index');

}	/* fxn */



public function patrons(){
$dbo=PDBO;	
require_once(SITE."functions/librarians.php");

$db=&$this->model->db;

$rows=array();
if(isset($_GET['submit'])){
	// pr($_POST);
	$params=$_GET;
	$xr = getPatronsReport($db,$params);
	$rows=$xr['rows'];
	$q=$xr['q'];


}	/* post */

$data=getSessionLevelsAndClassrooms($db);
$data['rows']=$rows;
$data['q']=isset($q)?$q:NULL;


$data['count']=count($rows);
$this->view->render($data,'librarians/patrons');

}


public function recount($params=null){
	$dbo=PDBO;	
	$date=isset($params[0])? $params[0]:$_SESSION['today'];
	require_once(SITE."functions/patrons.php");
	$db=&$this->model->db;
	$_SESSION['num_visitors'] = sessionizeNumvisitors($db,$date);
	redirect('patrons/visit');
}	/* fxn */




public function reset(){
	$dbo=PDBO;	
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_lis.php");
	require_once(SITE.'views/customs/'.VCFOLDER.'/customs.php');	/* session customs */
	
	$dbg=PDBG;$db=&$this->model->db;
	sessionizeTime();	
	sessionizeSettingsGis($db,$dbg);
	$ucid = $_SESSION['user']['ucid'];
	sessionizeUserByUcid($db,$ucid);	
	sessionizeLis($db);
	redirect('librarians');

	
/* subdepts, visitors, libstats, patrons, etc. */
	


}	/* fxn */




public function stats(){
$dbo=PDBO;	
require_once(SITE."functions/librarians.php");

$db=&$this->model->db;
$data=getSessionLevelsAndClassrooms($db);

$rows=array();
if(isset($_GET['submit'])){
	$params=$_GET;

	$xr = getPatronStats($db,$params);
	$data['rows']=$xr['rows'];

	
}	/* post */

$data['q']=isset($q)? $q:NULL;

$this->view->render($data,'librarians/stats');

}





public function crlist(){

$data=NULL;
$this->view->render($data,'librarians/crlist');

}	/* fxn */












}	/* BlankController */
