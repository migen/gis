<?php

function getStudentDetails($db,$scid){
	$dbo=PDBO;
	$q="SELECT c.* FROM {$dbo}.`00_contacts` AS c WHERE c.id='$scid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
	
}	/* fxn */