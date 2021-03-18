<?php

/* 
	
*/



function transmute($totalscore,$totalmax){	
	$a = $_SESSION['settings']['floor_score'];
	$b = (100-$a);	
	$x = ($totalscore / $totalmax) * $b + $a;
	return $x;
}

function transmutePct($totalpct,$num_subcriteria){
	$a = $_SESSION['settings']['floor_score'];
	$b = (100-$a);	
	
	$x = $totalpct / $num_subcriteria * $b + $a;
	return $x;	

}

