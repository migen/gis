<?php


$year = $_SESSION['year'];
$moid = $_SESSION['moid'];
$fdm = $year.'-'.$moid.'-01';
$ldm  = isset($_GET['due'])? $_GET['due']: date('Y-m-t');
$surcharge = (isset($surcharge))? $surcharge:0;


/* bbb */
$today = $_SESSION['today'];
$assessed = $tsum['total'];
$resfee = $tsum['resfee'];
$resdue = $tsum['resdue'];
$paymode_code = $tsum['paymode_code'];

$dpfee = $tsum[$paymode_code.'_dpfee'];
$dpdue = $tsum[$paymode_code.'_dpdue'];
$numperiods = $tsum['numperiods'];
$intrate = $_SESSION['settings']['intrate'];	
