<?php

Class StudyearsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();
	

}

public function index(){
	
	$data="Studyears";	
	$this->view->render($data,'abc/defaultAbc');
}	/* fxn */



public function links($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$_SESSION['qtr'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
	$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
	$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
	$data['current']=($sy==DBYR)? true:false;
	$db=&$this->model->db;

	include_once(SITE.'views/elements/dbsch.php');
	
	if($scid){
		$q="SELECT c.id,c.code,c.name,summ.crid,c.`sy` AS csy,cr.name AS classroom,cr.level_id 
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
			WHERE c.`id`='$scid' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row1=$sth->fetch();
		$row2=array();
		$row=array_merge($row1,$row2);
		$data['row']=&$row;		
		
	}
	
	$view=isset($_GET['sch'])? "students/linksSch":"students/linksStudents";	
	$this->view->render($data,$view);
}	/* fxn */



public function view($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$_SESSION['qtr'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
	$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
	$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
	$data['current']=($sy==DBYR)? true:false;
	$db=&$this->baseModel->db;

	// include_once(SITE.'views/elements/dbsch.php');
	
	if($scid){
		$q="SELECT c.name AS student,c.code,c.name,c.begsy,c.endsy,c.`sy` AS csy,
				cr.name AS classroom,summ.crid
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
			WHERE c.`id`='$scid' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();		
		$data['row']=&$row;
		
	}	/* scid */
	
	$vfile="studyears/viewStudyears";	
	vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */


public function edit($params=NULL){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['qtr']=$_SESSION['qtr'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	$first_year = ($sy>$_SESSION['settings']['sy_beg'])? false:true;
	$pdbg=($first_year)? PDBG:VCPREFIX.($sy-1).US.DBG;
	$data['prevsy']=$prevsy=($first_year)? $sy:$sy-1;
	$data['current']=($sy==DBYR)? true:false;
	$db=&$this->baseModel->db;

	// include_once(SITE.'views/elements/dbsch.php');
	
	if(isset($_POST['submit'])){
		// pr($_POST);
		$post=$_POST['post'];
		$db->update("{$dbo}.`00_contacts`",$post,"id='$scid'");
		flashRedirect("studyears/view/$scid","Student Years updated.");
		exit;
		
	}	/* post */
	
	if($scid){
		$q="SELECT c.name AS student,c.code,c.name,c.begsy,c.endsy,c.`sy` AS csy,
				cr.name AS classroom,summ.crid
			FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id 
			WHERE c.`id`='$scid' LIMIT 1; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();		
		$data['row']=&$row;
		
	}	/* scid */
	
	$vfile="studyears/editStudyears";	
	vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */


public function crid($params=NULL){
	$crid=$params[0];
	$db=&$this->baseModel->db;
	$dbo=PDBO;$dbg=PDBG;
	$order=$_SESSION['settings']['classlist_order'];
	
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$q="";
		foreach($posts AS $post){
			$begsy=$post['begsy'];
			$endsy=$post['endsy'];
			$scid=$post['scid'];
			$q.="UPDATE {$dbo}.`00_contacts` SET `begsy`='$begsy',`endsy`='$endsy' WHERE id='$scid' LIMIT 1; ";			
		}
		$db->query($q);
		flashRedirect("studyears/crid/$crid","Updated Student Years.");
		exit;
		
		
	} 	/* post */
	
	$q="
		SELECT c.id AS scid,c.code AS studcode,c.name AS student,c.begsy,c.endsy
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE summ.crid='$crid' ORDER BY $order;		
	";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"studyears/cridStudyears");
	
	
	
}	/* fxn */


public function scid($params=NULL){
	if(!isset($params)){ pr("scid NOT set"); exit; }
	$data['scid']=$params[0];
	$data['begsy']=$begsy=$_SESSION['settings']['sy_beg'];
	$data['endsy']=$endsy=DBYR;
	
	for($i=$begsy;$i<=$endsy;$i++){
		// pr($i);
		$q="SELECT
			FROM {$dbg}.05_summaries 
		";
		
		
	}
	
	
	

	
}	/* fxn */







}	/* BlankController */
