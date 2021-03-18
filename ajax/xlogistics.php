<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");
$dbo = PDBO;	
$dbg = PDBG;


switch($_POST['task']){

case "xdeleteSmvDetail":
	$sdid = $_POST['sdid'];
	$q = "DELETE FROM {$dbo}.`30_smvdetails` WHERE `id` = '$sdid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;

case "xdelPmvdid":
	$pmvdid = $_POST['pmvdid'];
	$tfrom = $_POST['tfrom'];
	$q="SELECT * FROM {$dbo}.`30_pmvdetails` WHERE id='$pmvdid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	/* 2 */
	$qty=$row['mvqty'];
	$tdest=$row['terminal'];
	$prid=$row['prid'];
	$q="UPDATE {$dbo}.`03_products` SET `t{$tfrom}`=`t{$tfrom}`+ '$qty',`t{$tdest}`=`t{$tdest}`- '$qty' WHERE `id`='$prid' LIMIT 1; ";
	$db->query($q);	
	/* 3 */
	$q = "DELETE FROM {$dbo}.`30_pmvdetails` WHERE `id` = '$pmvdid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
	
case "movePO":
	$poid = $_POST['poid'];
	$prid = $_POST['prid'];
	$qty = $_POST['qty'];
	$tfrom=$_POST['tfrom'];
	$cost=$_POST['cost'];
	$t = $_POST['t'];
	$q = "INSERT INTO {$dbo}.`30_pmvdetails`(`poid`,`terminal`,`prid`,`mvqty`,`cost`) VALUES ";
	$q.= "('$poid','$t','$prid','$qty','$cost');";
	$_SESSION['q'] = $q;
	
	$db->query($q);
	/* 2 */
	$q="UPDATE {$dbo}.`03_products` SET `t{$t}`=`t{$t}`+'$qty',`t{$tfrom}`=`t{$tfrom}`-'$qty' ";
	$q.=" WHERE `id`='$prid' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q'] .= $q;	
	break;
	
	
default:
	break;


	
}	/* switch */
