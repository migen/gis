<?php 

$get=sages($_GET);


?>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Prid</th>
	<th>Product</th>
	<th>Order Qty</th>
	<th>Recvd Qty</th>	
	<th>ID</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>	
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['sum_roqty']; ?></td>
	<td><?php echo $rows[$i]['sum_rxqty']; ?></td>

	<td>
		<a href="<?php echo URL.'logistics/smvpridItemized/'.$rows[$i]['prid'].$get; ?>" >Itemized</a>
	</td>
</tr>
<?php endfor; ?>
</table>
