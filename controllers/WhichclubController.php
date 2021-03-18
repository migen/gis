<?php

Class WhichclubController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	prx("whichclub");

	$data['home']	= $_SESSION['home'];
	
	$this->view->render($data,'tests/indexTests');

}	/* fxn */



public function student($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$data['prevsy']=$prevsy=($sy-1);
	
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;	
	$pdbg=VCPREFIX.$prevsy.US.DBG;
	
	$data['row']=false;
	
	if($scid){
		$q="SELECT name,role_id FROM {$dbo}.00_contacts WHERE id=$scid LIMIT 1;";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		extract($row);
		if($row['role_id']!=RSTUD){
			flashRedirect('whichclub/student',"$name - Not a student.");
		}		

	
		$q="
			SELECT
				$sy AS sy,$prevsy AS prevsy,summ.club_id,cl.name AS club,c.name AS studname,summ.scid,c.code AS studcode,
				pcl.prevclub,pcl.prevclub_id,c.role_id
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON c.id=summ.scid
			INNER JOIN {$dbg}.05_clubs AS cl ON cl.id=summ.club_id
			
			LEFT JOIN (
				SELECT				
					psum.scid,pcl.name AS prevclub,pcl.id AS prevclub_id
				FROM {$pdbg}.05_summaries AS psum 
				INNER JOIN {$pdbg}.05_clubs AS pcl ON pcl.id=psum.club_id
				WHERE psum.scid=$scid
			) AS pcl ON pcl.scid=c.id
			
			WHERE c.id=$scid LIMIT 1;";
		debug($q);
		$sth=$db->querysoc($q);
		$data['row']=$sth->fetch();
		
	}	/* scid */
		

	$this->view->render($data,"whichclub/studentWhichclub");
}	/* fxn */



public function encrid($params=NULL){
	$data['scid']=isset($params[0])? $params[0]:false;
	$data['sy']=DBYR;
	$data=isset($data)? $data:NULL;
	$this->view->render($data,"tests/encridTests");
}	/* fxn */





}	/* TestsController */
