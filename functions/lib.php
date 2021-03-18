<?php

function getMonthDetails($db,$moid){
$dbo=PDBO;
$q="SELECT * FROM {$dbo}.months WHERE `index`='$moid' LIMIT 1; ";
$sth=$db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function ulps($db,$moid,$lvl,$dbg=PDBG){
$moidno=ltrim($moid,'0');
$rdays=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
$sy=$_SESSION['sy'];
if($moid < $_SESSION['settings']['month_start']){ $year = $sy+1; } else {$year=$sy; }

$q="";
foreach($rdays AS $day){
	$date=$year.'-'.$moid.'-'.$day;
	$q.="
		UPDATE {$dbg}.70_patronstats AS a
		LEFT JOIN (
			SELECT count(p.id) AS count,cr.level_id AS lvl
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.ucid
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE p.date='$date' AND cr.level_id='$lvl'	
		) AS b ON a.lvl = b.lvl 
		SET a.{$day}=b.count
		WHERE a.moid='$moidno' AND a.lvl = '$lvl';		
	";
}	
$db->querysoc($q);

/* 2 total */
$q="UPDATE {$dbg}.70_patronstats SET `total`=(ifnull(`1`,0)+ifnull(`2`,0)+ifnull(`3`,0)+ifnull(`4`,0)+ifnull(`5`,0)+ifnull(`6`,0)+ifnull(`7`,0)+ifnull(`8`,0)+ifnull(`9`,0)+ifnull(`10`,0)+ifnull(`11`,0)+ifnull(`12`,0)+ifnull(`13`,0)+ifnull(`14`,0)+ifnull(`15`,0)+ifnull(`16`,0)+ifnull(`17`,0)+ifnull(`18`,0)+ifnull(`19`,0)+ifnull(`20`,0)+ifnull(`21`,0)+ifnull(`22`,0)+ifnull(`23`,0)+ifnull(`24`,0)+ifnull(`25`,0)+ifnull(`26`,0)+ifnull(`27`,0)+ifnull(`28`,0)+ifnull(`29`,0)+ifnull(`30`,0)+ifnull(`31`,0)) WHERE moid='$moid' AND lvl='$lvl';";

$db->querysoc($q);

echo "Moid $moid LVL: $lvl <br />";

}	/* fxn */



function ulpsEmployees($db,$moid,$lvl,$dbg=PDBG){
$dbo=PDBO;
$moidno=ltrim($moid,'0');
$rdays=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
$sy=$_SESSION['sy'];
if($moid < $_SESSION['settings']['month_start']){ $year = $sy+1; } else {$year=$sy; }

$lvl=0;

$q="";
foreach($rdays AS $day){
	$date=$year.'-'.$moid.'-'.$day;
	$q.="
		UPDATE {$dbg}.70_patronstats AS a
		LEFT JOIN (
			SELECT count(p.id) AS count,0 AS lvl
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbo}.`00_contacts` AS c ON c.id=p.ucid
			WHERE p.date='$date' AND c.role_id<>'".RSTUD."'	
		) AS b ON a.lvl = b.lvl 
		SET a.{$day}=b.count
		WHERE a.moid='$moidno' AND a.lvl = '$lvl';		
	";
}	
$db->querysoc($q);

/* 2 total */
$q="UPDATE {$dbg}.70_patronstats SET `total`=(ifnull(`1`,0)+ifnull(`2`,0)+ifnull(`3`,0)+ifnull(`4`,0)+ifnull(`5`,0)+ifnull(`6`,0)+ifnull(`7`,0)+ifnull(`8`,0)+ifnull(`9`,0)+ifnull(`10`,0)+ifnull(`11`,0)+ifnull(`12`,0)+ifnull(`13`,0)+ifnull(`14`,0)+ifnull(`15`,0)+ifnull(`16`,0)+ifnull(`17`,0)+ifnull(`18`,0)+ifnull(`19`,0)+ifnull(`20`,0)+ifnull(`21`,0)+ifnull(`22`,0)+ifnull(`23`,0)+ifnull(`24`,0)+ifnull(`25`,0)+ifnull(`26`,0)+ifnull(`27`,0)+ifnull(`28`,0)+ifnull(`29`,0)+ifnull(`30`,0)+ifnull(`31`,0)) WHERE moid='$moid' AND lvl='$lvl';";

$db->querysoc($q);

echo "Moid $moid LVL: $lvl <br />";

}	/* fxn */



function upsd($db,$date,$dbg=PDBG){	
	$moidno=date('m',strtotime($date));
	$day=date('d',strtotime($date));
	$q="";
	$levels=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
foreach($levels AS $lvl){
	$q.="
		UPDATE {$dbg}.70_patronstats AS a
		LEFT JOIN (
			SELECT count(p.id) AS count,cr.level_id AS lvl
			FROM {$dbg}.70_patrons AS p 
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid=p.ucid
			LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			WHERE p.date='$date' AND cr.level_id='$lvl'	
		) AS b ON a.lvl = b.lvl 
		SET a.{$day}=b.count
		WHERE a.moid='$moidno' AND a.lvl = '$lvl';		
	";
}
	$db->querysoc($q);

}	/* fxn */



