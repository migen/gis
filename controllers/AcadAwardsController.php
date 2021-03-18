<?php

Class AcadAwardsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;
	$db=&$this->model->db;
	echo "AcadAwards index";
	
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'abc/index');
	

}	/* fxn */



public function level($params=NULL){
	require_once(SITE.'functions/conducts_awards.php');

	$lvl=isset($params[0])? $params[0]:4;
	$sy=isset($params[1])? $params[1]:DBYR;
	$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$db=&$this->model->db;
	
	pr($dbg);
	$sch=VCFOLDER;
	
	pr($sch);
	// $q={$sch}();
	$q=$sch();
	echo "option 1: "; pr($q);

	$q="SELECT * FROM {$dbo}.abap WHERE name='conducts_awards' LIMIT 1;	";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$q=$row['query'];
	pr($q);
	
	// $_POST['discounts'] = str_replace(",","",$_POST['discounts']);
	
	$scid=364;
	$q=str_replace("{DBO}",DBO,$q);
	$q=str_replace("{DBG}",$dbg,$q);
	$q=str_replace("{scid}",$scid,$q);
	pr($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	pr($row);
	
	
	
	

	
	
	
	
	
	
	
	$data['lvl']=$lvl;
	$data['rows']=array(
		array('student'=>'Anna'),
		array('student'=>'Banana'),
		array('student'=>'Coconut'),
	);
	$data['count']=3;
	
	$this->view->render($data,'awards/conducts');
}	/* fxn */



public function classroom($params=NULL){
	require_once(SITE.'functions/conducts_awards.php');

	$lvl=isset($params[0])? $params[0]:4;
	$sy=isset($params[1])? $params[1]:DBYR;
	$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$db=&$this->model->db;
	
	pr($dbg);
	$sch=VCFOLDER;
	
	pr($sch);
	// $q={$sch}();
	$q=$sch();
	echo "option 1: "; pr($q);

	$q="SELECT * FROM {$dbo}.abap WHERE name='conducts_awards' LIMIT 1;	";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$q=$row['query'];
	pr($q);
	
	// $_POST['discounts'] = str_replace(",","",$_POST['discounts']);
	
	$scid=364;
	$q=str_replace("{DBO}",DBO,$q);
	$q=str_replace("{DBG}",$dbg,$q);
	$q=str_replace("{scid}",$scid,$q);
	pr($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	pr($row);
	
	
	
	

	
	
	
	
	
	
	
	$data['lvl']=$lvl;
	$data['rows']=array(
		array('student'=>'Anna'),
		array('student'=>'Banana'),
		array('student'=>'Coconut'),
	);
	$data['count']=3;
	
	$this->view->render($data,'awards/conducts');
}	/* fxn */



public function border(){
	$data=NULL;
	$this->view->render($data,'awards/border');
}	/* fxn */



}	/* BlankController */
