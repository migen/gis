<?php

function countdown($deadline,$today){
	$dt1 = strtotime($deadline);
	$dt2 = strtotime($today);
	$dtdiff = $dt1 - $dt2;
	$days_left = $dtdiff/(3600*24);
	return $days_left;
}	/* fxn */
