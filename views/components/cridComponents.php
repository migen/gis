<h3>
	Classroom Components (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>

</h3>

<?php 
pr($cr);
?>



<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>Subtype</th>
	<th>Subject</th>
	<th>Sem</th>
	<th>Course</th>
	<th>Criteria</th>
	<th>Weight</th>
	<th>Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['subjtype_id']; ?></td>
	<td><?php echo $rows[$i]['subject'].' #'.$rows[$i]['subject_id']; ?></td>
	<td><?php echo $rows[$i]['semester']; ?></td>
	<td><?php echo $rows[$i]['course'].' #'.$rows[$i]['course_id']; ?></td>
	<td><?php echo $rows[$i]['criteria'].' #'.$rows[$i]['criteria_id']; ?></td>
	<td><?php echo $rows[$i]['weight']; ?></td>
	<td><a href="#" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>