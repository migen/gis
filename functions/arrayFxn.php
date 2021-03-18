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
}	/* fxn */



function exclude($orig,$excl){
	$res=array_diff($orig,$excl);
	return $res;
}	/* fxn */