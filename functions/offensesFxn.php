<?php

function getOffensesClasslist($db,$dbg,$crid,$order=NULL){
	$dbo=PDBO;
	$order=($order==NULL)? $_SESSION['settings']['classlist_order']:$order;	
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$q="SELECT summ.scid,c.name
		FROM {$dbg}.`50_offenses_{$sch}` AS o
		LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=o.scid
		LEFT JOIN {$dbg}.`05_summaries` AS summ ON c.id=summ.scid
		WHERE summ.crid='$crid' ORDER BY $order; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();


}	/* fxn */

function syncOffensesByClassroom($db,$dbg,$crid,$order=NULL){
	$dbo=PDBO;
	$order=($order==NULL)? $_SESSION['settings']['classlist_order']:$order;
	$sch=isset($_GET['sch'])? $_GET['sch']:VCFOLDER;
	$a=getClasslistSimple($db,$dbg,$crid);	
	$ar = buildArray($a,'scid');	
	$b=getOffensesClasslist($db,$dbg,$crid);
	$br = buildArray($b,'scid');		
	$ix = array_diff($ar,$br);			
	$q = " INSERT INTO {$dbg}.50_offenses_{$sch}(`scid`) VALUES  ";
	foreach($ix AS $scid){ $q .= " ('$scid'),"; }
	$q = rtrim($q,",");$q .= "; ";		
	$sth=$db->query($q);	
	echo ($sth)? "Success":"Failure";		
}	/* fxn */
