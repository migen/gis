<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");
$dbg = PDBG;	
$dbo = PDBO;	


switch($_POST['task']){

case "xsaveDisplay":
	$prid = $_POST['prid'];
	$in_t1 = $_POST['in_t1'];$in_t2 = $_POST['in_t2'];$in_t3 = $_POST['in_t3'];
	$in_t4 = $_POST['in_t4'];$in_t5 = $_POST['in_t5'];$in_t6 = $_POST['in_t6'];
	
	$q = "UPDATE {$dbo}.`03_products` SET
		`in_t1`='$in_t1',`in_t2`='$in_t2',`in_t3`='$in_t3',
		`in_t4`='$in_t4',`in_t5`='$in_t5',`in_t6`='$in_t6'
		WHERE `id`='$prid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "xdeletePODetail":
	$pdid = $_POST['pdid'];
	$q = "DELETE FROM {$dbo}.`30_podetails` WHERE `id` = '$pdid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "xdeletePOPayment":
	$ppid = $_POST['ppid'];
	$q = "DELETE FROM {$dbo}.`30_po_payments` WHERE `id` = '$ppid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "xsavePOPayment":
	$ppid = $_POST['ppid'];
	$amount = $_POST['amount'];
	$reference = $_POST['reference'];
	$q = "UPDATE {$dbo}.`30_po_payments` SET `amount`='$amount',`reference`='$reference' WHERE `id` = '$ppid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;	
	
case "xdeleteSupplier":
	$psid = $_POST['psid'];
	$q = " DELETE FROM {$dbg}.`products_suppliers` WHERE id = '$psid' LIMIT 1; ";	
	$db->query($q);
	$_SESSION['q'] = $q;
	break;



case "xsaveTIP":
	$dbg=PDBG;
	$date=$_SESSION['today'];
	$prid = $_POST['prid'];
	$cost = $_POST['cost'];	
	$price = $_POST['price'];	
	$qtyold = $_POST['qtyold'];	
	$t = $_POST['t'];	
	$qty = $_POST['qty'];
	$q = " UPDATE {$dbo}.`03_products` SET `t{$t}` = '$qty',`cost`='$cost',`price`='$price' WHERE `id` = '$prid' LIMIT 1; ";
	$db->query($q);
	$tmax=$_SESSION['settings']['numterminals'];
	$expr="level=(";
	for($i=1;$i<=$tmax;$i++){ $expr.="t{$i}+"; }
	$expr=rtrim($expr,"+");
	$expr.=")";
	$q=" UPDATE {$dbo}.`03_products` SET $expr WHERE `id` = '$prid' LIMIT 1;";
	$db->query($q);	
	/* 3 - invlogs */
	$io=$qty-$qtyold;
	$q="INSERT INTO {$dbg}.30_invlogs(`date`,`prid`,`terminal`,`io`)VALUES ('$date','$prid','$t','$io'); ";
	$_SESSION['q'] = $q;		
	$db->query($q);		
	break;
	
	
	
default:
	break;


	
}	/* switch */
