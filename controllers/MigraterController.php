<?php

Class MigraterController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}

public function index(){
$dbo=PDBO;
$dbg=PDBG;
$dbp=PDBP;

if(isset($_GET['submit'])){
	pr($_GET);
	$dbtable=$_GET['dbtable'];
	$idbeg=$_GET['idbeg'];
	$idend=$_GET['idend'];
	$q=" INSERT INTO {$dbp}.$dbtable SELECT d.* FROM {$dbg}.$dbtable d WHERE id >= '$idbeg' AND id <='$idend'; ";
	pr($q);
	
	exit;
}



$data=NULL;
$this->view->render($data,'migrater/indexMigrater');

}	/* fxn */



public function ref(){ 
	$dbo=PDBO;$dbp=PDBP;$dbg=PDBG;
	$db=&$this->model->db;
	
	pr($dbo);
	pr($dbp);
	pr($dbg);

	
/* 

CREATE TABLE newtable LIKE oldtable; 
INSERT newtable SELECT * FROM oldtable;
OR
CREATE TABLE tbl_new AS SELECT * FROM tbl_old;	// no triggers. only data


INSERT INTO dues_storage
SELECT d.*, CURRENT_DATE()
FROM dues d
WHERE id = 5; */

	/* 1 copy rows */
	$q=" INSERT INTO {$dbg}.zto SELECT d.* FROM {$dbg}.zfrom d WHERE year < '2018'; ";
	pr($q);
	$db->query($q);

	/* 2 - duplicate table */
	$q=" CREATE TABLE {$dbg}.zfrom_copy LIKE {$dbg}.zfrom; 
	INSERT {$dbg}.zfrom_copy SELECT * FROM {$dbg}.zfrom; ";
	pr($q);
	$db->query($q);

	/* 3 - delete from rows */
	$q=" DELETE FROM {$dbg}.zfrom WHERE year < '2018'; ";
	pr($q);
	$db->query($q);
	
	echo "<br />All 3 queries executed.";

	echo "<hr />";
	echo "<h3>Now join tables for all rows</h3>";
	
	// $q="SELECT a.*,b.*  
		// FROM {$dbg}.zfrom AS a
		// JOIN {$dbg}.zto AS b
	// ";
	$q="SELECT * FROM {$dbg}.zfrom UNION (SELECT * FROM {$dbg}.zto);";		// ok
	
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($rows);
	

	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/index');
	

}	/* fxn */


public function dbinit($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/dbinit_axis.php');
$db=&$this->model->db;
if(isset($params[0])){
	dbinit_axis($db);
}



}	/* fxn */




}	/* BlankController */
