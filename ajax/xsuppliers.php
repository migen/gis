<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){

$dbg = PDBG;


case "prodsuppliers":	
	$pcatid = $_POST['pcatid'];
	$q = " SELECT p.* FROM {$dbo}.`03_products` AS p
			LEFT JOIN {$dbo}.`03_products_suppliers` AS ps ON ps.product_id = p.id
			WHERE ps.`prodcategory_id` = '$pcatid'; ";	
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;


case "xgetProductsByPart":
	$part 	= $_POST['part'];
	$limits = (isset($_POST['limits']))? $_POST['limits']:20;	
	$q = " SELECT * FROM {$dbo}.`03_products` WHERE `name` LIKE '%".$part."%' OR `barcode` LIKE '%".$part."%' 
		OR `code` LIKE '%".$part."%' ORDER BY `name` LIMIT $limits;  ";
	// $_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;
		
		

case "xgetProductByBarcode":
	$barcode = $_POST['barcode'];
	$q = " SELECT * FROM {$dbo}.`03_products` WHERE 
		`barcode` = '".$barcode."' OR `code` = '".$barcode."' LIMIT 1;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;


case "xgetSupplierProductByBarcode":
	$barcode = $_POST['barcode'];
	$suppid = $_POST['suppid'];
	$q = " SELECT * FROM {$dbo}.`03_products` WHERE `suppid`='$suppid' AND (
		`barcode` = '".$barcode."' OR `code` = '".$barcode."') LIMIT 1;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	break;
	
	
default:
	break;

	
	

}	/* switch */




	

	
