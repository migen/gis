<h5>
	Pay Groups
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'hr'; ?>" >HR</a>
	| <a href="<?php echo URL.'paygroups/add'; ?>" >Add</a>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
	<th>Pos</th>
	<th>Edit</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['pgid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td><a href="<?php echo URL.'paygroups/edit/'.$rows[$i]['pgid']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
