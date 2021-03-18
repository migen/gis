<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){	

case "xgetSubproducts":
	$id = $_POST['id'];
	$cond=(empty($id))? NULL:"WHERE pr.`prodtype_id` = $id";
	$q="SELECT pr.*,pt.color FROM {$dbo}.00_products AS pr 
		LEFT JOIN {$dbo}.00_prodtypes AS pt ON pt.id=pr.prodtype_id
		$cond ORDER BY pr.prodtype_id,pr.name; ";		
	$_SESSION['q'] = $q;
	$sth = $db->query($q);
	$rows = $sth->fetchAll();		
	echo "<h3>Sub Products</h3>";
	foreach($rows as $row){
		echo "<p class='box'>".$row['name'].'<br />'.$row['price']."</p>";	
	}	
	break;	

	

case "xgetMerchandise":
	$id = $_POST['id'];
	$cond=(empty($id))? NULL:"WHERE pr.`prodtype_id` = $id";
	$q="SELECT pr.*,pt.color FROM {$dbo}.00_products AS pr 
		LEFT JOIN {$dbo}.00_prodtypes AS pt ON pt.id=pr.prodtype_id
		$cond ORDER BY pr.prodtype_id,pr.name; ";		
	$_SESSION['q'] = $q;
	$sth = $db->query($q);
	$rows = $sth->fetchAll();	
	// $rows = array_map(function($r) {
	  // $r['name'] = utf8_encode($r['name']);
	  // return $r;
	// }, $rows);		
	echo json_encode($rows);		
	break;	

case "xgetProductById":
	$id = $_POST['id'];
	$q="SELECT * FROM {$dbo}.00_products WHERE `id` = $id LIMIT 1; ";		
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	break;	


	
default:
	break;

	
		
	

}	/* switch */




	

	
