<?php

function sessionizeRatings($db,$course){

	$crsClass	= classifyCourse($course);	
	$_SESSION['ctype'] = $ctype = isset($_GET['ctype'])? $_GET['ctype'] : $course['crstype_id'];
	$_SESSION['dept_id'] = $dept_id = isset($_GET['dept'])? $_GET['dept'] : $crsClass['dept_id'];
	$_SESSION['ratings']= getRatings($db,$ctype,$dept_id);		
	// echo "Sessionize ratings";
}
