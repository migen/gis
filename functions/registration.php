<?php

function getLastStudentRegistered($db){
	$dbo=PDBO;
	$q="SELECT id,code,name,account FROM {$dbo}.00_contacts WHERE role_id=1 ORDER BY code DESC LIMIT 1; ";
	// pr($q);
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row;
	
}	/* fxn */

function setCode($num,$sy=NULL,$prefix=NULL,$delim='-',$numchar=4){
$dbo=PDBO;
$sy= isset($sy)? $sy : date('Y');
$code = '';

// if(is_null($prefix)){ $prefix = substr($sy,2,2); }
$prefix = substr($sy,2,2); 
$char = '';
for($i=0;$i<$numchar;$i++) $char.= '0';
$numlen 	= strlen($num);
$suffix = '';
if($numchar>$numlen){ 
	$numzero = $numchar - $numlen; 
	for($i=0;$i<$numzero;$i++) $suffix .= '0';
	$suffix .= $num;
} else {
	$suffix = $num;
} 

$code .= $prefix.$delim.$suffix;


return $code;

}	/* fxn */


function qryPurgeStudent($db,$dbg,$vars,$row,$sy){
	$dbo=PDBO;
	$q="";
	$pcid=$vars['pcid'];	
	$q.="DELETE FROM {$dbg}.05_summaries WHERE scid='$pcid' LIMIT 1; ";
	return $q;
}	/* fxn */


function qryRegister($db,$dbg,$vars,$row,$sy){
$dbo=PDBO;
$pcid=$vars['pcid'];
$today=$vars['today'];
$title_id=$vars['title_id'];
$role_id=$vars['role_id'];
$privilege_id=$vars['privilege_id'];
// $sy_registered=$_SESSION['settings']['sy_enrollment'];

$q="";
if(strlen($row['fullname'])>2){
	$fullname=trim($row['fullname']);		
	$name_array=explode(' ',$fullname);
	$code=$row['code'];
	$is_male=$row['is_male'];
	$crid=$row['crid'];
	
	$dbg = VCPREFIX.$sy.US.DBG;
	$code = preg_replace("([^0-9a-zA-Z-/])", "", $code);	
	$exists = validateCode($db,$code,$dbg);
		
	if(!$exists){			
		$q.=" INSERT IGNORE INTO {$dbo}.`00_contacts` (`id`,`parent_id`,`name`,`code`,
			`account`,`title_id`,`role_id`,`privilege_id`,`sy`,`is_male`) 
			VALUES ($pcid,$pcid,'".$row['fullname']."','$code','$code',1,1,1,$sy,$is_male); ";
		$q.=" INSERT IGNORE INTO {$dbo}.`00_profiles` (`contact_id`) VALUES ($pcid); ";
		$q.=" INSERT IGNORE INTO {$dbg}.`05_summaries` (`scid`,`crid`) VALUES ($pcid,$crid); ";
		$_SESSION['last_registered']['sy']=$sy;
		$_SESSION['last_registered']['scid']=$pcid;
		$_SESSION['last_registered']['student']=$fullname;		
		
	} /* exists */
	else { $url=$_SESSION['url'];flashRedirect($url,"Code exists - $code"); }
}	/* strlen over 2 meaning not empty */
return $q;

}	/* fxn */



