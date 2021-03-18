<?php


 

function syncTsum($db,$crid,$dbg){
	$dbo=PDBO;	
	/* 1 contacts */		
	$q=" SELECT `scid` FROM {$dbg}.05_summaries WHERE `crid`='$crid'; ";			
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'scid');	
	
	/* 2 table with scid or contact_id */		
	$q = "SELECT `scid` FROM {$dbg}.03_tsummaries;";		
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'scid');

	/* 3 */
	$ix = array_diff($ar,$br);		
	$q = " INSERT INTO {$dbg}.03_tsummaries(`scid`)VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";		
	
	$db->query($q);		
	
	
}	/* fxn */

 
function updateTsumCrid($db,$crid,$dbg){
	$dbo=PDBO;
	$q=" UPDATE {$dbg}.03_tsummaries AS a 
		INNER JOIN {$dbg}.05_summaries AS b ON b.scid=a.scid
		SET a.crid=b.crid WHERE b.crid='$crid';	";
	$db->query($q);	
	
}	/* fxn */



function syncSummextByClassroom($db,$dbg,$crid){
	$dbo=PDBO;	
	$q=" SELECT `scid` FROM {$dbg}.05_summaries WHERE `crid`='$crid' ORDER BY `scid`; ";			
	$sth=$db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');		
	$q="SELECT summ.scid FROM {$dbg}.`05_summext` AS sx
		INNER JOIN {$dbg}.`05_summaries` AS summ ON summ.scid=sx.scid
		WHERE summ.crid='$crid' ORDER BY summ.scid; ";	
	$sth=$db->querysoc($q);
	$b=$sth->fetchAll();
	$br = buildArray($b,'scid');
	$ix = array_diff($ar,$br);		
	$q = " INSERT INTO {$dbg}.05_summext(`scid`)VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";			
	$db->query($q);			
	
}	/* fxn */


function syncSummext($db,$dbg){
	$dbo=PDBO;	
	$q=" SELECT `scid` FROM {$dbg}.05_summaries; ";			
	$sth=$db->querysoc($q);
	$a=$sth->fetchAll();
	$ar=buildArray($a,'scid');		
	$q=" SELECT `scid` FROM {$dbg}.05_summext; ";				
	$sth=$db->querysoc($q);
	$b=$sth->fetchAll();
	$br = buildArray($b,'scid');
	$ix = array_diff($ar,$br);		
	$q = " INSERT INTO {$dbg}.05_summext(`scid`)VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";			
	$db->query($q);			
	
}	/* fxn */




