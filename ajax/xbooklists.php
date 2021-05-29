<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbo=PDBO;$dbg=PDBG;


switch($_POST['task']){



case "xaddBooklist":	/* 20200226 */		
	$post=$_POST;
	unset($post['task']);
	unset($post['dbbooks']);
	unset($post['dblvlbooks']);
	unset($post['lb']);
	$lb_post=$_POST['lb'];
	$lb_post=$_POST['lb'];	

	// 1 - parent
	$dbbooks=$_POST['dbbooks'];		
	$db->add($dbbooks,$post);	
	
	$book_id=$db->lastInsertId();
	$lb_post['book_id']=$book_id;
	// 2 - child
	$dblvlbooks=$_POST['dblvlbooks'];		
	$db->add($dblvlbooks,$lb_post);		
	
	break;	

	
	
default:
	break;

	
	

}	/* switch */




	

	
