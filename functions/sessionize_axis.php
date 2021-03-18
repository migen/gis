<?php



function sessionize_axis($db,$dbg=PDBG){
	$dbo=PDBO;		
	if($_SESSION['srid']!=RSTUD){
		$_SESSION['levels']=fetchRows($db,"{$dbo}.`05_levels`","id,code,name,label,department_id,subdepartment_id","id");
		$_SESSION['paytypes']=fetchRows($db,"{$dbo}.`03_paytypes`","*","id");
		$_SESSION['paymodes']=fetchRows($db,"{$dbo}.`03_paymodes`","*","id");
		$_SESSION['feetypes']=fetchRows($db,"{$dbo}.`03_feetypes`","id,parent_id,is_discount,code,name","name");		
	}	
	
	
}	/* fxn */

