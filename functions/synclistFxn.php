<?php

function syncScid($db,$sy,$scid){
	$dbo=PDBO;$dbp=PDBP;$dbg=VCPREFIX.$sy.US.DBG;		
	$q=qryString($sy);	
	$q.=" WHERE c.id=$scid; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	if(!isset($row['enscid'])){ $q.="INSERT INTO {$dbo}.05_enrollments(`sy`,`scid`)VALUES($sy,$scid); "; }	
	if(!isset($row['summscid'])){ $q.="INSERT INTO {$dbg}.05_summaries(`scid`)VALUES($scid); "; }	
	if(!isset($row['sumxscid'])){ $q.="INSERT INTO {$dbg}.05_summext(`scid`)VALUES($scid); "; }	
	if(!isset($row['attdscid'])){ $q.="INSERT INTO {$dbg}.05_attendance(`scid`)VALUES($scid); "; }	
	if(!isset($row['profscid'])){ $q.="INSERT INTO {$dbo}.00_profiles(`contact_id`)VALUES($scid); "; }	
	if(!isset($row['ctpscid'])){ $q.="INSERT INTO {$dbo}.00_ctp(`contact_id`)VALUES($scid); "; }	
	if(!isset($row['phscid'])){ $q.="INSERT INTO {$dbp}.photos(`contact_id`)VALUES($scid); "; }	
	
	$sth=$db->query($q); echo ($sth)? "<h3 class='red' >Synced.</h3>":"<h3 class='red'>FAIL</h3>"; 	
	
}	/* fxn */



function qryString($sy){
	$dbo=PDBO;$dbp=PDBP;$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT c.id AS ucid,c.parent_id AS pcid,c.name,c.role_id,c.is_active,c.is_male,
			cr.id AS crid,cr.name AS classroom,
			en.scid AS enscid,summ.scid AS summscid, 
			sumx.scid AS sumxscid,attd.scid AS attdscid, 
			ctp.contact_id AS ctpscid,prof.contact_id AS profscid,ph.contact_id AS phscid			
		FROM {$dbo}.00_contacts AS c
		LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy AND en.scid=c.id)
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_summext AS sumx ON sumx.scid=c.id
		LEFT JOIN {$dbg}.05_attendance AS attd ON attd.scid=c.id
		LEFT JOIN {$dbo}.00_ctp AS ctp ON ctp.contact_id=c.id
		LEFT JOIN {$dbo}.00_profiles AS prof ON prof.contact_id=c.id
		LEFT JOIN {$dbp}.photos AS ph ON ph.contact_id=c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id ";
	return $q;
		
}	/* fxn */

