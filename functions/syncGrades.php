<?php


function getclassyearByStudent($db,$dbg,$sy,$ucid,$fields=NULL,$filters=NULL){
	$dbo=PDBO;
	$q = "SELECT ats.timein,ats.timeout,sum.*,sum.id AS sumid,ctp.*,cr.acid AS acid,c.is_male,$fields
			c.id AS scid,c.code AS student_code,c.name AS student,c.is_active,c.is_cleared,			
			s.*,s.contact_id,sum.crid AS crid,s.prevcrid AS prevcrid,c.`sy`,sum.scid AS sumscid			
		FROM {$dbg}.`05_summaries` AS sum
			LEFT JOIN {$dbg}.05_students AS s ON sum.scid  = s.contact_id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid  = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON sum.scid  = p.contact_id
			LEFT JOIN {$dbo}.`00_ctp` ON sum.scid  = ctp.contact_id
			LEFT JOIN {$dbg}.05_classrooms AS cr ON sum.crid 	 = cr.id
			LEFT JOIN {$dbg}.05_attendance_schemas AS ats ON c.attschema_id = ats.id
		WHERE 
				sum.scid 	= '$ucid'
			$filters ;		
	";	
	// pr($q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


