<?php

function getPatronDetails($db,$code,$dif,$dbg=PDBG){
	$dbo=PDBO;$dbp=DBP;
	$q="SELECT c.name AS name,c.code AS code,c.id AS ucid,
			'$dif' AS dif,d.code AS dcp,d.id AS dip,
			p.photo,cr.name AS classroom,l.id AS lvl
		FROM {$dbo}.`00_contacts` AS c
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id 
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id 
		LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id 
		LEFT JOIN {$dbo}.88_ip_subdepts AS d ON l.subdepartment_id = d.id 
		LEFT JOIN {$dbp}.photos AS p ON p.contact_id = c.id 
		WHERE c.`code`='$code' LIMIT 1; ";		
	$sth=$db->querysoc($q);
	return $sth->fetch();

}	/* fxn */

function getDeptcode($lvl){
	switch($lvl){
		case $lvl < 10: $deptcode="GS"; break;
		case $lvl < 14: $deptcode="HS"; break;
		default: $deptcode="SHS"; break;	
	}
	return $deptcode;
}


function longEnough($timeout,$timenow,$interval){
	$tsout = strtotime($timeout);
	$tsnow = strtotime($timenow);
	$tsdiff = $tsnow - $tsout;
	$minsdiff = $tsdiff/60;
	return (round($minsdiff)>$interval)? true:false;
}	/* fxn */	



function sessionizeNumvisitors($db,$date,$dbg=PDBG){
$dbo=PDBO;
$q=" UPDATE {$dbg}.libstats AS a
		LEFT JOIN (
			SELECT count(p.id) AS count,cr.level_id AS lvl,p.date
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.ucid
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			WHERE p.date='$date' AND l.subdepartment_id='2'	
		) AS b ON a.date = b.date 
		SET a.num_gs=b.count
		WHERE a.date='$date'; ";
$db->query($q);

$q=" UPDATE {$dbg}.libstats AS a
		LEFT JOIN (
			SELECT count(p.id) AS count,cr.level_id AS lvl,p.date
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.ucid
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			WHERE p.date='$date' AND l.subdepartment_id='3'	
		) AS b ON a.date = b.date 
		SET a.num_hs=b.count
		WHERE a.date='$date';		
	";
$db->query($q);

$q=" UPDATE {$dbg}.libstats AS a
		LEFT JOIN (
			SELECT count(p.id) AS count,cr.level_id AS lvl,p.date
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.ucid
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id=l.id
			WHERE p.date='$date' AND l.subdepartment_id='4'	
		) AS b ON a.date = b.date 
		SET a.num_shs=b.count
		WHERE a.date='$date';		
	";
$db->query($q);


$q=" UPDATE {$dbg}.libstats AS a
		LEFT JOIN (
			SELECT count(p.id) AS count,p.date
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=p.ucid
			WHERE p.date='$date' AND c.role_id <> 1	
		) AS b ON a.date = b.date 
		SET a.num_empl=b.count
		WHERE a.date='$date';		
	";

$db->query($q);

$q="UPDATE {$dbg}.libstats SET num_visitors=(ifnull(`num_gs`,0)+ifnull(`num_hs`,0)+ifnull(`num_shs`,0)+ifnull(`num_empl`,0)) 
WHERE date='$date' LIMIT 1;";
$db->query($q);

$q="SELECT * FROM {$dbg}.libstats WHERE `date`='$date' LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
if(empty($row)){
	$q="INSERT INTO {$dbg}.libstats(`date`)VALUES('$date');";		
	$db->query($q);		
}
$_SESSION['num_empl'] = $row['num_empl'];
$_SESSION['num_ps'] = $row['num_ps'];
$_SESSION['num_gs'] = $row['num_gs'];
$_SESSION['num_hs'] = $row['num_hs'];
$_SESSION['num_shs'] = $row['num_shs'];
$_SESSION['num_visitors'] = $row['num_visitors'];

}	/* fxn */


function incrementNumvisitors($db,$date){
$dbo=PDBO;$dbg=PDBG;
$q="UPDATE {$dbg}.libstats SET `num_visitors`=(`num_visitors`+1) WHERE `date`='$date' LIMIT 1; ";
$db->query($q);
$_SESSION['num_visitors']=$_SESSION['num_visitors']+1;
	
}	/* fxn */


function incrementNumvisitorsByDept($db,$date,$dept='gs'){
$dept=strtolower($dept);
$dbg=PDBG;
$q="UPDATE {$dbg}.libstats SET `num_visitors`=(`num_visitors`+1), 
`num_{$dept}`=(`num_{$dept}`+1) WHERE `date`='$date' LIMIT 1; ";
$db->query($q);
$_SESSION['num_visitors']=$_SESSION['num_visitors']+1;
$_SESSION['num_'.$dept]=$_SESSION['num_'.$dept]+1;
	
}	/* fxn */
