<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."library/Functions.php");
require_once(SITE."functions/logs.php");


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){


case "xaddStudent":
	$row=$_POST;
	$code=$row['code'];$name=$row['name'];$is_male=$row['is_male'];	
	unset($row['task']);
	$dbcontacts="{$dbo}.00_contacts";
	$dbprofiles="{$dbo}.00_profiles";
	$dbsummaries="{$dbg}.05_summaries";
	$last_scid=lastId($db,$dbcontacts);
	$scid=($last_scid+1);
	$q="INSERT IGNORE INTO $dbcontacts(id,parent_id,code,account,name,is_male,title_id,role_id,privilege_id)
		VALUES($scid,$scid,'$code','$code','$name',$is_male,1,1,1);";	
	$q.="INSERT IGNORE INTO $dbprofiles(`contact_id`)VALUES($scid);";
	$q.="INSERT IGNORE INTO $dbsummaries(`scid`)VALUES($scid);";
	// $_SESSION['q1']=$q;
	$sth=$db->query($q);
	
	$_SESSION['q1']=$q;	
	$_SESSION['q1'].=($sth)? "Success":"Failed";	
	/* 2 logs */
	// $axn = $_SESSION['axn']['editcsy'];
	$axn=1;$ucid=&$scid;	
	$details = "student added - $code $name";
	$more['ecid']=$_SESSION['ucid'];
	logThis($db,$ucid,$axn,$details,$more);						
	break;


case "xeditContact":
	$row = $_POST;
	$id=$row['scid'];
	unset($row['task']);
	unset($row['scid']);
	$db->update("{$dbo}.`00_contacts`",$row,"id='$id'");
	
	/* 2 logs */
	$axn = $_SESSION['axn']['editcsy'];
	$details = "links-students-edit";
	$ucid = $id;
	$more['ecid'] = $_SESSION['ucid'];
	logThis($db,$ucid,$axn,$details,$more);						
	break;


case "xeditStudent":
	$row = $_POST;
	$q = " UPDATE {$dbg}.05_students SET
		`incsubj` 			= '".$row['incsubj']."',
		`is_discountable` 	= '".$row['discount']."',
		`years_in_school` 	= '".$row['yis']."',
		`year_entry` 		= '".$row['ye']."',
		`level_entry` 		= '".$row['le']."',
		`batch` 			= '".$row['batch']."'
		WHERE `contact_id` = '".$row['cid']."' LIMIT 1;
	";	 
	$_SESSION['q'] = $q;
	$db->query($q);
	break;



case "xeditQualified":
	$row = $_POST;
	$qtr = $_POST['qtr'];
	$q = " UPDATE {$dbg}.05_summaries SET
		`is_qualified_q{$qtr}` 		= '".$row['qualified']."' 
		WHERE `scid`  = '".$row['scid']."' LIMIT 1;
	";	 
	// $_SESSION['q'] = $q;
	$db->query($q);
	break;



case "qualifySumscid":
	$row = $_POST;
	$qtr = $_POST['qtr'];
	$q = " UPDATE {$dbg}.05_summaries SET
		`is_qualified_q{$qtr}` 		= '1' 
		WHERE `scid`  = '".$row['scid']."' LIMIT 1;
	";	 
	// $_SESSION['q'] = $q;
	$db->query($q);
	break;
	

case "disqualifySumscid":
	$row = $_POST;
	$qtr = $_POST['qtr'];
	$q = " UPDATE {$dbg}.05_summaries SET
		`is_qualified_q{$qtr}` 		= '0' 
		WHERE `scid`  = '".$row['scid']."' LIMIT 1;
	";	 
	// $_SESSION['q'] = $q;
	$db->query($q);
	break;
	
	
default:
	break;

	
	

}	/* switch */




	

	
