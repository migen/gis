<?php

Class CollcrsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	
	$data="Collcrs";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */


public function mgr($params=NULL){
	// echo "Collcrs mgr";
	$data['major_id']=$major_id=isset($params[0])? $params[0]:false;
	$dbo=PDBO;$dbg=PDBG;
	$db=&$this->baseModel->db;
	$cond=($major_id)? "AND cr.num='$major_id'":NULL;
	$q="
		SELECT c.*,s.*,c.name AS course
			FROM {$dbo}.00_courses AS c
			LEFT JOIN {$dbo}.00_subjects AS s ON c.subject_id=s.id
			LEFT JOIN {$dbo}.00_classrooms AS cr ON c.crid=cr.id
		WHERE 1=1 $cond ORDER BY cr.num,s.code;	
			
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();


	$this->view->render($data,"collcrs/mgrCollcrs");
  	
}	/* fxn */


public function saveName($params=NULL){
	$db=$this->baseModel->db;
	$dbo=PDBO;
	$q="
		UPDATE {$dbo}.00_courses AS c
		INNER JOIN {$dbo}.00_subjects AS s ON c.subject_id=s.id
		LEFT JOIN {$dbo}.00_classrooms AS cr ON c.crid=cr.id
		LEFT JOIN {$dbo}.00_majors AS m ON cr.num=m.id
		SET c.name=CONCAT(m.code,'-',s.name);
		
	";
	pr($q);
	$sth=$db->query($q);
	echo ($sth)? "Success":"Fail";
	

	
}	/* fxn */









}	/* BlankController */
