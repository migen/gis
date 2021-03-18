<?php

function syncLibstatsRows($db,$dbg=PDBG){

/* subdepts */
$x=array(2,3,4);
/* lvls */
$y=array(4,5,6,7,8,9,10,11,12,13,14,15);
/* months */
$z=array(1,2,3,4,5,6,7,8,9,10,11,12);
foreach($x AS $xe){
	foreach($y AS $ye){
		foreach($z AS $ze){
			$q="SELECT id FROM {$dbg}.70_patronstats WHERE subdepartment_id='$xe' 
				AND `lvl`='$ye' AND `moid`='$ze' LIMIT 1; "; 
			$sth=$db->querysoc($q);
			$row=$sth->fetch();
			if(empty($row)){
				$q="INSERT INTO {$dbg}.70_patronstats (`subdepartment_id`,`lvl`,`moid`) VALUES 
					('$xe','$ye','$ze'); ";
				$db->query($q);
			}		
		}
	}
} 

}	/* fxn */


function addLibstatsRow($db,$lvl,$moid,$subdepartment_id){



}	/* fxn */




function tallyDay($db,$date,$dbg=PDBG){
	$dbo=PDBO;	
	$moid= date('m',strtotime($date));
	$day= date('d',strtotime($date));	
	
	/* subdepts */
	$x=array(2,3,4);
	
	/* levels */
	$y=array(4,5,6,7,8,9,10,11,12,13,14,15);
	

	$qa=" UPDATE {$dbg}.70_patronstats AS a
		INNER JOIN (
			SELECT 
				COUNT(p.id) AS count,p.subdepartment_id,l.id AS lvl 
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ucid = c.id
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			WHERE p.date='$date' ";
	$qc = " ) AS b ON a.subdepartment_id = b.subdepartment_id AND a.lvl=b.lvl
		SET a.`{$day}`=b.count WHERE a.moid='$moid'; ";	
	$qt="";
	foreach($x AS $xe){
		foreach($y AS $ye){
			$q=$qa." AND p.subdepartment_id='$xe' AND l.id='$ye' ".$qc;	
			$qt.=$q;
		}
		
	}	/* x */	
	// pr($qt);
	$db->query($qt);
	// exit;
	
}	/* fxn */


function tallyMonthTotal($db,$moid){
	$dbo=PDBO;
	$dbg=PDBG;
	$q="UPDATE {$dbg}.70_patronstats SET total = ";
	for($i=1;$i<32;$i++){ $q.="IFNULL(`$i`,0)+"; }
	$q=rtrim($q,"+");
	$q.=" WHERE `moid`=$moid; ";
	$db->query($q);

}	/* fxn */

