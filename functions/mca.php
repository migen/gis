<?php

function aq($db,$level_id,$cond=true,$dbg=PDBG){	/* courses_quarters by advisersCoor,title-12,4-3 */
  $dbo=PDBO;
  $where = "";
  $q = "SELECT cr.*,aq.*,cr.id AS 'crid',cr.`name` AS 'classroom',cr.acid AS acid,
			c.account,c.name AS adviser,cp.`ctp` AS pass,aq.id AS aqid,
			prom.is_finalized AS prom_finalized
		FROM {$dbg}.05_classrooms AS cr 
            LEFT JOIN {$dbg}.05_advisers_quarters AS aq ON cr.id = aq.crid 
            LEFT JOIN {$dbg}.05_promotions AS prom ON prom.crid = cr.id 
            LEFT JOIN {$dbo}.`00_contacts` AS c ON cr.acid = c.id 
            LEFT JOIN {$dbo}.`00_ctp` AS cp ON cr.acid = cp.contact_id 		
		WHERE cr.level_id = '$level_id'
		$where	ORDER BY cr.level_id ASC,cr.section_id ASC; ";	 	 
	$sth = $db->querysoc($q);
	$data['aq'] 	 = $sth->fetchAll();
	$data['num_aq']  = count($data['aq']);		
	return $data;

}	/* fxn */



function cq($db,$level_id,$cond=true,$dbg=PDBG){		/* courses_quarters by subjectsCoor,title-10,4-1 */
  $dbo=PDBO;
  $where = "";	  
  $q = "SELECT crs.id AS course_id,crs.name AS course,crs.crstype_id AS ctype_id,crs.crid AS crid,crs.*,
			l.name AS level,sec.name AS section,c.id AS tcid,c.account,c.name AS teacher,cp.`ctp` AS pass,cq.id AS cqid,cq.*
		FROM {$dbg}.05_courses AS crs 
            LEFT JOIN {$dbg}.05_classrooms AS cr ON crs.crid = cr.id 
            LEFT JOIN {$dbg}.05_courses_quarters AS cq ON crs.id = cq.course_id 
            LEFT JOIN {$dbo}.`00_contacts` AS c ON crs.tcid = c.id 
            LEFT JOIN {$dbo}.`00_ctp` AS cp ON crs.tcid = cp.contact_id 					
            LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id 
            LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id 
 		WHERE crs.is_active 	 = '1' AND cr.level_id 	 = '$level_id' $where 
		ORDER BY crs.crid,crs.position,crs.id;  ";
	$sth = $db->querysoc($q);
	$data['cq'] = $sth->fetchAll();
	$data['num_cq'] = count($data['cq']);		
	return $data;

}	/* fxn */

