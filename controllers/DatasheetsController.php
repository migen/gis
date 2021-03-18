<?php

Class DatasheetsController extends Controller{	

public $dbtable;


public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();
	
}	/* fxn */

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	// parent::beforeFilter();

	// $acl = array(array(4,0),array(5,0));
	// $this->permit($acl,false);		
	
}	/* fxn */




public function index($params=NULL){	
	$db=&$this->baseModel->db;
	$dbo=PDBO;$data['sy']=DBYR;

	$this->view->render($data,"datasheets/indexDatasheets");

}	/* fxn */

public function openAll(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="UPDATE {$dbo}.00_profiles SET profile_finalized=0; ";
	pr($q);
	pr("&exe");
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
	}
		
}	/* fxn */

public function lockAll(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$q="UPDATE {$dbo}.00_profiles SET profile_finalized=1; ";
	pr($q);
	pr("&exe");
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
	}
		
}	/* fxn */



public function crid($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['dbg']=$dbg=PDBG;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	
	if($crid){
		$q="SELECT cr.name AS classroom,c.name AS adviser,cr.id AS crid,c.id AS tcid,cr.level_id,cr.section_id
			FROM {$dbg}.05_classrooms AS cr 
			LEFT JOIN {$dbo}.00_contacts AS c ON cr.acid=c.id
			WHERE cr.id=$crid LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['cr']=$sth->fetch();	
		
	}
	
	if(!isset($_SESSION['classrooms'])){ 
		$fields="id,code,name,acid,level_id,section_id";$order="level_id";
		$_SESSION['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order); 
	}
	$data['classrooms']=$_SESSION['classrooms'];
	
	$one="datasheetsCrid_{$sch}";$two="datasheets/cridDatasheets";
	$vfile=cview($one,$two,$sch);
	debug($vfile);vfile($vfile);
	
	$this->view->render($data,$vfile);
	
	
}	/* fxn */


public function level($params=NULL){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:false;
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['dbg']=$dbg=PDBG;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	
	if($lvl){
		$q="SELECT l.name AS level,l.*
			FROM {$dbo}.05_levels AS l 
			WHERE l.id=$lvl LIMIT 1;";
		$sth=$db->querysoc($q);
		$data['level']=$sth->fetch();	
		
	}
	
	if(!isset($_SESSION['levels'])){ 
		$fields="id,code,name,label,department_id,subdepartment_id";$order="id";
		$_SESSION['levels']=fetchRows($db,"{$dbo}.05_levels",$fields,$order); 
	}
	$data['levels']=$_SESSION['levels'];
	
	$one="datasheetsLevel_{$sch}";$two="datasheets/levelDatasheets";
	$vfile=cview($one,$two,$sch);
	debug($vfile);vfile($vfile);
	
	$this->view->render($data,$vfile);
	
	
}	/* fxn */


public function all($params=NULL){
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['db']=$db=$this->baseModel->db;
	$data['dbo']=$dbo=PDBO;
	$data['dbg']=$dbg=PDBG;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	
	
	
	$one="datasheetsAll_{$sch}";$two="datasheets/cridDatasheets";
	$vfile=cview($one,$two,$sch);
	debug($vfile);vfile($vfile);
	
	$this->view->render($data,$vfile);
	
	
}	/* fxn */



}	/* BlankController */
