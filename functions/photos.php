<?php



function getClassPhotos($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=1){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;

	$q = "
		SELECT 		
			c.id AS scid,c.name AS student,img.photo		
		FROM {$dbg}.`05_summaries` AS sum
			LEFT JOIN {$dbg}.05_students AS s ON sum.scid  = s.contact_id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON sum.scid  = c.id
			LEFT JOIN {$dbo}.`00_profiles` AS p ON sum.scid  = p.contact_id
			LEFT JOIN ".DBP.".photos AS img ON sum.scid  = img.contact_id
		WHERE sum.crid 	= '$crid'
			$is_male $filters ORDER BY $order ;		
	";	
	$sth = $db->querysoc($q);
	if(!$sth){ echo "gmodel-getClassPhoto: "; pr($q); }
	return $sth->fetchAll();

}	/* fxn */

