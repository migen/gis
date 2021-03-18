<?php

	header("Access-Control-Allow-Origin: * "); 
	header("Content-Type: application/json");
	
	include_once("../library/Ignition.php");
	include_once(SITE."library/Functions.php");

	$id=isset($_GET['id'])? $_GET['id']:1;
	$dbo=PDBO;	
	$q="select id,name from {$dbo}.00_contacts Where id=$id LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	// pr($row);
	echo json_encode($row);