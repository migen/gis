<?php


function getAllTeachers($db,$sort,$order,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT cr.id,cr.id AS crid,cr.name AS classroom,cr.acid AS acid,c.is_active,is_cleared,
			c.account,c.name AS adviser,c.is_active,c.id AS ucid,c.parent_id AS pcid,c.is_male,
			cr.level_id,cr.section_id,cp.`ctp` 			
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbg}.05_classrooms AS cr ON cr.acid = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS cp ON cp.contact_id = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		WHERE c.role_id = '".RTEAC."'
		ORDER BY $sort $order; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	

}	/* fxn */


function getNonteachers($db,$sort,$order){
	$dbo=PDBO;
	$q = "SELECT 
			c.id,c.id AS ucid,c.account,c.name AS employee,c.is_active,c.is_cleared,
			c.is_male,
			t.name AS title,
			cp.`ctp` 			
		FROM {$dbo}.`00_contacts` AS c 
			LEFT JOIN {$dbo}.`00_ctp` AS cp ON cp.contact_id = c.id
			LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id = t.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
		WHERE c.role_id <> '".RTEAC."' AND	c.role_id <> '".RSTUD."'
		ORDER BY $sort $order;";
	debug("miscontactsFxn: ".$q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function getAdvisers($db,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT crs.crstype_id,crs.id AS conduct_id,l.code AS lvlcode,l.name AS level,sxn.name AS section,sxn.code AS sxncode,
			cr.id,cr.id AS crid,cr.name AS classroom,cr.acid AS acid,c.is_active,c.id AS ucid,c.account,c.name AS adviser,c.is_active,cp.`ctp` 			
		FROM {$dbg}.05_classrooms AS cr
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn ON cr.section_id = sxn.id			
			LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS cp ON cp.contact_id = c.id			
			LEFT JOIN (
				SELECT id,crid,crstype_id FROM {$dbg}.05_courses WHERE crstype_id <> '".CTYPEACAD."' AND is_active = '1'
			) AS crs ON crs.crid = cr.id		
		ORDER BY cr.level_id ASC,cr.id; ";
	debug("miscontactsFxn: ".$q);	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
	
}