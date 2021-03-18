<?php

function syncLvlDays($db,$lvl,$moid,$dbg=PDBG){

$q="SELECT DAY(`date`) AS day FROM {$dbg}.05_calendar WHERE MONTH(`date`)='$moid' ORDER BY date ASC LIMIT 50;";
$sth=$db->querysoc($q);
$rows=$sth->fetchAll();
$ar   = buildArray($rows,'day');
$y=getPatronsStats($db,$moid,$lvl);
$br   = buildArray($y,'day');
$ix = array_diff($ar,$br);

$q = " INSERT INTO {$dbg}.`patronstats`(`moid`,`lvl`,`day`) VALUES ";
foreach($ix AS $day){ $q .= " ('$moid','$lvl','$day'),"; }
$q = rtrim($q,",");
$q .= "; "; 
$db->query($q);



}	/* fxn */

