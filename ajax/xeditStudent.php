<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



$row = $_POST;
$dbg = PDBG;



$q = " zxxx UPDATE {$dbg}.05_students SET
`incsubj` 			= '".$row['incsubj']."',
`is_discountable` 	= '".$row['discount']."',
`years_in_school` 	= '".$row['yis']."',
`year_entry` 		= '".$row['ye']."',
`level_entry` 		= '".$row['le']."',
`batch` 			= '".$row['batch']."'
WHERE `contact_id` = '".$row['cid']."' LIMIT 1;
 ";

$_SESSION['q'] = $q;
$db->query($q);

