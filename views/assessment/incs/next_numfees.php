
<br />
<div class="divborder" >
<table class="no-gis-table-bordered table-fx" style="width:3.6in;"  >
<tr class=""  >
	<th style="width:2.2in;" >Details</th>
	<th class="right" >Amount</th>
</tr>
<?php for($i=0;$i<$numfees;$i++): ?>	
<tr>
	<td><?php echo $fees[$i]['fee']; ?></td>
	<td class="right" ><?php echo number_format($fees[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
<tr>
	<td colspan="" >Assessed</td>
	<td class="b right" ><?php echo number_format($tsum['total'],2); ?></td>
</tr>

<?php $totalfees = $tsum['total']-$discounts; ?>

<tr><td colspan="">Less: Discounts</td><td class="right" ><?php echo number_format($discounts,2); ?></td></tr>
<tr><th colspan="">Total Fees</th><th class="right" ><?php echo number_format($totalfees,2); ?></th></tr>
<tr><td colspan="">Less: Payments</td><td class="right" ><?php echo number_format($tpaid,2); ?></td></tr>
<?php $netfees=($totalfees-$tpaid); ?>
<tr><th colspan="">Net</th><th class="right" ><?php echo number_format($netfees,2); ?></th></tr>

</table>


</div>