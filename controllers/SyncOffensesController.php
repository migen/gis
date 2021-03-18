<?php

Class SyncOffensesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}

public function index(){	
	echo "sync offenses";
	$this->view->render(NULL,'abc/index');
	
}	/* fxn */




public function all(){
	require_once(SITE.'functions/offensesFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;$dbg=&$dbg;$sy=DBYR;$dbo=PDBO;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$q="SELECT summ.scid
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE cr.section_id>2;";
	$sth=$db->querysoc($q);
	$a=$sth->fetchAll();
	$ar = buildArray($a,'scid');	

	$q="SELECT scid FROM {$dbg}.50_offenses_{$sch};";
	$sth=$db->querysoc($q);
	$b=$sth->fetchAll();	
	$br = buildArray($b,'scid');	
	
	$ix = array_diff($ar,$br);			
	$q = " INSERT INTO {$dbg}.50_offenses_{$sch}(`scid`) VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";			
	$sth=$db->query($q);	
	echo ($sth)? "Success":"Failure";		
	
}	/* fxn */










}	/* BlankController */
