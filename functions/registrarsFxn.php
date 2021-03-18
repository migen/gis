<?php


function filterStudents($db,$dbg,$cond,$sort,$order){
	$dbo=PDBO;
	$q = " SELECT ctp.ctp,
			c.id AS ucid,c.parent_id AS pcid,
			sum.crid AS sumcrid,sum.scid AS sumscid,sum.acid AS sumacid,		
			cr.name AS classroom,
			c.*,c.id AS scid,c.name AS student,c.`sy`,cr.acid,
			cr.id AS crid,
			t.total,l.name AS level,sxn.name AS section,
			cr.level_id,c.code AS student_code,
			s.contact_id AS studscid,p.contact_id AS profscid,ph.contact_id AS photoscid,ctp.contact_id AS ctpscid,
			tsum.scid AS tsumscid,
			attd.scid AS attdscid			
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS sum on sum.scid = c.id
			LEFT JOIN {$dbg}.05_attendance AS attd on attd.scid = c.id
			LEFT JOIN {$dbg}.05_classrooms AS cr on sum.crid = cr.id			
			LEFT JOIN {$dbo}.`05_levels` AS l on cr.level_id = l.id
			LEFT JOIN {$dbo}.`05_sections` AS sxn on cr.section_id = sxn.id
			LEFT JOIN {$dbo}.`03_tuitions` AS t on cr.level_id = t.level_id
			LEFT JOIN {$dbg}.05_students AS s on s.contact_id = c.id
			LEFT JOIN {$dbg}.03_tsummaries AS tsum on tsum.scid = c.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.id					
			LEFT JOIN ".DBP.".photos AS ph on ph.contact_id = c.id					
		WHERE c.role_id = '".RSTUD."' $cond ORDER BY $sort $order ; ";
	debug("registrarsFxn: ".$q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */
