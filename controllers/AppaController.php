<?php

Class AppaController extends Controller{	

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
	include_once(SITE.'functions/appaFxn.php');
	$db=$this->baseModel->db;$dbg=PDBO;
	$data=getAllProdtypes($db,$dbg);	
	if(isset($_POST['submit'])){
		$post=$_POST;
		$pos_id=sale($db,$dbg,$post);
		$_SESSION['pos_id']=$pos_id;		
		flashRedirect("appa","Sale Added # $pos_id.");
		exit;
	}	
	$this->view->render($data,"appa/indexAppa");
}	/* fxn */



public function view($params=NULL){
	$id=$params[0];
	$db=$this->baseModel->db;$dbo=PDBO;
	$q="SELECT p.*,c.name AS employee FROM {$dbo}.00_pos AS p 
	INNER JOIN {$dbo}.`00_contacts` AS c ON c.id=p.employee_id WHERE p.id=$id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['pos']=$sth->fetch();
	
	$q="SELECT pr.name AS product,i.* FROM {$dbo}.00_positems AS i 
		INNER JOIN {$dbo}.00_products AS pr ON i.product_id=pr.id 
		WHERE i.pos_id=$id; ";
	$sth=$db->querysoc($q);
	$data['items']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"appa/viewSale");
	
}	/* fxn */







}	/* BlankController */
