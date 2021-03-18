<?php

Class SeedersController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}


public function beforeFilter(){
	parent::loginRedirect();
	$acl = array(array(5,0));
	$this->permit($acl);				
}	/* fxn */


public function index(){ 
	pr('<h1>Seeders for MIS only - Home</h1> | Schema');
	pr("tuitions");
	pr("tfees");
	// $data['home']	= $_SESSION['home'];
	// $this->view->render($data,'tests/index');

}	/* fxn */



public function addRecordsBySY($params=NULL){
	if((!isset($params[0])) || (!isset($params[1]))){ 
		prx("param-table and param-sy required."); }
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$dbtable=$params[0];
	$nextsy=$params[1];
	$currsy=$nextsy-1;
	$url = "seeders/addRecordsBySY/{$dbtable}/$nextsy";
	
	if(isset($_SESSION['message'])){ pr('<h1>'.$_SESSION['message'].'</h1>'); unset($_SESSION['message']); }

	pr("Target");
	$q="SELECT * FROM {$dbtable} WHERE sy=$nextsy ORDER BY id; ";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$num_target=$sth->rowCount();
	debug($rows);
	
	pr("Source");
	$q="SELECT * FROM {$dbtable} WHERE sy=$currsy ORDER BY id; ";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$num_source=$sth->rowCount();	
	debug($rows);

	if($num_target==$num_source){
		pr("Synced.");
		pr("count - $num_target");
	} else {
		echo "<h1 class='brown'>&exe</h1>";
		if(isset($_GET['exe'])){
			foreach($rows AS $row){
				unset($row['id']);
				$row['sy']=$nextsy;
				$db->add("{$dbtable}",$row);
			}
			
			$msg = "Added $nextsy $dbtable for all levels";
			flashRedirect($url,$msg);
			
					
		}
		
	}


	
}





public function tuitions($params=NULL){
	// migrateNextSyTuition
	if(!isset($params[0])){ prx("param-sy required."); }
	$db=&$this->baseModel->db;
	$dbo=PDBO;
	$nextsy=$params[0];
	$currsy=$nextsy-1;

	$url = "tuitions/table/$nextsy";

	pr("Target");
	$q="SELECT * FROM {$dbo}.03_tuitions WHERE sy=$nextsy ORDER BY id; ";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$num_target=$sth->rowCount();
	debug($rows);
	
	pr("Source");
	$q="SELECT * FROM {$dbo}.03_tuitions WHERE sy=$currsy ORDER BY id; ";
	pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$num_source=$sth->rowCount();	
	debug($rows);

	if($num_target==$num_source){
		pr("Synced.");
		pr("count - $num_target");
	} else {
		echo "<h1 class='brown'>&exe</h1>";
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


	
}




}	/* TuitionsController */
