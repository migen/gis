<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


switch($_POST['dbx']){
	case 'dbm':
		$dbx = PDBG;break;
	default:
		$dbx = DBO;break;		
}



$name  	= $_POST['name'];
$tbl 	= $_POST['tbl'];

$q 		= " SELECT id FROM {$dbx}.{$tbl} WHERE `name` = '$name' LIMIT 1; ";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$_SESSION['q'] = $q;
echo json_encode($row);





	

	
