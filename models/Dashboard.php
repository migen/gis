<?php



class Dashboard extends Model{



public function __construct(){
	parent::__construct();
}



public function getCountClassrooms($dbg=PDBG,$temp=0){
$dbo=PDBO;
$cond = (!$temp)? " WHERE sec.code <> 'TMP' " :  null; 
$q = "
	SELECT 
		count(cr.id) AS numrows
	FROM {$dbg}.05_classrooms AS cr
 		LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id	
	$cond
";
// pr($q);
$sth = $this->db->querysoc($q);
$row = $sth->fetch();
return $row['numrows'];

}	/* fxn */


public function getCountPromotions($dbg,$sy,$temp=0){
$dbo=PDBO;
$cond = (!$temp)? " AND sec.code <> 'TMP' " :  null; 
$q = "
	SELECT 
		count(p.crid) AS numrows
	FROM {$dbg}.05_promotions AS p
 		INNER JOIN {$dbg}.05_classrooms AS cr ON p.crid = cr.id	
 		INNER JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id	
	WHERE p.`is_finalized` = '1'
		$cond
";
$sth = $this->db->querysoc($q);
$row = $sth->fetch();
return $row['numrows'];

}	/* fxn */

/* getCountEnrollments */
public function getCountPromotedStudents($sy,$is_sectioned=1,$dbg=PDBG){	
/* Promoted here doesn't mean elevated but deped SF by adviser */  
	$dbo=PDBO;
	$q = " SELECT count(s.id) AS numrows FROM {$dbg}.05_students AS s 	
			INNER JOIN {$dbo}.`00_contacts` AS c ON s.contact_id = c.id
			WHERE 		
					c.`is_active` = '1'
				AND s.`is_sectioned` = '$is_sectioned';	
	";
	$sth = $this->db->querysoc($q);	
	if(!$sth){ pr($q);exit; }
	$row = $sth->fetch();
	return $row['numrows'];

}	/* fxn */	



public function getCount($table,$where=null,$debug=false){
	$dbo=PDBO;
	$q = " SELECT count(id) AS numrows FROM $table $where ; ";
	$sth = $this->db->query($q);
	if(!$sth){ echo "getCount: "; pr($q);exit; }
	$row = $sth->fetch();
	if($debug){ pr($q); pr($row); }	
	return $row['numrows'];
}	/* fxn */
	

public function getCountPhotos($dbtable,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT count(DISTINCT(c.parent_id)) AS numrows 
		FROM $dbtable
			INNER JOIN {$dbo}.`00_contacts` AS c ON $dbtable.`contact_id` = c.`id`
	";
	$sth = $this->db->query($q);
	if(!$sth){ echo "getCountPhotos: "; pr($q);exit; }
	$row = $sth->fetch();
	return $row['numrows'];
	
}

public function getCountCidsDBO($table,$debug=false){
	$dbo=PDBO;
	$q = "
		SELECT count(DISTINCT(c.parent_id)) AS numrows 
		FROM {$dbo}.`$table` AS `t`
			INNER JOIN {$dbo}.`00_contacts` AS `c` ON t.`contact_id` = c.`id`
	";
	$sth = $this->db->query($q);
	if(!$sth){ pr($q);exit; }	
	$row = $sth->fetch();
	if($debug){ pr($q); pr($row); }		
	return $row['numrows'];
	
}

	
public function getCountCids($table,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT count(DISTINCT(c.parent_id)) AS numrows 
		FROM {$dbg}.`$table`
			INNER JOIN {$dbo}.`00_contacts` AS c ON $table.`contact_id` = c.`id`
	";
	$sth = $this->db->query($q);
	if(!$sth){ echo "getCountCids: "; pr($q);exit; }	
	$row = $sth->fetch();
	return $row['numrows'];
	
}


public function countIteachers($dbg=PDBG){
$dbo=PDBO;
$q = "
	SELECT 
		count(DISTINCT(c.parent_id)) AS numrows
	FROM {$dbg}.iteachers AS it
		LEFT JOIN {$dbo}.`00_contacts` AS c ON it.asee_cid = c.parent_id
	WHERE	
			c.role_id 	= ".RTEAC."
		AND	c.id = c.parent_id
		AND	c.is_active = '1'
;";
// pr($q); exit;
$sth = $this->db->querysoc($q);
$row = $sth->fetch();
return $row['numrows'];

}	/* fxn */






public function getCountAttendance($dbg,$sy){	
	$dbo=PDBO;
	$q = " SELECT count(att.id) AS numrows 
			FROM {$dbg}.05_attendance AS att
				INNER JOIN {$dbo}.`00_contacts` AS c ON att.scid = c.id
		WHERE 	c.`is_active` = '1' ; ";
	$sth = $this->db->querysoc($q);	
	$row = $sth->fetch();
	return $row['numrows'];

}	/* fxn */

public function getCountAttemps($dbg,$sy){	
	$dbo=PDBO;
	$q = " SELECT count(att.id) AS numrows 
			FROM {$dbg}.06_attendance_employees AS att
				INNER JOIN {$dbo}.`00_contacts` AS c ON att.ecid = c.id
		WHERE 	c.`is_active` = '1' ; ";
	$sth = $this->db->querysoc($q);	
	$row = $sth->fetch();
	return $row['numrows'];

}	/* fxn */



public function getCountTuitionSummaries($dbg=PDBG){	
	$dbo=PDBO;
/* for reg & mis/dashboard */ 
	$q = " SELECT count(tsum.id) AS numrows 
			FROM {$dbg}.03_tsummaries AS tsum
				LEFT JOIN {$dbo}.`00_contacts` AS c ON tsum.scid = c.id
		WHERE 	c.is_active = 1; ";
	$sth = $this->db->querysoc($q);	
	$row = $sth->fetch();
	return $row['numrows'];

}	/* fxn */





public function getCountMultiUsers($dbg=PDBG,$debug=false){
	$dbo=PDBO;
	$q = "
		SELECT count(DISTINCT(pc.id)) AS `numrows`
		FROM {$dbo}.`00_contacts` AS uc
			LEFT JOIN {$dbo}.`00_contacts` AS pc ON uc.parent_id = pc.id
		GROUP BY uc.`parent_id`
		HAVING COUNT(uc.parent_id) > 1
	";
	// pr($q);
	$sth = $this->db->query($q);
	$row = $sth->fetch();
	if($debug){ pr($q); pr($row); }		
	
	return $row['numrows'];
}	/* fxn */


public function getCountProfiles($active=1){
$dbo=PDBO;
$cond = ($active)? " AND c.is_active = '1' " :  null; 
$q = "
	SELECT 
		count(p.contact_id) AS numrows
	FROM {$dbo}.`00_profiles` AS p
 		INNER JOIN {$dbo}.`00_contacts` AS c ON p.contact_id = c.id	
	WHERE c.id=c.parent_id
	$cond
";

$sth = $this->db->querysoc($q);
$row = $sth->fetch();
return $row['numrows'];

}	/* fxn */



public function getCountSummaries($dbg,$sy){	/* for reg & mis-dashboard  */
	$dbo=PDBO;
	$q = " SELECT count(sum.id) AS numrows 
			FROM {$dbg}.05_summaries AS sum
				INNER JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
		WHERE 	c.`is_active` = '1'; ";
	$sth = $this->db->querysoc($q);	
	$row = $sth->fetch();
	return $row['numrows'];

}	/* fxn */


















}  /* Dashboard */