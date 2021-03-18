<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;
$dbg=PDBG;


switch($_POST['task']){

case "xeditAq":
	$crid 	= $_POST['crid'];$row = $_POST;$qtr = $_POST['qtr'];
	$q = "";	
 	$sth = $db->query($q);
	$_SESSION['q'] = $q;
	break;

case "cridLvl":	
	$crid = $_POST['crid'];
	$q = " SELECT level_id AS lvl FROM {$dbg}.05_classrooms  WHERE `id` = '$crid' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;
	

case "clsAdvi":
	$sy = $_POST['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	$crid = $_POST['crid'];
	$q = " SELECT id AS crid,acid,level_id FROM {$dbg}.05_classrooms  WHERE `id` = '$crid' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;

case "xcrid":
	$dbg = PDBG;
	$crid = $_POST['crid'];
	$q = " SELECT 
				cr.id AS crid,cr.acid,cr.level_id,
				l.department_id
			FROM {$dbg}.05_classrooms AS cr
				LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id			
			WHERE cr.`id` = '$crid' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;


case "xeditSectioning":
	$post = $_POST;
	$psy=isset($_POST['psy'])? $_POST['psy']:DBYR;	/* paramsy */
	$dbo=PDBO;$dbg=VCPREFIX.$psy.US.DBG;$dbg=VCPREFIX.$psy.US.DBG;
	$current=($psy==DBYR)?true:false;
	$q = "";
	$q .= " UPDATE {$dbo}.`00_contacts` SET `is_active` = '".$post['is_active']."',`sy` = '".$post['sy']."',";
	if($current){ $q.="`crid` = '".$post['crid']."',"; }
	$q.="`is_male` = '".$post['male']."' WHERE `id`	= '".$post['scid']."' LIMIT 1; ";			
	$q .= "UPDATE {$dbg}.05_summaries SET `crid` = '".$post['crid']."',`acid` = '".$post['acid']."'
		WHERE `scid` = '".$post['scid']."' LIMIT 1;";	
	$q .= "UPDATE {$dbg}.03_tsummaries SET `crid` = '".$post['crid']."' WHERE `scid` = '".$post['scid']."' LIMIT 1; ";	
	$db->query($q);
	$_SESSION['q'] = $q;	
	break;	


case "xpromoteScid":
	$sy=isset($_POST['sy'])? $_POST['sy']:DBYR;	/* paramsy */
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;
	$scid=$_POST['scid'];$lvl=$_POST['currlvl'];
	$q="SELECT id AS nxtcrid,level_id AS nxtlvl
			FROM {$dbg}.05_classrooms WHERE level_id=($lvl+1) AND section_id=1;";	
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$nxtcrid=$row['nxtcrid'];
	$q="UPDATE {$dbg}.05_summaries SET `crid`='$nxtcrid' WHERE `scid`='$scid' LIMIT 1;  ";
	$db->query($q);
	$_SESSION['q'] = $q;	
	$_SESSION['message'] = "Section updated.";	
	break;	

	
		
default:
	break;

	
	

}	/* switch */




	

	
