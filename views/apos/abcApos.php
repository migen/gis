<?php


function arrayAddKeyValuePair($rows,$field,$value){
	$new_rows=array();
	$i=0;
	foreach($rows AS $row){
		$new_rows[$i]=$row;
		$new_rows[$i][$field]=$value;
		$i++;

	}
	return $new_rows;
	
	
}


// pr($data);
pr($rows);

echo "<hr />";


$rows=arrayAddKeyValuePair($rows,"pos_id",$pos_id);

pr($rows);