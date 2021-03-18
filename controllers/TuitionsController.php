<?php

Class TuitionsController extends Controller{	

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


public function level($params=NULL){
	$data['lvl']=$lvl=isset($params[0])? $params[0]:4;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	if(isset($_POST['submit'])){
		$posts=$_POST['posts'];
		$total=0;
		
		/* one - tfeedetails  */
		foreach($posts AS $post){
			$id=$post['id'];unset($post['id']);
			$amount=str_replace(",","",$post['amount']);			
			$in_total=$post['in_total'];
			$total+=($in_total)? $amount:0;
			$db->update("{$dbo}.03_tfeedetails",$post,"id=$id");
		}
		/* two - total summary */ 
		$tfid=$_POST['tf']['id'];
		$tf['total']=$total;
		// pr($tf);exit;
		
		$db->update("{$dbo}.`03_tuitions`",$tf,"id=$tfid AND sy=$sy");		
		flashRedirect("tuitions/level/$lvl/$sy","Saved.");		
		exit;
	}	/* fxn */
	
	$data['num']=$num=isset($_GET['num'])? $_GET['num']:1;
	$q="SELECT d.*,d.id AS pkid,f.name AS feetype,f.parent_id
		FROM {$dbo}.03_tfeedetails AS d
		LEFT JOIN {$dbo}.03_feetypes AS f ON d.feetype_id=f.id
		WHERE d.sy=$sy AND d.level_id=$lvl AND d.num=$num ORDER BY d.position;";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	// $data['level']=fetchRow($db,"{$dbo}.05_levels",$lvl);
	$q="SELECT l.name,t.level_id,t.num,l.id,t.total AS amount,t.id AS pkid
		FROM {$dbo}.05_levels AS l
		INNER JOIN {$dbo}.`03_tuitions` AS t ON l.id=t.level_id
		WHERE t.sy=$sy AND t.level_id=$lvl AND t.num=$num;";
	debug($q);		
	$sth=$db->querysoc($q);
	$data['level']=$sth->fetch();
	
	//
	$data['levels']=$_SESSION['levels'];
	
	$vfile=(isset($_GET['edit']))? "tuitions/levelTuitionsEdit":"tuitions/levelTuitions";		
	$this->view->render($data,$vfile);
	
	
}	/* fxn */



public function table($params=NULL){
$dbo=PDBO;
$db=&$this->model->db;
$data['sy']=$sy=isset($params[0])? $params[0]:$_SESSION['year'];
$dbg=VCPREFIX.$sy.US.DBG;
$dbg=&$dbg;
$schema=$dbo;
$table="03_tuitions";

$q = "SELECT t.*,l.name AS lvlname,t.id AS pkid 
FROM {$dbo}.03_tuitions AS t
INNER JOIN {$dbo}.05_levels AS l ON t.level_id=l.id 
WHERE sy=$sy ORDER BY t.level_id ASC;";
debug("TuitionsCtlr-tableFxn:<br /> $q ");
$sth = $db->querysoc($q);
$data['rows'] = $rows = $sth->fetchAll();
$data['count'] = count($rows);


if(!isset($_SESSION['levels'])){ 
	$_SESSION['levels']=fetchRows($db,"{$dbo}.05_levels","id,code,name,department_id,subdepartment_id","id"); 
}
$data['levels']=$_SESSION['levels'];
$vfile='tuitions/tableTuitions';vfile($vfile);
$this->view->render($data,$vfile);


}	/* fxn */


public function edit($params){
	if(!isset($params)){ pr("Pkid not set."); exit; }
	$data['id']=$id=$params[0];
	$db=&$this->baseModel->db;$dbo=PDBO;
	$dbtable="{$dbo}.03_tuitions";
	if(isset($params[1])){
		$data['sy']=$sy=$params[1];		
	} else {
		$row=fetchRow($db,$dbtable,$id,"sy");
		$data['sy']=$sy=$row['sy'];
	}
	
	if(isset($_POST['submit'])){
		$post=$_POST['tuition'];
		$db->update($dbtable,$post,"id=$id");
		flashRedirect("tuitions/table/$sy","Saved.");
	}	/* post */
	
	$q="SELECT t.*,t.id AS pkid,l.name AS lvlname
		FROM {$dbo}.05_levels AS l 
		INNER JOIN {$dbo}.03_tuitions AS t ON t.level_id=l.id
		WHERE t.id=$id LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['row']=$sth->fetch();
	
	$this->view->render($data,"tuitions/editTuition");
	
	
}	/* fxn */


public function syncTuitionAmount(){
	$data['sy']=$sy=$_SESSION['settings']['sy_enrollment'];
	$db=&$this->baseModel->db;$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
		// LEFT JOIN {$dbo}.03_tfeedetails AS d ON (t.level_id=d.level_id && t.num=d.num && t.sy=d.sy)
	
	$q1=" SELECT t.id AS pkid,d.amount AS tuition_amount,t.level_id,d.sy,l.name AS level,
			t.num,t.total,t.tuition_amount AS saved_tuition_amount
		FROM {$dbo}.03_tuitions AS t 
		LEFT JOIN {$dbo}.03_tfeedetails AS d ON (t.level_id=d.level_id && t.num=d.num  && t.sy=d.sy)
		LEFT JOIN {$dbo}.05_levels AS l ON t.level_id=l.id 
		WHERE d.feetype_id=1 AND t.sy=$sy 
		ORDER BY t.level_id,t.num ";
	debug($q1);
	$q=" UPDATE {$dbo}.03_tuitions AS a 
		INNER JOIN (";
	$q.=$q1;		
	$q.=") AS b ON b.pkid=a.id
		SET a.tuition_amount=b.tuition_amount
	";
	debug($q);
	if(isset($_GET['exe'])){
		$sth=$db->query($q);
		echo ($sth)? "Success":"Fail";
				
	}
	$sth=$db->querysoc($q1);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	
	$this->view->render($data,"tuitions/syncTuitionAmount");
	
	
}	/* fxn */


public function nextSyTuitions($params=NULL){
	// migrateNextSyTuition
	if(!isset($params[0])){ prx("param-sy required."); }
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$nextsy=$params[0];
	$currsy=$nextsy-1;

	$url = "tuitions/table/$nextsy";

	echo "<h1 class='brown'>&exe</h1>";
	pr("Target");
	$q="SELECT * FROM {$dbo}.03_tuitions WHERE sy=$nextsy ORDER BY id; ";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	debug($rows);
	
	pr("Source");
	$q="SELECT * FROM {$dbo}.03_tuitions WHERE sy=$currsy ORDER BY id; ";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	debug($rows);

	if(isset($_GET['exe'])){
		foreach($rows AS $row){
			unset($row['id']);
			$row['sy']=$nextsy;
			$db->add("{$dbo}.03_tuitions",$row);
		}
		
		$msg = "Added $nextsy tuition for all levels";
		flashRedirect($url,$msg);
		
				
	}

	
}




}	/* TuitionsController */
