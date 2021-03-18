<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		




$dbg=PDBG;

switch($_POST['task']){

case "xeditSection":
	$q = " UPDATE {$dbo}.`05_sections` SET `code` = '".$_POST['code']."',`name` = '".$_POST['name']."',`position` = '".$_POST['position']."' 
			WHERE `id` = '".$_POST['id']."' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q']=$q;
	break;

	
case "xeditCrig":
	$crid = $_POST['crid'];
	$q = " UPDATE {$dbg}.05_classrooms SET `is_init_grades` = '0'
		WHERE `id` = '$crid' LIMIT 1;  ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
case "xeditClsAdmin":
	$crid = $_POST['crid'];
	$sy = $_POST['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbg=&$dbg;
	
	$q = " UPDATE {$dbg}.05_classrooms SET 				
				`is_modified_acid` = '1',
				`num` = '".$_POST['num']."',
				`name` = '".$_POST['name']."',
				`label` = '".$_POST['label']."',
				`acid` = '".$_POST['advi']."',
				`hcid` = '".$_POST['coor']."' 
			WHERE `id` = '".$crid."' LIMIT 1;
	";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;


case "xgetLvl":
	$crid = $_POST['crid'];
	$dbg=PDBG;
	$q="SELECT id,acid,level_id,level_id AS lvl,department_id AS dept 
		FROM {$dbg}.05_classrooms WHERE id='$crid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	$_SESSION['q'] = $q;
	
	break;
	
	
default:
	break;

	
	

}	/* switch */




	

	
