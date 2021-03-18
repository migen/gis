<?php

Class PayperiodsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="SELECT *,id AS ppid FROM {$dbg}.06_payperiods ORDER BY begdate DESC;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	

	$this->view->render($data,'payperiods/indexPayperiods');
}	/* fxn */

public function edit($params){
$data['id']=$id=$params[0];
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbg}.06_payperiods",$post,"id='$id'");
	flashRedirect("payperiods/edit/$id","Saved.");
}	/* post */
$q="SELECT * FROM {$dbg}.06_payperiods WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'payperiods/editPayperiod');


}	/* fxn */


public function add(){
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['id']=lastId($db,"{$dbg}.06_payperiods")+1;		
	$db->add("{$dbg}.06_payperiods",$post);
	flashRedirect("payperiods","Added.");
}	/* post */
$data=NULL;
$this->view->render($data,'payperiods/addPayperiod');

}	/* fxn */

public function delete($params){
	$ppid=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="DELETE FROM {$dbg}.06_payperiods WHERE id='$ppid' LIMIT 1; ";
	$db->query($q);
}	/* fxn */




}	/* BlankController */
