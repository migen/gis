<?php

Class PromlevelsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	// parent::beforeFilter();

	$acl = array(array(5,0));
	$this->permit($acl,false);		
	
}	/* fxn */


public function index($params=NULL){	
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['sy']=DBYR;	
	$data['dbg']=$dbg=PDBG;
	
	pr('promlevels');
//	$this->view->render($data,"abc/index");

}	/* fxn */


public function year($params=NULL){	/* promoteAll */
	/* 20210415 */
	pr('20210415');	
	$db=&$this->baseModel->db;
	$sy=isset($params[0])?$params[0]:DBYR;
	$nsy=$sy+1;
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;

	
	/* debug sample */
	$q="
		SELECT 
			c.name,summ.crid,cr.level_id,(cr.level_id+1) AS nextlvl,ncr.id AS ncrid
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.00_contacts AS c ON summ.scid=c.id
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		INNER JOIN {$dbg}.05_classrooms AS ncr ON ncr.section_id=1 && ncr.level_id=(cr.level_id+1)
		WHERE summ.scid=2233;
	";
	if(isset($_GET['debug'])){
		pr($q);
		$sth=$db->querysoc($q);
		$row=$sth->fetch();	
		pr($row);
		echo "<hr>";		
	} else {
		pr("&debug");
	}
	
	//-------------------------------
	
	if(!isset($_GET['exe'])){ pr("&exe"); }	
	pr("process1: reset is_promoted");
	/* process */
	$q1="UPDATE {$dbg}.05_summaries SET is_promoted=1; ";
	pr($q1);
	
	pr("process2: update promlvl");
	/* process */
	$q2="
		UPDATE {$dbg}.05_summaries AS a 
		INNER JOIN (
			SELECT 
				summ.scid,summ.crid,cr.level_id,(cr.level_id+1) AS nextlvl,ncr.id AS ncrid
			FROM {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbg}.05_classrooms AS ncr ON ncr.section_id=1 && ncr.level_id=(cr.level_id+1)		
			WHERE cr.section_id>2 AND summ.is_promoted=1
		) AS b ON a.scid=b.scid
		SET a.promlvl=b.nextlvl,a.promcrid=b.ncrid;		
	";	
	pr($q2);	
	if(isset($_GET['exe'])){
		$sth=$db->query($q1);
		echo "Reset is_promoted - ";
		echo ($sth)? "Success":"Fail";
		
		echo "<br>";
		
		$sth=$db->query($q2);
		echo "Promote all - ";
		echo ($sth)? "Success":"Fail";
		
		echo "<br> Please remove &exe";
	}
	



	
	
}	/* fxn */




}	/* BlankController */
