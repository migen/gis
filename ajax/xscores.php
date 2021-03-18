<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;
$dbo = PDBO;


switch($_POST['task']){

case "xdelScore":
	$scoreid=$_POST['scoreid'];
	$q=" DELETE FROM {$dbg}.50_scores WHERE `id` = '$scoreid' LIMIT 1; ";
	$_SESSION['q']=$q;
	$db->query($q);
	break;


case "xeditRow":
	$row=$_POST;	
	$sy=$_POST['sy'];
	$dbtable=$_POST['dbtable'];
	$dbg=VCPREFIX.$sy.US.DBG;$id=$row['id'];
	unset($row['task']);unset($row['id']);unset($row['sy']);unset($row['dbtable']);
	$db->update($dbtable,$row," `id`=$id ");
	break;

	
default:
	break;





}	/* switch */


