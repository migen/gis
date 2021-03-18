<?php


function getPO($db,$dbg,$poid){
	$dbo=PDBO;
	$q = "SELECT po.*,e.name AS employee,s.name AS supplier,t.name AS terminal_name 
		FROM {$dbo}.30_po AS `po`
			LEFT JOIN {$dbo}.`00_contacts` AS e ON po.ecid = e.id 
			LEFT JOIN {$dbo}.`00_contacts` AS s ON po.suppid = s.id 
			LEFT JOIN {$dbo}.terminals AS t ON po.terminal = t.id 
		WHERE po.`id` = $poid LIMIT 1; ";
	debug($q);
	$sth = $db->querysoc($q);
	$data['row'] = $po = $sth->fetch();
	
	/* 2 supplier info */
	$suppid=$data['row']['suppid'];	
	$q="SELECT c.name AS fullname,c.*,s.*,s.id AS suppucid FROM {$dbo}.`00_contacts` AS c
	LEFT JOIN {$dbo}.suppliers AS s ON s.contact_id=c.id WHERE c.`id`='$suppid' LIMIT 1;";
	debug($q);	
	$sth=$db->querysoc($q);
	$data['supplier']=$supplier=$sth->fetch();	
	if(empty($row['suppucid'])){ $q="INSERT INTO {$dbo}.suppliers(`contact_id`)VALUES('$suppid');"; $db->query($q); }
	
	/* 3 */
 
	$q = "SELECT pd.*,pr.name AS product,pd.id AS pdid,pr.code,b.sumrxqty AS rxqty,pr.is_decimal 
		FROM {$dbo}.`30_podetails` AS pd 
			LEFT JOIN {$dbo}.`30_po` AS po ON pd.po_id = po.id
			LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id
			LEFT JOIN (
				SELECT po_id,product_id,sum(rxqty) AS sumrxqty FROM {$dbo}.`30_po_rx` WHERE po_id='$poid' GROUP BY product_id
			) AS b ON (b.po_id=po.id && b.product_id=pr.id)
		WHERE pd.po_id = $poid ORDER BY pr.name; ";

	debug($q);	
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();			
	$total_roqty=0;
	$total_rxqty=0;
	foreach($data['rows'] AS $row){
		$total_roqty+=$row['roqty'];
		$total_rxqty+=$row['rxqty'];
	}
	$data['total_roqty']=$total_roqty;
	$data['total_rxqty']=$total_rxqty;
	$qty_balance=($total_roqty-$total_rxqty);
	
	if($qty_balance>0){ $is_delivered=0; $delivery_status='Partial'; } elseif($qty_balance<0){
		$is_delivered=2; $delivery_status='Over';
	} else{ $is_delivered=1; $delivery_status='Full'; }
	
	
	/* 3.1 */
	$is_delivered=($total_roqty==$total_rxqty)? 1:0;
	$q="UPDATE {$dbo}.`30_po` SET `is_delivered`='$is_delivered',`qty_ordered`='$total_roqty',
		`qty_received`='$total_rxqty' WHERE `id`='$poid' LIMIT 1; ";
	debug($q);		
	$db->query($q);
	

	/* 4 */
	$q = "SELECT *,id AS ppid FROM {$dbo}.`30_po_payments` WHERE po_id = '$poid'; ";
	debug($q);	
	$sth = $db->querysoc($q);
	$data['pays'] = $sth->fetchAll();		
	$total_paid=0;
	foreach($data['pays'] AS $row){
		$total_paid+=round($row['amount'],2);
	}
	$data['total_paid']=$total_paid;
	$po_total=round($po['assessed'],2)-round($po['discount'],2);
	$balance=$po_total-$total_paid;

	if($balance>0){ $is_paid=0; $payment_status='Unpaid'; } elseif($balance<0){ $is_paid=2; $payment_status='Over payment';
	} else{ $is_paid=1; $payment_status='Full payment'; }
	
	$q="UPDATE {$dbo}.`30_po` SET `is_paid`='$is_paid',`paid`='$total_paid',`balance`='$balance' 
		WHERE `id`='$poid' LIMIT 1; ";
	debug($q);		
	$db->query($q);
	
	$data['delivery_status']=$delivery_status;
	$data['payment_status']=$payment_status;
		
	return $data;


}	/* fxn */


