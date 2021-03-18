<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;


switch($_POST['task']){


		

case "addOrno":
	$q = "INSERT INTO {$dbg}.ornos (`date`,`orno`,`is_void`,`remarks`) VALUES 
		('".$_POST['date']."','".$_POST['orno']."','".$_POST['is_void']."','".$_POST['remarks']."');";
	$_SESSION['q'] = $q;
	$db->query($q);		
	break;

case "xvoidOrno": /* pos report */
	$oid = $_POST['oid'];
	$q = "UPDATE {$dbg}.ornos SET `is_void` = '1' WHERE `id` = '$oid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "xunvoidOrno": /* pos report */
	$oid = $_POST['oid'];
	$q = "UPDATE {$dbg}.ornos SET `is_void` = '0' WHERE `id` = '$oid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
case "hasDuplicateOrno": /* pos report */
	$orno = $_POST['orno'];
	$orno = trim($orno);
	$q = "SELECT id,orno FROM {$dbg}.30_payments WHERE `orno` = '$orno' LIMIT 1;";
	$sth = $db->querysoc($q);	
	$row = $sth->fetch();
	echo json_encode($row);	
	$_SESSION['q']=$q;
	break;

case "xdeletePayment": 
	$sy = $_POST['sy'];
	$pid = $_POST['pid'];
	$dbg=VCPREFIX.$sy.US.DBG;	
	$q = "DELETE FROM {$dbg}.`30_payments` WHERE `id` = '$pid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "xdeleteBill": 
	$sy = $_POST['sy'];
	$pid = $_POST['pid'];
	$dbg=VCPREFIX.$sy.US.DBG;	
	$q = "DELETE FROM {$dbg}.`30_payments_bills` WHERE `id` = '$pid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
