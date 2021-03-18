<?php



function studentCanViewCurrentRcardOnly($sy){
	$srid=$_SESSION['srid'];
	$sy_grading=$_SESSION['settings']['sy_grading'];
	$d = "sy: ".$sy."<br />";
	$d.="srid: ".$srid."<br />";
	$d.="sy_grading: ".$sy_grading."<br />";
	
	$allowed=true;
	
	if(($srid==RSTUD) && ($sy!=$sy_grading)){
		$allowed=false;
	}
	
	$d=$allowed? "allowed":"NOT allowed";echo "<br />";
	return $allowed? true:false;
	
}