function savePO($db,$dbg,$poid,$po,$pd,$count,$pays,$payment,$t){
	$dbo=PDBO;$today=$_SESSION['today'];$year=DBYR;
	$rxdate=$po['rxdate'];$total = 0;	
	$q = ""; 
	$numrows = count($pd);
	for($i=0;$i<$numrows;$i++){
		$row = $pd[$i];
		$amount = $row['roqty']*$row['cost'];
		$total+=$amount;
		if($i<$count){	
			$q .= "UPDATE {$dbo}.`30_podetails` SET 
				`product_id`='".$row['product_id']."', 
				`roqty`='".$row['roqty']."', 
				`rxqty`='".$row['rxqty']."', 
				`cost`='".$row['cost']."', 
				`amount`='".$amount."'
				WHERE `id` = '".$row['pdid']."' LIMIT 1; ";	
			$q .= "UPDATE {$dbo}.`03_products` SET `t{$t}`=`t{$t}`+(".$row['pxqty']."-".$row['oldrxqty']."),
				`pocost`='".$row['cost']."' WHERE `id` = '".$row['product_id']."' LIMIT 1; ";	
				
		} else {
			if($row['product_id']>0){
				$q .= "INSERT INTO {$dbo}.30_podetails(`po_id`,`product_id`,`roqty`,`cost`,`amount`,`rxqty`) VALUES  
						('$poid','".$row['product_id']."','".$row['roqty']."','".$row['cost']."','".$row['amount']."',
						'".$row['rxqty']."');";	
				$q .= "UPDATE {$dbo}.`03_products` SET `t{$t}` = (`t{$t}`+".$row['rxqty']."),`pocost`='".$row['cost']."' 
					WHERE `id` = '".$row['product_id']."' LIMIT 1; ";						
			}
		}
		
		if($row['cost']!=$row['origcost']){
			$q.="INSERT INTO {$dbg}.`30_costlogs`(`year`,`prid`,`date`,`oldcost`,`cost`)VALUES
				('$year','".$row['product_id']."','$today','".$row['origcost']."','".$row['cost']."'); ";
		}
		debug($q);
		
		/* px */
		// if($row['pxqty']>0){
		if(isset($row['pxqty']) && $row['pxqty']>0){
			$q.="INSERT INTO {$dbo}.30_po_rx(`po_id`,`product_id`,`rxdate`,`rxqty`)
				VALUES('$poid','".$row['product_id']."','$rxdate','".$row['pxqty']."'); ";
		}
		
	}	/* pd */	
	// pr($q); 
	// exit; 
	$db->query($q);	
	$_SESSION['q'] = $q;
	
	/* 2 */
	$prids=buildArray($pd,'product_id');
	$q="";
	$tmax=$_SESSION['settings']['numterminals'];
	$expr="level=(";
	for($i=1;$i<=6;$i++){ $expr.="t{$i}+"; }
	$expr=rtrim($expr,"+");
	$expr.=")";	
	foreach($prids AS $prid){ $q.="UPDATE {$dbo}.`03_products` SET $expr WHERE `id`='$prid' LIMIT 1;"; }	
	$_SESSION['q']=$q;
	$db->query($q);
	
	/* 3 */
	if($payment['amount']>0){
		$q = "INSERT INTO {$dbo}.30_po_payments(`po_id`,`amount`,`reference`,`date`) 
			VALUES ('$poid','".$payment['amount']."','".$payment['reference']."','$today');";
		$db->query($q);			
	}	/* pay */
	
	$paid = 0;
	$q="";
	foreach($pays AS $pay){
		$paid+=$pay['amount'];
		$q .= "UPDATE {$dbg}.`po_payments` SET `date` = '".$pay['date']."',`amount` = '".$pay['amount']."',
			`reference` = '".$pay['reference']."' WHERE `id` = '".$pay['ppid']."' LIMIT 1; ";		
	}
	$db->query($q);
	
	
	/* 3 */
	$paid+=$payment['amount'];
	$assessed = str_replace(",","",$po['assessed']);			
	// echo "TOTAL HERE: "; pr($total);
	// $total = $assessed - $po['discount'];
	$assessed=$total;	
	$total = $total - $po['discount'];
	
	$balance = $total - $paid;
	
	$q = "UPDATE {$dbo}.`30_po` SET 
		`assessed` = '$assessed',
		`discount` = '".$po['discount']."',
		`paid` = '$paid',
		`total` = '$total',
		`balance` = '$balance',
		`terminal` = '".$po['terminal']."',
		`invoice` = '".$po['invoice']."',
		`reference` = '".$po['reference']."',
		`remarks` = '".$po['remarks']."',
		`date` = '".$po['date']."'
		WHERE `id` = '$poid' LIMIT 1; ";
	// pr($q);exit;
	$db->query($q);
	
}	/* fxn */


