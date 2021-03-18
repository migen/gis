<?php

function getRefno($db){
	$dbo=PDBO;
	$dbg=PDBG;
	$idno=maxId($db,"{$dbg}.`30_shrinkages`");
	$moid=$_SESSION['moid'];
	$idno=str_pad(($idno+1),4, "0",STR_PAD_LEFT);
	$yr=date('Y');
	$refno=$yr.$moid.$idno;
	return $refno;
}	/* fxn */


function getShrinkage($db,$skid,$dbg){
$dbo=PDBO;
$q="SELECT sk.id AS skid,sk.*,p.level,p.cost,p.price,p.level,p.t1,p.t2,p.t3,p.t4,p.t5,p.t6,
		p.name AS product,sk.remarks AS skremarks 
	FROM {$dbg}.`30_shrinkages` AS sk
	LEFT JOIN {$dbo}.`03_products` AS p ON sk.prid=p.id
	WHERE sk.id='$skid' LIMIT 1; ";
$sth=$db->querysoc($q);
return $sth->fetch();

}	/* fxn */


function updateShrinkage($db,$skid,$post,$orig){
	$dbo=PDBO;
	$dbg=PDBG;$tp=$post['terminal'];$to=$orig['terminal'];	
	$q="";
	$q.="UPDATE {$dbg}.`30_shrinkages` SET 
		`terminal`='$tp',`qty`='".$post['qty']."',`reference`='".$post['reference']."',
		`prid`='".$post['prid']."',`cost`='".$post['cost']."',`price`='".$post['price']."',
		`sktype_id`='".$post['sktype_id']."'
		WHERE id='$skid' LIMIT 1;";
		
	$q.="UPDATE {$dbo}.`03_products` SET `t{$to}`=(`t{$to}`+'".$orig['qty']."'),
		`level`=(`level`+'".$orig['qty']."') WHERE id='".$orig['prid']."' LIMIT 1;";	
		
	$q.="UPDATE {$dbo}.`03_products` SET `t{$tp}`=(`t{$tp}`-'".$post['qty']."'),
		`level`=(`level`-'".$post['qty']."') WHERE id='".$post['prid']."' LIMIT 1;";			
	$db->query($q);	

}	/* fxn */


