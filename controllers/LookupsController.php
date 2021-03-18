<?php

Class LookupsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data['home']	= $_SESSION['home'];
	$this->view->render($data,'lookups/indexLookups');

}	/* fxn */




public function equivalents($params=NULL){
$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');	

	$ssy  = $_SESSION['sy'];
	$sy	  = isset($params[0])? $params[0]:DBYR;
	$dbg  = VCPREFIX.$sy.US.DBG;
	
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : 1;
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : 2;	
	if ($dept_id == 1) 			$dept = " is_ps = '1' ";
		elseif ($dept_id == 3) 	$dept = " is_hs = '1' ";
		else 					$dept = " is_gs = '1' ";
		
	$q   = " SELECT * FROM {$dbg}.05_equivalents WHERE `crstype_id` ='$ctype' AND $dept ORDER BY `equivalent` DESC; ";	
	$sth = $this->model->db->querysoc($q);
	$data['equivalents'] = $sth->fetchAll();
	$data['ratings'] = array();
	$data['count'] = count($data['equivalents']);
	$this->view->render($data,'lookups/equivalents');

}	/* fxn */


public function descriptions($params=NULL){
$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	$db	=&	$this->model->db;
	$sy	  = isset($params[0])? $params[0]:DBYR;
	$dbg  = VCPREFIX.$sy.US.DBG;	
	
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : 1;
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : 2;	
	
	$type = " crstype_id = '$ctype' " ;		
	if ($dept_id == 1) 			$dept = " is_ps = '1' ";
		elseif ($dept_id == 3) 	$dept = " is_hs = '1' ";
		else 					$dept = " is_gs = '1' ";
		
	$q = "
		SELECT *,id AS dgid,rating,grade_floor AS grade
		FROM {$dbg}.05_descriptions
		WHERE $type and $dept  
		ORDER BY grade_floor desc;	
	";	
	// pr($q);
	$sth = $db->querysoc($q);
	$data['descriptions'] = $descriptions = $sth->fetchAll();
	$data['ratings'] = $descriptions;
	$data['count'] = count($data['descriptions']);
	$this->view->render($data,'lookups/descriptions');

}	/* fxn */


public function profile($params=NULL){
$dbo=PDBO;
	$data['table']=$table=isset($params[0])? $params[0]:'cities';
	$db=&$this->baseModel->db;$dbo=PDBO;	
	$q="SELECT id,code,name FROM {$dbo}.$table ORDER BY name;";debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	$this->view->render($data,"lookups/profileLookups");
	
}	/* fxn */


public function add($params=NULL){
$dbo=PDBO;
	reqFxn("dbFxn");
	$data['table']=$table=isset($params[0])? $params[0]:'cities';
	$db=&$this->baseModel->db;$dbo=PDBO;	
	$cols=getDbtableColumns($db,$dbo,$table,$except="'id'");
	$data['dbx']=$dbx=getDbtableFields($db,$dbo,$table,$except="'id'");

	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		// pr($posts);exit;
		$dbtable=$dbo.".".$table;
		foreach($posts AS $post){
			if(!empty($post['name'])){ $db->add($dbtable,$post); }			
		}
		$url="lookups/add/$table";
		flashRedirect($url,"Record added to $table.");
		exit;
	}	/* post */
	
	$this->view->render($data,"lookups/addLookup");
	
}	/* fxn */





}	/* LookupsController */