function createPO($db,$dbg,$posts,$lastPoid){		
	$dbo=PDBO;
	$rows = $posts['pos'];
	$poid = $lastPoid+1;

	$total = 0;
	$count=0;
	$q = "INSERT IGNORE INTO {$dbo}.`30_podetails`(`po_id`,`product_id`,`cost`,`roqty`) VALUES ";	
	foreach($rows AS $row){
		if(isset($row['is_selected'])){
			$q .= " ('$poid','".$row['product_id']."','".$row['cost']."','".$row['roqty']."'),";			
		}	/* if */
		
	}	/* foreach */
	$q = rtrim($q,",");
	$q .= ";";
	$sth=$db->query($q);
 	if($sth){
		$terminal = $posts['terminal'];
		$suppid = $posts['suppid'];
		$ecid = $posts['ecid'];
		$today = $_SESSION['today'];	
		$reference = $posts['reference'];		
		$q = "INSERT IGNORE INTO {$dbo}.30_po(`id`,`terminal`,`suppid`,`ecid`,`date`,`reference`) 
			VALUES ('$poid','$terminal','$suppid','$ecid','$today','$reference'); ";
		$sth = $db->querysoc($q);		
		return $poid;	
	} else {		
		return false;
	}
	
}	/* fxn */


function podetails($db,$dbg,$poid){
	$dbo=PDBO;
	$q = "SELECT po.*,e.name AS employee,s.name AS supplier,t.name AS terminal_name 
		FROM {$dbo}.30_po AS `po`
			LEFT JOIN {$dbo}.`00_contacts` AS e ON po.ecid = e.id 
			LEFT JOIN {$dbo}.`00_contacts` AS s ON po.suppid = s.id 
			LEFT JOIN {$dbo}.terminals AS t ON po.terminal = t.id 
		WHERE po.`id` = $poid LIMIT 1; ";
	$sth = $db->querysoc($q);
	$data['row'] = $po = $sth->fetch();
	
	/* 2 supplier info */
	$suppid=$data['row']['suppid'];	
	$q="SELECT c.name AS fullname,c.*,s.*,s.id AS suppucid FROM {$dbo}.`00_contacts` AS c
	LEFT JOIN {$dbo}.suppliers AS s ON s.contact_id=c.id WHERE c.`id`='$suppid' LIMIT 1;";
	$sth=$db->querysoc($q);
	$data['supplier']=$supplier=$sth->fetch();	
	if(empty($row['suppucid'])){ $q="INSERT INTO {$dbo}.suppliers(`contact_id`)VALUES('$suppid');"; $db->query($q); }
	
	$t=$po['terminal'];
	/* 3 */
	// $q = "SELECT pd.*,pr.name AS product,pd.id AS pdid,pr.code,b.sumrxqty AS rxqty,pr.is_decimal 
		// FROM {$dbo}.`30_podetails` AS pd 
			// LEFT JOIN {$dbo}.`30_po` AS po ON pd.po_id = po.id
			// LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id
			// LEFT JOIN (
				// SELECT po_id,product_id,sum(rxqty) AS sumrxqty FROM {$dbo}.`30_po_rx` WHERE po_id='$poid' GROUP BY product_id
			// ) AS b ON (b.po_id=po.id && b.product_id=pr.id)
		// WHERE pd.po_id = '$poid' ORDER BY pr.name; ";	
	
	// $q = "SELECT pd.*,p.name AS product,pd.id AS pdid,p.code,p.t{$t} 
		// FROM {$dbo}.`30_podetails` AS pd 
			// LEFT JOIN {$dbo}.`03_products` AS p ON pd.product_id = p.id
		// WHERE pd.po_id = '$poid' ORDER BY p.name; ";
		
	$q = "SELECT pd.*,pr.name AS product,pd.id AS pdid,pr.code,pr.t{$t},b.sumrxqty AS rxqty,pr.is_decimal 
		FROM {$dbo}.`30_podetails` AS pd 
			LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id
			LEFT JOIN {$dbo}.`30_po` AS po ON pd.po_id = po.id			
			LEFT JOIN (
				SELECT po_id,product_id,sum(rxqty) AS sumrxqty FROM {$dbo}.`30_po_rx` WHERE po_id='$poid' GROUP BY product_id
			) AS b ON (b.po_id=po.id && b.product_id=pr.id)			
		WHERE pd.po_id = '$poid' ORDER BY pr.name; ";
	// pr($q);
		
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();		
	$data['count']=count($data['rows']);
	
	/* 4 pmvdetails */
	$q="SELECT pd.*,pd.id AS pdid,p.name AS product,p.*,pd.cost FROM {$dbo}.`30_pmvdetails` AS pd 
		LEFT JOIN {$dbo}.`03_products` AS p ON pd.prid=p.id WHERE pd.poid='$poid' ORDER BY p.name,pd.terminal; ";
				
	$sth = $db->querysoc($q);
	$data['pd'] = $sth->fetchAll();	
	$data['numpd']=count($data['pd']);
	
	return $data;


}	/* fxn */


