<?php

Class DupesController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	echo "Dupes index";

}	/* fxn */


public function studcavs($params){
	require_once(SITE."functions/dupes.php");
	$scid=$params[0];
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
	
	$row=getStudcavsRow($db,$scid);
	$crs=$row['crs'];
	
	
	$q="SELECT
			g.id AS gid,crs.crid,cri.id AS criteria_id,cri.name AS criteria
		FROM {$dbg}.50_grades AS g 
			LEFT JOIN {$dbg}.05_courses AS crs ON g.course_id=crs.id
			LEFT JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id=cri.id
		WHERE g.scid='$scid' AND crs.crstype_id='".CTYPETRAIT."'
		ORDER BY crs.crid,cri.id;
	";
	
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=$rows;
	$data['row']=$row;
	$data['count']=count($rows);
	
	$q="SELECT count(id) AS count FROM {$dbg}.50_grades;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	pr($row);
	
	$this->view->render($data,'dupes/studcavs');
	
	

}	/* fxn */


public function cleanCridcavs($params){
	require_once(SITE."functions/dupes.php");
	$crid=$params[0];
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;

	$q="DELETE g FROM {$dbg}.50_grades AS g 
		INNER JOIN {$dbg}.05_courses AS crs ON crs.id=g.course_id 
		INNER JOIN 
		(
			SELECT summ.scid AS scid 			
			FROM {$dbg}.05_summaries AS summ WHERE summ.crid='$crid'
		) AS a ON a.scid = g.scid
		WHERE crs.crstype_id='".CTYPETRAIT."' AND crs.crid<>'$crid' 
		";
	pr($q);
	echo "Get exe to execute.";
	if(isset($_GET['exe'])){ $db->query($q); echo "<h3>Purged duplicate Crid Cavs.</h3>"; }


}	/* fxn */



public function cridcavs($params){
	require_once(SITE."functions/dupes.php");
	$crid=$params[0];
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;

	$q="SELECT id,name,level_id FROM {$dbg}.05_classrooms WHERE id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['cr']=$sth->fetch();
	
	$q="SELECT 
			g.id AS gid,crs.crid,g.scid,g.criteria_id,cri.name AS criteria,a.student
		FROM {$dbg}.50_grades AS g 
		INNER JOIN {$dbg}.05_courses AS crs ON crs.id=g.course_id 
		INNER JOIN 
		(
			SELECT summ.scid AS scid,c.name AS student
			FROM {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
			
			WHERE summ.crid='$crid'
		) AS a ON a.scid = g.scid
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id=cri.id
		WHERE crs.crstype_id='".CTYPETRAIT."' AND crs.crid<>'$crid' 
		";
	// pr($q);
	if(isset($_GET['debug'])){ $data['q']=$q; }
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=$rows;
	$data['count']=count($rows);
	$this->view->render($data,"dupes/cridcavs");


}	/* fxn */



public function lvlcavs($params){
	$data['lvl']=$lvl=$params[0];
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;

	$q="SELECT id,name FROM {$dbo}.`05_levels` WHERE id='$lvl' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['lvlrow']=$sth->fetch();
	
	
	$q="SELECT 
			g.q1,g.id AS gid,crs.crid,g.scid,g.criteria_id,cri.name AS criteria,a.student
		FROM {$dbg}.50_grades AS g 
		INNER JOIN {$dbg}.05_courses AS crs ON crs.id=g.course_id 
		INNER JOIN 
		(
			SELECT summ.scid AS scid,c.name AS student,summ.crid
			FROM {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id			
			WHERE cr.level_id='$lvl'
		) AS a ON a.scid = g.scid
		LEFT JOIN {$dbo}.`05_criteria` AS cri ON g.criteria_id=cri.id
		WHERE crs.crstype_id='".CTYPETRAIT."' AND crs.crid<>a.crid 
		";
	// pr($q);
	if(isset($_GET['debug'])){ $data['q']=$q; }
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['rows']=$rows;
	$data['count']=count($rows);
	$this->view->render($data,"dupes/lvlcavs");


}	/* fxn */


public function purgeLvlcavs($params){
	require_once(SITE."functions/dupes.php");
	$lvl=$params[0];
	$db=&$this->model->db;
	$dbo=PDBO;$dbg=PDBG;$dbg=PDBG;
		
	$q="DELETE g FROM {$dbg}.50_grades AS g 
		INNER JOIN {$dbg}.05_courses AS crs ON crs.id=g.course_id 
		INNER JOIN 
		(
			SELECT summ.scid AS scid,summ.crid 			
			FROM {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id			
			WHERE cr.level_id='$lvl'			
		) AS a ON a.scid = g.scid
		WHERE crs.crstype_id='".CTYPETRAIT."' AND crs.crid<>a.crid 
		";
	pr($q);
	echo "Get exe to execute.";
	if(isset($_GET['exe'])){ $db->query($q); echo "<h3>Purged duplicate Lvl Cavs.</h3>"; }


}	/* fxn */




}	/* BlankController */
