<?php

function dbgExists($db,$sy=DBYR){
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$q="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbg';";
	$sth=$db->query($q);
	$row=$sth->fetch();
	return (!empty($row))? true:false;

}	/* fxn */