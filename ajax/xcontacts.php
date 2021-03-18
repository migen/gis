<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;


switch($_POST['task']){

case "xaddContact":
	require_once('../functions/contactsFxn.php'); 
	$fullname = $_POST['fullname'];
	$roleid = $_POST['roleid'];
	$q = " SELECT id AS title_id FROM {$dbo}.`00_titles` WHERE 
		`role_id` = '$roleid' AND privilege_id = '1' LIMIT 1;  ";
	$sth = $db->querysoc($q);	
	$row = $sth->fetch();
	$title_id = $row['title_id'];
	/* 2 insert contact */
	$id = lastContactId($db);
	$id+=1;
	$q = "INSERT INTO {$dbo}.`00_contacts` (`id`,`parent_id`,`name`,`title_id`,`role_id`,`privilege_id`,
			`sy`) VALUES ('$id','$id','$fullname','$title_id','$roleid','1','".DBYR."');";
	$_SESSION['q'] = $q;
	$db->query($q);		
	break;

case "xgetPriv":
	$q = " SELECT id AS tid,privilege_id AS privid,role_id AS roleid
			FROM {$dbo}.`00_titles` WHERE `id`=".$_POST['tid']." LIMIT 1;  ";
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();
	echo json_encode($row);
	break;

case "xeditContact":
	$row = $_POST;	
	$id = $row['id'];
	unset($row['task']);
	unset($row['id']);	
	$row['pass'] = MD5($row['ctp']);
	$ctp['ctp'] = $row['ctp'];
	unset($row['ctp']);
	$db->update("".PDBO.".`00_contacts`",$row,"id=$id");	
	$db->update("{$dbo}.`00_ctp`",$ctp,"contact_id=$id");	
	break;

	
case "xeditProfile":
	$row = $_POST;	
	$contact_id = $row['id'];
	unset($row['task']);
	unset($row['id']);
	$db->update("".PDBO.".`00_profiles`",$row,"contact_id=$contact_id");	
	break;

case "xeditContactProfile":
	$row = $_POST;	
	
	$with_chinese	 = $_SESSION['settings']['with_chinese'];	
	$fullname   	 = trim($_POST['fullname']);
	
	$name_array = explode(' ',$fullname);
	$last_name = isset($name_array[0])? trim(array_shift($name_array),',') : '';
	$middle_name = !empty($name_array)? array_pop($name_array) : '';
	$first_name = !empty($name_array)? implode(' ',$name_array) : '';
	
	$q = " 
		UPDATE {$dbo}.`00_profiles` 
		SET ";
		$q .= " 
			`last_name`   	= '".$last_name."',
			`middle_name`   = '".$middle_name."',
			`first_name`   	= '".$first_name."',		
			`birthdate`   	= '".$_POST['birthdate']."',
			`address`   	= '".$_POST['address']."'
		WHERE `contact_id`  = '".$_POST['cid']."' LIMIT 1;				
	";
	
	$q .= " UPDATE {$dbo}.`00_contacts` SET  ";
	$q .= " `code`   		= '".$_POST['code']."',
			`name`   		= '".$fullname."',
			`is_male`   	= '".$_POST['is_male']."',
			`is_active`   	= '".$_POST['is_active']."',
			`position`   	= '".$_POST['posi']."',
			`remarks`   	= '".$_POST['remarks']."'
		WHERE `id`  		= '".$_POST['cid']."' LIMIT 1;				
	";

	$db->querysoc($q);
	$_SESSION['q'] = $q;
	break;

	
case "xstatusContact":
	$q = " UPDATE {$dbo}.`00_contacts` SET `is_active` = '".$_POST['status']."' WHERE `id` = '".$_POST['ucid']."' LIMIT 1;  ";
	$db->query($q);
	break;

	
case "xverifyCode":
	$code = $_POST['code'];
	$q 		= " SELECT `id`,`parent_id` AS `pcid`,`code`,`account`,`name` FROM {$dbo}.`00_contacts` 
			WHERE `code` = '$code' OR `account` = '$code' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$_SESSION['q'] = $q;
	echo json_encode($row);
	break;



case "xeditContactCtp":
	$row 	= $_POST;	
	$id 	= $row['id'];
	$ctp['ctp']	 = $row['pass'];
	$row['pass'] = MD5($row['pass']);
	unset($row['task']);
	unset($row['id']);	
	$db->update("".PDBO.".`00_contacts`",$row,"id=$id");	
	$db->update("{$dbo}.`00_ctp`",$ctp,"contact_id=$id");	
	break;	
	
default:
	break;

	
	

}	/* switch */




	

	
