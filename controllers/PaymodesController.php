<?php

Class PaymodesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	pr("Paymodes");
	echo "<a href='".URL."/paymodes/table' >Table</a>"; 
	
}	/* fxn */
	
	
	
public function table(){
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	$q="SELECT *,id AS pmid FROM {$dbo}.03_paymodes ORDER BY id;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	

	$this->view->render($data,'paymodes/tablePaymodes');
}	/* fxn */


public function edit1($params){
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

public function add1(){
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

public function delete1($params){
	$id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="DELETE FROM {$dbg}.06_paygroups WHERE id='$id' LIMIT 1; ";
	$db->query($q);
}	/* fxn */




}	/* BlankController */
