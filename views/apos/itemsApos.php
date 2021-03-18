<h3>
	Items | <?php $this->shovel('homelinks'); ?>
	<?php include_once('apos_links.php'); ?>

	
</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>POS</th>
	<th>Type</th>
	<th>Prid</th>
	<th>Product</th>
	<th>Qty</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['pos_id']; ?></td>
	<td><?php echo $rows[$i]['type_id']; ?></td>
	<td><?php echo $rows[$i]['product_id']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['qty']; ?></td>
</tr>
<?php endfor; ?>
</table>
