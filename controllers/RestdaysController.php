<?php

Class RestdaysController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;	
	$pcid=$_SESSION['pcid'];
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'restdays/index');

}	/* fxn */


public function setter(){
require_once(SITE.'functions/restdays.php');
require_once(SITE.'functions/sessionize_hr.php');
$db=&$this->model->db;
$dbo="2011_abc";$dbhr="2011_abc";
if(isset($_POST['submit'])){
	// pr($_POST);
	$posts=$_POST['post'];
	foreach($posts AS $post){
		if(isset($post['check'])){
			// pr($post);
			updateRestdaysByEmployee($db,$post,$dbhr);
		}
	}	/* posts */
	
	/* 2 */
	sessionizeEmployees($db,$dbo,$dbhr);	
	flashRedirect("restdays/setter","Restdays updated.");	
	exit;
}	/* post */

// $data=NULL;
$dbo = "2011_abc";

// $data

$data['rows']=$_SESSION['hr']['employees'];
$data['count']=$_SESSION['hr']['employees_count'];

// $data=NULL;
$this->view->render($data,'restdays/setter');

}	/* fxn */






}	/* RestdaysController */
