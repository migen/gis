<h5>
	SWOT <?php echo $classroom['name']; ?>
	
</h5>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Student</th>
	<th>Course</th>
	<th>Grade</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['subject']; ?></td>
	<td><?php echo $rows[$i]['grade']; ?></td>
</tr>
<?php endfor; ?>
</table>
