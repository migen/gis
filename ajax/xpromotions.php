<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		

$dbg=PDBG;	

switch($_POST['task']){
	
case "xpromk12":
	$post = $_POST;		
	$sy = $post['sy'];
	$dbg = VCPREFIX.$sy.US.DBG;
	$scid = $post['scid'];
	$incunits = $post['incunits'];
	$incsubj = $post['incsubj'];
	$promcrid = $post['promcrid'];
	$promlvl = $post['promlvl'];
	$eligdate = $post['eligdate'];
	$is_promoted = $post['is_promoted'];

	$q="";
	$q.="UPDATE {$dbg}.05_summaries SET 
		`incunits`='$incunits',`incsubj`='$incsubj',`promcrid`='$promcrid',
		`promlvl`='$promlvl',`eligdate`='$eligdate',`is_promoted`='$is_promoted'
		WHERE `scid`='$scid'; ";	
	$db->query($q);
	$_SESSION['q'] = $q;
	break;
	
	

case "xpromk12_ok":
	$post = $_POST;		
	$sy = $post['sy'];
	$dbg = VCPREFIX.$sy.US.DBG;
	$scid = $post['scid'];
	$incunits = $post['incunits'];
	$incsubj = $post['incsubj'];
	$promcrid = $post['promcrid'];
	$promlvl = $post['promlvl'];
	$is_promoted = $post['is_promoted'];

	$q="";
	$q.="UPDATE {$dbg}.05_summaries SET 
		`incunits`='$incunits',`incsubj`='$incsubj',`promcrid`='$promcrid',
		`promlvl`='$promlvl',`is_promoted`='$is_promoted'
		WHERE `scid`='$scid'; ";	
	$db->query($q);
	$_SESSION['q'] = $q;
	break;


	
	
default:
	break;

	
	

}	/* switch */




	

	
