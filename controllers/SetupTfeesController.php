 <?php
/**
 * @copyright MIDASGEN | PCMED-MIGEN
 */

 /* from MyController */
Class SetupTfeesController extends Controller{
/*
1) ac (code=account)
2) cricode (code=name)

*/


public function __construct(){
	parent::__construct();
	parent::beforeFilter();
	$this->view->js = array('js/jquery.js','js/jqueryui.js','js/vegas.js');		
	$acl = array(array(5,0));
	$this->permit($acl);					
	
}	/* fxn */


public function index(){
	$data = NULL;
	$this->view->render($data,'setup/indexSetup');
	
}	/* fxn */


public function lockTuitionLevels($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbo=PDBO;$db=&$this->baseModel->db;
	$q="UPDATE {$dbo}.03_tuitions SET is_finalized=1 WHERE sy=$sy; ";
	$sth=$db->query($q);
	$msg=$sth? "Lock Tuition Levels lock - done":"Lock Tuition Levels - failed";
	flashRedirect('index',$msg);
	
}	/* fxn */


public function openTuitionLevels($params=NULL){
	$sy=isset($params[0])? $params[0]:DBYR;
	$dbo=PDBO;$db=&$this->baseModel->db;
	$q="UPDATE {$dbo}.03_tuitions SET is_finalized=0 WHERE sy=$sy; ";
	$sth=$db->query($q);
	$msg=$sth? "Open Tuition Levels - done":"Open Tuition Levels - failed";
	flashRedirect('index',$msg);
	
}	/* fxn */



public function syncDetails($params=NULL){
	$data['sy_from']=$sy_from=isset($params[0])? $params[0]:DBYR;
	$data['sy_to']=$sy_to=($sy_from+1);
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$data['brid']=$brid=$_SESSION['brid'];
		
	pr($data);
	pr("<h1>Copy tuition fee details from SY{$sy_from} to SY{$sy_to} for all. <br>Params-0 is sy_to. </h1>");
	
	pr('<h1>&debug to not redirect</h1>');
	
	if(!isset($_GET['exe'])){
		pr("<a href='".URL."setupTfees/syncDetails/".$sy_from."&exe' >Proceed?</a>");
	}
	
	
	if(isset($_GET['exe'])){
		// 1 - delete all details from destination
		$info='';
		$q="DELETE FROM {$dbo}.03_tfeedetails WHERE sy=$sy_to AND branch_id=$brid; ";
		$info.=$q;
		$info.="<br>";
		
		$sth=$db->query($q);
		$info .= "delete $sy_to details from db - ";
		$info .= ($sth)? "ok":"fail";
		$info.="<br>";
		
		echo '<hr>';
		
		// 2 - select all from src
		$q="SELECT * FROM {$dbo}.03_tfeedetails WHERE branch_id=$brid AND sy=$sy_from ORDER BY id; ";
		$sth=$db->querysoc($q);
		$rows=$sth->fetchAll();
		
		// insert to dest
		$q="INSERT INTO {$dbo}.03_tfeedetails(sy,level_id,num,feetype_id,amount,branch_id,
			position,is_displayed,in_total,indent,amount_hidden) VALUES ";
		$info.=$q."<br>";
		foreach($rows AS $row){
			extract($row);
			$q.="($sy_to,$level_id,$num,$feetype_id,'$amount',$branch_id,$position,$is_displayed,$in_total,
				$indent,$amount_hidden),";
		}
		$q=rtrim($q,',');$q.=";";
		
		$sth=$db->query($q);
		$info.="insert to db - ";
		$info.= ($sth)? "ok":"fail";
		$info.="<br>";
		
		if(isset($_GET['debug'])){
			pr($info); 			
		} else {
			flashRedirect('index','Tfeedetails synced.');
		}
		
		
	}	/* exe */
	
	
	
	
}	/* fxn */






} /* SetupController */
