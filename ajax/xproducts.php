<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
$dbg = PDBG;	
$dbo = PDBO;	


switch($_POST['task']){
	

case "xeditAssignment":
	$post = $_POST;	
	
	$sy = $post['sy'];
	$dbg = VCPREFIX.$sy.US.DBG;
	$dbo=PDBO;
	$psid = $post['psid'];
	$prod = $post['prod'];
	$supp = $post['supp'];
	$cost = $post['cost'];
	
	$q = " 
		UPDATE {$dbg}.`products_suppliers` 
		SET ";
		$q .= " 
			`suppid` = '".$post['supp']."',
			`product_id` = '".$post['prod']."',
			`cost` = '".$post['cost']."'			
		WHERE `id`  = '".$post['psid']."' LIMIT 1;				
	";

	$q .= " UPDATE {$dbo}.`03_products` SET `roqty` = '".$post['roqty']."' WHERE `id`  = '".$post['prod']."' LIMIT 1; ";	
	$db->querysoc($q);
	$_SESSION['q'] = $q;
	break;

	
case "getSupplierProductByID":
	$prodid = $_POST['prodid'];
	$q = " SELECT * FROM {$dbo}.`03_products` WHERE `id` = '$prodid' LIMIT 1; ";			
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;
	
case "xdeleteProduct":
	$pid = $_POST['pid'];
	$q = " DELETE FROM {$dbo}.`03_products` WHERE id = '$pid' LIMIT 1; ";	
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	

case "xeditProduct":
	$row = $_POST;	
	$id = $row['id'];
	unset($row['task']);
	unset($row['id']);	
	/* 1 */
	$db->update("{$dbo}.03_products",$row,"id=$id");		
	/* 2 - tally level total */
	$tmax=$_SESSION['settings']['numterminals'];
	$expr="level=(";
	for($i=1;$i<=$tmax;$i++){ $expr.="t{$i}+"; }
	$expr=rtrim($expr,"+");
	$expr.=")";
	$q=" UPDATE {$dbo}.`03_products` SET $expr WHERE `id` = '$id' LIMIT 1;";
	$db->query($q);		
	break;

	
case "xaddSupplier":
	$cost = $_POST['cost'];
	$prid = $_POST['prid'];
	$suppid = $_POST['suppid'];
	$q = " INSERT INTO {$dbo}.`03_products_suppliers`(`suppid`,`product_id`,`cost`) VALUES ('$suppid','$prid','$cost'); ";	
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
case "xdeleteSupplier":
	$psid = $_POST['psid'];
	$q = " DELETE FROM {$dbg}.`products_suppliers` WHERE id = '$psid' LIMIT 1; ";	
	$db->query($q);
	$_SESSION['q'] = $q;
	break;


case "xgetProductByPrid":
	$prid = $_POST['prid'];
	$q = " SELECT * FROM {$dbo}.`03_products` WHERE `id` = '$prid' LIMIT 1; ";	
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;



	
	
default:
	break;

	
	

}	/* switch */




	

	
