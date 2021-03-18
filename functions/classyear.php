<?php

/* standalone - conflicts with reports,frcards */

/* classlists/classroom */
function classyear($db,$dbg,$sy,$crid,$male=2,$order="c.name",$fields=NULL,$filters=NULL,$limit=NULL,$active=0){
	$dbo=PDBO;
	if($male==1){ $is_male = " AND c.is_male = 1 "; } 
		elseif($male==0) { $is_male = " AND c.is_male = 0 "; }
		else { $is_male = null; }
	$is_active = ($active)? " AND c.`is_active` = '1' " : NULL;
		
	if(isset($_GET['sch'])){
		$sch=$_GET['sch'];
		$dbo=VCPREFIX."dbone_{$sch}";
	} else { $dbo=PDBO; }
		
	$q = "SELECT $crid AS crid,c.*,$fields sum.*,c.id AS scid,c.code AS student_code,c.name AS student,
		c.`sy`,sum.scid AS sumscid,c.is_active AS is_active
		FROM {$dbo}.`00_contacts` AS c INNER JOIN {$dbg}.05_summaries AS sum ON sum.scid = c.id
		WHERE sum.crid 	= '$crid' $is_male $filters ORDER BY $order ; ";	
	debug($q,"classyearFxn classyear");
	$sth = $db->querysoc($q);
	$_SESSION['q']="ClassyearFile-classyearFxn <br /> ".$q;
	return $sth->fetchAll();

}	/* fxn */


function canViewClasslist($db,$acid,$crid){
	$srid	= $_SESSION['srid'];
	$adroles=array(RADMIN,RMIS,RREG,RACAD,RLIB);	
	$admin = in_array($srid,$adroles)? true:false;	
	$adviser = ($acid==$_SESSION['ucid'])? true:false;		
	return ($admin || $adviser)? true:false;
}	/* fxn */
