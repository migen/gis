<?php

Class SynclistController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();

}

public function index(){	
	$dbo=PDBO;$dbg=PDBG;$db=$this->baseModel->db;
	$data['levels']=$_SESSION['levels'];
	$vfile="synclist/indexSynclist";$this->view->render($data,$vfile);
}	/* fxn */


public function crid($params=NULL){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/synclistFxn.php");
	$data['crid']=$crid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$dbo=PDBO;$dbp=PDBP;
	$dbg=VCPREFIX.$sy.US.DBG;$db=$this->baseModel->db;

	$q=qryString($sy);
	$order=$_SESSION['settings']['classlist_order'];	
	$q.=" WHERE summ.crid=$crid ORDER BY $order LIMIT 200; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	$data['classroom']=getSimpleClassroomDetails($db,$crid);
	$vfile="synclist/cridSynclist";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function lvl($params=NULL){
	require_once(SITE."functions/details.php");
	require_once(SITE."functions/synclistFxn.php");
	$data['lvl']=$lvl=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$dbo=PDBO;$dbp=PDBP;
	$dbg=VCPREFIX.$sy.US.DBG;$db=$this->baseModel->db;
	$data['levels']=$_SESSION['levels'];
	
	$q=qryString($sy);
	$order="cr.name,c.name";
	$q.=" WHERE cr.level_id=$lvl ORDER BY $order LIMIT 500; ";
	debug($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	
	$data['level']=getLevelDetails($db,$lvl);
	
	
	$vfile="synclist/lvlSynclist";vfile($vfile);
	$this->view->render($data,$vfile);
	
}	/* fxn */


public function syncAll($params=NULL){	// with Summaries
	require_once(SITE."functions/synclistFxn.php");
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$dbo=PDBO;$dbp=PDBP;
	$dbg=VCPREFIX.$sy.US.DBG;$db=$this->baseModel->db;
	
	$q=qryString($sy);
	$q.=" WHERE c.role_id=".RSTUD." AND c.is_active=1;";	
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	pr("Count: ".$count);

/* sync */	
$q="INSERT INTO {$dbo}.05_enrollments(`sy`,`scid`)VALUES";
foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['enscid'])){ $q.="($sy,$scid),"; }  } 
$q=rtrim($q,",");$q.=";";$db->query($q);

$q="INSERT INTO {$dbg}.05_summaries(`scid`)VALUES";
foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['summscid'])){ $q.="($scid),"; } } 
$q=rtrim($q,",");$q.=";";$db->query($q);

$q="INSERT INTO {$dbg}.05_summext(`scid`)VALUES";
foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['sumxscid'])){ $q.="($scid),"; } } 
$q=rtrim($q,",");$q.=";";$db->query($q);

$q="INSERT INTO {$dbg}.05_attendance(`scid`)VALUES";
foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['attdscid'])){ $q.="($scid),"; } } 
$q=rtrim($q,",");$q.=";";$db->query($q);

$q="INSERT INTO {$dbo}.00_ctp(`contact_id`)VALUES";
foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['ctpscid'])){ $q.="($scid),"; } } 
$q=rtrim($q,",");$q.=";";$db->query($q);

$q="INSERT INTO {$dbo}.00_profiles(`contact_id`)VALUES";
foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['profscid'])){ $q.="($scid),"; } } 
$q=rtrim($q,",");$q.=";";$db->query($q);

echo "Synced.";
	
	
}	/* fxn */



