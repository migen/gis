<?php


function listsmvsummary($db,$get,$dbg=PDBG){
$dbo=PDBO;
$cond="";
$condlimits="";

$data['sort'] = $sort = (isset($get['sort']))?$get['sort']:'pr.name';
$data['order'] = $order = (isset($get['order']))?$get['order']:'DESC';
$data['page'] = $page = (isset($get['page']))?$get['page']:1;
$data['limits'] = $limits = (isset($get['limits']))?$get['limits']:30;	
$data['offset'] = $offset = ($page-1)*$limits;
$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 

// if (!empty($get['reference'])){ $cond .= " AND po.reference LIKE '%".$get['reference']."%'"; }				

if (!empty($get['start'])){ $cond .= " AND smv.date >= '".$get['start']."'"; }				
if (!empty($get['end'])){ $cond .= " AND smv.date <= '".$get['end']."'"; }				
if (!empty($get['reference'])){ $cond .= " AND smv.reference LIKE '%".$get['reference']."%'"; }				
if (!empty($get['prid'])){ $cond .= " AND sd.prid = '".$get['prid']."'"; }				
if (!empty($get['status'])){ $cond .= " AND smv.status = '".$get['status']."'"; }				

// pr($_SESSION['terminal']);

if($_SESSION['user']['privilege_id']==0){
	if (!empty($get['src'])){ $cond .= " AND smv.src = '".$get['src']."'"; }				
	if (!empty($get['dest'])){ $cond .= " AND smv.dest = '".$get['dest']."'"; }				
} else {
	if (!empty($get['src'])){ $cond .= " AND smv.src = '".$_SESSION['terminal']."'"; }				
	elseif (!empty($get['dest'])){ $cond .= " AND smv.dest = '".$_SESSION['terminal']."'"; }
	else { $cond .= " AND (smv.src = '".$_SESSION['terminal']."' || smv.dest = '".$_SESSION['terminal']."') "; }
}


$q="
	SELECT 	
		pr.name AS product,sd.prid,SUM(sd.roqty) AS sum_roqty,SUM(sd.rxqty) AS sum_rxqty
	FROM {$dbo}.`30_smv` AS smv
		LEFT JOIN {$dbo}.`30_smvdetails` AS sd ON sd.smv_id=smv.id	
		LEFT JOIN {$dbo}.`03_products` AS pr ON sd.prid=pr.id	
	WHERE 1=1 $cond
	GROUP BY sd.prid		
	ORDER BY $sort $order $condlimits ;		
";

// pr($q);
// $_SESSION['q']=$q;
if(isset($_GET['debug'])){ $data['q']=$q; }
$sth=$db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

return $data;

}	/* fxn */



function listsmv($db,$get,$dbg=PDBG){
$dbo=PDBO;
$cond="";
$condlimits="";

$data['sort'] = $sort = (isset($get['sort']))?$get['sort']:'smv.date';
$data['order'] = $order = (isset($get['order']))?$get['order']:'DESC';
$data['page'] = $page = (isset($get['page']))?$get['page']:1;
$data['limits'] = $limits = (isset($get['limits']))?$get['limits']:30;	
$data['offset'] = $offset = ($page-1)*$limits;
$condlimits = ($limits>0)? "LIMIT $limits OFFSET $offset":NULL; 

// if (!empty($get['reference'])){ $cond .= " AND po.reference LIKE '%".$get['reference']."%'"; }				

if (!empty($get['start'])){ $cond .= " AND smv.date >= '".$get['start']."'"; }				
if (!empty($get['end'])){ $cond .= " AND smv.date <= '".$get['end']."'"; }				
if (!empty($get['reference'])){ $cond .= " AND smv.reference LIKE '%".$get['reference']."%'"; }				
if (!empty($get['prid'])){ $cond .= " AND sd.prid = '".$get['prid']."'"; }				
if (!empty($get['status'])){ $cond .= " AND smv.status = '".$get['status']."'"; }				

// pr($_SESSION['terminal']);

if($_SESSION['user']['privilege_id']==0){
	if (!empty($get['src'])){ $cond .= " AND smv.src = '".$get['src']."'"; }				
	if (!empty($get['dest'])){ $cond .= " AND smv.dest = '".$get['dest']."'"; }				
} else {
	if (!empty($get['src'])){ $cond .= " AND smv.src = '".$_SESSION['terminal']."'"; }				
	elseif (!empty($get['dest'])){ $cond .= " AND smv.dest = '".$_SESSION['terminal']."'"; }
	else { $cond .= " AND (smv.src = '".$_SESSION['terminal']."' || smv.dest = '".$_SESSION['terminal']."') "; }
}


$q="
	SELECT 	
		smv.id AS smvid,smv.*
	FROM {$dbo}.`30_smv` AS smv
		LEFT JOIN {$dbo}.`30_smvdetails` AS sd ON sd.smv_id=smv.id	
	WHERE 1=1 $cond
	GROUP BY smv.id		
	ORDER BY $sort $order $condlimits ;		
";
// pr($q);
// $_SESSION['q']=$q;
if(isset($_GET['debug'])){ $data['q']=$q; }
$sth=$db->querysoc($q);
$data['rows'] = $sth->fetchAll();
$data['count'] = count($data['rows']);

return $data;

}	/* fxn */




