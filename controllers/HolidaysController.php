<?php

Class HolidaysController extends Controller{	

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
	$sort=isset($_GET['sort'])? $_GET['sort']:"date";
	$dbhr="2011_abc";
	$q=" SELECT * FROM {$dbhr}.holidays ORDER BY $sort ;";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=&$rows;
	$data['count']=count($rows);			
	$this->view->render($data,'holidays/indexHolidays');
	
}	/* fxn */


public function edit($params){
$dbo=PDBO;	
$data['id']=$id=$params[0];
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbg}.06_holidays",$post,"id='$id'");
	flashRedirect("holidays/edit/$id","Saved.");
}	/* post */
$q="SELECT * FROM {$dbg}.06_holidays WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
if(!isset($_SESSION['paydaytypes'])){ $_SESSION['paydaytypes'] = fetchRows($db,"{$dbg}.06_paydaytypes","*","name"); 	 } 
$data['paydaytypes'] = $_SESSION['paydaytypes'];		
$this->view->render($data,'holidays/editHoliday');

}	/* fxn */


public function add(){
$dbo=PDBO;	
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['id']=lastId($db,"{$dbg}.06_holidays")+1;
	$db->add("{$dbg}.06_holidays",$post);
	flashRedirect("holidays","Added.");
}	/* post */

if(!isset($_SESSION['paydaytypes'])){ $_SESSION['paydaytypes'] = fetchRows($db,"{$dbg}.06_paydaytypes","*","name"); 	 } 
$data['paydaytypes'] = $_SESSION['paydaytypes'];		
$this->view->render($data,'holidays/addHoliday');

}	/* fxn */

public function delete($params){
	$dbo=PDBO;	
	$id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="DELETE FROM {$dbg}.06_holidays WHERE id='$id' LIMIT 1; ";
	$db->query($q);
}	/* fxn */






}	/* HolidaysController */
