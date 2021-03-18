<?php


function getUniratings($db,$dbg=PDBG){					 				 
	$dbo=PDBO;
	$q = "SELECT id AS dgid,rating,grade_floor AS grade FROM {$dbg}.01_descriptions ORDER BY grade_floor desc; ";		
	debug($q,"uniratingsFxn: getUniratings");		
	$sth = $db->querysoc($q);
	return $sth->fetchAll();			
}	/* fxn */

function unirating($grade,$ratings){
	foreach($ratings AS $r){
		if($grade >= $r['grade']){		
			return $r['rating'];break;
		}
	}
	return "F";	
}



function getUniequivs($db,$dbg=PDBG){				 
	$dbo=PDBO;
	$q = "SELECT `floor` AS `grade`,`equivalent` AS `equiv`
				FROM {$dbg}.01_equivalents ORDER BY floor desc; ";		
	$sth = $db->querysoc($q);
	return $sth->fetchAll();			
}	/* fxn */



function uniequiv($grade,$equivs){
	foreach($equivs AS $e){
		if($grade >= $e['grade']){
			return $e['equiv'];break;			
		}
	}
	return "60";	
}	/* fxn */