function getSmv($db,$smvid,$dbg=PDBG){
	$dbo=PDBO;
	$q = "SELECT smv.*,smv.id AS smvid
		FROM {$dbo}.`30_smv` AS `smv` WHERE smv.`id` = $smvid LIMIT 1; ";
	$sth = $db->querysoc($q);
	$data['smv'] = $sth->fetch();
	
	$q = "SELECT sd.*,pr.name AS product,pr.code,sd.id AS sdid 
		FROM {$dbo}.`30_smvdetails` AS sd 
			LEFT JOIN {$dbo}.`03_products` AS pr ON sd.prid = pr.id
		WHERE sd.smv_id = '$smvid' ORDER BY pr.name; ";
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();		
	$data['count'] = count($data['rows']);
	
	/* 2 */
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
	$q="UPDATE {$dbo}.`30_smv` SET `is_delivered`='$is_delivered',`qty_ordered`='$total_roqty',
		`qty_received`='$total_rxqty' WHERE `id`='$smvid' LIMIT 1; ";
	// pr($q);
	$db->query($q);
		
	$data['delivery_status']=$delivery_status;
	return $data;

}	/* fxn */



function saveSmv($db,$smvid,$smv,$sd,$count,$src,$dest,$dbg=PDBG){
	$dbo=PDBO;
	$q = "";
	$numrows = count($sd);
	for($i=0;$i<$numrows;$i++){
		$row = $sd[$i];
		if($i<$count){
			$q .= "UPDATE {$dbo}.`30_smvdetails` SET 
				`prid`='".$row['prid']."', 
				`roqty`='".$row['roqty']."', 
				`rxqty`='".$row['rxqty']."' 
				WHERE `id` = '".$row['sdid']."' LIMIT 1; ";	
			$q .= "UPDATE {$dbo}.`03_products` SET 
				`t{$src}` = (`t{$src}`-(".$row['rxqty']."-".$row['oldrxqty'].")), 
				`t{$dest}` = (`t{$dest}`+(".$row['rxqty']."-".$row['oldrxqty'].")) 
				WHERE `id` = '".$row['prid']."' LIMIT 1; ";				
		} else {
			if($row['prid']>0){
				$q .= "INSERT INTO {$dbo}.`30_smvdetails`(`smv_id`,`prid`,`roqty`,`rxqty`) VALUES  
						('$smvid','".$row['prid']."','".$row['roqty']."','".$row['rxqty']."');";	
				$q .= "UPDATE {$dbo}.`03_products` SET `t{$src}` = (`t{$src}`-".$row['rxqty']."),
					`t{$dest}` = (`t{$dest}`+".$row['rxqty'].") WHERE `id` = '".$row['prid']."' LIMIT 1; ";						
			}
		}

	}	/* sd */
	$_SESSION['q'] = $q;
	$db->query($q);
	
	/* 2 */
	$prids=buildArray($sd,'prid');
	$q="";
	$tmax=$_SESSION['settings']['numterminals'];
	$expr="level=(";
	for($i=1;$i<=6;$i++){ $expr.="t{$i}+"; }
	$expr=rtrim($expr,"+");
	$expr.=")";	
	foreach($prids AS $prid){ $q.="UPDATE {$dbo}.`03_products` SET $expr WHERE `id`='$prid' LIMIT 1;"; }	
	$db->query($q);

	$q = "UPDATE {$dbo}.`30_smv` SET 
		`comments` = '".$smv['comments']."',
		`reference` = '".$smv['reference']."'
		WHERE `id` = '$smvid' LIMIT 1; ";
	$db->query($q);
	
	
}	/* fxn */



function supplierProducts($db,$dbg,$suppid){
$dbo=PDBO;
$q = "SELECT id,name FROM {$dbo}.`03_products` WHERE suppid = '$suppid'; ";
$sth = $db->querysoc($q);
$a = $sth->fetchAll();
/* not primary suppliers */
$q = "
	SELECT p.id,p.name
	FROM {$dbo}.03_products_suppliers AS ps INNER JOIN {$dbo}.`03_products` AS p ON ps.product_id = p.id 
	WHERE ps.suppid = '$suppid';";
$sth = $db->querysoc($q);
$b = $sth->fetchAll();

$c = array_merge($a,$b);
return $c;

}	/* fxn */



function getsmvpridItemized($db,$prid,$dbg=PDBG){
$dbo=PDBO;
$get=$_GET;
$cond="";
if (!empty($get['start'])){ $cond .= " AND smv.date >= '".$get['start']."'"; }				
if (!empty($get['end'])){ $cond .= " AND smv.date <= '".$get['end']."'"; }				

$q="
	SELECT 
		pr.name AS product,sd.*,smv.date
	FROM {$dbo}.`30_smv` AS smv
		LEFT JOIN {$dbo}.`30_smvdetails` AS sd ON sd.smv_id=smv.id
		LEFT JOIN {$dbo}.`03_products` AS pr ON sd.prid=pr.id
	WHERE sd.prid='$prid' $cond	
";
$sth=$db->querysoc($q);
$data['rows']=$rows=$sth->fetchAll();
$data['count']=count($rows);
return $data;

}	/* fxn */


