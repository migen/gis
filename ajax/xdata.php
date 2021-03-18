<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){	



case "xgetRowById":	/* 20200226 */
	$post=$_POST;$dbtable=$post['dbtable'];$id=$post['id'];	
	$q="SELECT * FROM $dbtable WHERE id=$id LIMIT 1; ";	
	$_SESSION['q']=$q;
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);			
	break;	


case "xgetIdByCode":	/* 20200226 */
	$post=$_POST;$dbtable=$post['dbtable'];$part=$post['part'];	
	$q="SELECT id FROM $dbtable WHERE code = '".$part."' OR name='".$part."' LIMIT 1; ";	
	$_SESSION['q']=$q;
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	echo json_encode($row);			
	break;	



case "xsaveData":	/* 20200226 */
	if(isset($_POST['logdetails'])){
		$sy=isset($_POST['logsy'])? $_POST['logsy']:DBYR;
		$module_id=isset($_POST['module_id'])? $_POST['module_id']:1;
		if(isset($_POST['module_id'])){ unset($_POST['module_id']); }

		$dbg=VCPREFIX.$sy.US.DBG;
		$details=$_POST['logdetails'];
		unset($_POST['logsy']);unset($_POST['logdetails']);
		$ip=$_SERVER['REMOTE_ADDR'];$ucid=$_SESSION['ucid'];$ts=date("Y-m-d H:i:s");
		$q="INSERT INTO {$dbo}.logs(`sy`,`ip`,`datetime`,`ucid`,`module_id`,`details`)VALUES(?,?,?,?,?,?);";
		$sth=$db->prepare($q);
		$sth->execute([$sy,$ip,$ts,$ucid,$module_id,$details]); 
		
	}	/* log */
	
	/* process */
	$post=$_POST;unset($post['task']);unset($post['dbtable']);
	$dbtable=$_POST['dbtable'];		
	$db->add($dbtable,$post);	
	$_SESSION['q1']=$post;
	break;	



case "xdeleteData":	/* 20200226 */
	if(isset($_POST['logdetails'])){
		$sy=isset($_POST['logsy'])? $_POST['logsy']:DBYR;
		$module_id=isset($_POST['module_id'])? $_POST['module_id']:1;
		$dbg=VCPREFIX.$sy.US.DBG;
		$details=$_POST['logdetails'];
		unset($_POST['logdetails']);
		$ip=$_SERVER['REMOTE_ADDR'];$ucid=$_SESSION['ucid'];$ts=date("Y-m-d H:i:s");
		$q="INSERT INTO {$dbo}.logs(`sy`,`ip`,`datetime`,`ucid`,`module_id`,`details`)VALUES(?,?,?,?,?,?);";
		$sth=$db->prepare($q);
		$sth->execute([$sy,$ip,$ts,$ucid,$module_id,$details]); 
			
	}	/* log */

	/* process */
	$post=$_POST;unset($post['task']);unset($post['dbtable']);
	$dbtable=$_POST['dbtable'];$id=$_POST['id'];		
	$db->delete($id,$dbtable); 
	break;	

	

case "xgetData":	/* 20200226 */
	$post=$_POST;$dbtable=$post['dbtable'];$limit=$post['limit'];$part=$post['part'];	
	// 2
	$q="SELECT id,code,name FROM $dbtable WHERE code LIKE '%".$part."%' OR name LIKE '%".$part."%' LIMIT $limit; ";	
	$_SESSION['q']=$post;
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	echo json_encode($rows);	
		
	break;	



case "xeditData":
	$post=$_POST;unset($post['task']);unset($post['dbtable']);unset($post['id']);
	$dbtable=$_POST['dbtable'];	$id=$_POST['id'];	
	$db->update($dbtable,$post,"`id`=$id");
	break;	

/* gisv3 */
case "xsaveDataNotOK":
	$post=$_POST;unset($post['task']);unset($post['dbtable']);
	$dbtable=$_POST['dbtable'];	
	$db->createIfNotExists($dbtable,$post);	
	break;	
	

default:
	break;

	
		
	

}	/* switch */




	

	
