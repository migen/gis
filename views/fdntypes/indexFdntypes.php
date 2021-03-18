<h5>
	Foundation Types
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'foundation'; ?>" >Foundation</a>
	| <a href="<?php echo URL.'fdntypes/add'; ?>" >Add</a>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
	<th>Edit</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'fdntypes/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
