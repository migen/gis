<h5>
	Club Components
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubcomponents/add?numrows=1'; ?>" >Add</a>
	
</h5>

<table class="gis-table-bordered" >

<tr>
	<th>#</th>
	<th>Club</th>
	<th>Criteria</th>
	<th>Weight</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['club']; ?></td>
	<td><?php echo $rows[$i]['criteria']; ?></td>
	<td><?php echo $rows[$i]['weight']; ?></td>
</tr>
<?php endfor; ?>
</table>


