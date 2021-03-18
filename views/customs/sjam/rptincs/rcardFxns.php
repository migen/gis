<?php

$tbl_width="auto";

function getOrdinalName($num){
	switch($num){
		case 1: $ordinalnum = "First"; break;
		case 2: $ordinalnum = "Second"; break;
		case 3: $ordinalnum = "Third"; break;
		case 4: $ordinalnum = "Final"; break;
		default: $ordinalnum = $num."th"; break;	
	}
	return $ordinalnum;
}	/* fxn */


function getOrdinal($num){
	switch($num){
		case 1: $ordinalnum = "1st"; break;
		case 2: $ordinalnum = "2nd"; break;
		case 3: $ordinalnum = "3rd"; break;
		case 4: $ordinalnum = "Final"; break;
		default: $ordinalnum = $num."th"; break;	
	}
	return $ordinalnum;
}	/* fxn */

