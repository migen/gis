<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;

switch($_POST['task']){

case "xeditProfiling":

	$fullname=trim($_POST['fullname']);	
	$birthdate=trim($_POST['birthdate']);	
	$name_array = explode(' ',$fullname);
	$last_name = isset($name_array[0])? trim(array_shift($name_array),',') : '';
	$middle_name = !empty($name_array)? array_pop($name_array) : '';
	$first_name = !empty($name_array)? implode(' ',$name_array) : '';
	$with_chinese = $_SESSION['settings']['with_chinese'];

	/* profiles */
	$q="UPDATE {$dbo}.`00_profiles` SET `birthdate`='$birthdate',
			`address` = '".$_POST['address']."' WHERE `contact_id`='".$_POST['cid']."' LIMIT 1; ";		
		
	$mdpass=MD5($birthdate);
		
	/* 2 */
	$q .= " UPDATE {$dbo}.`00_contacts` SET `code` = '".$_POST['code']."',`pass`='$mdpass',
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




	
	