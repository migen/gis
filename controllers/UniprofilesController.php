<?php

Class UniprofilesController extends Controller{	

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


public function scid($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['db']=$db=$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;	
	$cfields="c.name";
	$pfields="p.*";
	
	$q="SELECT $cfields,$pfields FROM {$dbo}.`00_contacts` AS c 
		LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id=c.id
		WHERE c.id='$scid' LIMIT 1;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['row']=$row=$sth->fetch();	
	/* sync profile */
	if(empty($row['contact_id'])){ $post['contact_id']=$scid;$db->add("{$dbo}.`00_profiles`",$post); }
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		unset($post['id']);unset($post['name']);
		$db->update("{$dbo}.`00_profiles`",$post,"contact_id='$scid'");
		flashRedirect("uniprofiles/scid/$scid","Saved.");
		
	}	/* post */
		
	if($scid){ $vfile="uniprofiles/scidUniprofile"; } else { $vfile="redirect/contactRedirect"; } 
	$data['rurl']="uniprofiles/scid";		
	$this->view->render($data,$vfile);	
	
}	/* fxn */

public function crid($params=NULL){
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['db']=$db=$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;
	$q=" 
		SELECT
		FROM {$dbg}.01_summaries AS summ
		INNER JOIN {}
		
	";
	
	
	
}	/* fxn */







public function one($params=NULL){
$data['scid']=$scid=isset($params[0])? $params[0]:false;
$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$db->update("{$dbo}.`00_contacts`",$post,"id='$scid'");
	flashRedirect("profiles/one/$scid","Profile updated.");
}	/* post */

$data['row']=fetchRow($db,"{$dbo}.`00_contacts`","$scid");
$this->view->render($data,"profiles/oneProfiles");

}	/* fxn */






}	/* ProfilesController */
