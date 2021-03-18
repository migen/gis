<?php


function fetchCustomer($db,$field,$value){
	$dbo=PDBO;
	$q    = " SELECT c.`id`,c.`code`,c.`account`,c.`name`,b.balance 			
		FROM {$dbo}.`00_contacts` AS c
			LEFT JOIN {$dbo}.`balances` AS b ON b.contact_id = c.id		
		WHERE c.`$field` = '$value' LIMIT 1; ";
	$sth = $db->querysoc($q);
	return $sth->fetch();

}	/* fxn */
