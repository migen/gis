 <?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

 /* from MyController */
Class SetupEnstepsController extends Controller{
/*
1) ac (code=account)
2) cricode (code=name)

*/


public function __construct(){
	parent::__construct();
	parent::beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');		
	$acl = array(array(5,0));
	$this->permit($acl);					
	
}	/* fxn */


public function index(){
	$data = NULL;
	$this->view->render($data,'setup/indexSetup');
	
}	/* fxn */


public function initEnsteps(){	// syncEnsteps
	
	
	
}	/* fxn */




} /* SetupController */
