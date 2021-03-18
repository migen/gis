<?php

Class DuplicatesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
	$db=&$this->model->db;
	echo "Duplicates index";	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/index');
	

}	/* fxn */


public function students($params=NULL){ 
$sch=VCFOLDER;$sy=DBYR;
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$q="SELECT scid,count(*) AS numrows
	FROM {$dbg}.{$sch}_ar_{$sy}
	GROUP BY scid HAVING COUNT(numrows) > 1; ";
debug($q); 


$q="SELECT id AS scid,code,name,role_id,count(*) AS numrows
	FROM {$dbo}.00_contacts
	GROUP BY code HAVING COUNT(numrows) > 1; ";

$sth = $db->querysoc($q);
$data['duplicates'] = $sth->fetchAll();
$data['count'] = count($data['duplicates']);

pr($data);

echo '<a href="'.URL.'mis/query" >MIS Query</a>';

// $this->view->render($data,'mis/atte_duplicates');


}	/* fxn */




public function go(){

$db=&$this->model->db;
// $dbg="2011_abc";
$dbg=DBO;
$dbo=PDBO;
$columns = "`id`,`code`,`account`,`name`";
$duplifield="account";

// WHERE id=parent_id
$q="
	SELECT $columns
	FROM {$dbo}.`00_contacts`
	WHERE 1=1
	GROUP BY `$duplifield`
	HAVING count(`$duplifield`) > 1	
	ORDER BY `id`
";
pr($q);

$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
pr($rows);

}	/* fxn */




public function duplicates($params=NULL){ 
$sch=VCFOLDER;$sy=DBYR;
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$q="SELECT scid,count(*) AS numrows
	FROM {$dbg}.{$sch}_ar_{$sy}
	GROUP BY scid HAVING COUNT(numrows) > 1; ";
debug($q); 

pr("&get - dbtable, field, ");

if((!isset($_GET['dbtable']) || (!isset($_GET['field'])))){ pr("Get params required."); exit; }

$field=$_GET['field'];
$dbtable=$_GET['dbtable'];

$q="SELECT $field,count(*) AS numrows
	FROM {$dbtable} GROUP BY $field
	HAVING COUNT(numrows) > 1; ";
pr($q);
$sth = $db->querysoc($q);
$data['duplicates'] = $sth->fetchAll();
$data['count'] = count($data['duplicates']);

pr($data);

echo '<a href="'.URL.'mis/query" >MIS Query</a>';

// $this->view->render($data,'mis/atte_duplicates');


}	/* fxn */



public function sjam_ar($params=NULL){ 
$sch=VCFOLDER;$sy=DBYR;
$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
$q="SELECT scid,count(*) AS numrows
	FROM {$dbg}.{$sch}_ar_{$sy}
	GROUP BY scid HAVING COUNT(numrows) > 1; ";
debug($q); 

$sth = $db->querysoc($q);
$data['duplicates'] = $sth->fetchAll();
$data['count'] = count($data['duplicates']);

pr($data);

echo '<a href="'.URL.'mis/query" >MIS Query</a>';


}

}	/* DuplicatesController */
