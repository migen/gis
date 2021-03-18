<?php



function read($db,$id,$dbg=PDBG){
$dbo=PDBO;	
$q = " SELECT p.*,p.id AS prid FROM {$dbo}.`03_products` AS p WHERE p.id = '$id' LIMIT 1; ";
$sth = $db->querysoc($q);
$row = $sth->fetch();
return $row;

}	/* fxn */


function prodtype($db,$id,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT * FROM {$dbo}.`03_prodtypes` WHERE `id` = '$id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function prodsubtype($db,$id,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT * FROM {$dbo}.`03_prodsubtypes` WHERE `id` = '$id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function prodtypes($db,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT p.*,g.name AS prodtag FROM {$dbo}.`03_prodtypes` AS p
		LEFT JOIN {$dbo}.`03_prodtags` AS g ON p.prodtag_id = g.id ORDER BY g.id,p.`name` ; ";
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	return $data;
}	/* fxn */


function prodsubtypes($db,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT s.*,t.name AS prodtype 
		FROM {$dbo}.`03_prodsubtypes` AS s
		LEFT JOIN {$dbo}.`03_prodtypes` AS t ON s.prodtype_id = t.id ORDER BY t.id,s.`name` ; ";
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	return $data;
}	/* fxn */


/* prodcategories or umbrella food,drinks,misc */
function prodtags($db,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT * FROM {$dbo}.`03_prodtags` ORDER BY `id` ; ";
	$sth = $db->querysoc($q);
	$data['rows'] = $sth->fetchAll();
	$data['count'] = count($data['rows']);
	return $data;
}	/* fxn */

function prodtag($db,$id,$dbg=PDBG){
	$dbo=PDBO;	
	$q = " SELECT * FROM {$dbg}.`03_prodcategories` WHERE `id` = '$id' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();
}	/* fxn */


function suppliersByProduct($db,$id,$dbg=PDBG){
	$dbo=PDBO;	
	$q = "
		SELECT 
			ps.*,ps.id AS psid,c.id AS ucid,c.parent_id AS pcid,c.name AS supplier			
		FROM {$dbo}.`03_products` AS p 
			INNER JOIN {$dbo}.03_products_suppliers AS ps ON ps.product_id = p.id
			LEFT JOIN {$dbo}.`00_contacts` AS c ON ps.suppid = c.id
		WHERE p.id = '$id';	";	
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


function productsBySupplier($db,$suppid,$dbg=PDBG){
	$dbo=PDBO;	
	$q = "SELECT 
			ps.id AS psid,ps.suppid,ps.cost,
			p.id AS prid,p.name AS product
		FROM {$dbo}.03_products_suppliers AS ps
			LEFT JOIN {$dbo}.`03_products` AS p ON ps.product_id = p.id
		WHERE ps.suppid = '$suppid'; ";
	$sth = $db->querysoc($q);
	return $sth->fetchAll();

}	/* fxn */


