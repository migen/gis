<?php



function sessionize_mis($db,$dbg=PDBG){
	$dbo=PDBO;
	require_once(SITE."functions/students.php");
	require_once(SITE."functions/sessionize.php");
	require_once(SITE."functions/sessionize_mis.php");
	require_once(SITE."functions/sessionize_lis.php");	
	require_once(SITE."functions/sessionize_invis.php");
	require_once(SITE."functions/sessionize_account.php");
	$ucid = $_SESSION['user']['ucid'];	

	/* 2  */	
	sessionizeTablesMIS($db,$dbg);
	if($_SESSION['settings']['has_axis']){ sessionizeAccount($db); }		
	if($_SESSION['settings']['has_axis']){ sessionizeLis($db); }	
		
	/* 3 - etc */
	unset($_SESSION['crid']);
	unset($_SESSION['erid']);

	
}	/* fxn */



function sessionize_librarians($db,$dbg=PDBG){
	require_once(SITE."functions/sessionize_lis.php");
	if($_SESSION['settings']['has_axis']){ sessionizeLis($db); }	
}	/* fxn */

function sessionize_stocks($db,$dbg=PDBG){
	require_once(SITE."functions/sessionize_invis.php");
	sessionizeInvis($db,$dbg=PDBG);	
	
}	/* fxn */

function sessionize_acad($db,$dbg=PDBG){}	/* fxn */
function sessionize_admin($db,$dbg=PDBG){}	/* fxn */
function sessionize_finance($db,$dbg=PDBG){ }	/* fxn */

function sessionize_students($db,$dbg=PDBG){
	require_once(SITE."functions/sessionize_student.php");	
	$row=sessionizeStudinfo($db);		
	$_SESSION['student']=$row;
	$_SESSION['message']=$_SESSION['settings']['flash_message_student'];
	
	
}	/* fxn */

function sessionize_teachers($db,$dbg=PDBG){
	require_once(SITE."functions/sessionize_teacher.php");sessionizeTeacher($db);	
}	/* fxn */


function sessionize_accounts($db,$dbg=PDBG){
	require_once(SITE."functions/sessionize_account.php");
	if($_SESSION['settings']['has_axis']){ sessionizeAccount($db); }		
}	/* fxn */


function sessionize_registrars($db,$dbg=PDBG){
	require_once(SITE."functions/sessionize_registrars.php");
	sessionizeRegistrars($db,$dbo=PDBO,$dbg=PDBG);

}	/* fxn */


