<?php


class Guidance extends Model{


public function __construct(){
	parent::__construct();
}



public function sessionizeGuidance($sy,$dbg=PDBG){
	$dbo=PDBO;
	require_once(SITE."functions/contactsFxn.php");
	require_once(SITE."functions/sessionize.php");
	$db =& $this->db;

	$ucid = $_SESSION['user']['ucid'];
	sessionizeSettingsGis($db,$dbg);
	$this->urooms($ucid);	
	$data['levels'] 	= $this->fetchRows("{$dbo}.`05_levels`","*","id");
	$data[$sy]['classrooms'] = $this->fetchRows("{$dbg}.05_classrooms","*","level_id");
	$data[$sy]['num_classrooms'] = count($data[$sy]['classrooms']);
	$data[$sy]['teachers'] 	= getContacts($db,RTEAC);
	$data[$sy]['num_teachers'] = count($data[$sy]['teachers']);
	$data[$sy]['num_iteachers'] = $this->countIteachers($dbg);			/* ARMModel */

	$_SESSION['guidance'] = $data;
	
}	/* fxn */



public function getTeacherIscores($dbg,$icomponent_id,$tcid,$sy,$period){
	$dbo=PDBO;
	$q = "SELECT c.`id` AS `scid`,c.`code` AS `student_code`,c.`name` AS `student`,isc.* 
			FROM {$dbg}.`iscores` AS `isc`		
				INNER JOIN {$dbo}.`00_contacts` AS c ON isc.`asor_cid`	= c.`id`				
			WHERE 	
					c.`is_active` = '1'
				AND isc.`period` 		= $period
				AND isc.`icomponent_id` = $icomponent_id					
				AND isc.`asee_cid` 		= $tcid ;";
	debug("GuidanceModel: ".$q);
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */



public function getIstudents($dbg,$tcid){
$dbo=PDBO;	
$q = " SELECT 
			DISTINCT(sum.scid) AS scid,
			c.code AS student_code,c.name AS student 
		FROM {$dbg}.05_summaries AS sum 
			INNER JOIN {$dbo}.`00_contacts` AS c ON sum.scid = c.id
			INNER JOIN {$dbg}.05_students AS s ON sum.scid = s.contact_id
			INNER JOIN {$dbg}.05_classrooms AS cr ON sum.crid = cr.id
			INNER JOIN {$dbg}.05_courses AS crs ON crs.crid = cr.id
		WHERE 	crs.tcid = $tcid
			AND c.is_active = 1
		ORDER BY c.name ;";
debug("GuidanceModel: ".$q);
$sth = $this->db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


public function igrades($dbg,$sy,$period,$itype_id,$tcid){
	$dbo=PDBO;	
	$q = " SELECT 
			ig.*,c.name AS student
		FROM {$dbg}.igrades AS ig
			INNER JOIN {$dbo}.`00_contacts` AS c ON ig.asor_cid = c.id
		WHERE ig.`itype_id` 	= $itype_id
			AND	ig.`period` 	 = $period
			AND	ig.`asee_cid` 	 = $tcid ; ";
	debug("Guidance: ".$q);		
	$sth = $this->db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */






} 	/* GuidanceModel */



