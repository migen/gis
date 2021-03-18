<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		



switch($_POST['task']){


case "xtallyStudents":
	$sy=$_POST['sy'];
	$nsy=$sy+1;
	$name=$_POST['name'];
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;$dbg=VCPREFIX.$sy.US.DBG;

	$q = " 
		SELECT count(c.id) AS numrows FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
		WHERE c.role_id=1 AND cr.id<>1 AND cr.id<>2 AND c.`sy`<>'$nsy'; ";				
	$sth = $db->querysoc($q);
	$_SESSION['q'] = $q;
	$row = $sth->fetch();	
	$today=$_SESSION['today'];
	$q="UPDATE {$dbg}.dashboard SET `value`='".$row['numrows']."',`updated`='$today' WHERE `name`='$name' LIMIT 1; ";
	$db->query($q);	
	$_SESSION['q'] .= $q;	
	echo json_encode($row);	
	break;


	
default:
	break;

	
	

}	/* switch */




	

	
