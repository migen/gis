<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg = PDBG;
$dbo = PDBO;


switch($_POST['task']){

case "xgetRowsByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE `code` LIKE '%".$part."%' OR `name` LIKE '%".$part."%' ORDER BY name LIMIT 10;  ";		
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$_SESSION['q1'] = $q;		
	echo json_encode($rows);
	break;


case "sajaxFilter":
	$part=$_POST['part'];
	$limits = $_POST['limits'];
	$limits=3;

	$rows=array();		
	$contacts=$_SESSION['contacts'];
	$count=0;
	$i=0;
	foreach($contacts AS $row){		
		if($count==$limits){ break; }
		$name=$row['name'];
		$code=$row['code'];
		if((stripos($name,$part)!==FALSE) || (stripos($code,$part)!==FALSE)){	
			$count++;
			array_push($rows,$row);
		}
		$i++;
	}	/* foreach */
	

	$_SESSION['q1'] = "sajaxFilter: part: $part - Limits: $limits ";		
	echo json_encode($rows);
	break;


case "sajaxFilterOK":
	$part=$_POST['part'];
	$limits = $_POST['limits'];
	$limits=3;

	$rows=array();		
	$contacts=$_SESSION['contacts'];
	$count=0;
	$i=0;
	foreach($contacts AS $row){		
		if($count==$limits){ break; }
		$name=$row['name'];
		if(stripos($name,$part)!==FALSE){
			$count++;
			array_push($rows,$row);
		}
		$i++;
	}	/* foreach */
	

	$_SESSION['q1'] = "sajaxFilter: part: $part - Limits: $limits ";		
	echo json_encode($rows);
	break;

	
	
default:
	break;






}	/* switch */

