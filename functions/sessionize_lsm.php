<?php



function sessionizeLSM($db,$dbg=PDBG){	
	$dbo=PDBO;
	/* 1 */
	$q="SELECT id,code,name FROM {$dbo}.`05_levels` ORDER BY id; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$_SESSION['lsm']['levels']=$rows;
	
	/* 2 */
	$q="SELECT id,code,name FROM {$dbo}.`05_sections` ORDER BY code; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$_SESSION['lsm']['sections']=$rows;	
	
	/* 3 */
	$q="SELECT id,code,name FROM {$dbg}.05_nums ORDER BY code; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$_SESSION['lsm']['nums']=$rows;		
	
	
	
}	/* fxn */
