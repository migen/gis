<?php

// enrollment step / dbo.05_steps /  contacts.enstep (int: default=1)
Class EnstepsController extends Controller{	


public function __construct(){
	parent::__construct();		
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js','js/crypto.js');
	parent::beforeFilter();

	$acl = array(array(4,0),array(5,0),array(2,0),array(9,0));
	$this->permit($acl,false);		
	
}	/* fxn */




public function index($params=NULL){	


	
	$data['content']=isset($content)? $content:null;
	$this->view->render($data,"abc/index");

}	/* fxn */



public function student($params=NULL){
	require_once(SITE.'functions/enstepsFxn.php');
	// if(!isset($params)){ pr("param[0]-scid is required"); exit; }	
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
		
	$data['num_ensteps']=$num_ensteps=$_SESSION['settings']['num_ensteps'];
 
	/* post */
	if(isset($_POST['submit'])){
		$contact=$_POST['contact'];
		$step=$_POST['step'];
		// pr($_POST);echo '<hr>';prx($_POST);
		
/* 		
		for($i=1;$i<=$num_ensteps;$i++){
			$step['finalized_s'.$i] = (isset($step['finalized_s'.$i]) && $step['finalized_s'.$i]!=='0000-00-00')? 
				$step['finalized_s'.$i] : null;
		}
 */		
		
		$db->update("{$dbo}.00_contacts",$contact,"id=$scid");
		$db->update("{$dbo}.05_steps",$step,"scid=$scid AND type='enrollment'");
		
		flashRedirect("ensteps/student/$scid/$sy","Saved.");
		exit;
	}
	
	if($scid){
		/* getData */
		// pr($q);		
		$data['row']=getStudentEnsteps($db,$sy,$scid);
		
		if(empty($row['step_type'])){ 
			$q="INSERT INTO {$dbo}.05_steps(scid,type)VALUES($scid,'enrollment'); ";
			$sth=$db->query($q);
			// echo ($sth)? "Insert OK":"Insert Fail";echo "<br>"; echo $db->lastInsertId();
		}
		
	}	/* scid */
	// $sch=VCFOLDER;$one="paymode_{$sch}";$two="students/paymodeStudent";
	// $vfile=cview($one,$two,$sch);vfile($vfile);	
	
	$vfile="ensteps/studentEnstep";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */



}	/* BlankController */
