<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;$dbg=PDBG;

switch($_POST['task']){

case "xeditClub":	
	$qtr=$_POST['qtr'];$qx=$_POST['qx'];$club_id=$_POST['club_id'];
	$q=" UPDATE {$dbg}.05_clubs SET `is_finalized_q{$qtr}`='$qx' WHERE `id` = '$club_id' LIMIT 1; ";
	$db->query($q);
	$_SESSION['q']=$q;
	break;


case "removeStudentFromClub":
	$scid=$_POST['scid'];
	$q = " UPDATE {$dbg}.05_summaries SET club_id=0 WHERE `scid`='$scid' LIMIT 1; ";
	$_SESSION['q']=$q;
	$db->querysoc($q);
	break;

case "studentToClub":
	$ucid=$_POST['ucid'];$club_id=$_POST['club_id'];
	$q = " UPDATE {$dbg}.05_summaries SET `club_id`='$club_id' WHERE `scid`='$ucid' 
		AND (`club_id`<1 OR `club_id` IS NULL OR `club_id`='') LIMIT 1; ";
	$_SESSION['q']=$q;
	$db->querysoc($q);
	/* 2 */
	$q="SELECT id,code,name,name AS student FROM {$dbo}.`00_contacts` WHERE `id`='$ucid' LIMIT 1; ";
	$_SESSION['q'].=$q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);	
	break;
	

case "addClub":
	$name=$_POST['name'];
	$q="INSERT INTO {$dbg}.`05_clubs`(`name`) VALUES('$name'); ";
	$_SESSION['q']=$q;
	$db->query($q);


	
default:
	break;






}	/* switch */


