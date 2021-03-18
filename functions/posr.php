<?php


function itemsReport($db,$params,$dbg=PDBG){
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
	if (!empty($params['is_return'])){ $cond .= " AND pd.qty < '0' "; }				
	if (!empty($params['ccid'])){ $cond .= " AND p.ccid = '".$params['ccid']."'"; }				
	if (!empty($params['comm'])){ $cond .= " AND pr.comm = '".$params['comm']."'"; }				
	if (!empty($params['terminal'])){ $cond .= " AND p.terminal = '".$params['terminal']."'"; }				
	if (!empty($params['start'])){ $cond .= " AND DATE(p.datetime) >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND DATE(p.datetime) <= '".$params['end']."'"; }				
	if (!empty($params['sy'])){ $sy=$params['sy']; $dbg=VCPREFIX.$sy.US.DBG; }				
	
	if (!empty($params['product_id'])){ 
		$cond .= " AND pd.product_id = '".$params['product_id']."'"; 
	} 				
	if (!empty($params['prodtype_id'])){ 
		$cond .= " AND ps.prodtype_id = '".$params['prodtype_id']."'"; 
	} 				
	if (!empty($params['prodsubtype_id'])){ 
		$cond .= " AND ps.id = '".$params['prodsubtype_id']."'"; 
	} 				

	if (!empty($params['prodtag_id'])){ 
		$cond .= " AND pt.prodtag_id = '".$params['prodtag_id']."'"; 
	} 				
	
	$is_summary = false;			
	$case = "items_list";
	
	$q = items_list($db,$dbg,$cond,$sort,$order,$condlimits);
	$data['case'] = $case;
	// pr($cond);
	// echo "items report: "; pr($q);
	$data['q']=$q;
	debug($q,"posr: itemsReport ");
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);				
		
	return $data;


}	/* fxn */

function sales_list($db,$dbg,$cond,$sort,$order,$condlimits){
	$dbo=PDBO;
	$q = "SELECT p.id AS pos_id,p.*,e.name AS employee,e.code AS emplcode,c.code AS custcode,
			IF(p.ccid=0,p.guest,c.name) AS customer,b.code AS bankcode,b.name AS bank,
			pt.code AS ptcode,pt.name AS paytype		
		FROM {$dbo}.`30_pos` AS p
			LEFT JOIN {$dbo}.`00_contacts` AS e ON p.ecid = e.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON p.ccid = c.id
			LEFT JOIN {$dbo}.`03_banks` AS b ON p.bank_id = b.id
			LEFT JOIN {$dbo}.`03_paytypes` AS pt ON p.paytype_id = pt.id
		 WHERE 	1=1 $cond ORDER BY $sort $order $condlimits ;";		
	debug($q,"posr: sales_list ");	 
	return $q;
	
}	/* fxn */



