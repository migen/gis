<?php

Class CrsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
	$dbo=PDBO;
	$data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */

public function crid($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:1;
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	$data['sy']=$_SESSION['sy'];
	$data['qtr']=$_SESSION['qtr'];
	$q="SELECT cr.*,sxn.name AS section,c.name AS adviser 
		FROM {$dbg}.05_classrooms AS cr 
		INNER JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id=sxn.id
		INNER JOIN {$dbo}.`00_contacts` AS c ON cr.acid=c.id
		WHERE cr.id='$crid' LIMIT 1; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['cr']=$sth->fetch();
	
	$q="SELECT crs.*,crs.label AS crslabel,crs.code AS crscode,crs.name AS course,crs.id AS crs,
		sub.id AS subid,sub.name AS subject,	
		c.name AS teacher
	FROM {$dbg}.05_courses AS crs 
	INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
	INNER JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
	WHERE crs.crid='$crid' AND crs.is_active=1 ORDER BY crs.semester,crs.position; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	/* count-crs */
	$q="SELECT count(crs.id) AS ct FROM {$dbg}.05_courses AS crs 
		WHERE crs.crid='$crid' AND crs.is_active=1 AND crs.semester=0; ";
	debug($q);
	$sth=$db->querysoc($q);
	$d=$sth->fetch();
	$data['count_sem0']=$d['ct'];
	
	$q="SELECT count(crs.id) AS ct FROM {$dbg}.05_courses AS crs 
		WHERE crs.crid='$crid' AND crs.is_active=1 AND crs.semester=1; ";
	debug($q);
	$sth=$db->querysoc($q);
	$d=$sth->fetch();
	$data['count_sem1']=$d['ct'];
	
	$q="SELECT count(crs.id) AS ct FROM {$dbg}.05_courses AS crs 
		WHERE crs.crid='$crid' AND crs.is_active=1 AND crs.semester=2; ";
	$sth=$db->querysoc($q);
	$d=$sth->fetch();
	debug($q);
	$data['count_sem2']=$d['ct'];
	$vfile="crs/cridCrs";vfile($vfile);	
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function finder(){	
	$data=NULL;
	$this->view->render($data,"crs/finderCrs");
	
}	/* fxn */



public function edit($params){
	$dbo=PDBO;
	require_once(SITE.'functions/crsFxn.php');
	require_once(SITE.'functions/dbFxn.php');
	$data['crs']=$crs=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	/* 1 */
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbg}.05_courses",$post,"id='$crs'");
		flashRedirect("crs/edit/$crs","Saved.");exit;		
	}	/* post */
		
	/* 2 */
	// $data['row']=getCourseData($db,$dbg,$crs);
	$data['row']=getCourseInfo($db,$dbg,$crs);
	$vfile="crs/editCrs";
	vfile($vfile);
	
	/* 3 */
	$schema=$dbg;$table="05_courses";
	$data['columns']=getDbtableColumns($db,$schema,$table);
	$data['columns_array']=explode(",",$data['columns']);
	
	$this->view->render($data,$vfile);
	
}	/* fxn */






}	/* BlankController */
