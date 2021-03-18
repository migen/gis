

<?php 
// echo "font-assess: $font_assess";
?>


<br />
<div class="divborder" style="font-size:<?php echo $font_assess; ?>;" >
<table class="gis-table-bordered table-fx" style="width:4.6in;"  >
<tr class=""  >
	<th style="width:3.2in;" >Details</th>
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

<tr><td colspan="">Less: Discounts
<?php foreach($disr AS $row): ?>
<?php echo '<br /> &nbsp;&nbsp;&nbsp;'.$row['feetype']; ?>
<?php endforeach; ?>
</td><td class="right" ><?php // echo number_format($discounts,2); ?>
<?php foreach($disr AS $row): ?>
<?php echo '<br /> &nbsp;&nbsp;&nbsp;'.number_format($row['amount'],2); ?>
<?php endforeach; ?>

</td></tr>
<tr><th colspan="">Total Fees</th><th class="right" ><?php echo number_format($totalfees,2); ?></th></tr>
<tr><td colspan="">Less: Payments</td><td class="right" ><?php echo number_format($tpaid,2); ?></td></tr>
<?php $netfees=(round($totalfees,2)-round($tpaid,2));  ?>
<tr><th colspan="">Net</th><th class="right" ><?php echo number_format($netfees,2); ?></th></tr>

</table>


</div>