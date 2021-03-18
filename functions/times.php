<?php

/* days,weeks,months,quarters,years */

function timediffToHours($tbig,$tlil){	
	$big = strtotime($tbig);
	$lil = strtotime($tlil);
	$x = $big-$lil;
	$hrs = round($x/60/60);
	return $hrs;
}	/* fxn */


function timediffToMinutes($tbig,$tlil){	
	$big = strtotime($tbig);
	$lil = strtotime($tlil);
	$x = $big-$lil;
	$min = round($x/60);
	return $min;
}	/* fxn */


function getSY($ssy,$month){	/* ssy is session sy */
	$first_month = $_SESSION['settings']['first_month'];
	if($month < $first_month){ $year = $ssy+1; } else { $year = $ssy; }		
	return $year;
}	/* fxn */


function getMonth($db,$moid,$code=true,$dbg=PDBG){
	$dbo=PDBO;
	$q 	 = " SELECT * FROM {$dbo}.months WHERE `id` = '$moid' or `index` = '$moid'  LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return ($code)? $row['code'] : $row['name'];
}	/* fxn */



function gisMonthsQuarters($db,$qtr=5,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT `id`,`name`,`code`,`quarter` FROM {$dbo}.`05_months_quarters` ";
	if($qtr < 5){ $q .= " WHERE `quarter` = '$qtr' "; }
	$q .= " ORDER BY `id`; ";
	$sth = $db->querysoc($q);				
	return $sth->fetchAll();
	
}	/* fxn */



