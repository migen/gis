<?php


	 
function sessionizeTablesMIS($db,$dbg=PDBG){
	$dbo=PDBO;$brid=$_SESSION['brid'];
	require_once(SITE."functions/sessionize_classroom.php");sessionizeLevelClassrooms($db); 
	require_once(SITE."functions/contactsFxn.php");$_SESSION['teachers']=getContacts($db,RTEAC); 
		
	$_SESSION['levels'] = fetchRows($db,"{$dbo}.`05_levels`","id,code,name,department_id AS deptid","id");
	$_SESSION['months'] = fetchRows($db,"{$dbo}.`00_months`","*","`index`");
	$_SESSION['crstypes'] = fetchRows($db,"{$dbo}.`05_crstypes`","id,code,name","name");
	$_SESSION['subjects'] = fetchRows($db,"{$dbo}.`05_subjects`","id,name,id AS subid","name");
	$_SESSION['subdepts'] = fetchRows($db,"{$dbo}.`05_subdepts`");
	$_SESSION['departments'] = fetchRows($db,"{$dbo}.`05_departments`");
	$_SESSION['titles'] = fetchRows($db,"{$dbo}.`00_titles`","id,name","name");
	$_SESSION['roles'] = fetchRows($db,"{$dbo}.`00_roles`","id,code,name","name");
	$_SESSION['actions'] = fetchRows($db,"{$dbo}.`00_actions`","*","module_id,name");
	$_SESSION['products'] = array();	
	unset($_SESSION['cirlist']);
	if($_SESSION['settings']['has_axis']){ sessionizeInvis($db); }
	
}	/* fxn */

