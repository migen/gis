<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;
$dbo = PDBO;


switch($_POST['task']){

case "xdelposdetail":
	$pdid = $_POST['pdid'];
	$q="SELECT pd.*,p.terminal 
		FROM {$dbo}.`30_positems` AS pd 
			LEFT JOIN {$dbo}.`30_pos` AS p ON p.id=pd.pos_id
		WHERE pd.id = '$pdid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$t=$row['terminal'];
	$amt=$row['amount'];
	$qty=$row['qty'];
	$prid=$row['product_id'];
	$pos_id=$row['pos_id'];
	
	/* 2 */
	$q="DELETE FROM {$dbo}.`30_positems` WHERE id='$pdid' LIMIT 1; ";	
	$q.="UPDATE {$dbo}.`03_products` SET `t{$t}`=`t{$t}`+ $qty,`level`=`level`+ $qty WHERE id='$prid' LIMIT 1; ";
	$q.="UPDATE {$dbo}.`30_pos` SET `total`=`total`- $amt,`tendercs`=`tendercs`- $amt WHERE id='$pos_id' LIMIT 1; ";
	$db->querysoc($q);			
	$_SESSION['q'] = $q;
	break;


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

case "ptyproducts":
	$ptyid = $_POST['ptyid'];
	$q = " SELECT * FROM {$dbo}.`03_products`  WHERE `prodtype_id` = '$ptyid'; ";	
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;

	
case "sgroup":
	$stypeid = $_POST['stypeid'];
	$q = " SELECT * FROM {$dbo}.`03_products`  WHERE `prodsubtype_id` = '$stypeid'; ";	
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;
	

case "autofillprice":	
	$prodid = $_POST['prodid'];
	$q = " SELECT * FROM {$dbo}.`03_products`  WHERE `id` = '$prodid' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
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
		
case "xgetProductByID":
	$prodid = $_POST['prodid'];
	$q = " SELECT * FROM {$dbo}.`03_products` WHERE `id` = '".$prodid."' LIMIT 1;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
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

		
default:
	break;

	
	

}	/* switch */




	

	