function posumm($db,$params,$dbg=PDBG){
	$dbo=PDBO;
	$sort   = (isset($params['sort']))?$params['sort']:'p.datetime';
	$order  = (isset($params['order']))?$params['order']:'DESC';
	$offset = ($params['page']-1)*$params['limits'];
		
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
		
	
	$cond = NULL;
	$cond .= "";
	if (!empty($params['comm'])){ $cond .= " AND pr.comm = '".$params['comm']."'"; }				
	if (!empty($params['suppid'])){ $cond .= " AND pr.suppid = '".$params['suppid']."'"; }				
	if (!empty($params['start'])){ $cond .= " AND p.date >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND p.date <= '".$params['end']."'"; }				
	
	$q = "
		SELECT 
			p.id AS po_id,p.is_paid,pr.id AS prid,pr.code,pr.name AS product,pr.comm,s.name AS supplier,pr.suppid,
			SUM(pd.roqty) AS `order_total`,p.`invoice`,
			SUM(pd.rxqty) AS `recd_total`			
		FROM {$dbo}.`30_podetails` AS pd
			LEFT JOIN {$dbo}.`30_po` AS p ON pd.po_id = p.id
			LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
			LEFT JOIN {$dbo}.`00_contacts` AS s ON pr.suppid = s.id		
		WHERE 	1=1 $cond GROUP BY pr.id ORDER BY $sort $order $condlimits 
	 ;";
	 $data['q']=$q;	
	$data['page'] = 'PO Summary';
	debug($q,'poFxn: posumm');
	// echo "PO Summ Qry: "; pr($q);
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);				

	$data['ccid'] = isset($_POST['ccid'])? $_POST['ccid']:false;		
	return $data;


}	/* fxn */



