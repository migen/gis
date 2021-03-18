<h5>
	Stocks Count Stats
	
</h5>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Supplier</th>
	<th>Numrows</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['supplier']; ?></td>
	<td><?php echo $rows[$i]['numrows']; ?></td>
</tr>
<?php endfor; ?>
</table>
