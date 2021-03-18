<h3>
	Statuses | <?php $this->shovel('homelinks'); ?>


</h3>

<table class="gis-table-bordered" > 
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
	<th>Type</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['type']; ?></td>
</tr>
<?php endfor; ?>
</table>
