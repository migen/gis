<?php

function updateRestdaysByEmployee($db,$post,$dbhr){	
	$dbo=PDBO;
	$pcid=$post['pcid'];
	$ar=$post['restdays'];
	$br=$_SESSION['hr']['employees'][$pcid]['restdays'];
	$ix = array_diff($ar,$br);		/* add */
	$jx = array_diff($br,$ar);		/* remove */	
	/* 1 add new restdays */
	$q="";
	foreach($ix AS $restday){ $q.="INSERT INTO {$dbhr}.restdays(`pcid`,`restday`)VALUES('$pcid','$restday'); "; }
	foreach($jx AS $restday){ $q.="DELETE FROM {$dbg}.06_restdays WHERE 
		`pcid`='$pcid' AND `restday`='$restday'; "; }	
	$db->query($q);
	
}	/* fxn */


