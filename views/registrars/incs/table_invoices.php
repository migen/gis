<script>
	$(function(){
		excel();
	})

</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<table id="tblExport" class="gis-table-bordered" >

<tr class="headrow" >
	<th>ID</th>
	<th>Date</th>
	<th>Customer</th>
	<th>Employee</th>
	<th>Fee</th>
	<th>Tender</th>
	<th>Amount</th>
	<th class="right" >Paid</th>
	<th>Balance</th>
	<th>Or Num</th>
	<th>Details</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><a href='<?php echo URL."invoices/edit/".$rows[$i]["invid"]; ?>' >
		<?php echo $rows[$i]['invid']; ?></a></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td><?php echo $rows[$i]['paytype']; ?></td>
	<td class="right" ><?php echo $rows[$i]['amount']; ?></td>
	<td class="right" ><?php echo $rows[$i]['paid']; ?></td>
	<td class="right" ><?php echo $rows[$i]['balance']; ?></td>
	<td class="right" ><a href='<?php echo URL."invoices/printorno/".$rows[$i]['orno']; ?>'>
		<?php echo $rows[$i]['orno']; ?></a></td>
	<td><?php echo $rows[$i]['details']; ?></td>
</tr>
<?php endfor; ?>
</table>