<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;


switch($_POST['task']){

case "testPoster":
	$post=$_POST;
	extract($post);
	
	$_SESSION['q']="Called by $poster";	
	break;


	
default:
	break;

	
	

}	/* switch */




	

	
