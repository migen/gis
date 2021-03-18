<?php


function profilingByClassroom($db,$dbg,$sy,$crid,$sort){
$dbo=PDBO;
$q = "
	SELECT c.id AS scid,c.code AS student_code,c.name AS student,c.name AS fullname,c.lrn,c.parent_id AS pcid,c.grp, 
		c.is_cleared,c.is_active AS status,c.is_active,c.remarks,c.position,		 
		c.is_male,p.first_name AS fname,p.middle_name AS mname,p.last_name AS lname,c.chinese_name AS cname,
		p.birthdate,c.is_male,p.sms,p.phone,p.address,p.email
	FROM {$dbo}.`00_contacts` AS `c` 
		LEFT JOIN {$dbg}.`05_summaries` AS `summ` ON summ.`scid` = c.`id`
		LEFT JOIN {$dbo}.`00_profiles` AS `p` ON p.`contact_id` = c.`id`
	WHERE summ.crid  = '$crid' ORDER BY $sort LIMIT 200; "; debug($q);
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */

