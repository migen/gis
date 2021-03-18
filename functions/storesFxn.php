<?php

function getAllProdtypes($db,$dbg){
	$dbo=PDBO;
	$q="SELECT * FROM {$dbg}.00_prodtypes ORDER BY name; ";
	$sth=$db->querysoc($q);
	$data['rows']=$sth->fetchAll();
	$data['count']=$sth->rowCount();
	return $data;
	
}	/* fxn */

function sale($db,$dbo,$post){
	$dbo=PDBO;
	$pos=$post['pos'];
	$positems=$post['positems'];
	$pos['date']=$_SESSION['date'];
	$pos['time']=date('H:i:s');
	$pos['employee_id']=$_SESSION['ucid'];	
	$pos['total']=str_replace(",","",$pos['total']);	
	$db->add("{$dbo}.00_pos",$pos);
	$pos_id = $db->lastInsertId();	
	$q="INSERT INTO {$dbo}.00_positems(`pos_id`,`product_id`,`price`,`qty`,`subtotal`)VALUES";
	foreach($positems AS $row){ 
		$row['price']=str_replace(",","",$row['price']);
		$row['subtotal']=str_replace(",","",$row['subtotal']);
		$q.="($pos_id,".$row['product_id'].",".$row['price'].",".$row['qty'].",".$row['subtotal']."),";		
	}
	$q=rtrim($q,",");$q.=";";
	$db->query($q);
	return $pos_id;
	
}	/* fxn */
