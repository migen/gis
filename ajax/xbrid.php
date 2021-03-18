<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;


switch($_POST['task']){

case "resessionizeBrid":
	$_SESSION['brid']=$brid=$_POST['brid'];
	$q="SELECT code,name FROM {$dbo}.`00_branches` WHERE id=$brid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$_SESSION['brcode']=$row['code'];$_SESSION['branch']=$branch=$row['name'];	
	$_SESSION['message']="Branch changed to #{$brid} - {$branch}.";
	break;

	
	
default:
	break;








}	/* switch */
