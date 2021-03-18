<?php

require_once(SITE."functions/details.php");

function units($db,$crid,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT c.id AS scid,c.code AS student_code,c.name AS student,c.is_active,
			s.level_entry,s.year_entry,s.batch,s.is_loyal,s.is_sectioned,is_old,			
			sum.units_previous,sum.units_current,sum.units_total,sum.years_earned
		FROM {$dbo}.`00_contacts` AS c 
			INNER JOIN {$dbg}.05_students AS s ON s.contact_id = c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON s.crid = cr.id
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		WHERE cr.id = $crid; ";
	$sth = $db->querysoc($q);
	$data['students'] = $sth->fetchAll(); 
	
	$cr = $_SESSION['classroom'] = $data['classroom'] = getClassroomDetails($db,$crid,$dbg);
	return $data;

}	/* fxn */

