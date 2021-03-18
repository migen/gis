<?php

Class SectionsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index($params=NULL){
	ob_start();
	echo "<h3>Sections | ";shovel('links_gset');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");
}	/* fxn */

public function set($params=NULL){
$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	if(isset($_POST['add'])){
		$year = date('Y');
		$q = "INSERT INTO {$dbo}.`05_sections` (`code`,`name`) VALUES ";
		$rows = $_POST['sections'];
		foreach($rows AS $row){	if(!empty($row['name'])){ $q .= " ('".$row['code']."','".$row['name']."'),"; } }			
		$q = rtrim($q,",");
		$q .= ";";
		$this->model->db->query($q);
		$url = "sections/set";
		flashRedirect($url,'Sections added.');		
		exit;
	}	/* post-add */

	$order = isset($_GET['order'])? $_GET['order']:'code';
	$data['sections'] = $this->model->fetchRows("{$dbo}.`05_sections`","*",$order);
	$data['num_sections'] 	= count($data['sections']);		
	$this->view->render($data,'sections/setSections');

}	/* fxn */



public function edit($params=NULL){
	$id=$params[0];
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;
	$q="SELECT * FROM {$dbo}.`05_sections` WHERE id='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	if(isset($_POST['submit'])){
		$q="UPDATE {$dbo}.`05_sections` SET `position`='".$_POST['position']."',`code`='".$_POST['code']."',
			`name`='".$_POST['name']."' 
			WHERE id='$id' LIMIT 1; ";
		$db->query($q);
		$url="sections/edit/$id";
		flashRedirect($url,'Section updated');
	}	/* post */
	$this->view->render($data,'sections/editSection');

}	/* fxn */




}	/* SectionsController */
