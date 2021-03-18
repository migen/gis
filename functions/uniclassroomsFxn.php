<?php

		// LEFT JOIN {$dbg}.01_courses AS crs ON crs.crid=cr.id

function sessionizeUniclassrooms($db,$dbg){		
	$dbo=PDBO;
	$q="SELECT cr.id AS crid,m.name AS major,m.years,m.code AS major_code,s.name AS section,cr.*
		FROM {$dbg}.01_classrooms AS cr
		LEFT JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
		LEFT JOIN {$dbg}.01_sections AS s ON cr.section_id=s.id
		GROUP BY cr.id ORDER BY m.`name`,s.name; ";		
	debug($q);
	$sth=$db->querysoc($q);	
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();
	$_SESSION['uniclassrooms']=$rows;
	$_SESSION['num_uniclassrooms']=$count;
	
} 	/* fxn */	



function upnameClassrooms($db,$dbg){
	$dbo=PDBO;
	$q="UPDATE {$dbg}.01_classrooms AS cr
		INNER JOIN {$dbg}.`05_majors` AS m ON cr.major_id=m.id
		INNER JOIN {$dbg}.01_sections AS s ON cr.section_id=s.id
		SET cr.code=CONCAT(m.code,'-',s.code),cr.name=CONCAT(m.code,'-',s.name)
		WHERE cr.name IS NULL;";
	$db->query($q);
		
}	/* fxn */