function salesReport($db,$params,$dbg=PDBG){
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
	if (!empty($params['ccid'])){ $cond .= " AND p.ccid = '".$params['ccid']."'"; }				
	if (!empty($params['ecid'])){ $cond .= " AND p.ecid = '".$params['ecid']."'"; }				
	if (!empty($params['terminal'])){ $cond .= " AND p.terminal = '".$params['terminal']."'"; }				
	if (!empty($params['start'])){ $cond .= " AND DATE(p.datetime) >= '".$params['start']."'"; }				
	if (!empty($params['end'])){ $cond .= " AND DATE(p.datetime) <= '".$params['end']."'"; }				
	if (!empty($params['sy'])){ $sy=$params['sy']; $dbg=VCPREFIX.$sy.US.DBG; }				
	if (!empty($params['terminal'])){ $cond .= " AND p.terminal = '".$params['terminal']."'"; }		
	$params['is_credit'] = (isset($params['is_credit']))? $params['is_credit']:2;
		
	if ($params['is_credit']==0){ $cond .= " AND (p.`is_credit` is null || p.is_credit = '0') "; 
		} elseif($params['is_credit']==1) { $cond .= " AND p.is_credit = '1' "; }	
	$params['is_paid'] = (isset($params['is_paid']))? $params['is_paid']:2;
	if ($params['is_paid']==0){ $cond .= " AND (p.`is_paid` = '0' || p.`is_paid` is null) "; 
		} elseif($params['is_paid']==1) { $cond .= " AND p.`is_paid` = '1' "; }
	
	$is_summary = $params['is_summary'];
	$is_sales = true;		
	$select_sales = " SUM(p.total) AS total ";
	$select = ($is_sales)? $select_sales:$select_inventory;
	
	if($is_summary==1){
		$case = "sales_summary";$pagename = "Sales Summary";
		$q = sales_summary($db,$dbg,$cond,$sort,$order,$condlimits);		
	} elseif($is_summary==2){
		$case = "sales_itemized";$pagename = "Sales Itemized";
		$q = sales_itemized($db,$dbg,$cond,$sort,$order,$condlimits);		
	} else {
		$case = "sales_list";$pagename = "Sales List";
		$q = sales_list($db,$dbg,$cond,$sort,$order,$condlimits);
	}
	$data['case'] = $case;
	$data['page'] = $pagename;

	debug($q,"posr: salesReport");
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);				

	$data['ccid'] = isset($_POST['ccid'])? $_POST['ccid']:false;		
	$data['q']=$q;
	debug($q,"posr: salesReport ");	 	
	return $data;


}	/* fxn */



function sales_summary($db,$dbg,$cond,$sort,$order,$condlimits){	
	$dbo=PDBO;
	if(!empty($_POST['suppid']) || !empty($_POST['comm'])){
		$q = "SELECT SUM(pd.price*pd.qty) AS `total`			
			FROM {$dbo}.`30_positems` AS pd
				LEFT JOIN {$dbo}.`30_pos` AS p ON pd.pos_id = p.id
				LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
			WHERE 	1=1 $cond ORDER BY $sort $order $condlimits ;";		 	
	} else {
		$q = " SELECT SUM(p.total) AS `total` FROM {$dbo}.`30_pos` AS p
			WHERE 1=1 $cond ORDER BY $sort $order $condlimits; ";
	
	}		
	debug($q,"posr: sales_summary ");	 		
	return $q;
	
}	/* fxn */




function sales_itemized($db,$dbg,$cond,$sort,$order,$condlimits){
	$dbo=PDBO;	 	 	 
	$q = "SELECT 
			pd.id AS pdid,pd.product_id AS prid,p.id AS pos_id,pr.suppid,c.name AS supplier,
			pr.name AS product,pr.barcode,SUM(pd.qty) AS sold,SUM(pd.qty*pd.price) AS revenue,
			pr.cost,AVG(pd.price) AS price,AVG(pd.cost) AS cost,
			b.rxqty AS rxqty
		FROM {$dbo}.`30_positems` AS pd
			LEFT JOIN {$dbo}.`30_pos` AS p ON pd.pos_id = p.id
			LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
			LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid = c.id
			LEFT JOIN ( SELECT pos_id,rxqty FROM {$dbo}.`30_positems` WHERE rxqty>0 ) AS b ON pd.pos_id = b.pos_id
		WHERE 1=1 $cond GROUP BY pr.id ORDER BY supplier,pr.name $condlimits ;";		 	 
	debug($q,"posr: sales_itemized ");	 		
	 return $q;
	
}	/* fxn */




