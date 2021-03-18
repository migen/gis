<?php


/* v539-20200219 @dbone.logs-latest for audit-trails */
function textlog($db,$module_id,$details,$sy=DBYR){
	$dbo=PDBO;
	$ip=$_SERVER['REMOTE_ADDR'];$ucid=$_SESSION['ucid'];$ts=date("Y-m-d H:i:s");
	$q="INSERT INTO {$dbo}.logs(`sy`,`ip`,`datetime`,`ucid`,`module_id`,`details`)VALUES(?,?,?,?,?,?);";
	$sth=$db->prepare($q);
	$sth->execute([$sy,$ip,$ts,$ucid,$module_id,$details]); 

	$pkid=$db->lastInsertId();$q="SELECT * FROM {$dbo}.logs WHERE id=$pkid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();
/*  $pkid=$db->lastInsertId();$q="SELECT * FROM {$dbo}.logs WHERE id=$pkid LIMIT 1;";
	$sth=$db->querysoc($q);$row=$sth->fetch();prx($row); */

}	/* fxn */




function newlog($db,$details,$more=NULL){
	$dbo=PDBO;
	$axn=isset($more['axn'])? $more['axn']:1;	
	$ip=$_SERVER['REMOTE_ADDR'];$ucid=$_SESSION['ucid'];$ts=date("Y-m-d H:i:s");
	$q="INSERT INTO {$dbo}.50_logbooks(ip,datetime,ucid,details,logtype_id)VALUES('$ip','$ts','$ucid','$details','$axn');";
	$sth=$db->query($q);

}	/* fxn */




/* yearbook */
function logThis($db,$ucid,$axn,$details=NULL,$more=NULL){
	$ts = date('Y-m-d H:i:s');
	$dbo=PDBO;$dbg=PDBG;
	$ip = $_SERVER['REMOTE_ADDR'];
	$qtr = isset($more['qtr'])? $more['qtr']:'';
	$ecid = isset($more['ecid'])? $more['ecid']:'';
	$scid = isset($more['scid'])? $more['scid']:'';
	$crsid = isset($more['crsid'])? $more['crsid']:'';
	$crid = isset($more['crid'])? $more['crid']:'';
	$lvlid = isset($more['lvlid'])? $more['lvlid']:'';
	$feeid = isset($more['feeid'])? $more['feeid']:'';
	$orno = isset($more['orno'])? $more['orno']:'';
	$amount = isset($more['amount'])? $more['amount']:'';	
	$q = "INSERT INTO {$dbg}.50_logs
	(`ip`,`datetime`,`ucid`,`action_id`,`details`,`ecid`,`scid`,`crsid`,`crid`,`lvlid`,`qtr`,`feeid`,`orno`,`amount`) 
		VALUES('$ip','$ts','$ucid','$axn','$details','$ecid','$scid','$crsid','$crid','$lvlid','$qtr','$feeid','$orno','$amount');";
	$_SESSION['q']=$q;
	$db->query($q);

}	/* fxn */

function ezlog($db,$details,$sy=DBYR,$more=NULL){
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbo=PDBO;
	$axn=isset($more['axn'])? $more['axn']:99;	
	$ip=$_SERVER['REMOTE_ADDR'];$ucid=$_SESSION['ucid'];$ts=date("Y-m-d H:i:s");
	$q="INSERT INTO {$dbo}.50_logs(`ip`,`datetime`,`logger_id`,`loggee_id`,`details`,`action_id`)VALUES(?,?,?,?,?,	?);";
	$sth=$db->prepare($q);
	$sth->execute([$ip,$ts,$ucid,$details,$axn]); 
	// pr($q);
	// pr($sth->errorInfo()); 
	$message=($sth)? "Success":"Fail";		
	/* pr($sth->errorInfo()); */
	$message=($sth)? "Success":"Fail";	
	$_SESSION['message']=&$message;

}	/* fxn */



function logQuery($ucid,$axn,$details=NULL,$more=NULL){
	$dbo=PDBO;$dbg=PDBG;
	$ts = date('Y-m-d H:i:s');
	$ip = $_SERVER['REMOTE_ADDR'];
	$qtr = isset($more['qtr'])? $more['qtr']:'';
	$ecid = isset($more['ecid'])? $more['ecid']:'';
	$scid = isset($more['scid'])? $more['scid']:'';
	$crsid = isset($more['crsid'])? $more['crsid']:'';
	$crid = isset($more['crid'])? $more['crid']:'';
	$lvlid = isset($more['lvlid'])? $more['lvlid']:'';
	$feeid = isset($more['feeid'])? $more['feeid']:'';
	$orno = isset($more['orno'])? $more['orno']:'';
	$amount = isset($more['amount'])? $more['amount']:'';	
	$q = "INSERT INTO {$dbg}.50_logs (`ip`,`datetime`,`ucid`,`action_id`,`details`,`ecid`,`scid`,`crsid`,`crid`,`lvlid`,`qtr`,`feeid`,`orno`,`amount`) 
		VALUES('$ip','$ts','$ucid','$axn','$details','$ecid','$scid','$crsid','$crid','$lvlid','$qtr','$feeid','$orno','$amount');";
	return $q;
		
}	/* fxn */


