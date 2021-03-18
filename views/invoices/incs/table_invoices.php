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
	<th>Edit</th>
	<th>ID</th>
	<th>Date</th>
	<th>Payor<br />Type</th>
	<th>Customer</th>
	<th>Employee</th>
	<th>Fee</th>
	<th>Amount</th>
	<th class="right" >Paid</th>
	<th>Balance</th>
	<th>Details</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><a href='<?php echo URL."invoices/edit/".$rows[$i]["invid"]; ?>' >Edit</a></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['porcode']; ?></td>
	<td><?php echo $rows[$i]['customer']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td class="right" ><?php echo $rows[$i]['amount']; ?></td>
	<td class="right" ><?php echo $rows[$i]['paid']; ?></td>
	<td class="right" ><?php echo $rows[$i]['balance']; ?></td>
	<td><?php echo $rows[$i]['details']; ?></td>
</tr>
<?php endfor; ?>
</table>