<?php

Class FdntypesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$dbo=PDBO;	
	$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT *,id AS pgid FROM {$dbg}.05_fdntypes ORDER BY id;";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	

	$this->view->render($data,'fdntypes/indexFdntypes');
}	/* fxn */

public function edit($params){
$dbo=PDBO;	
$data['id']=$id=$params[0];
$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbg}.05_fdntypes",$post,"id='$id'");
	flashRedirect("fdntypes/edit/$id/$sy","Saved.");
}	/* post */
$q="SELECT * FROM {$dbg}.05_fdntypes WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'fdntypes/editFdntype');


}	/* fxn */

public function add(){
$dbo=PDBO;	
$data['sy']=$sy=isset($params[0])?$params[0]:DBYR;
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['id']=lastId($db,"{$dbg}.05_fdntypes")+1;	
	$db->add("{$dbg}.05_fdntypes",$post);
	flashRedirect("fdntypes/index/$sy","Added.");
}	/* post */
$data=NULL;
$this->view->render($data,'fdntypes/addFdntype');

}	/* fxn */

public function delete($params){
	$dbo=PDBO;	
	$id=$params[0];
	$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
	$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;	
	$q="DELETE FROM {$dbg}.05_fdntypes WHERE id='$id' LIMIT 1; ";
	pr($q);	
	$db->query($q);
	echo "Success.";
	
}	/* fxn */




}	/* BlankController */
