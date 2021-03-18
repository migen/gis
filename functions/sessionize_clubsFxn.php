<?php


function sessionizeTeacherClub($db,$dbg,$tcid){
	$dbo=PDBO;
	$q=" SELECT c.* FROM {$dbg}.`05_clubs` AS c WHERE c.tcid='$tcid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$_SESSION['teacher']['club']=$row;
		
}	/* fxn */

