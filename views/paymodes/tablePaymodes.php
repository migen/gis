<h5>
	Pay Modes
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'hr'; ?>" >HR</a>
	| <a href="<?php echo URL.'paymodes/add'; ?>" >Add</a>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['pmid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
