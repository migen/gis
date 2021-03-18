<?php

Class UniclassroomsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	// if(!isset($_SESSION['uniclassrooms'])){ require_once(SITE.'functions/uniclassroomsFxn.php');sessionizeUniclassrooms($db,$dbg); }
	require_once(SITE.'functions/uniclassroomsFxn.php');sessionizeUniclassrooms($db,$dbg); 	
	$data['rows']=$_SESSION['uniclassrooms'];
	$data['count']=$_SESSION['num_uniclassrooms'];
		
	$this->view->render($data,"uniclassrooms/indexUniclassrooms");
}	/* fxn */

public function reset(){
$dbo=PDBO;
	require_once(SITE.'functions/uniclassroomsFxn.php');
	$db=&$this->baseModel->db;$dbg=PDBG;
	sessionizeUniclassrooms($db,$dbg);
	
	
}	/* fxn */

public function upname(){
$dbo=PDBO;
	$dbg=PDBG;
	pr("exe to execute");
	$q="UPDATE {$dbg}.01_classrooms AS cr
		INNER JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
		INNER JOIN {$dbg}.01_sections AS s ON cr.section_id=s.id
		SET cr.code=CONCAT(m.code,'-',s.code),cr.name=CONCAT(m.code,'-',s.name);";		
	if(isset($_GET['exe'])){
		$db=&$this->baseModel->db;
		$sth=$db->query($q);
		$msg=($sth)? "Success":"Fail"; pr($msg." - $q");		
	}	/* fxn */
	
	
}	/* fxn */

public function courses($params){
$dbo=PDBO;
	if(!isset($params[1])){ pr("Inc params - crid/lvl "); exit; }
	require_once(SITE.'functions/unicoursesFxn.php');
	$data['crid']=$crid=$params[0];
	$data['lvl']=$lvl=$params[1];
	$db=&$this->baseModel->db;$dbg=PDBG;
	$where=" WHERE c.crid=$crid AND c.level_id=$lvl ";
	$d=getUnicourses($db,$dbg,$where);
	$data['rows']=$d['rows'];$data['count']=$d['count'];	
	/* 2 */
	$data['cr']=fetchRow($db,"{$dbg}.01_classrooms","$crid");		
	$this->view->render($data,"uniclassrooms/coursesUniclassrooms");
		
	
}	/* fxn */

public function edit($params=NULL){
$dbo=PDBO;
	if(!isset($params[0])){ pr("Parameter crid NOT set."); exit; }
	$data['crid']=$crid=$params[0];
	$db=&$this->baseModel->db;$dbg=PDBG;
	
	if(isset($_POST['submit'])){
		$post=$_POST['post'];
		$db->update("{$dbg}.01_classrooms",$post,"id='$crid'");
		flashRedirect("uniclassrooms/edit/$crid","Saved.");
		exit;
	}	/* post */
	
	$q="SELECT cr.*,cr.id AS crid,m.code AS mcode,s.code AS sxncode,s.name AS section
	FROM {$dbg}.01_classrooms AS cr
	LEFT JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
	LEFT JOIN {$dbg}.01_sections AS s ON cr.section_id=s.id
	WHERE cr.id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();

	if(!isset($_SESSION['majors'])){ $_SESSION['majors'] = fetchRows($db,"{$dbg}.`05_majors`","*"); } 
	$data['majors']=$_SESSION['majors'];	
	if(!isset($_SESSION['unisections'])){ $_SESSION['unisections'] = fetchRows($db,"{$dbg}.01_sections","*"); } 
	$data['unisections']=$_SESSION['unisections'];	

	$this->view->render($data,"uniclassrooms/editUniclassroom");
	
	
}	/* fxn */

public function batch(){
$dbo=PDBO;
	$db=&$this->baseModel->db;$dbg=PDBG;
	if(isset($_POST['submit'])){
		require_once(SITE.'functions/uniclassroomsFxn.php');		
		$posts=$_POST['posts'];
		$dbtable="{$dbg}.01_classrooms";
		foreach($posts AS $post){
			if(!empty($post['major_id']) && !empty($post['section_id'])){
				$db->createIfNotExists($dbtable,$post);							
			}
		}	/* foreach */	
		upnameClassrooms($db,$dbg);
		flashRedirect("uniclassrooms","Batch added.");		
		exit;				
	}	/* post */	

	if(!isset($_SESSION['majors'])){ $_SESSION['majors'] = fetchRows($db,"{$dbg}.`05_majors`","id,code,name"); } 
	if(!isset($_SESSION['unisections'])){ $_SESSION['unisections'] = fetchRows($db,"{$dbg}.01_sections","id,code,name"); } 	
	$data['majors']=fetchRows($db,"{$dbg}.`05_majors`");;	
	$data['unisections']=fetchRows($db,"{$dbg}.01_sections");;		
	
	$this->view->render($data,"uniclassrooms/batchUniclassrooms");
	
}	/* fxn */


public function syncGrades($params=NULL){
$dbo=PDBO;
	reqFxn('unisyncGrades');
	if(!isset($params)){ echo "Crid NOT set"; exit; }	
	$crid=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;

	$q="SELECT m.years FROM {$dbg}.01_classrooms AS cr INNER JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id WHERE cr.id=$crid LIMIT 1;";
	$sth=$db->querysoc($q);
	$crrow=$sth->fetch();
	$years=$crrow['years'];

for($y=1;$y<=$years;$y++){
	/* getUniclasslist */
	$q="SELECT summ.scid,c.name FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.01_summaries AS summ ON c.id=summ.scid
		WHERE summ.crid=$crid AND summ.level_id=$y;	";
	$sth=$db->querysoc($q);
	$s=$sth->fetchAll();
	$sr=buildArray($s,"scid");
	
	/* getUniclassroomCourses */
	$q="SELECT id AS crs,level_id FROM {$dbg}.01_courses WHERE crid=$crid AND level_id=$y ORDER BY id; ";
	$sth=$db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,"crs");
	
	/* 3 */
	$q="INSERT INTO {$dbg}.10_grades(scid,course_id)VALUES";
	foreach($sr AS $scid){
		$b=getStudentUnigrades($db,$dbg,$scid);
		$br=buildArray($b,"crs");
		$ix=array_diff($ar,$br);
		foreach($ix AS $crs){
			$q.="($scid,$crs),";
		}	/* foreach ix */				
	}	/* foreach ar-scids */	
	$q=rtrim($q,",");$q.=";";debug($q);
	$sth=$db->query($q);echo ($sth)? "success":"fail";echo "<br />";
		
}	/* years */
	
/* update semester for crid */	
$q="UPDATE {$dbg}.10_grades AS g INNER JOIN {$dbg}.01_courses AS c ON g.course_id=c.id SET g.semester=c.semester WHERE c.crid=$crid; ";
debug($q);$sth=$db->query($q);echo ($sth)? "success":"fail";echo "<br />";



}	/* fxn */





}	/* BlankController */
