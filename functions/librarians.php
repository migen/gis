<?php

function getSessionLevelsAndClassrooms($db,$dbg=PDBG){
if(!isset($_SESSION['classrooms'])){ 
	$_SESSION['classrooms'] = fetchRows($db,"{$dbg}.05_classrooms","id,name,acid AS acid","level_id,name"); 	 } 
$data['classrooms'] = $_SESSION['classrooms'];	

if(!isset($_SESSION['levels'])){ 
	$_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,name","id"); 	 } 
$data['levels'] = $_SESSION['levels'];	

return $data;

}	/* fxn */


function getPatronsReport($db,$params,$dbg=PDBG){
	$dbo=PDBO;
	$sort   = (isset($params['sort']))?$params['sort']:'p.date';
	$order  = (isset($params['order']))?$params['order']:'DESC';
	$offset = ($params['page']-1)*$params['limits'];
		
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
			
	$cond = NULL;
	$cond .= "";
	if (!empty($params['start'])){ $cond .= " AND p.date >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND p.date <= '".$params['end']."'"; }				
	if (!empty($params['ucid'])){ $cond .= " AND p.ucid = '".$params['ucid']."'"; }				
	if (!empty($params['lvl'])){ $cond .= " AND cr.level_id = '".$params['lvl']."'"; } 				
	if (!empty($params['crid'])){ $cond .= " AND cr.id = '".$params['crid']."'"; } 				

	$q=" SELECT p.*,c.code,c.name AS contact,cr.name AS classroom,d.code AS dcf,d.id AS dif
		FROM {$dbg}.70_patrons AS p 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ucid = c.id
		LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
		LEFT JOIN {$dbo}.88_ip_subdepts AS d ON p.subdepartment_id = d.id
	WHERE 1=1 $cond ORDER BY $sort $order $condlimits; ";
	// pr($q);
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	$data['rows']=$rows;
	$data['q']=$q;
	return $data;

}	/* fxn */




function getPatronStats($db,$params,$dbg=PDBG){
	$dbo=PDBO;
	$cond="";		
	if($params['start']==$params['end']){
		$cond.="AND p.date='".$params['start']."'";
	} else {
		if (!empty($params['start'])){ $cond .= " AND p.date >= '".$params['start']."'"; }				
		if (!empty($params['end'])){ $cond .= " AND p.date <= '".$params['end']."'"; }					
	}

/* f */
$x=array(0=>'def',1=>'psf',2=>'gsf',3=>'hsf',4=>'shsf');
/* p */
$y=array(2=>'gsp',3=>'hsp',4=>'shsp');
	
$qs="
	SELECT 
		COUNT(p.id) AS count 
	FROM {$dbg}.70_patrons AS p 
	LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ucid = c.id
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
	LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
	LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
	WHERE
";	
// pr($qs);
$rows=array();
for($i=0;$i<5;$i++){
	if($i==1) continue;
	$fv=$x[$i];
	for($j=2;$j<5;$j++){
		$pv=$y[$j];
		// echo " (p.subdepartment_id is $i or $fv) AND ( l.subdepartment_id = $j or $pv ) <br />";
		$q="$qs p.subdepartment_id = $i AND l.subdepartment_id = $j $cond "; 
		// pr($q);
		$sth=$db->querysoc($q);
		// $r=$sth->fetchAll();
		$r=$sth->fetch();
		$rows[$i][$j]=$r;
		
	}
}	/* i */

// pr($rows);
// exit;

$qe="
	SELECT 
		COUNT(p.id) AS count 
	FROM {$dbg}.70_patrons AS p 
	LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ucid = c.id
	WHERE
";	

for($i=0;$i<5;$i++){
	if($i==1) continue;
	// echo " (p.subdepartment_id is $i or $fv) AND ( l.subdepartment_id = $j or $pv ) <br />";
	$q="$qe c.role_id <> '".RSTUD."' AND p.subdepartment_id = $i $cond "; 
	// pr($q);
	$sth=$db->querysoc($q);
	$r=$sth->fetch();
	$rows[$i][9]=$r;
		
}	/* i */




$data['rows']=$rows;	
	
	return $data;


	
	
}	/* fxn */



function sessionizeLibstats($db,$dbg=PDBG){
	$dbo=PDBO;
	$cond="";		
	$today=$_SESSION['today'];
	// $cond.="AND p.date='".$params['start']."'";
	$cond.="AND p.date='$today'";

		
/* f */
$x=array(0=>'def',1=>'psf',2=>'gsf',3=>'hsf',4=>'shsf');
/* p */
// $y=array(2=>'gsp',3=>'hsp',4=>'shsp');
	
$qs="
	SELECT 
		COUNT(p.id) AS count 
	FROM {$dbg}.70_patrons AS p 
	LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ucid = c.id
	LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
	LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
	LEFT JOIN {$dbo}.`05_levels` AS l ON cr.level_id = l.id
	WHERE
";	

/* gs */
$gs = $qs." p.subdepartment_id=2 $cond ; ";
$sth=$db->querysoc($gs);
$r=$sth->fetch();
$_SESSION['libstats'][2]['total']=$r['count'];

/* hs */
$hs = $qs." p.subdepartment_id=3 $cond ; ";
$sth=$db->querysoc($hs);
$r=$sth->fetch();
$_SESSION['libstats'][3]['total']=$r['count'];

/* shs */
$shs = $qs." p.subdepartment_id=4 $cond ; ";
$sth=$db->querysoc($shs);
$r=$sth->fetch();
$_SESSION['libstats'][4]['total']=$r['count'];

	
}	/* fxn */

