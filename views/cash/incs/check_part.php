<h5>Checks

</h5>

<table class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th class="vc200" >Student</th>
	<th>Amount</th>
	<th>Or No</th>
	<th class="vc120" >Bank</th>
	<th>Reference</th>
</tr>
<?php foreach($check_sales AS $row): ?>
<tr>
	<td><?php echo (isset($row['student']))? $row['student']:$row['payer']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td><?php echo $row['orno']; ?></td>
	<td><?php echo $row['bank']; ?></td>
	<td><?php echo $row['reference']; ?></td>
</tr>
<?php endforeach; ?>
<tr><th colspan="" >Total</th>
<th class="right" ><?php echo number_format($check,2); ?></th>
<th colspan="3" ></th></tr>
</table>