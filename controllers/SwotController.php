<?php

Class SwotController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	$lvl=4;
	$db=&$this->baseModel->db;
	$dbg=PDBG;$dbo=PDBO;
	
	$q="SELECT l.* FROM {$dbo}.`05_levels` AS l 
		WHERE l.id='$lvl' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['lrow']=$sth->fetch();
	
	$q="SELECT s.* FROM {$dbo}.`05_subjects` AS s 
		WHERE s.id='1' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['subrow']=$sth->fetch();
	


	

	$this->view->render($data,'swot/indexSwot');
	
	
}	/* fxn */


public function student($params=NULL){
$dbo=PDBO;
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['sy'];
	$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;		
	
if($scid):	
	$q="
		SELECT summ.scid,c.name,c.code,
			cr.level_id,cr.name AS classroom
		FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE c.id='$scid' LIMIT 1; 		
	";
	$sth=$db->querysoc($q);	
	$data['student']=$student=$sth->fetch();
	$data['lvl']=$lvl=$student['level_id'];
	
	
	$order="`grade` DESC";
	if($lvl<14){
		if($qtr<4){ $order=$order;			
		} else { $order="g.q5 DESC"; }		
	} else {
		if($qtr<4){
			$order=$order; } else { $order="g.q5 DESC,q6 DESC"; }		
	}
	/* 2 grades */
	$q="SELECT
			crs.name AS course,crs.label AS subject,g.q{$qtr} AS grade,
			g.q1,g.q2,g.q3,g.q4,g.q5,g.q6,crs.semester AS sem
		FROM {$dbg}.50_grades AS g
		LEFT JOIN {$dbg}.05_courses AS crs ON crs.id=g.course_id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON sub.id=crs.subject_id
		WHERE
			crs.crstype_id='".CTYPEACAD."' AND crs.is_num='1' AND 			
			g.scid='$scid' ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	
	
endif;	/* scid */
	
	
	$this->view->render($data,"swot/studentSwot");
	
}	/* fxn */


public function crid($params=NULL){
	$crid=1;
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbg=PDBG;
	$qtr=$_SESSION['qtr'];
	
	$q="
		SELECT cr.name
		FROM {$dbg}.05_classrooms AS cr 
		WHERE cr.id='$crid' LIMIT 1;
	";
	$sth=$db->querysoc($q);
	$data['classroom']=$sth->fetch();

	/* 2 */
	$q="
		SELECT
			crs.label AS subject,g.q{$qtr} AS grade,c.name AS student
		FROM {$dbg}.50_grades AS g
		LEFT JOIN {$dbo}.`00_contacts` AS c ON g.scid=c.id 		 
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id 		 
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id 		 
		WHERE crs.crstype_id='".CTYPEACAD."' AND crs.is_num='1' AND
			cr.id='$crid'
		GROUP BY (AVG(g.course_id)) 			
		ORDER BY g.q{$qtr} DESC LIMIT 30;				
	";
	
	$q="
		SELECT
			crs.label AS subject,g.q{$qtr} AS grade,c.name AS student
		FROM {$dbg}.50_grades AS g
		LEFT JOIN {$dbo}.`00_contacts` AS c ON g.scid=c.id 		 
		LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id 		 
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id 		 		
		WHERE crs.crstype_id='".CTYPEACAD."' AND crs.is_num='1' AND
			cr.id='$crid'
		GROUP BY (g.q{$qtr})
		ORDER BY g.q{$qtr} DESC LIMIT 30;					
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	

	$this->view->render($data,"swot/cridSwot");
	
	
	
}	/* fxn */






}	/* BlankController */
