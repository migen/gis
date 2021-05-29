<?php

Class LevelsController extends Controller{	

public $dbtable;

public function __construct(){
	parent::__construct();		
	$this->dbtable=PDBO.".05_levels";
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	$acl = array(array(5,0),array(4,0),array(9,0));
	$this->permit($acl);					
}


public function index($params=NULL){ 
	ob_start();
	echo "<h3>Levels | ";shovel('links_gset');echo "</h3>";
	$data=ob_get_contents();
	ob_end_clean();
	$this->view->render($data,"layouts/linksLayout");

}	/* fxn */

public function set($params=NULL){ 
	$dbo=PDBO;	
	$data['home']=$_SESSION['home'];
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	$data['order']=$order=isset($_GET['order'])? $_GET['order']:"id";
	$data['rows']=fetchRows($db,"{$dbo}.`05_levels`","*",$order);
	$data['count']=count($data['rows']);
	$this->view->render($data,'levels/setLevels');

}	/* fxn */



public function xgetLevelCourses($params=null){
$dbo=PDBO;$lid = $_POST['lid'];
include_once(SITE.'views/elements/params_sq.php');

$q="SELECT crs.id,crs.name
	FROM {$dbg}.05_courses AS crs
		INNER JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id	
	WHERE cr.level_id=$lid ;";
$sth = $this->model->db->querysoc($q);
$row = $sth->fetchAll();
echo json_encode($row);

}	/* fxn */

public function edit($params){
	$dbo=PDBO;	
	require_once(SITE."functions/details.php");	
	$data['level_id']=$level_id=$params[0];
	$data['sy']=$sy= isset($params[1])? $params[1]:DBYR;	
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;		
	if(isset($_POST['submit'])){
		$row = $_POST['level'];
		$db->update("{$dbo}.`05_levels`",$row," `id` = '".$row['id']."' ");					
		$db->query($q);
		$url = "levels/view/$level_id";
		flashRedirect($url,'Level updated.');
		exit;		
	} /* post */
	
/*  process  */
	$data['level']		 = $level	= getLevelDetails($db,$level_id,$dbg);	
	$data['departments'] = $this->model->fetchRows(DBO.".`05_departments`",'*','id');	
	$data['ctypes'] 	 = $this->model->fetchRows("{$dbo}.`05_crstypes`",'*','id'," WHERE `id` = ".CTYPECONDUCT." OR `id` = ".CTYPETRAIT." " );	
	$this->view->render($data,'levels/editLevels');
}	/* fxn */



public function view($params){
	require_once(SITE."functions/details.php");	
	$data['level_id']=$level_id=$params[0];
	$data['sy']=$sy= isset($params[1])? $params[1]:DBYR;	
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;		
	/*  process  */
	$data['level']		 = $level	= getLevelDetails($db,$level_id,$dbg);	
	$this->view->render($data,'levels/viewLevels');
}	/* fxn */




public function students($params=NULL){
$dbo=PDBO;	
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:$_SESSION['settings']['sy_enrollment'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
$classlist_order=$_SESSION['settings']['classlist_order'];
$q="SELECT c.id AS scid,c.id,c.code,c.name,cr.name AS classroom,cr.section_id AS sxn,c.account,ctp.ctp 
FROM {$dbo}.`00_contacts` AS c 
INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
LEFT JOIN {$dbo}.00_ctp AS ctp ON summ.scid=ctp.contact_id
WHERE c.role_id=1 AND c.is_active=1 AND cr.level_id='$lvl' ORDER BY cr.section_id,$classlist_order; ";
// pr($q);
debug($q);
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

/* 2 */
$data['level']=fetchRow($db,"{$dbo}.`05_levels`",$lvl);
$fields="id,code,name";$order="id";$where="WHERE `id`<16";
$data['levels'] = fetchRows($db,"{$dbo}.`05_levels`",$fields,$order,$where);

$this->view->render($data,'levels/studentsLevel');

}	/* fxn */


public function cir($params=NULL){
$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
$data['qtr']=$qtr=isset($params[2])? $params[2]:$_SESSION['qtr'];
$db=&$this->baseModel->db;$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;

$data['level']=fetchRow($db,"{$dbo}.`05_levels`","$lvl");

$q="SELECT cr.*,s.name AS section,cr.name AS classroom,cr.id AS crid FROM {$dbg}.05_classrooms AS cr 
LEFT JOIN {$dbo}.`05_sections` AS s ON s.id=cr.section_id WHERE cr.level_id='$lvl'; ";
$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

if(!isset($_SESSION['levels'])){ $_SESSION['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name","id"); 	 } 
$data['levels']=$_SESSION['levels'];	

$this->view->render($data,'levels/cirLevels');


}	/* fxn */



public function ajax(){

$data=NULL;
$this->view->render($data,'levels/ajaxLevels');

}	/* fxn */


public function immediate($params=NULL){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;
	$data['lvl']=$lvl=isset($params[0])? $params[0]:6;
	$data['level']=fetchRow($db,"{$dbo}.`05_levels`",$lvl,"id,name");
	$y=$data['level'];
	
	$i=1;
	$x[$i]=array();
	
	array_push($x[$i],$y);
	// pr($x);
	// exit;
	
	// pr($_SESSION['levels']);
	// pr($_SESSION['levels_classrooms']);

		
	$q="SELECT id AS crid,level_id,name AS classroom		
		FROM {$dbg}.05_classrooms ORDER BY level_id LIMIT 9; ";
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	// pr($data);exit;
	
	$lc=array();
	if(!isset($_SESSION['level_classrooms'])){
		foreach($rows AS $row){
			$lvl=$row['level_id'];
			// pr($lvl);
			if(!isset($lc[$lvl])){ 
				// echo "init lc-$lvl"; 
				$lc[$lvl]=array(); 
			}
			array_push($lc[$lvl],$row);
			
			// if(!isset($lc[$lvl])){ echo "init lc-$lvl"; $lc[$lvl]=array(); }
			// $lc[$lvl]=array_push($lc[$lvl],$row);
			
		}
		
	}	/* fxn */
	
	pr($lc);
	
	

	// pr($data);
	
	$this->view->render($data,"levels/immediateLevels");
	
	
}	/* fxn */


public function pivots($params=NULL){
	$dbo=PDBO;$dbg=PDBG;$db=&$this->baseModel->db;

	$q="SELECT prid,
		  MAX(IF(property = 'color', value, NULL)) AS color,
		  MAX(IF(property = 'name', value, NULL)) AS name
		FROM
		{$dbo}.pivots
		GROUP BY prid; ";
	pr($q);
	
	$q="SELECT prid,
		  MAX(IF(property = 'color')) AS color,
		  MAX(IF(property = 'name')) AS name
		FROM
		{$dbo}.pivots
		GROUP BY prid; ";
	pr($q);
	
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();

	// pr($data);
	
	$this->view->render($data,"levels/pivotsLevels");
	
}	/* fxn */





}	/* LevelsController */
