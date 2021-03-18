<?php



function sessionizeAcl($db,$ucid){	
	$dbo=PDBO;
	$q="SELECT url_id FROM {$dbo}.acl WHERE ucid='$ucid'; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$_SESSION['acl']['url_ids']=buildArray($rows,'url_id');
	
	
}	/* fxn */
