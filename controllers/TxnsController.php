<?php

Class TxnsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	
	$data="Txns";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */



public function stack($params=NULL){
	$scid=isset($params[0])? $params[0]:1200;
	$data['scid']=&$scid;
	$data['year_beg']=$year_beg=2016;
	$data['year_end']=$year_end=2018;
	$db=&$this->baseModel->db;$dbo=PDBO;
	
	$rows=array();
	$count=0;
	$i=0;
	for($y=$year_beg;$y<=$year_end;$y++){
		$dbg=VCPREFIX.$y.US.DBG;		
		$q="SELECT *,CONCAT('".VCPREFIX."',$y,'_".DBG."') AS 'dbname' FROM {$dbg}.txns WHERE `scid`='$scid';  ";
		$sth=$db->querysoc($q);
		$recs[$i]=$sth->fetchAll();
		foreach($recs[$i] AS $rec){			
			array_push($rows,$rec);			
			$count++;
		}	/* foreach */
		$i++;		
	}	
	$data['rows']=&$rows;
	$data['count']=&$count;		
	$this->view->render($data,"txns/stackTxns");

}	/* fxn */







}	/* BlankController */
