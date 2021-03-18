<?php

Class UnicollegesController extends Controller{	

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
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	$q="SELECT * FROM {$dbg}.01_colleges ORDER BY `id`; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	$this->view->render($data,"unicolleges/indexUnicolleges");
}	/* fxn */


public function edit($params=NULL){
$dbo=PDBO;
	if(empty($params)){ pr("College ID empty."); exit; }
	$data['college_id']=$college_id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		// pr($post);exit;
		$db->update("{$dbg}.01_colleges",$post,"id=$college_id");
		flashRedirect("unicolleges","Updated College ID #$college_id.");
		
	}	/* post */
	
	$data['row']=fetchRow($db,"{$dbg}.01_colleges",$college_id);
	$this->view->render($data,"unicolleges/editUnicollege");
	
}	/* fxn */










}	/* BlankController */
