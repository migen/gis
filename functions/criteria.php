<?php




function deleteComponent($db,$id,$dbg=PDBG){	
	$dbo=PDBO;
	$q = " DELETE FROM {$dbg}.05_components WHERE `id` = '$id' LIMIT 1; ";
	$db->query($q);

}	/* fxn */


function deleteCriteria($db,$id,$dbg=PDBG){	
	$dbo=PDBO;
	$q = " DELETE FROM {$dbo}.`05_criteria` WHERE `id` = '$id' LIMIT 1; ";
	$db->query($q);

}	/* fxn */



function criteriaDetails($db,$dbg=PDBG,$sort=false,$order='DESC'){
	$dbo=PDBO;
	$sort = ($sort)? $sort:"cri.crstype_id,cri.is_active";
	$q = " SELECT cri.*,cty.name AS crstype,d.code AS department,cri.id AS criteria_id,cri.name AS criteria,cri.id AS id 	
		   FROM {$dbo}.`05_criteria` AS cri
			   LEFT JOIN {$dbo}.`05_crstypes` AS cty ON cri.crstype_id = cty.id
			   LEFT JOIN {$dbo}.`05_departments` AS d ON cri.department_id = d.id
		   ORDER BY $sort $order,cri.name ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

