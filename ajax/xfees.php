<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		
require_once(SITE."functions/logs.php");

$dbo=PDBO;
$dbg = PDBG;

switch($_POST['task']){	

case "orno":
	$orno = $_POST['orno'];

	$q = " SELECT p.*,f.name AS feetype FROM {$dbg}.`30_payments` AS p 
		LEFT JOIN {$dbo}.`03_feetypes` AS f ON p.feetype_id = f.id
		WHERE p.`orno` = '$orno';  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;


case "xeditTsum":
	$post = $_POST;
	$today = $_SESSION['today'];
	$ecid = $_SESSION['pcid'];
	$scid = $post['scid'];

			
$q = "UPDATE {$dbg}.03_tsummaries SET 
		`balance` = '".$post['balance']."', 
		`paymode_id` = '".$post['mode']."', 
		`remarks` = '".$post['rmks']."'
		WHERE `scid` = '".$post['scid']."' LIMIT 1;";		
		
if($post['tpay']>0){
	$q.= "INSERT INTO {$dbg}.30_payments(`scid`,`ecid`,`feetype_id`,`date`,`amount`,`orno`,`pointer`,`details`) 
	VALUES ('".$post['scid']."','".$post['ecid']."','".$post['tfeeid']."','".$post['date']."','".$post['tpay']."',
	'".$post['orno']."','1','".$post['details']."'); ";	
	$more['feeid'] = $post['tfeeid'];
	$more['orno'] = $post['orno'];
	$more['amount'] = $post['tpay'];
	
}					
		
if(($post['amount']>0) && ($post['feetype']>0)){
	$q.= "INSERT INTO {$dbg}.`30_auxes`(`due`,`ecid`,`scid`,`feetype_id`,`amount`) VALUES 
		('$today','$ecid','".$post['scid']."','".$post['feetype']."','".$post['amount']."'); ";					
}					
	
	$_SESSION['q'] = $q;
	$_SESSION['message'] = "Ajax Updated Student Account.";
	$db->querysoc($q);
	
	/* 2 logs */
	$axn = $_SESSION['axn']['ledger_setup'];
	$details = "";
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $scid;
	logThis($db,$ucid,$axn,$details,$more);					
	
	break;



case "deleteTaux":	/* xobal */
	$sy = isset($_POST['sy'])? $_POST['sy']:DBYR;
	$auxid = $_POST['tauxid'];	
	
	$q = "SELECT * FROM {$dbg}.`30_auxes` WHERE `id` = '$auxid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$aux = $sth->fetch();
	
	$q = " DELETE FROM {$dbg}.`20_auxes` WHERE `id` = '$auxid' LIMIT 1;  ";
	$_SESSION['q'] = $sy." - ".$q;
	$_SESSION['message'] = "Aux Deleted.";
	$db->query($q);
	
	/* 2 logs */	
	$axn = $_SESSION['axn']['delete_auxfee'];
	$details = $aux['amount'].' on '.$aux['due'];
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $aux['scid'];
	$more['feeid'] = $aux['feetype_id'];
	logThis($db,$ucid,$axn,$details,$more);					
	
	break;


case "auxThis":
	$sy = $_POST['sy'];
	$dbg = VCPREFIX.$sy.US.DBG;
	$q = " SELECT * FROM {$dbo}.`03_feetypes` WHERE `id` = '".$_POST['id']."' LIMIT 1;  ";
	$_SESSION['q'] = $sy." - ".$q;
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	echo json_encode($row);
	
	break;



case "addAux":
	$sy = isset($_POST['sy'])? $_POST['sy']:DBYR;
	$dbg = VCPREFIX.$sy.US.DBG;
	$fid = $_POST['auxtype'];

	/* 1 - insert aux */
$q = " INSERT INTO {$dbg}.`20_auxes`(`scid`,`feetype_id`,`amount`,`due`,`num`) VALUES 
		('".$_POST['scid']."','$fid','".$_POST['auxamt']."','".$_POST['due']."','".$_POST['num']."');  ";						
	$db->query($q);
	
/* 2 - with combo devt fee */	
	$q = "SELECT a.*,b.amount AS comboamount  
			FROM {$dbo}.`03_feetypes` AS a 
				LEFT JOIN {$dbo}.`03_feetypes` AS b ON a.combo = b.id
			WHERE a.id = '$fid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$combo = $row['combo'];
	if($combo>0){
	$q = " INSERT INTO {$dbg}.`20_auxes`(`scid`,`feetype_id`,`amount`,`due`,`num`) VALUES 
			('".$_POST['scid']."','".$row['combo']."','".$row['comboamount']."','".$_SESSION['today']."','1');  ";						
			$db->query($q);
	}

	/* 2 logs */	
	$axn = $_SESSION['axn']['auxfee'];
	$details = $_POST['auxamt'].' on '.$_POST['due'];
	if($combo>0){ $details.=" | Combo feeid: ".$row['combo'].' for '.$row['comboamount']; }
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $_POST['scid'];
	$more['feeid'] = $fid;
	$more['amount'] = $_POST['auxamt'];
	logThis($db,$ucid,$axn,$details,$more);							
	break;	
	
case "scidPaymode":	
	$sy=isset($_POST['sy'])? $_POST['sy']:DBYR;
	$dbg=VCPREFIX.$sy.US.DBG;
	$q = " UPDATE {$dbg}.`03_tsummaries` SET `paymode_id` = '".$_POST['pmid']."' 
		WHERE `scid` = '".$_POST['scid']."' LIMIT 1;  ";
	$_SESSION['q'] = $q;
	$db->query($q);

	/* 2 logs */
	$axn = $_SESSION['axn']['edit_paymode'];
	$details = "";
	$ucid = $_SESSION['user']['ucid'];
	$more['qtr'] = $_SESSION['qtr'];
	$more['scid'] = $scid;
	logThis($db,$ucid,$axn,$details,$more);			
	break;


case "xgetFeesByPart":
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT * FROM {$dbo}.`03_feetypes` WHERE `name` LIKE '%".$part."%' ORDER BY `name` LIMIT $limits;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;
	
case "xgetBanksByPart":
	$dbo=PDBO;
	$part = $_POST['part'];
	$limits = $_POST['limits'];
	$q = " SELECT * FROM {$dbo}.`03_banks` WHERE `name` LIKE '%".$part."%' ORDER BY `name` LIMIT $limits;  ";
	$_SESSION['q'] = $q;
	$sth = $db->querysoc($q);
	$rows = $sth->fetchAll();
	echo json_encode($rows);
	break;

	
default:
	break;

	
		
	

}	/* switch */




	

	
