<?php

Class CostsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}

public function index(){
	echo "Costs Index";
}


public function logs(){ 
	$data['home']	= $_SESSION['home'];
	$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
	$params=$_GET;
	$cond="";
	if(!empty($params['prid'])){ $cond.=" AND c.prid='".$params['prid']."'"; } 
	if(!empty($params['suppid'])){ $cond.=" AND p.suppid='".$params['suppid']."'"; } 
	$q="SELECT c.*,p.name AS product 
		FROM {$dbg}.`30_costlogs` AS c 
		LEFT JOIN {$dbo}.`03_products` AS p ON c.prid=p.id
		WHERE 1=1 $cond ORDER BY p.name,c.id DESC; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=count($rows);

	
	$this->view->render($data,'costs/logs');

}	/* fxn */









}	/* CostsController */
