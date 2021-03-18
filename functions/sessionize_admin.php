<?php



function sessionizeAdmin($db,$dbg=PDBG){
	require_once(SITE.'functions/feesFxn.php');
	$dbo=PDBO;
	$has_axis=$_SESSION['settings']['has_axis'];
	$_SESSION['levels']		= fetchRows($db,"{$dbo}.`05_levels`","*","id");
	$cr_fields="id,name,acid,level_id,section_id";
	$cr_order="level_id,section_id";
	$_SESSION['classrooms']	= fetchRows($db,"{$dbg}.05_classrooms",$cr_fields,$cr_order);		

	if($has_axis){	
		$_SESSION['inventory']=true;
		$_SESSION['axis']=true;		
		$_SESSION['suppliers'] = fetchRows($db,"{$dbo}.`00_contacts`","id,code,name","name","WHERE `role_id`='".RSUPP."' "); 	
		$_SESSION['prodtypes'] = fetchRows($db,"{$dbo}.`03_prodtypes`","*","name");	
		$_SESSION['prodsubtypes'] = fetchRows($db,"{$dbo}.`03_prodsubtypes`","*","name");	
		$_SESSION['prodtags'] = fetchRows($db,"{$dbo}.`03_prodtags`","*");	
		$_SESSION['comm']   = $_SESSION['suppliers'];
		$_SESSION['products']   = array();	
		$_SESSION['paymodes'] = fetchRows($db,"{$dbo}.`03_paymodes`","*","id");
		$_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*","id");
		$_SESSION['feetypes']=fetchRows($db,"{$dbo}.`03_feetypes`","id,parent_id,is_discount,code,name","name");				
		$_SESSION['tuitions'] = fetchRows($db,"{$dbo}.`03_tuitions`","*","level_id","WHERE sy=".DBYR);
		// $_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","*","name"); 		
		$_SESSION['obid'] = feecode_id($db,'obal'); 
		$_SESSION['tfeeid'] = feecode_id($db,'tfee'); 
		$_SESSION['surgid'] = feecode_id($db,'surg'); 
		$_SESSION['ovrid'] = feecode_id($db,'ovr'); 	
	}	/* has_axis */

	
	sessionizeSettingsGis($db);
	$ucid=$_SESSION['user']['ucid'];
	sessionizeUserByUcid($db,$ucid);
	
}	/* fxn */

