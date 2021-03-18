<?php

Class ComponentsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}



public function index(){
	$this->view->render($data=NULL,"components/indexComponents");
}	/* fxn */


public function roots(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbg=PDBG;
	$q="SELECT * FROM {$dbg}.05_comproots ORDER BY subjtype_id; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	// pr($rows);

	if(!isset($_GET['exe'])){ pr('&exe'); } 

	foreach($rows AS $row){
		pr($row);
		extract($row);
		$q="UPDATE {$dbg}.05_components AS comp 
			INNER JOIN {$dbo}.05_subjects AS sub ON comp.subject_id=sub.id
			INNER JOIN {$dbo}.05_subjtypes AS st ON sub.subjtype_id=st.id
			INNER JOIN {$dbo}.05_criteria AS cri ON comp.criteria_id=cri.id
			SET comp.weight=$weight 
			WHERE st.id=$subjtype_id AND cri.id=$criteria_id AND cri.is_active=2;";
		pr($q);
		if(isset($_GET['exe'])){
			$sth=$db->query($q);
			echo ($sth)? "success":"fail";echo "<br />";			
		}

	}	
}	/* fxn */


public function changeSubjects(){
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbg=PDBG;
	$q="
		SELECT sc.*,os.name AS oldsubj,ns.name AS newsubj,
			os.subjtype_id AS ost_id,
			ns.subjtype_id AS nst_id
		FROM {$dbg}.05_subjchanges AS sc 
		INNER JOIN {$dbo}.05_subjects AS os ON sc.oldsubj_id=os.id
		LEFT JOIN {$dbo}.05_subjects AS ns ON sc.newsubj_id=os.id		
		ORDER BY os.name;";
	

	if(!isset($_GET['exe'])){ pr('&exe'); } 
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();	
	pr($count);
	
	pr($q);	
	echo "<hr />";
	// prx($rows);

	foreach($rows AS $row){
		pr($row);
		extract($row);
		$q="UPDATE {$dbg}.05_components 
			SET subject_id=$newsubj_id 
			WHERE level_id>13 AND subject_id=$oldsubj_id;";
		$q.="UPDATE {$dbg}.05_courses 
			SET subject_id=$newsubj_id 
			WHERE level_id>13 AND subject_id=$oldsubj_id; ";
		$q.="UPDATE {$dbg}.05_courses 
			SET supsubject_id=$newsubj_id 
			WHERE level_id>13 AND supsubject_id=$oldsubj_id; ";			
		$q.="UPDATE {$dbg}.05_subjects_coordinators 
			SET subject_id=$newsubj_id 
			WHERE level_id>13 AND subject_id=$oldsubj_id; ";
		pr($q);
		if(isset($_GET['exe'])){
			$sth=$db->query($q);
			echo ($sth)? "success":"fail";echo "<br />";			
		}

	}	
}	/* fxn */




