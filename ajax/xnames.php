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



$id  = $_POST['id'];
$tbl = $_POST['tbl'];

$q 		= " SELECT id,name FROM {$dbx}.{$tbl} WHERE `id` = '$id' LIMIT 1; ";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$_SESSION['q'] = $q;
echo json_encode($row);





	

	
