<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");

$dbg = PDBG;


switch($_POST['task']){


case "xgetFee":
	$dbg = VCPREFIX.DBYR.US.DBG;
	$q = " SELECT * FROM {$dbo}.`03_feetypes` WHERE `id` = '".$_POST['ftid']."' LIMIT 1;  ";
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;


case "xdeleteInvoicePayment":
	$q = " SELECT * FROM {$dbg}.30_payments WHERE `id` = '".$_POST['payid']."' LIMIT 1;  ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();

	$q = " DELETE FROM {$dbg}.30_payments WHERE `id` = '".$_POST['payid']."' LIMIT 1;  ";	
	$_SESSION['q'] = $q;
	$db->querysoc($q);
	
	/* 2 logs */
	$axn = $_SESSION['axn']['delete_payment'];
	$details = "Pymt Date: ".$row['date'];
	$ucid = $_SESSION['user']['ucid'];	
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $row['scid'];
	$more['orno'] = $row['orno'];
	$more['feeid'] = $row['feetype_id'];
	$more['amount'] = $row['amount'];
	logThis($db,$ucid,$axn,$details,$more);	
	break;


case "xaddInvoicePayment":
	$pay=$_POST;
	unset($pay['task']);

	if($pay['amount']>0){
		$db->add("{$dbg}.30_payments",$pay);
		$q = "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '".$pay['orno']."' WHERE `ecid` = '".$pay['ecid']."' LIMIT 1;";
		$db->query($q);
		$_SESSION['orno'] = $pay['orno']; 				
	}	/* pay */		
	break;

	
default:
	break;

	
	

}	/* switch */




	

	
