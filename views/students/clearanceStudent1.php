<?php 

// $_SESSION['accounts']=array();

/* 1 - let */
$qtr=$_SESSION['qtr'];



/* 2 */
$period_factor=1;
if($paymode_id==2){
	if($qtr>1){ $period_factor=2; }	
} else if($paymode_id==4){
	$period_factor=$qtr;
} else if($paymode_id==3){
	$period_factor=$qtr*2;	
}	

$accounts['period_factor']=&$period_factor;


/* 3 */

$incs=SITE."views/customs/sjam/assessmentIncs_sjam.php";
require_once($incs);




$accounts['qtr']=&$qtr;
$accounts['paymode_id']=&$student['paymode_id'];
$accounts['student']=&$student;
$accounts['annuity']=$annuity=$arp['adjusted_periodic'];
$accounts['paid_tuition']=getTotalPaymentByFeetype($payments,1);
$accounts['paid_deposit']=getTotalPaymentByFeetype($payments,2);
$total_payment=$accounts['paid_tuition']+$accounts['paid_deposit'];
$accounts['total_paid_tuition']=&$total_payment;

$required_payable=$annuity*$period_factor;
$accounts['required_payable']=&$required_payable;
$accounts['allowance']=$allowance=$_SESSION['settings']['allowance_rcard_viewing'];

$accounts['can_view_rcard']=canViewRcard($total_payment,$required_payable,$allowance);



prx($accounts);
// prx($data);




// if($srid==RSTUD){ $_SESSION['accounts']=$data; }

// echo "<hr />";
// pr($_SESSION['accounts']);




?>

<table class="gis-table-bordered" >
<tr>
	<th>Scid</th>
	<td><?php echo $scid; ?></td>
</tr>



</table>
