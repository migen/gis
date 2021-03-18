<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
$dbg = PDBG;


switch($_POST['task']){


case "ptl":
	$idfrom = $_POST['idfrom'];
	$idto 	= $_POST['idto'];

	$q  = "";
	/* 1 */
	$q .= " UPDATE {$dbg}.05_courses SET `tcid` = '$idto' WHERE `tcid` = '$idfrom'; ";
	$q .= " UPDATE {$dbg}.05_courses SET `hcid` = '$idto' WHERE `hcid` = '$idfrom'; ";
	$q .= " UPDATE {$dbg}.05_classrooms SET `acid` = '$idto' WHERE `acid` = '$idfrom'; ";
	$q .= " UPDATE {$dbg}.05_classrooms SET `chinese_acid` = '$idto' WHERE `chinese_acid` = '$idfrom'; ";
	$q .= " UPDATE {$dbg}.05_summaries SET `acid` = '$idto' WHERE `acid` = '$idfrom'; ";
	
	/* 2 */
	$q .= " DELETE FROM {$dbo}.`00_contacts` WHERE `id` = '$idfrom' LIMIT 1; ";
	$q .= " DELETE FROM {$dbo}.`00_profiles` WHERE `contact_id` = '$idfrom' LIMIT 1; ";
	$q .= " DELETE FROM ".DBP.".photos WHERE `contact_id` = '$idfrom' LIMIT 1; ";
	$q .= " DELETE FROM {$dbo}.`00_ctp` WHERE `contact_id` = '$idfrom' LIMIT 1; ";
		
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$_SESSION['message'] = 'Contact user deleted.'; 
	break;

case "xeditContact":
	$row = $_POST;	
	$id = $row['id'];
	unset($row['task']);
	unset($row['id']);	
	$db->update(DBO.".`00_contacts`",$row,"id=$id");	
	break;

	
case "xeditProfile":
	$row = $_POST;	
	$contact_id = $row['id'];
	unset($row['task']);
	unset($row['id']);
	$db->update(DBO.".`00_profiles`",$row,"contact_id=$contact_id");	
	break;

	
case "xstatusContact":
	$q = " UPDATE {$dbo}.`00_contacts` SET `is_active` = '".$_POST['status']."' WHERE `id` = '".$_POST['ucid']."' LIMIT 1;  ";
	$db->query($q);
	break;

	
case "xverifyCode":
	$code = $_POST['code'];
	$q 		= " SELECT `id`,`parent_id` AS `pcid`,`code`,`account`,`name` FROM {$dbo}.`00_contacts` 
			WHERE `code` = '$code' OR `account` = '$code' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;

	
	
default:
	break;

	
	

}	/* switch */




	

	
