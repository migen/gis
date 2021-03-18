<?php

Class EnrolleesController extends Controller{	

public $db;
public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	$this->db=$this->baseModel->db;

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbg=PDBG;$dbo=PDBO;	
	$data['sy']=DBYR;
	$this->view->render($data,"enrollees/indexEnrollees");
	
	
}	/* fxn */


public function current($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$order=isset($_GET['order'])? $_GET['order']:"l.id,s.id,c.is_male DESC,c.name";
	$data['last_school']=$last_school=isset($_GET['last_school'])? true:false;
	$q=" SELECT c.id AS scid,summ.crid,cr.name AS classroom,c.code AS studcode,c.name AS student,l.name AS level,s.name AS section ";
	if($last_school){ $q.=",st.last_school "; } 
	$q.=" FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id 
		LEFT JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id ";	
	if($last_school){ $q.=" LEFT JOIN {$dbg}.05_students AS st ON st.contact_id=c.id  "; }	
	$q.=" WHERE c.`sy`='$sy' AND c.is_active=1 ORDER BY $order;";
	debug($q);
	$sth=$this->db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$this->view->render($data,'enrollees/currentEnrollees');
	

}	/* fxn */



public function official($params=NULL){
	$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['settings']['sy_enrollment'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	$order=isset($_GET['order'])? $_GET['order']:"cr.level_id,cr.section_id,c.is_male DESC,c.name";
	// AND p.feetype_id=1
	$q="SELECT 
			c.id AS scid,c.code AS studcode,c.name AS student,pr.birthdate,
			sum(p.amount) AS amount,summ.crid,cr.name AS classroom
		FROM {$dbo}.00_contacts AS c 
		LEFT JOIN {$dbo}.00_profiles AS pr ON pr.contact_id=c.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
		LEFT JOIN {$dbo}.30_payments AS p ON p.scid=c.id 
		WHERE p.sy=$sy AND summ.crid>0 
		GROUP BY p.scid 
		ORDER BY $order;";	
	debug($q);
	$sth=$this->db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	$vfile="enrollees/officialEnrollees";
	// $Vfile="enrollees/officiallyEnrolled";
	
	$this->view->render($data,$vfile);
	

}	/* fxn */





}	/* BlankController */
