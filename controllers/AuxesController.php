<?php

Class AuxesController extends Controller{	

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
	echo "auxes index";
	$this->view->render($data,'tests/index');

}	/* fxn */





public function ad($params=NULL){
$db=&$this->model->db;
$ssy=DBYR;
$data['sy']=$sy=isset($params[0])? $params[0]:$ssy;
$dbo=PDBO;$dbg=$sy.US.DBG;$dbg=$sy.US.DBG;


if(isset($_POST['filter'])){
	$params = $_POST;
	
	$sort = $params['sort'];
	$order = $params['order'];
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 	
	$cond = NULL;
	$cond .= "";
	
	if (!empty($params['auxtype'])){ $ad = ($params['auxtype']==1)? '1':'0'; 
		$cond .= " AND ft.is_discount = '$ad'"; }					
	if (!empty($params['lvlid'])){ $cond .= " AND cr.level_id = '".$params['lvlid']."'"; }					
	if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; }					
	if (!empty($params['scid'])){ $cond .= " AND a.scid = '".$params['scid']."'"; }					
	if (!empty($params['ecid'])){ $cond .= " AND a.ecid = '".$params['ecid']."'"; }				
	if (!empty($params['feetype_id'])){ $cond .= " AND a.feetype_id = '".$params['feetype_id']."'"; }					
	
		
	$q=" SELECT a.*,a.id AS auxid,s.name AS student,e.name AS employee,ft.is_discount,
			ft.name AS feetype,cr.name AS classroom
		FROM {$dbg}.`30_auxes` AS a 
			LEFT JOIN {$dbg}.05_summaries AS summ ON a.scid = summ.scid
			LEFT JOIN {$dbo}.`00_contacts` AS s ON a.scid = s.id
			LEFT JOIN {$dbo}.`00_contacts` AS e ON a.ecid = e.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`03_feetypes` AS ft ON a.feetype_id = ft.id
		WHERE 1=1 $cond ORDER BY $sort $order $condlimits; ";		
		
	// pr($q);	
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$data['rows'] = $rows; 		
	$data['count'] = count($rows);


} 	/* filter */


if(!isset($_SESSION['feetypes'])){ 
	$_SESSION['feetypes'] = fetchRows($db,"{$dbo}.`03_feetypes`","*","name"); 	 } 
$data['feetypes'] = $_SESSION['feetypes'];	
if(!isset($_SESSION['levels'])){ 
	$_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","*","id"); 	 } 
$data['levels'] = $_SESSION['levels'];	
if(!isset($_SESSION['classrooms'])){ 
	$_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,code,name","level_id,section_id"); 	 } 
$data['classrooms'] = $_SESSION['classrooms'];	

$this->view->render($data,'auxes/ad');


}	/* fxn */






}	/* AuxesController */
