<h3>
	Student Classrooms Transcript
	| <?php $this->shovel('homelinks'); ?>
	
</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Code</th>
	<th>Name</th>
	<th>SY</th>
	<th>Classroom</th>

</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
</tr>
<?php endfor; ?>
</table>
