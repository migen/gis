<?php

Class IbookController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data=NULL;
	$data['ucid']=$ucid=$_SESSION['ucid'];
	$data['srid']=$srid=$_SESSION['srid'];
	if(isset($_GET['find'])){
		$find=$_GET['find'];
		$cond=($srid==RMIS)? NULL:"AND i.ucid='$ucid'";
		$q="SELECT i.*,c.name AS user FROM {$dbo}.00_ibook AS i LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=i.ucid
			WHERE i.`name` LIKE '%".$find."%' $cond; ";
		debug($q);
		$sth=$db->querysoc($q);
		$data['rows']=$sth->fetchAll();
		$data['count']=count($data['rows']);
	}	/* get */
	
	$this->view->render($data,'ibook/indexIbook');
}	/* fxn */


public function edit($params){
$data['id']=$id=$params[0];
$db=&$this->baseModel->db;$dbo=PDBO;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbo}.00_ibook",$post,"id='$id'");
	flashRedirect("ibook/edit/$id/$sy","Saved.");
}	/* post */
$q="SELECT * FROM {$dbo}.00_ibook WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'ibook/editIbook');


}	/* fxn */

public function add(){
$db=&$this->baseModel->db;$dbo=PDBO;
if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['id']=lastId($db,"{$dbo}.00_ibook")+1;	
	$db->add("{$dbo}.00_ibook",$post);
	flashRedirect("ibook","Added.");
}	/* post */
$data=NULL;
$this->view->render($data,'ibook/addIbook');

}	/* fxn */

public function delete($params){
	$id=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="DELETE FROM {$dbo}.00_ibook WHERE id='$id' LIMIT 1; ";
	pr($q);	
	$db->query($q);
	echo "Success.";
	
}	/* fxn */




}	/* BlankController */
