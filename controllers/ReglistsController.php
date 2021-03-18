<?php


Class ReglistsController extends Controller{	



public function __construct(){
	parent::__construct();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');	

	/* -- reg-9 and MIS-5,move methods to GController for other roles like teachers,i.e. clsAdvi */
	$acl = array(array(9,0),array(5,0),array(6,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);		

	
}

public function beforeFilter(){ parent::beforeFilter();		}	


public function index(){
$db =& $this->model->db;
$dbg=PDBG;$dbg=PDBG;$dbo=PDBO;


if(isset($_GET['filter'])){
	$params = $_GET;
	
	$sort = $params['sort'];
	$order = $params['order'];
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
		
	$cond = NULL;
	$cond .= "";
	if (!empty($params['natl'])){ $cond .= " AND p.nationality LIKE '%".$params['natl']."%'"; }				
	if (!empty($params['lvl'])){ $cond .= " AND cr.level_id = '".$params['lvl']."'"; }				
	if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; }				
	if (!empty($params['code'])){ $cond .= " AND c.code LIKE '%".$params['code']."%'"; }				
	if (!empty($params['name'])){ $cond .= " AND c.name LIKE '%".$params['name']."%'"; }	
	if (!empty($params['sy'])){ $cond .= " AND c.`sy` = '".$params['sy']."'"; }	

	$q=" SELECT c.*,ctp.ctp,c.id AS ucid,c.parent_id AS pcid,l.name AS level,sxn.name AS section,p.nationality 
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		WHERE c.role_id='".RSTUD."' $cond ORDER BY $sort $order $condlimits; ";
	$data['q']=$q;	
	// pr($q);
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);

} else {
	$data['roles'] = $_SESSION['roles'];
	$data['levels'] = $_SESSION['levels'];
	$data['classrooms'] = $_SESSION['classrooms'];
	

}




$data['sort'] = $sort = isset($sort)? $sort : 'p.name';
$data['order'] = $order = isset($order)? $order : 'ASC';
$data['page'] = $page = isset($page)? $page : '1';
$data['limits'] = $limits = isset($limits)? $limits : '20';

// $data=isset($data)? $data:NULL;
$this->view->render($data,'reglists/indexReglists');

}	/* fxn */




} 	/* RegistrarsController */
