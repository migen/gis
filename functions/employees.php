<?php


function employee($db,$dbg,$ecid,$fields=NULL){	
	$dbo=PDBO;
	$q = " SELECT ctp.ctp,$fields c.id AS ucid,c.parent_id AS pcid,			
			c.*,c.id AS ecid,c.name AS employee,c.`sy`,c.code AS employee_code,p.contact_id AS profecid,
			ph.contact_id AS photoecid,ctp.contact_id AS ctpucid,e.contact_id AS emplecid
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.06_employees AS e on e.contact_id = c.parent_id
 			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.parent_id					
			LEFT JOIN ".DBP.".photos AS ph on ph.contact_id = c.parent_id					
		WHERE c.id 	= '$ecid';";
	debug($q,"employees: employee ");
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */



/* **role=0 means all,1-employees only coz students role is 1 and not applicable here,7 RTEAC */
function employing($db,$dbg,$role_id=1,$male=2,$order="c.`name` ASC",$fields=NULL,$filters=NULL,$limit=NULL,$active=false){	
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	switch($role_id){
		case 0: $rolecond = ""; break;
		case 1: $rolecond = "AND (c.`role_id`!='".RTEAC."')"; break;
		default: $rolecond = "AND (c.`role_id`='$role_id')"; break;
	}
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;

	$q = "SELECT ctp.ctp,$fields c.id AS ucid,c.parent_id AS pcid,			
			c.*,c.id AS ecid,c.name AS employee,c.`sy`,c.code AS employee_code,
			p.contact_id AS profecid,ctp.contact_id AS ctpucid,e.contact_id AS emplecid
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.06_employees AS e on e.contact_id = c.parent_id
 			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id = c.id					
			LEFT JOIN {$dbo}.`00_profiles` AS p on p.contact_id = c.parent_id					
		WHERE
			(c.`role_id` != '".RSTUD."') $rolecond
			$is_active $is_male $filters
		ORDER BY $order ; ";
	debug($q,"employees: employing ");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */






function employeesAttendanceMonths($db,$sy,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbg}.05_attendance_months_employees LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();		
}	/* fxn */



function employees($db,$dbg=PDBG,$fields=NULL,$filters="AND c.is_active = 1"){
	$dbo=PDBO;
	/* IMPT: id & name at the end for selects */
	$q = "
		SELECT 
			c.is_male,$fields
			c.id AS ecid,c.code AS employee_code,c.name AS employee,c.account,
			c.is_active,c.is_cleared,c.prefix,
			c.title_id,c.role_id,c.privilege_id,
			t.name AS title,r.name AS role,			
			e.*,c.id AS id,c.name
		FROM {$dbo}.`00_contacts` AS c		
			LEFT JOIN {$dbg}.06_employees AS e ON e.contact_id 	= c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id 	= c.id
			LEFT JOIN {$dbo}.`00_titles` AS t ON c.title_id 		= t.id
			LEFT JOIN {$dbo}.`00_roles` AS r ON c.role_id 		= r.id
			LEFT JOIN {$dbo}.`00_ctp` AS ctp ON ctp.contact_id 		= c.id
			LEFT JOIN {$dbg}.05_attendance_schemas AS ats ON c.attschema_id 	= ats.id
		WHERE 
				c.`role_id`   <> 1
			AND	c.`parent_id` <> 1
			$filters				
		ORDER BY c.`name` ASC
		;		
	";
	// pr($q);
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */

