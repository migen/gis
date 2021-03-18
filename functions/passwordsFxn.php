<?php

function getPasswordsByRole($db,$dbo,$role=RTEAC){
$dbo=PDBO;
$q="SELECT c.id,c.account,c.name,ctp.ctp FROM {$dbo}.`00_contacts` AS c 
LEFT JOIN {$dbo}.`00_ctp` AS ctp ON c.id=ctp.contact_id WHERE c.role_id='$role' ORDER BY c.name;  ";
debug($q);
$sth=$db->querysoc($q);
return $sth->fetchAll();

}	/* fxn */

