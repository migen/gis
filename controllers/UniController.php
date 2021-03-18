<?php

Class UniController extends Controller{	

public function __construct(){
	parent::__construct();			
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$needs_js=array('index');	
	if($this->only($needs_js)){ $this->view->js = array('js/jquery.js','js/vegas.js'); }	
	parent::beforeFilter();

}	/* fxn */


public function index(){	
$dbo=PDBO;
	$data="Universities and Colleges";	
	$this->view->render($data,'uni/indexUni');
}	/* fxn */


public function tables(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.00_tables ORDER BY `pos`,`index`,`table`; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();	
	$this->view->render($data,"uni/tablesUni");	
}	/* fxn */



public function prereq(){
	$db=&$this->baseModel->db;$dbo=PDBO;	
/* 	1) subjects - id,name
	2) prerequisites - id, presubject_id, subject_id */	
	$q="SELECT pr.*, s.name AS subject,ps.name AS prereq
		FROM {$dbo}.00_prerequisites AS pr 
		LEFT JOIN {$dbo}.00_subjects AS s ON pr.subject_id = s.id
		LEFT JOIN {$dbo}.00_subjects AS ps ON pr.parent_id = ps.id
		ORDER BY s.name; ";
	debug($q);$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$vfile="uni/prereqUni";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */


public function baid(){
	$db=&$this->baseModel->db;$dbo=PDBO;	
				
	$q2="SELECT id,book_id AS book, GROUP_CONCAT(DISTINCT author_id ORDER BY author_id) AS authors
		FROM {$dbo}.00_books_authors GROUP BY book_id ORDER BY book_id; ";	
		
	$q="
		SELECT ba.id,b.name AS book,GROUP_CONCAT(a.name ORDER BY a.name SEPARATOR ',' ) AS authors
		FROM {$dbo}.00_books_authors AS ba 
		LEFT JOIN {$dbo}.00_books AS b ON ba.book_id=b.id
		LEFT JOIN {$dbo}.00_authors AS a ON ba.author_id=a.id
		GROUP BY ba.book_id ORDER BY b.name;
	";		
	debug($q);$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$vfile="uni/baidUni";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */



public function cpr(){	/* course prerequisites */
	$db=&$this->baseModel->db;$dbo=PDBO;	
/* 	
	1) courses - id,subject_id,crid,tcid,name
	2) subjects - id,name
	3) prerequisites - id, presubject_id, subject_id */	
	$q="SELECT c.name AS course,c.*,pr.*, 
			GROUP_CONCAT(ps.name ORDER BY ps.name SEPARATOR ', ') AS prerequisite_list,
			s.code AS subject_code,s.name AS subject		
		FROM {$dbo}.00_courses AS c
		LEFT JOIN {$dbo}.00_subjects AS s ON c.subject_id = s.id		
		LEFT JOIN {$dbo}.00_prerequisites AS pr ON pr.subject_id = s.id
		LEFT JOIN {$dbo}.00_subjects AS ps ON pr.parent_id = ps.id
		GROUP BY c.subject_id ORDER BY s.name; ";
	debug($q);$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$vfile="uni/cprUni";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */









}	/* BlankController */
