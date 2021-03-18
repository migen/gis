<?php

function poDelivery($db,$poid,$cond,$dbg=PDBG){
$dbo=PDBO;
$q="SELECT px.po_id,px.id AS pxid,px.rxdate,pr.name AS product,px.rxqty,pd.cost
	FROM {$dbo}.`30_po_rx` AS px
		LEFT JOIN {$dbo}.`03_products` AS pr ON px.product_id=pr.id
		LEFT JOIN {$dbo}.`30_podetails` AS pd ON (px.po_id=pd.po_id && px.product_id=pd.product_id)
	WHERE px.po_id='$poid' $cond ORDER BY px.rxdate,pr.name; ";
debug($q,'deliveryFxn: poDelivery');
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */


