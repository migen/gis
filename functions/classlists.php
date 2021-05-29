<?php


function canViewClasslist($db,$acid,$crid){
	$dbo=PDBO;
	$srid	= $_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD,RLIB,RTEAC);
	$admin = in_array($srid,$adroles)? true:false;	
	$adviser = ($acid==$_SESSION['ucid'])? true:false;		
	if($srid==RTEAC and !$adviser){ if($_SESSION['user']['privilege_id']>0){ flashRedirect($home); } }
	return ($admin || $adviser)? true:false;
}	/* fxn */


function getClasslist($db,$dbg,$crid,$order,$fields=NULL,$is_active=NULL){
	$cond=NULL; if($is_active){ $cond="AND c.is_active=1"; }
	$dbo=PDBO;
	$q=" SELECT $fields summ.scid,c.code,c.name,c.is_male,c.position,c.lrn,c.sy AS ensy
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		WHERE summ.crid='$crid' $cond
		ORDER BY $order;";		
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */

function getClasslistByProfile($db,$dbg,$crid,$order,$fields=NULL,$is_active=NULL){
	$cond=NULL; if($is_active){ $cond="AND c.is_active=1"; }
	$dbo=PDBO;
	$q=" SELECT $fields summ.scid,c.code,c.name,c.is_male,c.position,c.lrn 
		FROM {$dbo}.`00_contacts` AS c 
		INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
		LEFT JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		WHERE summ.crid='$crid' $cond
		ORDER BY $order;";		
	debug($q);
	$sth=$db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */
