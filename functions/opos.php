<?php


function add($db,$posts,$dbg=PDBG){
	$dbo=PDBO;
	$pos = $posts['pos'];
	$positems = $posts['positems'];
	$orno = $pos['orno'];
		
	if($pos['ccid']!=0){ unset($pos['guest']); } 
	
	$pos['total'] = str_replace(",","",$pos['total']);
	$pos['tendercs'] = str_replace(",","",$pos['tendercs']);
	$pos['tenderetc'] = str_replace(",","",$pos['tenderetc']);
		
	$pos['is_paid'] = ($pos['is_credit']==1)? 0:1;		
	$db->add("{$dbo}.`30_pos`",$pos);
	$pos_id = $db->lastInsertId();	

	$q = "INSERT INTO {$dbo}.`30_positems`(`pos_id`,`product_id`,`price`,`qty`,`amount`,`cost`) VALUES ";
	foreach($positems AS $row){			
		$q .= " ('$pos_id','".$row['product_id']."','".$row['price']."','".$row['qty']."','".$row['amount']."','".$row['cost']."'),";	
	}	
	$q = rtrim($q,",");
	$q .= ";";
	
	$tml = $pos['terminal'];
	foreach($positems AS $row){			
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

	
	/* 3 - orno */
	$q .= "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '".$pos['ecid']."' LIMIT 1;";					
	$_SESSION['orno'] = $orno; 								
	$_SESSION['q'] = $q; 								
	$db->query($q);
	
	/* 4 process level_currcost and pocost */
	$pridr = buildArray($posts['positems'],'product_id');
	$q="";
	foreach($pridr AS $prid){ $q.=qryLevelcurrcostVsPocost($db,$prid); }
	$db->query($q);	

	/* 5 sessionize */
	$_SESSION['last_orno'] = $pos['orno'];
	$_SESSION['last_posid'] = $pos_id;
		
	return $pos_id;

}	/* fxn */



function myTerminal($db){
	$terminal = (isset($_SESSION['terminal']))? $_SESSION['terminal']:getMyTerminal($db);
	return $terminal;	
}	/* fxn */


function getMyTerminal($db,$dbg=PDBG){
	$dbo=PDBO;
	$ecid = $_SESSION['ucid'];
	$q = "SELECT * FROM {$dbo}.`03_terminals_employees` WHERE `ecid` = '$ecid' LIMIT 1; ";
	$sth = $db->querysoc($q);
	$row = $sth->fetch();
	$terminal = $row['terminal'];
	$_SESSION['terminal'] = $terminal;
	return $terminal;
}	/* fxn */


function viewPos($pos_id,$db,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT p.*,
		IF(p.ccid=0,p.guest,c.name) AS customer,c.code AS customer_code,cr.name AS classroom,
		e.name AS employee,e.code AS employee_code,b.name AS bank
	FROM {$dbo}.`30_pos` AS p
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid = c.id
		LEFT JOIN {$dbo}.`00_contacts` AS e ON p.ecid = e.id
		LEFT JOIN {$dbo}.`03_banks` AS b ON p.bank_id = b.id
		LEFT JOIN {$dbg}.`05_summaries` AS summ ON summ.scid = c.id
		LEFT JOIN {$dbg}.05_classrooms AS cr ON summ.crid = cr.id
	WHERE p.`id` = '$pos_id' LIMIT 1;
";
$sth = $db->querysoc($q);
$data['pos'] = $sth->fetch();


$q = "
	SELECT 
		pd.id AS pdid,pd.*,p.name AS product,p.combo,p.barcode,p.code
	FROM {$dbo}.`30_positems` AS pd
		LEFT JOIN {$dbo}.`03_products` AS p ON pd.product_id = p.id
	WHERE pd.`pos_id` = '$pos_id' ORDER BY p.name LIMIT 100;
";
$sth = $db->querysoc($q);
$data['positems'] = $sth->fetchAll();

return $data;


}	/* fxn */


function selectsPos($db,$dbg=PDBG){	
	$dbo=PDBO;
	$data['products'] = array();	
	if(!isset($_SESSION['prodtypes'])){ 
		$_SESSION['prodtypes'] =  fetchRows($db,"{$dbo}.`03_prodtypes`",'id,name','name');	 } 
	$data['prodtypes'] = $_SESSION['prodtypes'];	
	
	if(!isset($_SESSION['prodsubtypes'])){ 
		$_SESSION['prodsubtypes'] =  fetchRows($db,"{$dbo}.`03_prodsubtypes`",'id,name','name');	 } 
	$data['prodsubtypes'] = $_SESSION['prodsubtypes'];		
	return $data;
	
}	/* fxn */



function sp($data){		/* selectProdcategories */
	$rows = $data['selects']['prodsubtypes'];
	foreach($rows as $row){
		echo "<option value=\"".$row['id']."\">".$row['name']." #".$row['id']."</option>";
	}	
}

function lastPosid($db,$dbg=PDBG){
	$dbo=PDBO;
	$q="SELECT max(id) AS posid FROM {$dbo}.`30_pos`;";
	$sth=$db->querysoc($q);
	$row=$sth->fetch();
	return $row['posid'];
}	/* fxn */


function getOrigPosdetails($db,$rxref_posid,$dbg=PDBG){		
	$dbo=PDBO;
	$q = "SELECT pd.id AS pdid,pd.*,p.name AS product,p.combo,p.barcode,p.code
		FROM {$dbo}.`30_positems` AS pd
			LEFT JOIN {$dbo}.`03_products` AS p ON pd.product_id = p.id
		WHERE pd.`pos_id` = '$rxref_posid' ORDER BY p.name LIMIT 100; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();


}	/* fxn */
