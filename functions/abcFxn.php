<?php


function syScidAccess($db,$scid){
	$dbo=PDBO;
	$data['scid']=$scid;
	$data['dbyr']=$dbyr=DBYR;
	// $data['dbyr']=$dbyr=$_SESSION['settings']['sy_enrollment'];
	$data['sy_enrollment']=$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
	$data['sy_grading']=$sy_grading=$_SESSION['settings']['sy_grading'];
	// $data['sy_grading']=$sy_grading=2021;
	$data['sy_payments']=$sy_payments=$_SESSION['settings']['sy_payments'];

	
	$row=fetchRow($db,"{$dbo}.00_contacts",$scid,"sy AS ensy,id AS scid");
	extract($row);
	
	$data['new_student']=$new_student=($ensy>=$dbyr)? true:false;
	$data['sy']=$new_student?$ensy:$dbyr;	
	
	$data['grensame']=$grensame=($sy_grading==$sy_enrollment)? true:false;
	
	$hasRcard=true;
	if($new_student && !$grensame){ $hasRcard=false; }
	
	$data['hasRcard']=$hasRcard;
	

	return $data;
	
	
}	/* fxn */




