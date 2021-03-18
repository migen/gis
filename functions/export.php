<?php



function export($data,$prefix='webdata'){
	$filename = $prefix."_".date('YMd_His').".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"",false);
	header("Content-Type: application/vnd.ms-excel",false);

	$flag = false;
	foreach($data as $row){
		echo implode("\t",array_values($row)) . "\r\n";			
	}
	
	    
} /* fxn */
