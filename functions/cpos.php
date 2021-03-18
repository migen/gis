<?php

function evalCredit($posts){
	echo "cpos fxn here <br />";
	pr($posts);
	exit;

}	/* fxn */


function viewCpos($db,$ccid,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT pr.name AS product,pr.combo,p.*,p.id AS cposid
	FROM {$dbo}.`30_poscredits` AS p
	LEFT JOIN {$dbo}.`03_products` AS pr ON p.product_id=pr.id
	WHERE p.ccid='$ccid'
	ORDER BY p.id DESC;";
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


function addCpos($db,$ccid,$posts){
$dbg=PDBG;$dbo=PDBO;
$q="INSERT INTO {$dbo}.`30_poscredits`(`ccid`,`product_id`,`cost`,`price`,`qty`,`amount`,`datecr`) VALUES ";
foreach($posts AS $post){
$q.="('$ccid','".$post['product_id']."','".$post['cost']."','".$post['price']."','".$post['qty']."','".$post['amount']."','".$post['datecr']."'),"; 
}
$q=rtrim($q,",");$q.=";";
$db->query($q);

/* 2 */
$tml = $_SESSION['terminal'];
$q="";
foreach($posts AS $row){			
	$qty = $row['qty'];
	$q .= "UPDATE {$dbo}.`03_products` SET 
		`level` = `level`-".$qty.",`level_currcost` = `level_currcost`-".$qty.",`t{$tml}` = `t{$tml}` -".$qty."
		WHERE `id`='".$row['product_id']."' LIMIT 1;";		
	/* 2 - combo */
	$combos = trim($row['combo']);
	$combor = array_filter(explode(',',$combos));
	foreach($combor AS $cid){
		$q .= "UPDATE {$dbo}.`03_products` SET level = level-".$qty.",`t{$tml}` = `t{$tml}` -".$qty." 
			WHERE `id`='".$cid."' LIMIT 1;";
	}
			
} 	/* positems */
$db->query($q);

}	/* fxn */


function saveCpos($db,$posts,$dbg=PDBG){	// like that of oposfxn-add except for datecr
	$dbo=PDBO;
	$pos = $posts['pos'];
	$positems = $posts['positems'];
	$orno = $pos['orno'];
	
	if($pos['ccid']!=0){ unset($pos['guest']); } 
	$pos['total'] = str_replace(",","",$pos['total']);
	$pos['tendercs'] = str_replace(",","",$pos['tendercs']);
	$pos['tenderetc'] = str_replace(",","",$pos['tenderetc']);
	$pos['is_paid'] = ($pos['is_credit']==1)? 0:1;
	$pos['year']=DBYR;
	$db->add("{$dbo}.`30_pos`",$pos);
	$pos_id = $db->lastInsertId();
	$q = "INSERT INTO {$dbo}.`30_positems`(`pos_id`,`product_id`,`price`,`qty`,`amount`,`cost`) VALUES ";
	foreach($positems AS $row){			
		$q .= " ('$pos_id','".$row['product_id']."','".$row['price']."','".$row['qty']."','".$row['amount']."',
		'".$row['cost']."'),";	
	}	
	$q = rtrim($q,",");
	$q .= ";";
	
	/* 3 - orno */
	$q .= "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '".$pos['ecid']."' LIMIT 1;";					
	$_SESSION['orno'] = $orno; 
	$db->query($q);
	
	/* 4 process level_currcost and pocost */
	$pridr = buildArray($posts['positems'],'product_id');
	$q="";
	foreach($pridr AS $prid){ $q.=qryLevelcurrcostVsPocost($db,$prid); }
	debug($q,'cposFxn: saveCpos');
	$db->query($q);	
	
	/* 5 sessionize */
	$_SESSION['last_orno'] = $pos['orno'];
	$_SESSION['last_posid'] = $pos_id;
		
	return $pos_id;

}	/* fxn */



function posincs($db,$dbg=PDBG){
	$dbo=PDBO;
	$trml = myTerminal($db);
	echo (!isset($trml))? "<h3 class='brown' >Terminal for Employee Not Set, Ask MIS Help.</h3>":NULL;
	$trml = isset($trml)? $trml:'1';
	$data['terminal'] = $trml;	

	$data['orno'] = (lastOrno($db,$_SESSION['pcid'],$dbg)+1);
	$data['limits'] = $_SESSION['settings']['limits'];

	if(!isset($_SESSION['banks'])){ 
		$_SESSION['banks'] = fetchRows($db,"{$dbo}.`03_banks`","id,code,name","name"); 	 } 
	$data['banks'] = $_SESSION['banks'];	
	
	if(!isset($_SESSION['paytypes'])){ 
		$_SESSION['paytypes'] = fetchRows($db,"{$dbo}.`03_paytypes`","*","name"); 	 } 
	$data['paytypes'] = $_SESSION['paytypes'];	
	$data['npos'] = true;
	
	$data1 = posLastOrno($db,$dbg);
	$data = array_merge($data,$data1);
	return $data;

}	/* fxn */


function deleteCposids($db,$idr){	// cpos checkout
	$dbo=PDBO;
	$dbg=PDBG;$q="";
	foreach($idr AS $id){ $q.="DELETE FROM {$dbo}.`30_poscredits` WHERE `id`='$id' LIMIT 1;"; }
	$db->query($q);

}	/* fxn */


function getContactDetails($db,$ccid){
	$dbo=PDBO;
	$q=" SELECT id,code,name FROM {$dbo}.`00_contacts` WHERE `id`='$ccid' LIMIT 1; ";
	$sth=$db->querysoc($q);
	return $sth->fetch();
}	/* fxn */
