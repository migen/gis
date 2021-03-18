<?php

Class majorsController extends Controller{	

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
	$q="SELECT m.*,m.id AS major_id,c.code AS college_code FROM {$dbg}.`05_majors` AS m
		LEFT JOIN {$dbg}.01_colleges AS c ON m.college_id=c.id
		ORDER BY m.`college_id`,`name`; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();		
	$this->view->render($data,"majors/indexmajors");
}	/* fxn */

public function add(){
	$data['db']=&$this->baseModel->db;
	$this->view->render($data,"majors/addmajors");	
}	/* fxn */


public function reset(){ $db=&$this->baseModel->db;$dbg=PDBG;$_SESSION['majors']=fetchRows($db,"{$dbg}.`05_majors`","id,code,name");pr("Done.");}	


public function edit($params=NULL){
$dbo=PDBO;
	if(empty($params)){ pr("Major ID empty."); exit; }
	$data['major_id']=$major_id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		// pr($post);exit;
		$db->update("{$dbg}.`05_majors`",$post,"id=$major_id");
		flashRedirect("majors/view/$major_id","Updated.");
		
	}	/* post */
	
	// $data['row']=fetchRow($db,"{$dbg}.`05_majors`",$major_id);
	$q="SELECT m.*,c.name AS college FROM {$dbg}.`05_majors` AS m LEFT JOIN {$dbg}.01_colleges AS c ON m.college_id=c.id WHERE m.id=$major_id LIMIT 1;  ";
	$sth=$db->querysoc($q);$data['row']=$sth->fetch();	
	$data['unicolleges']=fetchRows($db,"{$dbg}.01_colleges");	
	$this->view->render($data,"majors/editUnimajor");
	
}	/* fxn */



public function view($params=NULL){
$dbo=PDBO;
	if(empty($params)){ pr("Major ID empty."); exit; }
	$data['major_id']=$major_id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;	
	// $data['row']=fetchRow($db,"{$dbg}.`05_majors`",$major_id);
	$q="SELECT m.*,c.name AS college FROM {$dbg}.`05_majors` AS m LEFT JOIN {$dbg}.01_colleges AS c ON m.college_id=c.id WHERE m.id=$major_id LIMIT 1;  ";
	$sth=$db->querysoc($q);$data['row']=$sth->fetch();
	$this->view->render($data,"majors/viewUnimajor");	
}	/* fxn */




}	/* BlankController */

