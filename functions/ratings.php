<?php



function getRatingsFromDescriptions($db,$type_id=1,$dept_id=2,$dbg=PDBG,$debug=false){
	$dbo=PDBO;
	$dept_id=($dept_id==5)? 2:$dept_id;
	$type=" crstype_id='$type_id' " ;		
	if ($dept_id == 2) 			$dept=" is_gs = '1' ";
		elseif ($dept_id == 3) 	$dept=" is_hs = '1' ";
		else 					$dept=" is_ps = '1' ";
					 				 
	$q = "SELECT id AS dgid,rating,grade_floor AS grade FROM {$dbg}.05_descriptions 
			WHERE $type and $dept ORDER BY grade_floor desc; ";		
	debug($q,"ratings: getRatingsFromDescriptions - same as reportsFxn:getRatings() ");		
	
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();			
		if($debug OR isset($_GET['debug'])){
		pr($rows);
	}

	return $rows;
}	/* fxn */



function getTraitsRatings($db,$traitsCond,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT rating,grade_floor,grade_ceiling FROM {$dbg}.05_descriptions
			WHERE `crstype_id` = '2' AND ( $traitsCond ) ORDER BY grade_floor desc; ";					
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getPSMapehRatings($db,$psmapehsCond,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT rating,grade_floor,grade_ceiling FROM {$dbg}.05_descriptions
			WHERE `crstype_id` = '4' AND ( $psmapehsCond ) ORDER BY grade_floor desc; ";				
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

function getAcadRatings($db,$acadCond,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT rating,grade_floor,grade_ceiling FROM {$dbg}.05_descriptions
			WHERE `crstype_id` = '1' AND ( $acadCond ) ORDER BY grade_floor desc; ";					
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getConductRatings($db,$conductCond,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT rating,grade_floor,grade_ceiling FROM {$dbg}.05_descriptions
			WHERE `crstype_id` = '5' AND ( $conductCond ) ORDER BY grade_floor desc; ";					
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */



function getAllRatings($db,$student,$dbg=PDBG){
	$dbo=PDBO;
	$is_ps	= $student['is_ps'];
	$is_gs	= $student['is_gs'];
	$is_hs	= $student['is_hs'];
	$is_k12	= $student['is_k12'];

	/* case 1 */
	if($is_ps){
		$traitsCond   = " `is_ps` = 1  ";
		$r['traits']  = getTraitsRatings($db,$traitsCond,$dbg);	
		$r['psmapeh'] = $r['traits'];		
	}
	
	/* case 2 */
	if($is_k12 && $is_gs){
		$traitsCond = " `is_gs` = 1  ";
		$r['traits'] = getTraitsRatings($db,$traitsCond,$dbg);	
		$acadCond 	 = " `is_gs` = 1  ";
		$r['acad']   = getAcadRatings($db,$acadCond,$dbg);			
	}
	
	/* case 3 */
	if(!$is_k12 && $is_gs){ 
		$conductCond  = " `is_gs` = 1  ";
		$r['conduct'] = getConductRatings($db,$conductCond,$dbg);	
		$acadCond 	  = " `is_gs` = 1  ";
		$r['acad'] 	  = getAcadRatings($db,$acadCond,$dbg);	
	}

	/* case 4 */
	if($is_k12 && $is_hs){
		$traitsCond  = " `is_hs` = 1  "; 
		$r['traits'] = getTraitsRatings($db,$traitsCond,$dbg);	
		$acadCond 	 = " `is_hs` = 1  "; 
		$r['acad']   = getAcadRatings($db,$acadCond,$dbg);	
	}
	
	/* case 5 */
	if(!$is_k12 && $is_hs){
		$acadCond  = " `is_hs` = 1  "; 
		$r['acad'] = getAcadRatings($db,$acadCond,$dbg);	
	}
		
	return $r;	

}	/* fxn */

