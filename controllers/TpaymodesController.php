<?php

Class paymodesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function index($params=NULL){

$ssy = $_SESSION['sy'];
$sy = isset($params[0])? $params[0]:$ssy;
$dbg = VCPREFIX.$sy.US.DBG;

if(isset($_POST['submit'])){
	$posts = $_POST['posts'];
	$q = "";
	foreach($posts AS $post){
		$q .= " UPDATE {$dbo}.`03_paymodes` SET `dates` = '".$post['dates']."',`surcharge` = '".$post['surcharge']."',
			`periods` = '".$post['periods']."' WHERE `id` = '".$post['id']."' LIMIT 1; ";	
	}
	// pr($q);
	// exit;
	$this->model->db->query($q);
	flashRedirect('paymodes/index','Payment Modes Updated.');
}	/* post */


$q = "SELECT * FROM {$dbo}.`03_paymodes`; ";
$sth = $this->model->db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

$this->view->render($data,'paymodes/index');


}	/* fxn */








}	/* paymodesController */
