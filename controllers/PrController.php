<?php

Class PrController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "Pr index";

}	/* fxn */


public function classlist($params){
$dbo=PDBO;
require_once(SITE."functions/classlist.php");
require_once(SITE."functions/details.php");
$db=&$this->model->db;
$data['crid']=$crid=$params[0];
$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['sy'];
$dbo=PDBO;
$dbg=VCPREFIX.$sy.US.DBG;
$dbg=VCPREFIX.$sy.US.DBG;

$data['cr']=getClassroomDetails($db,$crid,$dbg);

$order=$_SESSION['settings']['classlist_order'];
$data['rows']=classlist($db,$dbg,$crid,$male=2,$order,$fields=NULL,$filters=NULL,$limit=NULL,$active=1);
$data['count']=count($data['rows']);

$this->view->render($data,'pr/classlist');



}	/* fxn */


}	/* BlankController */
