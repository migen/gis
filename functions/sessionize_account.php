<?php


function sessionizeAccount($db){
	require_once(SITE.'functions/fees.php');
	require_once(SITE.'functions/feesFxn.php');
	$dbg=PDBG;$dbo=PDBO;
	$_SESSION['axis'] = true;	
	$_SESSION['paymodes'] = fetchRows($db,"{$dbo}.`03_paymodes`","*","id");
	$_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*","id");
	$_SESSION['feetypes']=fetchRows($db,"{$dbo}.`03_feetypes`","id,parent_id,is_discount,code,name","name");			
	$_SESSION['tuitions'] = fetchRows($db,"{$dbo}.`03_tuitions`","*","level_id");
	// $_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","*","name"); 		
	$lvl_fields="id,code,name";
	$_SESSION['levels']		= fetchRows($db,"{$dbo}.`05_levels`",$lvl_fields,"id");
	$cr_fields="id,name,acid,level_id,section_id";
	$cr_order="level_id,section_id";
	$_SESSION['classrooms']	= fetchRows($db,"{$dbg}.05_classrooms",$cr_fields,$cr_order);	

	$_SESSION['obid'] = feecode_id($db,'obal'); 
	$_SESSION['tfeeid'] = feecode_id($db,'tfee'); 
	$_SESSION['surgid'] = feecode_id($db,'surg'); 
	$_SESSION['ovrid'] = feecode_id($db,'ovr'); 
	$_SESSION['products'] = array();
	
	sessionizeSettingsGis($db);
	$ucid = $_SESSION['user']['ucid'];
	sessionizeUserByUcid($db,$ucid);
	
}	/* fxn */

