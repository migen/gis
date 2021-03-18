<?php 



$scid=$scid;
$sy=DBYR;
$qtr=$_SESSION['qtr'];
$incs=SITE."functions/enrollmentFxn.php";require_once($incs);
	$data=getAssessmentDataForClearance($db,$sy,$scid);
	extract($data);
$incs=SITE."views/customs/sjam/assessmentIncs_sjam.php";require_once($incs);
	$paymode_id=$student['paymode_id'];
	$allowance=$_SESSION['settings']['balance_cutoff'];
	$accounts['period_factor']=$period_factor=getPeriodFactor($qtr,$paymode_id);
$accounts=getStudentAccounts($db,$sy,$scid,$student,$qtr,$period_factor,$arp,$payments,$allowance,$student['previous_balance']);


prx($accounts);
// prx($data);






