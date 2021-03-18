<?php

Class UnicomponentsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}



public function index(){	/* course prerequisites */
$dbo=PDBO;
	require_once(SITE.'functions/unicomponentsFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;	
	$data=getUnicomponents($db,$dbg);	
	// $data['subjects']=getSubjects($db,$dbg);	
		
	$vfile="unigset/componentsUnicomponents";vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */



public function edit($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ echo "Parameter component id NOT set."; exit; }
	$data['id']=$id=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbg}.01_components",$post,"id='$id'");
		flashRedirect("unicomponents/edit/$id","Saved.");
	}	/* post */
	$q="SELECT * FROM {$dbg}.01_components WHERE `id`='$id' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();

	if(!isset($_SESSION['unicriteria'])){ $_SESSION['unicriteria'] = fetchRows($db,"{$dbg}.01_criteria"); } 
	$data['unicriteria']=$_SESSION['unicriteria'];	
	if(!isset($_SESSION['unisubjects'])){ $_SESSION['unisubjects'] = fetchRows($db,"{$dbo}.`05_subjects`"); } 
	$data['unisubjects']=$_SESSION['unisubjects'];	
	
	$this->view->render($data,"unicomponents/editUnicomponent");
	
}	/* fxn */




public function batch($params=NULL){
$dbo=PDBO;
require_once(SITE.'functions/unicomponentsFxn.php');
$db=&$this->baseModel->db;$dbg=PDBG;

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	/* j */
	$substr=$post['subjects'];
	$subarr=explode(',',$substr);
	/* k */
	$cristr=$post['criterias'];
	$criarr=explode(',',$cristr);
	$numcri=count($criarr);	
	$wtstr=$post['weights'];
	$wtarr=explode(',',$wtstr);	
	$q="";
	foreach($subarr AS $s){
		for($k=0;$k<$numcri;$k++){
			$q.=insertComponentIfNotExists($db,$criarr,$wtarr,$k,$s);
		}	/* cri */			
	}	/* sub */	
	debug($q);
	$sth=$db->query($q);
	$msg = ($sth)? "Success":"Failure";
	flashRedirect("unicomponents",$msg);	
	exit;

}	/* post */


	if(!isset($_SESSION['unicriteria'])){ $_SESSION['unicriteria'] = fetchRows($db,"{$dbg}.01_criteria","*","name"); } 
	$data['unicriteria']=$_SESSION['unicriteria'];	
	if(!isset($_SESSION['unisubjects'])){ $_SESSION['unisubjects'] = fetchRows($db,"{$dbo}.`05_subjects`"); } 
	$data['unisubjects']=$_SESSION['unisubjects'];	

	$this->view->render($data,'unicomponents/setupUnicomponents');


}	/* fxn */















}	/* BlankController */
