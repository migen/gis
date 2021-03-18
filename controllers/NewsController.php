<?php

Class NewsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	
	$dbo=PDBO;$db=&$this->baseModel->db;
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$q="SELECT * FROM {$dbo}.news WHERE id='$id' LIMIT 1; ";
	} else if(isset($_GET['title'])){
		$title=$_GET['title'];	
		$q="SELECT * FROM {$dbo}.news WHERE `title` LIKE '%".$title."%'; ";
	} else {
		$limit=isset($_GET['limit'])? $_GET['limit']:2;
		$q="SELECT * FROM {$dbo}.news LIMIT $limit; ";
	}
	pr($q);
	
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	echo json_encode($rows);
	
	// $this->view->render($data,'news/indexNews','blank');

}	/* fxn */



}	/* BlankController */
