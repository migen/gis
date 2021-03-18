<?php

Class CritypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	echo "Critypes";shovel('links_gset');
}	



public function edit($params){
$dbo=PDBO;
$data['id']=$id=$params[0];
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbo}.`05_critypes`",$post,"id='$id'");
	flashRedirect("critypes/edit/$id","Saved.");
}	/* post */
$q="SELECT * FROM {$dbo}.`05_critypes` WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'critypes/editCritype');


}	/* fxn */

public function add(){
$dbo=PDBO;
$db=&$this->baseModel->db;$dbg=PDBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['id']=lastId($db,"{$dbo}.`05_critypes`")+1;	
	$db->add("{$dbo}.`05_critypes`",$post);
	flashRedirect("critypes","Added.");
}	/* post */
$data=NULL;
$this->view->render($data,'critypes/addCritype');

}	/* fxn */

public function delete($params){
	$dbo=PDBO;
	$id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$q="DELETE FROM {$dbo}.`05_critypes` WHERE id='$id' LIMIT 1; ";
	$db->query($q);
}	/* fxn */


public function editCriteria(){
$dbo=PDBO;
$db=&$this->baseModel->db;$dbg=PDBG;

if(isset($_GET['submit'])){
	$x=$_GET['x_critype'];
	$y=$_GET['y_critype'];
	$q=" UPDATE {$dbo}.`05_criteria` SET critype_id='$y' WHERE critype_id='$x'; ";
	pr($q);
	echo "?exe <br />";	
	if(isset($_GET['exe'])){ $sth=$db->query($q); echo ($sth)? "Success":"Failure"; }


}	/* fxn */

$order=isset($_GET['order'])? $_GET['order']:"id,name";
$data['critypes']=fetchRows($db,"{$dbo}.`05_critypes`","*",$order);
$this->view->render($data,"critypes/editCriteria");

}	/* fxn */



}	/* BlankController */
