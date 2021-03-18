<?php

Class UnisubjectsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
	$db=&$this->baseModel->db;$dbg=PDBG;$data="unisubjects";	
	$this->view->render($data,"unisubjects/indexUnisubjects");
}	/* fxn */


public function all(){	
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	// if(!isset($_SESSION['prerequisites'])){ 
		require_once(SITE.'functions/prerequisitesFxn.php');
		$d=getPrerequisites($db,$dbg); 
		$_SESSION['prerequisites']=$d['rows'];
		$_SESSION['num_prerequisites']=$d['count'];
	// } 
	
	$data['rows']=$_SESSION['prerequisites'];		
	$data['count']=$_SESSION['num_prerequisites'];		
	
	
	$this->view->render($data,"unisubjects/allUnisubjects");
}	/* fxn */


public function create(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
		
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			if(!empty($post['name'])){
				$db->createIfNotExists("{$dbo}.`05_subjects`",$post);
			}			
		}	/* foreach */		
		flashRedirect("unisubjects","College Subjects added.");
		exit;
		
	}	/* post */
	
	if(!isset($_SESSION['prerequisites'])){ 
		require_once(SITE.'functions/prerequisitesFxn.php');$d=getPrerequisites($db,$dbg); 
		$_SESSION['prerequisites']=$d['rows'];$_SESSION['num_prerequisites']=$d['count'];
	} 	
	$data['rows']=$_SESSION['prerequisites'];	
		
	$this->view->render($data,"unisubjects/createUnisubjects");
	
}	/* fxn */



public function edit($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ echo "Parameter subject id NOT set."; exit; }
	$data['sub']=$sub=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbo}.`05_subjects`",$post,"id='$sub'");
		flashRedirect("unisubjects/edit/$sub","Saved.");
	}	/* post */
	$q="SELECT * FROM {$dbo}.`05_subjects` WHERE `id`='$sub' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	$this->view->render($data,"unisubjects/editUnisubject");
	
}	/* fxn */


public function reset(){
$dbo=PDBO;
	unset($_SESSION['prerequisites']);
	flashRedirect("unisubjects","Subjects reset.");
	// require_once(SITE.'functions/uniclassroomsFxn.php');
	// $db=&$this->baseModel->db;$dbg=PDBG;
	// $_SESSION['unisubjects']=fetchRows($db,"{$dbo}.`05_subjects`","*","name");
	
	
}	/* fxn */


public function crs($params=NULL){
	$data['sub']=$sub=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$data['subject']=fetchRow($db,"{$dbo}.`05_subjects`",$sub,"id,name");
	/* 2 */
	$q="SELECT crs.*,sub.name AS subject,crs.name AS course,crs.id AS crs,sub.id AS sub,c.name AS teacher,cr.code AS crcode
		FROM {$dbg}.01_courses AS crs 
		INNER JOIN {$dbo}.`05_subjects` AS sub ON crs.subject_id=sub.id
		INNER JOIN {$dbg}.01_classrooms AS cr ON crs.crid=cr.id
		LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid=c.id
		WHERE crs.subject_id=$sub ORDER BY crs.name";debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"unisubjects/crsUnisubjects");
	
}	/* fxn */




}	/* BlankController */
