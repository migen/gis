<?php

/* 1) gls, 2) sectioning, 3) sectioner, */


function sectioningClass($db,$sy,$crid,$male=2,$order="c.`name` ASC",$fields=NULL,$filters=NULL,$limit=NULL,$active=1){	
	$dbo=PDBO;$dbg=VCPREFIX.$sy.US.DBG;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;

	$q = "SELECT 
			cr.acid AS acid,$fields c.id AS ucid,c.parent_id AS pcid,c.code AS studcode,c.name AS studname,
			c.`sy` AS contsy,c.crid AS contcrid,
			summ.scid AS summscid,summ.scid,en.id AS enid,en.scid AS enscid,en.crid AS encrid,
			summ.prevcrid AS summprevcrid
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.05_enrollments AS en ON (en.sy=$sy && en.scid = c.id)
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		WHERE summ.crid = $crid $is_male $filters ORDER BY $order; ";
	// echo "fxn/sectioning: Class "; pr($q);
	debug("SectioningFxn: ".$q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



/* Mis getlevelstudents Attendance schemas glsAts */
function sectioningLevel($db,$dbg,$level_id,$limit,$order=NULL,$fields=NULL,$filter=NULL){	

$dbo=PDBO;
$order = (empty($order))? "summ.`crid`,c.`name`":$order;
$q = "SELECT ctp.ctp,$fields summ.crid,summ.acid,summ.scid AS sumscid,		
		cr.name AS classroom,c.*,c.id AS scid,c.name AS student,c.`sy`,cr.id AS crid
	FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id
		LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id		
	WHERE cr.level_id   = '$level_id' $filter ORDER BY $order LIMIT $limit ;";
echo "fxn/sectioning: Level "; pr($q);
$sth = $this->db->querysoc($q);
return $sth->fetchAll();

} /* fxn */

