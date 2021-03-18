<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;


switch($_POST['task']){

case "zxtest":
	$id=$_POST['id'];
	$name=$_POST['name'];
	$q="UPDATE {$dbg}.ztruncs SET `name`='$name' WHERE `id`='$id' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q']=$q;
	break;
	
// canon ip2700

	
	
default:
	break;

	
	

}	/* switch */




	

	



