<?php




function syncPayroll($db,$payperiod_id){
	$dbg=PDBG;$dbo=PDBO;
	
	/* 1 employees */		
	$q="SELECT c.id AS ecid,c.name AS employee FROM {$dbo}.`00_contacts` AS c
		WHERE c.role_id>1 AND c.id=c.parent_id ORDER BY ecid DESC; ";			
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'ecid');	
	
	/* 2 payroll - employees within payperiod */		
	$q = " SELECT ecid,payperiod_id FROM {$dbg}.60_payrolls WHERE payperiod_id='$payperiod_id'; ";		
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'ecid');

	/* 3 */
	$ix = array_diff($ar,$br);		
	$q = " INSERT INTO {$dbg}.60_payrolls(`ecid`,`payperiod_id`) VALUES  ";
	foreach($ix AS $ecid){ $q .= " ('$ecid','$payperiod_id'),"; }
	$q = rtrim($q,",");$q .= "; ";		
	$db->query($q);	
	
	
}	/* fxn */



function syncPaymaster($db){
	$dbg=PDBG;$dbo=PDBO;

	/* 1 employees */		
	$q="SELECT c.`id` AS ecid,c.`name` AS `employee` FROM {$dbo}.`00_contacts` AS c
		WHERE c.`role_id`>1 AND c.`id`=c.`parent_id` ORDER BY `ecid`; ";			
	$sth = $db->querysoc($q);
	$a = $sth->fetchAll();
	$ar = buildArray($a,'ecid');	
	
	/* 2 payroll - employees within payperiod */		
	$q = " SELECT `ecid` FROM {$dbg}.06_paymaster; ";		
	$sth = $db->querysoc($q);
	$b = $sth->fetchAll();
	$br = buildArray($b,'ecid');

	/* 3 */
	$ix = array_diff($ar,$br);		
	$q = " INSERT INTO {$dbg}.06_paymaster(`ecid`) VALUES  ";
	foreach($ix AS $ecid){ $q .= " ('$ecid'),"; }
	$q = rtrim($q,",");$q .= "; ";		
		
	$db->query($q);	
	
	
}	/* fxn */


