<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){	
	



case "xsaveData":	// add NOT update (xedit)
	// require_once(SITE.'functions/uniclassroomsFxn.php');		
	$post=$_POST;unset($post['task']);unset($post['dbtable']);
	$dbtable=$_POST['dbtable'];	
	/* 1 */
	$q1="SELECT id FROM {$dbtable} WHERE ";
	foreach($post AS $k=>$v){ $q1.="{$k}={$v} AND "; }
	$q1=rtrim($q1," AND ");$q1.=" LIMIT 1;";
	$sth=$db->querysoc($q1);
	$row=$sth->fetch();
	/* 2 */
	if(!$row){ $db->add($dbtable,$post); } 
	/* 3 */
	upnameClassrooms($db,$dbg);
	break;	

case "xeditData":
	$post=$_POST;unset($post['task']);unset($post['dbtable']);unset($post['id']);
	$dbtable=$_POST['dbtable'];	$id=$_POST['id'];	
	$db->update($dbtable,$post,"`id`=$id");
	break;	


case "xsaveDataNotOK":
	$post=$_POST;unset($post['task']);unset($post['dbtable']);
	$dbtable=$_POST['dbtable'];	
	$db->createIfNotExists($dbtable,$post);	
	break;	
	

default:
	break;

	
		
	

}	/* switch */




	

	
