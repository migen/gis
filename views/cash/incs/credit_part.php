<h5>Credit Cards

</h5>

<table class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th>Student</th>
	<th>Amount</th>
	<th>Or No</th>
	<th>Details</th>
</tr>
<?php foreach($credit_sales AS $row): ?>
<tr>
	<td><?php echo $row['student']; ?></td>
	<td class="right" ><?php echo number_format($row['amount'],2); ?></td>
	<td><?php echo $row['orno']; ?></td>
	<td><?php echo $row['details']; ?></td>
</tr>
<?php endforeach; ?>
</table>