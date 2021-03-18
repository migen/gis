<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbg = PDBG;

switch($_REQUEST['task']){	


case "xgetSubjectsByPart":
	$part = $_REQUEST['part'];
	$q = " SELECT * FROM {$dbo}.`05_subjects` WHERE `name` LIKE '%".$part."%' ORDER BY `name` ;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows['data'] = $sth->fetchAll();
	echo json_encode($rows);
	break;

case "xgetContactsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT id,name,code,parent_id,crid,role_id,privilege_id 
		FROM {$dbo}.`00_contacts` WHERE `name` LIKE '%".$part."%' 
		OR `code` LIKE '%".$part."%' ORDER BY `name` LIMIT $limits;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$rows = array_map(function($r) {
	  $r['name'] = utf8_encode($r['name']);
	  return $r;
	}, $rows);		
	echo json_encode($rows);
	break;
	

case "xeditSubject":
	$subid=$_POST['sub'];
	$q = " UPDATE {$dbo}.`05_subjects` SET 
			`is_active` 	 = '".$_POST['actv']."',`is_num` 	 = '".$_POST['num']."',
			`with_scores` 	 = '".$_POST['ws']."',`is_kpup` = '".$_POST['kpup']."',
			`parent_id` = '".$_POST['prnt']."',`weight` = '".$_POST['wt']."',
			`in_genave` = '".$_POST['iga']."',`affects_ranking` = '".$_POST['ar']."',
			`indent` = '".$_POST['indt']."',`is_aggregate` = '".$_POST['aggre']."',
			`is_transmuted` = '".$_POST['trans']."',`is_active` = '".$_POST['actv']."',
			`name` = '".$_POST['name']."',`code` = '".$_POST['code']."',
			`position` = '".$_POST['pos']."',
			`crstype_id` = '".$_POST['cty']."'
		WHERE `id` = '$subid' LIMIT 1;  ";
	$_SESSION['q'] = 'sessQ - '.$q;
	$db->query($q);

	break;


case "xeditFdn":
	$id=$_POST['id'];
	$dbg=VCPREFIX.$_POST['sy'].US.DBG;
	$q = " UPDATE {$dbo}.`05_subjects` SET `is_foundation` = '".$_POST['isFdn']."',`fdntype_id` = '".$_POST['fdnType']."'
		WHERE `id` = '$id' LIMIT 1;  ";
	$_SESSION['q']=$q;
	$db->query($q);
	break;
	
			
	
default:
	break;

	
		
	

}	/* switch */




	

	
