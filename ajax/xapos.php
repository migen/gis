<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

// var crid=$('select[name="students['+i+'][crid]"]').val();


$table_products="00_products";
$dbg=PDBG;$dbo=PDBO;


switch($_POST['task']){




case "getProductDetails":
	$id=$_POST['prid'];
	$q = " SELECT * FROM {$dbo}.`{$table_products}` WHERE `id` = '$id' LIMIT 1; ";
	$_SESSION['q']=$q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	break;

	
default:
	break;








}	/* switch */

