<?php

Class ReservationsController extends Controller{	

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




public function acknowledgement($params=NULL){
$dbo=PDBO;
	$this->view->js = array('js/jquery.js','js/vegas.js');
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$dbo=PDBO;
	$dbg = VCPREFIX.$sy.US.DBG;	
	$dbg = VCPREFIX.$sy.US.DBG;	
	
	if($scid){
		$q=" SELECT c.name AS studname,c.id AS scid,c.code AS studcode,cr.name AS classroom,l.name AS level
			FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			WHERE c.id='$scid' LIMIT 1; ";
		$sth=$this->model->db->querysoc($q);		
		$data['student']=$student=$sth->fetch();
	}
	// pr($q);
	
	$vpath = SITE.'views/customs/'.VCFOLDER.'/resack.php';		
	if(is_readable($vpath)){
		$vfile="/customs/".VCFOLDER."/resack";	
	} else {
		$vfile="reservations/acknowledgement";		
	}


	$data['page']='Reservation Acknowledgement Letter';
	$this->view->render($data,$vfile);


}	/* fxn */







}	/* ReservationsController */
