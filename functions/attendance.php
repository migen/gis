<?php

function classlistAttschema($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;
	
	$q = "
		SELECT 
			$crid AS crid,$crid AS crid,c.*,$fields			
			sum.*,c.id AS scid,c.code AS student_code,c.name AS student,c.`sy`,			
			sum.id AS sumid,sum.scid AS sumscid
		FROM {$dbo}.`00_contacts` AS c
			INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
			LEFT JOIN {$dbg}.05_attendance_schemas AS ats ON ats.id = c.attschema_id
		WHERE 
				sum.crid 	= '$crid'
				$is_active $is_male $filters
		ORDER BY $order ;			
	";	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
		

}	/* fxn */

function sumpreQtr($row){	 /* sum present days */
	$tdpre = ($row['q1_days_present'] + $row['q2_days_present'] + $row['q3_days_present'] + $row['q4_days_present']);
	return $tdpre;
}

function sumtarQtr($row){	 /* sum tardy days */
	$tdtar = ($row['q1_days_tardy']+$row['q2_days_tardy']+$row['q3_days_tardy']+$row['q4_days_tardy']);
	return $tdtar;
}


function sumpre($row){	 /* sum present days */
	$tdpre = (
		$row['jun_days_present'] + $row['jul_days_present'] + $row['aug_days_present'] + $row['sep_days_present'] + 
		$row['oct_days_present'] + $row['nov_days_present'] + $row['dec_days_present'] + $row['jan_days_present'] + 
		$row['feb_days_present'] + $row['mar_days_present'] + $row['apr_days_present'] + $row['may_days_present'] 	
	);
	return $tdpre;
}
	
function sumtar($row){	/* sum tardy days */
	$tdtar = (
		$row['jun_days_tardy'] + $row['jul_days_tardy'] + $row['aug_days_tardy'] + $row['sep_days_tardy'] + 
		$row['oct_days_tardy'] + $row['nov_days_tardy'] + $row['dec_days_tardy'] + $row['jan_days_tardy'] + 
		$row['feb_days_tardy'] + $row['mar_days_tardy'] + $row['apr_days_tardy'] + $row['may_days_tardy'] 	
	);
	return $tdtar;
}



function attendance($db,$dbg,$sy,$scid){
$dbo=PDBO;
$q = "SELECT att.*,att.id AS attid,c.id AS scid,c.code AS student_code,c.name AS student 
	FROM {$dbg}.05_attendance as att
		INNER JOIN {$dbo}.`00_contacts` AS c ON att.scid 	= c.id	 			
	WHERE att.`scid`  = '$scid'; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function attendanceMonths($db,$level_id,$sy,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbg}.05_attendance_months WHERE 	`level_id` = '".$level_id."' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();		
}	/* fxn */


function talpre($db,$dbg,$cid,$year,$month,$emps=false){	/* present-attendance */
	$dbo=PDBO;
	$is_incl = ($emps)? 'is_included_employees':'is_included';	
	$attlogs = ($emps)? 'attendance_employees_logs':'attendance_logs';
	$q = "
		SELECT count(att.id) AS result FROM {$dbg}.`$attlogs` AS att		
			INNER JOIN {$dbg}.05_calendar AS cal ON att.date = cal.date 
		WHERE 	
				att.`contact_id` = '$cid'
			AND YEAR(att.`date`) = '$year'
			AND MONTH(att.`date`) = '$month' 
			AND cal.`$is_incl` = '1' ;
	";
	// pr($q); exit;
	$sth = $db->querysoc($q);	
	$row = $sth->fetch();
	return $row['result'];
}	/* fxn */


function taltar($db,$dbg,$cid,$year,$month,$timein,$timeout){ 	/* tardy-attendance */
	$dbo=PDBO;
	$q = "SELECT count(id) AS result FROM {$dbg}.05_attendance_logs		
		WHERE `contact_id` = '$cid' AND YEAR(`date`) = '$year' AND MONTH(`date`) = '$month' AND `timein` > '$timein';";
	// pr($q); exit;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row['result'];
}	/* fxn */


/* tardy-attendance */
function talmin($db,$dbg,$cid,$year,$month,$schtimein,$schtimeout){ 
	$dbo=PDBO;
	$q = "SELECT sum(a.mintardy) AS result
		FROM (
			select `timein`,'$schtimein',round(TIME_TO_SEC(TIMEDIFF(`timein`,'$schtimein'))/60) AS mintardy			
			FROM {$dbg}.05_attendance_logs 
			WHERE `contact_id` = '$cid' AND YEAR(`date`) = '$year' AND MONTH(`date`) = '$month' AND `timein` > '$schtimein'
		) AS a; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return $row['result'];
}	/*  fxn */


function getEmployeeAttendance($db,$dbg,$sy,$ecid){
$dbo=PDBO;
$q = "SELECT att.*,att.id AS attid,c.id AS ecid,c.code AS employee_code,c.name AS employee
	FROM {$dbg}.06_attendance_employees as att RIGHT JOIN {$dbo}.`00_contacts` AS c ON att.ecid 	= c.id	 			
	WHERE att.`ecid`  = '$ecid'; ";
$sth = $db->querysoc($q);
return $sth->fetch();

}	/* fxn */


