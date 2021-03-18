<?php

	header("Access-Control-Allow-Origin: * "); 
	header("Content-Type: application/json");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");
	
	
	include_once("../library/Ignition.php");
	include_once(SITE."library/Functions.php");

	$id=isset($_GET['id'])? $_GET['id']:1;
	$dbo=PDBO;	

	$post=json_decode(file_get_contents("php://input"));
	
	$title=$post->title;
	$body=$post->body;
	$author=$post->author;
	$category_id=$post->category_id;
	
	$q="INSERT INTO {$dbo}.posts(`title`,`body`,`author`,`category_id`) VALUES('$title','$body','$author','$category_id'); ";
	$sth=$db->query($q);
	if($sth){
		echo json_encode(array("message"=>"Post Created - $q "));
	} else {
		echo json_encode(array("message"=>"Post NOT created - $q ."));	
	}

	
	