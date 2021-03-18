<?php

Class SyController extends Controller{	

public function __construct(){
	parent::__construct();			
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$acl = array(array(5,0),array(9,0));
	$this->permit($acl,false);		
	
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	echo "School Year";
	$this->view->render($data,'tests/index');

}	/* fxn */


public function level($params=NULL){
	// if(!isset($params[0])){ prx("Level ID parameter required.");}
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="SELECT c.id AS scid,c.code,c.account,c.sy,c.name,cr.name AS classroom 
		FROM {$dbo}.00_contacts AS c  
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE cr.level_id=$lvl 
		ORDER BY cr.section_id,c.name;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$data['level']=fetchRow($db,"{$dbo}.05_levels",$lvl);	
	$data['levels']=$_SESSION['levels'];
		
	$this->view->render($data,"sy/levelSy");
	
	
}	/* fxn */



public function test($params=NULL){
	// if(!isset($params[0])){ prx("Level ID parameter required.");}
	// $data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	// $data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="SELECT c.id AS scid,c.code,c.account,c.sy,c.name,cr.name AS classroom 
		FROM {$dbo}.00_contacts AS c  
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE (c.code LIKE '2020%' OR c.sy=2020)
		ORDER BY c.code,c.name 
		;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	debug($data['rows'][0]);
	
/* UPDATE myTable mt1, myTable mt2 
SET mt1.postdate = SUBSTRING_INDEX(mt2.postdatetime," " ,1)
WHERE mt1.id = mt2.id */

	$dbtable="{$dbo}.00_contacts";	
	$q="UPDATE $dbtable SET sy=LEFT(code,4);";	
	pr($q);
	if(isset($_GET['exe'])){ $db->query($q); }
		
/* 	
	$q="SELECT id,code,name,left(code,4) AS leftcode FROM $dbtable where role_id=1 limit 5; ";	
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	pr($rows);
 */		
	$this->view->render($data,"sy/testSy");
	
	
}	/* fxn */




}	/* TpaysController */
