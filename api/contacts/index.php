<?php

	header("Access-Control-Allow-Origin: * "); 
	header("Content-Type: application/json");
	
	include_once("../library/Ignition.php");
	include_once(SITE."library/Functions.php");

	$id=isset($_GET['id'])? $_GET['id']:1;
	$dbo=PDBO;	
	
	$q="SELECT id,code,name FROM {$dbo}.00_contacts ORDER BY id DESC LIMIT 5; ";		
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['message']="Traversy Rest API";
	// $data['blogs']=$rows;
	$data['rows']=$rows;
	echo json_encode($data);