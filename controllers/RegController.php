<?php

Class RegController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	/* -- reg-9 and MIS-5,move methods to GController for other roles like teachers,i.e. clsAdvi */
	$acl = array(array(9,0),array(5,0),array(6,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);		
	
}	/* fxn */

public function beforeFilter(){ parent::beforeFilter();		}	



public function index($params=NULL){	
$dbo=PDBO;

$db =& $this->model->db;$dbg=PDBG;
$home=$_SESSION['home'];	
$srid=$_SESSION['srid'];
$allowed=array(RMIS,RREG);
if(!in_array($srid,$allowed)){ flashRedirect(); }
// $data=$_SESSION['registrar']; 
$data['user']=$_SESSION['user'];		
$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
$data['qtr']=$qtr=isset($params[1])?$params[1]:$_SESSION['qtr'];
$data['home']=$home;	
	
if(!isset($_SESSION['roles'])){ $_SESSION['roles'] = fetchRows($db,DBO.'.`00_roles`'); } 
$data['roles'] 	= $_SESSION['roles'];	
if(!isset($_SESSION['classrooms'])){ $_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name,acid AS acid","level_id,name"); 	 } 
$data['classrooms'] = $_SESSION['classrooms'];		
if(!isset($_SESSION['levels'])){ $_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,name","id"); 	 } 
$data['levels'] = $_SESSION['levels'];		
$vfile="reg/indexReg";
$this->view->render($data,$vfile);	

}	/* fxn */


public function notes(){ $this->view->render(null,'registrars/notes');	}	/* fxn */

public function reset($params=NULL){ $this->model->sessionizeRegistrar(PDBG);redirect(); } /* fxn */



} 	/* RegistrarsController */
