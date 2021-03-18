<?php


function rx($db,$pos,$pds,$ccid,$sy){
	$dbo=PDBO;
	$dbg=PDBG;
	$odbg=VCPREFIX.$sy.US.DBG; 
	$dt=dt();
	$last_posid=lastPosid($db,$dbg);
	$new_posid=$last_posid+1;
	$old_posid=$pos['id'];
	$ecid=$_SESSION['ucid'];
	$tml=$pos['terminal'];

	$q="";
	$total=0;
	foreach($pds AS $pd){
		// pr($pd);
		if(isset($pd['qty'])){
			$product_id=$pd['product_id'];$cost=$pd['cost'];$price=$pd['price'];
			$qty=$pd['qty'];$amount=$pd['qty']*-$pd['price'];
			$pdid=$pd['pdid'];			
			$total+=$amount;
			$q.="INSERT INTO {$dbo}.`30_positems`(`rx_pdid`,`rx_posid`,`pos_id`,`product_id`,`cost`,`price`,`qty`,`amount`)  VALUES ('$pdid','$old_posid','$new_posid','$product_id','$cost','$price','$qty','$amount');";				
			$q .= "UPDATE {$dbo}.`03_products` SET `level` = `level`-".$qty.",`t{$tml}` = `t{$tml}` - ".$qty."
				WHERE `id`='$product_id' LIMIT 1;";				
			$q.="UPDATE {$odbg}.`30_positems` SET `is_rxed`=1 WHERE `id`='$pdid' LIMIT 1; ";			
			
		}
		// pr($q);
	}	/* foreach */
	if($q){ $q.="INSERT INTO {$dbo}.`30_pos`(`id`,`datetime`,`ecid`,`ccid`,`terminal`,`total`,`is_return`)
			VALUES('$new_posid','$dt','$ecid','$ccid','$tml','$total','1'); ";
	} 
	if($sy==DBYR){ $q.="UPDATE {$dbo}.`30_pos` SET `ccid`='$ccid' WHERE `id`='$old_posid' LIMIT 1; ";}	
	$sth=$db->query($q);
	return $sth;
	
}	/* fxn */



function viewPosrx($db,$posid,$dbg){
	$dbo=PDBO;
	$q="SELECT a.*,b.name AS product
		FROM {$dbo}.`30_positems` AS a LEFT JOIN {$dbo}.`03_products` AS b ON a.product_id=b.id";
	$q.=" WHERE a.rx_posid='$posid' ORDER BY b.name ; ";		
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	return $sth->fetchAll();

}	/* fxn */



function viewPosdetails($pos_id,$db,$dbg=PDBG){
$dbo=PDBO;
$q = "SELECT p.*,
		IF(p.ccid=0,p.guest,c.name) AS customer,c.code AS customer_code,
		e.name AS employee,e.code AS employee_code,b.name AS bank
	FROM {$dbo}.`30_pos` AS p
		LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid = c.id
		LEFT JOIN {$dbo}.`00_contacts` AS e ON p.ecid = e.id
		LEFT JOIN {$dbo}.`03_banks` AS b ON p.bank_id = b.id
	WHERE p.`id` = '$pos_id' LIMIT 1; ";
$sth = $db->querysoc($q);
$data['pos'] = $sth->fetch();

$q = "SELECT pd.id AS pdid,pd.*,p.name AS product,p.id AS prid,p.combo,p.barcode,p.code
	FROM {$dbo}.`30_positems` AS pd
		LEFT JOIN {$dbo}.`03_products` AS p ON pd.product_id = p.id
	WHERE pd.`pos_id` = '$pos_id' ORDER BY p.name LIMIT 100; ";
$sth = $db->querysoc($q);
$data['positems'] = $sth->fetchAll();


$q = "SELECT 
		pd.*,p.code,p.name AS product,p.id AS prid
	FROM {$dbo}.`30_positems` AS pd
		LEFT JOIN {$dbo}.`03_products` AS p ON pd.product_id = p.id
	WHERE pd.`rx_posid` = '$pos_id' AND pd.qty>0 ORDER BY p.name LIMIT 100; ";
$sth = $db->querysoc($q);
$data['prxdetails'] = $sth->fetchAll();

return $data;


}	/* fxn */




function addrx($db,$posts){
	$dbg=PDBG;$dbo=PDBO;	
	$pos = $posts['pos'];
	$positems = $posts['positems'];
	$orno = $pos['orno'];

	if($pos['ccid']!=0){ unset($pos['guest']); } 
	$pos['total'] = str_replace(",","",$pos['total']);
	$pos['tenderetc'] = str_replace(",","",$pos['tenderetc']);
	$pos['tendercs'] = $pos['total']-$pos['tenderetc'];
		
	if(!empty($positems[0]['product_id'])){	/* with positems */
	
		$db->add("{$dbo}.`30_pos`",$pos);
		$pos_id = $db->lastInsertId();
		$tml = $pos['terminal'];

		$q="";
		foreach($positems AS $row){			
			if(($row['qty']!=0) && ($row['product_id']>1)){		/* hasproduct */
				$qty = $row['qty'];
				/* 1 */
				$q .= " INSERT INTO {$dbo}.`30_positems`(`pos_id`,`product_id`,`price`,`qty`,`amount`,`cost`) VALUES ('$pos_id','".$row['product_id']."','".$row['price']."','".$row['qty']."','".$row['amount']."','".$row['cost']."');";
				/* 2 */
				$q .= "UPDATE {$dbo}.`03_products` SET `level` = `level`-".$qty.",`t{$tml}` = `t{$tml}` -".$qty."
				WHERE `id`='".$row['product_id']."' LIMIT 1;";
				
				if(isset($row['pdid'])){
					$q.="UPDATE {$dbo}.`30_positems` SET `rxqty`=IFNULL(`rxqty`,0)-'$qty' WHERE `id`='".$row['pdid']."' LIMIT 1; ";
				}
				
			}	/* hasproduct */
		}	
		
		
		/* 3 - rxid */
		$q .= "UPDATE {$dbo}.`30_pos` SET `rxid` = '$pos_id' WHERE `id` = '".$pos['rxref_posid']."' LIMIT 1;";					
		/* 4 - orno */
		$q .= "UPDATE {$dbo}.`03_orbooklets` SET `orno` = '$orno' WHERE `ecid` = '".$pos['ecid']."' LIMIT 1;";					
		$_SESSION['orno'] = $orno; 								
		$db->query($q);
		$_SESSION['last_orno'] = $pos['orno'];
		$_SESSION['last_posid'] = $pos_id;
		return $pos_id;
	}	/* with positems */
	return false;
		

}	/* fxn */


