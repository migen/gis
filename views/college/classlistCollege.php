<h5>
	College Classlist (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
</h5>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>SCID</th>
	<th>Number</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>

