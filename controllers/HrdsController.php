<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN

Hrd - appraisal for guidance and hrd
 */

Class HrdsController extends Controller{	/* replaced by Guidance GCIS */

public function __construct(){
	parent::__construct();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	
	
}


public function beforeFilter(){}



public function index(){
	
	$data = isset($data)? $data : null;			
	$this->view->render($data,'hrd/index');

}	


public function instruments(){
	$dbo=PDBO;	
	if(isset($_POST['add'])){
		// pr($_POST);
		$year = date('Y');
		$q = "INSERT INTO {$dbg}.instruments (`code`,`name`) VALUES ";

		$rows = $_POST['instruments'];
		foreach($rows AS $row){			
		  $q .= " ('".$row['code']."','".$row['name']."'),";					
		}	// foreach		
		$q = rtrim($q,",");
		$q .= ";";
		$this->Hrd->db->query($q);
		$url = "hrds/instruments";
		redirect($url);
		// pr($q);
		
		exit;
	}	// post-add


	$data['instruments'] 		= $this->Hrd->instruments();
	$data['num_instruments'] 	= count($data['instruments']);
	$this->view->render($data,'hrd/instruments','full');
}	// fxn


public function instrutypes(){
	$dbo=PDBO;	
	if(isset($_POST['add'])){
		// pr($_POST);
		$year = date('Y');
		$q = "INSERT INTO {$dbg}.instrutypes (`code`,`name`) VALUES ";

		$rows = $_POST['instrutypes'];
		foreach($rows AS $row){			
		  $q .= " ('".$row['code']."','".$row['name']."'),";					
		}	// foreach		
		$q = rtrim($q,",");
		$q .= ";";
		$this->Hrd->db->query($q);
		$url = "hrds/instrutypes";
		redirect($url);
		// pr($q);
		
		exit;
	}	// post-add


	$data['instrutypes'] 		= $this->Hrd->instrutypes();
	$data['num_instrutypes'] 	= count($data['instrutypes']);
	$this->view->render($data,'hrd/instrutypes','full');
}	// fxn




public function instrucriteria(){
	$dbo=PDBO;	
	if(isset($_POST['add'])){
		// pr($_POST);
		$q = "INSERT INTO {$dbg}.instrucriteria (`instrutype_id`,`name`) VALUES ";
		$rows = $_POST['instrucriteria'];
		foreach($rows AS $row){			
		  $q .= " ('".$row['instrutype_id']."','".$row['name']."'),";					
		}	// foreach		
		$q = rtrim($q,","); $q .= ";";
		$this->Hrd->db->query($q);
		$url = "hrds/instrucriteria";
		redirect($url);
		exit;
	}	// post

//-----------------------------------------------------------------------------
	$data['instrutypes'] 		= $this->Hrd->instrutypes();	
	$data['instrucriteria'] 	= $this->Hrd->instrucriteria();
	$data['num_instrucriteria']	= count($data['instrucriteria']);

	$this->view->render($data,'hrd/instrucriteria','full');
}	// fxn



public function icomponents($params){
$dbo=PDBO;	
$instrid = $params[0];

if(isset($_POST['add'])){
	pr($_POST); exit;
	$rows = $_POST['icomponents'];
	$q = " INSERT INTO ".DBH.".instrucomponents (`instrument_id`,`instrutype_id`,`total_score`,`weight`) VALUES ";
	foreach($rows AS $row){
		$q .= " ('$instrid','".$row['instrutype_id']."','".$row['total_score']."','".$row['weight']."'),";
	}
	$q = rtrim($q,","); $q .= ";";
	$this->Hrd->db->query($q);
	redirect('hrds/icomponents/'.$instrid);	

}	// post

//---------------------------------------------------------------------
$data['instrument'] 	  = $this->Hrd->instrument($instrid);
$data['icomponents'] 	  = $this->Hrd->icomponents($instrid);
$data['num_icomponents']  = count($data['icomponents']);
$data['instrutypes']   	  = $this->Hrd->instrutypes();

$this->view->render($data,'hrd/icomponents','full');


}	





} #AppsController

