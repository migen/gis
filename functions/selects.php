<?php



function selects($model,$dbg=PDBG){
	$dbo=PDBO;
/* ------------------- grading ---------------------------------------------- */	
	$data['subjects'] = $model->fetchRows("{$dbo}.`05_subjects`",'id,name','name',' WHERE `is_active` = 1 ');
	$data['sections'] = $model->fetchRows("{$dbo}.`05_sections`");	
	$data['levels']   = $model->fetchRows("{$dbo}.`05_levels`");	
	$data['classrooms']   = $model->fetchRows("{$dbg}.05_classrooms");	

/* ------------------- contacts ----------------------------------------------	 */
	$data['departments'] = $model->fetchRows("".PDBO.".`05_departments`");	
	$data['titles']   	= $model->fetchRows("".PDBO.".`00_titles`");	
	$data['roles']  	= $model->fetchRows("".PDBO.".`00_roles`");	
	
/* ------------------- profile ----------------------------------------------	 */
	$data['cities']   		= $model->fetchRows("".PDBO.".cities");	
	$data['provinces']   	= $model->fetchRows("".PDBO.".provinces");	
	$data['religions']   	= $model->fetchRows("".PDBO.".religions");	
	$data['nationalities']  = $model->fetchRows("".PDBO.".nationalities");	
	$data['smsnetworks']    = $model->fetchRows(DBO.".smsnetworks");	
		
	return $data;
}	/* fxn */

