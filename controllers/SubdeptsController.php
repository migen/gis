<?php

Class SubdeptsController extends Controller{	
public $dbtable=PDBO.".`05_subdepts`";

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$db=&$this->model->db;
	$q="SELECT * FROM {$dbo}.`05_subdepts` ORDER BY `id`; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	
	$this->view->render($data,'subdepts/indexSubdepts');

}	/* fxn */


public function ip(){ 
	$dbo=PDBO;$db=&$this->model->db;
	$q="SELECT * FROM {$dbo}.88_ip_subdepts ORDER BY `id`; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);	
	$this->view->render($data,'subdepts/ipSubdepts');
}	/* fxn */



public function edit($params=NULL){
$id=isset($params[0])? $params[0]:1;
$db=&$this->model->db;$dbo=PDBO;

if(isset($_POST['submit'])){
	$q="UPDATE {$dbo}.88_ip_subdepts SET `ip`='".$_POST['ip']."' WHERE id='$id' LIMIT 1; ";	
	$db->query($q);
	flashRedirect('subdepts',"Subdept $id updated.");
	
}	/* post */

$q="SELECT * FROM {$dbo}.88_ip_subdepts WHERE id='$id' LIMIT 1; ";
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$this->view->render($data,'subdepts/edit');

}	/* fxn */




}	/* SubdeptsController */
