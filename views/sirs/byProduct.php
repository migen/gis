<h5>
	<?php $this->shovel('breadlinks'); ?> 
	<a href="<?php echo URL.'sales/add'; ?>">Add</a>
	
</h5>


<?php 

// pr($data);


?>


<h5>Total Product Sales
	<p>From: <?php echo date('M d, Y', strtotime($data['from'])); ?>
		&nbsp; To: <?php echo date('M d, Y', strtotime($data['to'])); ?>
	</p>
</h5>


<table>

<tr>
	<th>Code</th>
	<td><?php echo $data['product']['code']; ?></td>
</tr>

<tr>
	<th>Product</th>
	<td><?php echo $data['product']['name']; ?></td>
</tr>

</table>

<hr />

<table class='gis-table-bordered table-fx'>

<tr class='headrow'>
	<td class='vc100' >Date</td>
	<td class='vc150'>Customer</td>
	<td>Qty</td>
	<td>Price</td>
	<td class='vc100' >Amount</td>
</tr>


<?php 
	$numrows = count($data['sales']);
	$total 	 = 0;
	for($i=0;$i<$numrows;$i++): 
	$row = $data['sales'][$i];
	$total += $row['amount'];
?>

<tr>
	<td><?php echo date('M d, Y', strtotime($row['datetime'])); ?></td>
	<td><?php echo $row['customer']; ?></td>
	<td class='right' ><?php echo $row['qty']; ?></td>
	<td class='right' ><?php echo number_format($row['price'],2); ?></td>
	<td class='right' ><?php echo number_format($row['amount'],2); ?></td>
</tr>

<?php endfor; ?>

<tr>
	<td colspan=4><b>Total</b></td>
	<td class='right' ><b><?php echo number_format($total,2); ?></b></td>
</tr>


</table>


<!-- pagination -->
<?php echo $data['pages']; ?>
