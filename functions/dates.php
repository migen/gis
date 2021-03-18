<?php

function getDateNumber($date){	/* 1976-10-23 is 6 */
	return date('w',strtotime($date)); 
}	/* fxn */


function getDateDay($date){	/* 1976-10-23 is Sat */
	return date('D',strtotime($date)); 
}	/* fxn */


function formatDate($date){
	return date("F d, Y", strtotime($date));
}	/* fxn */



