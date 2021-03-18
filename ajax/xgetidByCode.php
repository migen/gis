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



$code  	= $_POST['code'];
$tbl 	= $_POST['tbl'];

$q 		= " SELECT id FROM {$dbx}.{$tbl} WHERE `code` = '$code' LIMIT 1; ";
$sth = $db->querysoc($q);
$row = $sth->fetch();
$_SESSION['q'] = $q;
echo json_encode($row);





	

	
