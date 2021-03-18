<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbg=PDBG;


switch($_POST['task']){


case "zerofyFinals":
	$grp=$_POST['grp'];
	$q = " UPDATE {$dbo}.finals SET `score_a`=0,`score_b`=0,`margin`=0 WHERE `grp`='$grp'; ";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;
/* 
update 2016_dbmaster_abc.03_tuitions AS a
INNER JOIN (
	select * FROM 2016_dbmaster_abc.levels
) AS b ON b.id = a.level_id
SET a.label = b.name
 */	
	
case "zerofyLevelRanks":
	$lvl=$_POST['lvl'];$qtr=$_POST['qtr'];
	$q = " UPDATE {$dbg}.05_summaries AS a 
		INNER JOIN {$dbg}.05_summext AS b ON a.scid=b.scid 
		INNER JOIN {$dbg}.05_classrooms AS c ON a.crid=c.id 
		SET b.rank_level_ave_q{$qtr}=0
		WHERE c.level_id='$lvl'; ";
	$_SESSION['q'] = $q;
	$db->query($q);
	break;
	
default:
	break;







}	/* switch */


