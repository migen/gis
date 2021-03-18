<?php

Class SecretsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}




public function index(){
	$dbo = PDBO;
	$q = " SELECT * FROM {$dbo}.secrets; ";
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	$this->view->render($data,'secrets/index');
	
}	/* fxn */
 
 
public function editSecret($params){
$dbo=PDBO;
	$data['id'] = $id = $params[0];
	$q = " SELECT * FROM {$dbo}.secrets WHERE id = '$id' LIMIT 1; ";
	$sth = $this->model->db->querysoc($q);
	$data['row'] = $sth->fetch();
	
	if(isset($_POST['submit'])){
		// pr($_POST);
		$post = $_POST;
		$clear = $post['clear'];
		$value = MD5($clear);
		$q = "UPDATE {$dbo}.secrets SET `value` = '$value',`clear` = '$clear' WHERE `id` = '$id'; ";
		$this->model->db->query($q);
		$url = "mis/secrets";
		flashRedirect($url,'Secret updated.');
		exit;
		
	} /* post */
	
	$this->view->render($data,'mis/secret');

}	/* fxn */
 
 
 
public function addSecret(){
$dbo=PDBO;
	
	if(isset($_POST['submit'])){
		$post = $_POST;
		$name  = $post['name'];
		$clear = $post['clear'];
		$value = MD5($clear);
		$q = "INSERT INTO {$dbo}.secrets (`name`,`value`,`clear`) 
			VALUES('$name','$value','$clear'); ";
		$this->model->db->query($q);
		$url = "mis/secrets";
		flashRedirect($url,'Secret added.');
		exit;
		
	} /* post */
		
	$this->view->render($data=NULL,'mis/secret');

}	/* fxn */
 







}	/* SecretsController */
