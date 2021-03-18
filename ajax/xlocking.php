<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$id = $_POST['id'];
$dbg=PDBG;

switch($_POST['task']){

case "xeditLockingConduct":
	extract($_POST);
	$dbg=VCPREFIX.$sy.US.DBG;
	$q=" UPDATE {$dbg}.`05_advisers_quarters` SET 
			`conduct_q1`=$q1,`conduct_q2`=$q2,`conduct_q3`=$q3,`conduct_q4`=$q4
		WHERE `id`='$pkid' LIMIT 1; ";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;

		
default:
	break;







}	/* switch */


