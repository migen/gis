<?php

function report($db,$params,$dbg=PDBG){
	$dbo=PDBO;
	$suppid=$params['suppid'];
	$start=$params['start'];
	$end=$params['end'];
	$suppid=2359;
	$today='2018-01-19';
	
	$q="SELECT pr.id AS prid,SUM(b.rxqty) AS received,SUM(c.qty) AS shrinkage
		FROM {$dbo}.`03_products` AS pr 
			LEFT JOIN {$dbo}.`30_po_rx` AS b ON b.product_id=pr.id		
			LEFT JOIN {$dbg}.`30_shrinkages` AS c ON c.prid=pr.id		
		WHERE pr.suppid='$suppid' AND 
			b.rxdate='$today' AND c.date='$today'
		GROUP BY pr.id; ";	
	$q="SELECT id AS prid,name,price,level FROM {$dbo}.`03_products` WHERE `suppid`=$suppid; ";
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=count($rows);

	for($i=0;$i<$count;$i++){
		$q="SELECT SUM(rxqty) AS received FROM {$dbo}.`30_po_rx` 
			WHERE `product_id`='".$rows[$i]['prid']."' AND `rxdate`='$today';";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$rows[$i]['received']=$row['received'];
	}

	for($i=0;$i<$count;$i++){
		$q="SELECT SUM(qty) AS shrinkages FROM {$dbg}.`30_shrinkages`
			WHERE `prid`='".$rows[$i]['prid']."' AND `date`='$today';";
		$sth=$db->querysoc($q);
		$row=$sth->fetch();
		$rows[$i]['shrinkages']=$row['shrinkages'];
	}
	
	
	pr($rows);
	


}	/* fxn */

