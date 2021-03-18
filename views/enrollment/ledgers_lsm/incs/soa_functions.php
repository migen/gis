<?php

function pamt($annuity,$discperiod,$surcharge=0){	/* payables amount */
	$x = $annuity-$discperiod-$surcharge;	
	return round($x,2);
}	/* fxn */


function tbalance($tbalance){
	return ($tbalance<0)? 0:$tbalance;
}	/* fxn */



function isdue($duedate,$cutoff=NULL){	
	$cutdate = (is_null($cutoff))? $_SESSION['today']:$cutoff;
	$duedate = trim($duedate);
	$a = ($duedate<$cutdate)? true:false;	
	return ($a)? true:false;
}	/* fxn */


function getOrdinalX($num){
	switch($num){
		case 1: $ordinalnum = "1st"; break;
		case 2: $ordinalnum = "2nd"; break;
		case 3: $ordinalnum = "3rd"; break;
		default: $ordinalnum = $num."th"; break;	
	}
	return $ordinalnum;
}	/* fxn */





