<h5>
	Settings | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'settings/add'; ?>" >Add</a>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Label</th>
	<th>Name</th>
	<th>Value</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['label']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['value']; ?></td>
	<td><a href="<?php echo URL.'settings/edit/'.$id; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
