<?php

Class RanktoolsController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index($params=NULL){
	pr("Ranktools");
}	/* fxn */



public function viewAveTwoSems($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['lvl']=$lvl=isset($params[0])? $params[0]:14;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['level']=$level=fetchRow($db,"{$dbo}.05_levels",$lvl);
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['lvl']=$lvl=isset($params[0])? $params[0]:14;
	$data['deciave']=$deciave=isset($_GET['deciave'])? $_GET['deciave']:$_SESSION['settings']['deciave'];	
	$q="SELECT c.id AS scid,c.code AS studcode,c.name AS studname,
			cr.name AS classroom,summ.ave_q5,summ.ave_q6,summ.ave_q7,
			sumx.rank_level_ave_q7
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbg}.05_summext AS sumx ON summ.scid=sumx.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
		WHERE cr.level_id=$lvl AND cr.section_id>2 ORDER BY summ.ave_q7 DESC; ";
	// pr("&deciave=$deciave");
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"ranktools/viewAveTwoSemsRanktools");


} 	/* fxn */

public function updateAveTwoSems($params=NULL){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$data['lvl']=$lvl=isset($params[0])? $params[0]:14;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['level']=$level=fetchRow($db,"{$dbo}.05_levels",$lvl);
	$dbg=VCPREFIX.$sy.US.DBG;
	$data['lvl']=$lvl=isset($params[0])? $params[0]:14;
	$data['deciave']=$deciave=isset($_GET['deciave'])? $_GET['deciave']:$_SESSION['settings']['deciave'];	
	$q="UPDATE {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		SET summ.ave_q7=round((round(summ.ave_q5,$deciave)+round(summ.ave_q6,$deciave))/2,$deciave)
		WHERE cr.level_id=$lvl; ";
	pr("&deciave=$deciave");
	debug($q);
	$sth=$db->query($q);echo ($sth)? "Success":"Fail";
	
}	/* fxn */





}	/* BlankController */
