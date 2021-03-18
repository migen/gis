<?php



function getEquivs($db,$ctype_id = 1,$dept_id = 2,$dbg=PDBG){				 
	$dbo=PDBO;
	$ctype = " crstype_id = '$ctype_id' " ;		
	if ($dept_id == 1) 			$dept = " is_ps = '1' ";
		elseif ($dept_id == 3) 	$dept = " is_hs = '1' ";
		else 					$dept = " is_gs = '1' ";
					 				 
	$q = "
			SELECT `id` AS `eqid`,`floor` AS `grade`,`equivalent` AS `equiv`
				FROM {$dbg}.05_equivalents
			WHERE $ctype and $dept  
			ORDER BY floor desc;
		";		
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
			
}	/* fxn */


function rating($grade,$ratings){
	foreach($ratings AS $r){
		if($grade >= $r['grade']){		
			return $r['rating'];break;
		}
	}
	return "F";	
}


function equiv($grade,$equivs){
	foreach($equivs AS $e){
		if($grade >= $e['grade']){
			return $e['equiv'];break;			
		}
	}
	return "60";	
}

