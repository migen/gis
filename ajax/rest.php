<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

function pr($r){ echo "<pre>"; print_r($r); echo "</pre>"; }

/* 
$q = " SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE id > 80 LIMIT 4; ";
pr($q);
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
pr($rows);
echo json_encode($rows);	

 */

 
$q = " SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE id > 80 LIMIT 10 ; ";
// $_SESSION['q'] = $q;
// pr($q);
$sth = $db->querysoc($q);
$rows = $sth->fetchAll();
echo json_encode($rows);	








