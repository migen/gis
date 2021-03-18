<?php

function actions($db,$dbo=PDBO){
	$dbo=PDBO;	
	$q = " SELECT axn.*,m.code AS module_code 
			FROM {$dbo}.`00_actions` AS axn 
				INNER JOIN {$dbo}.modules AS m ON axn.module_id = m.id
			ORDER BY axn.name;";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

