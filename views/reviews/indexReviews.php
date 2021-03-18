<h5>
	Reviews
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'hr'; ?>" >HR</a>
	| <a href="<?php echo URL.'reviews/add'; ?>" >Add</a>
	
	
</h5>

<?php 
pr($data);
?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Item</th>
	<th>Debug</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['dbu']; ?></td>
</tr>
<?php endfor; ?>
</table>
