<?php


function sacs($db,$dept,$dbg=PDBG){
	$dbo=PDBO;
	switch($dept){
		case 1: $cond = " AND sac.department_id = '1' "; break;
		case 2: $cond = " AND sac.department_id = '2' "; break;
		case 3: $cond = " AND sac.department_id = '3' "; break;
		default: $cond = "  "; break;
	}
	$q = "SELECT 
			sub.id AS subid,sub.name AS subject,sub.code AS subject_code,
			hc.id AS hcid,hc.code,hc.account,hc.name AS coordinator,
			sac.id AS sacid,sac.department_id,sub.*,ctp.ctp,hc.code AS emplcode
		FROM {$dbo}.`05_subjects` AS sub
			INNER JOIN {$dbo}.`05_subjects_coordinators` AS sac ON sac.subject_id = sub.id
			LEFT JOIN {$dbo}.`00_contacts` AS hc ON sac.hcid = hc.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON hc.id = ctp.contact_id
		WHERE sub.is_active = 1	$cond
		ORDER BY sub.name,sac.id;";
	debug("sacsFxn-sacs:".$q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