public function scripts(){
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=PDBG;

	// 1
	$cond_active=isset($_GET['active'])? 'AND is_active='.$_GET['active']:'AND is_active=2';
	$crstype_id=isset($_GET['crstype'])? $_GET['crstype']:1;
	$order_cri=isset($_GET['order_cri'])? $_GET['order_cri']:'position';
	$q="SELECT id,code,name,is_active,position FROM {$dbo}.05_criteria WHERE crstype_id=$crstype_id $cond_active ORDER BY $order_cri; ";
	$data['query']['criteria']=$q;
	$sth=$db->querysoc($q);
	$data['cri_rows']=$sth->fetchAll();
	$data['cri_count']=$sth->rowCount();

	// 2
	$order_st=isset($_GET['order_st'])? $_GET['order_st']:'position';
	$q="SELECT * FROM {$dbo}.05_subjtypes ORDER BY $order_st; ";
	$data['query']['subjtypes']=$q;
	$sth=$db->querysoc($q);
	$data['st_rows']=$sth->fetchAll();
	$data['st_count']=$sth->rowCount();

	

	
	$data['scripts']['q1']=" UPDATE {$dbg}.05_components SET criteria_id=?? WHERE criteria_id=?? ; ";
	$data['scripts']['q2']="
		UPDATE {$dbg}.05_components AS comp 
		INNER JOIN {$dbo}.05_subjects AS sub ON comp.subject_id=sub.id
		INNER JOIN {$dbo}.05_subjtypes AS st ON sub.subjtype_id=st.id
		INNER JOIN {$dbo}.05_criteria AS cri ON comp.criteria_id=cri.id
		SET comp.weight=77 
		WHERE st.id=1 AND cri.id=163 AND cri.is_active=2; ";
	$data['scripts']['q3']="UPDATE {$dbo}.05_components 	
		SET subject_id=?? 
		WHERE level_id>13 AND subject_id=??
	";

		// INNER JOIN {$dbo}.05_subjtypes AS ost ON os.subjtype_id=ost.id
		// INNER JOIN {$dbo}.05_subjtypes AS nst ON ns.subjtype_id=nst.id
	
	$data['scripts']['q4']="
		SHS - Create and Change Subject ID - 1) courses 2) components <br />
		// 1 - select from tbl.subjchange <br />
		SELECT sc.*,os.name AS oldsubj,ns.name AS newsubj,
			os.subjtype_id AS ost_id,
			ns.subjtype_id AS nst_id,
		FROM {$dbg}.05_subjchanges AS sc 
		INNER JOIN {$dbo}.05_subjects AS os ON sc.oldsubj_id=os.id
		INNER JOIN {$dbo}.05_subjects AS ns ON sc.newsubj_id=os.id		
		ORDER BY os.name;
		<br />
		// 2 - update components <br />		
		UPDATE {$dbg}.05_components 
		SET subject_id=?? 
		WHERE level_id>13 AND subject_id=??
		<br />
		// 3 - courses.subject_id <br />		
		UPDATE {$dbg}.05_courses 
		SET subject_id=?? 
		WHERE level_id>13 AND subject_id=??;
		<br />
		// 4 subjects_coordinators <br />				
		UPDATE {$dbg}.05_subjects_coordinators 
		SET supsubject_id=?? 
		WHERE level_id>13 AND supsubject_id=??;
		<br />
		
		
	";
	
	
	
	
	$this->view->render($data,"components/scriptsComponents");
	
	
}	/* fxn */


public function edit($params){		
	$dbo=PDBO;
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);				

	require_once(SITE."functions/criteria.php");
	require_once(SITE."functions/components.php");
	$data['home']=$_SESSION['home'];
	$ssy=$_SESSION['sy'];
	$db=&$this->model->db;$dbg=PDBG;
	$ucid=$_SESSION['user']['ucid'];
	$today=$_SESSION['today'];
	
	if(isset($_POST['submit'])){
		$rows = $_POST['components'];				
		$q = "";
		foreach($rows as $row){	
			$q .= "UPDATE {$dbg}.05_components SET `criteria_id` = ".$row['criteria_id'].",
				`weight` = '".$row['weight']."',`semester` = '".$row['semester']."',
				`modified_ecid`=$ucid,`modified_date`='$today' WHERE `id` = '".$row['id']."' LIMIT 1; "; 
		} 
		debug($q);
		$sth=$db->query($q);		
		$url=$_SESSION['url'];
		flashRedirect($url,"Saved.");
		exit;		
	} /* submitted */
	
	/* for batch delete */
	if(isset($_POST['batch'])){
		$ids = $_POST['rows'];
		foreach($ids AS $id){
			deleteComponent($db,$id);
		}
		
		$level_id = isset($_SESSION['level_id'])? $_SESSION['level_id']:4;
		$url = 'gset/components/'.$level_id;
		redirect($url);		
	}
	
	
	$num_params = count($params);
	for($i=0;$i<$num_params;$i++){
		$data['components'][$i] = readComponents($db,$params[$i]);
	}			

	$data['selectscriteria'] = fetchRows($db,"{$dbo}.`05_criteria`","id,name,crstype_id");	
	$data = isset($data)? $data : null;		
	$this->view->render($data,'components/editComponents');		
	
}		/* fxn */


public function delete($params){
	$dbo=PDBO;
	$acl = array(array(5,0));
	/* 2nd param is strict,default is false */	
	$this->permit($acl);			

	$dbg=PDBG;$db=&$this->model->db;
	$component_id = $params[0];
	$q = " DELETE FROM {$dbg}.05_components WHERE `id` = '$component_id' LIMIT 1; ";
	$db->query($q);
	$level_id = isset($_SESSION['components']['level_id'])? $_SESSION['components']['level_id'] : 1;
	$url = 'gset/components/'.$level_id;
	redirect($url);
} 	/* fxn */



public function add($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	require_once(SITE."functions/components.php");
	$db =& $this->model->db;
	
	if(isset($_POST['submit'])){
		// pr($_POST);
		$rows = $_POST['components'];		
		$q = " INSERT INTO `{$dbg}`.`05_components` (`criteria_id`,`level_id`,`subject_id`,`weight`) VALUES ";
foreach($rows AS $row){
	$q .= " ('".$row['criteria_id']."','".$row['level_id']."','".$row['subject_id']."','".$row['weight']."'),";		
}
		$q = rtrim($q,",");
		$q .= ";";
		$db->query($q);
		$level_id = isset($_SESSION['components']['level_id'])? $_SESSION['components']['level_id'] : 1;
		$url = 'gset/components/'.$level_id;
		redirect($url);
		exit;				
	} /* post-submit */
	$data['selects'] = selectsForAddComponents($db,$dbg);	
	$data = isset($data)? $data : null;		
	$this->view->render($data,'components/add');		

}	/* fxn */


public function addMisc($params=NULL){
	$dbo=PDBO;
	include_once(SITE.'views/elements/params_sq.php');
	require_once(SITE."functions/components.php");
	$db =& $this->model->db;

	if(isset($_POST['submit'])){
		$rows = $_POST['components'];
		$q = " INSERT INTO {$dbg}.05_components (`criteria_id`,`level_id`,`subject_id`,`weight`) VALUES ";
foreach($rows AS $row){		
	$q .= " ('".$row['criteria_id']."','".$row['level_id']."','".$row['subject_id']."','".$row['weight']."'),";
}
		$q = rtrim($q,",");
		$q .= ";";
		$db->query($q);
		$level_id = isset($_SESSION['components']['level_id'])? $_SESSION['components']['level_id'] : 1;
		$url = 'gset/components/'.$level_id;
		redirect($url);
		exit;
			
	} /* post-submit */

	$data['selects'] = selectsForAddMiscComponents($db,$dbg);	
	$data = isset($data)? $data : null;		
	$this->view->render($data,'components/addMisc');		

}	/* fxn */


