<?php





function masterInventory($db,$params,$dbg=PDBG){
	$dbo=PDBO;
	$start=$params['start'];
	$end=$params['end'];
	$cond="";
	if($params['suppid']>0){ $cond="suppid='".$params['suppid']."'"; }
	
	$suppid=$params['suppid'];
	$qr="";	
	$q="SELECT id AS prid,barcode,name AS product,cost,price,level FROM {$dbo}.`03_products` WHERE $cond; ";
	$qr.="<br />".$q;
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=count($rows);
	
	for($i=0;$i<$count;$i++){
		$q="SELECT SUM(rxqty) AS received FROM {$dbo}.30_po_rx 
			WHERE `product_id`='".$rows[$i]['prid']."' AND `rxdate`>='$start' AND `rxdate`<='$end'; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$rows[$i]['received']=$row['received'];
	}	/* fxn */
	$qr.="<br />".$q;
	
	for($i=0;$i<$count;$i++){
		$q="SELECT SUM(qty) AS shrinkages FROM {$dbg}.30_shrinkages 
			WHERE `prid`='".$rows[$i]['prid']."' AND `date`>='$start' AND `date`<='$end'; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$rows[$i]['shrinkages']=$row['shrinkages'];
	}	/* fxn */
	$qr.="<br />".$q;

	for($i=0;$i<$count;$i++){
		$q="SELECT SUM(pd.`qty`) AS sold 
			FROM {$dbo}.`30_positems` AS pd 
				INNER JOIN {$dbo}.`30_pos` AS p ON p.id=pd.pos_id
			WHERE pd.`product_id`='".$rows[$i]['prid']."' AND DATE(p.`datetime`)>='$start' AND DATE(p.`datetime`)<='$end'; ";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$rows[$i]['sold']=$row['sold'];
	}	/* fxn */
	$qr.="<br />".$q;
	
	$q="SELECT id,name FROM {$dbo}.`00_contacts` WHERE id='$suppid' LIMIT 1;  ";
	$sth=$db->querysoc($q);
	$supp=$sth->fetch();
	$qr.=$q;
	
	$data['rows']=&$rows;
	$data['count']=&$count;
	$data['supp']=&$supp;
	$data['q']=&$qr;
	
	return $data;
	



}	/* fxn */

function getProductsBySupplier($db,$t,$where,$sort="c.name,pr.name",$order="ASC",$dbg=PDBG){
$dbo=PDBO;

$q="SELECT pr.id AS prid,pr.name AS product,pr.level,pr.*
	FROM {$dbo}.`03_products` AS pr LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid = c.id
	WHERE 1=1 $where ORDER BY $sort $order;";
$sth=$db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['q']=$q;
return $data;

}	/* fxn */



function getProductsBySales($db,$t,$where,$sort="pr.name",$order="ASC",$dbg=PDBG){
$dbo=PDBO;
$q="SELECT pr.id AS prid,pr.name AS product,pr.level,b.sold AS sold,pr.*,c.name AS supplier
	FROM {$dbo}.`03_products` AS pr 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid = c.id
		RIGHT JOIN (
			SELECT pd.product_id AS `prodid`,sum(pd.qty) AS sold,p.id AS pos_id
			FROM {$dbo}.`30_positems` AS pd
				LEFT JOIN {$dbo}.`30_pos` AS p ON p.id = pd.pos_id		
				LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
			WHERE 1=1  AND p.terminal = '$t' 	
			GROUP BY pd.product_id		
		) AS b ON pr.id = b.prodid
	WHERE 1=1 $where				
	ORDER BY $sort $order; ";
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function getProducts($db,$where=NULL,$sort="pr.name",$order="ASC",$dbg=PDBG){
$dbo=PDBO;
$q="
	SELECT pr.id AS prid,pr.name AS product,pr.*
	FROM {$dbo}.`03_products` AS pr 
	WHERE 1=1 $where		
	ORDER BY $sort $order
";


// pr($q);
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


function getSoldProducts($db,$t,$sort="c.name,pr.name",$order="ASC",$dbg=PDBG){
$dbo=PDBO;
$q="SELECT pr.id AS prid,pr.name AS product,pr.level,b.sold AS sold,pr.*,c.name AS supplier
	FROM {$dbo}.`03_products` AS pr 
		LEFT JOIN {$dbo}.`00_contacts` AS c ON pr.suppid=c.id
		RIGHT JOIN (
			SELECT pd.product_id AS `prodid`,sum(pd.qty) AS sold,p.id AS pos_id
			FROM {$dbo}.`30_positems` AS pd
				LEFT JOIN {$dbo}.`30_pos` AS p ON p.id = pd.pos_id		
				LEFT JOIN {$dbo}.`03_products` AS pr ON pd.product_id = pr.id		
			WHERE 1=1  AND p.terminal = '$t' 	
			GROUP BY pd.product_id		
		) AS b ON pr.id = b.prodid
	ORDER BY $sort $order ";
debug("inventory: ".$q);
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */



function getInvlogs($db,$params,$dbg=PDBG){
	$dbo=PDBO;
	$sort   = (isset($params['sort']))?$params['sort']:'p.date';
	$order  = (isset($params['order']))?$params['order']:'DESC';
	$offset = ($params['page']-1)*$params['limits'];
		
	$page = $params['page'];
	$limits = $params['limits'];	
	$offset = ($page-1)*$limits;
	$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 
			
	$cond = NULL;
	$cond .= "";
	if (!empty($params['suppid'])){ $cond .= " AND p.suppid = '".$params['suppid']."'"; }				
	if (!empty($params['terminal'])){ $cond .= " AND i.terminal = '".$params['terminal']."'"; }				
	if (!empty($params['prid'])){ $cond .= " AND p.id = '".$params['prid']."'"; }				
	if (!empty($params['dateone'])){ $cond .= " AND i.date >= '".$params['dateone']."'"; }				
	if (!empty($params['datetwo'])){ $cond .= " AND i.date <= '".$params['datetwo']."'"; }				

	$q="SELECT i.*,p.name AS product,p.code,p.comm 
	FROM {$dbg}.30_invlogs AS i 
	LEFT JOIN {$dbo}.`03_products` AS p ON i.prid=p.id 
	WHERE 1=1 $cond ORDER BY $sort $order $condlimits;";
	debug("inventory: ".$q);
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=count($data['rows']);

	return $data;

}	/* fxn */




