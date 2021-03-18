<?php

Class OBController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');

}

public function index(){
    ob_start();
    phpinfo();	
    $ob = ob_get_clean();
	echo "Append to url ?ob";
	if(isset($_GET['ob'])){ echo $ob; }
	
	// print($output);
	// $data=NULL;$this->view->render($data,'abc/indexAbc');
}	/* fxn */


}	/* BlankController */
