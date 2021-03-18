<?php

Class LegendsController extends Controller{	

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



public function traits($params=NULL){
$dbo=PDBO;	
$db=&$this->model->db;
$dbg=PDBG;$dbg=&$dbg;

$q="
	SELECT * FROM {$dbo}.`05_criteria` WHERE `crstype_id`='".CTYPETRAIT."' ORDER BY name;
";

$sth=$db->querysoc($q);
$data['rows']=$sth->fetchAll();
$data['count']=count($data['rows']);

$this->view->render($data,'legends/traits');

}	/* fxn */





public function equivalents(){
$dbo=PDBO;
	$dbg  = PDBG;
	$dbg=&$dbg;
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype']:1;
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : 2;	

	$type = " crstype_id = '$ctype' " ;		
	if ($dept_id == 1) 			$dept = " is_ps = '1' ";
		elseif ($dept_id == 3) 	$dept = " is_hs = '1' ";
		else 					$dept = " is_gs = '1' ";
	
	if(isset($_POST['save'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.05_equivalents SET 
				`floor`='".$post['floor']."',`ceiling`='".$post['ceiling']."',`equivalent`='".$post['equivalent']."',
				`is_ps`='".$post['is_ps']."',`is_gs`='".$post['is_gs']."',`is_hs`='".$post['is_hs']."'
				WHERE `id`='".$post['eid']."' LIMIT 1;"; 
		}	/* foreach */		
		$this->model->db->query($q);
		$url = "legends/equivalents?ctype=$ctype";
		flashRedirect($url,'Saved.');		
		
	}	/* fxn */
	
	if(isset($_POST['add'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts AS $post){
			$q.="INSERT INTO {$dbg}.05_equivalents(`floor`,`ceiling`,`equivalent`,`is_ps`,`is_gs`,`is_hs`,`crstype_id`) 
				VALUES ('".$post['floor']."','".$post['ceiling']."','".$post['equivalent']."','".$post['is_ps']."','".$post['is_gs']."','".$post['is_hs']."','$ctype'); ";
		}	/* foreach */
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "legends/equivalents?ctype=$ctype";
		flashRedirect($url,'Added new.');		
		
	}	/* add */

	/* 2 */
	$q   = " SELECT *,id AS eid FROM {$dbg}.05_equivalents WHERE $type AND $dept ORDER BY `equivalent` DESC; ";	
	if(isset($_GET['debug'])){ pr($q); }
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $rows = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	
	$q   = " SELECT * FROM {$dbo}.`05_crstypes` WHERE `id` ='$ctype'; ";	
	if(isset($_GET['debug'])){ pr($q); }
	$sth = $this->model->db->querysoc($q);	
	$row = $sth->fetch();
	$data['crstype'] = $row['name'];
	
	$this->view->render($data,'legends/equivalents');

}	/* fxn */



public function descriptions(){
$dbo=PDBO;
	$dbg  = PDBG;
	$dbg=&$dbg;
	$data['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype']:1;
	$data['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : 2;	

	$type = " crstype_id = '$ctype' " ;		
	if ($dept_id == 1) 			$dept = " is_ps = '1' ";
		elseif ($dept_id == 3) 	$dept = " is_hs = '1' ";
		else 					$dept = " is_gs = '1' ";

	
	if(isset($_POST['save'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts AS $post){
			$q.="UPDATE {$dbg}.05_descriptions SET 
				`grade_floor`='".$post['floor']."',
				`grade_ceiling`='".$post['ceiling']."',
				`description`='".$post['description']."',
				`rating`='".$post['rating']."',
				`is_ps`='".$post['is_ps']."',
				`is_gs`='".$post['is_gs']."',
				`is_hs`='".$post['is_hs']."'
				WHERE `id`='".$post['did']."' LIMIT 1;
			"; 
		}	/* foreach */
		$this->model->db->query($q);
		$url = "legends/descriptions?ctype=$ctype&dept=$dept_id";
		flashRedirect($url,'Saved.');		
		
	}	/* fxn */
	
	if(isset($_POST['add'])){
		$posts = $_POST['posts'];
		$q = "";
		foreach($posts AS $post){
			$q.="INSERT INTO {$dbg}.05_descriptions(`grade_floor`,`grade_ceiling`,`description`,`rating`,`is_ps`,`is_gs`,`is_hs`,`crstype_id`) 
				VALUES ('".$post['floor']."','".$post['ceiling']."','".$post['description']."','".$post['rating']."','".$post['is_ps']."','".$post['is_gs']."','".$post['is_hs']."','$ctype'); ";
		}	/* foreach */
		// pr($q); exit;
		$this->model->db->query($q);
		$url = "legends/descriptions?ctype=$ctype";
		flashRedirect($url,'Added new.');		
		
	}	/* add */

	/* 2 */
	$q   = " SELECT *,id AS did FROM {$dbg}.05_descriptions WHERE $type and $dept ORDER BY `grade_ceiling` DESC; ";	
	debug($q);
	$sth = $this->model->db->querysoc($q);
	$data['rows'] = $rows = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	
	$q   = " SELECT * FROM {$dbo}.`05_crstypes` WHERE `id` ='$ctype'; ";	
	$sth = $this->model->db->querysoc($q);	
	$row = $sth->fetch();
	$data['crstype'] = $row['name'];
	
	$this->view->render($data,'legends/descriptions');

}	/* fxn */






















}	/* LegendsController */
