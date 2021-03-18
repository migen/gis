<?php

function showColumns($db,$dbtable){	
	$q="SHOW columns FROM {$dbtable}; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();

	$fields=array();
	foreach($rows AS $row){
		$fields[]=$row['Field'];
	}
	return $fields;
	
}	/* fxn */



function getDbtableColumnsByString($db,$schema,$table,$except="'id'"){
	$q="SELECT GROUP_CONCAT(COLUMN_NAME) AS str_fields
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE TABLE_SCHEMA = '{$schema}' AND TABLE_NAME='$table' 
	AND COLUMN_NAME NOT IN ({$except}) ORDER BY ORDINAL_POSITION;";
	debug($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$str_fields=$row['str_fields'];
	return $str_fields;
		
}	/* fxn */

function getDbtableColumnsByArray($db,$schema,$table,$except="'id'"){
	$q="SELECT COLUMN_NAME AS `field`
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE TABLE_SCHEMA = '{$schema}' AND TABLE_NAME='$table' 
	AND COLUMN_NAME NOT IN ({$except}) ORDER BY ORDINAL_POSITION;";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['field_array']=buildArray($rows,'field');
	$data['count']=count($data['field_array']);
	$data['field_string']=implode(",",$data['field_array']);
	return $data;

		
}	/* fxn */

