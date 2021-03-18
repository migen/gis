<?php


function deptsPush($dept,$depts){
	if($dept['is_ps']) { array_push($depts,'1'); }
	if($dept['is_gs']) { array_push($depts,'2'); }
	if($dept['is_hs']) { array_push($depts,'3'); }
	return $depts;
	
}	/* fxn */

