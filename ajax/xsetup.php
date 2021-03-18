<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbg = PDBG;
$dbo = PDBO;

	
switch($_POST['task']){


case "xeditSuco":
	$q = " UPDATE {$dbo}.`05_subjects_coordinators` SET `hcid` = '".$_POST['ucid']."'
			WHERE `id` = '".$_POST['sacid']."' LIMIT 1;";
	$db->query($q);
	// $_SESSION['q'] = $q;
	break;


case "xAddTerminal":	
	$q = "INSERT INTO {$dbo}.`03_terminals_employees`(`ecid`,`terminal`) VALUES ('".$_POST['ecid']."','".$_POST['terminal']."');";
	$db->query($q);
	// $_SESSION['q'] = $q;
	break;
	
case "xSaveTerminal":
	$sy=$_POST['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$q = " UPDATE {$dbo}.`03_terminals_employees` SET `terminal` = '".$_POST['terminal']."' 
		WHERE `id` = '".$_POST['pkid']."' LIMIT 1;";
	$db->query($q);
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
