<?php

Class UploadsController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}


public function index(){	
	pr("uploads");
	// $dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	// require_once(SITE."functions/encryptionFxn.php");
	// pr($this->dbtable);
	// $this->view->render($data,"records/complexRecords");	
}	/* fxn */


public function item($params=NULL){
	$dbo=PDBO;
	$folder=isset($params[0])? $params[0]:"images";
	if(isset($_POST['submit'])) {
		$tmp_file = $_FILES['file_upload']['tmp_name'];
		$target_file = basename($_FILES['file_upload']['name']);	
		$upload_dir = SITE."public/{$folder}"; 
		// $upload_dir = ROOT.'/assets';		
		$filename = stripslashes(trim($_POST['filename']));
		$target_file = (isNullOrEmpty($filename))?  $target_file : $filename;				
		$upfile = $upload_dir.'/'.$target_file;
		if(move_uploaded_file($tmp_file,$upfile)) {
			Session::set('message','File uploaded successfully.');
		} else {
			$error = $_FILES['file_upload']['error'];
			Session::set('message','Upload failed.');
		}			
		redirect('mis');
			
	}	/* post */
		
	// $this->view->render(null,'mis/upload');
	$vfile="uploads/itemUploads";vfile($vfile);
	$this->view->render(null,$vfile);

} /* fxn */






}	/* BlankController */
