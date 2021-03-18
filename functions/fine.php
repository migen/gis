<?php



function fineSumAtt($db,$dbg,$sy,$scid,$crid=0){		/* fxn insert if not exists - fine */
$dbo=PDBO;
/* 1 - sum */
$q = " SELECT id FROM {$dbg}.`05_summaries` WHERE `scid` = '$scid' LIMIT 1;  ";
$sth = $db->querysoc($q);
$row = $sth->fetch();
if(empty($row)){
	$q = " INSERT INTO {$dbg}.`05_summaries` (`scid`,`crid`) VALUES ('$scid','$crid');  ";
	$db->query($q);			
}

/* 2 - att */
$q = " SELECT id FROM {$dbg}.`05_attendance` WHERE `scid` = '$scid' LIMIT 1;  ";
$sth = $db->querysoc($q);
$row = $sth->fetch();
if(empty($row)){
	$q = " INSERT INTO {$dbg}.`05_attendance` (`scid`) VALUES ('$scid');  ";
	$db->query($q);			
}

}	/* fxn */

