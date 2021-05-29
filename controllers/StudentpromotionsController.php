<?php

Class StudentpromotionsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	// parent::beforeFilter();

	$acl = array(array(5,0),array(9,0));
	$this->permit($acl,false);		
	
}	/* fxn */


public function index($params=NULL){	
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['sy']=DBYR;	
	$data['dbg']=$dbg=PDBG;
	
	pr('studentpromotions');
	
	$this->view->render($data,"abc/index");

}	/* fxn */


public function year($params=NULL){
	$db=&$this->baseModel->db;
	$data['scid']=$scid=isset($params[0])?$params[0]:false;
	$data['sy']=$sy=isset($params[1])?$params[1]:DBYR;
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	
	if(isset($_POST['submit'])){
		$is_promoted=($_POST['is_promoted']==1)? true:false;
		$q="UPDATE {$dbg}.05_summaries SET is_promoted = ".$_POST['is_promoted']." WHERE scid=$scid LIMIT 1;";
		$sth=$db->query($q);
		$msg=($sth)? "Update success":"Update failed";
		
		// pr($q);

		/* 2 */
		if($is_promoted){
			$q="
				UPDATE {$dbg}.05_summaries AS a 
				INNER JOIN (
					SELECT 
						summ.scid,summ.crid,cr.level_id,(cr.level_id+1) AS nextlvl,ncr.id AS ncrid
					FROM {$dbg}.05_summaries AS summ 
					INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
					INNER JOIN {$dbg}.05_classrooms AS ncr ON ncr.section_id=1 && ncr.level_id=(cr.level_id+1)		
				) AS b ON a.scid=b.scid
				SET a.promlvl=b.nextlvl,a.promcrid=b.ncrid
				WHERE a.scid=$scid;		
			";						
		} else {
			$q="
				UPDATE {$dbg}.05_summaries AS a 
				INNER JOIN (
					SELECT 
						summ.scid,summ.crid,cr.level_id,(cr.level_id) AS nextlvl,ncr.id AS ncrid
					FROM {$dbg}.05_summaries AS summ 
					INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
					INNER JOIN {$dbg}.05_classrooms AS ncr ON ncr.section_id=1 && ncr.level_id=(cr.level_id)						
				) AS b ON a.scid=b.scid
				SET a.promlvl=b.nextlvl,a.promcrid=b.ncrid
				WHERE a.scid=$scid;		
			";						
		}
		
		$sth=$db->querysoc($q);
		$msg = ($sth)? "success":"fail";
		flashRedirect("studentpromotions/year/$scid/$sy",$msg);		
		
	}	/* post */
	
	if($scid){
		$q="SELECT c.name AS studname,c.code AS studcode,summ.scid,summ.is_promoted,cr.name AS classroom
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE c.id=$scid LIMIT 1;
		";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();

		
		if($row['is_promoted']){
			$q="SELECT ncr.name AS nextclassroom
				FROM {$dbg}.05_summaries AS summ 
				INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
				INNER JOIN {$dbg}.05_classrooms AS ncr ON ncr.section_id=1 && ncr.level_id=(cr.level_id+1) 
				WHERE summ.scid=$scid LIMIT 1;";			
		} else {
			$q="SELECT ncr.name AS nextclassroom
				FROM {$dbg}.05_summaries AS summ 
				INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id=summ.crid
				INNER JOIN {$dbg}.05_classrooms AS ncr ON ncr.section_id=1 && ncr.level_id=(cr.level_id) 
				WHERE summ.scid=$scid LIMIT 1;";			
		}
		$sth=$db->querysoc($q);
		$row2=$sth->fetch();

		$data['row']=array_merge($row,$row2);
		
		
		
	}
	
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"studentpromotions/yearStudentPromotions");	
	
	
	
}	/* fxn */





}	/* BlankController */
