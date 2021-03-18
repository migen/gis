 <?php
/* register new student, enroll students to a classroom */
/* 1) gls, 2) sectioning, 3) sectioner, */




function sectioningStudent($db,$sy,$scid,$fields=NULL){
$dbo=PDBO;$dbp=PDBP;$dbg=VCPREFIX.$sy.US.DBG;
$has_axis=&$_SESSION['settings']['has_axis'];
	$q = "SELECT ctp.ctp,$fields c.id AS ucid,c.parent_id AS pcid,c.is_enrolled,	
			summ.crid AS sumcrid,summ.scid AS sumscid,summ.acid AS sumacid,summ.promcrid,summ.promlvl,
			cr.name AS classroom,c.code,c.is_active,c.is_cleared,c.role_id,c.is_male,c.prevcrid,
			c.id AS scid,c.name AS student,c.`sy`,c.`sy` AS csy,
			c.crid AS contcrid,cr.acid,cr.num AS tnum,cr.id AS crid,
			ccr.acid AS cacid,ccr.id AS ccrid,ccr.name AS currclassroom,ccr.id AS currcrid,ccr.level_id AS currlvl,
			l.name AS level,sxn.name AS section,cr.level_id,c.code AS student_code,
			s.contact_id AS studscid,p.contact_id AS profscid,ctp.contact_id AS ctpscid,
			attd.scid AS attdscid";
		$q.=" FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id			
			LEFT JOIN {$dbg}.05_classrooms AS ccr on c.crid = ccr.id			
			LEFT JOIN {$dbg}.05_attendance AS attd on attd.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id ";			
if($has_axis){ $q.="
	LEFT JOIN {$dbo}.`03_tuitions` AS t ON (cr.level_id = t.level_id AND cr.num =t.num) "; 
}			
			$q.=" LEFT JOIN {$dbg}.05_students AS s on s.contact_id = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
		WHERE c.id='$scid'; ";
	debug($q,"enrollment: sectioningStudent ");
	$sth = $db->querysoc($q);
	return $sth->fetch();



}	/* fxn */


function sectioningClass($db,$dbg,$crid,$male=2,$order="c.`name` ASC",$fields=NULL,$filters=NULL,$limit=NULL,$active=false){	
	$dbo=PDBO;$dbp=PDBP;
	$has_axis=&$_SESSION['settings']['has_axis'];

	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;

	$q = "SELECT ctp.ctp,$fields c.id AS ucid,c.parent_id AS pcid,c.is_enrolled,summ.crid AS sumcrid,summ.scid AS sumscid,summ.acid AS sumacid,		
			cr.name AS classroom,cr.acid,cr.id AS crid,c.code,c.grp,c.crid AS contcrid,c.is_active,c.is_cleared,c.is_male,
			c.id AS scid,c.name AS student,c.`sy`,l.name AS level,sxn.name AS section,
			cr.level_id,c.code AS student_code,s.contact_id AS studscid,p.contact_id AS profscid,ctp.contact_id AS ctpscid,attd.scid AS attdscid";
if($has_axis){ $q.=",tsum.scid AS tsumscid "; }			
	$q.=" FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
			LEFT JOIN {$dbg}.05_attendance AS attd on attd.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id			
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id
			LEFT JOIN {$dbg}.05_students AS s on s.contact_id = c.id ";			
if($has_axis){ $q.=" LEFT JOIN {$dbg}.03_tsummaries AS tsum on tsum.scid = c.id "; }				
	$q.="	LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
		WHERE summ.crid = '$crid' $is_male $filters
		ORDER BY $order ; ";
	debug($q,"enrollment: sectioningClass");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


/* Mis getlevelstudents Attendance schemas glsAts */
function sectioningLevel($db,$dbg,$level_id,$limit,$order=NULL,$fields=NULL,$filter=NULL){	
$dbo=PDBO;$dbp=PDBP;
$has_axis=&$_SESSION['settings']['has_axis'];
$order = (empty($order))? "summ.`crid`,c.`name`":$order;
	$q = "SELECT ctp.ctp,$fields c.id AS ucid,c.parent_id AS pcid,c.is_enrolled,summ.crid AS sumcrid,summ.scid AS sumscid,summ.acid AS sumacid,		
			cr.name AS classroom,cr.acid,cr.id AS crid,c.code,c.grp,c.crid AS contcrid,c.is_active,c.is_cleared,c.is_male,
			c.id AS scid,c.name AS student,c.`sy`,l.name AS level,sxn.name AS section,
			cr.level_id,c.code AS student_code,s.contact_id AS studscid,p.contact_id AS profscid,ctp.contact_id AS ctpscid,attd.scid AS attdscid";
if($has_axis){ $q.=",tsum.scid AS tsumscid "; }			
	$q.=" FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
		LEFT JOIN {$dbg}.05_attendance AS attd on attd.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id
		LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
		LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id
		LEFT JOIN {$dbg}.05_students AS s on s.contact_id = c.id ";			
if($has_axis){ $q.=" LEFT JOIN {$dbg}.03_tsummaries AS tsum on tsum.scid = c.id "; }				
	$q.="LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id							
		LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
	WHERE cr.level_id   = '$level_id' $filter
	ORDER BY $order LIMIT $limit;";
debug($q,"enrollment: sectioningLevel");
$sth = $db->querysoc($q);
return $sth->fetchAll();

} /* fxn */




function classPromotion($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;$dbp=PDBP;
	$has_axis=&$_SESSION['settings']['has_axis'];

	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	
	$q = "SELECT $crid AS crid,c.*,$fields summ.*,c.id AS scid,c.code AS student_code,c.name AS student,c.`sy`,			
			summ.scid AS sumscid
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id									
		WHERE summ.crid = $crid $is_male $filters ORDER BY $order ;";	
	
	debug($q,"enrollment: classPromotion");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */




function summaryPreport($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$q = " SELECT $crid AS crid,$crid AS crid,c.*,$fields			
			summ.*,c.id AS scid,c.code AS student_code,c.name AS student,c.`sy`,			
			summ.scid AS sumscid,s.*,a.q5_days_present,summ.is_promoted
		FROM {$dbg}.05_summaries AS summ 
			INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
			LEFT JOIN {$dbg}.05_students AS s ON summ.scid = s.contact_id			
			LEFT JOIN {$dbg}.05_attendance AS a ON summ.scid = a.scid			
		WHERE summ.crid='$crid' $is_male $filters ORDER BY $order ; ";	
	debug($q,"Enrollment: summaryPreport");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function classPromotionOld($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	
	$q = "SELECT s.*,$crid AS crid,$crid AS crid,c.*,$fields summ.*,c.id AS scid,
			c.code AS student_code,c.name AS student,c.`sy`,summ.scid AS sumscid
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
			LEFT JOIN {$dbg}.05_summaries AS summ on summ.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on summ.crid = cr.id									
			LEFT JOIN {$dbg}.05_students AS s on s.contact_id = c.id									
		WHERE summ.crid 	= '$crid' $is_male $filters ORDER BY $order ; ";	
	debug($q,"Enrollment: classPromotionOld");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



function classroomsRange($db,$lvl){
	$dbo=PDBO;$dbg=PDBG;$prevlvl=$lvl-1;$nextlvl=$lvl+1;
	$q=" SELECT id,name FROM {$dbg}.05_classrooms WHERE level_id>='$prevlvl' AND level_id<='$nextlvl' ORDER BY level_id; ";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


