<?php

Class ItypesController extends Controller{	

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
	$this->view->render($data,'tests/index');

}	/* fxn */





public function itypes($params=NULL){
$dbo=PDBO;	
include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['add'])){
	$year = date('Y');
	$q = "INSERT INTO {$dbg}.itypes (`code`,`name`) VALUES ";

	$rows = $_POST['itypes'];
	foreach($rows AS $row){			
	  $q .= " ('".$row['code']."','".$row['name']."'),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
	
	// pr($q); exit;
	
	$this->model->db->query($q);
	$url = "itypes/index";
	redirect($url);		
	exit;
}	/* post-add */

$q = " SELECT * FROM {$dbg}.itypes;";
$sth = $this->model->db->querysoc($q);
$data['itypes'] = $sth->fetchAll();
$data['num_itypes']	= count($data['itypes']);

$this->view->render($data,'itypes/index');

}	/* fxn */





public function itypes1($params=NULL){
$dbo=PDBO;	
include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['add'])){
	$year = date('Y');
	$q = "INSERT INTO {$dbg}.itypes (`code`,`name`) VALUES ";

	$rows = $_POST['itypes'];
	foreach($rows AS $row){			
	  $q .= " ('".$row['code']."','".$row['name']."'),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
	
	// pr($q); exit;
	
	$this->model->db->query($q);
	$url = "mis/itypes";
	redirect($url);		
	exit;
}	/* post-add */

$q = " SELECT * FROM {$dbg}.itypes;";
$sth = $this->model->db->querysoc($q);
$data['itypes'] = $sth->fetchAll();
$data['num_itypes']	= count($data['itypes']);

$this->view->render($data,'mis/itypes');

}	/* fxn */

public function icategories($params=NULL){

include_once(SITE.'views/elements/params_sq.php');

if(isset($_POST['add'])){
	$q = "INSERT INTO {$dbg}.icategories(`code`,`name`) VALUES ";

	$rows = $_POST['icategories'];
	foreach($rows AS $row){			
	  $q .= " ('".$row['code']."','".$row['name']."'),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
	
	// pr($q); exit;
	
	$this->model->db->query($q);
	$url = "mis/icategories";
	redirect($url);		
	exit;
}	/* post-add */

$q = " SELECT * FROM {$dbg}.icategories;";
$sth = $this->model->db->querysoc($q);
$data['icategories'] 	  = $sth->fetchAll();
$data['num_icategories']  = count($data['icategories']);

$this->view->render($data,'mis/icategories');

}	/* fxn */


public function icriteria($params=NULL){
$dbo=PDBO;	
$data['icategory_id'] = $icategory_id = isset($params[0])? $params[0] : 0;

$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

$data['home']	= $home			= $_SESSION['home'];
$dbg = VCPREFIX.$sy.US.DBG; 

if(isset($_POST['add'])){
	$q = "INSERT INTO {$dbg}.icriteria(`icategory_id`,`name`) VALUES ";

	$rows = $_POST['icriteria'];
	foreach($rows AS $row){			
	  $q .= " ('".$icategory_id."','".$row['name']."'),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
		
	$this->model->db->query($q);
	$url = "mis/icriteria/".$icategory_id.DS.$sy;
	redirect($url);		
	exit;
}	/* post-add */

/*--------------------------- process ------------------------------------------------------------------*/
$q = " SELECT icat.name AS icategory,icri.* 
	FROM {$dbg}.`icriteria` AS `icri`
		LEFT JOIN {$dbg}.icategories AS icat ON icri.icategory_id = icat.id
";
if($icategory_id != 0){ $q .= " WHERE icri.`icategory_id` = '$icategory_id'; "; }
$q .= " ORDER BY icat.`name`  ";
// pr($q);
$sth = $this->model->db->querysoc($q);
$data['icriteria'] 	  	 = $sth->fetchAll();
$data['num_icriteria'] 	 = count($data['icriteria']);

$this->view->render($data,'mis/icriteria');

}	/* fxn */




public function icomponents($params){
$dbo=PDBO;	
$data['itype_id'] = $itype_id	= $params[0];

$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

$data['home']	= $home			= $_SESSION['home'];
$dbg = VCPREFIX.$sy.US.DBG; 

if(isset($_POST['add'])){
	$q = "INSERT INTO {$dbg}.icomponents(`is_active`,`itype_id`,`icriteria_id`,`max`,`weight`) VALUES ";

	$rows = $_POST['icomponents'];
	foreach($rows AS $row){			
	  $q .= " ('1','".$itype_id."','".$row['icriteria_id']."','".$row['max']."','".$row['weight']."' ),";					
	}	/* foreach */		
	$q = rtrim($q,",");
	$q .= ";";
	
	// pr($q); exit;
	
	$this->model->db->query($q);
	$url = "mis/icomponents/".$itype_id;
	redirect($url);		
	exit;
}	/* post-add */


if(isset($_POST['saveit'])){
	$row = $_POST['itype'];
	$this->model->db->update("{$dbg}.itypes",$row," `id` = '$itype_id'  ");
	$url = "mis/icomponents/".$itype_id;
	redirect($url);		
	exit;
}	/* post */

/* 1 - itype or sales */
$q = " SELECT * FROM {$dbg}.`itypes` WHERE `id` = '$itype_id' LIMIT 1; ";
$sth = $this->model->db->querysoc($q);
$data['itype'] = $sth->fetch();

/* 2 - icomponents or items */
$q = " SELECT 
			icri.name AS icriteria,
			icat.code AS icategory_code,icat.name AS icategory,
			icomp.*
		FROM {$dbg}.icomponents AS icomp
			LEFT JOIN {$dbg}.icriteria AS icri ON icomp.icriteria_id = icri.id
			LEFT JOIN {$dbg}.icategories AS icat ON icri.icategory_id = icat.id
		WHERE icomp.`itype_id` = '$itype_id'
";

// pr($q);
$sth = $this->model->db->querysoc($q);
$data['icomponents'] 	  = $sth->fetchAll();
$data['num_icomponents']  = count($data['icomponents']);

$data['icriterias'] = $this->model->fetchRows("{$dbg}.icriteria");

$this->view->render($data,'mis/icomponents');


}	/* fxn */



public function editIcomponent($params){
$dbo=PDBO;	
$icompid = $params[0];
$data['ssy'] 	= $ssy	= $_SESSION['sy'];
$data['sy'] 	= $sy	= isset($params[1])? $params[1] : $ssy;

$data['home']	= $home			= $_SESSION['home'];
$dbg = VCPREFIX.$sy.US.DBG; 

$data['icomponent'] = $icomponent = $this->model->fetchRow("{$dbg}.icomponents",$icompid);

if(isset($_POST['submit'])){
	$row = $_POST['icomp'];   
	$this->model->db->update("{$dbg}.icomponents",$row," `id` = '$icompid' ");  
	$url = "mis/icomponents/".$icomponent['itype_id'];
	redirect($url);

	// $this->model->db->update("{$dbg}.itypes",$row," `id` = '$itype_id' ");  

}	/* post */


$data['icriteria']  = $this->model->fetchRows("{$dbg}.icriteria");


$this->view->render($data,'mis/editIcomponent');


}	/* fxn */























}	/* ItypesController */
