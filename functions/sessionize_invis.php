<?php





function sessionizeInvis($db,$dbg=PDBG){
	$dbo=PDBO;	
	
	if(isset($_SESSION['settings']['has_invis']) && ($_SESSION['settings']['has_invis']==1)){
		$_SESSION['inventory']  = true;
		$_SESSION['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name,label,department_id,subdepartment_id","id");
		$cr_fields="id,name,acid,level_id,section_id";
		$cr_order="level_id,section_id";
		$_SESSION['classrooms']	= fetchRows($db,"{$dbg}.05_classrooms",$cr_fields,$cr_order);			
		// $_SESSION['suppliers']=fetchRows($db,"{$dbo}.`00_contacts`","id,code,name","name","WHERE `role_id`='".RSUPP."' "); 	
		// $_SESSION['prodtypes']=fetchRows($db,"{$dbo}.`03_prodtypes`","*","name");	
		// $_SESSION['comm']=$_SESSION['suppliers'];
		// $_SESSION['products'] =array();		
	}	

	sessionizeSettingsGis($db);
	$ucid=$_SESSION['user']['ucid'];
	sessionizeUserByUcid($db,$ucid);


	
}	/* fxn */