public function syncTable($params=NULL){	// with Summaries
	$data['sy']=$sy=isset($params[0])? $params[0]:DBYR;
	$dbo=PDBO;$dbp=PDBP;
	$dbg=VCPREFIX.$sy.US.DBG;$db=$this->baseModel->db;
	
	$q=" SELECT c.id AS ucid,c.parent_id AS pcid ";
if(isset($_GET['enrollments'])){ $q.=",en.scid AS enscid "; } 			
if(isset($_GET['summaries'])){ $q.=",summ.scid AS summscid "; } 			
if(isset($_GET['summext'])){ $q.=",sumx.scid AS sumxscid "; } 			
if(isset($_GET['attd'])){ $q.=",attd.scid AS attdscid "; } 			
if(isset($_GET['ctp'])){ $q.=",ctp.contact_id AS ctpscid "; } 			
if(isset($_GET['profiles'])){ $q.=",prof.contact_id AS profscid "; } 			
if(isset($_GET['photos'])){ $q.=",ph.contact_id AS phscid "; } 			
	$q.=" FROM {$dbo}.00_contacts AS c ";
if(isset($_GET['enrollments'])){ $q.=" LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=c.id) "; } 			
if(isset($_GET['summaries'])){ $q.=" LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id "; } 			
if(isset($_GET['summext'])){ $q.=" LEFT JOIN {$dbg}.05_summext AS sumx ON sumx.scid=c.id "; } 			
if(isset($_GET['attd'])){ $q.=" LEFT JOIN {$dbg}.05_attendance AS attd ON attd.scid=c.id "; } 			
if(isset($_GET['ctp'])){ $q.=" LEFT JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id "; } 			
if(isset($_GET['profiles'])){ $q.=" LEFT JOIN {$dbo}.00_profiles AS prof ON prof.contact_id=c.id "; } 			
if(isset($_GET['photos'])){ $q.=" LEFT JOIN {$dbp}.photos AS ph ON ph.contact_id=c.id "; } 			
	$q.=" WHERE c.role_id=".RSTUD." AND c.is_active=1; ";
	pr($q);
	$sth=$db->querysoc($q);
	$data['rows']=$rows=$sth->fetchAll();
	$data['count']=$count=$sth->rowCount();
	pr("Count: ".$count);

/* sync */	
if(isset($_GET['enrollments'])){ $q="INSERT INTO {$dbo}.05_enrollments(`sy`,`scid`)VALUES ";
	foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['enscid'])){ $q.="($sy,$scid),"; } } }	/* table */

if(isset($_GET['summaries'])){ $q="INSERT INTO {$dbg}.05_summaries(`scid`)VALUES ";
	foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['summscid'])){ $q.="($scid),"; } } }	/* table */

if(isset($_GET['summext'])){ $q="INSERT INTO {$dbg}.05_summext(`scid`)VALUES ";
	foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['sumxscid'])){ $q.="($scid),"; } } }	/* table */

if(isset($_GET['attd'])){ $q="INSERT INTO {$dbg}.05_attendance(`scid`)VALUES ";
	foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['attdscid'])){ $q.="($scid),"; } } }	/* table */

if(isset($_GET['ctp'])){ $q="INSERT INTO {$dbo}.00_ctp(`contact_id`)VALUES ";
	foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['ctpscid'])){ $q.="($scid),"; } } }	/* table */

if(isset($_GET['profiles'])){ $q="INSERT INTO {$dbo}.00_profiles(`contact_id`)VALUES ";
	foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['profscid'])){ $q.="($scid),"; } } }	/* table */

if(isset($_GET['photos'])){ $q="INSERT INTO {$dbp}.photos(`contact_id`)VALUES ";
	foreach($rows AS $row){ $scid=$row['ucid']; if(!isset($row['phscid'])){ $q.="($scid),"; } } }	/* table */


$q=rtrim($q,",");$q.=";";

if(empty($q)){ echo "Nothing to Sync."; } else { pr("&exe"); pr("Query - ".$q);	}
if(isset($_GET['exe'])){ $sth=$db->query($q); echo ($sth)? "<h3 class='red' >Success.</h3>":"<h3 class='red'>FAIL</h3>"; }

	$vfile="synclist/synctableSynclist";vfile($vfile);
	$this->view->render($data,$vfile);
	
	
}	/* fxn */


public function scid($params=NULL){
	require_once(SITE."functions/synclistFxn.php");
	$data['scid']=$scid=isset($params[0])? $params[0]:false;
	$data['sy']=$sy=isset($params[1])? $params[1]:DBYR;
	$dbo=PDBO;$dbp=PDBP;
	$dbg=VCPREFIX.$sy.US.DBG;$db=$this->baseModel->db;
	if(!$scid){ echo "no scid"; exit; }
	
	syncScid($db,$sy,$scid);	
}	/* fxn */




}	/* BlankController */
