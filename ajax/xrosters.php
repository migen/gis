<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

// functions
include_once(SITE.'functions/enrollmentFxn.php');		




$dbo=PDBO;$dbg=PDBG;
$has_axis=$_SESSION['settings']['has_axis'];


switch($_POST['task']){


case "xeditRoster":
	$row=$_POST;$sy=$row['sy'];$dbg=VCPREFIX.$sy.US.DBG;
	$scid=$row['scid'];$crid=$row['crid'];$acid=$row['acid'];
	enrollStudent($db,$sy,$scid,$crid);
break;	
	
	
case "releaseRoster":
	$row=$_POST;$sy=$row['sy'];$scid=$row['scid'];$dbg=VCPREFIX.$sy.US.DBG;		
	enrollStudent($db,$sy,$scid,$crid=0);	
break;		



case "moveToTmp":
	$row=$_POST;$sy=$row['sy'];$dbg=VCPREFIX.$sy.US.DBG;
	$q="";
if($sy==DBYR){
	$q.=" UPDATE {$dbo}.`00_contacts` SET `prevcrid`=crid,`crid`=".$row['tmpcrid']." WHERE `id`=".$row['scid']." LIMIT 1; ";		
}		
	$q.="UPDATE {$dbo}.05_enrollments SET `crid`=".$row['tmpcrid']." WHERE `scid`=".$row['scid']." LIMIT 1; ";	
	$q.="UPDATE {$dbg}.05_summaries SET `crid`=".$row['tmpcrid']." WHERE `scid`=".$row['scid']." LIMIT 1; ";	
	$db->query($q);
break;	


case "moveToOut":
	$row=$_POST;$sy=$row['sy'];$dbg=VCPREFIX.$sy.US.DBG;$q="";
if($sy==DBYR){
	$q.=" UPDATE {$dbo}.`00_contacts` SET `prevcrid`=crid,`crid`=".$row['outcrid']." WHERE `id`=".$row['scid']." LIMIT 1; ";		
}		
	$q.="UPDATE {$dbo}.05_enrollments SET `crid`=".$row['outcrid']." WHERE `scid`=".$row['scid']." LIMIT 1; ";	
	$q.="UPDATE {$dbg}.05_summaries SET `crid`=".$row['outcrid']." WHERE `scid`=".$row['scid']." LIMIT 1; ";	
	$db->query($q);
break;	
	
	
case "registerStudent":	
	$row=$_POST;$sy=isset($row['sy'])? $row['sy']:DBYR;$dbg=VCPREFIX.$sy.US.DBG;
	$pass=MD5('pass');	
	$crid=$_POST['crid'];$acid = $_POST['acid'];	
	$code=trim($_POST['code']);$name=trim($_POST['stud']);	
	$code=preg_replace("([^0-9a-zA-Z-/])", "", $code);
	$name=preg_replace("([^0-9a-zA-Z-, /])", "", $name);	
	$long_enough=(strlen($code)>3)? true:false;
	if(!$long_enough){ return false; }
	
$q="SELECT id FROM {$dbo}.`00_contacts` WHERE `code`='$code' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$avail = (empty($row))? true:false;	

if($avail){
	$pcid=lastId($db,"{$dbo}.`00_contacts`");	
	$pcid+=1;	
	$q="";	
	$q.=" INSERT IGNORE INTO {$dbo}.`00_contacts` (`id`,`parent_id`,`name`,`code`,`account`,
			`pass`,`title_id`,`role_id`,`privilege_id`,`sy`,`crid`) 
		VALUES ('$pcid','$pcid','$name','$code','$code','$pass',1,1,1,$sy,$crid); ";
	$q.="INSERT IGNORE INTO {$dbo}.`00_profiles` (`contact_id`) VALUES ($pcid);";			
	$q.="INSERT IGNORE INTO {$dbg}.05_summaries (`scid`,`crid`) VALUES ($pcid,$crid); ";
	$q.="INSERT IGNORE INTO {$dbg}.05_attendance (`scid`) VALUES ($pcid); ";
	$q.="INSERT IGNORE INTO {$dbo}.`00_ctp`(`contact_id`,`ctp`,`ctpb`) VALUES ('$pcid','pass','pass'); ";
	$db->query($q);
}

	$_SESSION['q'] = $q;		
break;	


case "xeditSection":
	$q = " UPDATE {$dbo}.`05_sections` SET `code` = '".$_POST['code']."',`name` = '".$_POST['name']."',
		`position` = '".$_POST['position']."' WHERE `id` = '".$_POST['id']."' LIMIT 1; ";
	$db->query($q);
break;
	
	
case "xgetStudentsByPartRosters":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT c.id,c.name,c.code,c.account,c.parent_id,c.role_id,c.privilege_id,summ.crid,summ.crid AS summcrid
		FROM {$dbo}.`00_contacts` AS c
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE c.`role_id`='".RSTUD."' AND (c.`code` LIKE '%".$part."%' 
		OR c.`account` LIKE '%".$part."%' OR c.`name` LIKE '%".$part."%') 
		ORDER BY c.`name` LIMIT $limits;  ";		
	$_SESSION['q'] = $q;	
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$rows = array_map(function($r) {
	  $r['name'] = utf8_encode($r['name']);
	  return $r;
	}, $rows);	
	echo json_encode($rows);	
	break;

case "xeditCridAndPrevcrid":
	extract($_POST);
	$q="";
	$dbg=VCPREFIX.$sy.US.DBG;$dbo=PDBO;
	$q.="UPDATE {$dbg}.05_summaries SET prevcrid=$prevcrid,crid=$crid WHERE scid=$scid LIMIT 1; ";
	$q.="UPDATE {$dbo}.05_enrollments SET crid=$crid WHERE scid=$scid AND sy=$sy LIMIT 1; ";
	$sth=$db->query($q);
	$msg=($sth)? "Success":"Fail";

	$_SESSION['q']=$msg.' - '.$q;
	break;

	
		
default:
	break;

	
	

}	/* switch */




	

	
