<?php

	header("Access-Control-Allow-Origin: * "); 
	header("Content-Type: application/json");
	
	include_once("../library/Ignition.php");
	include_once(SITE."library/Functions.php");

	$id=isset($_GET['id'])? $_GET['id']:1;
	$dbo=PDBO;	
	$q="SELECT p.*,c.name AS category FROM {$dbo}.posts AS p 
		LEFT JOIN {$dbo}.categories AS c ON c.id=p.category_id ORDER BY c.created_at DESC; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['message']="Traversy Rest API";
	$data['blogs']=$rows;
	echo json_encode($data);