public function filter(){
$dbo=PDBO;
$db=&$this->model->db;$dbg=PDBG;
if(isset($_GET['filter'])){
	$params = isset($_GET)? $_GET:array();
	$cond = "";
	$sort = (isset($params['sort']))? $params['sort']:'com.level_id,subject';
	$order = (isset($params['order']))? $params['order']:'ASC';
	
	if (!empty($params['ctype'])){ $cond .= " AND cri.crstype_id = '".$params['ctype']."'"; }				
	if (!empty($params['level_id'])){ $cond .= " AND com.level_id = '".$params['level_id']."'"; }				
	if (!empty($params['criteria_id'])){ $cond .= " AND com.criteria_id = '".$params['criteria_id']."'"; }				
	if (!empty($params['subject_id'])){ $cond .= " AND com.subject_id = '".$params['subject_id']."'"; }				

	$q = "
		SELECT cri.id AS criteria_id,com.id AS component_id,com.*,cri.*,sub.name AS subject,cri.name AS criteria
		FROM {$dbg}.05_components AS com
			INNER JOIN {$dbo}.`05_criteria` AS cri ON com.criteria_id = cri.id
			INNER JOIN {$dbo}.`05_subjects` AS sub ON com.subject_id = sub.id
		WHERE 1=1 $cond		
		ORDER BY $sort $order ; ";
	debug($q);
	$sth = $db->querysoc($q);
	$data['rows'] = $rows = $sth->fetchAll();
	$data['count'] = count($rows);

} 	/* get */


/* for batch edits */
if(isset($_POST['batch'])){
	$ids = stringify($_POST['rows']);		
	$url = 'components/edit/'.$ids;
	redirect($url);		
}


$data['ctypes'] = $this->model->fetchRows("{$dbo}.`05_crstypes`","id,name","name");
$data['subjects'] = $this->model->fetchRows("{$dbo}.`05_subjects`","id,name","name");
$data['levels'] = $this->model->fetchRows("{$dbo}.`05_levels`","id,name","id");
$data['criteria'] = $this->model->fetchRows("{$dbo}.`05_criteria`","id,name","name");

$this->view->render($data,'components/filterComponents');


}	/* fxn */


