<?php

Class StatsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){
	include_once(SITE.'views/elements/params_sq.php');	
	$this->view->render($data,'stats/indexStats');
}	/* fxn */



public function popn($params=NULL){		/* student population in any given sy */
$dbo=PDBO;
require_once(SITE.'views/customs/'.VCFOLDER.'/customs.php');	
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$db=&$this->model->db;
$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;	
$condsy=($sy==DBYR)? " AND c.`sy`<>'".($sy+1)."'":NULL;
$paidcond=" AND cr.is_free=0 ";
$dq="";
$q="SELECT count(summ.scid) AS total 
FROM {$dbg}.05_summaries AS summ
LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
WHERE c.role_id='".RSTUD."' AND cr.section_id>2 $condsy $paidcond ; ";		
if(isset($_GET['debug'])){ $dq.="Summer: <br />".$q."<br />"; }
$sth=$db->querysoc($q);
$data['row']=$sth->fetch();
$data['summer']=$summer=$data['row']['total'];

/* 2 */
$q=" 
SELECT count(summ.scid) AS `count`,l.name AS level
FROM {$dbg}.05_summaries AS summ
LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
LEFT JOIN {$dbo}.`05_levels` AS l ON l.id=cr.level_id
WHERE (cr.section_id>2 $paidcond ";	/* sxn02 out */
$q .= " AND c.role_id='".RSTUD."' $condsy )
	GROUP BY cr.level_id ORDER BY cr.level_id ; 
";
if(isset($_GET['debug'])){ $dq.=$q; }
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$data['rows']=$rows;
$data['count']=count($rows);
$data['num_paid']=&$data['count'];
$data['dq']=$dq;

/* 3 */
$freecond=" cr.is_free=1 ";
$q=" 
SELECT count(summ.scid) AS `count`,l.name AS level
FROM {$dbg}.05_summaries AS summ
LEFT JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
LEFT JOIN {$dbo}.`05_levels` AS l ON l.id=cr.level_id
WHERE ($freecond ";	/* sxn02 out */
$q .= " AND c.role_id='".RSTUD."' $condsy )
	GROUP BY cr.level_id ORDER BY cr.level_id ; 
";
if(isset($_GET['debug'])){ $dq.=$q; }
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$data['freerows']=$rows;
$data['freecount']=count($rows);


$this->view->render($data,'stats/popn');

}	/* fxn */



public function noloads(){
$dbo=PDBO;
$db=&$this->model->db;
$dbg=PDBG;

$q="
	SELECT 
		crs.id AS crsid,cr.name AS classroom,sub.name AS subject
	FROM {$dbg}.05_courses AS crs
		LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id		
	WHERE crs.tcid<1 ORDER BY cr.level_id,sub.name;
";
$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=$count=count($rows);

$this->view->render($data,'stats/noloads');

}	/* fxn */





















}	/* StatsController */
