<?php


function updateJoinYear($db,$dbsrc,$tblmaster,$tblsub,$fkey){
	$q="UPDATE {$dbsrc}.`{$tblsub}` AS a
		INNER JOIN 
		( SELECT * FROM {$dbsrc}.`{$tblmaster}`) AS b ON a.`{$fkey}`=b.id
		SET a.year=b.year;";
	pr($q);
	return $q;	
}


function dataCopy($db,$dbsrc,$dbdest,$dbtbl,$dbyr,$keepyears=0){
	$mvyear=$dbyr-$keepyears;
	$cond="`year` < '$mvyear' ";
	$q="INSERT INTO {$dbdest}.`{$dbtbl}`  
		( SELECT * FROM {$dbsrc}.`{$dbtbl}` WHERE $cond );";
	pr($q);
	return $q;
	
}

// DELETE FROM {$dbsrc}.`{$dbtbl}` WHERE $cond; 

function dataDelete($db,$dbsrc,$dbdest,$dbtbl,$dbyr,$keepyears=0){
	$mvyear=$dbyr-$keepyears;
	$cond="`year` < '$mvyear' ";
	$q="DELETE FROM {$dbsrc}.`{$dbtbl}` WHERE $cond; ";
	pr($q);
	return $q;	
}	/* fxn */


function rowExists($db,$table,$condkey,$condvalue,$fields="*"){
	$q = " SELECT $fields FROM $table WHERE `$condkey` = '$condvalue' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	return ($row)? true : false;
}	/* fxn */


function stackProcess($db,$tbl_src,$tbl_dest,$db_src,$db_dest,$limit=NULL,$offset=NULL){
	$q="SELECT GROUP_CONCAT(COLUMN_NAME) AS str_fields
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE TABLE_SCHEMA = '{$db_src}' AND TABLE_NAME='$tbl_src' 
	AND COLUMN_NAME NOT IN ('id') ORDER BY ORDINAL_POSITION;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	$str_fields=$row['str_fields'];
	
	/* 2 */
	$condlimit=($limit)? " LIMIT $limit OFFSET $offset ":NULL;
	$q="INSERT INTO {$db_dest}.`{$tbl_dest}`($str_fields) 
		( SELECT $str_fields FROM {$db_src}.`{$tbl_src}` $condlimit );";
	return $q;
	
}	/* fxn */


function getDbtableColumns($db,$schema,$table,$except="'id'"){
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

function getDbtableFields($db,$schema,$table,$except="'id'"){
	$q="SELECT COLUMN_NAME AS `field`
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE TABLE_SCHEMA = '{$schema}' AND TABLE_NAME='$table' 
	AND COLUMN_NAME NOT IN ({$except}) ORDER BY ORDINAL_POSITION;";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$data['field_array']=buildArray($rows,'field');
	$data['field_string']=implode(",",$data['field_array']);
	return $data;
	// pr($data);
	// $str_fields=$row['str_fields'];
	// return $str_fields;
		
}	/* fxn */


function getDbtables($db,$dbx){
	$q="SELECT table_name AS tbl
		FROM information_schema.tables WHERE table_schema='$dbx'; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$rows=buildArray($rows,"tbl");
	$count=$sth->rowCount();
	$data['rows']=&$rows;
	$data['count']=&$count;
	return $data;
	
	
}	/* fxn */
