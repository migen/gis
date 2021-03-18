<?php

Class DatatypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
	
	$this->view->render($data=NULL,'datatypes/indexDatatypes');
}	/* fxn */


public function strint(){
	$db=&$this->baseModel->db;$dbo=PDBO;

	$q="SELECT *,((q1+q2)/2) AS ave_s1,((q3+q4)/2) AS ave_s2 FROM {$dbo}.00_datatypes; ";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"datatypes/strintDatatypes");
	
	
	$q1="SELECT AVG(id) FROM {$dbo}.50_scores; ";	// 0.3 sec, 281102.0487
	pr($q1);
	$q1="SELECT AVG(pk) FROM {$dbo}.50_scores; ";	// 2 sec, 281,102
	pr($q1);
	 
 

}	/* fxn */


public function scores(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT count(id) AS count FROM {$dbo}.50_scores;  ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$data['count']=$row['count'];
	echo number_format($data['count'],2);
	
	
	
	
}	/* fxn */













}	/* BlankController */
