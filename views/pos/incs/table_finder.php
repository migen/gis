<p>

<h4><?php echo "Product: ".$product['name']; ?></h4>

<table class="gis-table-bordered" >
<tr>
<th>PosID</th>
<th>Date Time</th>
<th>Cashier</th>
<th>Qty</th>
<th>Price</th>
<th>Amount</th>
<th>Rx</th>
<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['posid']; ?></td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['cashier']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
	<td><?php echo $rows[$i]['rxqty']; ?></td>
	<td><a href="<?php echo URL.'npos/view/'.$rows[$i]['posid'].DS.$sy; ?>" >View</a></td>	
</tr>
<?php endfor; ?>
</table>
</p>
