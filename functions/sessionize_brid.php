<?php

function sessionize_brid($db){
	$dbo=PDBO;
	if(!isset($_SESSION['branches'])){  $_SESSION['branches']=fetchRows($db,"{$dbo}.`00_branches`","*","id"); }
	if(!isset($_SESSION['brid'])){ $ucid=$_SESSION['ucid'];
		$row=fetchRow($db,"{$dbo}.`00_contacts`",$ucid,"id,branch_id");$_SESSION['brid']=$row['branch_id'];
	}
	// pr($row);
	
}	/* fxn */
