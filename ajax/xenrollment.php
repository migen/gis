<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
// require_once(SITE."functions/enrollmentFxn.php");
$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){	

case "reconcileTuitionTotal":	
	$part=$_POST['part'];
	$sy=$_POST['sy'];
	$dbg=VCPREFIX.$sy.US.DBG;
	$q="UPDATE {$dbo}.`03_tuitions` SET `total` = '".$_POST['total']."' WHERE 
		`level_id` = '".$_POST['level_id']."' AND `num` = '".$_POST['num']."' LIMIT 1;  ";
	$db->querysoc($q);return true;
	break;

case "xsaveEncoder":
	$dbg=PDBG;$encoder=$_POST['encoder'];$scid=$_POST['scid'];
	$q="UPDATE {$dbg}.03_tsummaries SET `encoder` = '$encoder' WHERE `scid` = '$scid' LIMIT 1;";$db->query($q);
	break;


case "xenrollStudent":	// coedit / same with enrollmentFxn | 20200403
	$post=$_POST;
	$sy=$post['sy'];$scid=$post['scid'];$post_crid=$crid=$post['crid'];$dbg=VCPREFIX.$sy.US.DBG;
	
	$q="SELECT c.sy,c.id AS scid,en.id AS enid,summ.id AS summid,c.crid AS contcrid,en.crid AS encrid,summ.crid AS summcrid
	FROM {$dbo}.`00_contacts` AS c LEFT JOIN {$dbo}.`05_enrollments` AS en ON (en.sy=$sy && en.scid=c.id)
		LEFT JOIN {$dbg}.`05_summaries` AS summ ON summ.scid=c.id WHERE c.id=$scid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();	
	/* 2 */
	$q="";			
	if($sy==DBYR){	/* current */
		if($row['contcrid']!=$post_crid){ $q.="UPDATE {$dbo}.00_contacts SET sy=$sy,prevcrid=crid,crid=$post_crid WHERE id=$scid LIMIT 1;"; }		
	}	/* current */
	
	/* 1 - contacts */			
	if($row['encrid']!=$post_crid){ $q.="UPDATE {$dbo}.05_enrollments SET crid=$post_crid WHERE id=".$row['enid']." LIMIT 1;"; }
	if($row['summcrid']!=$post_crid){ $q.="UPDATE {$dbg}.05_summaries SET crid=$post_crid WHERE id=".$row['summid']." LIMIT 1;"; }
	$_SESSION['q1']=$q;
	if(!empty($q)){ $sth=$db->query($q); return ($sth)? true:false; }	

	break;

	
default:
	break;

	
		
	

}	/* switch */




	

	