function items_list($db,$dbg,$cond,$sort,$order,$condlimits){
	$dbo=PDBO;	
	$q = "SELECT DATE(b.datetime) AS date,b.pos_id,pr.barcode,pr.name AS product,pr.cost,pr.price,pr.uom,c.name AS supplier,pr.suppid,
		pr.id AS prodid,pr.level,b.sold,b.revenues,(b.sold*b.cost) AS cgs,b.price,b.cost
	FROM {$dbo}.`03_products` AS pr 
		RIGHT JOIN (
			SELECT p.datetime,pd.product_id AS `prodid`,sum(pd.qty*pd.price) AS revenues,sum(pd.qty) AS sold,p.id AS pos_id,
			AVG(pd.price) AS price,AVG(pd.cost) AS cost
			FROM {$dbo}.`30_positems` AS pd
				LEFT JOIN {$dbo}.`30_pos` AS p ON p.id = pd.pos_id		
				LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
				LEFT JOIN {$dbo}.`03_prodsubtypes` AS ps ON pr.prodsubtype_id = ps.id		
				LEFT JOIN {$dbo}.`03_prodtypes` AS pt ON ps.prodtype_id = pt.id		
			WHERE 1=1 $cond 	
			GROUP BY pd.product_id		
		) AS b ON pr.id = b.prodid
		LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid=c.id
	ORDER BY supplier,pr.name; ;";	
	debug($q,"posr: items_list ");	 		
	return $q;
	
}	/* fxn */



function getEmployeeOrnos($db,$ecid,$start,$end){
$dbg=PDBG;$dbo=PDBO;

$q=" SELECT `orno` FROM {$dbo}.`30_pos` WHERE DATE(`datetime`) >= '$start' AND DATE(`datetime`) <= '$end' 
	AND `ecid` = '$ecid' ORDER BY `orno` DESC LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
$data['max'] = $row['orno'];
debug($q,"posr: getEmployeeOrnos-max ");	 		

$q=" SELECT `orno` FROM {$dbo}.`30_pos` WHERE DATE(`datetime`) >= '$start' AND DATE(`datetime`) <= '$end' 
	AND `ecid` = '$ecid' ORDER BY `orno` ASC LIMIT 1; ";
$sth=$db->querysoc($q);
$row=$sth->fetch();
debug($q,"posr: getEmployeeOrnos-min ");	 		
$data['min'] = $row['orno'];

return $data;

}	/* fxn */


function getEmployeeSales($db,$ecid,$start,$end){
$dbg=PDBG;$dbo=PDBO;

$q=" SELECT sum(p.total) AS `sales` FROM {$dbo}.`30_pos` AS p WHERE p.ecid='$ecid' 
	AND DATE(`datetime`) >= '$start' AND DATE(`datetime`) <= '$end' ;";
debug($q,"posr: getEmployeeSales-total ");	 		
$sth=$db->querysoc($q);
$row=$sth->fetch();
$data['total'] = $row['sales'];

$q=" SELECT sum(p.total) AS `sales` FROM {$dbo}.`30_pos` AS p WHERE p.ecid='$ecid' 
	AND DATE(`datetime`) >= '$start' AND DATE(`datetime`) <= '$end' 
	AND p.`is_paid`='1';";
debug($q,"posr: getEmployeeSales-paid ");	 			
$sth=$db->querysoc($q);
$row=$sth->fetch();
$data['paid'] = $row['sales'];
$data['unpaid'] = $data['total']-$data['paid'];


/* 2 tender */
$q=" SELECT sum(p.tenderetc) AS `sales` FROM {$dbo}.`30_pos` AS p WHERE p.ecid='$ecid' 
	AND DATE(`datetime`) >= '$start' AND DATE(`datetime`) <= '$end' 
AND p.`is_paid`='1';";
debug($q,"posr: getEmployeeSales-etc or noncash ");	 			
$sth=$db->querysoc($q);
$row=$sth->fetch();
$data['tender_etc'] = $row['sales'];
$data['tender_cash'] = $data['paid'] - $data['tender_etc'];


/* 3 cash count denominations tally */

$where=" `date` >= '$start' AND `date` <= '$end' AND `ecid` = '$ecid' ";
$q="SELECT SUM(cash) AS cash FROM {$dbg}.`30_cash` WHERE $where;";
debug($q,"posr: getEmployeeSales-cash_count ");	 			
$sth=$db->querysoc($q);
$row=$sth->fetch();
$data['cash_count'] = $row['cash'];


return $data;

}	/* fxn */
