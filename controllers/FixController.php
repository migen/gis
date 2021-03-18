<?php

Class FixController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	

	$data="Fix";$this->view->render($data,'abc/defaultAbc');
	
}	/* fxn */


public function lsa($params=NULL){
	// levelSingleAggregates	
	
	$db=&$this->baseModel->db;$dbg=PDBG;$dbo=PDBO;
	// ps = parent subject, cs = child subject
	$sy=$_SESSION['sy'];
	$data['qtr']=$qtr=isset($_GET['qtr'])? $_GET['qtr']:$_SESSION['qtr'];
	
	$data['ps']=$ps=isset($params[0])? $params[0] : 80;
	$data['cs']=$cs=isset($params[1])? $params[1] : 67;
	$data['lvl']=$lvl=isset($params[2])? $params[2] : 4;

	$data['levels']=$_SESSION['levels'];
	
	
	// 1
	if(isset($_POST['submit'])){
		// pr($_POST['posts']);
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$gid=$post['gid']; 
			$grade=$post['grade']; 
			$q.="UPDATE {$dbg}.50_grades SET q{$qtr}=$grade WHERE id=$gid LIMIT 1;";			
		}
		// pr($q);exit;
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Fail";
		flashRedirect("fix/lsa/$ps/$cs/$lvl?qtr=$qtr",$msg);		
		exit;
	}
	
	
	
	// 2
	$q="SELECT id,code,name FROM {$dbo}.`05_subjects` WHERE id=$ps LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['mom']=$mom=$sth->fetch();

	$q="SELECT id,code,name FROM {$dbo}.`05_subjects` WHERE id=$cs LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['kid']=$mom=$sth->fetch();

	$q="SELECT id,code,name FROM {$dbo}.`05_levels` WHERE id=$lvl LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['level']=$level=$sth->fetch();


	// 3
	$q="SELECT c.id AS scid,c.name AS student,g.q{$qtr} AS grade,cr.id AS crid,g.id AS gid
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON c.id = summ.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id = summ.crid
		INNER JOIN {$dbo}.`05_levels` AS l ON l.id = cr.level_id
		INNER JOIN {$dbg}.50_grades AS g ON c.id = g.scid
		INNER JOIN {$dbg}.05_courses AS crs ON crs.id = g.course_id		
		WHERE cr.level_id = $lvl AND crs.subject_id = $ps
		ORDER BY cr.id, c.name;
	";
	
	$sth=$db->querysoc($q);
	$data['moms']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	

	$q="SELECT c.id AS scid,c.name AS student,g.q{$qtr} AS grade,cr.id AS crid
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON c.id = summ.scid
		INNER JOIN {$dbg}.05_classrooms AS cr ON cr.id = summ.crid
		INNER JOIN {$dbo}.`05_levels` AS l ON l.id = cr.level_id
		INNER JOIN {$dbg}.50_grades AS g ON c.id = g.scid
		INNER JOIN {$dbg}.05_courses AS crs ON crs.id = g.course_id		
		WHERE cr.level_id = $lvl AND crs.subject_id = $cs
		ORDER BY cr.id, c.name;
	";
	
	$sth=$db->querysoc($q);
	$data['kids']=$sth->fetchAll();
	$data['kids_count']=$sth->rowCount();

	
	
	$this->view->render($data,"fix/lsaFix");
	
 	
	
}	/* fxn */



}	/* BlankController */
