<?php

function resetmis($db){
	$home = 'mis';
	$dbo=PDBO;$dbg = PDBG;
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_mis.php");
	require_once(SITE."functions/sessionize_lis.php");
	require_once(SITE."functions/sessionize_invis.php");
	require_once(SITE."functions/sessionize_account.php");

	$ucid = $_SESSION['user']['ucid'];	
	/* 2 - settings */	
	// urooms($db,$ucid);
	sessionizeTablesMIS($db,$dbg);
	sessionizeAccount($db);
	sessionizeUserByUcid($db,$ucid);	
	sessionizeTime();
	sessionizeLis($db);
	/* 3 - etc */
	unset($_SESSION['crid']);
	unset($_SESSION['erid']);
	
	require_once(SITE.'views/customs/'.VCFOLDER.'/customs.php');	/* session customs */
	echo 'reset fxn mis here ';
	echo "<hr />";
	pr($_SESSION);
	exit;
	// redirect($home);	
	
}	/* fxn */

