<h5>
	View Apos | <?php $this->shovel('homelinks'); ?>
	<?php include_once('apos_links.php'); ?>

</h5>

<table class="gis-table-bordered" >
	<tr><th>ID</th><td><?php echo $pos['id']; ?></td></tr>
	<tr><th>Type</th><td><?php echo $pos['type']; ?></td></tr>
	<tr><th>Date</th><td><?php echo $pos['date']; ?></td></tr>
	<tr><th>Total</th><td><?php echo $pos['total']; ?></td></tr>
</table>

<br />

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>PrID</th>
	<th>Product</th>
	<th>Cost</th>
	<th>Qty</th>
	<th>Price</th>
	<th>Amount</th>
</tr>
<?php $i=0; ?>
<?php foreach($positems AS $row): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['id']; ?></td>
	<td><?php echo $row['product_id']; ?></td>
	<td><?php echo $row['product']; ?></td>
	<td><?php echo $row['cost']; ?></td>
	<td><?php echo $row['qty']; ?></td>
	<td><?php echo $row['price']; ?></td>
	<td><?php echo $row['amount']; ?></td>
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>
