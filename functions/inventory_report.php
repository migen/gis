<?php

function report($db,$params,$dbg=PDBG){
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