<h5>
	Payday Types
	| <?php $this->shovel('homelinks','HR'); ?>
	| <a href="<?php echo URL.'paydaytypes/add'; ?>" >Add</a>	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Name</th>
	<th>Factor</th>
	<th>Factor OT</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['factor']; ?></td>
	<td><?php echo $rows[$i]['factor_ot']; ?></td>
	<td><a href="<?php echo URL.'paydaytypes/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>




