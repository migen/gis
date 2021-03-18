<h3>
	Works | <?php $this->shovel('homelinks'); ?>


</h3>

<h5>Work</h5>
<table class="gis-table-bordered" > 
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Work</th>
	<th>Status</th>
	<th>Type</th>
</tr>
<?php for($i=0;$i<$work_count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $work_rows[$i]['id']; ?></td>
	<td><?php echo $work_rows[$i]['work']; ?></td>
	<td><?php echo $work_rows[$i]['status']; ?></td>
	<td><?php echo $work_rows[$i]['type']; ?></td>
</tr>
<?php endfor; ?>
</table>



<h5>Students</h5>
<table class="gis-table-bordered" > 
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Work</th>
	<th>Status</th>
	<th>Type</th>
</tr>
<?php for($i=0;$i<$student_count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $student_rows[$i]['id']; ?></td>
	<td><?php echo $student_rows[$i]['work']; ?></td>
	<td><?php echo $student_rows[$i]['status']; ?></td>
	<td><?php echo $student_rows[$i]['type']; ?></td>
</tr>
<?php endfor; ?>
</table>
