<?php

Class AddonsController extends Controller{	

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



public function add($params=NULL){
require_once(SITE."functions/addons.php");
$db=&$this->model->db;
$ssy = $_SESSION['sy'];
$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;

$data['scid']=$scid=isset($params[0])? $params[0]:false;
if($scid){ 
	$data['student']=$student=fetchRow($db,"{$dbo}.`00_contacts`",$scid);
	$data['tsum']=justTsum($db,$scid,$dbg);		
}

if(isset($_POST['submit'])){
	$post=$_POST['post'];
	$post['scid']=$scid;

	$db->add("{$dbg}.`30_auxes`",$post);
	$fid=$post['feetype_id'];
/* 2 - with combo devt fee */	
	$q = "SELECT a.*,b.amount AS comboamount  
			FROM {$dbo}.`03_feetypes` AS a 
				LEFT JOIN {$dbo}.`03_feetypes` AS b ON a.combo = b.id
			WHERE a.id = '$fid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$combo = $row['combo'];
	if($combo>0){
	$q = " INSERT INTO {$dbg}.`20_auxes`(`scid`,`feetype_id`,`amount`,`due`,`num`) VALUES 
			('$scid','".$row['combo']."','".$row['comboamount']."','".$_SESSION['today']."','1');  ";						
			$db->query($q);
	}
	
	flashRedirect("ledgers/pay/$scid/$sy","Fee added.");
	exit;
}	/* post */

$data['feetypes']=$_SESSION['feetypes'];
$this->view->render($data,'addons/add');
}	/* fxn */



public function edit($params){
	$data['tauxid']=$tauxid = $params[0];	
	$ssy = $_SESSION['sy'];
	$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
	$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;	
	$data['url']=isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:URL.$_SESSION['home'];
	
	/* 1 - getscid */
	$q = "SELECT 
			a.*,c.name AS student,f.name AS feetype 
		FROM {$dbg}.`30_auxes` AS a
			LEFT JOIN {$dbo}.`00_contacts` AS c ON a.scid = c.id
			LEFT JOIN {$dbo}.`03_feetypes` AS f ON a.feetype_id = f.id
		WHERE a.`id` = '$tauxid' LIMIT 1;";
	$sth = $this->model->db->querysoc($q);
	$data['row'] = $sth->fetch();
	$data['scid'] = $scid = $data['row']['scid'];

	if(isset($_POST['submit'])){
		$aux = $_POST['aux'];
		$url=$_POST['url'];
		$this->model->db->update("{$dbg}.`30_auxes`",$aux,"id = '$tauxid'");
		redirectURL($url);
		exit;
	}	/* post */
		
	$data['feetypes'] = $this->model->fetchRows("{$dbo}.`03_feetypes`","*","name");
	$this->view->render($data,'addons/edit');
	

}	/* fxn */



public function delete($params){
	$priv=$_SESSION['user']['privilege_id'];
	if($priv!=0){ echo "Not supervisor level."; exit; }
	$tauxid = $params[0];	
	$ssy = $_SESSION['sy'];
	$data['sy'] = $sy = isset($params[1])? $params[1]:$ssy;
	$db=&$this->model->db;$dbo=PDBO;$dbg = VCPREFIX.$sy.US.DBG;$dbg = VCPREFIX.$sy.US.DBG;	
	$q="SELECT scid FROM {$dbg}.`30_auxes` WHERE `id`='$tauxid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$scid=$row['scid'];		
	$q="DELETE FROM {$dbg}.`30_auxes` WHERE `id`='$tauxid' LIMIT 1; ";
	$db->query($q);
	$url="ledgers/pay/$scid/$sy";
	flashRedirect($url,'Addon deleted');	
}	/* fxn */






















}	/* AddonsController */
