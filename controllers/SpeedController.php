<?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN

 */

Class SpeedController extends Controller{

public function __construct(){
	parent::__construct();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js','accounts/js/parent.js');	 

	$acl = array(array(5,0),array(9,0),array(7,0));
	$this->permit($acl);				
	
}	/* fxn */


public function beforeFilter(){}




public function informant($params=NULL){	
$dbo=PDBO;
	// include_once(SITE.'views/elements/params_sq.php');
	$dbg = PDBG; 
	
	if(!empty($params[0])) {  $tcid = $params[0]; $info = $this->model->getInfoContacts($tcid,$dbg); }				
	
	/* informant,pdata/ post data is the input key id */
	if(isset($_POST['submit'])){
		$pdata = $_POST['data'];
		if(!empty($pdata['tcid'])) { $tcid=$pdata['tcid']; $info = $this->model->getInfoContacts($tcid,$dbg);} 
	}	/* post */

	$data['info']	= isset($info)? $info : null;	
	$this->view->render($data,'registrars/informant');	
}	/* fxn */


















}	/* SpeedController */
