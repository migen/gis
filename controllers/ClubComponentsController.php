<?php

Class ClubComponentsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$dbo=PDBO;$dbg=PDBG;$db=&$this->model->db;
	
	$q="SELECT
			cc.*,cri.name AS criteria,c.name AS club
		FROM {$dbg}.clubcomponents AS cc 
		INNER JOIN {$dbo}.`05_criteria` AS cri ON cc.criteria_id=cri.id
		INNER JOIN {$dbg}.`05_clubs` AS c ON cc.club_id=c.id
		ORDER BY c.name,cri.name;
	";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);
	
	
	$data=isset($data)? $data:NULL;
	$this->view->render($data,'clubgset/components');
	

}	/* fxn */


public function add(){
$dbo=PDBO;
$db=&$this->model->db;$dbg=PDBG;

if(isset($_POST['submit'])){
	$posts = $_POST['post'];	
	foreach($posts AS $post){ $db->add("{$dbg}.clubcomponents",$post); }
	flashRedirect("clubcomponents","Club Components added.");
	exit;
	
}	/* fxn */

$criwhere=" WHERE crstype_id <> 2 ";
$data['criteria']=fetchRows($db,"{$dbo}.`05_criteria`","id,name","name",$criwhere);
$data['clubs']=fetchRows($db,"{$dbg}.`05_clubs`","id,name","name");
$this->view->render($data,'clubcomponents/add');


}	/* fxn */



}	/* BlankController */
