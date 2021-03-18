<?php

Class AbcController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}




public function index(){
select count(id) FROM 2018_dbgis_lsm.products_2017; 

INSERT INTO 2018_dbgis_lsm.abc_2017 SELECT * FROM 2018_dbgis_lsm.abc_2018; 



INSERT INTO 2018_dbgis_lsm.products_2017 SELECT * FROM 2018_dbgis_lsm.products_2018; 



SELECT count(id) FROM 2018_dbgis_lsm.products_2017 WHERE
		(suppid=2220 || suppid=2230);

DELETE FROM 2018_dbgis_lsm.products_2017 WHERE
	(suppid=2220 || suppid=2230);

SELECT count(id) FROM 2018_dbgis_lsm.products_2017 WHERE
	(suppid=2220 || suppid=2230);

	
SELECT count(id) FROM 2018_dbgis_lsm.products_2017 WHERE
	(suppid!=2220 && suppid!=2230);

DELETE FROM 2018_dbgis_lsm.products_2018 WHERE
	(suppid!=2220 && suppid!=2230);
	
	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;

	$q="SELECT * FROM {$dbg}.products_2017 WHERE id>9000; ";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	
	$this->view->render($data,'abc/abcIndex');
	



}	/* fxn */


public function index7(){
	
	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;

$q="select count(id) FROM {$dbg}.products_2017; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
pr($q);
pr($row);

$q="select count(id) FROM {$dbg}.products_2018; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
pr($q);
pr($row);



}


public function index5(){	

	
	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;
	
	// 1 - delete evangaline and gm from 2017
	$q="DELETE FROM {$dbg}.abcd_2016 WHERE
		(suppid=1 || suppid=2);
	";
	// $sth=$db->query($q);
	// pr($q);
	// echo ($sth)? "success":"fail"; echo "<br />";

	// 2 - retain delete non-evangaline and non-gm from 2018
	$q="
		DELETE FROM {$dbg}.abcd_2016
		WHERE (suppid!=1 && suppid!=2);	
	";
		
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "DELETE success":"Delete fail"; echo "<br />";


		


}	/* fxn */


public function index3(){
	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;

	$q="
		DELETE FROM {$dbg}.abcd_2016
		WHERE (suppid!=1 && suppid!=2)
	";
	
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "success":"fail"; echo "<br />";
	

}



public function index2(){

	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;

// INSERT INTO tbl_temp2 (fld_id)
    // SELECT tbl_temp1.fld_order_id
    // FROM tbl_temp1 WHERE tbl_temp1.fld_order_id > 100;	
	
	$q=" INSERT INTO {$dbg}.abc_2017 SELECT * FROM {$dbg}.abc_2018; ";
	
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "success":"fail"; echo "<br />";
	
	
	$q="SELECT * FROM {$dbg}.abc_2017; ";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	
	$this->view->render($data,'abc/abcIndex');
	



}	/* fxn */


public function index8(){	

	
	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;
	$q="";
	
	
	// 1 - delete evangaline and gm from 2017
	$q="DELETE FROM {$dbg}.products_2017 WHERE
		(suppid=2220 || suppid=2230);
	";
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "success":"fail"; echo "<br />";

	// 2 - delete non-evangaline and non-gm from 2018
	$q="
		DELETE FROM {$dbg}.products_2018
		WHERE (suppid!=2220 && suppid!=2230);	
	";
		
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "DELETE success":"Delete fail"; echo "<br />";


	
	// $q=" INSERT INTO {$dbg}.abc_2017 SELECT * FROM {$dbg}.abc_2018; ";
	$q=" INSERT INTO {$dbg}.products_2017 SELECT * FROM {$dbg}.products_2018; ";
	
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "success":"fail"; echo "<br />";


$q="select count(id) FROM {$dbg}.products_2017; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
pr($q);
pr($row);
	
	
	// pr($q);
	// $sth=$db->querysoc($q);
	// $data['rows']=$sth->fetchAll();
	// $data['count']=count($data['rows']);
	
	// $this->view->render($data,'abc/productsAbc');
	


}	/* fxn */



public function index9(){	

	
	$db=&$this->model->db;
	$dbg=PDBG;$dbo=PDBO;
	$q="";
	

$q="select count(id) FROM {$dbg}.products_2017; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
pr($q);
pr($row);
	
	
	// 1 - delete evangaline and gm from 2017
	$q="DELETE FROM {$dbg}.products_2017 WHERE
		(suppid=2220 || suppid=2230);
	";
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "success":"fail"; echo "<br />";

$q="select count(id) FROM {$dbg}.products_2017; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
pr($q);
pr($row);
	

$q="select count(id) FROM {$dbg}.products_2018; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
pr($q);
pr($row);
	
	// 2 - delete non-evangaline and non-gm from 2018
	$q="
		DELETE FROM {$dbg}.products_2018
		WHERE (suppid!=2220 && suppid!=2230);	
	";
		
	$sth=$db->query($q);
	pr($q);
	echo ($sth)? "DELETE success":"Delete fail"; echo "<br />";

$q="select count(id) FROM {$dbg}.products_2018; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
pr($q);
pr($row);

	
	// $q=" INSERT INTO {$dbg}.abc_2017 SELECT * FROM {$dbg}.abc_2018; ";
	// $q=" INSERT INTO {$dbg}.products_2017 SELECT * FROM {$dbg}.products_2018; ";
	
	// $sth=$db->query($q);
	// pr($q);
	// echo ($sth)? "success":"fail"; echo "<br />";


	
	
	// pr($q);
	// $sth=$db->querysoc($q);
	// $data['rows']=$sth->fetchAll();
	// $data['count']=count($data['rows']);
	
	// $this->view->render($data,'abc/productsAbc');
	


}	/* fxn */






}	/* BlankController */
