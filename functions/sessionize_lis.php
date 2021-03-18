<?php


	 
function sessionizeLis($db,$dbg=PDBG){
	$dbo=PDBO;$brid=$_SESSION['brid'];	
	$fields="id,code,name,acid,label,level_id,section_id,branch_id";$where="WHERE branch_id=$brid";
	$_SESSION['classrooms']=fetchRows($db,"{$dbg}.05_classrooms",$fields,$order="level_id,name",$where);
		
	$q="SELECT subdepartment_id AS id,code,name FROM {$dbo}.88_ip_subdepts GROUP BY subdepartment_id; ";
	$sth=$db->querysoc($q);
	$_SESSION['subdepts']=$sth->fetchAll();

	require_once(SITE."functions/ip.php");	
	$row = getSubdept($db);	
	$_SESSION['subdepartment_id'] = $row['subdepartment_id'];	
	$_SESSION['subdept'] = $row['code'];	

	
}	/* fxn */


