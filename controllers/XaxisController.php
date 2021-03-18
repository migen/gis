<?php

Class XaxisController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	
	// $data=array('car','house');
	$data=NULL;	
	// $this->view->render($data,'abc/indexAbcxxx');
	$this->view->render($data,"xaxis/indexXaxis");
}	/* fxn */




public function finder($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$_SESSION['qtr'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$db=&$this->baseModel->db;
	$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
	$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
	$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
	$data['current']=($sy==DBYR)? true:false;
	
	include_once(SITE.'views/elements/dbsch.php');
	
	if($scid){
		$q="SELECT c.id,c.code,c.name,summ.crid,c.`sy` AS csy,cr.name AS classroom,cr.level_id 
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
			WHERE c.`id`='$scid' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row1=$sth->fetch();
		$row2=array();
		$row=array_merge($row1,$row2);
		$data['row']=&$row;		
		
	}
	
	$vfile="xaxis/finderXaxis";	vfile($vfile);	
	$this->view->render($data,$vfile);
}	/* fxn */


public function assessment($params=NULL){
	$scid=isset($params[0])? $params[0]:false;
	$sy=isset($params[1])? $params[1]:$_SESSION['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;$db=&$this->baseModel->db;
	if(!$scid){ flashRedirect("xaxis/finder","Redirected from assessment with empty student parameter."); }
	
	$q="
		SELECT c.name AS student,summ.scid,
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE c.id='$scid' LIMIT 1;
		
	";
	
	
}	/* fxn */




}	/* BlankController */
