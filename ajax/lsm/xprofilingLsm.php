<?php
session_start();							
include_once('../../config/Paths.php');		
include_once('../library/database.php');		


$dbo=PDBO;

switch($_POST['task']){

case "xeditProfiling":

	$fullname = trim($_POST['fullname']);	
	$name_array = explode(' ',$fullname);
	$last_name = isset($name_array[0])? trim(array_shift($name_array),',') : '';
	$middle_name = !empty($name_array)? array_pop($name_array) : '';
	$first_name = !empty($name_array)? implode(' ',$name_array) : '';
		
	/* profiles */
	$q="UPDATE {$dbo}.`00_profiles` SET `birthdate`='".$_POST['birthdate']."',
			`father`='".$_POST['father']."',`mother`='".$_POST['mother']."',
			`address` = '".$_POST['address']."' WHERE `contact_id`='".$_POST['cid']."' LIMIT 1; ";		
		
	/* 2 */
	$q.=" UPDATE {$dbo}.`00_contacts` SET `code` = '".$_POST['code']."',
			`account` = '".$_POST['code']."',`name` = '".$fullname."',
			`lrn` = '".$_POST['lrn']."',`is_male` = '".$_POST['is_male']."',
			`grp` = '".$_POST['grp']."',`position` = '".$_POST['posi']."',
			`remarks` = '".$_POST['remarks']."'
		WHERE `id` = '".$_POST['cid']."' LIMIT 1; ";
	$db->query($q);		
	$_SESSION['q'] = $q;		
	break;
	
default:
	break;

	
	
}	/* switch */




	
	