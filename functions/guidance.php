<?php



function getStudentIscores($db,$dbg,$scid,$tcid,$sy,$period){
$dbo=PDBO;
$q = "
		SELECT 
			icomp.*,
			isc.*,isc.`id` AS `iscid`,
			icri.name AS item,icri.icategory_id,icat.name AS icategory
		FROM {$dbg}.`iscores` AS `isc`		
			LEFT JOIN {$dbg}.`icomponents` AS `icomp` ON isc.`icomponent_id` = icomp.`id`
			LEFT JOIN {$dbg}.`icriteria` AS `icri` ON icomp.`icriteria_id` = icri.`id`
			LEFT JOIN {$dbg}.`icategories` AS `icat` ON icri.`icategory_id` = icat.`id`
		WHERE isc.`asor_cid` = '$scid' AND	isc.`asee_cid` 		= '$tcid'
			AND isc.`sy` = '$sy'
			AND isc.`period` = '$period'
		ORDER BY icri.icategory_id,icri.`id`; ";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


function getIgrade($db,$dbg,$sy,$period,$tcid,$scid,$itype_id){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbg}.igrades WHERE
		`itype_id` = '$itype_id',`sy` = '$sy',`period` = '$period',
		`asee_cide` = '$tcid',`asor_cid` = '$scid' LIMIT 1
	;";
	$db->querysoc($q);
	return $sth->fetch();

}	/* fxn */

	
function getIcomponents($db,$itype_id,$dbg=PDBG){
$dbo=PDBO;
$q = " SELECT 
			icri.name AS icriteria,
			icat.code AS icategory_code,icat.name AS icategory,
			icomp.*,icomp.id AS icomponent_id
		FROM {$dbg}.icomponents AS icomp
			LEFT JOIN {$dbg}.icriteria AS icri ON icomp.icriteria_id = icri.id
			LEFT JOIN {$dbg}.icategories AS icat ON icri.icategory_id = icat.id
		WHERE icomp.`itype_id` = '$itype_id'
		ORDER BY icri.icategory_id,icri.`id`;";
$sth = $db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */
	


function getItypeDetails($db,$itype_id,$dbg=PDBG){
	$dbo=PDBO;
	$q = " SELECT * FROM {$dbg}.`itypes` WHERE `id` = '$itype_id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */
	
