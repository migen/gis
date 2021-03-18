<h5>
	Pivots
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'hr'; ?>" >HR</a>
	
	
</h5>

<?php 
pr($data);
?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Product</th>
	<th>Price</th>
	<th>Color</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['price']; ?></td>
	<td><?php echo $rows[$i]['color']; ?></td>
</tr>
<?php endfor; ?>
</table>
