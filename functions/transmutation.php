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
	// echo "$x is $totalpct divby $num_subcriteria * $b + $a <br />";
	return $x;	

}


function gradeEquiv($grade){
	$sfg = $_SESSION['settings']['floor_grade_equiv'];
	$scg = $_SESSION['settings']['ceiling_grade_equiv'];	
	$fg	 = ($grade >= $sfg)? $grade : $sfg;
	$gr	 = ($fg <= $scg)? $fg : $scg;	
	return $gr;

}