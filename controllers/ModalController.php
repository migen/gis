<?php

Class ModalController extends Controller{	

public function __construct(){
	parent::__construct();		
	// $this->beforeFilter();	
}	/* fxn */

public function beforeFilter(){
	parent::beforeFilter();
}	/* fxn */




public function index(){
	$data=("Modal");
	
	$this->view->render($data,'modal/indexModal',"empty");
}	/* fxn */



public function pages(){
$dbo=PDBO;
	// $data=("Pages");pr($data);
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="SELECT id,name FROM {$dbo}.`00_contacts` WHERE role_id=1 ORDER BY name LIMIT 30; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
		
	
	$this->view->render($data,'modal/pagesModal');
}	/* fxn */




public function bs(){	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;	
	$data['rows']=fetchRows($db,"{$dbo}.`05_levels`","*","id");
	$data['count']=count($data['rows']);
	$vfile="modal/bsModal";vfile($vfile);
	$this->view->render($data,$vfile,'bootstrap');	
}	/* fxn */


public function custom(){	
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;	
	// $data['rows']=fetchRows($db,"{$dbo}.`05_levels`","*","id");
	$q="SELECT * FROM {$dbo}.05_levels WHERE id >3 AND id < 8 ORDER BY id; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	$data['count']=count($data['rows']);
	$vfile="modal/customModal";vfile($vfile);
	
	$this->view->js = array('js/jquery.js','js/vegas.js');	
	$this->view->css = array('custom.css');	
	$this->view->render($data,$vfile,'full');	


}	/* fxn */


public function one(){	

	$data=NULL;
	$vfile="modal/oneModal";vfile($vfile);

	$this->view->js = array('js/jquery.js','js/vegas.js');	
	// $this->view->css = array('custom.css');	
	$this->view->render($data,$vfile,'full');	


}	/* fxn */





}	/* BlankController */
