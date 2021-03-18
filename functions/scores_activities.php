<?php


function activities($db,$dbg,$course_id,$qtr){
$dbo=PDBO;
$course = $data['course'] = $_SESSION['course'];
$data['current_qtr'] = $_SESSION['qtr'];
$is_locked  = $course['is_finalized_q'.$qtr];
$data['qtr'] = $qtr;
			
$qqtr			= 'q'.$qtr;
$data['qqtr'] 	= $qqtr;

if($_SESSION['settings']['tier_adapter'] == 3){		
	if($data['course']['is_kpup'] == 1){	
		$data['activities'] = getActivitiesKpup($db,$dbg,$course_id,$qtr,$dbg);	
	} else {	
		$data['activities'] = getActivities($db,$dbg,$course_id,$qtr);	
	}
} else {
	$data['activities'] = getActivities($db,$dbg,$course_id,$qtr);	

}
	
$data['num_activities'] = count($data['activities']);	
return $data;	


} 	/* fxn */

