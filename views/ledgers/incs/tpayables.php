
<table class="gis-table-bordered" >

<?php $totaldues=$assessed; ?>
<?php $nowdues=0; ?>
<tr>
	<th class="vc300" >Particulars</th>
	<th class="vc120" >Due Date</th>
	<th class="right" >Amount</th>
</tr>

<?php 
	
	$datedue = $tuition[$paymode_code.'_dpdue'];
	$amountdue = $tuition[$paymode_code.'_dpfee'];
	$pamt=pamt($amountdue,$discperiod);
	$trunning = $amountdue;
	$tpaid = $student['tpaid'];
	$tbalance=$trunning-$tpaid;	
	$isdue = isdue($datedue,$fdm,$ldm,$tbalance,$today);
	$nowdues = ($isdue)? $nowdues+=$tbalance:$nowdues;
	
?>

<tr class="<?php echo ($isdue)? '':NULL;  echo ($tbalance)? NULL:'trpayables';  ?>" >
	<td>Tuition - 1st Payment</td>
	<td><?php echo $datedue; ?></td>
	<td class="right" ><?php echo number_format($pamt,2); ?></td>
</tr>

<?php if($paymode_id!=1): ?>	<!-- if not paymode id of 1:yearly -->
<?php for($j=2;$j<$limitperiods;$j++): ?>	<!-- leftperiods -->
<?php 
	$k=$j-2; 
	$datedue = trim($rpaydates[$k]);
	$amountdue = $annuity;
	$pamt=pamt($amountdue,$discperiod);
	$trunning+=$pamt; 
	$tbalance=$trunning-$tpaid;
	
	$isdue = isdue($datedue,$fdm,$ldm,$tbalance,$today);
	$nowdues = ($isdue)? $tbalance:$nowdues;
	
	
?>

<tr class="<?php echo ($isdue)? '':NULL;  echo ($tbalance)? NULL:'trpayables';  ?>" >
	<td>Tuition - <?php echo getOrdinal($j).' Payment'; ?></td>
	<td><?php echo $datedue; ?></td>
	<td class="right" ><?php echo number_format($pamt,2); ?> </td>
</tr>	
<?php endfor; ?>	<!-- leftperiods -->
<?php endif; ?>	<!-- if not paymode id of 1:yearly -->
</div>	<!-- tuition payables -->

<div class="third" >	<!-- tuition payments -->


</table>
