<h5>
	Student Promotions
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<p>
	<table class="gis-table-bordered table-altrow" >
		<tr><th><?php echo $student['name']; ?></th></tr>
	</table>
</p>

<table class="gis-table-bordered table-altrow" >
<tr><th>SY</th><th>Level</th><th>Section</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $rows[$i]['sy']; ?></td>
		<td><?php echo $rows[$i]['level']; ?></td>
		<td><?php echo $rows[$i]['section']; ?></td>
	</tr>
<?php endfor; ?>
</table>
