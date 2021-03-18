<?php


function getSupplierDetails($db,$suppid){
$dbo=PDBO;
$q="SELECT * FROM {$dbo}.`00_contacts` WHERE id='$suppid' LIMIT 1; ";
$sth=$db->querysoc($q);
return $sth->fetch();

}	/* fxn */