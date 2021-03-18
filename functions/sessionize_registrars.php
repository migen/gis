<?php

function sessionizeRegistrars($db,$dbo=PDBO,$dbg=PDBG){
	$dbo=PDBO;
	require_once(SITE."functions/depts.php");
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize.php");
	$ucid=$_SESSION['user']['ucid'];	
	$_SESSION['branches']=fetchRows($db,"{$dbo}.`00_branches`"); 	
	$_SESSION['roles']=fetchRows($db,"{$dbo}.`00_roles`"); 
	$data['roles']=$_SESSION['roles'];	

	require_once(SITE."functions/sessionize_classroom.php");sessionizeLevelClassrooms($db); 
	$_SESSION['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name,department_id,subdepartment_id","id"); 	  	

	/* 1 - departments */
	$q=" SELECT * FROM {$dbo}.`88_contacts_departments` WHERE `contact_id` = '$ucid'; ";
	$sth=$db->querysoc($q);
	$data['department']=$dept=$sth->fetch();	
	$depts=deptsPush($dept,$depts=array());
	
	/* 2 - levels */
	if(!empty($depts)){
		$q = " SELECT l.id,l.name FROM {$dbo}.`05_levels` AS l ";
		$q .= " WHERE ";
		foreach($depts AS $dept){
			$q .= " l.department_id = '$dept' OR ";
		}
		$q = rtrim($q," OR ");
		$q .= " ORDER BY l.id ASC; ";
		$sth = $db->querysoc($q);
		$levels = $data['levels'] = $sth->fetchAll();
	} else {
		$levels = $data['levels'] = array();
	}

	/* 3 - depts classrooms */
	if(!empty($depts)){
		$q = "
			SELECT 
				cr.id,cr.name,cr.level_id,cr.section_id,
				l.name AS level,l.is_k12,l.is_ps,l.is_gs,l.is_hs,
				sec.name AS section
			FROM {$dbg}.05_classrooms AS cr
				LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
				LEFT JOIN {$dbo}.`05_sections` AS sec ON cr.section_id = sec.id			
		";
		$q .= " WHERE ";
		foreach($depts AS $dept){
			$q .= " l.department_id = '$dept' OR ";
		}
		$q = rtrim($q," OR ");
		$q .= " ORDER BY l.id ASC; ";
		$sth = $db->querysoc($q);
		$classrooms = $data['classrooms'] = $sth->fetchAll();
	} else {
		$classrooms = $data['classrooms'] = array();
	}

	unset($_SESSION['courses_locked']);	/* for registrars-gradebook */	
	
	$data['num_classrooms'] = count($data['classrooms']);
	$data['num_levels'] 	= count($data['levels']);
	$data['crids']	= buildArray($data['classrooms'],'id');	
		
	/* 4 */
if(($_SESSION['user']['role_id']==RREG) && ($_SESSION['user']['privilege_id']==2)){ 
	$_SESSION['user']['home']='registration'; $_SESSION['home']='registration'; 
}	
	
	$_SESSION['registrar']=$data;
	
}	/* fxn */


