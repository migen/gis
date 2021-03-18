<h3>
	Previous Balance Level (PBL) | <?php $this->shovel('homelinks'); ?>
	
	
</h3>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
</tr>
<?php endfor; ?>
</table>
