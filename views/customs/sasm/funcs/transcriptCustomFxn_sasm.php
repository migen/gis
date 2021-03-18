<?php


// pr("transcriptCustomFxn_");


function groupEnrollmentLevels($ensumm){
	$rows=$ensumm;
	$i=0;
	$num_ps=0;
	$num_pri=0;
	$num_int=0;
	$num_jhs=0;
	$num_shs=0;
	foreach($ensumm AS $row){		
		if($row['lvl']>13){			
			$ensumm[$i]['group']='shs';
			$num_shs++;
		} else if($row['lvl']>9){			
			$ensumm[$i]['group']='jhs';
			$num_jhs++;
		} else if($row['lvl']>6){			
			$ensumm[$i]['group']='int';
			$num_int++;
		} else if($row['lvl']>3){			
			$ensumm[$i]['group']='pri';
			$num_pri++;
		} else {
			$ensumm[$i]['group']='ps';
			$num_ps++;			
		}	
		$i++;
	}
	
	$data['ensumm']=$ensumm;
	$data['num_ps']=$num_ps;
	$data['num_pri']=$num_pri;
	$data['num_int']=$num_int;
	$data['num_jhs']=$num_jhs;
	$data['num_shs']=$num_shs;
	
	return $data;
	
}	/* fxn */


function getStudentGrades_jhs($db,$sy,$scid){
	$grades=getStudentGrades($db,$sy,$scid);	
	return $grades;
}

