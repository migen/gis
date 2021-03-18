<?php


/*
1 - is-stud
2 - settigs.studlogin = true
3 - dept / level
4 - shs

*/


function canViewRcardConditionsEC(){
	$srid=$_SESSION['srid'];
	$today=$_SESSION['today'];
	$studlogin=$_SESSION['settings']['studlogin'];
	
	if($srid!=RSTUD){ return true; } 
	if(!$studlogin){ return false; } 
	
	$start=$_SESSION['settings']['rcard_viewdates_start_ec'];
	$end=$_SESSION['settings']['rcard_viewdates_end_ec'];

	if($today<=$end && $today>=$start){
	} else {
		return false;		
	}

	return true;

	
}	/* fxn */
