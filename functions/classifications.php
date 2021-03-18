<?php


function classifyDepartment($department_id){
	$dbo=PDBO;
/* 6 values=>ps,gs,hs,pg,pgh,gh */
	switch($department_id){
		case 1: $q = " 1,0,0 "; break;
		case 2: $q = " 0,1,0 "; break;
		case 3: $q = " 0,0,1 "; break;
		case 4: $q = " 1,1,0 "; break;
		case 6: $q = " 0,1,1 "; break;
		case 7: $q = " 1,0,1 "; break;
		default:$q = " 1,1,1 "; break;	
	}
	return $q;
}	/* fxn */


function classifyDepartmentForEdit($department_id,$prefix=''){
	$dbo=PDBO;
/* 6 values=>ps,gs,hs,pg,pgh,gh */
	switch($department_id){
		case 1: $q = " {$prefix}`is_ps` = '1',{$prefix}`is_gs` = '0',{$prefix}`is_hs` = '0' "; break;
		case 2: $q = " {$prefix}`is_gs` = '1',{$prefix}`is_ps` = '0',{$prefix}`is_hs` = '0' "; break;
		case 3: $q = " {$prefix}`is_hs` = '1',{$prefix}`is_ps` = '0',{$prefix}`is_gs` = '0' "; break;
		case 4: $q = " {$prefix}`is_ps` = '1',{$prefix}`is_gs` = '1',{$prefix}`is_hs` = '0' "; break;
		case 6: $q = " {$prefix}`is_gs` = '1',{$prefix}`is_hs` = '1',{$prefix}`is_ps` = '0' "; break;
		case 7: $q = " {$prefix}`is_gs` = '0',{$prefix}`is_hs` = '1',{$prefix}`is_ps` = '1' "; break;
		default: $q = " {$prefix}`is_ps` = '1',{$prefix}`is_gs` = '1',{$prefix}`is_hs` = '1' "; break;		
	}
	return $q;
}	/* fxn */


function classifyCourse($course){
	$dbo=PDBO;
	return array(
		'type_id'	=> $course['crstype_id'],
		'dept_id'	=> $course['department_id']
	);
}


function classifyClass($classroom){
	$dbo=PDBO;
	if($classroom['is_ps']) 					$dept_id = 1;
		elseif($classroom['is_hs']) 			$dept_id = 3;
		else		$dept_id = 2;				/* gs - default */				
	return array(
		'dept_id'	=> $dept_id
	);
}


function classifyCourseType($crstype_id){
	$dbo=PDBO;
/* 6 values=>acad,trait,club,psmapeh,conduct,cocurr */
	switch($crstype_id){
		case 2: $q = " 0,1,0,0,0,0 "; break;
		case 3: $q = " 0,0,1,0,0,0 "; break;
		case 4: $q = " 0,0,0,1,0,0 "; break;
		case 5: $q = " 0,0,0,0,1,0 "; break;
		case 6: $q = " 0,0,0,0,0,1 "; break;
		default:$q = " 1,0,0,0,0,0 "; break;	
	}
	return $q;
}	/* fxn */


function getDepartmentArray($dept){
	$dbo=PDBO;
	switch($dept){
		case 1: $dr = array('dept'=>$dept,'dept_code'=>'PS','department'=>'PreSchool');break;
		case 3: $dr = array('dept'=>$dept,'dept_code'=>'HS','department'=>'High School');break;
		default: $dr = array('dept'=>$dept,'dept_code'=>'GS','department'=>'Grade School');break;
	}
	return $dr;	

}	/* fxn */

