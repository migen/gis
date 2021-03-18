<?php

Class PaydaytypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(!isset($_SESSION['hr']['paydaytypes'])){ $_SESSION['hr']['paydaytypes'] = fetchRows($db,"{$dbg}.06_paydaytypes","*","name"); 	 } 
	$data['rows'] = $_SESSION['hr']['paydaytypes'];		
	$data['count']=count($data['rows']);	
	$this->view->render($data,'paydaytypes/indexPaydaytypes');
}	/* fxn */

public function edit($params){
$data['id']=$id=$params[0];
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbg}.06_paydaytypes",$post,"id='$id'");
	flashRedirect("paydaytypes/edit/$id","Saved.");
}	/* post */
$q="SELECT * FROM {$dbg}.06_paydaytypes WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'paydaytypes/editPaydaytypes');


}	/* fxn */


public function add(){
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['id']=lastId($db,"{$dbg}.06_paydaytypes")+1;		
	$db->add("{$dbg}.06_paydaytypes",$post);
	flashRedirect("paydaytypes","Added.");
}	/* post */
$data=NULL;
$this->view->render($data,'paydaytypes/addPaydaytypes');

}	/* fxn */

public function delete($params){
	$ppid=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="DELETE FROM {$dbg}.06_payperiods WHERE id='$ppid' LIMIT 1; ";
	$db->query($q);
}	/* fxn */




}	/* BlankController */
