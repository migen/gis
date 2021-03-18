<?php


Class DashboardController extends Controller{	



public function __construct(){
	parent::__construct();		
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js,js/vegas_extra.js');	
	$this->beforeFilter();

	
}

public function beforeFilter(){ 
	parent::beforeFilter();		
	$acl = array(array(9,0),array(5,0),array(7,0));
	$this->permit($acl);		
	
}	/* fxn */



public function index(){
	echo "dashboard controller index";

}	/* fxn */



public function mis($params=NULL){	/* arm-model */
	$acl = array(array(5,0));
	$this->permit($acl);		
	$db=&$this->model->db;$dbg=PDBG;$dbo=PDBO;
	$debug=true;

	include_once(SITE.'views/elements/params_sq.php');
	// getCount(dbtable,condition,debug)
	
$data['num_users'] 	 	 = $this->model->getCount("{$dbo}.`00_contacts`",null,false);				
$data['active_contacts'] = $this->model->getCount("{$dbo}.`00_contacts`"," WHERE id=parent_id AND `is_active` = '1' ",false);		
$data['num_parents'] 	 = $this->model->getCount("{$dbo}.`00_contacts`"," WHERE `id` = `parent_id` ",false);	

	$data['num_calendar'] 	 = $this->model->getCount("{$dbg}.05_calendar",null,false);		
	$data['num_ctp'] 		 = $this->model->getCountCidsDBO("ctp",false);	// 2nd param debug		
	$q = "SELECT count(DISTINCT(c.parent_id)) AS numrows 
		FROM ".DBP.".`photos` AS `t`
			INNER JOIN {$dbo}.`00_contacts` AS `c` ON t.`contact_id` = c.`id`";
	$sth = $this->model->db->query($q);
	if(!$sth){ pr($q);exit; }	
	$row = $sth->fetch();
	$data['num_photos'] = $row['numrows'];

	$data['num_profiles'] 	 = $this->model->getCountCidsDBO("profiles",false);		
	// exit;

$data['active_employees']= $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND `is_active` = '1' AND `role_id` <> '".RSTUD."'  ");
	$data['num_multiusers']  =  $this->model->getCountMultiUsers($dbg);	
	$data['active_users'] 	 = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE `is_active` = '1' ");	
	$data['num_departments'] = $this->model->getCount("".PDBO.".`05_departments`");
	$data['num_subjects'] 	= $this->model->getCount("{$dbo}.`05_subjects`");	
	$data['num_criteria'] 	= $this->model->getCount("{$dbo}.`05_criteria`");	
	$data['num_components'] = $this->model->getCount("{$dbg}.05_components");
	$data['num_modified_advisers'] 	 = $this->model->getCount("{$dbg}.05_classrooms"," WHERE `is_modified_acid` = '1' AND `is_active` = '1' ");	
	$data['num_courses'] 	 = $this->model->getCount("{$dbg}.05_courses"," WHERE `is_active` = 1 " );
	$data['num_cq'] 		 = $this->model->getCount("{$dbg}.05_courses_quarters");		
	$data['num_classrooms'] = $this->model->getCountClassrooms($dbg,$temp=0);
	$data['num_promotions'] = $this->model->getCountPromotions($dbg,$sy,$tmp=0);
	$data['num_prom_classrooms']    = $this->model->getCount("{$dbg}.05_promotions" );				
	$data['num_aq'] 		= $this->model->getCount("{$dbg}.05_advisers_quarters");
	$data['has_axis']=$has_axis=$_SESSION['settings']['has_axis'];	
	if($has_axis){ $data['num_tsum']=$this->model->getCountTuitionSummaries($dbg); }

	/* 10 */
	$data['num_awardees']=0;
	
	
	$q="SELECT count(summ.scid) AS numrows FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id WHERE cr.section_id>2;	";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();		
	$data['num_summaries']=$row['numrows'];
				
	$data['num_attendance']  = $this->model->getCountAttendance($dbg,$sy);	
	$data['num_promotions'] = $this->model->getCountPromotions($dbg,$sy,$tmp=0);	
	$data['num_students']   = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND role_id = 1 AND `is_active` = 1 " );
	$data['num_employees']  = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND  `role_id` <> '1' AND `is_active` = 1 " );
	$data['num_students_finalized'] = $this->model->getCount("".PDBO.".`00_profiles`"," WHERE is_finalized = 1 " );		
	$data['num_sectioned'] 	= $this->model->getCountPromotedStudents($sy,$sectioned=1,$dbg);
	$data['num_open_cq'] 	= $this->model->getCount("{$dbg}.05_courses_quarters"," WHERE is_finalized_q$qtr = '0' " );
	$data['num_open_aq'] 	= $this->model->getCount("{$dbg}.05_advisers_quarters"," WHERE is_finalized_q$qtr = '0' " );	
	$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");
		
	$data['months']	= $this->model->fetchRows("".PDBO.".months");
	$_SESSION['url'] = "dashboard/stats";
	
	$this->view->render($data,'dashboard/misDashboard');

}	/* fxn */


public function stats($params=NULL){
$db=&$this->model->db;
$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
$q="SELECT * FROM {$dbg}.dashboard; ";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$this->view->render($data,'dashboard/stats');

}	/* fxn */



public function registrar($params=NULL){
$acl = array(array(9,0),array(5,0));
$this->permit($acl);		

include_once(SITE.'views/elements/params_sq.php');
$data['sqtr']	= $sqtr 	= $_SESSION['qtr'];
	
	
$data['active_students'] = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id && `is_active` = '1' && `role_id` = '".RSTUD."'  " );	
$data['num_dropouts']    = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND `role_id` = '1' AND `is_active` = '0' " );		
	$data['is_finalized_sectioning']   = $_SESSION['settings']['is_finalized_sectioning'];	
	$data['num_classrooms'] = $this->model->getCountClassrooms($dbg,$temp=0);
	$data['num_promotions'] = $this->model->getCountPromotions($dbg,$sy,$tmp=0);	
	$data['num_prom_classrooms']    = $this->model->getCount("{$dbg}.05_promotions");		
	$data['num_summaries'] 	 = $this->model->getCountSummaries($dbg,$sy);	
	$data['num_sectioned'] 		= $this->model->getCountPromotedStudents($sy,$sxnd=1,$dbg);

	
	$this->view->render($data,'dashboard/registrar');

}	/* fxn */



public function teacher(){

	$acl = array(array(9,0),array(5,0),array(7,0));
	$this->permit($acl);		
	
	echo "dashboard teacher";

}	/* fxn */



public function syncs($params=NULL){
	include_once(SITE.'views/elements/params_sq.php');
	$dbg=&$dbg;

	$data['num_calendar'] 	 = $this->model->getCount("{$dbg}.05_calendar");		
	$data['active_contacts'] = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND `is_active` = '1' ");		
	$data['num_parents'] 	 = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id ");		
	$data['num_contacts'] 	 = $this->model->getCount("".PDBO.".`00_contacts`");		
	$data['num_users'] 	 	 = $this->model->getCount("".PDBO.".`00_contacts`");			
	$data['num_ctp'] 	 	 = $this->model->getCount("{$dbo}.`00_ctp`");			
	
	$q = "SELECT count(DISTINCT(c.parent_id)) AS numrows 
		FROM ".DBP.".`photos` AS `t`
			INNER JOIN {$dbo}.`00_contacts` AS `c` ON t.`contact_id` = c.`id`";
	$sth = $this->model->db->query($q);
	if(!$sth){ pr($q);exit; }	
	$row = $sth->fetch();
	$data['num_photos'] = $row['numrows'];
	
	$data['num_profiles'] 	 = $this->model->getCountCidsDBO("profiles");		

	$data['active_employees']= $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND 
		`is_active` = '1' AND `role_id` <> '".RSTUD."'  ");
	$data['num_multiusers']  =  $this->model->getCountMultiUsers($dbg);	
	$data['active_users'] 	 = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE `is_active` = '1' ");	
	$data['num_departments'] = $this->model->getCount("".PDBO.".`05_departments`");
	$data['num_subjects'] 	= $this->model->getCount("{$dbo}.`05_subjects`");	
	$data['num_criteria'] 	= $this->model->getCount("{$dbo}.`05_criteria`");	
	$data['num_components'] = $this->model->getCount("{$dbg}.05_components");
	
	$data['num_modified_advisers'] 	 = $this->model->getCount("{$dbg}.05_classrooms"," WHERE `is_modified_acid` = '1' AND `is_active` = '1' ");	
	$data['num_courses'] 	 = $this->model->getCount("{$dbg}.05_courses"," WHERE `is_active` = 1 " );
	$data['num_cq'] 		 = $this->model->getCount("{$dbg}.05_courses_quarters");	
	$data['num_classrooms'] = $this->model->getCountClassrooms($dbg,$temp=0);
	$data['num_promotions'] = $this->model->getCountPromotions($dbg,$sy,$tmp=0);
	$data['num_prom_classrooms']    = $this->model->getCount("{$dbg}.05_promotions");		
	$data['num_aq'] 		= $this->model->getCount("{$dbg}.05_advisers_quarters");
	if($_SESSION['settings']['has_axis']==1){ $data['num_tsum']=$this->model->getCountTuitionSummaries($dbg);	}
	if($_SESSION['settings']['has_hris']==1){ $data['num_attemps']=$this->model->getCountAttemps($dbg,$sy); }
	$data['num_summaries']  = $this->model->getCountSummaries($dbg,$sy);	
	$data['num_attendance']  = $this->model->getCountAttendance($dbg,$sy);	
	$data['num_promotions'] = $this->model->getCountPromotions($dbg,$sy,$tmp=0);
	$data['num_students']   = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND role_id = 1 AND `is_active` = 1 " );

	
	$q = " SELECT count(s.contact_id) AS numrows FROM {$dbg}.05_students AS s   
		LEFT JOIN {$dbo}.`00_contacts` AS c ON s.contact_id = c.id
		WHERE c.is_active = 1 AND c.role_id = 1; ";
		$sth = $this->model->db->querysoc($q);
		$row = $sth->fetch();
	$data['num_cstudents']   = 	$row['numrows'];	
	// pr($data['num_cstudents']);
	
	$data['num_employees']  = $this->model->getCount("".PDBO.".`00_contacts`"," WHERE id=parent_id AND  `role_id` <> '1' AND `is_active` = 1 " );
	$data['num_students_finalized'] = $this->model->getCount("".PDBO.".`00_profiles`"," WHERE is_finalized = 1 " );		
	$data['num_sectioned'] 	= $this->model->getCountPromotedStudents($sy,$sectioned=1,$dbg);
	$data['num_open_cq'] 	= $this->model->getCount("{$dbg}.05_courses_quarters"," WHERE is_finalized_q$qtr = '0' " );
	$data['num_open_aq'] 	= $this->model->getCount("{$dbg}.05_advisers_quarters"," WHERE is_finalized_q$qtr = '0' " );	
	$data['classrooms']	= $this->model->fetchRows("{$dbg}.05_classrooms","*","level_id");
	$data['current'] = (DBYR==$_SESSION['sy'])? true:false;
	$data['months']	= $this->model->fetchRows("".PDBO.".months");
	
	$this->view->render($data,'dashboard/syncsDashboard');

}	/* fxn */



public function pos($params=NULL){

	$this->view->render($data=NULL,'dashboard/pos');


}	/* fxn */


public function aaa(){
	$db=&$this->model->db;
	$sy=DBYR;
	$nsy=DBYR+1;
	// $name=$_POST['name'];
	$name="students";
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;

	$q = " 
		SELECT count(c.id) AS numrows FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE c.role_id=1 AND cr.id<>1 AND cr.id<>2 AND c.`sy`<>'$nsy'; ";				
	$sth = $db->querysoc($q);
	
	// $_SESSION['q'] = $q;
	$_SESSION['q'] = "";
	$row = $sth->fetch();	
	echo json_encode($row);



}






} 	/* DashboardController */