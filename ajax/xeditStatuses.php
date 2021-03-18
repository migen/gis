<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



$row = $_POST;



$q = " UPDATE {$dbo}.`00_contacts` SET
`remarks` 			= '".$row['remarks']."',
`is_active` 		= '".$row['is_active']."',
`is_cleared` 		= '".$row['is_cleared']."' 
WHERE `id` 			= '".$row['ucid']."' LIMIT 1;
 ";

$_SESSION['q'] = $q;
$db->query($q);

