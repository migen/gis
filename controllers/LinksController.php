<?php

Class LinksController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js','');

}

public function index(){
	$data=NULL;$this->view->render($data,'links/indexLinks');
	
}	/* fxn */

public function axis(){
	// $dbo=PDBO;$data['sy']=DBYR;$data['qtr']=$_SESSION['qtr'];
	$data=isset($data)? $data:null;
	$vfile='links/axisLinks';vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */

public function mis(){
	// $data=isset($data)? $data:null;
	$data['sy']=$_SESSION['sy'];
	$data['qtr']=$_SESSION['qtr'];
	$data['roles']=$_SESSION['roles'];
	$data['levels']=$_SESSION['levels'];
	$data['teachers']=[];
	$vfile='links/misLinks';vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */


public function devtools(){
	$data=isset($data)? $data:null;
	$vfile='links/devtoolsLinks';vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */

public function etc(){
	$data=isset($data)? $data:null;
	$vfile='links/etcLinks';vfile($vfile);
	$this->view->render($data,$vfile);
}	/* fxn */

public function lab(){
	$vfile='links/labLinks';vfile($vfile);
	$data=isset($data)? $data:null;
	$this->view->render($data,$vfile);
}	/* fxn */






}	/* BlankController */
