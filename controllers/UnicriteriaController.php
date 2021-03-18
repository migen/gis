<?php

Class UnicriteriaController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(!isset($_SESSION['unicriteria'])){ $_SESSION['unicriteria']=fetchRows($db,"{$dbg}.01_criteria","*","name"); } 	
	$data['rows']=$_SESSION['unicriteria'];
	$data['count']=count($data['rows']);		
	$this->view->render($data,"unicriteria/setUnicriteria");
}	/* fxn */


public function add(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
		
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		foreach($posts AS $post){
			if(!empty($post['name'])){
				$db->add("{$dbg}.01_criteria",$post);
			}			
		}	/* foreach */		
		flashRedirect("unicriteria","College Criteria added.");
		exit;
		
	}	/* post */
	if(!isset($_SESSION['unicriteria'])){ $_SESSION['unicriteria'] = fetchRows($db,"{$dbg}.01_criteria","*"); } 
	$data['rows']=$_SESSION['unicriteria'];	
	
	$this->view->render($data,"unicriteria/addUnicriteria");
	
}	/* fxn */



public function edit($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ echo "Parameter criteria id NOT set."; exit; }
	$data['cri']=$cri=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbg}.01_criteria",$post,"id='$cri'");
		flashRedirect("unicriteria/edit/$cri","Saved.");
	}	/* post */
	$q="SELECT * FROM {$dbg}.01_criteria WHERE `id`='$cri' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	$this->view->render($data,"unicriteria/editUnicriteria");
	
}	/* fxn */


public function reset(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	$_SESSION['unicriteria'] = fetchRows($db,"{$dbg}.01_criteria","*","name");	
}	/* fxn */









}	/* BlankController */
