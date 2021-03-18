<?php



function getOrnoNext($db){
	$ucid=$_SESSION['ucid'];
	$dbo=PDBO;
	$q="SELECT * FROM {$dbo}.03_orbooklets WHERE ecid=$ucid LIMIT 1; ";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$last_orno=$row['orno'];
	$last_orno=(int)$last_orno;
	return ($last_orno+1);			
}	/* fxn */


/* ajax-xorno */ 
function updateUserOrno($db,$orno,$ecid=false){
	if(!$ecid){ $ecid=$_SESSION['ucid']; }
	$dbo=PDBO;
	$q="UPDATE {$dbo}.03_orbooklets SET orno='$orno' WHERE ecid=$ecid LIMIT 1;";
	$db->query($q);
}	/* fxn */
