<?php

/* yearbook */
function classlist($db,$dbg,$crid,$male=2,$order="c.`name` ASC",$fields=NULL,$filters=NULL,$limit=NULL,$active=1){	
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;

	$q = "SELECT 
			sum.*,c.is_male,$fields			
			c.id AS scid,c.code AS student_code,c.name AS student,
			c.is_active,c.is_cleared,			
			c.`sy`,sum.scid AS sumscid
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`00_profiles` AS p ON p.contact_id = c.id
			LEFT JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		WHERE 
				sum.crid 	= '$crid'
				$is_male $filters
		ORDER BY $order ; ";
	debug($q,"classlist: classlist");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}


function sxnlist($db,$dbg,$crid,$actv=1){	
	$dbo=PDBO;
	$is_active = ($actv)? " AND c.`is_active` = '1' " : NULL;
	$q = "SELECT c.id AS scid,c.code,c.name,c.is_male		
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbg}.05_summaries AS summ ON summ.scid = c.id
		WHERE summ.crid 	= '$crid' $is_active ORDER BY name ; ";
	debug($q,"classlist sxnlist");
	$sth = $db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */

function getClasslistSimple($db,$dbg,$crid,$order=NULL,$fields=NULL){
	$dbo=PDBO;
	$order=($order==NULL)? $_SESSION['settings']['classlist_order']:$order;
	$q="SELECT $fields summ.scid,c.name AS student,c.code AS studcode FROM {$dbg}.05_summaries AS summ
	INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id WHERE summ.crid='$crid' ORDER BY $order; ";
	debug($q,"classlist: getClasslistSimple");
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
}	/* fxn */


function getClasslistSummext($db,$dbg,$crid,$order,$fields=NULL){
	$dbo=PDBO;
	$q="SELECT $fields summ.scid,c.code AS studcode,c.name AS student
		FROM {$dbg}.05_summaries AS summ 
		INNER JOIN {$dbo}.`00_contacts` AS c ON summ.scid=c.id
		LEFT JOIN {$dbg}.05_summext AS sx ON sx.scid=summ.scid
		WHERE summ.crid='$crid' ORDER BY $order;";
	$sth=$db->querysoc($q);
	return $sth->fetchAll();
	
}	/* fxn */