public function view($params=NULL){
	$dbo=PDBO;
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/classrooms.php");
	require_once(SITE."functions/components.php");
	
	$data['level_id'] = $level_id = isset($params[0])? $params[0]:4;
	$_SESSION['level_id']	= $level_id;
	$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->model->db;$dbg=VCPREFIX.$sy.US.DBG;
	
	/* for batch edits */
	if(isset($_POST['batch'])){
		$ids = stringify($_POST['rows']);		
		$url = 'components/modify/'.$ids;
		redirect($url);		
	}
		
	$data['level'] 	= getLevelDetails($db,$level_id,$dbg);
	$_SESSION['components']['level_id'] = $level_id;
	$rdata  = getComponentsByLevel($db,$level_id,$dbg);	
	$data['q']  = $rdata['q'];
	$data['components']  = $rdata['components'];	
	$data['classrooms']  = getClassroomsByLevel($db,$level_id,$dbg); 
	if(!isset($_SESSION['levels'])){ $_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,label,code,name","id"); }
	$data['levels'] = $_SESSION['levels'];
	
	$this->view->render($data,'components/view');

}	/* fxn */


public function modify($params){		
	$dbo=PDBO;
	require_once(SITE."functions/criteria.php");
	require_once(SITE."functions/components.php");
	$db =& $this->model->db;

	$data['home']	= $_SESSION['home'];
	$ssy	= DBYR;
	$dbg	= PDBG;
	$ucid   = $_SESSION['user']['ucid'];
	$today 	= $_SESSION['today'];
	
	if(isset($_POST['submit'])){
		$rows = $_POST['components'];				
		$q = "";
		foreach($rows as $row){	
			$q .= "UPDATE {$dbg}.05_components SET `criteria_id` = ".$row['criteria_id'].",
				`weight` = '".$row['weight']."',`semester` = '".$row['semester']."',
				`modified_ecid`=$ucid,`modified_date`='$today' WHERE `id` = '".$row['id']."' LIMIT 1; "; 
		} 
		$db->query($q);		
		$level_id = isset($_SESSION['components']['level_id'])? $_SESSION['components']['level_id'] : 1;
		$url = 'components/view/'.$level_id;
		redirect($url);
		exit;		
	} /* submitted */
		
	
	$num_params = count($params);
	for($i=0;$i<$num_params;$i++){
		$data['components'][$i] = readComponents($db,$params[$i]);
	}			

	$data['selectscriteria'] = fetchRows($db,"{$dbo}.`05_criteria`","id,name,crstype_id");	
	$data = isset($data)? $data : null;		
	$this->view->render($data,'components/modify');		
	
}		/* fxn */


public function setup($params=NULL){
$db=&$this->model->db;$dbo=PDBO;$dbg=PDBG;
require_once(SITE.'functions/components.php');

$data['ctype_id']=$ctype_id=isset($params[0])? $params[0]:1;

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	/* i */
	$lvlstr=$post['levels'];
	$lvlarr= explode(',',$lvlstr);	
	/* j */
	$substr=$post['subjects'];
	$subarr=explode(',',$substr);
	/* k */
	$cristr=$post['criterias'];
	$criarr=explode(',',$cristr);
	$numcri=count($criarr);	
	$wtstr=$post['weights'];
	$wtarr=explode(',',$wtstr);	
	$q="";
	foreach($lvlarr AS $l){
		foreach($subarr AS $s){
			for($k=0;$k<$numcri;$k++){
				$q.=insertComponentIfNotExists($db,$criarr,$wtarr,$k,$l,$s);
			}	/* cri */			
		}	/* sub */	
	}	/* lvl */
	debug($q);
	$sth=$db->query($q);
	$msg = ($sth)? "Success":"Failure";
	flashRedirect("components/setup",$msg);	
	exit;

}	/* post */

$where=isset($_GET['all'])? NULL:" WHERE crstype_id='$ctype_id' ";
$data['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,name","id");
$data['criteria']=fetchRows($db,"{$dbo}.`05_criteria`","id,name,crstype_id","name",$where);
$data['subjects']=fetchRows($db,"{$dbo}.`05_subjects`","id,name","name",$where);

$this->view->render($data,'components/setupComponents');


}	/* fxn */


public function crid($params=NULL){
	$db=&$this->baseModel->db;
	$crid=isset($params[0])? $params[0]:80;
	$dbo=PDBO;$dbg=PDBG;
	
// subjtype	subject	course-name	criteria	weight	edit
	
	$q="
		SELECT
			subj.subjtype_id,subj.name AS subject,crs.name AS course,
			cri.name AS criteria,comp.weight,crs.semester,
			subj.id AS subject_id,
			crs.id AS course_id,
			cri.id AS criteria_id
		FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbg}.05_courses AS crs ON crs.crid=cr.id
		INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
		INNER JOIN {$dbo}.05_sections AS s ON cr.section_id=s.id
		INNER JOIN {$dbg}.05_components AS comp ON comp.level_id=l.id
		INNER JOIN {$dbo}.05_criteria AS cri ON comp.criteria_id=cri.id
		INNER JOIN {$dbo}.05_subjects AS subj ON comp.subject_id=subj.id
		WHERE crs.crid=$crid
		ORDER BY crs.semester,crs.name
		;
			
	";

	$q="
		SELECT
			subj.subjtype_id,subj.name AS subject,crs.name AS course,
			cri.name AS criteria,comp.weight,crs.semester,
			subj.id AS subject_id,
			crs.id AS course_id,
			cri.id AS criteria_id
		FROM {$dbg}.05_classrooms AS cr
		INNER JOIN {$dbg}.05_courses AS crs ON crs.crid=cr.id
		LEFT JOIN {$dbg}.05_components AS comp ON comp.level_id=cr.level_id
		LEFT JOIN {$dbo}.05_subjects AS subj ON crs.subject_id=subj.id
		LEFT JOIN {$dbo}.05_criteria AS cri ON comp.criteria_id=cri.id
		WHERE crs.crid=$crid
		ORDER BY crs.semester,crs.name,cri.position
		;
		
		
	";

	
	
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$q="
		SELECT id,name FROM {$dbg}.05_classrooms WHERE id=$crid LIMIT 1;
	";
	$sth=$db->querysoc($q);
	$data['cr']=$sth->fetch();
	
	
	
	
	$this->view->render($data,"components/cridComponents");
	
}	/* fxn */




}	/* ComponentsController */
