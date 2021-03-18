<?php

Class PaygroupsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="SELECT *,id AS pgid FROM {$dbg}.06_paygroups ORDER BY position;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	

	$this->view->render($data,'paygroups/indexPaygroups');
}	/* fxn */

public function edit($params){
$data['id']=$id=$params[0];
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbg}.06_paygroups",$post,"id='$id'");
	flashRedirect("paygroups/edit/$id","Saved.");
}	/* post */
$q="SELECT * FROM {$dbg}.06_paygroups WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'paygroups/editPaygroup');


}	/* fxn */

public function add(){
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['id']=lastId($db,"{$dbg}.06_paygroups")+1;	
	$db->add("{$dbg}.06_paygroups",$post);
	flashRedirect("paygroups","Added.");
}	/* post */
$data=NULL;
$this->view->render($data,'paygroups/addPaygroup');

}	/* fxn */

public function delete($params){
	$id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="DELETE FROM {$dbg}.06_paygroups WHERE id='$id' LIMIT 1; ";
	$db->query($q);
}	/* fxn */




}	/* BlankController */
