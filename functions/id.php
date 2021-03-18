<?php 

function getIdByCode($db,$dbtable,$code){
	$q="SELECT id,code,name FROM {$dbtable} WHERE `code` = '$code' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


